<?php

/**
 * @file
 * Handles the form validation of the customer survey form
 * All hooks are in the .module file.
 */


/**
 * Master validation function for the customer survey form - uses per-stage 
 * validation and calls functions for each one.
 * 
 * @param type $form
 * @param type $form_state
 * @return type 
 */
function customer_certify_form_validate($form, &$form_state) {
    
  if ($form_state['triggering_element']['#value'] == 'Back') {
    return;
  }  
    
  switch ($form_state['stage']) { 
      
    case 'select_certify':
      return customer_certify_select_validate($form, $form_state);
     break;  
 
    case 'run_criteria': 
      return customer_certify_criteria_validate($form, $form_state);  
     break;

    case 'summary_request': 
      return customer_certify_summary_validate($form, $form_state);  
     break;
 
  }
}


/**
 * Validation for the rate_the_room step
 * 
 * @param type $form
 * @param type $form_state 
 */
function customer_certify_select_validate($form, &$form_state) {
  if (!$form_state['values']['product']) {
    form_set_error('product', 'You must enter Product before continuing');    
  }
  if (!$form_state['values']['company']) {
    form_set_error('company', 'You must enter Company before continuing');    
  }
  if (!$form_state['values']['name']) {
    form_set_error('name', 'You must enter Name before continuing');    
  }
  if (!$form_state['values']['phone']) {
    form_set_error('phone', 'You must enter Phone before continuing');    
  }
  if (!$form_state['values']['email']) {
    form_set_error('email', 'You must enter Email before continuing');    
  }
  if (!$form_state['values']['role']) {
    form_set_error('role', 'You must enter Role before continuing');    
  }
}


/**
 * Validation for the rate_the_service step
 * 
 * @param type $form
 * @param type $form_state 
 */
function customer_certify_criteria_validate($form, &$form_state) {
  if (!$form_state['values']['environment']) {
    form_set_error('environment', 'You must enter Deployment Environment before continuing');    
  }
  if (!$form_state['values']['trans_req']) {
    form_set_error('trans_req', 'You must enter Transaction Request Information before continuing');    
  }
  if (!$form_state['values']['trans_payload']) {
    form_set_error('trans_payload', 'You must enter Transaction Payload before continuing');    
  }
}


/**
 * Validation for the personal_details step
 * 
 * @param type $form
 * @param type $form_state 
 */
function customer_certify_summary_validate($form, &$form_state) {
  if (!$form_state['values']['all_valid']) {
    form_set_error('all_valid', 'You must enter a Confirmation before continuing');    
  }
  
}