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
        <div class="dexp-team">
            <figure class="dexp-image-item">
                <a href="<?php print '/'.$path; ?>">
                    <?php print render($content['field_team_image']); ?>
                </a>
            </figure>
            <h6 class="dexp-col-non-mg upper"><?php print $title; ?></h6>
            <span class="position">
                <?php print render($content['field_team_position']); ?>
            </span>
            <div class="dexp-social-group-smallspace">
                <?php print render($content['field_team_social']); ?>
            </div>

        </div>
    </div>
</div> 
