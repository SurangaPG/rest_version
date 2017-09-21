<?php

namespace Drupal\rest_version\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Rest version entities.
 *
 * @TODO Remove this since it's crazy confusing in regards to the non entity interface used to represent actual rest versions.
 */
interface RestVersionInterface extends ConfigEntityInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * @return string
   */
  public function getNamespace();

  /**
   * @return string
   */
  public function getPrefix();
}
