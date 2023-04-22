
<div class="wpo-ourservice">
		<h4 class="ourservice-heading">
			<?php if ( !empty($icon) ) { ?>
			<i class="fa <?php echo $icon; ?> fa-3x pull-left"></i>
			<?php } ?>
			<?php if ( empty($icon)&&$imagefile ) { ?>
			<img src="<?php echo $thumbnailurl; ?>" class="pull-left" title="<?php echo $widget_heading;?>"/>
			<?php } ?>
			<?php echo $widget_heading; ?>
		</h4>
		<div class="ourservice-content">
			<?php echo $content; ?>
		</div>
</div>