<?php
	$span = 12/$cols;
	$id = rand(1,9)+substr(md5($heading_title),0,3);
	$themeConfig = (array)$this->config->get('themecontrol');
	$listingConfig = array(
		'category_pzoom'    => 1,
		'quickview'         => 0,
		'product_layout'	=> 'default',
		'enable_paneltool'	=> 0
	);
	$listingConfig = array_merge($listingConfig, $themeConfig );
	$quickview     = $listingConfig['quickview'];
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
	$columns_count  = 1;
?>


<div class="listproduct">

	<!-- title + list link -->
	<?php if( $show_title ) { ?>
	<div class="panel-heading"><h4 class="panel-title <?php echo $addition_cls; ?>"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="link-categories pull-right hidden-xs hidden-sm">
		<?php if (!empty($categories)): ?>
		<ul class="breadcrumb">
			<?php foreach ($categories as $category): ?>
			<li><a href="<?php echo $category["href"] ?>"><?php echo $category["name"] ?></a></li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
	</div>	

	<div class="panel-body">
		<div class="row">
		<?php  
			$col1 = $img_class;
			$col2 = 12 - $img_class;
		?>
		<!-- banner -->
		<?php if(!empty($banner)) { ?>
		<div class="border-right banner effect-v10 hidden-sm hidden-xs col-md-<?php echo $col1; ?> col-lg-<?php echo $col1; ?>">
			<a href="#"><img class="img-responsive" src="<?php echo $banner; ?>" alt="img"></a>
		</div>
		<?php } ?>
		
		<div class="col-lg-<?php echo $col2; ?> col-md-<?php echo $col2; ?>">
			<div class="box-products owl-carousel-play hightlight" data-ride="owlcarousel">
				<?php if( count($list1) > $itemsperpage ) { ?>
				<div class="carousel-controls">
					<a class="carousel-control left" href="#carousel<?php echo $id;?>"   data-slide="prev"><i class="fa fa-arrow-left"></i></a>
					<a class="carousel-control right" href="#carousel<?php echo $id;?>"  data-slide="next"><i class="fa fa-arrow-right"></i></a>
				</div>
				<?php } ?>
				<div class="owl-carousel product-grid"  data-show="<?php echo ($columns_count); ?>" data-pagination="false" data-navigation="true">
					<?php $pages = array_chunk( $list1, $itemsperpage); ?>
					<?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							<div class="row products-row <?php ;if($i == count($tproducts) - $cols +1) { echo "last";} ?>"><?php //start box-product?>
							<?php } ?>
								<div class="col-md-<?php echo $span;?> col-sm-<?php echo $span;?> col-xs-12 <?php if($i%$cols == 0) { echo "last";} ?> product-col">
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
		</div>
	</div>
</div>