<?php

namespace Drupal\rest_version\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages discovery and instantiation of version plugins.
 *
 * @see plugin_api
 */
class VersionPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new \Drupal\rest\Plugin\Type\ResourcePluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/RestVersion/Version', $namespaces, $module_handler, 'Drupal\rest_version\Version\VersionInterface', 'Drupal\rest_version\Annotation\RestVersion');

    $this->setCacheBackend($cache_backend, 'rest_version_version_plugins');
    $this->alterInfo('rest_version_version_plugins');
  }

}
