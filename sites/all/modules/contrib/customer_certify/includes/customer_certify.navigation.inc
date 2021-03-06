<?php 

/**
 * @file
 * Handles the navigation of the customer survey form
 * All hooks are in the .module file.
 */


/**
 * Generate a header which informs the user of which stage they're on.
 * 
 * @param type $form
 * @param type $form_state
 * @return type 
 */
function customer_certify_get_header($form, &$form_state) {
  
  $form_state['stage'] = isset($form_state['stage']) ? $form_state['stage'] : 1;  
    
  $form_stages = array(
    'select_certify' => 1,
    'run_criteria' => 2,
    'summary_request' => 3,
  ); 
    
  if (isset($form_stages[$form_state['stage']])) {
   $current_step = $form_stages[$form_state['stage']]; 
  }
  else {
   $current_step = 1;
  }
  
  $stages = array(
    1 => array('data' => '1. Product Selection for Certification'),
    2 => array('data' => '2. Test Run Criteria'),
    3 => array('data' => '3. Summary of Request'),
  );
  
  $stages[$current_step]['class'] = array('active');
  
  $stages_list = theme('item_list', array('items' => $stages));
  
  $form['header'] = array(
    '#type' => 'fieldset',
    '#title' => '',
    '#value' => $stages_list,
  );

  return $form;
  
}


/**
 * Given the current stage the user is on, calculate what the next step would be
 * 
 * @param type $form_state
 * @return string 
 */
function customer_certify_move_to_next_stage($form, &$form_state) {

  switch ($form_state['stage']) {
    case 'select_certify':
      return 'run_criteria';
     break;

    case 'run_criteria':
      return 'summary_request';
     break; 
  }

}


/**
 * Given the current stage the user is on, calculate what the previous step
 * would be
 * 
 * @param type $form_state
 * @return string 
 */

function customer_certify_move_to_previous_stage($form, &$form_state) {

  switch ($form_state['stage']) {
    case 'run_criteria':
      return 'select_certify';
     break;

    case 'summary_request':
      return 'run_criteria';
     break;
  }
    
}