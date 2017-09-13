<?php

namespace Drupal\rest_version\Manager\Resource;

use Drupal\rest\Plugin\Type\ResourcePluginManager;

/**
 * Class WrapperResourcePluginManager
 *
 * Provides a dummy ResourcePluginManager based on the core implementation.
 * This is activated when the "dev" version is used.
 */
class WrapperResourcePluginManager implements ResourcePluginManagerInterface {

    /**
     * @var \Drupal\rest\Plugin\Type\ResourcePluginManager
     */
    protected $resourcePluginManager;

    /**
     * WrapperResourcePluginManager constructor.
     *
     * @param \Drupal\rest\Plugin\Type\ResourcePluginManager $resourcePluginManager
     *   The core drupal rest plugin manager.
     */
    public function __construct(ResourcePluginManager $resourcePluginManager) {
        $this->resourcePluginManager = $resourcePluginManager;
    }

    /**
     * @inheritdoc
     */
    public function createInstance($plugin_id, array $configuration = []) {
        return $this->resourcePluginManager->createInstance($plugin_id, $configuration);
    }

    /**
     * @inheritdoc
     */
    public function getDefinitions() {
        return $this->resourcePluginManager->getDefinitions();
    }

    /**
     * @inheritdoc
     */
    public function getDefinition($plugin_id, $exception_on_invalid = TRUE) {
        return $this->resourcePluginManager->getDefinition($plugin_id, $exception_on_invalid);
    }

    /**
     * @inheritdoc
     */
    public function hasDefinition($plugin_id) {
        return $this->resourcePluginManager->hasDefinition($plugin_id);
    }

    /**
     * @inheritdoc
     */
    public function getInstance(array $options) {
        return $this->resourcePluginManager->getInstance($options);
    }
}