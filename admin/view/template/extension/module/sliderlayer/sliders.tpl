<?php 
  echo $header; 
  echo $column_left; 
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a class="btn btn-primary" title="<?php echo $objlang->get('button_save_all_and_edit_group'); ?>" onclick="$('#form-sliders').submit();" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
				<a class="btn btn-info" title="<?php echo $objlang->get('button_save_all_and_create_new'); ?>" onclick="$('#action_mode').val('create-new');$('#form-sliders').submit();" data-toggle="tooltip"><i class="fa fa-plus-circle"></i></a> | <a class="btn btn-danger" title="<?php echo $button_cancel; ?>" href="<?php echo $cancel; ?>" data-toggle="tooltip"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>

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
				<ul id="grouptabs" class="nav nav-tabs" role="tablist">
					<li class="active">
						<a href="#tab-listmodules" role="tab" data-toggle="tab">
							<i class="fa fa-plus"></i>
						<?php echo $objlang->get('tab_manage_module');?></a>
					</li>
					<li><a href="#tab-slidergroups" role="tab" data-toggle="tab">
						<i class="fa fa-database"></i>
						<?php echo $objlang->get('tab_manage_slider_group'); ?></a></li>
					<li><a href="#tab-importtools" role="tab" data-toggle="tab">
						<i class="fa fa-cloud-download"></i>

						<?php echo $objlang->get('tab_import_tools');?></a></li>
				</ul>
				<div class="tab-content">
					<!-- List Modules -->
					<div class="tab-pane active" id="tab-listmodules">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module">
							<input type="hidden" name="action_mode" id="action_mode" value="module-only">
						
							<div class="col-sm-2">
								<ul class="nav nav-pills nav-stacked" id="module">
									<?php if ($extensions) { ?>
									<?php foreach ($extensions as $extension) { ?>
									<?php $actived = (empty($module_id))?"class='active'":''; ?>
									<li <?php echo $actived; ?>><a href="<?php echo $extension['edit']; ?>" ><i class="fa fa-plus-circle"></i> <?php echo $extension['name']; ?></a></li>
									<?php $i=0; foreach ($extension['module'] as $m) { $i++;?>
									<?php $active = ($m['module_id'] == $module_id)?'class="active"':''; ?>
									<li <?php echo $active; ?>><a href="<?php echo $m['edit']; ?>" ><i class="fa fa-minus-circle" onclick=""></i> <?php echo $m['name']; ?></a></li>
									<?php } //end modules?>
									<?php } //end extensions?>
									<?php } else { ?>
									<?php } //end if?>
								</ul>
							</div>
							<div class="pull-right">
								<a class="btn btn-success" title="<?php echo $objlang->get('button_save_module'); ?>" onclick="$('#action_mode').val('module-only');$('#form-module').submit();" data-toggle="tooltip"><i class="fa fa-save"></i></a>
								<?php if(!empty($module_id)) { ?>
								<a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $mdelete; ?>' : false;" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
							</div><br><br>
							<div class="col-sm-10">
								<div class="tab-content" id="tab-content">
									<div class="tab-pane active">
										<div class="form-group">
											<label class="col-sm-2 control-label"><?php echo $objlang->get('entry_module_name'); ?></label>
											<div class="col-sm-10">
												<input class="form-control" type="text" placeholder="Module name" value="<?php echo $name; ?>" name="name"/>
												<br>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
											<div class="col-sm-10">
												<select class="form-control" name="status" id="input-status">
												<?php if ($status) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
												</select><br>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_banner; ?></label>
											<div class="col-sm-10">
												<select class="form-control" name="group_id">
													<?php foreach ($slidergroups as $sg) { ?>
													<?php if ($sg['id'] == $group_id) { ?>
													<option value="<?php echo $sg['id']; ?>" selected="selected"><?php echo $sg['title']; ?></option>
													<?php } else { ?>
													<option value="<?php echo $sg['id']; ?>"><?php echo $sg['title']; ?></option>
													<?php } ?>
													<?php } ?>
												</select>
												<br>
											</div>
										</div>
										<br/>
									</div>
								</div>
							</div>
						</form><!-- End Form-Module -->
					</div>
					<!-- Slider Groups -->
					<div class="tab-pane" id="tab-slidergroups">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sliders">
						<input type="hidden" name="action_mode" id="action_mode" value="">
						<div class="groups">
							<h4><?php echo $objlang->get('Slider Groups');?></h4>
						
							<ul>
								<?php foreach( $slidergroups as $sgroup ) {  ?>
								<li <?php if( $sgroup['id'] == $id ) { ?> class="active" <?php } ?> >    
									<a class="text-warning" title="Edit Sliders In Group" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/layer', 'group_id='.$id.'&token=' . $objsession->data['token'], 'SSL');?>"  >
										<i class="fa fa-list-alt"></i>  | </a>
										 
									<a title="Edit This Group" <?php if( $sgroup['id'] == $id ) { ?> class="btn-edit-group active" <?php } ?> href="<?php echo $objurl->link('extension/module/pavsliderlayer', 'id='.$sgroup['id'].'&token=' . $objsession->data['token'], 'SSL');?>">
										<i class="fa fa-edit"></i>
 										<?php echo $sgroup['title'];?>
 										<span>(ID:<?php echo $sgroup['id'];?>)</span> 
									</a> 
									
																
								</li>
							<?php } ?>
							</ul>
							<hr>
							<p class="alert alert-info" style="margin-right:20px;">Click above group to edit setting and manage sliders</p>
						</div>
						<div class="group-form">
											<h4>
												<?php echo $objlang->get('Slider Group Form');?>
												<?php if( $id ) { ?><?php echo $objlang->get('Edit');?>: <span><?php echo $params['title'];?></span>
												<?php } else { ?>: <?php echo $objlang->get('Create New Group');?><?php } ?>
											</h4>
											<div class="group-form-inner">
												
												<table class="table">
													<tr>
														<td>ID: <?php echo $id;?><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
														<td>
															<?php if( $id ) { ?> 
															<div class="buttons">
																
																<a class="btn btn-primary btn-sm" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/layer', 'group_id='.$id.'&token=' . $objsession->data['token'], 'SSL');?>" class="btn btn-green" >
																	<i class="fa fa-list-alt fa-2x"></i><br>
																	<?php echo 'Manages Sliders'; ?></a>
																

																		
																<a class="btn btn-warning btn-sm" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/export', 'id='.$id.'&token=' . $objsession->data['token'], 'SSL');?>"  class="btn orange" id="preview-sliders">
																	<i class="fa fa-floppy-o fa-2x"></i><br>
																	<?php echo $objlang->get('Export Group And Sliders'); ?></a>

																	<p class="pull-right">
																		<a class="btn btn-success btn-sm" id="btn-preview-ingroup" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/previewGroup', 'id='.$id.'&token=' . $objsession->data['token'], 'SSL');?>" class="button grey" id="preview">
																	<i class="fa fa-play fa-2x"></i><br>
																	<?php echo $objlang->get('Preview Sliders In Group');?>
																	</a>
																	<a class="btn btn-danger btn-sm" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/deleteGroup', 'id='.$id.'&token=' . $token, 'SSL');?>" onclick="return confirm('Are you sure to delete this');" class="btn " id="preview-sliders">
																	<i class="fa fa-trash fa-2x"></i><br>
																	<?php echo $objlang->get('Delete This');?></a>

																	</p>
															</div>  
															<?php } ?>
														</td>   
													<tr>
													<tr>
														<td><?php echo $objlang->get('Slide Group Title');?></td>
														<td><input class="form-control" type="text" name="slider[title]" value="<?php echo $params['title'];?>"/></td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Delay');?></td>
														<td><input class="form-control" type="text" name="slider[delay]" value="<?php echo $params['delay'];?>"/></td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('FullWidth Mode');?></td>
														<td>
															<select class="form-control" name="slider[fullwidth]">
															<?php foreach( $fullwidth as $key => $value ) { ?>
															<option value="<?php echo $key;?>" <?php if( isset($params['fullwidth']) && ($key == $params['fullwidth']) ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
															<?php } ?>
															</select>
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Slider Demension');?></td>
														<td>
															<label><?php echo $objlang->get('Width');?></label>
															<input class="form-control" type="text" name="slider[width]" value="<?php echo $params['width'];?>"/>
															<label>Height</label>
															<input class="form-control" type="text" name="slider[height]" value="<?php echo $params['height'];?>"/>
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Touch Mobile');?></td>
														<td>    
															<select class="form-control" name="slider[touch_mobile]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['touch_mobile'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?>
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Stop On Hover');?></td>
														<td>
															<select class="form-control" name="slider[stop_on_hover]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['stop_on_hover'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Shuffle Mode');?></td>
														<td>
															<select class="form-control" name="slider[shuffle_mode]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['shuffle_mode'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Image Cropping');?></td>
														<td>
															<select class="form-control" name="slider[image_cropping]">
															<?php foreach( $yesno as $key => $value ) { ?>
															<option value="<?php echo $key;?>" <?php if( $key == $params['image_cropping'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
															<?php } ?> 
															</select>   
														</td>
													</tr>
												</table> 

												<!-- Image Croping -->
												<h4><?php echo $objlang->get('Image Cropping');?></h4>
												<table class="table">
													<tr>
														<td><?php echo $objlang->get('Shadow Type');?></td>
														<td>
															<select class="form-control" name="slider[shadow_type]">
																<?php foreach( $shadow_types as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['shadow_type'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Show Time Line');?></td>
														<td>
															<select class="form-control" name="slider[show_time_line]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['show_time_line'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td>Time Liner Position</td>
														<td>
															<select class="form-control" name="slider[time_line_position]">
																<?php foreach( $linepostions as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['time_line_position'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Background Color');?></td>
														<td><input class="form-control" type="text" name="slider[background_color]" value="<?php echo $params['background_color'];?>"/></td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Margin');?></td>
														<td><input class="form-control" type="text" name="slider[margin]" value="<?php echo $params['margin'];?>"/> Example: 5px 0; or 5px 10px 20px</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Padding(border)');?></td>
														<td><input class="form-control" type="text" name="slider[padding]" value="<?php echo $params['padding'];?>"/> Example: 5px 0; or 5px 10px 20px</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Show Background Image');?></td>
														<td>
															<select class="form-control" name="slider[background_image]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['background_image'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																<?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Background URL');?></td>
														<td><input class="form-control" type="text" value="<?php echo $params['background_url'];?>" name="slider[background_url]"/></td>
													</tr>
												</table> 
												<!-- Navigator -->
												<h4><?php echo $objlang->get('Navigator');?></h4>
												<table class="table">
													<tr>
														<td><?php echo $objlang->get('Navigator Type');?></td>
														<td>
															<select class="form-control" name="slider[navigator_type]">
																<?php foreach( $navigator_types as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['navigator_type'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																 <?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Arrows');?></td>
														<td>
															<select class="form-control" name="slider[navigator_arrows]">
																<?php foreach( $navigation_arrows as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['navigator_arrows'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																 <?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Style');?></td>
														<td>
															<select class="form-control" name="slider[navigation_style]">
																<?php foreach( $navigation_style as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['navigation_style'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																 <?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Offset Horizontal');?></td>
														<td><input class="form-control" type="text" value="<?php echo $params['offset_horizontal'];?>" name="slider[offset_horizontal]"/></td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Offset Vertical');?></td>
														<td><input class="form-control" type="text" value="<?php echo $params['offset_vertical'];?>" name="slider[offset_vertical]"/></td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Always Show Navigator');?></td>
														<td>
															<select class="form-control" name="slider[show_navigator]">
																<?php foreach( $yesno as $key => $value ) { ?>
																<option value="<?php echo $key;?>" <?php if( $key == $params['show_navigator'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
																 <?php } ?> 
															</select>   
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Hide Navigator After');?></td>
														<td><input class="form-control" type="text" value="<?php echo $params['hide_navigator_after'];?>" name="slider[hide_navigator_after]"/></td>
													</tr>   
												</table> 
												<!-- Thumbnails -->
												<h4><?php echo $objlang->get('Thumbnails');?></h4>
												<table class="table">
													<tr>
														<td><?php echo $objlang->get('Thumbnail Width');?></td>
														<td>
															<input class="form-control" type="text" value="<?php echo $params['thumbnail_width'];?>" name="slider[thumbnail_width]"/>
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Thumbnail Height');?> </td>
														<td>
															<input class="form-control" type="text" value="<?php echo $params['thumbnail_height'];?>" name="slider[thumbnail_height]"/>
														</td>
													</tr>
													<tr>
														<td><?php echo $objlang->get('Number of Thumbnails');?> </td>
														<td>
															<input class="form-control" type="text" value="<?php echo $params['thumbnail_amount'];?>" name="slider[thumbnail_amount]"/>
														</td>
													</tr>
												</table> 
												<!-- Mobile Visiblity -->
												<h4><?php echo $objlang->get('Mobile Visiblity');?></h4>
												<table class="table">
													<tr>
														<td><?php echo $objlang->get('Hide Under Width');?></td>
														<td><input class="form-control" type="text" value="<?php echo $params['hide_screen_width'];?>" name="slider[hide_screen_width]"/></td>
													</tr>
												</table> 
											</div><!-- End Group Form -->

						</div>						
						</form><!-- End Form-Module -->
					</div>
					<!-- Import Tools -->
					<div class="tab-pane" id="tab-importtools">
						<form id="import" method="post" enctype="multipart/form-data" action="<?php echo $actionImport; ?>">
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="file" class="input_import_slider" id="input-file" name="import_file"><br/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button class="btn btn-warning" type="submit"><?php echo $objlang->get('button_import_slider');?></button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

 <!-- Modal Form Group Layer Sliders-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $objlang->get('text_preview_sliders_in_group');?></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $objlang->get('text_close'); ?></button>
			</div>
		</div> 
	</div> 
</div>	

<script type="text/javascript">
//Preview Group LayerSlider
$("#btn-preview-ingroup").click( function(){

	$('#myModal1 .modal-dialog').css('width',1170);
	var a = $( '<span class="glyphicon glyphicon-refresh"></span><iframe frameborder="0" scrolling="no" src="'+$(this).attr('href')+'" style="width:100%;height:500px; display:none"/>'  );
	$('#myModal1 .modal-body').html( a );
		
	$('#myModal1').modal('show');
	$('#myModal1').attr('rel', $(this).attr('rel') );
	$(a).load( function(){  
		$('#myModal1 .modal-body .glyphicon-refresh').hide();
		$('#myModal1 .modal-body iframe').show();
	});
	return false; 
});

// dropdown multiple store
$('#pavstores').bind('change', function () {
	url = 'index.php?route=extension/module/pavsliderlayer&token=<?php echo $token; ?>';
	var id = $(this).val();
	if (id) {
		url += '&store_id=' + encodeURIComponent(id);
	}
	window.location = url;
});

$('#grouptabs a').click( function(){
	$.cookie("sactived_tab", $(this).attr("href") );
});

if( $.cookie("sactived_tab") !="undefined" ){
	$('#grouptabs a').each( function(){ 
		if( $(this).attr("href") ==  $.cookie("sactived_tab") ){
			$(this).click();
			return ;
		}
	});
}
</script>

<?php echo $footer; ?>