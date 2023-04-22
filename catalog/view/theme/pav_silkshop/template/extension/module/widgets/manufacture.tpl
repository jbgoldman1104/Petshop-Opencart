<?php $id = rand(1,10); $span =  12/$columns; ?>
   <div class="hidden-xs widget-carousel owl-carousel-play carousel-ed slide <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>box-<?php echo $stylecls;?><?php } ?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading box-heading"><?php echo $heading_title?></div>
	<?php } ?>


		<div class="carousel-inner owl-carousel" data-show="1" data-pagination="false" data-navigation="true">
			<?php

			$pages = array_chunk( $banners, $itemsperpage );?>

			<?php foreach ($pages as $k => $tbanners) {?>
			<div class="item <?php if($k==0) {?>active<?php } ?> space-padding-lr-10">
				<?php foreach( $tbanners as $i => $banner ) {  $i=$i+1;?>
					<?php if( $i%$columns == 1 ) { ?>
					<div class="row">
					<?php } ?>

					<div class="col-lg-<?php echo $span;?> col-md-<?php echo $span;?> col-sm-<?php echo $span;?> col-xs-12">
						<div class="item-inner">
							<?php if ($banner['link']) { ?>
							<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
							<?php } else { ?>
							<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
							<?php } ?>
						</div>
					</div>

					<?php if( $i%$columns == 0 || $i==count($tbanners) ) { ?>
					</div>
					<?php } ?>
				<?php } //endforeach; banner ?>
			</div>
			<?php } //endforeach; pages?>	
		</div>

		<?php if( count($banners) > $itemsperpage ){ ?>	
		<div class="carousel-controls">
			<a class="carousel-control left" href="#pavcarousel<?php echo $id;?>" data-slide="prev"><i class="fa fa-angle-left"></i></a>
			<a class="carousel-control right" href="#pavcarousel<?php echo $id;?>" data-slide="next"><i class="fa fa-angle-right"></i></a>
		</div>		
		<?php } ?>

    </div>