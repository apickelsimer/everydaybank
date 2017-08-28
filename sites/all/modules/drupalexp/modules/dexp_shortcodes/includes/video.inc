<?php

function dexp_shortcodes_video_shortcode_info(&$shortcodes) {
  $shortcodes['video'] = array(
      'title' => t('Video'),
      'description' => t('Create Video Shortcode'),
      'process callback' => 'dexp_shortcodes_video',
  );
}

function dexp_shortcodes_video($attrs, $text) {
  $attrs = shortcode_attrs(array(
      'title' => '',
      'file' => '',
      'type' => 'local', //local|youtube|vimeo
      'video_id' => '',
          ), $attrs);
  $attrs['content'] = $text;
  return trim(theme('dexp_shortcodes_video', $attrs));
}

function dexp_shortcodes_video_theme(&$themes) {
  $path = drupal_get_path('module', 'dexp_shortcodes');
  $themes['dexp_shortcodes_video'] = array(
      'template' => 'video',
      'path' => $path . '/theme',
      'pattern' => 'shortcode__',
      'preprocess functions' => array(
          'template_preprocess',
          'dexp_shortcodes_preprocess_shortcode_video',
      ),
      'variables' => array(
          'title' => '',
          'file' => '',
          'type' => 'local', //local|youtube|vimeo
          'video_id' => '',
          'content' => '',
      )
  );
}

function dexp_shortcodes_preprocess_shortcode_video(&$vars) {
  $vars['theme_hook_suggestions'][] = 'shortcode__video';
}