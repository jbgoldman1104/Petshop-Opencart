<?php
$objlang = $this->registry->get('language');
$themeConfig = (array)$this->config->get('themecontrol');
$listingConfig = array(
'category_pzoom'                     => 1,
'quickview'                          => 0,
'show_swap_image'                    => 0,
'product_layout'		=> 'default',
'enable_paneltool'	=> 0
);
$listingConfig     = array_merge($listingConfig, $themeConfig );
$categoryPzoom 	    = $listingConfig['category_pzoom'];
$quickview          = $listingConfig['quickview'];
$swapimg            = $listingConfig['show_swap_image'];
$categoryPzoom = isset($themeConfig['category_pzoom']) ? $themeConfig['category_pzoom']:0;

$theme = $this->config->get('config_template');
if( $listingConfig['enable_paneltool'] && isset($_COOKIE[$theme.'_productlayout']) && $_COOKIE[$theme.'_productlayout'] ){
$listingConfig['product_layout'] = trim($_COOKIE[$theme.'_productlayout']);
}
$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';
if( !is_file($productLayout) ){
$listingConfig['product_layout'] = 'default';
}
$button_cart = $objlang->get('button_cart');

// $cols = 12;

?>
<?php if( $show_title ) { ?>
<h4 class="widget-heading"><?php echo $heading_title?></h4>
<?php } ?>
<div class="widget-content <?php echo $addition_cls; ?>">
	<div class="widget-inner products-row">
		<?php foreach ($products as $product) { ?>
		<div class="w-product clearfix col-lg-<?php echo $cols;?> col-md-<?php echo $cols;?> col-sm-12 col-xs-12">
			<?php require( $productLayout );  ?>   
		</div>
		<?php } ?>
	</div>
</div>
