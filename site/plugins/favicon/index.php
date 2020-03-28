<?php

Kirby::plugin('lemmon/favicon', [
  'routes' => [
    [
      'pattern' => 'favicon.ico',
      'action' => function () {
        $file = site()->files()->filterBy('template', 'favicon')->first();
        if (!$file) {
          http_response_code(404);
          die('not found');
        }
        header('Content-Type: ' . $file->mime());
        readfile($file->root());
        exit;
      },
    ],
  ],
]);
