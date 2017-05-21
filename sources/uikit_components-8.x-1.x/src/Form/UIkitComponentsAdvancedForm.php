<?php

namespace Drupal\uikit_components\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class UIkitComponentsAdvancedForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'uikit_components_advanced_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);

    // Layout.
    $form['layout'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Layout'),
    ];

    // Navigations.
    $form['navigations'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Navigations'),
    ];

    // Common.
    $form['common'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Common'),
    ];

    // JavaScript.
    $form['javascript'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('JavaScript'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('uikit_components.advanced');
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'uikit_components.advanced',
    ];
  }

}
