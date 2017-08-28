<?php
/**
 * Available variables
 *
 * $products an array of "themed" api product elements
 * $num_products total number of products
 * $raw_products - PHP array of products, each of which is an associative array
 */
?>
<div class="api-product-listing-wrapper">
  <div class="apiproduct_filtered_list" id="apiproduct_filtered_list"></div>
</div>

<script>
  var rawProducts = <?php print '    ' . json_encode($raw_products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;

</script>

<script id="prod_template" type="text/html">
  <div id="<%= element_id %>" class="api-product-item">
    <div class="api-product-wrapper">
      <div class="api-product-image">
        <img src="<%= link_img %>" height="230" width="230">
      </div>
      <div>
        <h2 class="api-product-name"><%= display_name %></h2>
      </div>
      <div class="api-product-desc">
       <%= description_150 %>
      </div>
      <div class="api-product-link">
        <a href="<%= link_doc %>" class="apiproduct-btn-default">API docs</a>
      </div>
    </div>
  </div>
</script>
