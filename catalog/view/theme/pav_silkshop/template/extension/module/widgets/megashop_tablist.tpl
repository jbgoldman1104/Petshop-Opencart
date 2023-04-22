<?php
	$span = floor(12/$cols);
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


<div class="widget panel-default">
		<!-- title + list link -->
	<?php if( $show_title ) { ?>
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="link-categories pull-right hidden-xs hidden-sm tab-v2">
		<?php if (!empty($categories)): ?>
		<ul class="nav nav-tabs" role="tablist">
			<?php $i=0; foreach ($categories as $category): ?>
			<li class="<?php if($i==0) {?>active<?php } ?>">
				<a aria-expanded="false" href="#tablist-<?php echo $category["category_id"]; ?>" role="tab" data-toggle="tab"><?php echo $category["name"]; ?></a>
			</li>
			<?php $i++; endforeach ?>
		</ul>
		<?php endif ?>
	</div>
		
	<!-- content -->
	<div class="tab-content">
	<?php $k=0; foreach ($tablist as $key=>$value): ?>
		<div id="tablist-<?php echo $key; ?>" class="<?php if($k==0) {?>active in<?php } ?> tab-pane fade">			
			<div class="block-content owl-carousel-play hightlight" data-ride="owlcarousel">
				<?php if( count($value) > $itemsperpage ) { ?>

				<div class="carousel-controls">
					<a class="carousel-control left" href="#carousel<?php echo $id;?>" data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a class="carousel-control right" href="#carousel<?php echo $id;?>" data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>
				</div>	

				<?php } ?>
				<div class="owl-carousel product-grid"  data-show="<?php echo ($columns_count); ?>" data-pagination="false" data-navigation="true">
					<?php $pages = array_chunk( $value, $itemsperpage); ?>
					<?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="no-space-row item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							<div class="row products-row <?php ;if($i == count($tproducts) - $cols +1) { echo "last";} ?>"><?php //start box-product?>
							<?php } ?>
								<div class="col-lg-<?php echo $span;?> col-sm-<?php echo $span;?> col-xs-12 <?php if($i%$cols == 0) { echo "last";} ?> product-col">
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
	<?php $k++; endforeach ?>
	</div>
</div>