<?php $objlang = $this->registry->get('language');  $ourl = $this->registry->get('url');   ?>
<div class="product-block item-full clearfix">
  <?php if ($product['thumb']) {    ?>      
      <div class="image">
        <?php if( $product['special'] ) {   ?>
          <span class="product-label sale-exist"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
        <?php } ?>

        <div class="product-img img">
          <a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
            <img class="img-responsive" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
          </a>     
        </div>
      </div>
    <?php } ?>
         
  <div class="product-meta contents">   
    <h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>

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

    <?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
      <div class="cart">            
        <button data-loading-text="Loading..." class="btn btn-action" type="button" onclick="cart.addcart('<?php echo $product['product_id']; ?>');">
          <span class="text-cart"><?php echo $button_cart; ?></span>
        </button>
      </div>
    <?php } ?>

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





