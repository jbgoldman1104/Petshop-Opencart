<?php
	$cols = 4;
	$span = floor(12/$cols);
	$active = 'latest';
	$id = rand(1,time()+9);	
	$bspan = 12-$block_width;
	$themeConfig = (array)$this->config->get('themecontrol');
	$listingConfig = array(
		'category_pzoom'                     => 1,
		'quickview'                          => 0,
		'show_swap_image'                    => 0,
		'product_layout'		=> 'default',
	);
	$listingConfig     = array_merge($listingConfig, $themeConfig );
	$categoryPzoom 	    = $listingConfig['category_pzoom'];
	$quickview          = $listingConfig['quickview'];
	$swapimg            = $listingConfig['show_swap_image'];
	$categoryPzoom = isset($themeConfig['category_pzoom']) ? $themeConfig['category_pzoom']:0; 


	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';	
	if( !is_file($productLayout) ){
		$listingConfig['product_layout'] = 'default';
	}
	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';	

?>
<div class="panel products-featured <?php echo $addition_class;?>">
	<div class="panel-heading"><span><?php echo $heading_title; ?></span></div>
	<div class="panel-body">
 		<div class="products-rows slide" id="productfeatured<?php echo $id;?>">
 			<?php if( trim($message) || trim($banner) ) { ?>
 			<div class="featured-banner">
 				<?php if ( $banner ) { ?>
				<img src="image/<?php echo $banner; ?>">
 				<?php } ?>
				<?php if( trim($message) ) { ?>
				<div class="panel-description"><?php echo $message;?></div>
				<?php } ?>
			</div>
			<?php } ?>
 
						<?php if( count($products) > $itemsperpage ) { ?>
						<div class="carousel-controls">
							<a class="carousel-control left fa fa-angle-left" href="#productfeatured<?php echo $id;?>" data-slide="prev"></a>
							<a class="carousel-control right fa fa-angle-right" href="#productfeatured<?php echo $id;?>" data-slide="next"></a>
						</div>
						<?php } ?>
						<div class="carousel-inner">		
						 <?php  $pages = array_chunk( $products, $itemsperpage);  ?>	
						  <?php foreach ($pages as  $k => $tproducts ) {   ?>
								<div class="item <?php if($k==0) {?>active<?php } ?>">
									<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
										<?php if( $i%$cols == 1 ) { ?>
										  <div class="row products-row">
										<?php } ?>
											<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-6 col-xs-12 product-col">
												<?php require(  $productLayout );  ?>   	  	 
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
$('#productfeatured<?php echo $id;?>').carousel({interval:false,auto:false,pause:'hover'});
</script>
