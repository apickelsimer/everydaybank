<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="content"<?php print $content_attributes; ?>>
        <?php print render($title_prefix); ?>
        <?php print render($title_suffix); ?>
        <?php
// We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        //print_r($node);die;
        $path = drupal_get_path_alias("node/" . $node->nid);
        ?>    
        <div class="dexp-team full-content row">
            <div class="col-md-5">
                <figure class="dexp-image-item">
                    <?php print render($content['field_team_image']); ?>
                </figure>
            </div>
            <div class="col-md-7">
                <h4 class="dexp-col-non-mg upper"><?php print $title; ?></h4>
                <span class="position">
                    <?php print render($content['field_team_position']); ?>
                </span>       
                <p style="margin-bottom:50px;"><?php print render($content['body']); ?></p>
                <?php print render($content['field_team_phone']); ?>               
                <?php print render($content['field_team_email']); ?>
                <div class="dexp-social-group-smallspace">
                    <?php print render($content['field_team_social']); ?>
                </div>
            </div>

        </div>
    </div>
</div> 
