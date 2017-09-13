<?php

namespace Drupal\rest_version\Factory;

use Drupal\rest_version\Manager\Resource\ResourcePluginManagerInterface;

/**
 * Interface for the service that generates the actual resourcePluginManagers.
 *
 * Concept behind this is that the different resource plugins for the various
 * api versions should be capable of existing in a separate namespace. Thus
 * preventing the fact that module would become very cluttered under the
 * "standard" Plugin/Rest/resource.
 *
 * Basically this factory will generate pluginManagers on the fly based on the
 * detected version plugins.
 */
interface ResourcePluginManagerFactoryInterface {

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
    public function generateVersionResourcePluginManager($versionId);

}