<?php

namespace Drupal\rest_version_example\Plugin\rest\resource\v0;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "v0:node",
 *   label = @Translation("V0 resource"),
 *   uri_paths = {
 *     "canonical" = "/v0/node/{node}",
 *   }
 * )
 */
class DummyNodeResource extends ResourceBase {

  /**
   * @return \Drupal\rest\ResourceResponse
   */
  public function get() {
    return new ResourceResponse(['version 0']);
  }

}