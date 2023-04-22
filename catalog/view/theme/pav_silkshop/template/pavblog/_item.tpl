<div class="blog-item">

		<?php if( $cat_show_title ) { ?>
	<div class="image space-padding-tb-20">
		<?php if( $blog['thumb'] && $cat_show_image )  { ?>
		<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" class="img-responsive"/>
		<?php } ?>

	</div>		
	<div class="blog-body">
        <div class="blog-date">
            <?php if( $cat_show_created ) { ?>
			<span class="create">
				<span class="day"><?php echo date("d",strtotime($blog['created']));?></span>
			<span class="month"><?php echo date("M",strtotime($blog['created']));?></span> /
			<span class="month"><?php echo date("y",strtotime($blog['created']));?></span>
			</span>
            <?php } ?>
            <?php if( $blog_show_category ) { ?>
                    <span class="publishin"> -
                         <b><?php echo $objlang->get("text_published_in");?></b>
                        <a class="color" href="<?php echo $blog['category_link'];?>" title="<?php echo $blog['category_title'];?>"><?php echo $blog['category_title'];?></a>
                    </span>
            <?php } ?>
        </div>
        <div class="blog-header">
			<h4 class="blog-title">	<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a></h4>
		<?php } ?>
		</div>
		<?php if( $cat_show_description ) {?>
		<div class="description">
			<?php echo utf8_substr( $blog['description'],0, 180 );?>...
		</div>
		<?php } ?>
		<?php if( $cat_show_readmore ) { ?>
			<a href="<?php echo $blog['link'];?>" class="text-link text-uppercase font-size-12"><?php echo $objlang->get('text_readmore');?><i class="fa fa-angle-right"></i></a>
		<?php } ?>
	</div>			
</div>
