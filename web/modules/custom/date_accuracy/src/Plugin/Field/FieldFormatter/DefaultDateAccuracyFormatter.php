<?php

namespace Drupal\date_accuracy\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * plugin implementation of the 'default_date_accuracy_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "default_date_accuracy_formatter",
 *   label = @Translation("Default date accuracy formatter),
 *   field_types = {
 *     "date_accuracy"
 *   }
 * )
 */

class DefaultDateAccuracyFormatter extends FormatterBase {
  use StringTranslationTrait;

  /**
   * {@inheritdoc }
   */
  public static function defaultSettings() {
    return [
      'accuracy' => 'day',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc }
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      'accuracy' => [
        '#type' => 'select',
        '#title' => $this->t('Accuracy'),
        '#options' => ['year', 'month', 'day'],
        '#description' => $this->t('The accuracy of the date accuracy field.'),
        '#default_value' => $this->getSetting('accuracy'),
      ]
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('accuracy: @value');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = $this->viewValue($item);
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return array
   *   The value render array.
   */
  protected function viewValue(FieldItemInterface $item) {
    $date = $item->get('date')->getValue();
    return [
      '#theme' => 'date_accuracy',
      '#date' => $date,
      '#accuracy' => $this->getSetting('accuracy'),
    ];
  }

}
