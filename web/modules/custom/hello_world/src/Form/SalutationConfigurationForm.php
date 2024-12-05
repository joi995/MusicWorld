<?php
namespace Drupal\hello_world\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SalutationConfigurationForm extends ConfigFormBase {
  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames(): array {
    return ['hello_world.custom_salutation'];
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId(): string {
    return 'salutation_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('hello_world.custom_salutation');

    $form['salutation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Salutation'),
      'description' => $this->t('Please provide the salutation that you want to use.'),
      '#default_value' => $config->get('salutation'),
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('hello_world.custom_salutation')
      ->set('salutation', $form_state->getValue('salutation'))
      ->save();
  }

  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $salutation = $form_state->getValue('salutation');
    if (mb_strlen($salutation) > 20) {
      $form_state->setErrorByName('salutation', $this->t('Salutation must be less than 20 characters'));
    }
  }
}
