
<div id="<?php print $testimonial_wapper_id; ?>" class="testimonial carousel slide dexp_carousel <?php print $class;?>" data-ride="carousel">      
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php print $content; ?>
    </div>
    <!-- End Wrapper for slides -->
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <?php
        for ($i = 0; $i < $total_items; $i++):?>
            <li data-target="#<?php print $testimonial_wapper_id; ?>" data-slide-to="<?php print $i; ?>" <?php print $i == 0 ? 'class=active' : ''; ?>></li>
        <?php endfor;?>
    </ol>   
    <!-- End Carousel indicators -->
</div>