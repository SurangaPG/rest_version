<?php

namespace Drupal\rest_version_ui\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\rest_version\Plugin\RestVersionPluginManager;
use Drupal\rest_version\RestResourceRepositoryInterface;
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
   * @var \Drupal\rest_version\RestResourceRepositoryInterface
   */
  protected $restResourceRepository;

  /**
   * Injects RestUIManager Service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.rest_version.version'),
      $container->get('url_generator'),
      $container->get('repository.rest_version.resource')
    );
  }

  /**
   * Constructs a RestUIController object.
   *
   * @param \Drupal\rest_version\Plugin\RestVersionPluginManager $restVersionPluginManager
   *   The REST resource plugin manager.
   * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
   *   The url generator to use.
   * @param \Drupal\rest_version\RestResourceRepositoryInterface $restResourceRepository
   *   The rest resource repository.
   */
  public function __construct(RestVersionPluginManager $restVersionPluginManager, UrlGeneratorInterface $urlGenerator, RestResourceRepositoryInterface $restResourceRepository) {
    $this->restVersionPluginManager = $restVersionPluginManager;
    $this->urlGenerator = $urlGenerator;
    $this->restResourceRepository = $restResourceRepository;
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

    foreach ($this->restVersionPluginManager->getDefinitions() as $definition) {
      $build['version_list']['#rows'][]['data'] = [
        $definition['label'],
        $definition['id'],
        'operations' => [
          'data' => [
            '#type' => 'operations',
            '#links' => [
              'enable' => [
                'title' => $this->t('View'),
                'url' => Url::fromRoute('rest_version_ui.version.canonical', ['version_id' => $definition['id']]),
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

    foreach ($this->restResourceRepository->getDefinitions($version_id) as $definition) {
      $build['endpoint_list']['#rows'][] = [
        $definition['id'],
        $definition['label'],
      ];
    }

    return $build;
  }

}