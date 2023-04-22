 <?php 
	echo $header; 
	echo $column_left; 
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
			<div class="panel-body" style="height:520px;">
				
				<div class="col-sm-7">
					<div class="tool-icons clearfix" style="width:100%">
						<h4><?php echo $objlang->get('text_quickicons');?></h4>
						<ul>
							<li><a href="<?php echo $menus["contact"]["link"];?>"><span class="icon-blogs icon"></span><span><?php echo $objlang->get('menu_create_newsletter')?></span></a></li>
							<li><a href="<?php echo $menus["draft_contact"]["link"];?>"><span class="icon-addcategory icon"></span><span><?php echo $objlang->get('menu_manage_draft_newsletters')?></span></a></li>
							<li><a href="<?php echo $menus["subscribes"]["link"];?>"><span class="icon-category icon"></span><span><?php echo $objlang->get('menu_manage_subscribes')?></span></a></li>
							<li><a href="<?php echo $menus["modules"]["link"];?>"><span class="icon-comment icon"></span><span><?php echo $objlang->get('menu_manage_modules')?></span></a></li>
							<?php  /*
							<li><a href="<?php echo $menus["templates"]["link"];?>"><span class="icon-blog icon"></span><span><?php echo $objlang->get('menu_templates')?></span></a></li>
							<li><a href="<?php echo $menus["config"]["link"];?>"><span class="icon-modules icon"></span><span><?php echo $objlang->get('menu_global_config')?></span></a></li>
							*/ ?>
						</ul>
					</div>

				</div>
			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<?php echo $footer; ?>
