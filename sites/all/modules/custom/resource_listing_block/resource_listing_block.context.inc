<?php
/**
 * @file
 * resource_listing_block.context.inc
 */

/**
 * Implements hook_context_default_contexts().
 */
function resource_listing_block_context_default_contexts() {
  $export = array();

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'api_model_resource_listing';
  $context->description = 'This context is to enable the resource listing block on each API Model Method page';
  $context->tag = 'smartdocs';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'smart_method' => 'smart_method',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-resource_listing-block' => array(
          'module' => 'views',
          'delta' => 'resource_listing-block',
          'region' => 'sidebar_first',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('This context is to enable the resource listing block on each API Model Method page');
  t('smartdocs');
  $export['api_model_resource_listing'] = $context;

  return $export;
}
