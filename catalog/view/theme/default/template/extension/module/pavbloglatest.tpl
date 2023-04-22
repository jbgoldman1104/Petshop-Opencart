<div class="box ">
	<h3 class="box-heading"><?php echo $heading_title; ?></h3>
	<div class="box-content" >
		<?php if( !empty($blogs) ) { ?>
		<div class="pavblog-latest clearfix">
			<?php foreach( $blogs as $key => $blog ) { $key = $key + 1;?>
			<div class="pavcol<?php echo $cols;?>">
					<div class="blog-item">
							<div class="blog-header clearfix">
							<h4 class="blog-title">
								<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a>
							</h4>
							</div>
							<div class="blog-body">
								<?php if( $blog['thumb']  )  { ?>
								<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" align="left"/>
								<?php } ?>
								<div class="description">
										<?php $blog['description'] = strip_tags($blog['description']); ?>
										<?php echo utf8_substr( $blog['description'],0, 200 );?>...
								</div>
								<a href="<?php echo $blog['link'];?>" class="readmore"><?php echo $objlang->get('text_readmore');?></a>
							</div>	
						</div>
			</div>
			<?php if( ( $key%$cols==0 || $key == count($blogs)) ){  ?>
				<div class="clearfix"></div>
			<?php } ?>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
 </div>
