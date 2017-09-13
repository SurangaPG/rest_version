<?php

namespace Drupal\rest_version\Repository;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface;
use Drupal\rest_version\RestResourceRepositoryInterface;

/**
 * Interface RestResourceRepositoryInterface
 *
 * Basic interface to wrap around some helpers based on the resource config
 * storage.
 *
 * Provides an abstraction layer for later adaptations of the way the
 * resources are handled in a version based logic.
 */
class RestResourceRepository implements RestResourceRepositoryInterface {

    /**
     * Configuration entity to store enabled REST resources.
     *
     * @var \Drupal\rest\RestResourceConfigInterface
     */
    protected $resourceConfigStorage;

    /**
     * @var \Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface
     */
    protected $resourcePluginManagerFactory;

    /**
     * RestResourceRepository constructor.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
     *   The entity type manager.
     * @param \Drupal\rest_version\Factory\ResourcePluginManagerFactoryInterface $resourcePluginManagerFactory
     *   The resource plugin manager.
     */
    public function __construct(EntityTypeManagerInterface $entityTypeManager, ResourcePluginManagerFactoryInterface $resourcePluginManagerFactory) {
        $this->resourceConfigStorage = $entityTypeManager->getStorage('rest_resource_config');
        $this->resourcePluginManagerFactory = $resourcePluginManagerFactory;
    }

    /**
     * @inheritdoc
     */
    public function getDefinitions($versionId) {
        return $this->resourcePluginManagerFactory
            ->generateVersionResourcePluginManager($versionId)
            ->getDefinitions();
    }
}