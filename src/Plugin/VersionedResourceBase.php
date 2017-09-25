<?php

namespace Drupal\rest_version\Plugin;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest_version\Plugin\rest\version\VersionInterface;

class VersionedResourceBase extends ResourceBase {

  /**
   * Gets the base route for a particular method.
   *
   * @param string $canonical_path
   *   The canonical path for the resource.
   * @param string $method
   *   The HTTP method to be used for the route.
   *
   * @return \Symfony\Component\Routing\Route
   *   The created base route.
   */
  protected function getBaseRoute($canonical_path, $method) {

    $route = parent::getBaseRoute($canonical_path, $method);

    // @TODO Inject this instead of using the global drupal object.
    $majorVersion = $this->getPluginDefinition()['majorVersion'];

    // Backwards compatibility with the core rest items.
    // If no version is specified the "dev" version is used which is a dummy.
    $majorVersion = isset($majorVersion) ? $majorVersion : 'dev';

    /** @var VersionInterface $versionDefinition */
    $versionDefinition = \Drupal::service('plugin.manager.rest_version.version')->createInstance($majorVersion);
    $versionDefinition->alterRoute($route);

    return $route;
  }

}