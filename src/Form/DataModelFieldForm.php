<?php

namespace Drupal\rest_version\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DataModelFieldForm.
 */
class DataModelFieldForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $data_model_field = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $data_model_field->label(),
      '#description' => $this->t("Label for the Data model field."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $data_model_field->id(),
      '#machine_name' => [
        'exists' => '\Drupal\rest_version\Entity\DataModelField::load',
      ],
      '#disabled' => !$data_model_field->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $data_model_field = $this->entity;
    $status = $data_model_field->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Data model field.', [
          '%label' => $data_model_field->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Data model field.', [
          '%label' => $data_model_field->label(),
        ]));
    }
    $form_state->setRedirectUrl($data_model_field->toUrl('collection'));
  }

}
