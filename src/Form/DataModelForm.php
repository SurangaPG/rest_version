<?php

namespace Drupal\rest_version\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\rest_version\Entity\DataModelField;
use Drupal\rest_version\Entity\DataModelInterface;

/**
 * Class DataModelForm.
 */
class DataModelForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $data_model = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $data_model->label(),
      '#description' => $this->t("Label for the Data model."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $data_model->id(),
      '#machine_name' => [
        'exists' => '\Drupal\rest_version\Entity\DataModel::load',
      ],
      '#disabled' => !$data_model->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */
    // Add a sneaky testy implementation for the idea of saving entity field data.
    $entityTypeId = 'node';
    $entityBundle = 'page';

    // Get the fields on the bundle.
    $storage = $this->entityTypeManager->getStorage('field_config');
    $fields = $storage->loadByProperties(['entity_type' => $entityTypeId, 'bundle' => $entityBundle]);

    $form['fields']['#tree'] = TRUE;
    $form['fields'] = [
      '#type' => 'checkboxes',
      '#title' => t('Locked in fields'),
      '#options' => [],
      '#default_value' => $data_model->getFields(),
    ];

    // Add checkboxes to allow locking in the various fields.
    foreach ($fields as $fieldConfig) {
      $form['fields']['#options'][$fieldConfig->id()] = $fieldConfig->label();
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var DataModelInterface $data_model */
    $data_model = $this->entity;

    // Clean up the fields array to something a bit more usable.
    // Basically makes into a "straight" array of field identifiers.
    $fields = $data_model->getFields();
    $fields = array_filter($fields);
    $fields = array_keys($fields);
    $data_model->setFields($fields);

    // Generate a list of the updated field config for the data model.
    // @TODO account for the removing/updating of a data model.
    $storage = $this->entityTypeManager->getStorage('field_config');

    foreach($data_model->getFields() as $field) {
      $field = $storage->load($field);

      // @TODO Handle dependencies better by using the core config system (needs field etc).
      // @TODO Relying on the field as a dependency might not be enough since it's own dependencies might change.
      $fieldConfig = \Drupal::configFactory()->get('field.field.' . $field->id())->get();

      $dataModelFieldValues = [
        'id' => $data_model->id() . '.' . $field->id(),
        'label' => $field->label(),
        'field_config' => $fieldConfig,
      ];

      $dataModelField = DataModelField::create($dataModelFieldValues);
      $dataModelField->save();
    }


    $status = $data_model->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Data model.', [
          '%label' => $data_model->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Data model.', [
          '%label' => $data_model->label(),
        ]));
    }
    $form_state->setRedirectUrl($data_model->toUrl('collection'));
  }

}
