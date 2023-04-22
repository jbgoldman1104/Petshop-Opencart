<div class="product-block">

    <?php if ($product['thumb']) {    ?>
      <div class="image">
        <?php if( $product['special'] ) {   ?>
          <span class="product-label sale-exist"><span class="product-label-special"><?php echo $objlang->get('text_sale'); ?></span></span>
        <?php } ?>

        <div class="product-img">
          <a class="img" title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>">
            <img class="img-responsive" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
          </a>

        </div>
          <div class="action-button">
              <div class="quickview hidden-xs hidden-sm">
                  <a class="iframe-link btn quick-view" data-toggle="tooltip" data-placement="top" href="<?php echo $ourl->link('themecontrol/product','product_id='.$product['product_id']);?>"  title="<?php echo $objlang->get('quick_view'); ?>" ><i class="fa fa-external-link"></i></a>
              </div>
          </div>
      </div>
    <?php } ?>
  <div class="product-meta">
      <div class="top">
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

        <?php if( isset($product['description']) ){ ?>
          <p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,1000);?>...</p>
        <?php } ?>
      </div>
        <div class="bottom">
          <div class="action add-links clearfix">

             <?php if( !isset($listingConfig['catalog_mode']) || !$listingConfig['catalog_mode'] ) { ?>
            <div class="cart">
               <button data-loading-text="Loading..." class="btn-action" type="button" onclick="cart.addcart('<?php echo $product['product_id']; ?>');">
                 <i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo $objlang->get("button_cart"); ?></span>
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

        </div>
  </div>
</div>





