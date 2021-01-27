// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js');
