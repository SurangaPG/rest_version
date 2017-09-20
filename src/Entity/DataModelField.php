<?php

namespace Drupal\rest_version\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Data model field entity.
 *
 * @ConfigEntityType(
 *   id = "data_model_field",
 *   label = @Translation("Data model field"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rest_version\DataModelFieldListBuilder",
 *     "form" = {
 *       "add" = "Drupal\rest_version\Form\DataModelFieldForm",
 *       "edit" = "Drupal\rest_version\Form\DataModelFieldForm",
 *       "delete" = "Drupal\rest_version\Form\DataModelFieldDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\rest_version\DataModelFieldHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "data_model_field",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/data_model_field/{data_model_field}",
 *     "add-form" = "/admin/structure/data_model_field/add",
 *     "edit-form" = "/admin/structure/data_model_field/{data_model_field}/edit",
 *     "delete-form" = "/admin/structure/data_model_field/{data_model_field}/delete",
 *     "collection" = "/admin/structure/data_model_field"
 *   }
 * )
 */
class DataModelField extends ConfigEntityBase implements DataModelFieldInterface {

  /**
   * The Data model field ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Data model field label.
   *
   * @var string
   */
  protected $label;

}
