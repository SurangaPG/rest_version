<?php

namespace Drupal\rest_version\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Rest version entity.
 *
 * @ConfigEntityType(
 *   id = "rest_version",
 *   label = @Translation("Rest version"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rest_version\RestVersionListBuilder",
 *     "form" = {
 *       "add" = "Drupal\rest_version\Form\RestVersionForm",
 *       "edit" = "Drupal\rest_version\Form\RestVersionForm",
 *       "delete" = "Drupal\rest_version\Form\RestVersionDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\rest_version\RestVersionHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "rest_version",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/rest_version/{rest_version}",
 *     "add-form" = "/admin/structure/rest_version/add",
 *     "edit-form" = "/admin/structure/rest_version/{rest_version}/edit",
 *     "delete-form" = "/admin/structure/rest_version/{rest_version}/delete",
 *     "collection" = "/admin/structure/rest_version"
 *   }
 * )
 */
class RestVersion extends ConfigEntityBase implements RestVersionInterface {

  /**
   * The Rest version ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Rest version label.
   *
   * @var string
   */
  protected $label;

  /**
   * The namespace to look for data for.
   *
   * @var string
   */
  protected $namespace;

  /**
   * The prefix for this item.
   *
   * @var string
   */
  protected $prefix;

  /**
   * @inheritdoc
   */
  public function getNamespace() {
    return $this->namespace;
  }

  /**
   * @inheritdoc
   */
  public function getPrefix() {
    return $this->prefix;
  }
}
