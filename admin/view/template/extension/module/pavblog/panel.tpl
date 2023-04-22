<?php 
	echo $header; 
	echo $column_left; 
	$module_row=0; 
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- end div .page-header -->

	<div id="page-content" class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">
				<div class="col-sm-7">
					<div class="tool-icons clearfix">
						<h4><?php echo $objlang->get('text_quickicons');?></h4>
						<ul>
							<li><a href="<?php echo $manage_category_link;?>"><span class="icon-category icon"></span><span><?php echo $objlang->get('databroad_categories')?></span></a></li>
							<li><a href="<?php echo $add_category_link;?>"><span class="icon-addcategory icon"></span><span><?php echo $objlang->get('databroad_add_category')?></span></a></li>
							<li><a href="<?php echo $manage_blog_link;?>"><span class="icon-blogs icon"></span><span><?php echo $objlang->get('databroad_blogs')?></span></a></li>
							<li><a href="<?php echo $add_blog_link;?>"><span class="icon-blog icon"></span><span><?php echo $objlang->get('databroad_add_blog')?></span></a></li>
							<li><a href="<?php echo $manage_comment_link;?>"><span class="icon-comment icon"></span><span><?php echo $objlang->get('databroad_comment')?></span></a></li>
							<li><a href="<?php echo $modules_setting_link;?>"><span class="icon-modules icon"></span><span><?php echo $objlang->get('databroad_modules_setting')?></span></a></li>
							<li><a href="<?php echo $frontend_modules_link;?>"><span class="icon-front-modules icon"></span><span><?php echo $objlang->get('menu_frontend_module_setting')?></span></a></li>
						</ul>
					</div>
					<div class="clearfix pav-toolbar" style="width:100%">
						<h4><?php echo $objlang->get('text_modules_setting');?></h4>
						<ul>
							<li>
								<a target="_blank" href="<?php echo $objurl->link('extension/module/pavblog/frontmodules','token='.$token.'#tab-module-pavblogcategory');?>">
								<span class="icon-modules"></span><span><?php echo $objlang->get('module_latest');?></span></a>
							</li>
							<li>
								<a target="_blank" href="<?php echo $objurl->link('extension/module/pavblog/frontmodules','token='.$token.'#tab-module-pavblogcomment');?>">
								<span class="icon-modules"></span><span><?php echo $objlang->get('module_comment');?></span></a>
							</li>
							<li>
								<a target="_blank" href="<?php echo $objurl->link('extension/module/pavblog/frontmodules','token='.$token.'#tab-module-pavbloglatest');?>">
								<span class="icon-modules"></span><span><?php echo $objlang->get('module_category');?></span></a>
							</li>
						</ul>
						
						<div class="suggest-urls">
							<div>
								<h4><?php echo $objlang->get('text_modules_urls');?></h4>
								<ol>	
									<li>
										<div><b><?php echo $objlang->get('text_front_page');?></b></div>

										 <?php echo $objlang->get('text_normal');?>: <?php echo HTTPS_CATALOG."index.php?route=pavblog/blogs";?><br>
										 <?php echo $objlang->get('text_seo');?>: <?php echo HTTPS_CATALOG. $module_setting['keyword_listing_blogs_page']; ?>
									</li>

									<li>

										<div><b><?php echo $objlang->get('text_category_page'); ?></b></div>
									 
										<?php echo $objlang->get('text_normal');?>: <?php echo HTTPS_CATALOG."index.php?route=pavblog/category&id=";?>CATEGORY_ID <br>
										<?php echo $objlang->get('text_seo');?>: <?php echo HTTPS_CATALOG.'<b>Category - Keyword</b>';?>	
									</li>
									<li>
										<div><b><?php echo $objlang->get('text_item_page')?></b>: </div>
										<?php echo $objlang->get('text_normal');?>: <?php echo HTTPS_CATALOG."index.php?route=pavblog/blog/id=";?>BLOG_ID<br>
										<?php echo $objlang->get('text_seo');?>: <?php echo HTTPS_CATALOG.'<b>Blog - Keyword</b>';?>	
									</li>
									
									<li>
										<div><b><?php echo $objlang->get('text_filter_blog');?></b></div>
										<?php echo $objlang->get('text_normal');?>: <?php echo HTTPS_CATALOG."index.php?route=pavblog/blogs&tag=";?><b>TAG_NAME</b><br>
										<?php echo $objlang->get('text_seo');?>: <?php echo $objlang->get('text_seo');?>: <?php echo HTTPS_CATALOG. $module_setting['keyword_listing_blogs_page']; ?>?tag=<b>TAG_NAME</b>
									</li>
								</ol>
							</div>
						</div>
						<div id="guide-links">
							<b><?php echo $objlang->get('text_guide_urls');?></b>: 
							<a href="http://www.pavothemes.com/guides/pavblog/#setup-seo"><?php echo $objlang->get('text_guide_seo');?></a> -
							<a href="http://www.pavothemes.com/guides/pavblog/#manage-category"><?php echo $objlang->get('text_guide_category');?></a> -
							<a href="http://www.pavothemes.com/guides/pavblog/#manage-blog"><?php echo $objlang->get('text_guide_blog');?></a> -
							<a href="http://www.pavothemes.com/guides/pavblog/#module-setting"><?php echo $objlang->get('text_guide_module_setting');?></a>
						</div>
					</div>
				</div>
				<div class="col-sm-5">
					<ul id="grouptabs" class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#tab-newest" role="tab" data-toggle="tab"><?php echo $objlang->get('latest_blog'); ?></a></li>
						<li><a href="#tab-mostread" role="tab" data-toggle="tab"><?php echo $objlang->get('most_read');?></a></li>
						<li><a href="#tab-comment" role="tab" data-toggle="tab"><?php echo $objlang->get('latest_comment');?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab-newest">
							<ul>
							<?php foreach( $newest as $blog ) { ?>
								<li>
									<a href="<?php echo $objurl->link("module/pavblog/blog","id=".$blog['blog_id']."&token=".$token);?>"><?php echo $blog['title'];?></a>
								</li>
							<?php } ?>
							</ul>
						</div>
						<div class="tab-pane" id="tab-mostread">
							<ul>
							<?php foreach( $mostread as $blog ) { ?>
								<li>
									<a href="<?php echo $objurl->link("module/pavblog/blog","id=".$blog['blog_id']."&token=".$token);?>"><?php echo $blog['title'];?></a>
								</li>
							<?php } ?>
							</ul>
						</div>
						<div class="tab-pane" id="tab-comment">
							<ul>
								<?php foreach( $comments as $comment ) { ?>
								<li><a href="<?php echo $objurl->link("module/pavblog/comment","id=".$comment['comment_id']."&token=".$token);?>"><?php echo utf8_substr($comment['comment'],0,100);?></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div><!-- end div .panel-body -->

		</div><!-- end div .panel -->

	</div><!-- end div #page-content -->

</div><!-- end div #content -->

<!-- Modal Form Guide Link-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $objlang->get('Guide');?></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $objlang->get('close'); ?></button>
			</div>
		</div> 
	</div> 
</div>	
<script type="text/javascript">

	$("#guide-links a").click( function(){

		$('#myModal1 .modal-dialog').css('width',1170);
		var a = $( '<span class="glyphicon glyphicon-refresh"></span><iframe frameborder="0" scrolling="yes" src="'+$(this).attr('href')+'" style="width:100%;height:500px; display:none"/>'  );
		$('#myModal1 .modal-body').html( a );
			
		$('#myModal1').modal('show');
		$('#myModal1').attr('rel', $(this).attr('rel') );
		$(a).load( function(){  
			$('#myModal1 .modal-body .glyphicon-refresh').hide();
			$('#myModal1 .modal-body iframe').show();
		});

		return false; 
		
	});
</script>
<?php echo $footer; ?>
