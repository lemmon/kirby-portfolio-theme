<?php

Kirby::plugin('lemmon/bots', [
  'routes' => [
    [
      'pattern' => 'robots.txt',
      'action' => function () {
        if (kirby()->request()->path()->toString() !== kirby()->path()) {
          die('404');
        }
        $res = [
          'User-agent: *',
          'Disallow: /panel/',
          'Allow: /',
          'Sitemap: ' . kirby()->url() . '/sitemap.txt',
        ];
        return new Response(join("\n", $res), 'text/plain');
      },
    ],
    [
      'pattern' => 'sitemap.txt',
      'action' => function () {
        $pages = [
          site()->url() . '/',
        ];
        foreach (site()->index()->listed()->not('home') as $page) {
          $pages[] = $page->url();
        }
        return new Response(join("\n", $pages), 'text/plain');
      },
    ],
    [
      'pattern' => 'sitemap',
      'action' => function () {
        return go('sitemap.txt', 301);
      },
    ],
  ],
]);
