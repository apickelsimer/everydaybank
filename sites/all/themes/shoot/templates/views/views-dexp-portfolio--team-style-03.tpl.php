<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="custompadding" data-padding="0">
  <div id="<?php print drupal_html_id("team-view-id"); ?>" class="dexp-grid-items row">
    <?php foreach ($rows as $row): ?>
      <?php print $row; ?>
    <?php endforeach; ?>
  </div>
</div>