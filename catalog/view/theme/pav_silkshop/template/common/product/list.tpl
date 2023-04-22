<div class="product-block">

    <?php if ($product['thumb']) {    ?>
    <div class="image pull-left">
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
    <div class="media-body">
        <div class="product-meta">
            <h6 class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h6>
            <?php if( isset($product['description']) ){ ?>
            <!-- <p class="description"><?php echo utf8_substr( strip_tags($product['description']),0,220);?>...</p>
            <?php } ?> -->

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
        </div>
    </div>
</div>





