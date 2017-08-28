<?php

function dexp_shortcodes_tab_testimonials_shortcode_info(&$shortcodes) {
  $shortcodes['tab_testimonials'] = array(
      'title' => t('Tab Testimonials'),
      'description' => t('Tabs testimonials wrapper'),
      'process callback' => 'dexp_shortcodes_tab_testimonials',
      'tips callback' => 'dexp_shortcodes_tab_testimonial_tips',
  );
}

/**
 * Shortcode tab group definition
 */
function dexp_shortcodes_tab_testimonials( $attrs, $content = null ) {
   extract(shortcode_attrs(array('class' => '',), $attrs));
   global $shortcode_tab_testimonials_stack;
   $tab_wrapper_id = "dexp_tab_wrapper_";
   $tab_wrapper_id .= rand();
   if ($class == "" || ($class != "noboder" && $class != "vertical")) {
      $class = "horizontal";
   }
   $output = '<div id="'.$tab_wrapper_id.'" class="dexp_tab_wrapper dexp_tab_testimonial_wrapper '.$class.' clearfix"> <ul class="nav nav-tabs">';
   $tabCount = 1;
   $xclass="";
   foreach ($shortcode_tab_testimonials_stack as $tab) {   
      if($tabCount == 1) { 
        $output .= '<li class="active first"><a href="#'.$tab["id"].'" data-toggle="tab"><img alt="" src='.$tab["image"].'></a></li>';
      } else {
	  if($tabCount==Count($shortcode_tab_testimonials_stack)){$xclass="last";}
        $output .= '<li class="'.$xclass.'"><a href="#'.$tab["id"].'" data-toggle="tab"><img alt="" src='.$tab["image"].'></a></li>';  
      }
      $tabCount = $tabCount + 1;
   }      
   $output .= '</ul>';
   $output .='<div class="tab-content">';
   
   $tabCount = 1;
   foreach ($shortcode_tab_testimonials_stack as $tab) {
      if($tabCount == 1) {  
        $output .= '<div id="'.$tab["id"].'" class="active tab-pane">';
      } else {
        $output .= '<div id="'.$tab["id"].'" class="tab-pane">';  
      }
      $tabCount = $tabCount + 1;
      $output .= '<p>'.$tab["contents"]["#markup"].'</p><div class="name">'.$tab["title"].'</div><div class="position">'.$tab["position"].'</div></div>';
   }
   $output .='</div></div>';
   $output .='<div class="clearfix"></div>';
   $shortcode_tab_testimonials_stack = null;
   return $output;  
}

function dexp_shortcodes_tab_testimonial_shortcode_info(&$shortcodes) {
  $shortcodes['tab_testimonial'] = array(
      'title' => t('Tab Testimonial'),
      'description' => t('Tab Testimonial item'),
      'process callback' => 'dexp_shortcodes_tab_testimonial',
  );
}

/**
 * Shortcode tab item definition
 */
function dexp_shortcodes_tab_testimonial( $attrs, $content = null ) {
  extract(shortcode_attrs(array('title' => '', 'image' => '', 'position' =>''), $attrs));
  $id_tab_item = "dexp_tab_item_";
  $id_tab_item .= rand();
  global $shortcode_tab_testimonials_stack;
  if (!is_array($shortcode_tab_testimonials_stack)) $shortcode_tab_testimonials_stack = array();
  $tabPane = array(
    'title' => $title,
    'image'  => $image,
    'position' =>$position,
    'id'    => $id_tab_item,
    'contents' => array(
      '#markup' => $content,
    ),
    'weight' => count($shortcode_tab_testimonials_stack),
  );
  $shortcode_tab_testimonials_stack[] = $tabPane;
}

function dexp_shortcodes_tab_testimonial_tips($format, $long) {
  $output = '[tab_testimonials class="horizontal OR vertical"][tab_testimonial title="Tab Title 1" image="" position=""] Your content1 here [/tab_testimonial][tab_testimonial title="Tab Title 2" image="" position=""] Your content2 here [/tab_testimonial][/tab_testimonials]';
  return $output;
}