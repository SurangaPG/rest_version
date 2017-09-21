<?php

namespace Drupal\rest_version_example\Plugin\rest\resource\v1;

use Drupal\rest\ResourceResponse;
use Drupal\rest_version\Plugin\VersionedResourceBase;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "v1:node",
 *   label = @Translation("V1 resource"),
 *   uri_paths = {
 *     "canonical" = "/node/{node}",
 *   },
 *   majorVersion = "v1",
 * )
 */
class DummyNodeResource extends VersionedResourceBase {

  public function get() {
    return new ResourceResponse(['v1']);
  }

}