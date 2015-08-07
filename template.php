<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

/**
 * Implements hook_theme_preprocess_region().
 */
function uconn_theme_preprocess_region(&$variables) {
  $function = 'uconn_theme_preprocess_region_'.$variables['region'];
  if (function_exists($function)) {
    $function($variables);
  }
}

/**
 * Theme preprocessing function for region 'branding'.
 * @param array $variables
 *   Region specific variables.
 */
function uconn_theme_preprocess_region_branding(&$variables) {
  $variables['branding_text_left'] = theme_get_setting('uconn_branding_text');
  $variables['branding_text_right'] = theme_get_setting('uconn_branding_text_university');
  $variables['branding_text_link'] = theme_get_setting('uconn_branding_text_link');
}

/**
 * Implements hook_form_alter().
 */
function uconn_theme_form_islandora_solr_simple_search_form_alter(&$form, &$form_state, $form_id) {
  $form['simple']['islandora_simple_search_query']['#attributes']['size'] = 15;
  $form['simple']['islandora_simple_search_query']['#attributes']['placeholder'] = t("Search Repository");
  $deposit = array(
    '#markup' => l(t("Deposit"), theme_get_setting('uconn_deposit_text_link'), array('attributes' => array('class' => array('adv_deposit', 'form-submit'), 'type' => 'submit'))),
  );
  $link = array(
    '#markup' => l(t("Advanced Search"), "advanced-search", array('attributes' => array('class' => array('adv_search')))),
  );
  $form['simple']['islandora_simple_search_query']['#prefix'] = drupal_render($deposit);
  $form['simple']['islandora_simple_search_query']['#suffix'] = drupal_render($link);

}

/**
 * Implements hook_preprocess().
 */
function uconn_theme_preprocess_islandora_basic_collection_wrapper(&$variables) {
  $dsid = theme_get_setting('collection_image_ds');
  if (isset($variables['islandora_object'][$dsid])) {
    $variables['collection_image_ds'] = theme_get_setting('collection_image_ds');
  }
  if (in_array("islandora:collectionCModel", $variables['islandora_object']->{models})) {
    array_push($variables['associated_objects_array'][$key]['classes'], 'islandora-default-thumb');
    if (module_exists('dgi_ondemand')) {
      $block = module_invoke('dgi_ondemand', 'block_view', 'dgi_ondemand_latest_obj');
      $data = render($block['content']);
      if (!empty($data)) {
        $variables['islandora_latest_objects'] = $data;
      }
    }
  }
}

/**
 * Implements hook_preprocess_block().
 */
function uconn_theme_preprocess_block(&$variables) {
  if ($variables['block']->delta === 'basic_facets') {
    $variables['elements']['#block']->{'subject'} = t("Refine My Results");
  }
}

/**
 * Implements hook_preprocess_page().
 */
function uconn_theme_preprocess_page(&$variables) {
  $path = current_path();
  $path_array = explode("/", $path);

  // Add script to the front page, to control the height of the three columns at the bottom.
  // Does not work natively in Zen grids, so this is required.
  if (drupal_is_front_page()) {
    $theme_path = drupal_get_path('theme',$GLOBALS['theme']);
    drupal_add_js("$theme_path/js/jquery.matchHeight-min.js");
    drupal_add_js("$theme_path/js/matchHeightBehaviour.js");
  }

  // Selectively add class to content, edge case requires particular
  // Styling on the search result page. Set here so it is always
  // Available.
  $variables['inner_page_wrapper'] = "";
  if (count($path_array) >= 2) {
    if ($path_array[0] == 'islandora' && $path_array[1] == 'search'){
      global $_islandora_solr_queryclass;
      $sr = new IslandoraSolrResults();
      $secondary_display_profiles = $sr->addSecondaries($_islandora_solr_queryclass);
      $default_rss_icon_location = "/sites/all/modules/islandora_solr_search/islandora_solr_config/images/rss.png";
      $new_rss_icon_location = "/" . drupal_get_path('theme', 'uconn_theme') . '/images/rss_w.png';

      $secondary_display_profiles = str_replace(
        $default_rss_icon_location,
        $new_rss_icon_location,
        $secondary_display_profiles
      );

      if (isset($secondary_display_profiles)) {
        $variables['secondary_display_profiles'] = $secondary_display_profiles;
      }

      $variables['inner_page_wrapper'] = "inner-page-wrapper";
    }
  }
}
