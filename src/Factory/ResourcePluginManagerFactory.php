<?php

namespace Drupal\rest_version\Factory;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\rest\Plugin\Type\ResourcePluginManager;
use Drupal\rest_version\Manager\Resource\DefaultResourcePluginManager;
use Drupal\rest_version\Manager\Resource\ResourcePluginManagerInterface;
use Drupal\rest_version\Manager\Resource\WrapperResourcePluginManager;
use Drupal\rest_version\Manager\Version\VersionPluginManager;

/**
 * Factory for the service that generates the actual resourcePluginManagers.
 *
 * Concept behind this is that the different resource plugins for the various
 * api versions should be capable of existing in a separate namespace. Thus
 * preventing the fact that module would become very cluttered under the
 * "standard" Plugin/Rest/resource.
 *
 * Basically this factory will generate pluginManagers on the fly based on the
 * detected version plugins.
 */
class ResourcePluginManagerFactory implements ResourcePluginManagerFactoryInterface {

    /**
     * @var \Traversable
     *   An object that implements \Traversable which contains the root paths
     *   keyed by the corresponding namespace to look for plugin implementations.
     */
    protected $namespaces;

    /**
     * @var \Drupal\Core\Cache\CacheBackendInterface
     *   Cache backend instance to use.
     */
    protected $cacheBackend;

    /**
     * @var \Drupal\Core\Extension\ModuleHandlerInterface
     *   The module handler to invoke the alter hook with.
     */
    protected $moduleHandler;

    /**
     * @var \Drupal\rest\Plugin\Type\ResourcePluginManager
     *  The core rest resourcePluginManager.
     */
    protected $resourcePluginManager;

    /**
     * @var \Drupal\rest_version\Manager\Version\VersionPluginManager
     *   The version plugin manager.
     */
    protected $restVersionPluginManager;

    /**
     * @var \Drupal\rest_version\Manager\Resource\ResourcePluginManagerInterface[]
     *   All the resource plugin managers that were already loaded. Keyed by
     *   the id of the rest version they belong to.
     */
    protected $loadedManagers;

    /**
     * Constructs a new factory to generate the "version based plugin managers".
     *
     * @param \Traversable $namespaces
     *   An object that implements \Traversable which contains the root paths
     *   keyed by the corresponding namespace to look for plugin implementations.
     * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
     *   Cache backend instance to use.
     * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
     *   The module handler to invoke the alter hook with.
     * @param \Drupal\rest\Plugin\Type\ResourcePluginManager $resourcePluginManager
     *   The core rest resourcePluginManager.
     * @param \Drupal\rest_version\Manager\Version\VersionPluginManager $restVersionPluginManager
     *   The rest version plugin manager.
     */
    public function __construct(
        \Traversable $namespaces,
        CacheBackendInterface $cacheBackend,
        ModuleHandlerInterface $moduleHandler,
        ResourcePluginManager $resourcePluginManager,
        VersionPluginManager $restVersionPluginManager
    ) {
        $this->namespaces = $namespaces;
        $this->cacheBackend = $cacheBackend;
        $this->moduleHandler = $moduleHandler;
        $this->resourcePluginManager = $resourcePluginManager;
        $this->restVersionPluginManager = $restVersionPluginManager;
    }

    /**
     * Generates a single plugin manager.
     *
     * Factory method to start up a single plugin manager with all the resources
     * for a given version of the api.
     *
     * @param string $versionId
     *   Id for the pluginmanager to get.
     *
     * @return ResourcePluginManagerInterface
     *   The manager for the various resource plugins connected to the version.
     */
    public function generateVersionResourcePluginManager($versionId) {

        if (isset($this->loadedManagers[$versionId])) {
            return $this->loadedManagers[$versionId];
        }

        // The 'dev' version is special in the sense that it points to the
        // current complete data model. As supplied by the core rest.
        // So in this case we'll return a "dummy class" based on the core
        // resource plugin manager.
        if ($versionId == 'dev') {
            return new WrapperResourcePluginManager($this->resourcePluginManager);
        }

        // Otherwise we'll attempt to load in the plugin manager connected
        // to the major version.
        if ($this->restVersionPluginManager->hasDefinition($versionId)) {

            $definition = $this->restVersionPluginManager->getDefinition($versionId);

            return new DefaultResourcePluginManager($this->namespaces, $this->cacheBackend, $this->moduleHandler, $definition);
        }

    }
}