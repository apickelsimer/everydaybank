<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
 <?php print render($title_prefix); ?>
 <?php print render($title_suffix); ?>   
  <div class="time-mark">
   <?php print date('M d, y', $created);?>
 </div>   
 <div class="blog-timeline-item">
  <!-- Begin media blog -->
  <div class="media_element">
    <?php if (isset($content['field_quote'])):?>
    <div class="quote-post">
      <blockquote>
        <?php print render($content['field_quote']);?>
      </blockquote>
    </div>  
    <?php else: ?>
    <?php print render($content['field_media']);?>
    <?php endif; ?>
  </div>
  <!-- End media blog -->
  
  <!-- Begin blog Content -->
  <div class="blog-content">
    <div class="title">
      <h3><a title="" href="<?php print $node_url;?>"><?php print $title;?></a></h3>
    </div><!-- end title -->
    <div class="meta">
        <ul>
            <li class="posted-by">
                <i class="fa fa-user"></i> <?php print $name;?>
            </li>
            <li class="like"><?php print flag_create_link("like", $node->nid);?></li>
            <li class="comment-count">
                <i class="fa fa-comments"></i>
                <?php print $comment_count;?> Comments
            </li>
        </ul>
    </div><!-- end post-meta -->
    <?php print(render($content['body']));?>
    <a href="<?php print $node_url;?>" class="dexp-shortcodes-button btn dexp-btn-reflect-icon" role="button">
            <span>Read more</span>
        </a> 
  </div> <!-- End blog Content -->
  </div>
  </div>