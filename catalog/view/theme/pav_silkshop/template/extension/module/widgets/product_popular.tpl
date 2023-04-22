<?php 
	$span = 12/$cols; 
	$config = $this->registry->get('config');
?>
<div class="<?php echo $addition_cls; ?> panel panel-default">
	<?php if( $show_title ) { ?>
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title?></h4></div>
	<?php } ?>
	<div class="panel-body">
 		<div class="box-products slide carousel" id="widget-popular">

			<?php if( count($products) > $items ) { ?>
			<div class="carousel-controls">
				<a class="carousel-control left" href="#widget-popular" data-slide="prev"><i class="fa fa-angle-left"></i></a>
				<a class="carousel-control right" href="#widget-popular" data-slide="next"><i class="fa fa-angle-right"></i></a>
			</div> 
			<?php } ?>
			<div class="carousel-inner ">		
			 <?php $pages = array_chunk( $products, $items);?>
			 <?php foreach ($pages as  $k => $tproducts ) {   ?>
					<div class="item <?php if($k==0) {?>active<?php } ?>">
						<?php foreach( $tproducts as $i => $product ) {  $i=$i+1;?>
							<?php if( $i%$cols == 1 || $cols == 1) { ?>
							<div class="row products-row">
							<?php } ?>
								<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-12 col-xs-12 product-col border">
							  		<?php require( DIR_TEMPLATE.$config->get('config_template').'/template/common/product/default.tpl');?>
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
