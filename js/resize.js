/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

/**
 * Drupal behaviour to correct admin menu positions on smaller
 * screen sizes.
 */
(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.uconn_theme_resize = {
  attach: function(context, settings) {
    // Custom code to handle the admin menu on 
    // Page resize.
    function update_header_position() {
      if ($('#admin-menu').length > 0) {
        $('#page').css('margin-top', $('#admin-menu').height());
      }
      else if ($('#toolbar').length > 0) {
        $('#toolbar').css('margin-top', $('#admin-menu').height());
      }
    }
    $(window).resize(function() {
      update_header_position();
    });
  }
};
})(jQuery, Drupal, this, this.document);
