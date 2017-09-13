<?php

namespace Drupal\rest_version_example\Plugin\rest\resource\v1;

/**
 * Represents entities as resources.
 *
 * @RestResource(
 *   id = "v1.hahah",
 *   label = @Translation("V1 resource"),
 *   uri_paths = {
 *     "canonical" = "/haha",
 *   }
 * )
 */
class DummyResource {

}