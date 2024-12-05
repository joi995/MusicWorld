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
class DateAccuracyItem extends FieldItemBase {
  use StringTranslationTrait;

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
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
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['date'] = DataDefinition::create('string')
      ->setLabel(t('Date'));

    return $properties;
  }
}
