<?php

namespace Drupal\license_plate\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
* Plugin implementation of the 'date_accuracy' field type.
*
* @FieldType(
*   id = "date_accuracy",
*   label = @Translation("Date Accuracy"),
*   description = @Translation("field where you can store a date and choose how accurate they are"),
*   default_widget = "default_date_accuracy_widget",
*   default_formatter = "default_date_accuracy_formatter"
* )
*/
class DateAccuracyItem extends FieldItemBase
{
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings()
  {
    return [] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings()
  {
    return [] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data)
  {
    $elements = [];
    return $elements + parent::storageSettingsForm($form, $form_state, $has_data);
  }


  public static function schema(FieldStorageDefinitionInterface $field_definition)
  {
    $schema = [
      'columns' => [
        'date' => [
          'type' => 'varchar',
          'length' => 20,
        ],
      ],
    ];

    return $schema;
  }

  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition)
  {
    $properties['date'] = DataDefinition::create('string')
      ->setLabel(t('Date'));

    return $properties;
  }


  /**
   * {@inheritdoc}
   */
  public function getConstraints()
  {
    $constraints = parent::getConstraints();
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty()
  {
    // We consider the field empty if either of the properties is left empty.
    $date = $this->get('number')->getValue();
    return $date === NULL || $date === '';
  }
}
