<?php

namespace Drupal\rest_version_example\Plugin\rest\resource\v0;

use Drupal\rest\ResourceResponse;
use Drupal\rest_version\Plugin\VersionedResourceBase;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "v0:node",
 *   label = @Translation("V0 resource"),
 *   uri_paths = {
 *     "canonical" = "/node/{node}",
 *   },
 *   majorVersion = "v0",
 * )
 */
class DummyNodeResource extends VersionedResourceBase {

  /**
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {
    return new ResourceResponse(['version 0']);
  }

}