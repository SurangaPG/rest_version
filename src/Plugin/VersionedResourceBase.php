<?php

namespace Drupal\rest_version\Plugin;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest_version\Entity\RestVersionInterface;

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

    if (isset($majorVersion) && $majorVersion != 'dev') {
      /** @var RestVersionInterface $versionDefinition */
      $versionDefinition = \Drupal::service('plugin.manager.rest_version.version')->createInstance($majorVersion);
      $route->setPath($versionDefinition->getPrefix() . $route->getPath());
    }

    return $route;
  }

}