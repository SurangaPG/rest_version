<?php

namespace Drupal\rest_version\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Data model entity.
 *
 * @ConfigEntityType(
 *   id = "data_model",
 *   label = @Translation("Data model"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rest_version\DataModelListBuilder",
 *     "form" = {
 *       "add" = "Drupal\rest_version\Form\DataModelForm",
 *       "edit" = "Drupal\rest_version\Form\DataModelForm",
 *       "delete" = "Drupal\rest_version\Form\DataModelDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\rest_version\DataModelHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "data_model",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/data_model/{data_model}",
 *     "add-form" = "/admin/structure/data_model/add",
 *     "edit-form" = "/admin/structure/data_model/{data_model}/edit",
 *     "delete-form" = "/admin/structure/data_model/{data_model}/delete",
 *     "collection" = "/admin/structure/data_model"
 *   }
 * )
 */
class DataModel extends ConfigEntityBase implements DataModelInterface {

  /**
   * The Data model ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Data model label.
   *
   * @var string
   */
  protected $label;

}
