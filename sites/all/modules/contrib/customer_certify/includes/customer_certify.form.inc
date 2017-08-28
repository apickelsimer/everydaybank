<?php

/**
 * @file
 * Handles the form elements of the customer survey form
 * All hooks are in the .module file.
 */

/**
 * Master form which calls an individual form for each step.
 * 
 * @see customer_certify_form_validate().
 * @see customer_certify_form_submit().
 * 
 * @param type $form
 * @param string $form_state
 * @return type 
 */
function customer_certify_form($form, &$form_state) {
     
  drupal_add_css(drupal_get_path('module', 'customer_certify') . '/css/customer_certify.css');
  if (!isset($form_state['stage'])) $form_state['stage'] = 'select_certify';
 
  $form = array();
  $form = customer_certify_get_header($form, $form_state);

  switch ($form_state['stage']) {
    
    case 'select_certify':
      return customer_certify_select_form($form, $form_state);
     break;  
 
    case 'run_criteria': 
      return customer_certify_criteria_form($form, $form_state);  
     break;
 
    case 'summary_request': 
      return customer_certify_summary_form($form, $form_state);  
     break;
 
    default:
      return customer_certify_select_form($form, $form_state);
     break; 
  }
  
  return $form;
    
}


function customer_certify_load_apps($myapps) {
  global $user;  
  $module_path = drupal_get_path('module', 'devconnect_developer_apps');

  $path = libraries_get_path('jquery.selectlist');
  drupal_add_js(array('devconnect_developer_apps' => array('selectlist' => 'true')), 'setting');
  drupal_add_js($path . '/scripts/jquery.selectlist.min.js');
  drupal_add_js($module_path . '/devconnect_developer_apps.js');

  $app_entities = entity_load('developer_app', FALSE, array('mail' => $user->mail));

  $tmp_apps = array();
  foreach ($app_entities as $entity) {
    $aCnt = count($entity->credentialApiProducts);
    if ( $aCnt > 0 ) {
      if (!array_key_exists($entity->name,$tmp_apps)){
//        $tmp_apps[] = array(
//          $entity->name => $entity->attributes['DisplayName']);
        $tmp_apps[$entity->name] = $entity->attributes['DisplayName'];      
      }
    }
  }
  $myapps = $tmp_apps;
  return $myapps;
}

/**
 * Form for the rate_the_room step.
 * 
 * @see customer_certify_form().
 *  
 * @param type $form
 * @param type $form_state
 * @return type 
 */
function customer_certify_select_form($form, &$form_state) {
  $myapps = array();
  $my_apps = customer_certify_load_apps($myapps);

  $values = isset($form_state['multistep_values']['select_certify']) ? $form_state['multistep_values']['select_certify'] : array();

  $form['select_certify']['product'] = array(
    '#type' => 'select',
    '#title' => t('Which Product are you testing against?'),
//    '#options' => array('data-cash' => t('Data Cash'), 'merchants' => t('Merchants'), 'money-send' => t('Money Send'), 'offers' => t('Offers'), 'payments' => t('Payments')),
    '#options' => $my_apps,
    '#default_value' => isset($values['product']) ? $values['product'] : NULL,
  );    

 $form['select_certify']['company'] = array(
    '#type' => 'textfield',
    '#title' => 'Company',
    '#default_value' => isset($values['company']) ? $values['company'] : NULL,
  );

 $form['select_certify']['name'] = array(
    '#type' => 'textfield',
    '#title' => 'Name',
    '#default_value' => isset($values['name']) ? $values['name'] : NULL,
  );
  
 $form['select_certify']['phone'] = array(
    '#type' => 'textfield',
    '#title' => 'Phone',
    '#default_value' => isset($values['phone']) ? $values['phone'] : NULL,
  );
  
 $form['select_certify']['email'] = array(
    '#type' => 'textfield',
    '#title' => 'Email',
    '#default_value' => isset($values['email']) ? $values['email'] : NULL,
  );
  
 $form['select_certify']['role'] = array(
    '#type' => 'textfield',
    '#title' => 'Role',
    '#default_value' => isset($values['role']) ? $values['role'] : NULL,
  );
  
  $form['next'] = array(
    '#type' => 'submit',
    '#value' => t('Next')
  );
    
  return $form;
}


/**
 * Form for the rate_the_service step.
 * 
 * @see customer_certify_form().
 *  
 * @param type $form
 * @param type $form_state
 * @return type 
 */
function customer_certify_criteria_form($form, &$form_state) {
    
  $values = isset($form_state['multistep_values']['run_criteria']) ? $form_state['multistep_values']['run_criteria'] : array();

  $form['run_criteria']['environment'] = array(
    '#type' => 'radios',
    '#title' => 'Which envionment are you running against?',
    '#options' => array('dev' => t('Development'), 'test' => t('Test'), 'qa' => t('QA'), 'prod' => t('Production')),
    '#default_value' => isset($values['environment']) ? $values['environment'] : NULL,
  );

  $form['run_criteria']['trans_req'] = array(
    '#type' => 'textfield',
    '#title' => 'Transaction Request Info',
    '#default_value' => isset($values['trans_req']) ? $values['trans_req'] : NULL,
  );
  
  $form['run_criteria']['trans_payload'] = array(
    '#type' => 'textfield',
    '#title' => 'Transaction Payload',
    '#default_value' => isset($values['trans_payload']) ? $values['trans_payload'] : NULL,
  );
  
  $form['back'] = array(
    '#type' => 'submit',
    '#value' => t('Back')
  );
  
  $form['next'] = array(
    '#type' => 'submit',
    '#value' => t('Next')
  );
    
  return $form;
}


/**
 * Form for the summary_request step.
 * 
 * @see customer_certify_form().
 *  
 * @param type $form
 * @param type $form_state
 * @return type 
 */
function customer_certify_summary_form($form, &$form_state) {

  $values = isset($form_state['multistep_values']['summary_request']) ? $form_state['multistep_values']['summary_request'] : array();


  $form['summary_request']['all_valid'] = array(
    '#type' => 'radios',
    '#title' => 'All entries valid?',
    '#options' => array('no' => t('No'), 'yes' => t('Yes')),
    '#default_value' => isset($values['all_valid']) ? $values['all_valid'] : NULL,
  );
 
  $form['back'] = array(
    '#type' => 'submit',
    '#value' => t('Back')
  );
  
  $form['next'] = array(
    '#type' => 'submit',
    '#value' => t('Submit')
  );
  
  return $form;
}
