<?php $objlang = $this->registry->get('language'); ?>
<?php if ( isset($thumbnailurl) )  { ?>
<div class="widget-images <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>-<?php echo $stylecls;?><?php } ?>">
	<?php if( $show_title ) { ?>
	<h4 class="widget-heading">
	    <?php echo $heading_title?>
	</h4>
	<?php } ?>
	<div class="widget-inner clearfix">
		 <div class="image-item">
		 	<img class="img-responsive" alt=" " src="<?php echo $thumbnailurl; ?>"/>
		 	<?php if( $ispopup ){ ?>
		 	<a href="<?php echo $imageurl; ?>" class="pts-popup fancy" title="<?php echo $objlang->get('Large Image');?>"><span class="icon icon-expand"></span></a>
		 	<?php } ?>		  
		 </div>
	</div>
</div>
<?php } ?>