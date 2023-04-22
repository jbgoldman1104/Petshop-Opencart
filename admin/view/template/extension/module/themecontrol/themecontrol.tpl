<?php 
	echo $header;
	echo $column_left;
	$adminModuleViewDir = DIR_TEMPLATE . 'extension/module/themecontrol/'; 
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $ajax_clearcache; ?>" class="btn btn-info ajax-action"><?php echo $olang->get('text_clear_jscss_cache');?></a>
			</div>	
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb clearfix">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<!-- end div header -->

	<div class="container-fluid">

		<?php if( $refreshmodify ){ ?>
		<div class="alert alert-warning">
			Please <a href="<?php echo $refreshmodifylink; ?>" target="_blank" class="btn btn-sm btn-info">click here</a> to refesh modifycation which will create multiple layout positions to use for the theme
		</div>
		<?php } ?>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="sform">
		 	 
		 	 <div class="store-info alert alert-info">
			 	<div class="row">	
			 	  <label class="col-sm-1 control-label"><?php echo $olang->get('text_default_store'); ?></label>	
			 	  <div class="col-sm-3">
			 	 	  <select class="form-control"  name="stores" id="pavstores">
							<?php foreach($stores as $store):?>
							<?php if($store['store_id'] == $store_id):?>
								<option value="<?php echo $store['store_id'];?>" selected="selected"><?php echo $store['name'];?></option>
							<?php else:?>
								<option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>
							<?php endif;?>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-sm-2 control-label text-align-right"><?php echo $olang->get('text_store_theme'); ?>: <strong class=" label label-danger"><?php echo $module['default_theme']; ?></strong> </div>	
				 
				    <div class="col-sm-6">
					    <div class="pull-right">    <button type="submit" form="sform"  data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn save-data btn-primary"><i class="fa fa-save"></i> <?php echo $text_save;?></button>
					        <button type="button" onclick="$('#action_type').val('save-edit');"   data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-danger save-data"><i class="fa fa-save save-data"></i> <?php echo $text_saveandstay;?></button>
					 
					        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>

					       
					      
					    </div>    
			    	</div>
		    	

				</div>	


		 	 </div>
			<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>

			<?php if( isset($alert_info) ){ ?>
			<div class="alert alert-success"><?php echo $alert_info; ?></div>
			<?php } ?>

			<div class="box"  id="themepanel">
				<div class="content">
					
					<div class="entry-theme">
						<?php if( isset($first_installation) )  { ?>
						<div class="label" style="float:right"><?php echo $olang->get("text_first_installation"); ?></div>
						<?php } ?>
					</div>

					<div class="ibox">
						<div id="tabs" class="htabs">
							<ul class="nav nav-tabs nav-pills nav-tablangs" id="moduletabs">
								<li class="active"><a data-toggle="tab"  href="#tab-general"><span class="fa fa-gear"></span> <?php echo $tab_general; ?></a></li>
								<li><a data-toggle="tab"  href="#tab-pages-layout"><span class="fa fa-files-o"></span> <?php echo $olang->get('tab_modules_pages');?></a></li>
								<li><a data-toggle="tab"  href="#tab-font"><span class="fa fa-font"></span> <?php echo $tab_font; ?></a></li>
								<?php if(  isset($imodules) && is_array($imodules) ){ ?>
								<li><a data-toggle="tab"  href="#tab-imodules"><span class="fa fa-gears"></span> <?php echo $olang->get('tab_internal_modules');?></a></li>
								<?php } ?>
								<li><a data-toggle="tab"  href="#tab-modules"><span class="fa fa-bars"></span> <?php echo $olang->get('tab_modules_layouts');?></a></li>
								<?php if( isset($samples) && $samples )  { ?>
								<li><a data-toggle="tab"  href="#tab-datasample"><span class="fa fa-cloud-download"></span> <?php echo $olang->get('tab_datasample');?></a></li>
								<?php } ?>
								<li><a data-toggle="tab"  href="#tab-compress"><span class="fa fa-tachometer"></span> <?php echo $olang->get('tab_compression');?></a></li>
								<li><a data-toggle="tab"  href="#tab-customcode"><span class="fa fa-mail-reply"></span> <?php echo $olang->get('tab_customcode');?></a></li>
								<li><a data-toggle="tab"  href="#tab-support"><span class="fa fa-info"></span> <?php echo $olang->get('tab_information'); ?> </a></li>
							</ul>
						</div>
						<input type="hidden" name="themecontrol[layout_id]" value="1">
						<input type="hidden" name="themecontrol[position]" value="1">

						<div id="tab-contents" class="tab-content">

							<div id="tab-pages-layout"  class="tab-pane">
								<?php include( $adminModuleViewDir.'tab/pages-setting.tpl'); ?>
							</div>  

							<div id="tab-general"  class="tab-pane active">
								<?php include( $adminModuleViewDir.'tab/general-setting.tpl'); ?>
								<?php if( isset($theme_customizations) && is_array($theme_customizations) && isset($theme_customizations['layout']) ) { ?>
								<h3><?php echo $olang->get('text_template_layouts_setting'); ?></h3> 
								<div class="theme-customizations">
									<?php 
									foreach($theme_customizations['layout'] as $bhead => $bcustoms ) {  
										$ckey = trim(strtolower($bhead));
										$default = isset($bcustoms['default'])?trim($bcustoms['default']):"";
										$selected = isset($module[$ckey])?$module[$ckey]:$default;
										$label = isset($bcustoms['label'])?$bcustoms['label']:$bhead;
									?>
									<div class="theme-custom-block">

										<div class="form-group">
											<label class="col-sm-2 control-label"><?php echo $olang->get( ucfirst( str_replace("_"," ",$label)) ); ?></label>
											<div class="col-sm-10">
												<?php if( isset($bcustoms['type']) && ($bcustoms['type']) == 'text') { ?>
													<input value="<?php echo $selected; ?>" name="themecontrol[layout_<?php echo trim(strtolower($bhead)); ?>]">
												<?php } else { ?>
													<select class="form-control <?php if( count($bcustoms['option']) == 2 ) { ?>form-switch<?php } ?>" name="themecontrol[<?php echo $ckey; ?>]">
														<?php foreach( $bcustoms['option'] as $okey => $ovalue ) {  ?>
														<option <?php if($ovalue['value']==$selected) { ?> selected="selected" <?php } ?> value="<?php echo $ovalue['value']; ?>"><?php echo $olang->get($ovalue['text']); ?></option>
														<?php } ?>
													</select>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
								
							<?php if(  isset($imodules) && is_array($imodules) ){ ?>
							<div id="tab-imodules"  class="tab-pane">
								<p><?php echo $olang->get('text_explain_internal_modules'); ?></p>
								<div class="inner-modules-wrap clearfix">	 
									<div>
										<ul class="nav nav-tabs" >
										<?php  $i=0; foreach( $imodules as $key => $imod ) { ?>
											<li <?php if( $i++ ==0 ){ ?>class="active" <?php } ?>><a  role="tab" data-toggle="tab" href="#tab-imodule-<?php echo $key; ?>"><?php echo $olang->get( $imod['title'] );?></a></li>
										<?php } ?>
										</ul>
									</div>
									<div class="tab-content">
										<?php $i=0; foreach( $imodules as $key => $imod ) { ?>
											<div id="tab-imodule-<?php echo $key;?>" class="tab-pane <?php if( $i++ == 0){ ?> active<?php } ?>">
											<?php 
												if( is_object($imod['module'])){ $imod['module'] = array($imod['module']); }
												foreach($imod['module'] as $mkey => $mod){ 
											?>	
											<div class="panel panel-default">
												<div class="panel-heading"><i class="fa fa-wrench"></i> <strong><?php echo $mod->title?></strong></div>
												<div class="panel-body">
													<?php 
														$mod = (array)$mod;		 
														$fields = is_object($mod['field'])?array($mod['field']):$mod['field'];		 
														foreach( $fields as  $f ) { 
													?>
													<div class="forms-groups">
														<!-- image -->
														<?php
															if( $f->type=="image") { $rand = rand();
																	$image = isset($module[trim($f->name)])?$toolimage->resize( $module[trim($f->name)], 100, 100 ):$placeholder;
																	$vimg = isset($module[trim($f->name)])?($module[trim($f->name)]):$f->default;
														?>
														<div class="form-group">
															<label class="col-sm-3"><?php echo $f->label; ?></label>
															<div class="col-sm-9">
																<a href="" id="thumb-image<?php echo $rand;?>" data-toggle="image" class="img-thumbnail">
																	<img src="<?php echo $image;?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
																</a>
																<input type="hidden" name="themecontrol[<?php echo trim($f->name);?>]" value="<?php echo $vimg; ?>" id="input-image<?php echo $rand;?>" />
															</div>
														</div>
														<?php } ?>
														<!-- text -->
														<?php if( $f->type=='text') { $color = '';?>
														<?php if($f->color != 0) { $color = 'color';?>
														<script type="text/javascript" src="view/javascript/pavsocial/jscolor/jscolor.js"></script>
														<?php } ?>

														<div class="mod-text-lang form-group">
															<label class="col-sm-2"><?php echo $f->label; ?></label>
															<div class="col-sm-9">

																<?php if($f->lang != 0) { ?>
																<ul class="nav nav-tabs nav-tablangs">
																<?php foreach ($languages as $language) { ?>
																	<li><a href="#tab-lang-<?php echo $f->name;?><?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
																<?php } ?>
																</ul>
																<?php } ?>

																<div class="tab-content">
																	<?php if($f->lang == 0) { ?>
																		<?php $text = isset($module[trim($f->name)]) ? trim($module[trim($f->name)]) : trim($f->default); ?>
																		<input class="form-control <?php echo $color;?>" style="width:400px" value="<?php echo $text; ?>" type="text" name="themecontrol[<?php echo trim($f->name); ?>]">
																		<i><?php echo $f->description; ?></i>
																	<?php } else { ?>	
																		<?php foreach ($languages as $language) { ?>
																		<?php $text = ( isset($module[trim($f->name)][$language['language_id']]) ? trim($module[trim($f->name)][$language['language_id']]) : $f->default );  ?>
																		<div class="tab-pane" id="tab-lang-<?php echo $f->name;?><?php echo $language['language_id']; ?>">
																			<input size="100" value="<?php echo $text; ?>" type="text" name="themecontrol[<?php echo trim($f->name);?>][<?php echo $language['language_id']; ?>]">
																		 </div>
																		<?php } ?>
																	<?php } ?>	 
																</div>
															</div>
														</div>
														<?php } ?>
														<!-- text area -->
														<?php if( $f->type=='textarea') { ?>
														<ul class="nav nav-tabs nav-tablangs">
														<?php foreach ($languages as $language) { ?>
															<li><a href="#tab-lang-<?php echo $f->name;?><?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
														<?php } ?>
														</ul>
														<div class="tab-content">
															<?php 
																foreach ($languages as $language) { 
																	$text = ( isset($module[trim($f->name)][$language['language_id']]) ? trim($module[trim($f->name)][$language['language_id']]) : $f->default );
															?>
															<div class="tab-pane" id="tab-lang-<?php echo $f->name;?><?php echo $language['language_id']; ?>">
																<textarea id="w<?php echo trim($f->name);?>-<?php echo $language['language_id']; ?>"  name="themecontrol[<?php echo trim($f->name);?>][<?php echo $language['language_id']; ?>]"><?php echo $text;?></textarea>
															</div>
															<?php } ?>
														</div>
															
														
														<script type="text/javascript"><!--
															<?php foreach ($languages as $language) { ?>
															$('#w<?php echo trim($f->name);?>-<?php echo $language['language_id']; ?>').summernote({ height: 300 });
															<?php } ?>
														</script>
														<?php } ?>
														<!-- end -->
													</div>
													<?php } ?>	
												</div>
											</div>
													 
											<?php } ?>
											</div>
										<?php } ?>
									</div>
								</div>		
							</div>	
							<?php } ?>

							<div id="tab-font"  class="tab-pane">
								<?php include( $adminModuleViewDir."tab/font-setting.tpl" ); ?>
							</div>
				
							<div id="tab-modules"  class="tab-pane">
								<?php include( $adminModuleViewDir."tab/layout-setting.tpl" ); ?>
							</div>
							
							<input type="hidden" name="action_type" id="action_type" value="new">
							
							<?php if( isset($samples) && $samples )  { ?>
							<div id="tab-datasample"  class="tab-pane">
								<?php include( $adminModuleViewDir."tab/datasample.tpl" ); ?>	
							</div>
							<?php } ?>

							<div id="tab-compress"  class="tab-pane">
								<?php include( $adminModuleViewDir.'tab/compress-setting.tpl' ); ?>
							</div>

							<div id="tab-customcode"  class="tab-pane">
								<?php include( $adminModuleViewDir.'tab/customize-setting.tpl' ); ?>
							</div>
								
							<div id="tab-support" class="tab-pane">
								<h3><?php echo $themeinfo['name'];?></h3>	
								<hr>
								<div class="theme-info panel panel-info">
									<h4 class="panel-heading"><?php echo $olang->get('text_theme_information'); ?></h4>
									<div class="panel-body"><?php echo $themeinfo['description'];?></div>
								</div>	
								<div class="theme-info panel panel-default">
									<h4 class="panel-heading"><?php echo $olang->get('text_support_info'); ?></h4>
									<div class="panel-body"><?php echo $themeinfo['support'];?></div>
								</div>	
							</div>
							<!-- end tab-suport -->

						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- end div container -->
  	
</div>
 
<script type="text/javascript"><!--
	<?php foreach ($languages as $language) { ?>
	$('#customtab-content-<?php echo $language['language_id']; ?>').summernote({ height: 300 });
	$('#contact_customhtml<?php echo $language['language_id']; ?>').summernote({ height: 300 });
	<?php } ?>
 	 
	$('#moduletabs a').click( function(){  
		$.cookie("actived_tab", $(this).attr("href") );
	});

	$('.nav-tablangs').each( function(){
		$(this).find('li:first-child a').tab('show');
	});

	if($.cookie("actived_tab") !="undefined"){ 
		$('#moduletabs a').each( function(){
			if($(this).attr("href") ==  $.cookie("actived_tab")){ 
				$(this).parent().tab('show');
				$("#tab-contents > .tab-pane").removeClass('active');
				$($.cookie("actived_tab")).addClass('active');		
				return ;
			}
		});
	}


	$(document).ready( function(){
		$(".save-data").click( function(){
			// $('#action_type').val( $(this).attr("rel") );
			var string = 'rand='+Math.random();
			var hook = '';
			$(".ui-sortable").each( function(){
				if( $(this).attr("data-position") && $(".module-pos",this).length>0) {
					var position = $(this).attr("data-position");
					$(".module-pos",this).each( function(){
						if( $(this).attr("data-id") != "" ){
							hook += "modules["+position+"][]="+$(this).attr("data-id")+"&";
						}
					});
					string = string.replace(/\,$/,"");
					hook = hook.replace(/\,$/,"");
				}	
			});
			var unhook = '';

			$.ajax({
			  type: 'POST',
			  url: '<?php echo str_replace("&amp;","&",$ajax_modules_position);?>&layout_id='+$("#elayout_id").val(),
			  data: string+"&"+hook+unhook,
			  success: function(){
				 	 $('#sform').submit();
			 		// window.location.reload(true);
			  }
			});
			return false; 
		});

		$("a.ajax-action").click( function(){
			$(this).append('<span class="ajax-loading">Procesing...</span>');
			var _a = this;
			var url = $(this).attr('href');
			$.ajax({
				  type: 'POST',
				  url: url,
				  data: 'rand='+Math.random(),
				  success: function(){
				  	$(".ajax-loading",_a).remove();
				 }
			});	 
			return false; 
		});
	});

	$(".group-change").each( function(){
		var $this = this;
		$(".items-group-change",$this).hide();
		$(".group-"+$(".type-fonts",$this).val(), this).show();
	 
		$(".type-fonts", this).change( function(){
			$(".items-group-change",$this).hide();
			$(".group-"+$(this).val(), $this).show();
		} );
	});


	$(".custom-popup").click( function(){
		$('#dialog').remove();
		
		$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="'+$(this).attr('href')+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
		
		$('#dialog').dialog({
			title: 'Guide For Theme: <?php echo $module["default_theme"]; ?>',
			close: function (event, ui) {},	
			bgiframe: false,
			width: 980,
			height: 560,
			resizable: false,
			modal: true
		});
		return false;
	});
//--></script>


<?php echo $footer; ?>

