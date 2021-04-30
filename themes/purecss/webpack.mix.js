let mix = require('laravel-mix');

if (!mix.inProduction()) {
  mix.sourceMaps();
  mix.webpackConfig({
    devtool: 'inline-source-map'
  });
}

mix
  .js('source/scripts/purecss.js', 'dist/js');

mix
  .sass('source/scss/purecss.scss', 'dist/css/')
  .sass('source/scss/components/user.scss', 'dist/css/components');