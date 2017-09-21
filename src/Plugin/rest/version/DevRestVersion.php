<?php

namespace Drupal\rest_version\Plugin\rest\version;

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

}