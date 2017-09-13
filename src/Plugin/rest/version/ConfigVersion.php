<?php

namespace Drupal\rest_version\Plugin\Deriver;

use Drupal\rest\Plugin\ResourceBase;

/**
 * Represents version config entities as plugins.
 *
 * @see \Drupal\rest\Plugin\Deriver\EntityDeriver
 *
 * @RestVersion(
 *   id = "config_version",
 *   label = @Translation("Version"),
 *   deriver = "Drupal\rest_version\Plugin\rest\version\Deriver\ConfigVersionDeriver",
 * )
 */
class ConfigVersion extends ResourceBase {


}