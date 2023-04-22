<?php if( $show_title ) { ?>
<h5 class="widget-heading title hidden-xs hidden-sm"><?php echo $heading_title?></h5>
<?php } ?>

<div class="<?php echo $addition_cls; ?>">
	<ul class="content">
		<?php foreach ($subcategories as $category){ ?>
		<li>
            <a href="<?php echo $category['href']; ?>">
                <span><?php echo $category['name']; ?></span>
            </a>
        </li>
		<?php } ?>
	</ul>
</div>