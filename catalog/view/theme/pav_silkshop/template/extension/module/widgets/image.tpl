<?php if ( isset($thumbnailurl) )  { ?>
<div class="widget-images box <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>box-<?php echo $stylecls;?><?php } ?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading"><h3 class="panel-title"><?php echo $heading_title?></h3></div>
	<?php } ?>
	<div class="widget-inner img-adv box-content clearfix">
		 <div class="effect-v10">
		 	<a class="image-item" href="<?php echo $link; ?>"><img class="img-responsive" alt=" " src="https://shop.phillipspet.com/storefrontCommerce/imageContent.do?contentKey=559ca2e1-4fc9-4d2f-a644-eb4e3093c8b8&size=PRIMARY&fileName=887223.png"/></a>
		 	<?php if( $ispopup ){ ?>
		 	<a href="<?php echo $imageurl; ?>" class="pts-popup fancybox" title="<?php echo $this->language->get('Large Image');?>"><span class="icon icon-expand"></span></a>
		 	<?php } ?>		  
		 </div>
	</div>
</div>
<?php } ?>