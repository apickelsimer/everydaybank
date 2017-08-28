<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <div class="content"<?php print $content_attributes; ?>>
        <?php print render($title_prefix); ?>
        <?php print render($title_suffix); ?>
        <?php
// We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        $path = drupal_get_path_alias("node/" . $node->nid);
        $language = $node->language;
        if(!isset($node->field_team_image[$language])){
        $language="und";
        }
        $image_path = file_create_url($node->field_team_image[$language][0]['uri']);
        ?>                

        <div class="dexp-team hover-box">
            <figure><a data-rel="portfolio" class="fancybox" href="<?php print $image_path; ?>" rel="portfolio">
                    <div class="text-overlay"> 
                        <div class="info">
                            <span><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <?php print render($content['field_team_image']); ?> 
                </a>
            </figure>
            <figure class="dexp-image-short-cap">
                <figcaption class="dexp-image-caption">
                    <h4 class="dexp-col-non-mp"><a href="<?php print "/".$path; ?>"><?php print $title; ?></a></h4>
                    <span class="position">
                        <?php print render($content['field_team_position']); ?>
                    </span>
                </figcaption>
            </figure>
        </div>
    </div>
</div>