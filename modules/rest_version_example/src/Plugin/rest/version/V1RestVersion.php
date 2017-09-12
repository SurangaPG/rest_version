<?php

namespace Drupal\rest_version_example\Plugin\rest\version;

use Drupal\rest_version\Plugin\rest\version\RestVersionBase;

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