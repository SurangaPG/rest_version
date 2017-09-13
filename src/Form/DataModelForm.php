<?php

namespace Drupal\rest_version\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

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

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $data_model = $this->entity;
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
