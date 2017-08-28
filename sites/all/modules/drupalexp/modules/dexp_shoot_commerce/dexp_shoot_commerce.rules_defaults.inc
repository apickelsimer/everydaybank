<?php
/**
 * @file
 * dexp_shoot_commerce.rules_defaults.inc
 */

/**
 * Implements hook_default_rules_configuration().
 */
function dexp_shoot_commerce_default_rules_configuration() {
  $items = array();
  $items['rules_discount'] = entity_import('rules_config', '{ "rules_discount" : {
      "LABEL" : "Discount",
      "PLUGIN" : "reaction rule",
      "OWNER" : "rules",
      "REQUIRES" : [ "rules", "commerce_line_item", "commerce_product_reference" ],
      "ON" : { "commerce_product_calculate_sell_price" : [] },
      "IF" : [
        { "entity_has_field" : { "entity" : [ "commerce-line-item" ], "field" : "commerce_product" } },
        { "component_rules_product_is_on_sale" : { "product" : [ "commerce-line-item:commerce-product" ] } }
      ],
      "DO" : [
        { "commerce_line_item_unit_price_multiply" : {
            "commerce_line_item" : [ "commerce_line_item" ],
            "amount" : "0.9",
            "component_name" : "discount",
            "round_mode" : "1"
          }
        }
      ]
    }
  }');
  $items['rules_product_is_on_sale'] = entity_import('rules_config', '{ "rules_product_is_on_sale" : {
      "LABEL" : "Product is on sale",
      "PLUGIN" : "and",
      "OWNER" : "rules",
      "REQUIRES" : [ "rules" ],
      "USES VARIABLES" : { "product" : { "label" : "Product", "type" : "entity" } },
      "AND" : [
        { "entity_has_field" : { "entity" : [ "product" ], "field" : "field_product_characteristics" } },
        { "data_is" : {
            "data" : [ "product:field-product-characteristics" ],
            "value" : { "value" : { "16" : "16" } }
          }
        }
      ]
    }
  }');
  return $items;
}
