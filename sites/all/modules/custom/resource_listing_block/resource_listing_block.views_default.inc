<?php
/**
 * @file
 * resource_listing_block.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function resource_listing_block_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'resource_listing';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'Resource Listing';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Resource Listing';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'none';
  $handler->display->display_options['style_plugin'] = 'views_accordion';
  $handler->display->display_options['style_options']['grouping'] = array(
    0 => array(
      'field' => 'field_smart_method_tags',
      'rendered' => 1,
      'rendered_strip' => 0,
    ),
  );
  $handler->display->display_options['style_options']['use-grouping-header'] = 1;
  $handler->display->display_options['style_options']['collapsible'] = 1;
  $handler->display->display_options['style_options']['row-start-open'] = '0';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Field: Content: Tags */
  $handler->display->display_options['fields']['field_smart_method_tags']['id'] = 'field_smart_method_tags';
  $handler->display->display_options['fields']['field_smart_method_tags']['table'] = 'field_data_field_smart_method_tags';
  $handler->display->display_options['fields']['field_smart_method_tags']['field'] = 'field_smart_method_tags';
  $handler->display->display_options['fields']['field_smart_method_tags']['label'] = '';
  $handler->display->display_options['fields']['field_smart_method_tags']['exclude'] = TRUE;
  $handler->display->display_options['fields']['field_smart_method_tags']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['field_smart_method_tags']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_smart_method_tags']['delta_offset'] = '0';
  /* Field: Content: HTTP verb */
  $handler->display->display_options['fields']['field_smart_method_verb']['id'] = 'field_smart_method_verb';
  $handler->display->display_options['fields']['field_smart_method_verb']['table'] = 'field_data_field_smart_method_verb';
  $handler->display->display_options['fields']['field_smart_method_verb']['field'] = 'field_smart_method_verb';
  $handler->display->display_options['fields']['field_smart_method_verb']['label'] = '';
  $handler->display->display_options['fields']['field_smart_method_verb']['exclude'] = TRUE;
  $handler->display->display_options['fields']['field_smart_method_verb']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['field_smart_method_verb']['type'] = 'taxonomy_term_reference_plain';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['title']['alter']['text'] = '[field_smart_method_verb] [title]';
  $handler->display->display_options['fields']['title']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['title']['alter']['ellipsis'] = FALSE;
  $handler->display->display_options['fields']['title']['element_label_colon'] = FALSE;
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Contextual filter: Content: Model (field_smart_method_model) */
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['id'] = 'field_smart_method_model_tid';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['table'] = 'field_data_field_smart_method_model';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['field'] = 'field_smart_method_model_tid';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_argument_type'] = 'taxonomy_tid';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_argument_options']['term_page'] = FALSE;
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_argument_options']['node'] = TRUE;
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_argument_options']['limit'] = TRUE;
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['default_argument_options']['vocabularies'] = array(
    'smartdocs_models' => 'smartdocs_models',
  );
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['field_smart_method_model_tid']['summary_options']['items_per_page'] = '25';
  /* Filter criterion: Content: Published */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'smart_method' => 'smart_method',
  );

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');
  $export['resource_listing'] = $view;

  return $export;
}
