<?php if( $banners ) { ?>
<?php if( isset($widget_name)){
?>
<span class="menu-title"><?php echo $widget_name;?></span>
<?php
}?>
<div class="widget-banner panel panel-default">
	<div class="widget-inner clearfix">
		  <?php foreach ($banners as $banner) { ?>
		  <?php if ($banner['link']) { ?>
		  <div class="w-banner"><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div>
		  <?php } else { ?>
		  <div><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></div>
		  <?php } ?>
		  <?php } ?>
	</div>
</div>
<?php } ?>