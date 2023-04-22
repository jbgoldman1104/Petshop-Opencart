<?php
	$span = 12/$cols;
	$id = rand(1,9);
	$themeConfig = (array)$this->config->get('themecontrol');
	$listingConfig = array(
		'category_pzoom'        => 1,
		'quickview'             => 0,
		'show_swap_image'       => 0,
		'product_layout'		=> 'default',
		'enable_paneltool'	    => 0
	);
	$listingConfig      = array_merge($listingConfig, $themeConfig );
	$categoryPzoom 	    = $listingConfig['category_pzoom'];
	$quickview          = $listingConfig['quickview'];
	$swapimg            = $listingConfig['show_swap_image'];
	$categoryPzoom      = isset($themeConfig['category_pzoom']) ? $themeConfig['category_pzoom']:0;

	$theme = $this->config->get('config_template');
	if( $listingConfig['enable_paneltool'] && isset($_COOKIE[$theme.'_productlayout']) && $_COOKIE[$theme.'_productlayout'] ){
		$listingConfig['product_layout'] = trim($_COOKIE[$theme.'_productlayout']);
	} 
	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';	
	if( !is_file($productLayout) ){
		$listingConfig['product_layout'] = 'default';
	}
	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';

	$button_cart = $this->language->get('button_cart');
?>

<div class="widget-cols panel panel-default nopadding">
	<?php if( $show_title ) { ?>
	<div class="widget-heading panel-heading space-30 border-heading"><h4 class="panel-title"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="panel-body">
		<!-- First Product -->
		<?php if(!empty($product)) { ?>
		<div class="first-product border-right pull-left">
			<?php require( $productLayout );  ?>
		</div>
		<?php } ?>
		
		<!-- List Product -->
		<div class="widget-product-list sidebar pull-right <?php echo $addition_cls; ?>">
	 		<div class="box-products heightlight slide" id="widget-<?php echo $id;?>">
				<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls">
					<a class="carousel-control left center" href="#widget-<?php echo $id;?>"   data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a class="carousel-control right center" href="#widget-<?php echo $id;?>"  data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
				<?php } ?>

				<div class="carousel-inner">
				<?php $pages = array_chunk( $products, $itemsperpage); ?>
				<?php foreach ($pages as  $k => $tproducts ) {   ?>
						<div class="products-block item <?php if($k==0) {?>active<?php } ?>">
							<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
								<?php if( $i%$cols == 1 || $cols == 1) { ?>
								  <div class="row products-row">
								<?php } ?>
								
									  <div class="col-lg-<?php echo $span;?> col-sm-6 col-xs-12 product-col">
									  <?php require( $productLayout );  ?>
									  </div>

							  <?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
								 </div>
								<?php } ?>
							<?php } //endforeach; ?>
						</div>
			  	<?php } ?>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$('#widget-<?php echo $id;?>').carousel({interval:false,auto:false,pause:'hover'});
--></script>