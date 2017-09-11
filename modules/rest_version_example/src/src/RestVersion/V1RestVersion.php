<?php

namespace Drupal\rest_version_example\Plugin\RestVersion;

use Drupal\rest_version\Plugin\RestVersion\RestVersionBase;

/**
 * Example v1 for the api (currently used for dev purposes).
 *
 * @TODO Replace this by a config entity deriver.
 *
 * @RestVersion(
 *   id = "v1",
 *   label = "Version 1",
 *   machineName = "v1",
 * )
 */
class V1RestVersionBase extends RestVersionBase {

}