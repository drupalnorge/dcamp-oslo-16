;(function($) {
  'use strict';
  var windowHeight = $(window).height();
  Drupal.behaviors.themeCustom = {
    attach: function (context) {
      $(context).find('#home').css('height', windowHeight);
    }
  }
})(jQuery);