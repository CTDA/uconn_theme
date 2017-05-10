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
  $form['simple']['islandora_simple_search_query']['#title_display'] = 'invisible';

  $deposit_text = theme_get_setting('deposit_branding_text');
  $deposit = array(
    '#markup' => l(t($deposit_text), theme_get_setting('uconn_deposit_text_link'), array('attributes' => array('class' => array('adv_deposit', 'form-submit'), 'type' => 'submit'))),
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
  // Add content to the templates when using SPARQL or Legacy backend display.
  uconn_theme_collection_page_content($variables);
}

/**
 * Implements hook_preprocess_islandora_objects_subset().
 */
function uconn_theme_preprocess_islandora_objects_subset(&$variables) {
  // Add content to the templates when using SOLR backend display.
  uconn_theme_collection_page_content($variables);
}

/**
 * Helper function to set up content on collection pages.
 * @param array $variables
 *   Set of template preprocess variables.
 */
function uconn_theme_collection_page_content(&$variables) {
  if (!isset($variables['islandora_object'])) {
    $variables['islandora_object'] = menu_get_object('islandora_object', 2);
  }

  $variables['meta_description'] = islandora_solr_metadata_description_callback($variables['islandora_object']);
  $dsid = theme_get_setting('collection_image_ds');

  if (isset($variables['islandora_object'][$dsid])) {
    $variables['collection_image_ds'] = theme_get_setting('collection_image_ds');
  }

  $view = views_get_view('clone_of_islandora_usage_stats_for_collections');
  if (isset($view)) {

    // If our view exists, then set the display.
    $view->set_display('block');
    $view->pre_execute();
    $view->execute();

    // Rendering will return the HTML of the the view
    $output = $view->render();

    // Pass our view results in to our template.
    $variables['islandora_latest_objects']  = $output;
  }

  // Add classes to our display switcher, so they are easier to theme.
  if (isset($variables['display_links'])) {
    foreach ($variables['display_links'] as $key => &$values) {
      if ($values['title'] == 'Grid view') {
        $values['attributes']['class'][] = 'islandora-view-grid';
      }
      if ($values['title'] == 'List view') {
        $values['attributes']['class'][] = 'islandora-view-list';
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
