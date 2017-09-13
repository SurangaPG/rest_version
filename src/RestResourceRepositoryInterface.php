<?php

namespace Drupal\rest_version;

/**
 * Interface RestResourceRepositoryInterface
 *
 * Basic interface to wrap around some helpers based on the resource config
 * storage.
 *
 * Provides an abstraction layer for later adaptations of the way the
 * resources are handled in a version based logic.
 */
interface RestResourceRepositoryInterface {

    /**
     * Get all the definitions for this version.
     *
     * @param string $versionId
     *   The version id to get all the definitions for.
     *
     * @return \mixed[]
     *   Array with the loaded definitions for this version.
     */
    public function getDefinitions($versionId);

}