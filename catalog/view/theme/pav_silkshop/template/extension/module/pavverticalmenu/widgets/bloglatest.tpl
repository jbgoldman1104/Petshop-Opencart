 
<?php   if( !empty($blogs) ) { ?>

	<div class="widget-blogs  <?php $addition_cls?> <?php if ( isset($stylecls)&&$stylecls) { ?>-<?php echo $stylecls; ?><?php } ?>">
        <?php if( $show_title ){ ?>
        <h4 class="widget-heading title">
            <?php echo $heading_title; ?>
        </h4>
        <?php } ?>


	<div class="widget-inner -content">
				<div class="pavblog-latest row">
					<?php foreach( $blogs as $key => $blog ) { $key = $key + 1;?>
					<div class="col-lg-<?php echo floor(floor(12/$cols));?> col-md-<?php echo floor(floor(12/$cols));?> col-sm-<?php echo floor(floor(12/$cols));?>">
						<div class="blog-item">					
							<div class="blog-body">
								<?php if( $blog['thumb']  )  { ?>
									<div class="image">
										<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" alt="<?php echo $blog['title'];?>" class="img-responsive"/>
									</div>
								<?php } ?>
								<div class="create-info">
									<div class="inners">
										<div class="blog-header">
											<h4 class="blog-title">
												<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a>
											</h4>
										</div>
                                        <div class="create-date">
                                            <div class="created">
                                                <span class="day"><?php echo date("d",strtotime($blog['created']));?></span>
                                                <span class="month"><?php echo date("M",strtotime($blog['created']));?></span>
                                            </div>
                                        </div>
										<div class="description">
											<?php $blog['description'] = strip_tags($blog['description']); ?>
											<?php echo utf8_substr( $blog['description'],0, 40);?>...
										</div>
									</div>							
								</div>						
							</div>
						</div>
					</div>
					<?php if( ( $key%$cols==0 || $key == count($blogs)) ){  ?>

					<?php } ?>
					<?php } ?>
				</div>
				<?php } ?>
 	</div>

</div>
