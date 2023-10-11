/* eslint-disable import/no-extraneous-dependencies */
const mix = require("laravel-mix");

require("laravel-mix-polyfill");
require("laravel-mix-eslint");

/**
 * Setup Mix
 */
mix
  .setPublicPath("assets/dist/")
  .setResourceRoot("../")
  .sourceMaps(false, "inline-source-map")
  .eslint({
    fix: false,
    cache: false,
  })
  .options({
    // because mix versions fonts in css and doesn't add them to the manifest so I can't preload them
    processCssUrls: false,
  })
  .polyfill({
    enabled: true,
    useBuiltIns: "usage",
  });

/**
 * Compile CSS
 */
mix.sass("assets/src/scss/app.scss", "assets/dist/css").version();

/**
 * Copy assets
 */
mix
  .copyDirectory("assets/src/fonts", "assets/dist/fonts")
  .copyDirectory("assets/src/img", "assets/dist/img");

/**
 * Compile our main JS file
 */
mix.js("assets/src/js/app.js", "assets/dist/js").extract();
