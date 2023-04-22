<?php
/******************************************************
 * @package Pav Product Tabs module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2012 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
	$span = 12/$cols;
	$active = 'latest';
	$id = rand(1,9)+rand();
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
	$productLayout = DIR_TEMPLATE.$this->config->get('config_template').'/template/common/product/'.$listingConfig['product_layout'].'.tpl';
	$button_cart = $this->language->get('button_cart');
?>
<div class="widget-products panel-left panel panel-default hightlighted <?php $addition_cls?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading panel-heading block-borderbox"><h3 class="panel-title"><?php echo $heading_title?></h3></div>
	<?php } ?>
 		<div class="box-products owl-carousel-play" id="productcarousel<?php echo $id;?>" data-ride="owlcarousel">
		<?php if( count($specials) > $itemsperpage ) { ?>
			<div class="carousel-controls">
				<a class="carousel-control left center" href="#productcarousel<?php echo $id;?>"   data-slide="prev">
					<i class="fa fa-angle-left"></i>
				</a>
				<a class="carousel-control right center" href="#productcarousel<?php echo $id;?>"  data-slide="next">
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		<?php } ?>
			<div class="owl-carousel product-grid"  data-show="1" data-pagination="false" data-navigation="true">
				<?php $pages = array_chunk( $specials, $itemsperpage); ?>
				<?php foreach ($pages as  $k => $tproducts ) {   ?>
				<div class="item <?php if($k==0) {?>active<?php } ?> products-block">
					<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
						<?php if( $i%$cols == 1 || $cols == 1) { ?>
						<div class="row products-row <?php ;if($i == count($tproducts) - $cols +1) { echo "last";} ?>"><?php //start box-product?>
						<?php } ?>
							<div class="col-lg-<?php echo $span;?> col-sm-<?php echo $span;?> col-xs-12 <?php if($i%$cols == 0) { echo "last";} ?> product-col border">
								<?php require( $productLayout );  ?>
							</div>

						<?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
						</div><?php //end box-product?>
						<?php } ?>
					<?php } //endforeach; ?>
				</div>
			  <?php } ?>
			</div>
		</div>
</div>
