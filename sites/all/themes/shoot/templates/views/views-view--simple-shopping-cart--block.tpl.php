<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
global $user;
$quantity = 0;
$order = commerce_cart_order_load($user->uid);
if ($order) {
  $wrapper = entity_metadata_wrapper('commerce_order', $order);
  $line_items = $wrapper->commerce_line_items;
  $quantity = commerce_line_items_quantity($line_items, commerce_product_line_item_types());
}
?>
<a id="cart-baseket" href="<?php print url('cart'); ?>" alt="View cart">
  <span class="baseket fa-stack fa-1x">
    <span class="cart-quantity fa-stack fa-1x">
      <?php print $quantity; ?>
    </span>   
    <i class="fa fa-shopping-cart fa-stack-1x"></i>
  </span> 
  
</a>
