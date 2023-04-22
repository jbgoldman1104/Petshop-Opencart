<?php if ( isset($raw_html) ) { ?>
<div class="widget-raw-html box <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>box-<?php echo $stylecls;?><?php } ?>">
	<?php if( $show_title ) { ?><div class="widget-heading box-heading"><?php echo $heading_title?></div><?php } ?>
	<div class="widget-inner block_content">
		<?php echo $raw_html; ?>
	</div>
</div>
<?php } ?>