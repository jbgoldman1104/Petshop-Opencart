<?php
	$themeConfig = (array)$this->config->get('themecontrol');
	$listingConfig = array(
		'category_pzoom'        => 1,
		'quickview'             => 0,
		'show_swap_image'       => 0,
		'product_layout'		=> 'default',
		'enable_paneltool'	    => 0
	);
	$listingConfig = array_merge($listingConfig, $themeConfig );
	$categoryPzoom = $listingConfig['category_pzoom'];
	$quickview     = $listingConfig['quickview'];
	$swapimg       = $listingConfig['show_swap_image'];
	$categoryPzoom = isset($themeConfig['category_pzoom']) ? $themeConfig['category_pzoom']:0; 

	$span = floor(12/$cols);

	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';	
	if( !is_file($productLayout) ){
		$listingConfig['product_layout'] = 'default';
	}
	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';	

?>
<?php if( $show_title ) { ?>
<div class="widget-heading -heading"><?php echo $heading_title?></div>
<?php } ?>
<div class="widget-product-list <?php echo $addition_cls; ?>">
	<div class="widget-inner">
		<?php foreach ($products as $product) { ?>
		<div class="w-product clearfix col-lg-<?php echo $cols;?> col-md-<?php echo $cols;?> col-sm-12 col-xs-12">
			<?php require( $productLayout );  ?>   
		</div>
		<?php } ?>
	</div>
</div>
