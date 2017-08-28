<div class="skills_boxes">
  <span class="chart" data-bar-color="<?php print $color; ?>" data-percent="<?php print $percent; ?>"><span class="percent"></span></span>
    <div class="title"><h3><?php print $title; ?></h3></div>
    <p><?php print $content; ?></p>
</div><!-- end skills_boxes -->
<?php 
  global $base_url;
  $theme_path = drupal_get_path('theme', 'shoot'); 
?>
<script src="<?php print $base_url.'/'.$theme_path.'/templates/shortcode/js/jquery.easypiechart.min.js';?>"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.chart').easyPieChart({
            easing: 'easeOutBounce',
            size: <?php print $width; ?>,
            animate: 2000,
            lineWidth: 5,
            lineCap: 'square',
            barColor: false,
            trackColor: false,
            scaleColor: false,
            onStep: function(a,b,c) {
              $(this.el).find('span.percent').text(Math.round(a) + '%');               
            }
        });
    });
</script>