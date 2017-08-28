<?php
/**
 * @file
 * dexp_shoot_commerce.features.inc
 */

/**
 * Implements hook_views_api().
 */
function dexp_shoot_commerce_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_flag_default_flags().
 */
function dexp_shoot_commerce_flag_default_flags() {
  $flags = array();
  // Exported flag: "Wishlist".
  $flags['wishlist'] = array(
    'entity_type' => 'commerce_product',
    'title' => 'Wishlist',
    'global' => 0,
    'types' => array(
      0 => 'product',
    ),
    'flag_short' => '<i class=\'fa fa-heart\'></i>',
    'flag_long' => 'Add to Wishlist',
    'flag_message' => '',
    'unflag_short' => '<i class="fa fa-trash-o"></i>',
    'unflag_long' => 'Remove from Wishlist',
    'unflag_message' => '',
    'unflag_denied_text' => '',
    'link_type' => 'toggle',
    'weight' => 0,
    'show_in_links' => array(
      'full' => 'full',
      'node_full' => 'node_full',
      'node_teaser' => 'node_teaser',
      'token' => 0,
      'line_item' => 0,
      'commerce_line_item_display' => 0,
      'commerce_line_item_token' => 0,
      'node_rss' => 0,
      'node_search_index' => 0,
      'node_search_result' => 0,
      'node_dexp_portfolio' => 0,
      'node_time_line' => 0,
      'node_large' => 0,
      'node_gallery' => 0,
      'node_medium' => 0,
      'node_hover_image' => 0,
      'node_popup_image' => 0,
      'node_portfolio_bxslider' => 0,
      'node_product_sidebar' => 0,
      'node_token' => 0,
    ),
    'show_as_field' => 1,
    'show_on_form' => 0,
    'access_author' => '',
    'show_contextual_link' => 0,
    'api_version' => 3,
    'module' => 'dexp_shoot_commerce',
    'locked' => array(
      0 => 'name',
    ),
  );
  return $flags;

}

/**
 * Implements hook_node_info().
 */
function dexp_shoot_commerce_node_info() {
  $items = array(
    'product_display' => array(
      'name' => t('Product Display'),
      'base' => 'node_content',
      'description' => t('This content type is used for show product on page'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
