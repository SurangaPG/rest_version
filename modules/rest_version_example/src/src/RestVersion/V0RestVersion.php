<?php

namespace Drupal\rest_version_example\Plugin\RestVersion;

use Drupal\rest_version\Plugin\RestVersion\RestVersionBase;

/**
 * Example v0 for the api (currently used for dev purposes).
 *
 * @TODO Replace this by a config entity deriver.
 *
 * @RestVersion(
 *   id = "v0",
 *   label = "Version 0",
 *   machineName = "v0",
 * )
 */
class V0RestVersionBase extends RestVersionBase {

}