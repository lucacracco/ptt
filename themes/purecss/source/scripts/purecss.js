(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.purecss = {
    attach: function (context, settings) {
      console.log("PureCSS theme for Drupal!");
    }
  };

})(jQuery, Drupal, drupalSettings);