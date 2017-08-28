<?php

/**
 * @file
 * Views integration for the DirectV Product Roles
 */

/**
 * Implements hook_views_data()
 *
 */
function directv_product_roles_views_data() {

  $table = array(
    'directv_api_product_roles' => array(
      'table' => array(
        'group' => 'DirectV',      // Groupname
        'base' => array(
          'field' => 'app_id',  //Primary key
          'title' => 'API Product Roles in portalRoles',
          'help' => 'API Product Roles in from custom attribute portalRoles'
        )
      ),
      'name' => array(
        'title' => t('API Product Machine Name'),
        'help' => t('Internal or machine-referenceable name for the app'),
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE, // This is use by the table display plugin.
        ),
        'sort' => array('handler' => 'views_handler_sort'),
        'filter' => array('handler' => 'views_handler_filter_string'),
        'argument' => array('handler' => 'views_handler_argument_string')
      ),
      'displayName' => array(
        'title' => t('API Product Display Name'),
        'help' => t('Human-readable name for the API Product'),
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE, // This is use by the table display plugin.
        ),
        'sort' => array('handler' => 'views_handler_sort'),
        'filter' => array('handler' => 'views_handler_filter_string'),
        'argument' => array('handler' => 'views_handler_argument_string')
      ),
      'portalRole' => array(
        'title' => t('API Product Role'),
        'help' => t('API Product Role retrieved from custom attribute'),
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE, // This is use by the table display plugin.
        ),
        'sort' => array('handler' => 'views_handler_sort'),
        'filter' => array('handler' => 'views_handler_filter_string'),
        'argument' => array('handler' => 'views_handler_argument_string')
      ),
      'approvalType' => array(
        'title' => t('API Product Approval Type'),
        'help' => t('API Product Approval Type'),
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE, // This is use by the table display plugin.
        ),
        'sort' => array('handler' => 'views_handler_sort'),
        'filter' => array('handler' => 'views_handler_filter_string'),
        'argument' => array('handler' => 'views_handler_argument_string')
      ),
      'apisDeployedIn' => array(
        'title' => t('APIs Deployed In'),
        'help' => t('Environment API Product deployed in'),
        'field' => array(
          'handler' => 'views_handler_field',
          'click sortable' => TRUE, // This is use by the table display plugin.
        ),
        'sort' => array('handler' => 'views_handler_sort'),
        'filter' => array('handler' => 'views_handler_filter_string'),
        'argument' => array('handler' => 'views_handler_argument_string')
      )
    )
  );

  // The 'group' index will be used as a prefix in the UI for any of this
  // table's fields, sort criteria, etc. so it's easy to tell where they came
  // from.
  $table['directv_content_roles']['table']['group'] = t('API Content Access Roles');

  // Define this as a base table – a table that can be described in itself by
  // views (and not just being brought in as a relationship). In reality this
  // is not very useful for this table, as it isn't really a distinct object of
  // its own, but it makes a good example.
  $table['directv_content_roles']['table']['base'] = array(
    'field' => 'nid', // This is the identifier field for the view.
    'title' => t('DirectV Content Access Roles.'),
    'help' => t('Store roles for content for views to utilize in relationships.'),
    'weight' => -10,
  );

  // This table references the {node} table. The declaration below creates an
  // 'implicit' relationship to the node table, so that when 'node' is the base
  // table, the fields are automatically available.
  $table['directv_content_roles']['table']['join'] = array(

    // Index this array by the table name to which this table refers.
    // 'left_field' is the primary key in the referenced table.
    // 'field' is the foreign key in this table.
    'node' => array(
      'left_field' => 'nid',
      'field' => 'nid',
    ),
  );

  // Node ID table field.
  $table['directv_content_roles']['nid'] = array(
    'title' => t('DirectV Content Access roles'),
    'help' => t('Store roles for content for views to utilize in relationships.'),

    // Define a relationship to the {node} table, so example_table views can
    // add a relationship to nodes. If you want to define a relationship the
    // other direction, use hook_views_data_alter(), or use the 'implicit' join
    // method described above.
    'relationship' => array(
      'base' => 'node', // The name of the table to join with.
      'base field' => 'nid', // The name of the field on the joined table.
      // 'field' => 'nid' -- see hook_views_data_alter(); not needed here.
      'handler' => 'views_handler_relationship',
      'label' => t('Default label for the relationship'),
      'title' => t('Title shown when adding the relationship'),
      'help' => t('More information on this relationship'),
    ),
  );

  // Example plain text field.
  $table['directv_content_roles']['view_any_roles'] = array(
    'title' => t('View Any Roles'),
    'help' => t('View Any Roles from Content Access.'),
    'field' => array(
//      'handler' => 'directv_product_roles_field_handler',
      'handler' => 'views_handler_field',
      'views_handler_field',
      'click sortable' => TRUE, // This is use by the table display plugin.
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  // Example plain text field.
  $table['directv_content_roles']['view_own_roles'] = array(
    'title' => t('View Own Roles'),
    'help' => t('View Own Roles from Content Access.'),
    'field' => array(
//      'handler' => 'directv_product_roles_field_handler',
      'handler' => 'views_handler_field',
      'click sortable' => TRUE, // This is use by the table display plugin.
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  return $table;
}

/**
 * Class emc_test_field_handler to handle links
 *
 */
class directv_product_roles_field_handler extends  views_handler_field {
  /**
   * Override Trim to alter text
   */
  function render_trim_text($alter, $value) {
    dpm($alter);
    dpm($value);
    return str_replace(",","<br>",$value);
  }
}

