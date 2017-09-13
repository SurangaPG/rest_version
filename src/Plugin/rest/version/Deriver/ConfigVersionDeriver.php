<?php

namespace Drupal\rest_version\Plugin\rest\version\Deriver;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\rest_version\Entity\RestVersionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a version plugin for every config entity.
 *
 * @see \Drupal\rest\Plugin\rest\resource\EntityResource
 */
class ConfigVersionDeriver implements ContainerDeriverInterface {

  /**
   * List of derivative definitions.
   *
   * @var array
   */
  protected $derivatives;

  /**
   * The config storage manager
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $versionConfigStorage;

  /**
   * Constructs an EntityDeriver object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $versionConfigStorage
   *   The REST resource config storage.
   */
  public function __construct(EntityStorageInterface $versionConfigStorage) {
    $this->versionConfigStorage = $versionConfigStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity_type.manager')->getStorage('rest_version')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinition($derivative_id, $base_plugin_definition) {
    if (!isset($this->derivatives)) {
      $this->getDerivativeDefinitions($base_plugin_definition);
    }
    if (isset($this->derivatives[$derivative_id])) {
      return $this->derivatives[$derivative_id];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    if (!isset($this->derivatives)) {
      /** @var RestVersionInterface[] $versions */
      $versions = $this->versionConfigStorage->loadMultiple();

      foreach ($versions as $versionId => $versionConfig) {
        $this->derivatives[$versionId] = [
          'id' => $versionConfig->id(),
          'label' => $versionConfig->label(),
          'namespace' => $versionConfig->getNamespace(),
        ];

        $this->derivatives[$versionId] += $base_plugin_definition;
      }
    }
    return $this->derivatives;
  }

}
