module.exports = {
  content: [
    'site/**/*.twig',
    'site/plugins/**/*.php',
  ],
  css: ['static/master.css'],
  output: 'static/master.css',
  defaultExtractor: (x) => x.match(/[\w-/:]+(?<!:)/g) || [],
  safelist: ['-d', '-view'],
}
