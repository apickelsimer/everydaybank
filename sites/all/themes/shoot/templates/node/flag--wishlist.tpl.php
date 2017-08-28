<span class="<?php print $flag_wrapper_classes; ?>">
<?php if ($link_href): ?>
<a href="<?php print $link_href; ?>" title="<?php print $link_title; ?>" 
   class="dexp-social-icon dexp-social-transparent <?php print $flag_classes ?>" rel="nofollow"><?php print $link_text; ?></a>
<?php else: ?>
<span class="<?php print $flag_classes ?>"><?php print $link_text; ?></span>
<?php endif; ?>
<?php if ($after_flagging): ?>
<span class="flag-message flag-<?php print $status; ?>-message">
<?php print $message_text; ?>
</span>
<?php endif; ?>
</span> 