<?php if ( isset($raw_html) ) { ?>
<div class="widget-raw-html  <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>-<?php echo $stylecls;?><?php } ?>">
	<?php if ( isset($widget_heading)&&!empty($widget_heading) ) { ?>
	<div class="widget-heading title_block">
		<?php echo $widget_heading?>
	</div>
	<?php } ?>
	<div class="widget-inner block_content">
		<?php echo $raw_html; ?>
	</div>
</div>
<?php } ?>