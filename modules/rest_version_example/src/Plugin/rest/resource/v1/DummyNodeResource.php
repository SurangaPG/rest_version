<?php

namespace Drupal\rest_version_example\Plugin\rest\resource\v1;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "v1:node",
 *   label = @Translation("V1 resource"),
 *   uri_paths = {
 *     "canonical" = "/v1/node/{node}",
 *   }
 * )
 */
class DummyNodeResource extends ResourceBase {

  public function get() {
    return new ResourceResponse(['v1']);
  }

}