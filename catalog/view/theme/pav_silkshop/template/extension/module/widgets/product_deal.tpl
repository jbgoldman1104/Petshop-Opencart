<?php
	$config = $this->registry->get('config'); 

	$theme  = $config->get('config_template');

	//$cols = 12/$limit; 
	$span = 12/$cols; 
	$active = 'latest';
	$id = "wddeals-" . rand(1,9);

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
 	$objlang = $this->registry->get('language');
	$load = $this->registry->get("load");
	$language = $load->language("module/themecontrol");
	$text_sale = $language['text_sale'];
	$text_days = $language['text_days'];
	$text_hours = $language['text_hours'];
	$text_minutes = $language['text_minutes'];
	$text_seconds = $language['text_seconds'];
	$text_finish = $language['text_finish'];
?>

<div class="productdeals panel panel-default <?php echo $addition_cls; ?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading panel-heading block-borderbox"><h4 class="panel-title"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="widget-inner panel-body">
		


		<div class="box-products owl-carousel-play" id="pavdeals<?php echo $id;?>" data-ride="owlcarousel">
			<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls carousel-center">
					<a class="carousel-control left" href="#pavdeals<?php echo $id;?>"   data-slide="prev"><i class="fa fa-angle-left"></i></a>
					<a class="carousel-control right" href="#pavdeals<?php echo $id;?>"  data-slide="next"><i class="fa fa-angle-right"></i></a>
				</div> 
			<?php } ?>
			<div class="owl-carousel" data-show="1" data-pagination="false" data-navigation="true">	
			 <?php
				$pages = array_chunk( $products, $itemsperpage);
			 ?>

			 <?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							  <div class="row products-row">
							<?php } ?>
								  <div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-12 col-xs-12">
								  		<!-- ################ -->
								  		<?php $objlang = $this->registry->get('language');  $ourl = $this->registry->get('url');   ?>



<div class="product-block item-full">
  <?php if ($product['thumb']) {    ?>      
      <div class="image">
        <?php if( $product['special'] ) {   ?>
          <span class="product-label sale-exist"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
        <?php } ?>

        <div class="product-img img">
          <a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
            <img class="img-responsive" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
          </a>
          <div class="quickview hidden-xs hidden-sm">
            <a class="iframe-link btn quick-view" data-toggle="tooltip" data-placement="top" href="<?php echo $ourl->link('themecontrol/product','product_id='.$product['product_id']);?>"  title="<?php echo $objlang->get('quick_view'); ?>" ><i class="fa fa-arrows-alt"></i><?php echo $objlang->get('quick_view'); ?></a>
          </div>
          <div class="zoom hidden-xs hidden-sm hover-icon">
            <?php if( isset($categoryPzoom) && $categoryPzoom ) { $zimage = str_replace( "cache/","", preg_replace("#-\d+x\d+#", "",  $product['thumb'] ));  ?>
              <a data-toggle="tooltip" data-placement="top" href="<?php echo $zimage;?>" class="product-zoom info-view colorbox cboxElement" title="<?php echo $product['name']; ?>"><?php echo $objlang->get('text_zoom'); ?></a>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
         
  <div class="product-meta">   
    <?php if ($product['rating']) { ?>
          <div class="rating">
            <?php for ($is = 1; $is <= 5; $is++) { ?>
            <?php if ($product['rating'] < $is) { ?>
            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
            <?php } else { ?>
            <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i>
            </span>
            <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
        
        <h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>
        <?php if( isset($product['description']) ){ ?> 
        <p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,200);?>...</p>
        <?php } ?>

        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) {  ?>
            <span class="price-new"><?php echo $product['price']; ?></span>
            <?php if( preg_match( '#(\d+).?(\d+)#',  $product['price'], $p ) ) { ?> 
            <?php } ?>
          <?php } else { ?>
            <span class="price-new"><?php echo $product['special']; ?></span>
            <span class="price-old"><?php echo $product['price']; ?></span> 
            <?php if( preg_match( '#(\d+).?(\d+)#',  $product['special'], $p ) ) { ?> 
            <?php } ?>

          <?php } ?>
        </div>
        <?php } ?>  
        <div class="action add-links clearfix">

          <?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
            <div class="cart">            
               <button data-loading-text="Loading..." class="btn-action" type="button" onclick="cart.addcart('<?php echo $product['product_id']; ?>');">
                 <i class="fa fa-shopping-cart space-padding-lr-10"></i><span class="hidden-sm hidden-md"><?php echo $button_cart; ?></span>
              </button>
            </div>
          <?php } ?>

            <div class="compare">     
              <button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_compare"); ?>" onclick="compare.addcompare('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button> 
            </div>  
            <div class="wishlist">
              <button class="btn-action" type="button" data-toggle="tooltip" data-placement="top" title="<?php echo $objlang->get("button_wishlist"); ?>" onclick="wishlist.addwishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button> 
            </div>      

          </div>
    <div class="footer-deals">      
      <div id="item_countdown_<?php echo $product['product_id']; ?>" class="item-countdown clearfix"></div>
    </div>
  </div>  
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    $("#item_countdown_<?php echo $product['product_id']; ?>").lofCountDown({
      formatStyle:2,
      TargetDate:"<?php echo date('m/d/Y G:i:s', strtotime($product['date_end_string'])); ?>",
      DisplayFormat:"<ul class='list-inline'><li class='days'> %%D%% <span><?php echo $objlang->get("text_days");?></span></li><li class='hours'> %%H%% <span><?php echo $objlang->get("text_hours");?></span></li><li class='minutes'> %%M%% <span><?php echo $objlang->get("text_minutes");?></span></li><li class='seconds'> %%S%% <span><?php echo $objlang->get("text_seconds");?></span></li></ul>",
      FinishMessage: "<?php echo $objlang->get('text_finish');?>"
    });
  });
</script>






								  		<!-- ################ -->
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
 