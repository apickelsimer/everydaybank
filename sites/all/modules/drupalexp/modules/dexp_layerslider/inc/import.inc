<?php

function dexp_layerslider_import_form() {
  $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title')
  );
  $form['file'] = array(
      '#type' => 'file',
      '#title' => t('Import file'),
      '#description' => t('.txt file'),
  );
  $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Import'
  );
  return $form;
}

function dexp_layerslider_import_form_submit(&$form, $form_state) {
  $title = $form['title']['#value'];
  $data = $form['data']['#value'];
  if ($_FILES['files']['name']['file']) {
    $validators = array('file_validate_extensions' => array('txt'));
    $field = 'file';
    if (!($finfo = file_save_upload($field, $validators))) {
      // Failed to upload the file. file_save_upload() calls form_set_error() on
      // failure.
      drupal_set_message('Import failed.','error');
      return;
    }
    $data = file_get_contents($finfo->uri);
    file_delete($finfo);
  }else{
    drupal_set_message('Import failed.','error');
    return;
  }
  $json = base64_decode($data);
  $slideshow = json_decode($json);
  for ($i = 0; $i < count($slideshow->slides); $i++) {
    if (!empty($slideshow->slides[$i]->background_image_uri)) {
			if (isset($slideshow->slides[$i]->image_content)) {
				dexp_layerslider_base64toimage($slideshow->slides[$i]->image_content, $slideshow->slides[$i]->background_image_uri);
        unset($slideshow->slides[$i]->image_content);
      }
    }
    for ($j = 0; $j < count($slideshow->slides[$i]->layers); $j++) {
      if ($slideshow->slides[$i]->layers[$j]->type == 'image' && !empty($slideshow->slides[$i]->layers[$j]->image_uri)) {
        if (isset($slideshow->slides[$i]->layers[$j]->image_content)) {
          dexp_layerslider_base64toimage($slideshow->slides[$i]->layers[$j]->image_content, $slideshow->slides[$i]->layers[$j]->image_uri);
          unset($slideshow->slides[$i]->layers[$j]->image_content);
        }
      }
    }
  }
	db_insert('dexp_layerslider')->fields(array(
      'name' => $title,
      'settings' => base64_encode(json_encode($slideshow->settings)),
      'data' => base64_encode(json_encode($slideshow->slides)),
  ))->execute();
  drupal_set_message('Import was successful');
  drupal_goto('admin/dexp_layerslider');
}

function dexp_layerslider_base64toimage($str, $file) {
	$str = base64_decode($str);
  file_unmanaged_save_data($str, $file, FILE_EXISTS_REPLACE);
	return $file;
}
