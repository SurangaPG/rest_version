<?php

namespace Drupal\rest_version\Manager\Resource;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Class DefaultResourcePluginManager
 *
 * Default resource plugin manager, geared towards adding some extra namespace
 * information based on the definition of the version being loaded.
 */
class DefaultResourcePluginManager extends DefaultPluginManager implements ResourcePluginManagerInterface {

    /**
     * Constructs a new \Drupal\rest\Plugin\Type\ResourcePluginManager object.
     *
     * @param \Traversable $namespaces
     *   An object that implements \Traversable which contains the root paths
     *   keyed by the corresponding namespace to look for plugin implementations.
     * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
     *   Cache backend instance to use.
     * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
     *   The module handler to invoke the alter hook with.
     * @param array $versionDefinition
     *   The plugin definition for the version.
     */
    public function __construct(\Traversable $namespaces, CacheBackendInterface $cacheBackend, ModuleHandlerInterface $moduleHandler, $versionDefinition) {

        // Account for possible leading/trailing slashes.
        $pluginNamespace = 'Plugin/rest/resource/' . trim($versionDefinition['namespace'], '/');

        parent::__construct($pluginNamespace, $namespaces, $moduleHandler, 'Drupal\rest\Plugin\ResourceInterface', 'Drupal\rest\Annotation\RestResource');

        $this->setCacheBackend($cacheBackend, 'rest_plugins_' . $versionDefinition['id']);
        $this->alterInfo('rest_resource_' . $versionDefinition['id']);
    }
}