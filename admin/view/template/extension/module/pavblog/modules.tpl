<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="$('#form').submit();" class="btn btn-primary"><?php echo $objlang->get("button_save"); ?></a>
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

		<div id="ajaxloading" class="hide">
			<div class="alert alert-warning" role="alert"><?php echo $objlang->get('text_process_request'); ?></div>
		</div>

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			
			<form action="<?php echo $action;?>" method="post" id="form">
			<div class="panel-body">

				<ul class="nav nav-tabs" id="grouptab">
					<li><a href="#tab-general" data-toggle="tab"><?php echo $objlang->get('text_general_setting');?></a></li>
					<li><a href="#tab-category" data-toggle="tab"><?php echo $objlang->get('text_category_setting');?></a></li>
					<li><a href="#tab-blog" data-toggle="tab"><?php echo $objlang->get('text_blog_setting');?></a></li>
					<?php
						if(!empty($layout_modules)){
							foreach($layout_modules as $key=>$modules){
								$key = trim($key);
					?>
					<li><a href="#tab-module-<?php echo $key ?>"><?php echo $objlang->get("tab_".strtolower($key)); ?></a></li>
					<?php
							}
						}
					?>
				</ul>
				<div class="tab-content">
					<div id="tab-general" class="tab-pane">
						<table class="table">
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_large_image_demension');?></td>
								<td class="col-sm-8">
									<input style="width:20%"style="width:20%" class="form-control"name="pavblog[general_lwidth]" value="<?php echo $general_setting['general_lwidth'];?>" size="3"/> 
									x 
									<input style="width:20%"class="form-control"size="3" name="pavblog[general_lheight]" value="<?php echo $general_setting['general_lheight'];?>" />
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_small_image_demension');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[general_swidth]" value="<?php echo $general_setting['general_swidth'];?>" size="3"/>
									x 
									<input style="width:20%"class="form-control"size="3" name="pavblog[general_sheight]" value="<?php echo $general_setting['general_sheight'];?>" />
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_xsmall_image_demension');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[general_xwidth]" value="<?php echo $general_setting['general_xwidth'];?>" size="3"/> 
									x 
									<input style="width:20%"class="form-control"size="3" name="pavblog[general_xheight]" value="<?php echo $general_setting['general_xheight'];?>" />
								</td>
							</tr>
							
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_rss_limit');?></td>
								<td class="col-sm-8"><input style="width:20%"class="form-control"size="3" name="pavblog[rss_limit_item]" value="<?php echo $general_setting['rss_limit_item'];?>" /></td>
							</tr>
							<tr>
								<td colspan="2">
									<h4><?php echo $objlang->get('text_seo_data');?></h4>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('text_keyword_listing_blogs_page');?></td>
								<td class="col-sm-8"><input style="width:20%"class="form-control"size="30" name="pavblog[keyword_listing_blogs_page]" value="<?php echo $general_setting['keyword_listing_blogs_page'];?>" /></td>
							</tr>	
						</table>
					</div>
					<!-- end div tab-general -->

					<div id="tab-category" class="tab-pane">
						<table class="table">
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_children_columns');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[children_columns]" value="<?php echo $general_setting['children_columns'];?>" size="10"/>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_category_image_demension');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[general_cwidth]" value="<?php echo $general_setting['general_cwidth'];?>" size="3"/> 
									x 
									<input style="width:20%"class="form-control"size="3" name="pavblog[general_cheight]" value="<?php echo $general_setting['general_cheight'];?>" />
								</td>
							</tr> 
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_limit_leading_blogs');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[cat_limit_leading_blog]" value="<?php echo $general_setting['cat_limit_leading_blog'];?>" size="10"/>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_limit_secondary_blogs');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[cat_limit_secondary_blog]" value="<?php echo $general_setting['cat_limit_secondary_blog'];?>" size="10"/>
								</td>
							</tr>
							
							
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_leading_image_types');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_leading_image_type]">
									<?php foreach( $image_types as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_leading_image_type']){?>selected="selected"<?php } ?> ><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_secondary_image_types');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_secondary_image_type]">
									<?php foreach( $image_types as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_secondary_image_type']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_columns_leading_blogs');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[cat_columns_leading_blog]" value="<?php echo $general_setting['cat_columns_leading_blogs'];?>" size="10"/>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_columns_secondary_blogs');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[cat_columns_secondary_blogs]" value="<?php echo $general_setting['cat_columns_secondary_blogs'];?>" size="10"/>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_title');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_title]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_title']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_description');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_description]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_description']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_readmore');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_readmore]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_readmore']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_image');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_image]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_image']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
		
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_author');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_author]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_author']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_category');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_category]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_category']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_created');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_created]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_created']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_hits');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_hits]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_hits']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_comment_counter');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[cat_show_comment_counter]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['cat_show_comment_counter']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<!-- end div tab-category -->

					<div id="tab-blog" class="tab-pane">
						<table class="table">
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_blog_image_types');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_image_type]">
									<?php foreach( $image_types as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_image_type']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_title');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_title]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_title']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_image');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_image]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_image']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>

							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_author');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_author]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_author']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_category');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_category]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_category']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_created');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_created]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_created']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_comment_counter');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_comment_counter]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_comment_counter']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_hits');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_hits]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_hits']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_show_comment_form');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[blog_show_comment_form]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['blog_show_comment_form']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_comment_engine');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[comment_engine]">
										<?php foreach( $comment_engine as $key => $engine ){?>
											<option value="<?php echo $key;?>" <?php if($key==$general_setting['comment_engine']){?>selected="selected"<?php } ?>><?php echo $engine;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_diquis_account');?></td>
								<td class="col-sm-8"><input style="width:20%"class="form-control"name="pavblog[diquis_account]" value="<?php echo $general_setting['diquis_account'];?>" size="30"/>
								<br>
									<a href="https://disqus.com/admin/signup/" target="_blank"><?php echo $objlang->get('text_signup_diquis');?> </a>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_facebook_appid');?></td>
								<td class="col-sm-8">
									<input style="width:20%"class="form-control"name="pavblog[facebook_appid]" value="<?php echo $general_setting['facebook_appid'];?>" size="30"/>
									<p><i><?php echo $objlang->get('text_facebook_id_explain');?></i></p>
									<a target="_blank" href="http://developers.facebook.com/docs/reference/plugins/comments/">http://developers.facebook.com/docs/reference/plugins/comments/</a>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_comment_limit');?></td>
								<td class="col-sm-8"><input style="width:20%"class="form-control"name="pavblog[comment_limit]" value="<?php echo $general_setting['comment_limit'];?>" size="30"/></td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_facebook_width');?></td>
								<td class="col-sm-8"><input style="width:20%"class="form-control"name="pavblog[facebook_width]" value="<?php echo $general_setting['facebook_width'];?>" size="30"/></td>
							</tr>
							
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_auto_publish_comment');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[auto_publish_comment]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['auto_publish_comment']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-4"><?php echo $objlang->get('entry_enable_recaptcha');?></td>
								<td class="col-sm-8">
									<select style="width:20%" class="form-control"name="pavblog[enable_recaptcha]">
									<?php foreach( $yesno as $k => $v ) { ?>
										<option value="<?php echo $k;?>" <?php if($k==$general_setting['enable_recaptcha']){?>selected="selected"<?php } ?>><?php echo $v;?></option>	
									<?php } ?>
									</select>
									
								</td>
							</tr>
						</table>
					</div>
					<!-- end div tab-blog -->

					<!-- foreach div panel -->
					<?php
						if(!empty($layout_modules)){
							foreach($layout_modules as $key=>$item_module){
								//check the module is not installed
								if(!is_array($item_module)){
									$install_link = $this->url->link('extension/module/install', "extension=$key&token=" . $this->session->data['token'], 'SSL');
									?>
									<div id="tab-module-<?php echo $key;?>" class="tab-pane">
										<div class="tab-inner">
											<p><?php echo $objlang->get("module_not_installed"); ?><a  class="install_button" href="<?php echo $install_link; ?>"><?php echo $objlang->get("install");?></a></p>
											<div class="clear"></div>
										</div>
									</div>
									<?php
								}else{
									$modules_tpl = dirname(__FILE__).'/modules/'.trim($key).'.tpl';
									$modules = $item_module;
									$module_key = $key;
									if (isset($this->request->post[$key.'_module'])) {
										$modules = $this->request->post[$key.'_module'];
									}
									
									?>
									<div id="tab-module-<?php echo $key;?>" class="tab-pane">
										<div class="tab-inner">
											<input style="width:20%"class="form-control"type="hidden" name="pavblog[modules][]" value="<?php echo $key;?>"/>
											<?php
											if( file_exists($modules_tpl) ){
												require_once($modules_tpl);
											}
											?>
											<div class="clear"></div>
										</div>
									</div>
									<?php
								}
								
							}
						}
					?>
				</div><!-- end div tab-content -->

			</div>
			</form><!-- end from -->

		</div>

	</div><!-- end div #page-content -->
</div><!-- end div #content -->
<script type="text/javascript">
	$('#grouptab li:first-child a').tab('show');
	function __submit( val ){
		$("#action_mode").val( val );
		$("#form").submit();
	}
</script>
<?php echo $footer; ?>
