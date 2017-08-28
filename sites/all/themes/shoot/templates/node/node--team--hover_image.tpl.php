<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="content"<?php print $content_attributes; ?>>
        <?php //print render($title_prefix); ?>
        <?php //print render($title_suffix); ?>
        <?php
// We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        $path = drupal_get_path_alias("node/" . $node->nid);
        ?>                

        <div class="dexp-team hover-box">
            <figure class="dexp-image-item dexp-image-short-cap">
                <?php print render($content['field_team_image']); ?>
                <div class="dexp-socials">
                    <?php print render($content['field_team_social']); ?>
                </div>
                <figcaption class="dexp-image-caption">
                    <h4 class="dexp-col-non-mp"><a href="<?php print '/'.$path; ?>"><?php print $title; ?></a></h4>
                    <span class="position">
                        <?php print render($content['field_team_position']); ?>
                    </span>
                </figcaption>
            </figure>
        </div>
    </div>
    <?php print render($content['links']); ?>
    <?php print render($content['comments']); ?>
</div>