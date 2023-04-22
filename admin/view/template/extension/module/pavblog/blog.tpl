<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a class="btn btn-primary" onclick="$('#form').submit();"><?php echo $objlang->get("button_save"); ?></a>
				<a class="btn btn-success" onclick="$('#action_mode').val('save-edit');$('#form').submit();"><?php echo $objlang->get('button_save_edit'); ?></a>
				<a class="btn btn-info" onclick="$('#action_mode').val('save-new');$('#form').submit();"><?php echo $objlang->get('button_save_new'); ?></a>
				<?php if( $blog['blog_id'] ) { ?>
				<a class="btn btn-danger" href="<?php echo $action_delete;?>"><?php echo $objlang->get("button_delete"); ?></a>	
				<?php } ?>
			</div>
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
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php if( is_array($error_warning) ) { echo implode("<br>",$error_warning); } else { echo $error_warning; } ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">

				<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $action;?>">
					<input type="hidden" name="action_mode" id="action_mode" value=""/>
					<input type="hidden" name="pavblog_blog[blog_id]" value="<?php echo $blog['blog_id'];?>"/>

						<ul id="grouptabs" class="nav nav-tabs" role="tablist">
							<li>
								<a href="#tab-general" role="tab" data-toggle="tab"><?php echo $objlang->get("text_general"); ?></a>
							</li>
							<li>
								<a href="#tab-gallery" role="tab" data-toggle="tab"><?php echo $objlang->get("text_gallery"); ?></a>
							</li>
							<li>
								<a href="#tab-meta" role="tab" data-toggle="tab"><?php echo $objlang->get("text_meta"); ?></a>
							</li>
						</ul>

						<div class="tab-content">
							<div id="tab-general" class="tab-pane">

								<table class="table">
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_category_id');?></td>
										<td class="col-sm-10"><?php echo $menus;?></td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_status');?></td>
										<td class="col-sm-10">
											<select class="form-control" name="pavblog_blog[status]">
											<?php foreach( $yesno as $k=>$v ) { ?>
												<option value="<?php echo $k;?>" <?php if( $k==$blog['status'] ) { ?> selected="selected" <?php } ?>><?php echo $v;?></option>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_featured');?></td>
										<td class="col-sm-10">
											<select class="form-control" name="pavblog_blog[featured]">
											<?php foreach( $yesno as $k=>$v ) { ?>
												<option value="<?php echo $k;?>" <?php if( $k==$blog['featured'] ) { ?> selected="selected" <?php } ?>><?php echo $v;?></option>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_hits');?></td>
										<td class="col-sm-10">
											<input class="form-control" type="text" name="pavblog_blog[hits]" value="<?php echo $blog['hits'];?>">
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_tags');?></td>
										<td class="col-sm-10" style="width:20%">
											<input class="form-control" type="text" name="pavblog_blog[tags]" value="<?php echo $blog['tags'];?>" size="150">
											<br><i><?php echo $objlang->get('text_explain_tags');?></i>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_created');?></td>
										<td class="col-sm-10">
											<div class="input-group date" style="width:20%">
												<input type="text" name="pavblog_blog[created]" value="<?php echo $blog['created'];?>" placeholder="<?php //echo $entry_date_available; ?>" data-format="YYYY-MM-DD" id="input-pavblog-blog-created" class="form-control" />
												<span class="input-group-btn">
													<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										 	<script type="text/javascript"><!--
												$('.date').datetimepicker({
													pickTime: false
												});

												$('.time').datetimepicker({
													pickDate: false
												});

												$('.datetime').datetimepicker({
													pickDate: true,
													pickTime: true
												});
											//--></script> 


										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_creator');?></td>
										<td class="col-sm-10">
											<select class="form-control" name="pavblog_blog[user_id]">
												<?php foreach( $users as $user ) { ?> 
												<option value="<?php echo $user['user_id'];?>" <?php if( $user['user_id'] == $blog['user_id'] ){ ?>selected="selected"<?php } ?>><?php echo $user['username'];?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_keyword');?></td>
										<td class="col-sm-10"><input class="form-control" type="text" name="pavblog_blog[keyword]" size="100" value="<?php echo $blog['keyword'];?>"/></td>
									</tr>
								</table>

								<!-- Language-Blog -->
								<ul id="language-blog" class="nav nav-tabs" role="tablist">
									<?php foreach ($languages as $language) { ?>
									<li>
										<a href="#tab-language-<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
									</li>
									<?php } ?>
								</ul>
							
								<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="tab-language-<?php echo $language['language_id']; ?>">
									<table class="table">
										<tr>
											<td><?php echo $objlang->get('entry_title');?></td>
											<td><input  class="form-control" name="pavblog_blog_description[<?php echo $language['language_id'];?>][title]" size="120" value="<?php echo $pavblog_blog_descriptions[$language['language_id']]['title'];?>"/></td>
										</tr>
										<tr>
											<td><?php echo $objlang->get('entry_description');?></td>
											<td>
												<textarea id="pavblog_blog_description_title_lang<?php echo $language["language_id"];?>" class="form-control summernote" type="text" name="pavblog_blog_description[<?php echo $language['language_id'];?>][description]"  rows="6" cols="10"><?php echo $pavblog_blog_descriptions[$language['language_id']]['description'];?></textarea>
											</td>
										</tr>
										</tr>
										<tr>
											<td><?php echo $objlang->get('entry_content');?></td>
											<td>
												<textarea id="pavblog_blog_description_des_lang<?php echo $language["language_id"];?>" class="form-control summernote" type="text" name="pavblog_blog_description[<?php echo $language['language_id'];?>][content]"  rows="6" cols="10"><?php echo $pavblog_blog_descriptions[$language['language_id']]['content'];?></textarea>
											</td>
										</tr>
									</table>
								</div>
								<?php } ?>
								</div>

							</div><!-- end div .tab-general -->

							<div id="tab-gallery" class="tab-pane">
								<table class="table">
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_image');?></td>
										<td class="col-sm-8">
											<a href="" id="thumb-img" data-toggle="image" class="img-thumbnail">
												<img src="<?php echo empty($blog['thumb'])?$no_image:$blog['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" />
											</a>
											 <input type="hidden" name="pavblog_blog[image]" value="<?php echo $blog['image']; ?>" id="image" />
										</td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_video_code');?></td>
										<td class="col-sm-8"><textarea class="form-control" name="pavblog_blog[video_code]" rows="6" cols="40"><?php echo $blog['video_code'];?></textarea></td>
									</tr>
								</table>
							</div><!-- end div .tab-gallery -->

							<div id="tab-meta" class="tab-pane">
								<table class="table">
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_meta_title');?></td>
										<td class="col-sm-8"><input class="form-control" type="text" name="pavblog_blog[meta_title]" value="<?php echo $blog['meta_title'];?>"/></td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_meta_keyword');?></td>
										<td class="col-sm-8"><textarea class="form-control" name="pavblog_blog[meta_keyword]"><?php echo $blog['meta_keyword'];?></textarea></td>
									</tr>
									<tr>
										<td class="col-sm-2"><?php echo $objlang->get('entry_meta_description');?></td>
										<td class="col-sm-8"><textarea class="form-control" name="pavblog_blog[meta_description]" rows="6" cols="40"><?php echo $blog['meta_description'];?></textarea></td>
									</tr>
								</table>
							</div><!-- end div .tab-meta -->

						</div><!-- end div .tab-content -->
 
				</form>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->

	</div><!-- end div #page-content -->
		
</div>

<script type="text/javascript">

	$('#grouptabs li:first-child a').tab('show');

	$('#language-blog li:first-child a').tab('show');

	$(".action-delete").click( function(){ 
		return confirm( "<?php echo $objlang->get("text_confirm_delete");?>" );
	});

	// <?php foreach ($languages as $language) { ?>
	// $('#pavblog_blog_description_title_lang<?php echo $language["language_id"];?>').summernote({ height: 150 });
	// $('#pavblog_blog_description_des_lang<?php echo $language["language_id"]; ?>').summernote({ height: 150 });
	// <?php } ?>
	
</script>
<?php echo $footer; ?>
