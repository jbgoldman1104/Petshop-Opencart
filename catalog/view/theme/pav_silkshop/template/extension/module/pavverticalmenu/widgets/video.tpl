<?php if ( isset($video_link) ) { ?>
<div class="widget widget-video">
	<?php if ( $show_title ) {?>
	<h4 class="widget-heading">
		<?php echo $heading_title; ?>
	</h4>
	<?php } ?>
	<div class="widget-inner  video-responsive">
		<iframe src="<?php echo $video_link ?>" style="width:<?php echo $width ?>;height:<?php echo $height ?>px;" allowfullscreen="true"></iframe>
		<?php if ( $subinfo ) { ?>
		<div><?php $subinfo ?></div>
		<?php } ?>
	</div>
</div>
<?php } ?>