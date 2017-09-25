<?php

namespace Drupal\rest_version\Plugin\rest\version;

use Symfony\Component\Routing\Route;

interface VersionInterface {

  /**
   * @return string
   */
  public function getNamespace();

  /**
   * @return string
   */
  public function getPrefix();

  /**
   * @inheritdoc
   */
  public function getMachineName();

  /**
   * Converts a path to a prefixed one.
   *
   * This will allow your version to change the prefix of an endpoint to
   * the version based endpoint.
   *
   * @param string $path
   *
   * @return string
   */
  public function prefixPath($path);

  /**
   * Alters a route for a resource to be in line with the data for the version.
   *
   * This will allow the version plugin to add all the needed data to a
   * e.g prefix the path, add some extra parameters etc.
   *
   * @param \Symfony\Component\Routing\Route $route
   */
  public function alterRoute(Route &$route);
}