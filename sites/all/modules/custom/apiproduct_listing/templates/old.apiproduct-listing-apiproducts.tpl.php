<?php
/**
 * Available variables
 *
 * $products an array of api products,
 * $num_products total number of products
 */
?>
<?php
$count = 0;
$num_rem = $num_products % 3;
?>
<div class="api-product-listing-wrapper">
  <?php foreach($products as $product) :?>
  <?php if ($count % 3 == 0) :?>
  <div class='api-product-item-row'>
  <?php endif;?>
  <div class='api-product-item'>
    <?php print $product; ?>
  </div>
  <?php if ($count % 3 == 2 || ($count == $num_products)) :?>
      </div>
      <div class='clear-fix'></div>
  <?php endif; ?>
  <?php $count++; ?>
  <?php endforeach;?>
</div>
