<?php if( isset($widget_name)){
?>
<span class="menu-title"><?php echo $widget_name;?></span>
<?php
}?>
<div class="widget-feed">
	<div class="widget-inner">
		 <?php $i=0; foreach( $items as $entry ) { ?>
		 	<div class="rss-item">
		 		<a href="<?php echo $entry->link; ?>"><?php echo $entry->title?></a>
		 	</div>
		 <?php 
		 if($i++==$setting['limit'] ){
		 	break;
		 } 
		} ?>
	</div>
</div>