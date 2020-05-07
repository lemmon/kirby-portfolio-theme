<?php

Kirby::plugin('lemmon/image-tag', [
  'tags' => [
    'image' => [
      'attr' => [
        'alt',
        'title',
        'caption',
      ],
      'html' => function ($tag) {
        // find file
        $file = $tag->file($tag->value);
        if (!$file) return;
        // params
        $alt     = $tag->alt     ?? $file->alt()->value();
        $title   = $tag->title   ?? $file->title()->value();
        $caption = $tag->caption ?? $file->caption()->value();
        // responsivity
        if (!in_array($file->mime(), ['image/gif', 'image/svg+xml'])) {
          if (!empty($tag->data['srcset'])) {
            $srcset = $file->srcset($tag->data['srcset']);
          }
          if (!empty($tag->data['width'])) {
            $file = $file->resize($tag->data['width']);
          }
        }
        // html
        return Html::figure([
          Html::img($file->url(), [
            'width'  => $file->width(),
            'height' => $file->height(),
            'alt'    => $alt ?: ' ',
            'title'  => $title,
            'srcset' => $srcset ?? null,
          ]),
        ], $caption ? [
          kirbytext($caption),
        ] : null, [
          'class' => 'image',
        ]);
      },
    ],
  ],
]);
