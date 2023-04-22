<div class="list-category <?php echo $addition_cls; ?>">
	<?php if( $show_title ) { ?>
		<div class="widget-heading panel-heading block-borderbox">
			<h4 class="panel-title" data-number-split="2"><?php echo $heading_title?></h4>
		</div>
	<?php } ?>

	<div class="widget-inner tree-menu">
		<ul class="list-unstyled">
			<?php foreach ($categories_list as $category){ ?>
			<li><a href="<?php echo $category['href']; ?>"><span class="title"><?php echo $category['name']; ?></span></a></li>
			<?php } ?>
			<li><a href="<?php echo $link; ?>"><span class="title"><?php echo $view_more; ?></span> <i class="fa fa-angle-right"></i></a></li>
		</ul>
	</div>
</div>

