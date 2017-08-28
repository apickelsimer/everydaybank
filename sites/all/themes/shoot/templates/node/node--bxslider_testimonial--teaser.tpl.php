<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="content"<?php print $content_attributes; ?>>
        <?php
// We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
//print render($content);
        ?>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="client-image">
                    <?php print render($content['field_testimonial_image']); ?>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="client-author">
                    <h5><?php print $title; ?></h5>
                    <div><?php print render($content['field_testimonial_position'][0]); ?></div>
                </div>
                <div class="description"><?php print render($content['body']); ?></div>      
            </div>
        </div>
    </div>
</div> 