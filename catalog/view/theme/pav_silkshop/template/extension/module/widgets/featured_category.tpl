<?php
	$col = isset($cols)?$cols:4;
	$span = 12/$col;
?>

<div class="hidden-xs hidden-sm panel <?php echo $addition_cls?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading panel-heading"><h4 class="panel-title"><span><?php echo $heading_title?></span></h4></div>
	<?php } ?>
	<div class="widget-inner">	
		<?php if(!empty($categories)) { ?>
			<div class="box-content">
				<ul class="list-unstyled row">
					<?php foreach ($categories as $category): ?>
					<li class="col-lg-<?php echo $span ?> col-md-<?php echo $span ?> col-sm-6 col-xs-12 item-category">
						<div class="feature-category feature-category-v1">
							<div class="image">
							<a href="<?php echo $category['href']; ?>">
								<?php if ($category['image'] !== '') { ?>
								<img src="image/<?php echo $category['image']; ?>" alt="" class="img-responsive">
								<?php
								} ?>
							</a>
							</div>
							<div class="caption">
								<h4 class="heading"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h4>
								<div class="items"><a class="text-lighten" href="<?php echo $category['href']; ?>"><?php echo $category['items']; ?></a></div>
							</div>	
						</div>					
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php } ?>
	</div>
</div>