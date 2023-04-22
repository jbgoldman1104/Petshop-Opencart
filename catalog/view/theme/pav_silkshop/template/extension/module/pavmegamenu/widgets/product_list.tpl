<?php

   $themeConfig = (array)$sconfig->get('themecontrol');
   $listingConfig = array(
      'category_pzoom'        => 1,
      'quickview'             => 0,
      'show_swap_image'       => 0,
      'product_layout'     => 'default',
      'enable_paneltool'       => 0
   );
   $listingConfig = array_merge($listingConfig, $themeConfig );
   $categoryPzoom = $listingConfig['category_pzoom'];
   $quickview     = $listingConfig['quickview'];
   $swapimg       = $listingConfig['show_swap_image'];
   $categoryPzoom = isset($themeConfig['category_pzoom']) ? $themeConfig['category_pzoom']:0; 

   $span = 12/$cols;

   $productLayout = DIR_TEMPLATE.$themename.'/template/common/product/'.$listingConfig['product_layout'].'.tpl';  
   if( !is_file($productLayout) ){
      $listingConfig['product_layout'] = 'default';
   }
   $productLayout = DIR_TEMPLATE.$themename.'/template/common/product/'.$listingConfig['product_layout'] = 'list.tpl';

   $id = rand(1,9)+rand();

   $columns_count  = 1;
?>
<?php if( $show_title ) { ?>
<h5 class="widget-heading"><?php echo $heading_title?></h5>
<?php } ?>
<div class="widget-product-list <?php echo $addition_cls; ?>">
	<div class="widget-inner list">
            <?php foreach ($products as $product) { ?>
            <div class="w-product clearfix">
                <?php require( $productLayout );  ?>
            </div>
            <?php } ?>
	</div>
</div>
