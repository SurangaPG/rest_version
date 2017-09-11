<?php

namespace Drupal\rest_version_ui\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\rest_version\Plugin\RestVersionPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RestVersionUIController
 *
 * Contains all the route callbacks for the more generic pages.
 */
class RestVersionUIController extends ControllerBase {

  /**
   * @var
   */
  protected $restVersionPluginManager;

  /**
   * Injects RestUIManager Service.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.rest_version.version')
    );
  }

  /**
   * Constructs a RestUIController object.
   *
   * @param \Drupal\rest_version\Plugin\RestVersionPluginManager $restVersionPluginManager
   *   The REST resource plugin manager.
   */
  public function __construct(RestVersionPluginManager $restVersionPluginManager) {
    $this->restVersionPluginManager = $restVersionPluginManager;
  }

  /**
   * List page with all the different versions.
   */
  public function listVersions() {

    $build = [];

    foreach ($this->restVersionPluginManager->getDefinitions() as $definition) {

    }

    return $build;
  }

}