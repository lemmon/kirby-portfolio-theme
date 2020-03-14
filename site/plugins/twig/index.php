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
  $twig->addGlobal('kirby', kirby());
  $twig->addGlobal('site', site());
  $twig->addGlobal('page', page());
  $twig->addGlobal('pages', pages());
  kirby()->trigger('twig', $twig);
  $twig->display("pages/${template}.twig", $data ?? []);
}
