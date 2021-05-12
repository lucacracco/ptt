(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.bootstrap = {
    attach: function (context, settings) {
      console.log("Bootstrap5 theme for Drupal!");
    }
  };

})(jQuery, Drupal, drupalSettings);