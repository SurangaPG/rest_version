<?php

namespace Drupal\rest_version_ui\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\rest_version\Plugin\RestVersionPluginManager;
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
   * @var \Drupal\rest_version\Plugin\RestVersionPluginManager
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
   * Injects RestUIManager Service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.rest_version.version'),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a RestUIController object.
   *
   * @param \Drupal\rest_version\Plugin\RestVersionPluginManager $restVersionPluginManager
   *   The REST resource plugin manager.
   * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
   *   The url generator to use.
   */
  public function __construct(RestVersionPluginManager $restVersionPluginManager, UrlGeneratorInterface $urlGenerator) {
    $this->restVersionPluginManager = $restVersionPluginManager;
    $this->urlGenerator = $urlGenerator;
  }

  /**
   * List page with all the different versions.
   */
  public function listVersions() {

    $build = [];

    // @TODO Move this to a proper listbuilding class.
    $build['version_list'] = [
      '#type' => 'table',
      '#header' => [t('Label'), t('Machine name'), t('Operations')]
    ];

    foreach ($this->restVersionPluginManager->getDefinitions() as $definition) {
      $build['version_list']['#rows'][]['data'] = [
        $definition['label'],
        $definition['machineName'],
        'operations' => [
          'data' => [
            '#type' => 'operations',
            '#links' => [
              'enable' => [
                'title' => $this->t('View'),
                'url' => Url::fromRoute('rest_version_ui.version.canonical', ['version_id' => $definition['machineName']]),
              ],
            ],
          ]
        ]
      ];
    }

    return $build;
  }

  /**
   * Displays a single version for of the rest api.
   */
  public function viewVersion() {
    return [];
  }

}