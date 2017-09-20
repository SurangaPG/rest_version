<?php

namespace Drupal\rest_version\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Data model entities.
 */
interface DataModelInterface extends ConfigEntityInterface {

  /**
   * @return array
   */
  public function getFields();

  /**
   * @param array $fields
   */
  public function setFields($fields);

}
