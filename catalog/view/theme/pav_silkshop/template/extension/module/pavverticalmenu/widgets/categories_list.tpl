<?php if( $show_title ) { ?>
<h4 class="widget-heading"><?php echo $heading_title?></h4>
<?php } ?>

<div class="widget-inner <?php echo $addition_cls; ?>">
	<ul>
		<?php foreach ($categories_list as $category){ ?>
		<li><a href="<?php echo $category['href']; ?>"><span class="title"><?php echo $category['name']; ?></span></a></li>
		<?php } ?>
	</ul>
</div>