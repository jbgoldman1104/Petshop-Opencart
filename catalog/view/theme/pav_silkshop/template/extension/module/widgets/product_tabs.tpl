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
	$config = $sconfig;
   $theme  = $themename;
    $themeConfig = (array)$config->get('themecontrol');
    $listingConfig = array( 
        'listing_products_columns'                  => 0,
        'listing_products_columns_small'            => 2,
        'listing_products_columns_minismall'        => 1,
        'cateogry_display_mode'                     => 'grid',
        'category_pzoom'                            => 1,   
        'quickview'                                 => 0,
        'show_swap_image'                           => 0,
        'product_layout'                            => 'default',
        'catalog_mode'                              => 0,
        'enable_paneltool'                          => 0
    ); 
    $listingConfig      = array_merge($listingConfig, $themeConfig );
    $DISPLAY_MODE       = $listingConfig['cateogry_display_mode'];
    $MAX_ITEM_ROW       = $listingConfig['listing_products_columns']?$listingConfig['listing_products_columns']:3; 
    $MAX_ITEM_ROW_SMALL = $listingConfig['listing_products_columns_small']?$listingConfig['listing_products_columns_small']:2;
    $MAX_ITEM_ROW_MINI  = $listingConfig['listing_products_columns_minismall']?$listingConfig['listing_products_columns_minismall']:1; 
    $categoryPzoom      = $listingConfig['category_pzoom']; 
    $quickview          = $listingConfig['quickview'];
    $swapimg            = ($listingConfig['show_swap_image'])?'swap':'';  


    if( isset($_COOKIE[$theme.'_productlayout']) && $listingConfig['enable_paneltool'] && $_COOKIE[$theme.'_productlayout'] ){
        $listingConfig['product_layout'] = trim($_COOKIE[$theme.'_productlayout']);
    }
    
    $productLayout = DIR_TEMPLATE.$theme.'/template/common/product/'.$listingConfig['product_layout'].'.tpl';   
    if( !is_file($productLayout) ){
        $listingConfig['product_layout'] = 'default';
    }
 


	$button_cart = $this->language->get('button_cart');
	$tab = rand();
?>

<div class="widget-products product-tabs panel panel-default <?php $addition_cls?> <?php if ( isset($stylecls)&&$stylecls) { ?>box-<?php echo $stylecls; ?><?php } ?>">
	<?php if( $show_title ) { ?>
		<div class="widget-heading pull-left"><h3 class="panel-title hidden-xs"><span><?php echo $heading_title?></span></h3></div>
	<?php } ?>

	<div class="widget-content">
  	<div class="tabs-group <?php if($tabsstyle == 'tab-v2-r'){echo "tab-v2";}else{echo $tabsstyle;}?> <?php if($tabsstyle=='tab-v2'){echo "tabs-left";}elseif($tabsstyle=='tab-v3'){echo "tabs-right";}?>">
  		<div class="tab-heading">
            <ul role="tablist" class="nav nav-tabs" id="product_tabs<?php echo $id;?>">
            	<?php foreach( $tabs as $tab => $products ) { if( empty($products) ){ continue;} ?>
	                <li>
	                    <a data-toggle="tab" role="tab" href="#tab-<?php if($tabsstyle=='tab-2'){echo $tab.'-left-'.$id;}elseif($tabsstyle=='tab-3'){echo $tab.'-right-'.$id;;}else{echo $tab.$id;}?>" aria-expanded="true"><i class="fa <?php if($tab == 'latest'){echo $icon_newest;}elseif($tab=='featured'){echo $icon_featured;}elseif($tab=='bestseller'){echo $icon_bestseller;}elseif($tab=='special'){echo $icon_special;}else{echo $icon_mostviews;};?>"></i><?php echo $objlang->get('text_'.$tab)?></a>
	                </li>
	            <?php } ?>
            </ul>
         </div>    
    </div>


	 <div class="tab-content hightlight">
		<?php foreach( $tabs as $tab => $products ) {
				if( empty($products) ){ continue;}
			?>
				<div class="tab-pane fade box-products owl-carousel-play  tabcarousel<?php echo $id; ?>" id="tab-<?php if($tabsstyle=='tab-2'){echo $tab.'-left-'.$id;}elseif($tabsstyle=='tab-3'){echo $tab.'-right-'.$id;;}else{echo $tab.$id;}?>" data-ride="owlcarousel">

				<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls hidden-xs hidden-sm">
				<a class="carousel-control left" href="#tab-<?php echo $tab.$id;?>"   data-slide="prev"><i class="fa fa-arrow-left"></i></a>
				<a class="carousel-control right" href="#tab-<?php echo $tab.$id;?>"  data-slide="next"><i class="fa fa-arrow-right"></i></a>
				</div>
				<?php } ?>

				<div class="owl-carousel" data-show="1" data-pagination="false" data-navigation="true">
				<?php $pages = array_chunk( $products, $itemsperpage); ?>
				<?php foreach ($pages as  $k => $tproducts ) {   ?>
						<div class="item <?php if($k==0) {?>active<?php } ?>">
							<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
								<?php if( $i%$cols == 1 ) { ?>
								  <div class="row products-row">
								<?php } ?>
									  <div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-6 col-xs-12 product-col">
									  <?php require($productLayout);  ?>
									  </div>

							  <?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
								 </div>
								<?php } ?>
							<?php } //endforeach; ?>
						</div>
			  	<?php } ?>
				</div>


			</div>
		<?php } // endforeach of tabs ?>
	</div>
	</div>
</div>


<script>
$(function () {
	$('#product_tabs<?php echo $id;?> a:first').tab('show');
})

</script>