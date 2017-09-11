<?php

namespace Drupal\rest_version\Plugin\RestVersion;

/**
 * Special version that is always at the "head" of the current data model.
 *
 * @RestVersion(
 *   id = "dev",
 *   label = "Development",
 *   machineName = "dev",
 * )
 */
class DevRestVersionBase extends RestVersionBase {

}