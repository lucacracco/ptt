let mix = require('laravel-mix');
require('laravel-mix-imagemin');

if (!mix.inProduction()) {
  mix.sourceMaps();
  mix.webpackConfig({
    devtool: 'inline-source-map'
  });
}
mix.options({
  processCssUrls: false
});

// Fonts.
mix
  .copyDirectory('source/fonts', 'dist/fonts');

// Javascripts.
mix
  .js('source/scripts/bootstrap-framework.js', 'dist/js')
  .js('source/scripts/bootstrap.js', 'dist/js')

// Scss.
mix
  .sass('source/scss/bootstrap.scss', 'dist/css/')
  .sass('source/scss/user.scss', 'dist/css');

// Minify all images, `optipng` with `optimizationLevel` 5, disabling
// `jpegtran`, and adding `mozjpeg`.
mix
  .imagemin(
    {
      from: 'source/images',
      to: 'dist/images'
    },
    {
      optipng: {
        optimizationLevel: 5
      },
      jpegtran: null,
      plugins: [
        require('imagemin-mozjpeg')({
          quality: 100,
          progressive: true,
        }),
      ],
    }
  );