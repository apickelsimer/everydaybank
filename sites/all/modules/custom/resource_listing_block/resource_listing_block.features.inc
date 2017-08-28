<?php
/**
 * @file
 * resource_listing_block.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function resource_listing_block_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "context" && $api == "context") {
    return array("version" => "3");
  }
}

/**
 * Implements hook_views_api().
 */
function resource_listing_block_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_node_info().
 */
function resource_listing_block_node_info() {
  $items = array(
    'smart_method' => array(
      'name' => t('SmartDocs Method'),
      'base' => 'node_content',
      'description' => t('Describes all API methods handled by SmartDocs.'),
      'has_title' => '1',
      'title_label' => t('Name'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
