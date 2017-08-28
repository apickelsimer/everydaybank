<div class="dexp-callout <?php print $class; ?>">
    <div class="col-md-1 col-sm-1 col-xs-2"><i class="<?php print $icon; ?> dexp-callout-icon"></i></div>
    <?php if(isset($button)):?>
    <div class="col-md-8 col-sm-8 col-xs-10">
        <div class="dexp-callout-content">
            <h3><?php print $title; ?></h3>
            <p><?php print $content; ?></p>
        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12 text-right"><?php print $button;?></div>
    <?php else:?>
    <div class="col-md-11 col-sm-11 col-xs-10">
        <div class="dexp-callout-content">
            <h3><?php print $title; ?></h3>
            <p><?php print $content; ?></p>
        </div>
    </div>
     <?php endif;?>
</div>
