<?php

namespace Drupal\rest_version_example\Plugin\rest\version;

use Drupal\rest_version\Plugin\rest\version\VersionBase;

/**
 * Example v0 for the api (currently used for dev purposes).
 *
 * @TODO Replace this by a config entity deriver.
 *
 * @RestVersion(
 *   id = "v0",
 *   label = "Version 0",
 *   namespace = "V0",
 *   prefix = "/rest/v0",
 * )
 */
class V0RestVersion extends VersionBase {

}