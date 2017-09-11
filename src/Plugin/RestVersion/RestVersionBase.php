<?php

namespace Drupal\rest_version\Plugin\RestVersion;

use Drupal\Component\Plugin\PluginBase;
use Drupal\rest_version\RestVersionInterface;

abstract class RestVersionBase extends PluginBase implements RestVersionInterface {

  /**
   * @inheritdoc
   */
  public function getMachineName() {
    return $this->getPluginDefinition()['machineName'];
  }

}