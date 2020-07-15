<?php

function twig(string $template, array $data = null)
{
  $loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
  $twig = new Twig\Environment($loader, [
    'cache' => __DIR__ . '/../../cache/twig',
    'debug' => option('debug'),
  ]);
  $twig->addFunction(new Twig\TwigFunction('layout', function ($name = 'default') {
    return "layouts/${name}.twig";
  }));
  $twig->addFunction(new Twig\TwigFunction('partial', function ($name) {
    return "partials/${name}.twig";
  }));
  $twig->addFunction(new Twig\TwigFunction('template', function ($name) {
    return "pages/${name}.twig";
  }));
  $twig->addFunction(new Twig\TwigFunction('dump', function (...$args) {
    return Symfony\Component\VarDumper\VarDumper::dump(...$args);
  }));
  $twig->addFunction(new Twig\TwigFunction('site', 'site'));
  $twig->addFunction(new Twig\TwigFunction('page', 'page'));
  $twig->addFunction(new Twig\TwigFunction('pages', 'pages'));
  $twig->addFilter(new Twig\TwigFilter('kt', 'kirbytext', ['is_safe' => ['html']]));
  $twig->addFilter(new Twig\TwigFilter('kti', 'kirbytextinline', ['is_safe' => ['html']]));
  $twig->addFilter(new Twig\TwigFilter('excerpt', function ($text, $len = null) {
    $text = strval($text);
    $text = preg_split('/\n\h*\n/', $text);
    $text = array_filter($text, function ($p) {
      return $p and !preg_match('/^(\d+\.|[\-\+\*]\s|[#!\>])/', $p);
    });
    if (!$text) return null;
    $text = reset($text);
    $text = kirbytextinline($text);
    $text = strip_tags($text);
    $text = html_entity_decode($text);
    $text = preg_replace('/\n+/', ' ', $text);
    if ($len and mb_strlen($text) > $len) {
      $text = mb_substr($text, 0, $len);
      $text = preg_replace('/\W+$/u', '', $text);
      $append = '&hellip;';
    }
    return $text ? htmlspecialchars($text, ENT_COMPAT | ENT_HTML5) . ($append ?? '') : null;
  }, ['is_safe' => ['html']]));
  $twig->addGlobal('kirby', kirby());
  $twig->addGlobal('site', site());
  $twig->addGlobal('page', page());
  $twig->addGlobal('pages', pages());
  if (version_compare(\Kirby\Cms\App::version(), '3.4.0-rc.1', '<') === true) {
    kirby()->trigger('twig', $twig);
  } else {
    $twig_array = (array) $twig;
    kirby()->trigger('twig', $twig_array);
  }
  $twig->display("pages/${template}.twig", $data ?? []);
}
