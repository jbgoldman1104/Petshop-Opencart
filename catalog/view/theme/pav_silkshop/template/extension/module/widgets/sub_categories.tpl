<?php if( $show_title ) { ?><div class="widget-heading box-heading"><?php echo $heading_title?></div><?php } ?>

<div class="<?php echo $addition_cls; ?>">
	<ul>
		<?php foreach ($subcategories as $category){ ?>
		<li><a href="<?php echo $category['href']; ?>"><span class="title"><?php echo $category['name']; ?></span></a></li>
		<?php } ?>
	</ul>
</div>