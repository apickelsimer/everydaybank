<?php

function dexp_shortcodes_callout_shortcode_info(&$shortcodes) {
  $shortcodes['callout'] = array(
      'title' => t('Callout'),
      'description' => t('Create Callout shortcode'),
      'process callback' => 'dexp_shortcodes_callout',
      'tips callback' => 'dexp_shortcodes_callout_tips',
  );
}

function dexp_shortcodes_callout($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'class' => '', // Social name class 
      'icon' => '', // font awesome class 
      'title'=>'',
      'button' => ''), $attrs);
  $attrs['content'] = $text;
  return trim(theme('dexp_shortcodes_callout', $attrs));
}

function dexp_shortcodes_callout_theme(&$themes) {
  $path = drupal_get_path('module', 'dexp_shortcodes');
  $themes['dexp_shortcodes_callout'] = array(
      'template' => 'callout',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'dexp_shortcodes_preprocess_shortcode_callout',
      ),
      'variables' => array(
          'class' => '',
          'icon' => '',
          'title'=>'',
          'button' => '',
          'content' => '',
      )
  );
}

function dexp_shortcodes_preprocess_shortcode_callout(&$vars) {
  $vars['theme_hook_suggestions'][] = 'shortcode__callout';
}

function dexp_shortcodes_callout_tips($format, $long) {
  $output = "[callout class='' icon='' title='' button='']TEXT_HERE[/callout]";
  return $output;
}