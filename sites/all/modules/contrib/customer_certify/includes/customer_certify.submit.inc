<?php

/**
 * @file 
 * Handles the form submission of the customer survey form
 */


/**
 * Handles what to do with the submitted form depending on what stage has been
 * completed.
 * 
 * @see customer_certify_form()
 * @see customer_certify_form_validate()
 * 
 * @param type $form
 * @param type $form_state 
 */
function customer_certify_form_submit($form, &$form_state) {
  
  switch ($form_state['stage']) {
    
    case 'summary_request':
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      if ($form_state['triggering_element']['#value'] != 'Back') {
        customer_certify_summary_submit($form, $form_state);
        $form_state['complete'] = TRUE;
      }
     break;
 
    default:
      $form_state['multistep_values'][$form_state['stage']] = $form_state['values'];
      $form_state['new_stage'] = customer_certify_move_to_next_stage($form, $form_state);
     break;
 
  } 

  if (isset($form_state['complete'])) drupal_goto('complete-page');   
  
  if ($form_state['triggering_element']['#value'] == 'Back') {
    $form_state['new_stage'] = customer_certify_move_to_previous_stage($form, $form_state);
  } 
  
  if (isset($form_state['multistep_values']['form_build_id'])) {
    $form_state['values']['form_build_id'] = $form_state['multistep_values']['form_build_id'];
  }
  $form_state['multistep_values']['form_build_id'] = $form_state['values']['form_build_id'];
  $form_state['stage'] = $form_state['new_stage'];
  $form_state['rebuild'] = TRUE;
    
}

 /**
  * Handles the submission of the final stage
  * 
  * Sends an email to the user confirming their entry
  * 
  * @param type $form
  * @param type $form_state 
  */
function customer_certify_summary_submit($form, &$form_state) {
  
  $multstep_values = $form_state['multistep_values'];
    
  $module = 'customer_certify';
  $key = 'customer_certify_complete';

  $to = $multstep_values['select_certify']['email'] . '; ' . variable_get('site_mail', 'admin@example.com');
  $from = variable_get('site_mail', 'admin@example.com');

  $params = array(
    'body' => 'Thank you for submiting your certification. You have now been submitted into the process.',
    'subject' => 'You have participated in the certification process, ' . $multstep_values['select_certify']['name'],  
  );
 
  $date = new DateTime('now');
  $date->setTimezone(new DateTimeZone('UTC'));
  $str_dt = 'req_' . $date->format('YmdHis');
  $data = array('name' => $str_dt,
                'user' => $multstep_values['select_certify']['name'], 
                'company' => $multstep_values['select_certify']['company'],
                'phone' => $multstep_values['select_certify']['phone'],
                'email' => $multstep_values['select_certify']['email'],
                'product' => $multstep_values['select_certify']['product'],
                'role' => $multstep_values['select_certify']['role'],
                'environment' => $multstep_values['run_criteria']['environment'],
                'request_info' => $multstep_values['run_criteria']['trans_req'],
                'payload' => $multstep_values['run_criteria']['trans_payload']
                );
  $url = 'https://everydaybank-test.apigee.net/v1/certification/cert_submits';
  $rep = drupal_http_request($url, array(
          'method' => 'POST',
          'data' => json_encode($data),
          'headers' => array('Content-Type' => 'application/json','Accept' => 'application/json'))
  );
  

  $language = language_default();
  $send = TRUE;
  $result = drupal_mail($module, $key, $to, $language, $params, $from, $send);

  if ($result['result'] == TRUE) {
    drupal_set_message(t('Your message has been sent.'));
  }
  else {
    drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
  }
    
}

/**
 * Returns what to show on the completion page.
 * 
 * @return type 
 */
function customer_certify_status() {
  $usr_mail = $user->mail;
//  $usr_mail = 'cobregon@apigee.com';
  $data_ql = 'ql=select * where email="' . $usr_mail . '"';
  $opts = array(
                'method' => 'GET',
                 'data' => $data_ql,
                'headers' => array('Content-Type' => 'application/json','Accept' => 'application/json'));

  $urlrpt =  'https://everydaybank-test.apigee.net/v1/certification/cert_statuses';
  $rsl = drupal_http_request($urlrpt, $opts);
  return $rsl->data;
    
}

/**
 * Returns what to show on the completion page.
 * 
 * @return type 
 */
function customer_certify_complete() {

  return 'Thank you for completing our certification. You have been sent an email confirming you\'ve been through the certification process and status.';  
    
}
