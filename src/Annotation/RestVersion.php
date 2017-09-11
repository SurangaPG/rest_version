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
   * The Major version number.
   *
   * Usually in the form "v0", "v1" etc.
   *
   * @var string
   */
  public $machineName;

}
