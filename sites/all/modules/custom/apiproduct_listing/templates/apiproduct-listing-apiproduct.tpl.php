<?php
/**
 * Available variables
 *
 * $product The Edge API product object.
 * $display_name The display name of the API product
 * $description The description of the API Product.
 * Author: Cass Obregon
 * Added display for Catalog, Image, and additional attributes
 */
?>


<div class="api-product-wrapper" id="<?php print $product->name?>">
  <div class="api-product-image">
    <img src="<?php print $link_img?>" height="230" width="230">
  </div>
  <div>
    <h2 class="api-product-name"><?php print $display_name; ?></h2>
  </div>
  <div class="api-product-desc">
    <?php print substr($description, 0, 150) . '...'; ?>
  </div>
  <div class="api-product-link">
    <a href="<?php  print $link_doc?>" class="apiproduct-btn-default"><?php  print substr($display_name,0,18)?> APIS</a>
  </div>
</div>