<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/
?>
<div id="node-<?php print $node->nid; ?>" class="node-product-detail <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>

    <div class="row">
        <div class="col-ld-5 col-md-5 col-sm-12 col-xs-12">
            <div class="product-detail-images">
                <?php print render($content['product:field_product_images']);?>
            </div>    
        </div>

        <div class="col-ld-7 col-md-7 col-sm-12 col-xs-12">
            <h1> <?php print $node->title;?></h1>
            <div>
                <a href="#"><?php print $comment_count;?> review(s)</a>
            </div> 
            <div class="rating">
                  <?php print render($content['field_product_rating']);?>
            </div>
            <div class="price"><?php print render ($content['product:commerce_price']);?></div>
            <p><?php print substr(strip_tags(render($content['body'])), 0, 200);?></p>
            <?php print render($content['field_product']);?>
            <?php 
                if (isset($node->field_product[$node->language])) {
                    $product = $node->field_product[$node->language][0]['product_id'];
                } else {
                    $product = $node->field_product['und'][0]['product_id'];
                }
            ?>
            <?php print flag_create_link('wishlist', $product);?>
        </div>
    </div>
    
    <div class="line-60"></div>
    <div class="dexp_tab_wrapper default clearfix" id="dexp_tab_wrapper_product_detail"> 
        <ul class="nav nav-tabs">
            <li class="first active"><a data-toggle="tab" href="#product_description">
                <i class="tab-icon fa "></i>Product Description</a></li>
            <li class=""><a data-toggle="tab" href="#product_additional">
                <i class="tab-icon fa "></i>Additional Information</a></li>
            <li class="last"><a data-toggle="tab" href="#product_review">
                <i class="tab-icon fa "></i>Review (<?php print $comment_count;?>)</a>
            </li>
        </ul>
        <div class="tab-content" style="border:1px solid #e5e5e5; padding:10px 20px; border-radius:3px;">
            <div class="tab-pane active" id="product_description"> 
                <?php print render($content['body']);?>
            </div>
            <div class="tab-pane" id="product_additional">
                <table class="table table-bordered table-hover">
                    <tbody><tr>
                      <th>Product</th>
                      <th>Description</th>
                    </tr>
                    <tr>
                      <td>Brand</td>
                      <td><?php print render($content['field_brand']);?></td>
                    </tr>
                    <tr>
                      <td>Size</td>
                      <td><?php print render($content['product:field_product_size']);?></td>
                    </tr>
                    <tr>
                      <td>Color</td>
                      <td><?php print render($content['product:field_product_color']);?></td>
                    </tr>
                    <tr>
                      <td>Material</td>
                      <td><?php print render($content['product:field_product_material']);?></td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div class="tab-pane" id="product_review">
                 <?php print render ($content['comments']); ?>    
            </div>
        </div>
    </div>
    
    <div class="sep60"></div>
</div>
