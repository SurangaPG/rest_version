<?php

namespace Drupal\rest_version\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\rest\Plugin\Type\ResourcePluginManager;

/**
 * Manages discovery and instantiation of version plugins.
 *
 * @TODO This should probably not extend the defaultPluginManager but use a cleaner implementation.
 *
 * @see plugin_api
 */
class RestVersionResourcePluginManager extends DefaultPluginManager {

  /**
   * @var \Drupal\rest\Plugin\Type\ResourcePluginManager
   *   The core resourcePluginManager.
   */
  protected $resourcePluginManager;

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
   * @param \Drupal\rest\Plugin\Type\ResourcePluginManager $resourcePluginManager
   *   The core resource plugin manager.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, ResourcePluginManager $resourcePluginManager) {
    parent::__construct('Plugin/rest/resource/v0', $namespaces, $module_handler, 'Drupal\rest\Plugin\ResourceInterface', 'Drupal\rest\Annotation\RestResource');

    $this->resourcePluginManager = $resourcePluginManager;

    $this->setCacheBackend($cache_backend, 'rest_plugins');
    $this->alterInfo('rest_resource');
  }
}
