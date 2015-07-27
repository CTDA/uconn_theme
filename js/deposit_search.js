/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

/**
 * Drupal behaviour to trigger submit of simple search when
 * Deposit link is clicked.
 */
(function ($, Drupal, window, document, undefined) {
Drupal.behaviors.uconn_theme_deposit = {
  attach: function(context, settings) {
    var form = $('#islandora-solr-simple-search-form');
    // Attach mousedown() to the custom link in order to activate.
    $('.adv_deposit').click(function(e) {
      e.preventDefault();
      $('#edit-submit').trigger('click'); 
    });
  }
};
})(jQuery, Drupal, this, this.document);
