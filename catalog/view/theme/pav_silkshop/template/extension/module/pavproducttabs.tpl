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
?>
<div class="box producttabs">
<?php if( !empty($module_description) ) { ?>
 <div class="module-desc">
	<?php echo $module_description;?>
 </div>
 <?php } ?>
  <div class="tab-nav">
	<ul class="nav nav-tabs" id="producttabs<?php echo $id;?>">
		<?php foreach( $tabs as $tab => $products ) { if( empty($products) ){ continue;}  ?>
			 <li><a href="#tab-<?php echo $tab.$id;?>" data-toggle="tab"><?php echo $objlang->get('text_'.$tab)?></a></li>
		<?php } ?>
	</ul>
  </div>


	<div class="tab-content">
		<?php foreach( $tabs as $tab => $products ) {
				if( empty($products) ){ continue;}
			?>
			<div class="tab-pane box-products  tabcarousel<?php echo $id; ?> slide" id="tab-<?php echo $tab.$id;?>">

				<?php if( count($products) > $itemsperpage ) { ?>
				<div class="carousel-controls">
				<a class="carousel-control left" href="#tab-<?php echo $tab.$id;?>"   data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#tab-<?php echo $tab.$id;?>"  data-slide="next">&rsaquo;</a>
				</div>
				<?php } ?>
				<div class="carousel-inner ">
				 <?php
					$pages = array_chunk( $products, $itemsperpage);
				//	echo '<pre>'.print_r( $pages, 1 ); die;
				 ?>
				  <?php foreach ($pages as  $k => $tproducts ) {   ?>
						<div class="item <?php if($k==0) {?>active<?php } ?>">
							<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
								<?php if( $i%$cols == 1 ) { ?>
								  <div class="row box-product">
								<?php } ?>
									  <div class="col-lg-<?php echo $span;?> col-sm-<?php echo $span;?> col-xs-12 product-block">
									  <div class="product-thumb product-inner">
											<?php if ($product['thumb']) { ?>
											<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
											<?php } ?>
											<div class="caption">
												<div class="name"><h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4></a></div>
												<div class="description">
													<?php echo utf8_substr( strip_tags($product['description']),0,58);?>...
												</div>
												<?php if ($product['price']) { ?>
												<div class="price">
												  <?php if (!$product['special']) { ?>
												  <?php echo $product['price']; ?>
												  <?php } else { ?>
												  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
												  <?php } ?>
												</div>
												<?php } ?>
												<?php if ($product['rating']) { ?>
												<div class="rating">
												  <?php for ($i = 1; $i <= 5; $i++) { ?>
												  <?php if ($product['rating'] < $i) { ?>
												  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
												  <?php } else { ?>
												  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
												  <?php } ?>
												  <?php } ?>
												</div>
												<?php } ?>
											</div>	
											<div class="button-group">
												<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
												<button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
												<button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
											</div>
										</div>
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


<script>
$(function () {
$('#producttabs<?php echo $id;?> a:first').tab('show');
})
$('.tabcarousel<?php echo $id;?>').carousel({interval:false,auto:false,pause:'hover'});
</script>
