<?php

namespace Drupal\rest_version_example\Plugin\rest\version;

use Drupal\rest_version\Plugin\rest\version\VersionBase;

/**
 * Example v1 for the api (currently used for dev purposes).
 *
 * @TODO Replace this by a config entity deriver.
 *
 * @RestVersion(
 *   id = "v1",
 *   label = "Version 1",
 *   namespace = "V1",
 *   prefix = "/rest/v1",
 * )
 */
class V1RestVersion extends VersionBase {

}