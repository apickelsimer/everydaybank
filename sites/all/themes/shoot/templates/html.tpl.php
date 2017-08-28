<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1">
		<?php print $head; ?>
		<title>
			<?php 
				print trim($head_title, " |"); 
			?>
		</title>
		<?php print $styles; ?>
		<script type="text/javascript">
   			var Apigee = Apigee || {};
   			Apigee.APIModel = Apigee.APIModel || {};
 		</script>
		<?php print $scripts; ?>
	</head>
	
	<body class="<?php print $classes; ?>" <?php print $attributes;?>>
		<div id="skip-link">
		<a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
		</div>
		<?php print $page_top; ?>
		<?php print $page; ?>
		<?php print $page_bottom; ?>
	</body>
</html>