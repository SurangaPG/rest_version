<?php

namespace Drupal\rest_version\Plugin\rest\version;

interface VersionInterface {

  /**
   * @return string
   */
  public function getNamespace();

  /**
   * @return string
   */
  public function getPrefix();

  /**
   * @inheritdoc
   */
  public function getMachineName();

}