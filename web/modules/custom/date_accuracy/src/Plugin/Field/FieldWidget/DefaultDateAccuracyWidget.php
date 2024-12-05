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
