<?php
    $config = $sconfig;
    $theme  = $themename;

  
    $itemsperpage = 4;
    $cols = isset($customcols)? $customcols : 3;
    $span = 12/$cols;

    $id = md5(rand()+time()+$heading_title); 
    $columns_count  = 4;

    // Theme Config
    $themeConfig = (array)$config->get('themecontrol');
    $listingConfig = array(
        'category_pzoom'        => 1,
        'show_swap_image'       => 0,
        'quickview'             => 0,
        'product_layout'        => 'default',
        'catalog_mode'          => '',
    );
    $listingConfig              = array_merge($listingConfig, $themeConfig );
    $categoryPzoom              = $listingConfig['category_pzoom'];
    $quickview                  = $listingConfig['quickview'];
    $swapimg                    = ($listingConfig['show_swap_image'])?'swap':'';

    // Product Layout
    if( isset($_COOKIE[$theme.'_productlayout']) && $listingConfig['enable_paneltool'] && $_COOKIE[$theme.'_productlayout'] ){
        $listingConfig['product_layout'] = trim($_COOKIE[$theme.'_productlayout']);
    }
    $productLayout = DIR_TEMPLATE.$theme.'/template/common/product/'.$listingConfig['product_layout'].'.tpl';
    if( !is_file($productLayout) ){
        $listingConfig['product_layout'] = 'default';
    }
    $productLayout = DIR_TEMPLATE.$theme.'/template/common/product/'.$listingConfig['product_layout'].'.tpl'; 
?>
<div class="panel-heading">
    <h3 class="panel-title"><?php echo $heading_title; ?></h3>
</div>

<div class="list box-products owl-carousel-play" id="product_list<?php echo $id;?>" data-ride="owlcarousel">
    <?php if( count($products) > $itemsperpage ) { ?>
    <div class="carousel-controls hidden-xs hidden-sm">
        <a class="carousel-control left" href="#product_list<?php echo $id;?>"   data-slide="prev"><i class="fa fa-arrow-left"></i></a>
        <a class="carousel-control right" href="#product_list<?php echo $id;?>"  data-slide="next"><i class="fa fa-arrow-right"></i></a>
    </div>
    <?php } ?>
    <div class="owl-carousel product-grid"  data-show="1" data-pagination="false" data-navigation="true">

        <?php $pages = array_chunk( $products, $itemsperpage); ?>
            <?php foreach ($pages as  $k => $tproducts ) {   ?>
            <div class="item <?php if($k==0) {?>active<?php } ?> products-block">
                <?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
                    <?php if( $i%$cols == 1 || $cols == 1) { ?>
                    <div class="row products-row <?php ;if($i == count($tproducts) - $cols +1) { echo "last";} ?>"><?php //start box-product?>
                    <?php } ?>
                        <div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-6 col-xs-12 <?php if($i%$cols == 0) { echo "last";} ?> product-col">
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
<div class="clearfix"></div>

 <script type="text/javascript">
    $(document).ready(function() {
       var $carousel =  $("#<?php echo $id; ?>");
       $carousel.owlCarousel({
            autoPlay: false , //Set AutoPlay to 3 seconds
            items : <?php echo $cols; ?>,
            lazyLoad : true,
            navigation: false,
            navigationText:false,
            rewindNav: false,
            pagination:false

        });
        $("#wrap<?php echo $id; ?> .carousel-control.left").click(function(){
             $carousel.trigger('owl.prev');
        })
       $("#wrap<?php echo $id; ?> .carousel-control.right").click(function(){
            $carousel.trigger('owl.next');
        })
    });
</script>