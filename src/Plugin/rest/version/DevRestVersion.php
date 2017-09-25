<?php

namespace Drupal\rest_version\Plugin\rest\version;
use Symfony\Component\Routing\Route;

/**
 * Special version that is always at the "head" of the current data model.
 *
 * @RestVersion(
 *   id = "dev",
 *   label = "Development",
 *   machineName = "dev",
 *   prefix = "",
 * )
 */
class DevRestVersionBase extends VersionBase {

  /**
   * @inheritdoc
   */
  public function alterRoute(Route &$route) {
    // This is a dummy, the "dev" version is applied to all the core rest.
    // It won't add any extra prefix.
  }

}