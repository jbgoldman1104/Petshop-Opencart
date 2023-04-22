<?php if( $image ) { ?>
<?php if( isset($widget_name)){
?>
<span class="menu-title"><?php echo $widget_name;?></span>
<?php
}?>
<div class="widget-image">
	<div class="widget-inner clearfix">
		<div><img src="<?php echo $image; ?>" alt="" title="" /></div>
	</div>
</div>
<?php } ?>