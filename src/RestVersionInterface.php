<?php

namespace Drupal\rest_version;

/**
 * Defines a common interface for all versions for a rest implementation.
 */
interface RestVersionInterface {

  /**
   * Gets the machine name for the version.
   *
   * The machine name is a short identifier such as "v0", "v1" etc.
   * By default it is added as a prefix to the actual endpoint.
   *
   * @return string
   */
  public function getMachineName();

}