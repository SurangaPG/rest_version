<?php

namespace Drupal\rest_version\Plugin\rest\version;

use Drupal\Component\Plugin\PluginBase;

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
}