<div class="item <?php if ($sequence == 0) print 'active'; ?>">
    <img alt="" src="<?php if($image) print $image;?>">
    <h2><?php if($name) print $name;?><?php if($position) print $position;?></h2>
    <p><?php print $content; ?></p>  
</div>