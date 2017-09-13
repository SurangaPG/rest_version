<?php

namespace Drupal\rest_version\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class RestVersionForm.
 */
class RestVersionForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $rest_version = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $rest_version->label(),
      '#description' => $this->t("Label for the Rest version."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $rest_version->id(),
      '#machine_name' => [
        'exists' => '\Drupal\rest_version\Entity\RestVersion::load',
      ],
      '#disabled' => !$rest_version->isNew(),
    ];

    // @TODO No validation whatsoever currently.
    $form['namespace'] = [
      '#type' => 'textfield',
      '#default_value' => $rest_version->getNamespace(),
      '#description' => t('Specify the namespace for any codebased plugins.')
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $rest_version = $this->entity;
    $status = $rest_version->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Rest version.', [
          '%label' => $rest_version->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Rest version.', [
          '%label' => $rest_version->label(),
        ]));
    }
    $form_state->setRedirectUrl(Url::fromRoute('restui.list'));
  }

}
