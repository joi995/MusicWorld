<?php

namespace Drupal\date_accuracy\Plugin\Field\FieldWidget;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'default_date_accuracy_widget' widget.
 *
 * @FieldWidget(
 *   id = "default_date_accuracy_widget",
 *   label = @Translation("Default Date Accuracy widget"),
 *   field_types = {
 *     "date_accuracy"
 *   }
 * )
 */

class DefaultDateAccuracyWidget extends WidgetBase
{
  use StringTranslationTrait;

  /**
   * {@inheritDoc}
   */
  public static function defaultSettings()
  {
    return [
        'date_format' => 'Y-m-d',
        'placeholder' => 'Enter a date',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['fieldset_state'] = [
      '#type' => 'select',
      '#title' => $this->t('Fieldset default state'),
      '#options' => [
        'open' => $this->t('Open'),
        'closed' => $this->t('Closed'),
      ],
      '#default_value' => $this->getSetting('fieldset_state'),
      '#description' => $this->t('The default state of the fieldset which contains the two plate fields: open or closed'),
    ];

    $elements['placeholder'] = [
      '#type' => 'details',
      '#title' => $this->t('Placeholder'),
      '#description' => $this->t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    $placeholder_settings = $this->getSetting('placeholder');
    $elements['placeholder']['date'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Number field'),
      '#default_value' => $placeholder_settings['date'],
    ];

    return $elements;
  }


  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('License plate size: @number (for number) and @code (for code)', [
      '@number' => $this->getSetting('number_size'),
      '@code' => $this->getSetting('code_size'),
    ]);
    $placeholder_settings = $this->getSetting('placeholder');
    if (!empty($placeholder_settings['number']) && !empty($placeholder_settings['code'])) {
      $placeholder = $placeholder_settings['number'] . ' ' . $placeholder_settings['code'];
      $summary[] = $this->t('Placeholder: @placeholder', ['@placeholder' => $placeholder]);
    }
    $summary[] = $this->t('Fieldset state: @state', ['@state' => $this->getSetting('fieldset_state')]);

    return $summary;
  }


  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
  {
    $element['details'] = [
        '#type' => 'details',
        '#title' => $element['#title'],
        '#open' => $this->getSetting('fieldset_state') == 'open' ? TRUE : FALSE,
        '#description' => $element['#description'],
      ] + $element;

    $placeholder_settings = $this->getSetting('placeholder');

    $this->addCodeField($element, $items, $delta, $placeholder_settings);

    $element['details']['number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Date'),
      '#default_value' => $items[$delta]->date ?? NULL,
      '#placeholder' => $placeholder_settings['date'],
      '#description' => '',
      '#required' => $element['#required'],
    ];

    return $element;
  }
}
