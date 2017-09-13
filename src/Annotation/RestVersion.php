<?php

namespace Drupal\rest_version\Annotation;

use \Drupal\Component\Annotation\Plugin;

/**
 * Defines a Api Version annotation object.
 *
 * Plugin Namespace: Plugin\RestVersion\Version
 *
 * @ingroup third_party
 *
 * @Annotation
 */
class RestVersion extends Plugin {

  /**
   * The namespace to look for plugins for.
   *
   * @var string
   */
  public $namespace;

}
