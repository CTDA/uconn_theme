/**
 * @file
 * Drupal behaviour to controll column height of front page views.
 */

/**
 * Drupal behaviour to correct column heights on the front page. Not a huge fan of this solution, but with
 * Zen grids, there really isent one just yet that isent more hacky.
 */
(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.matchHeight = {
  attach: function(context, settings) {
    $(window).load(function() {
      $('.match-height div.block-inner-wrapper').matchHeight();
    });
  }
};
})(jQuery, Drupal, this, this.document);
