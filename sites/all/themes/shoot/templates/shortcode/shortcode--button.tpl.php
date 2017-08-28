<?php
$i = !empty($icon)?"<i class=\"{$icon}\"></i> ":"";
$hovertest=!empty($hover_text)? "data-btn-text='".$hover_text."'":"";
$content_all='';
if(strpos($classes,'dexp-btn-inline-icon') !== false){
   $content_all='<span '.$hovertest.'>'.$i.$content.'</span>';
}else{
    $content_all='<span '. $hovertest.'>'.$content.'</span>'.$i;
}
?>
<?php if($type =='link'):?>
<a role='button' class="<?php print $classes;?>" href="<?php print $link;?>"><?php print $content_all;?></a>
<?php else: ?>
<button type="button" class="<?php print $classes;?>"><?php print $content_all;?></button>
<?php endif;?>