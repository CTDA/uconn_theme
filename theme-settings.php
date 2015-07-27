<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function uconn_theme_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }
  $form['uconn_theme_custom'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom Settings'),
    '#weight' => 5,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['uconn_theme_custom']['uconn_branding_text'] = array(
    '#type' => 'textfield',
    '#title' => t('Branding header text.'),
    '#default_value' => (theme_get_setting('uconn_branding_text') ? theme_get_setting('uconn_branding_text') : "UCONN"),
    '#description' => t("Text in the header branding area, defaults to UCONN."),
  );
  $form['uconn_theme_custom']['uconn_branding_text_university'] = array(
    '#type' => 'textfield',
    '#title' => t('Branding university text.'),
    '#default_value' => (theme_get_setting('uconn_branding_text_university') ? theme_get_setting('uconn_branding_text_university') : "UNIVERSITY OF CONNECTICUT"),
    '#description' => t("Text in the header branding area, defaults to UNIVERSITY OF CONNECTICUT."),
  );
  $form['uconn_theme_custom']['uconn_branding_text_link'] = array(
    '#type' => 'textfield',
    '#title' => t('Link the branding text.'),
    '#default_value' => (theme_get_setting('uconn_branding_text_link') ? theme_get_setting('uconn_branding_text_link') : "research.lib.uconn.edu"),
    '#description' => t("Link the branding text to a paticular website, defaults to research.lib.uconn.edu."),
  );
  $form['uconn_theme_custom']['collection_level'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom Collection level options'),
    '#weight' => 6,
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['uconn_theme_custom']['collection_level']['collection_image_ds'] = array(
    '#type' => 'textfield',
    '#title' => t('Collection Level Image.'),
    '#default_value' => (theme_get_setting('collection_image_ds') ? theme_get_setting('collection_image_ds') : "TN"),
    '#description' => t("The collection level objects datastream id (DSID) to use as an image on the collection landing page."),
  );
}
