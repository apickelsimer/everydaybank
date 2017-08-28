<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>
  <div class="content"<?php print $content_attributes; ?>>
    <?php
// We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_portfolio_images']);
    $lightboxrel = 'portfolio_'.$nid;
    $portfolio_images = field_get_items('node', $node, 'field_portfolio_images');
    $first_image = '';
    if($portfolio_images){
      foreach($portfolio_images as $k => $portfolio_image){
        if($k == 0){
          $first_image = file_create_url($portfolio_image['uri']);
        }else{
          $image_path = file_create_url($portfolio_image['uri']);
          print '<a href="'.$image_path.'" class="fancybox" rel="'.$lightboxrel.'" title="" style="display:none">&nbsp;</a>';
        }
      }
    }
    ?>
    <div class="portfolio-image">
      <?php print render($content['field_portfolio_images']); ?>
      <div class="mediaholder"></div>
      <div class="portfolio-tools">
        <h5><a href="<?php print $node_url?>"><?php print $title;?></a></h5>
        <a href="<?php print $first_image; ?>" class="fancybox" rel="<?php print $lightboxrel; ?>" title="">
        <span class="fa fa-2x fa-search"></span></a>
        <?php print flag_create_link("like", $node->nid);?>
      </div>
    </div>
    <div class="portfolio-description">
      <h5><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h5>
      <div class="description"><?php print render($content['body']);?></div>
    </div>
  </div>
  <?php print render($content['links']); ?>
  <?php print render($content['comments']); ?>
</div> 