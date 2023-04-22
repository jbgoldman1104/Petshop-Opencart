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
			<div class="panel-body" >

				<div class="col-sm-2">
					<div class="logo"><h3><?php echo $heading_title; ?></h3></div>
					<div class="slidebar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
					<div class="clear clr"></div>
				</div>

				<div class="col-sm-10">
					<div class="heading">
						<h3><?php echo $objlang->get("text_frontend_modules"); ?></h1>
					</div>
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="content">
						<div class="col-sm-2">
							<ul class="nav nav-pills nav-stacked">
								<?php if ($extensions) { ?>
								<?php foreach ($extensions as $extension) { ?>
								<?php $actived = (empty($module_id))?"class='active'":''; ?>
								<li <?php echo $actived; ?>><a href="<?php echo $extension['edit']; ?>" ><i class="fa fa-plus-circle"></i> <?php echo $extension['name']; ?></a></li>
								<?php $i=0; foreach ($extension['module'] as $module) { $i++;?>
								<?php $active = ($module['module_id'] == $module_id)?'class="active"':''; ?>
								<li <?php echo $active; ?>><a href="<?php echo $module['edit']; ?>" ><i class="fa fa-minus-circle"></i> <?php echo $module['name']; ?></a></li>
								<?php } //end modules?>
								<?php } //end extensions?>
								<?php } //end if?>
							</ul>
						</div>
						<div class="col-sm-10">
							<div class="clearfix">
								<a class="btn btn-success" title="" onclick="$('#form').submit();" data-toggle="tooltip" data-original-title="Save"><i class="fa fa-save"> Save </i></a>
								<?php if(!empty($module_id)) { ?>
								<a onclick="confirm('Are you sure?') ? location.href='<?php echo $delete; ?>' : false;" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"> Delete</i></a>
								<?php } ?>
							</div>
							<hr>
							<div class="tab-content" id="tab-content-newsletter">
								<div class="tab-pane active" id="tab-module-newsletter">
									<table class="table noborder">
										<tr>
											<td class="col-sm-2">
												<?php echo $objlang->get('text_display_mode'); ?>
											</td>

											<td class="col-sm-10">
													<select name="displaymode" id="input-status" class="form-control">
														<?php foreach( $modes as $key => $val ) { ?>
														<?php $selected = ( $displaymode == $key ) ? 'selected="selected"' : "" ; ?>
														<option <?php echo $selected; ?> value="<?php echo $key?>"><?php echo $val; ?></option>
														<?php } ?>
													</select>	
											</td>
										</tr>
										<tr>
											<td class="col-sm-2"><?php echo $objlang->get('entry_module_name'); ?></td>
											<td class="col-sm-10">
												<input class="form-control" type="text" placeholder="<?php echo $objlang->get('entry_module_name'); ?>" value="<?php echo $name; ?>" name="name" />
											</td>
										</tr>
										<tr>
											<td class="col-sm-2"><?php echo $entry_status; ?></td>
											<td class="col-sm-10">
												<select name="status" id="input-status" class="form-control">
													<?php if($status) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
													<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</table>
									<ul class="nav nav-tabs" id="language">
										<?php foreach ($languages as $language) {?>
										<li><a href="#tab-module-language-<?php echo $language["language_id"]; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php foreach ($languages as $language) {?>
										<div class="tab-pane " id="tab-module-language-<?php echo $language["language_id"]; ?>">
											<table class="table noborder">
												<tr>
													<td class="col-sm-2"><?php echo $objlang->get("entry_description"); ?></td>
													<td class="col-sm-10">
														<textarea class="form-control summernote" id="description-<?php echo $language["language_id"]; ?>" name="description[<?php echo $language['language_id']; ?>]">
															<?php echo isset($description[$language['language_id']])?$description[$language['language_id']]:''; ?>
														</textarea>
													</td>
												</tr>
												<tr>
													<td class="col-sm-2"><?php echo $objlang->get("entry_social_icon"); ?></td>
													<td class="col-sm-10">
														<textarea class="form-control summernote" id="social-<?php echo $language["language_id"]; ?>" name="social[<?php echo $language['language_id']; ?>]">
															<?php echo isset($social[$language['language_id']])?$social[$language['language_id']]:''; ?>
														</textarea>
														<span class="help"><?php echo $objlang->get('about_entry_social_icon');?></span>
													</td>
												</tr>
											</table>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<script type="text/javascript">
	$('#language a:first').tab('show');
</script>
<style type="text/css">
	.noborder tbody > tr > td {border: 1px solid #fff;}
	.help {font-style:italic;}
</style>
<?php echo $footer; ?>