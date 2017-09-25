<?php

namespace Drupal\rest_version_ui\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Url;
use Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface;
use Drupal\rest_version\Manager\Version\VersionPluginManager;
use Drupal\rest_version\Plugin\rest\version\VersionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RestVersionUIController
 *
 * Contains all the route callbacks for the more generic pages.
 *
 * @TODO This uses the straight symfony urlGeneratorInterface?
 * This matches the contrib restui, but seems odd?
 */
class RestVersionUIController extends ControllerBase {

  /**
   * @var \Drupal\rest_version\Manager\Version\VersionPluginManager
   *   The plugin manager for all the versions.
   */
  protected $restVersionPluginManager;

  /**
   * The URL generator to use.
   *
   * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * @var \Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface
   *   The resource manager factory.
   */
  protected $resourcePluginManagerFactory;

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface
   *   Storage handler for the resource config.
   */
  protected $resourceConfigStorage;

  /**
   * Injects RestUIManager Service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.rest_version.version'),
      $container->get('url_generator'),
      $container->get('factory.plugin.manager.rest_version.resource'),
      $container->get('entity_type.manager')->getStorage('rest_resource_config')
    );
  }

  /**
   * Constructs a RestUIController object.
   *
   * @param \Drupal\rest_version\Manager\Version\VersionPluginManager $restVersionPluginManager
   *   The REST resource plugin manager.
   * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
   *   The url generator to use.
   * @param \Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface $resourcePluginManagerFactory
   *   The resource pluginmanager factory.
   * @param \Drupal\Core\Entity\EntityStorageInterface $resourceConfigStorage
   *   Storage handler for all the different resources.
   */
  public function __construct(VersionPluginManager $restVersionPluginManager, UrlGeneratorInterface $urlGenerator, ResourcePluginManagerFactoryInterface $resourcePluginManagerFactory, EntityStorageInterface $resourceConfigStorage) {
    $this->restVersionPluginManager = $restVersionPluginManager;
    $this->urlGenerator = $urlGenerator;
    $this->resourcePluginManagerFactory = $resourcePluginManagerFactory;
    $this->resourceConfigStorage = $resourceConfigStorage;
  }

  /**
   * List page with all the different versions.
   */
  public function listVersions() {

    $build = [];

    // @TODO Move this to a proper listbuilding class.
    $build['version_list'] = [
      '#type' => 'table',
      '#header' => [t('Label'), t('Id'), t('Operations')]
    ];

    foreach ($this->restVersionPluginManager->getDefinitions() as $plugin_id => $definition) {
      $build['version_list']['#rows'][]['data'] = [
        $definition['label'],
        $definition['id'],
        'operations' => [
          'data' => [
            '#type' => 'operations',
            '#links' => [
              'enable' => [
                'title' => $this->t('View'),
                'url' => Url::fromRoute('rest_version_ui.version.canonical', ['version_id' => $plugin_id]),
              ],
            ],
          ]
        ]
      ];
    }

    return $build;
  }

  /**
   * @param string $version_id
   *
   * @return array
   */
  public function viewVersion($version_id) {

    $build = [];

    $build['endpoint_list'] = [
        '#type' => 'table',
        '#header' => [t('id'), t('label')]
    ];

    /** @var VersionInterface $majorVersion */
    $majorVersion = $this->restVersionPluginManager->createInstance($version_id);

    // Following code is largely a copy of the contrib rest UI module to get things started.

    // Get the list of enabled and disabled resources.
    // @TODO Ugly since it loads all the resource config, not just those we'll need.
    // Maybe handle this in a more extensive manager class?
    $config = $this->resourceConfigStorage->loadMultiple();

    // Strip out the nested method configuration, we are only interested in the
    // plugin IDs of the resources.
    $enabled_resources = array_combine(array_keys($config), array_keys($config));
    $available_resources = ['enabled' => [], 'disabled' => []];
    $resources = $this->resourcePluginManagerFactory->generateVersionResourcePluginManager($version_id)->getDefinitions();
    foreach ($resources as $id => $resource) {
      $key = $this->getResourceKey($id);
      $status = (in_array($key, $enabled_resources) && $config[$key]->status()) ? 'enabled' : 'disabled';
      $available_resources[$status][$id] = $resource;
    }


    // Sort the list of resources by label.
    $sort_resources = function ($resource_a, $resource_b) {
      return strcmp($resource_a['label'], $resource_b['label']);
    };
    if (!empty($available_resources['enabled'])) {
      uasort($available_resources['enabled'], $sort_resources);
    }
    if (!empty($available_resources['disabled'])) {
      uasort($available_resources['disabled'], $sort_resources);
    }

    // Heading.
    $list['resources_title'] = [
      '#markup' => '<h2>' . $this->t('REST resources') . '</h2>',
    ];
    $list['resources_help'] = [
      '#markup' => '<p>' . $this->t('Here you can enable and disable available resources. Once a resource has been enabled, you can restrict its formats and authentication by clicking on its "Edit" link.') . '</p>',
    ];
    $list['enabled']['heading']['#markup'] = '<h2>' . $this->t('Enabled') . '</h2>';
    $list['disabled']['heading']['#markup'] = '<h2>' . $this->t('Disabled') . '</h2>';

    // List of resources.
    foreach (['enabled', 'disabled'] as $status) {
      $list[$status]['#type'] = 'container';
      $list[$status]['#attributes'] = ['class' => ['rest-ui-list-section', $status]];
      $list[$status]['table'] = [
        '#theme' => 'table',
        '#header' => [
          'resource_name' => [
            'data' => $this->t('Resource name'),
            'class' => ['rest-ui-name']
          ],
          'path' => [
            'data' => $this->t('Path'),
            'class' => ['views-ui-path'],
          ],
          'description' => [
            'data' => $this->t('Description'),
            'class' => ['rest-ui-description'],
          ],
          'operations' => [
            'data' => $this->t('Operations'),
            'class' => ['rest-ui-operations'],
          ],
        ],
        '#rows' => [],
      ];
      foreach ($available_resources[$status] as $id => $resource) {
        $canonical_uri_path = !empty($resource['uri_paths']['canonical'])
          ? $majorVersion->prefixPath($resource['uri_paths']['canonical'])
          : FALSE;

        // @see https://www.drupal.org/node/2737401
        // @todo Remove this in Drupal 9.0.0.
        $old_create_uri_path = !empty($resource['uri_paths']['https://www.drupal.org/link-relations/create'])
          ? $resource['uri_paths']['https://www.drupal.org/link-relations/create']
          : FALSE;
        $new_create_uri_path = !empty($resource['uri_paths']['create'])
          ? $resource['uri_paths']['create']
          : FALSE;
        $create_uri_path = $new_create_uri_path ?: $old_create_uri_path;

        $available_methods = array_intersect(array_map('strtoupper', get_class_methods($resource['class'])), [
          'HEAD',
          'GET',
          'POST',
          'PUT',
          'DELETE',
          'TRACE',
          'OPTIONS',
          'CONNECT',
          'PATCH',
        ]);

        // @todo Remove this when https://www.drupal.org/node/2300677 is fixed.
        $is_config_entity = isset($resource['serialization_class']) && is_subclass_of($resource['serialization_class'], \Drupal\Core\Config\Entity\ConfigEntityInterface::class, TRUE);
        if ($is_config_entity) {
          $available_methods = array_diff($available_methods, ['POST', 'PATCH', 'DELETE']);
          $create_uri_path = FALSE;
        }

        // Now calculate the configured methods: if a RestResourceConfig entity
        // exists for this @RestResource plugin, then regardless of whether that
        // configuration is enabled or not, inspect its enabled methods. Strike
        // through all disabled methods, so that it's clearly conveyed in the UI
        // which methods are supported on which URL, but may be disabled.
        if (isset($config[$this->getResourceKey($id)])) {
          $enabled_methods = $config[$this->getResourceKey($id)]->getMethods();
          $disabled_methods = array_diff($available_methods, $enabled_methods);
          $configured_methods = array_merge(
            array_intersect($available_methods, $enabled_methods),
            array_map(function ($method) { return "<del>$method</del>"; }, $disabled_methods)
          );
        }
        else {
          $configured_methods = $available_methods;
        }

        // All necessary information is collected, now generate some HTML.
        $canonical_methods = implode(', ', array_diff($configured_methods, ['POST']));
        if ($canonical_uri_path && $create_uri_path) {
          $uri_paths = "<code>$canonical_uri_path</code>: $canonical_methods";
          $uri_paths.= "</br><code>$create_uri_path</code>: POST";
        }
        else {
          if ($canonical_uri_path) {
            $uri_paths = "<code>$canonical_uri_path</code>: $canonical_methods";
          }
          else {
            $uri_paths = "<code>$create_uri_path</code>: POST";
          }
        }

        $list[$status]['table']['#rows'][$id] = [
          'data' => [
            'name' => !$is_config_entity ? $resource['label'] : $this->t('@label <sup>(read-only)</sup>', ['@label' => $resource['label']]),
            'path' => [
              'data' => [
                '#type' => 'inline_template',
                '#template' => $uri_paths,
              ],
            ],
            'description' => [],
            'operations' => [],
          ],
        ];

        if ($status == 'disabled') {
          $list[$status]['table']['#rows'][$id]['data']['operations']['data'] = [
            '#type' => 'operations',
            '#links' => [
              'enable' => [
                'title' => $this->t('Enable'),
                'url' => Url::fromRoute('restui.edit', ['resource_id' => $id]),
              ],
            ],
          ];
        }
        else {
          $list[$status]['table']['#rows'][$id]['data']['operations']['data'] = [
            '#type' => 'operations',
            '#links' => [
              'edit' => [
                'title' => $this->t('Edit'),
                'url' => Url::fromRoute('restui.edit', ['resource_id' => $id]),

              ],
              'disable' => [
                'title' => $this->t('Disable'),
                'url' => Url::fromRoute('restui.disable', ['resource_id' => $id]),
              ],
              'permissions' => [
                'title' => $this->t('Permissions'),
                'url' => Url::fromRoute('user.admin_permissions', [], ['fragment' => 'module-rest']),
              ],
            ],
          ];

          $list[$status]['table']['#rows'][$id]['data']['description']['data'] = [
            '#theme' => 'restui_resource_info',
            '#granularity' => $config[$this->getResourceKey($id)]->get('granularity'),
            '#configuration' => $config[$this->getResourceKey($id)]->get('configuration'),
          ];
        }
      }
    }

    $list['enabled']['table']['#empty'] = t('There are no enabled resources.');
    $list['disabled']['table']['#empty'] = t('There are no disabled resources.');
    $list['#title'] = t('REST resources for ' . $version_id);

    return $list;
  }

  /**
   * The key used in the form.
   *
   * @param string $resource_id
   *   The resource ID.
   *
   * @return string
   *   The resource key in the form.
   */
  protected function getResourceKey($resource_id) {
    return str_replace(':', '.', $resource_id);
  }

}