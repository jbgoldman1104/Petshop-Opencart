<?php 
	$config = $this->registry->get('config'); 

	$theme  = $config->get('config_template');

	$span = floor(12/$cols); 
	$active = 'latest';
	$id = rand(1,9);

	$themeConfig  	 			= (array)$config->get('themecontrol');
	$listingConfig  			= array( 		
		'category_pzoom' 		=> 1,
		'show_swap_image' 		=> 0,
		'quickview' 			=> 0,
		'product_layout'		=> 'default',
		'catalog_mode'			=> '',
	); 
	$listingConfig  			= array_merge($listingConfig, $themeConfig );
	$categoryPzoom 	    		= $listingConfig['category_pzoom'];
	$quickview 					= $listingConfig['quickview'];
	$swapimg 					= ($listingConfig['show_swap_image'])?'swap':'';
 
 
	$productLayout = DIR_TEMPLATE.$config->get('config_template').'/template/common/product/deal_default.tpl';	 

 	$ourl = $this->registry->get('url'); 

?>
<?php $objlang = $this->registry->get('language');  $ourl = $this->registry->get('url');   ?>
<div class="<?php echo $prefix;?>productdeals panel panel-default">
	<div class="panel-heading"> <h4 class="panel-title"> <?php echo $heading_title; ?> </h4></div>
	<div class="panel-body" >
 		<div class="box-products slide" id="pavdeals<?php echo $id;?>">
			<?php if( trim($message) ) { ?>
			<div class="box-description"><?php echo $message;?></div>
			<?php } ?>
			<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls">
					<a class="carousel-control left" href="#pavdeals<?php echo $id;?>"   data-slide="prev"><i class="fa fa-angle-left"></i></a>
					<a class="carousel-control right" href="#pavdeals<?php echo $id;?>"  data-slide="next"><i class="fa fa-angle-right"></i></a>
				</div> 
			<?php } ?>
			<div class="carousel-inner ">		
			 <?php
				$pages = array_chunk( $products, $itemsperpage);
			 ?>

			 <?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							  <div class="row products-row">
							<?php } ?>
								  <div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-12 col-xs-12 product-col border">
								  		<?php require( $productLayout );?>
								  </div>
						  
						  <?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
							 </div>
							<?php } ?>
						<?php } //endforeach; ?>
					</div>
			  <?php } ?>

			</div> 
		</div>
 </div> </div>


<script type="text/javascript">
$('#pavdeals<?php echo $id;?>').carousel({interval:<?php echo ( $auto_play_mode?$interval:'false') ;?>,auto:<?php echo $auto_play;?>,pause:'hover'});
</script>