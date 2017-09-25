<?php

namespace Drupal\rest_version\Plugin\rest\version;

use Drupal\Component\Plugin\PluginBase;
use Symfony\Component\Routing\Route;

abstract class VersionBase extends PluginBase implements VersionInterface {

  /**
   * @inheritdoc
   */
  public function getMachineName() {
    return $this->getPluginDefinition()['machineName'];
  }

  public function getNamespace() {
    return $this->getPluginDefinition()['namespace'];
  }

  public function getPrefix() {
    return $this->getPluginDefinition()['prefix'];
  }

  /**
   * @inheritdoc
   */
  public function prefixPath($path) {
    return $this->getPrefix() . $path;
  }

  /**
   * @inheritdoc
   */
  public function alterRoute(Route &$route) {
    $route->setPath($this->prefixPath($route->getPath()));
  }
}