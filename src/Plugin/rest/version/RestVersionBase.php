<?php

namespace Drupal\rest_version\Plugin\rest\version;

use Drupal\Component\Plugin\PluginBase;

abstract class RestVersionBase extends PluginBase {

  /**
   * @inheritdoc
   */
  public function getMachineName() {
    return $this->getPluginDefinition()['machineName'];
  }

}