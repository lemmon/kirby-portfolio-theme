<?php

require __DIR__ . '/helpers.php';
require __DIR__ . '/Color.php';

Kirby::plugin('lemmon/color-field', [
  'fieldMethods' => [
    'isColor' => function ($field) {
      return $field->isNotEmpty() and Lemmon\is_color($field->value());
    },
    'toColor' => function ($field) {
      return ($field->isNotEmpty() and Lemmon\is_color($field->value()))
        ? new Lemmon\Color($field->value())
        : null
        ;
    },
  ],
]);
