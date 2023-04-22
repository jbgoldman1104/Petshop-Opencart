<?php 
	$span = 12/$cols; 
	$id = rand(1,9);
	$config = $this->registry->get('config');
	$button_cart = $this->language->get('button_cart');
	$columns_count  = 1;
?>
<div class="<?php echo $addition_cls; ?>productdeals list-product panel panel-default">
	<?php if( $show_title ) { ?>
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="panel-body">
 		<div class="box-products slide owl-carousel-play" data-ride="owlcarousel" id="widget-todaydeals-<?php echo $id;?>">

			<?php if( count($products) > $items ) { ?>
			<div class="carousel-controls">
				<a class="carousel-control left" href="#widget-todaydeals-<?php echo $id;?>"   data-slide="prev"><i class="fa fa-arrow-left"></i></a>
				<a class="carousel-control right" href="#widget-todaydeals-<?php echo $id;?>"  data-slide="next"><i class="fa fa-arrow-right"></i></a>
			</div> 
			<?php } ?>
			<div class="owl-carousel" data-show="<?php echo ($columns_count); ?>" data-pagination="false" data-navigation="true">	
			 <?php $pages = array_chunk( $products, $items);?>
			 <?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							<div class="row">
							<?php } ?>
								<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-12 col-xs-12 product-col">
							  		<?php require( DIR_TEMPLATE.$config->get('config_template').'/template/common/product/deal_default.tpl');?>
								</div>
							<?php if( $i%$cols == 0 || $i==count($tproducts) ) { ?>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
			  <?php } ?>
			</div> 
		</div>
	</div>
</div>