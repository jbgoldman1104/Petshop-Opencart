<?php if( $show_title ) { ?>
<h4 class="widget-heading title"><?php echo $heading_title?></h4>
<?php } ?>

<div class="<?php echo $addition_cls; ?>">
	<ul class="content list-unstyled">
		<?php foreach ($subcategories as $category){ ?>
		<li>
            <a href="<?php echo $category['href']; ?>">
                <span><?php echo $category['name']; ?></span>
            </a>
        </li>
		<?php } ?>
	</ul>
</div>