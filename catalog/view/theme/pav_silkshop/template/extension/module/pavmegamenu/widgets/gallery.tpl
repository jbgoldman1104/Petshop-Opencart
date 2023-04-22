<?php if( $show_title ) { ?>
<div class="widget-heading -heading"><?php echo $heading_title?></div>
<?php } ?>
<div class="widget-gallery-list <?php echo $addition_cls; ?>">
	<div class="widget-inner">
		<?php foreach ($thumbnailurl as $img) { ?>
		<img src="<?php echo $img; ?>" atr=""/>
		<?php } ?>
	</div>
</div>