<?php 
  echo $header; 
  echo $column_left; 
  $module_row=0; 
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a class="btn btn-primary" onclick="$('#slider-form').submit();" class="button"><i class="fa fa-save"></i> <?php echo $button_save; ?></a>
      			<a class="btn btn-danger" href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
      			<a class="btn btn-success" id="btn-preview-ingroup" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/previewGroup', 'id='.$group_id.'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL');?>" class="button green" id="preview"><i class="fa fa-play"></i>  <?php echo $objlang->get('Preview Sliders In Group');?></a> |

      			<a class="btn btn-default" id="btn-preview-ingroup" href="<?php echo  $objurl->link('extension/module/pavsliderlayer', 'id='.$group_id.'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL');?>" class="button green" id="preview"><i class="fa fa-mail-reply"></i> <?php echo $objlang->get('Back to Edit Group');?></a> |

			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- End div#page-header -->

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
				<ul id="languagetabs" class="nav nav-tabs" role="tablist">
					<?php $i=0; foreach ($languages as $language) { $i++;?>
					<?php $class = ($language['language_id'] == $lang)?'class="active"':''; ?>
					<li <?php echo $class; ?> data-value="<?php echo $language['language_id']; ?>">
						<?php $url = $objurl->link('extension/module/pavsliderlayer/layer', '&group_id='.$group_id.'&lang='.$language['language_id'].'&token=' . $objsession->data['token'], 'SSL'); ?>
						<a href="<?php echo $url; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
				</ul>
				<div class="pull-right">
					<a href="" title="" class="btn btn-danger" data-toggle="clone"><i class="fa fa-file-text-o"></i> Clone Data</a>

				</div>
				<br>
				<h3><?php echo $objlang->get('List Of Sliders In Group');?>: <a href="<?php echo  $objurl->link('extension/module/pavsliderlayer', 'id='.$group_id.'&token=' . $objsession->data['token'], 'SSL');?>"><span><?php echo $sliderGroup['title'];?></span></a></h3>
	    	 	<div>
					<p class="explain"><?php echo $objlang->get('drap and drop to sort slider in list, and click to each item to edit detail information');?></p>
	    	 	</div>
	    		<div class="group-sliders clearfix">
	    			<div class="new-slider-item">
		    			<a href="<?php echo  $objurl->link('extension/module/pavsliderlayer/layer', 'group_id='.$group_id.'&token=' . $objsession->data['token'], 'SSL')?>">
		    			</a>
		    			<div><?php echo $objlang->get('text_create_new');?></div>
	    			</div>
	    			<?php foreach( $sliders as $slider )  { ?>
	    				<div class="slider-item <?php echo ( $slider['id'] == $slider_id ? 'active':'');?>" id="slider_<?php echo $slider['id'];?>">
	    					<a class="image" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/layer', 'id='.$slider['id'].'&group_id='.$slider['group_id'].'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL')?>">
	    						<img class="img-responsive" src="<?php echo HTTP_CATALOG."image/".$slider["image"];?>" height="86"/>
	    					</a>
	    					<a  title="<?php echo $objlang->get('text_clone_this');?>" class="slider-clone" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/copythis', 'id='.$slider['id'].'&group_id='.$slider['group_id'].'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL')?>"><span>Clone</span></a>
	    					<a  title="<?php echo $objlang->get('text_delete_this');?>" class="slider-delete" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/deleteslider', 'id='.$slider['id'].'&group_id='.$slider['group_id'].'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL')?>" onclick="return confirm('<?php echo $objlang->get('text_confirm_delete');?>')"><span>Delete</span></a>

	    					<a class="slider-status<?php if( !$slider['status']) { ?> slider-status-off <?php } ?>" href="<?php echo  $objurl->link('extension/module/pavsliderlayer/layer', 'id='.$slider['id'].'&group_id='.$slider['group_id'].'&lang='.$lang.'&token=' . $objsession->data['token'], 'SSL')?>"><span>Status</span></a>
	    					<div><?php echo $slider['title']; ?></div>
	    				</div>	
	    			<?php } ?>
	    		</div>
	    		<div class="clearfix"></div>

	    		<!-- Form Edit Info Slider Layer -->
	    		<?php if( $slider_id )  { ?> 
	    		<h3><?php echo $objlang->get('text_edit_slider');?> <span><?php echo $slider_title;?></span></h3>
	    		<?php  } else { ?>
	    			<h3><?php echo $objlang->get('text_create_new_slider');?></h3>
	    		<?php } ?>
				<form action="" method="post" id="slider-editor-form">
					<div id="slider-warning" class=""></div>
					<input type="hidden" id="slider_group_id" name="slider_group_id" value="<?php echo $group_id;?>"/>
					<div class="slider-params-wrap">
						<div class="slider-params">
							<table class="table">
								<tr>
									<td> <?php echo $objlang->get("Title")?> </td>
									<td><input class="form-control" type="text" name="slider_title" size="100" value="<?php echo $slider_title;?>"></td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Status")?> </td>
									<td><input name="slider_language_id" type="hidden" value="<?php echo $lang; ?>"/>
										<select class="form-control" name="slider_status">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $params['slider_status'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>	
									</td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Transition")?></td>
									<td>
										<select class="form-control" name="slider_transition">
											<?php foreach( $transtions as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $params['slider_transition'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>	
									</td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Slot Amount");?></td>
									<td><input class="form-control" type="text" name="slider_slot" value="<?php echo $params['slider_slot'];?>"></td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Transition Rotation")?></td>
									<td><input class="form-control" type="text" name="slider_rotation" value="<?php echo $params['slider_rotation'];?>"></td>
								</tr>
								<tr>
									<td> <?php echo $objlang->get("Transition Duration")?> </td>
									<td><input class="form-control" type="text" name="slider_duration" value="<?php echo $params['slider_duration'];?>" ></td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Delay")?>  </td>
									<td><input class="form-control" type="text" name="slider_delay" value="<?php echo $params['slider_delay'];?>"></td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Enable Link")?>  </td>
									<td> 
										<select class="form-control" name="slider_enable_link">
											<?php foreach( $yesno as $key => $value ) { ?>
											<option value="<?php echo $key;?>" <?php if( $key == $params['slider_enable_link'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
											<?php } ?>
										</select>	
									</td>
								</tr>
								<tr>
									<td><?php echo $objlang->get("Link")?></td>
									<td><input class="form-control" type="text" name="slider_link" value="<?php echo $params['slider_link'];?>"></td>
								</tr>
								<tr>
									<td> <?php echo $objlang->get("Thumbnail")?> </td>
									<td class="left">
										<div class="image">
											<a href="" id="thumb-img" data-toggle="image" class="img-thumbnail">
												<img src="<?php echo empty($slider_thumbnail)?$placeholder:$slider_thumbnail; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
											</a>
											<input type="hidden" name="slider_thumbnail" id="slider_thumbnail" value="<?php echo $params['slider_thumbnail'];?>"/>				
										</div>
									</td>
								</tr>
								<tr>
									<td><?php echo $objlang->get('Full Width Video');?></td>
									<td>
										<div>
											<select class="form-control" name="slider_usevideo">
												<?php foreach( $usevideo as $key => $value ) { ?>
												<option value="<?php echo $key;?>" <?php if( $key == $params['slider_usevideo'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
												<?php } ?>
											</select>
										</div><br/>
										<div>
											<b><?php echo $objlang->get('Video ID');?></b>
											<input class="form-control" type="text" name="slider_videoid" value="<?php echo $params['slider_videoid'];?>">
										</div>
									</td>
								</tr>
								<tr>
								<td><?php echo $objlang->get('Auto Play');?></td>
								<td>
									<select class="form-control" name="slider_videoplay">
										<?php foreach( $yesno as $key => $value ) { ?>
										<option value="<?php echo $key;?>" <?php if( $key == $params['slider_videoplay'] ){ ?> selected="selected" <?php } ?> ><?php echo $value; ?></option>
										<?php } ?>
									</select>	
									</td>
								</tr>
							</table>	
						</div>
					</div>
					<input name="slider_id" type="hidden" id="slider_id" value="<?php echo $slider_id;?>" />	
					<input name="slider_image" id="slider-image" type="hidden" value="<?php echo $slider_image;?>">
				</form>
				<div class="clearfix"></div>

			 	<!-- Button Upload BackGround Slider -->
				<div class="buttons clearfix">
					<a class="btn btn-warning" id="btn-update-slider"><?php echo $objlang->get("Update Image Slider")?></a>
				</div>
				<div class="clearfix"></div>

				<!-- Layers Editor -->
				<h3><?php echo $objlang->get("Layers Editor")?></h3> 
				<div class="layers-wrapper" id="slider-toolbar">
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"  id="slider-form">

						<div class="slider-toolbar clearfix">
							<ul>
								<li><div class="btn btn-create" href="#" data-action="add-image"><div class="icon-image icon"></div><?php echo $objlang->get("Add Layer Image")?></div></li>
								<li><div class="btn btn-create" href="#" data-action="add-video"><div class="icon-video icon"></div><?php echo $objlang->get("Add Layer Video")?></div></li>
								<li><div class="btn btn-create" href="#" data-action="add-text"><div class="icon-text icon"></div><?php echo $objlang->get("Add Layer Text")?></div></li>
								<li class="red"><div class="btn btn-delete" data-action="delete-layer"><div class="icon-delete icon"></div><?php echo $objlang->get("Delete This Layer")?></div></li>
							</ul>	
							
							<div class="buttons pull-right">
								<a class="btn btn-primary" onclick="$('#slider-form').submit();" class="button"><?php echo $button_save; ?></a> <a class="btn btn-success" id="btn-preview-slider"><?php echo $objlang->get("text_preview_this_slider")?></a>
							</div>
						</div><!-- End div.slider-toolbar -->

						<div class="slider-layers clearfix" >
						    <div class="slider-editor-wrap" style="width:<?php echo $sliderWidth;?>px;height:<?php echo $sliderHeight;?>px">	
						    	<div class="simage" id="simage">
						    		<img id="slider_image_src" src="<?php echo $slider_image_src;?>">
						    	</div>
							    <div class="slider-editor" id="slider-editor" style="width:<?php echo $sliderWidth;?>px;height:<?php echo $sliderHeight;?>px">
							    </div>
							</div><!-- End div.slider-editor-wrap -->

							<div class="layer-video-inpts" id="dialog-video">
								<table class="table">
									<tr>
										<td><?php echo $objlang->get("video_type")?></td>
										<td>
											<select class="form-control" name="layer_video_type" id="layer_video_type">
												<option value="youtube"><?php echo $objlang->get("Youtube");?></option>
												<option value="vimeo"><?php echo $objlang->get("Vimeo");?></option>
											</select>	
										</td>
									</tr>
									<tr>
										<td>Video ID</td>
										<td><input class="form-control" name="layer_video_id" type="text" id="dialog_video_id">
											<p><?php echo $objlang->get("for example youtube");?>: <b>VA770wpLX-Q</b> and vimeo: <b>17631561</b> </p>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<label><?php echo $objlang->get("Height")?></label>
											<input class="form-control" name="layer_video_height" type="text" value="200">
											<label><?php echo $objlang->get("Width")?></label>
											<input class="form-control" name="layer_video_width" type="text" value="300">
											
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="hidden" name="layer_video_thumb" id="layer_video_thumb">
											<div class="buttons">
												<a class="btn btn-primary layer-find-video"><?php echo $objlang->get("Find Video")?></a>
												<a class="btn btn-success layer-apply-video" id="apply_this_video" style="display:none;"><?php echo $objlang->get("Use This Video")?></a>
												<a class="btn btn-danger" onclick="$('#dialog-video').hide();"><?php echo $objlang->get("Close");?></a>
											</div>
										</td>
									</tr>	
								</table>
								<div id="video-preview"></div>
							</div><!-- End div.layer-video-inpts -->

							<div class="slider-foot">
								<div class="layer-collection-wrapper">
									<h4><?php echo $objlang->get("Layer Collection")?></h4>
									<div class="layer-collection" id="layer-collection"></div>	
								</div>

								<div class="layer-form" id="layer-form">
									<h4><?php echo $objlang->get("Edit Layer Data")?></h4>
									<input type="hidden" id="layer_id" name="layer_id"/>
									<input type="hidden" id="layer_content" name="layer_content"/>
									<input type="hidden" id="layer_type" name="layer_type"/>

									<table class="form">
										<tr>
											<td>Class Style</td>
											<td style="padding-bottom: 12px;">
												<div class="col-sm-6">
													<input class="form-control" type="text" name="layer_class" id="input-layer-class"/>
												</div>
												<div class="col-sm-6">
													<span class="buttons">
														<a class="btn btn-warning btn-sm" onclick="$('#input-layer-class').val('')"><?php echo $objlang->get("Clear");?></a> |
														<a class="btn btn-success btn-sm" id="btn-insert-typo"><?php echo $objlang->get("Insert Typo")?></a>
													</span>
												</div>
											</td>
										</tr>
										<tr>
											<td><?php echo $objlang->get("Text")?></td>
											<td>
												<textarea class="form-control" style="width:90%; height:60px" name="layer_caption" id="input-slider-caption" data-for="caption-layer" ></textarea>
												<br/>
												<?php echo $objlang->get("Allow insert html code");?>
											</td>
										</tr>
										<tr>
											<td><?php echo $objlang->get("Effect")?></td>
											<td>
												<label><?php echo $objlang->get("Animation")?></label>
												<select class="form-control" name="layer_animation">
													<option selected="selected" value="fade"><?php echo $objlang->get("Fade");?></option>
													<option value="sft"><?php echo $objlang->get("Short from Top");?></option>
													<option value="sfb"><?php echo $objlang->get("Short from Bottom");?></option>
													<option value="sfr"><?php echo $objlang->get("Short from Right");?></option>
													<option value="sfl"><?php echo $objlang->get("Short from Left");?></option>
													<option value="lft"><?php echo $objlang->get("Long from Top");?></option>
													<option value="lfb"><?php echo $objlang->get("Long from Bottom");?></option>
													<option value="lfr"><?php echo $objlang->get("Long from Right");?></option>
													<option value="lfl"><?php echo $objlang->get("Long from Left");?></option>
													<option value="randomrotate"><?php echo $objlang->get("Random Rotate");?></option>
												</select>	
												<p>	
													<label><?php echo $objlang->get("Easing")?></label>
													<select class="form-control" name="layer_easing">
														<option value="easeOutBack">easeOutBack</option>
														<option value="easeInQuad">easeInQuad</option>
														<option value="easeOutQuad">easeOutQuad</option>
														<option value="easeInOutQuad">easeInOutQuad</option>
														<option value="easeInCubic">easeInCubic</option>
														<option value="easeOutCubic">easeOutCubic</option>
														<option value="easeInOutCubic">easeInOutCubic</option>
														<option value="easeInQuart">easeInQuart</option>
														<option value="easeOutQuart">easeOutQuart</option>
														<option value="easeInOutQuart">easeInOutQuart</option>
														<option value="easeInQuint">easeInQuint</option>
														<option value="easeOutQuint">easeOutQuint</option>
														<option value="easeInOutQuint">easeInOutQuint</option>
														<option value="easeInSine">easeInSine</option>
														<option value="easeOutSine">easeOutSine</option>
														<option value="easeInOutSine">easeInOutSine</option>
														<option value="easeInExpo">easeInExpo</option>
														<option selected="selected" value="easeOutExpo">easeOutExpo</option>
														<option value="easeInOutExpo">easeInOutExpo</option>
														<option value="easeInCirc">easeInCirc</option>
														<option value="easeOutCirc">easeOutCirc</option>
														<option value="easeInOutCirc">easeInOutCirc</option>
														<option value="easeInElastic">easeInElastic</option>
														<option value="easeOutElastic">easeOutElastic</option>
														<option value="easeInOutElastic">easeInOutElastic</option>
														<option value="easeInBack">easeInBack</option>
														<option value="easeOutBack">easeOutBack</option>
														<option value="easeInOutBack">easeInOutBack</option>
														<option value="easeInBounce">easeInBounce</option>
														<option value="easeOutBounce">easeOutBounce</option>
														<option value="easeInOutBounce">easeInOutBounce</option>
													</select>	
												</p>	
											</td>
										</tr>	
										<tr>
											<td><?php echo $objlang->get("Speed")?></td>
											<td><input class="form-control" name="layer_speed" type="text"></td>
										</tr>
										<tr>
											<td><?php echo $objlang->get("Position");?></td>
											<td>
												<label><?php echo $objlang->get("Top");?>:</label><input class="form-control" size="3" type="text" name="layer_top">
												<label><?php echo $objlang->get("Left");?>:</label><input class="form-control" size="3" type="text" name="layer_left">
											</td>
										</tr>
									</table>

									<div class="other-effect">
										<h5><?php echo $objlang->get("Other Animation");?></h5>
										<table class="table">
											<tr>
												<td><?php echo $objlang->get("End Time");?></td>
												<td><input class="form-control" type="text" name="layer_endtime"> </td>
											</tr>
											<tr>
												<td><?php echo $objlang->get("End Speed");?></td>
												<td><input class="form-control" type="text" name="layer_endspeed"> </td>
											</tr>
											<tr>
												<td><?php echo $objlang->get("End Animation");?></td>
												<td>
													<select class="form-control" type="text" name="layer_endanimation"> 
														<option selected="selected" value="auto"><?php echo $objlang->get("Choose Automatic");?></option>
														<option value="fadeout"><?php echo $objlang->get("Fade Out");?></option>
														<option value="stt"><?php echo $objlang->get("Short to Top");?></option>
														<option value="stb"><?php echo $objlang->get("Short to Bottom");?></option>
														<option value="stl"><?php echo $objlang->get("Short to Left");?></option>
														<option value="str"><?php echo $objlang->get("Short to Right");?></option>
														<option value="ltt"><?php echo $objlang->get("Long to Top");?></option>
														<option value="ltb"><?php echo $objlang->get("Long to Bottom");?></option>
														<option value="ltl"><?php echo $objlang->get("Long to Left");?></option>
														<option value="ltr"><?php echo $objlang->get("Long to Right");?></option>
														<option value="randomrotateout"><?php echo $objlang->get("Random Rotate Out");?></option>
													</select>
												</td>
											</tr>	
											<tr>
												<td><?php echo $objlang->get("End Easing");?></td>
												<td>
													<select class="form-control" name="layer_endeasing"> 
														<option selected="selected" value="nothing">No Change</option>
														<option value="easeOutBack">easeOutBack</option>
														<option value="easeInQuad">easeInQuad</option>
														<option value="easeOutQuad">easeOutQuad</option>
														<option value="easeInOutQuad">easeInOutQuad</option>
														<option value="easeInCubic">easeInCubic</option>
														<option value="easeOutCubic">easeOutCubic</option>
														<option value="easeInOutCubic">easeInOutCubic</option>
														<option value="easeInQuart">easeInQuart</option>
														<option value="easeOutQuart">easeOutQuart</option>
														<option value="easeInOutQuart">easeInOutQuart</option>
														<option value="easeInQuint">easeInQuint</option>
														<option value="easeOutQuint">easeOutQuint</option>
														<option value="easeInOutQuint">easeInOutQuint</option>
														<option value="easeInSine">easeInSine</option>
														<option value="easeOutSine">easeOutSine</option>
														<option value="easeInOutSine">easeInOutSine</option>
														<option value="easeInExpo">easeInExpo</option>
														<option value="easeOutExpo">easeOutExpo</option>
														<option value="easeInOutExpo">easeInOutExpo</option>
														<option value="easeInCirc">easeInCirc</option>
														<option value="easeOutCirc">easeOutCirc</option>
														<option value="easeInOutCirc">easeInOutCirc</option>
														<option value="easeInElastic">easeInElastic</option>
														<option value="easeOutElastic">easeOutElastic</option>
														<option value="easeInOutElastic">easeInOutElastic</option>
														<option value="easeInBack">easeInBack</option>
														<option value="easeOutBack">easeOutBack</option>
														<option value="easeInOutBack">easeInOutBack</option>
														<option value="easeInBounce">easeInBounce</option>
														<option value="easeOutBounce">easeOutBounce</option>
														<option value="easeInOutBounce">easeInOutBounce</option>
													</select>
												</td>
											</tr>		
										</table>
									</div><!-- End div.other-effect -->
								</div><!-- End div.layer-form -->
							</div><!-- End div.slider-foot -->

		   				</div><!-- End div.slider-layers -->
					</form><!-- End form#slider-form -->

				</div><!-- End div.layers-wrapper -->
			</div><!-- End div.panel-body -->
		</div><!-- End div.panel-content -->

	</div><!-- End div#page-content -->

</div><!-- End div.content -->


 <!-- Modal Form-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<script type="text/javascript"><!--
// clone data
$(document).delegate('a[data-toggle=\'clone\']', 'click', function(e) {
	e.preventDefault();


	var content = '';

	content += '<table class="table">';
	content += '	<tr>';
	content += '		<td><label class="control-label">Group:</label></td>';
	content += '		<td>';
	content += '			<select class="form-control" name="clone_group" id="clone_group">';
	content += '				<option value="0">Select group</option>';
								<?php foreach ($sliderGroups as $group) { ?>
	content += '				<option value="<?php echo $group["id"]; ?>"><?php echo $group["title"]; ?></option>';
								<?php } ?>
	content += '			</select>';
	content += '		</td>';
	content += '	</tr>';
	content += '	<tr>';
	content += '		<td></td>';
	content += '		<td><button type="button" id="button-save" class="btn btn-primary"><i class="fa fa-save"></i></button> <button type="button" id="button-close" class="btn btn-danger"><i class="fa fa-close"></i></button></td>';
	content += '	</tr>';
	content += '</table>';

	var element = this;
	$(element).popover({
		title: 'Clone Data to GroupSliders',
		html: true,
		placement: 'left',
		trigger: 'manual',
		content: function() {
			return content;
		}
	});

	var group_id = <?php echo $group_id; ?>;
	var lang = <?php echo $lang; ?>;
	
	$(element).popover('toggle');
	// Save
	$('#button-save').on('click', function() { 
		var clone_group = $("#clone_group option:selected").val();
		$.ajax({
			url: 'index.php?route=extension/module/pavsliderlayer/cloneGroupSliders&group_id=' + group_id + '&lang=' + lang + '&clonegroup=' + clone_group + '&token=' + getURLVar('token'),
			type: 'GET',
		}).done(function(data) { 
			location.reload(); 
		});
	});
	// Close
	$('#button-close').on('click', function() {
		$(element).popover('hide');
	});
});

// Sortable Slider
$(".group-sliders").sortable({ accept:".slider-item",
	update:function() {   
		var ids = $( ".slider-item" );
		var params = '';
		var j=1;
		$.each( ids, function(i,e){
			params += 'id['+$(e).attr('id').replace("slider_","")+']='+(j++)+"&";
		});
		$.ajax({
			url:'<?php echo str_replace("&amp;","&",$actionUpdatePostURL); ?>',
			data: params,
			type:'POST'
		});
	} 
});

// Ajax Upload BackGround Image Slider
$("#btn-update-slider").click( function(){ 
	$('#modal-image').remove();
	$.ajax({
		url: 'index.php?route=extension/module/pavsliderlayer/filemanager&token=' + getURLVar('token') + '&target=' + $("#slider-image").attr('id') + '&thumb=simage',
		dataType: 'html',
		success: function(html) {
			$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
			$('#modal-image').modal('show');
		}	
	});
});
//--></script> 

<?php // echo '<pre>'.print_r( $sliderGroup,1 ); die;?> 
<script type="text/javascript"><!--
$( document ).ready( function(){
	var JSONLIST = '<?php echo json_encode( $layers ); ?>';
	var $pavoEditor = $(document).pavoSliderEditor(); 
	var SURLIMAGE = 'index.php?token=<?php echo $token; ?>';
	var SURL = '<?php echo HTTP_CATALOG ?>';
	$pavoEditor.process(SURL, SURLIMAGE, <?php echo $sliderGroup['params']['delay']; ?> ); 
	$pavoEditor.createList( JSONLIST  );
});

// Modal Create widget
$("#btn-preview-ingroup").bind('click', function(){ 

	$('#myModal .modal-dialog').css('width',1170);
	var a = $( '<span class="glyphicon glyphicon-refresh"></span><iframe frameborder="0" scrolling="no" src="'+$(this).attr('href')+'" style="width:100%;height:500px; display:none"/>'  );
	$('#myModal .modal-body').html( a );
		
	$('#myModal').modal('show');
	$('#myModal').attr('rel', $(this).attr('rel') );
	$(a).load( function(){  
		$('#myModal .modal-body .glyphicon-refresh').hide();
 		$('#myModal .modal-body iframe').show();
	});

	return false;
});
//--></script>
<?php echo $footer; ?>