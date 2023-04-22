<?php if( $warning_custom_files_permission ) { ?> 
 
	<?php foreach( $warning_custom_files_permission as $warning ) { ?>
		<div class="alert alert-danger"><?php echo $warning; ?></div>
	<?php } ?>

<?php } ?>
<div class="alert alert-success">
	<i><?php echo $olang->get('text_explain_customization');?></i>
</div>


<div class="form-group">
 
	<label class="col-sm-2 control-label" id="text_customize_theme"><?php echo $olang->get('text_customize_theme');?></label>
	<div class="col-sm-10">
		 <select class="form-control" name="themecontrol[customize_theme]">
			<option value=""><?php echo $olang->get('text_no_select'); ?></option>
			<?php foreach( $files as $file )  { $file = str_replace(".css", "", $file);?>
			<option value="<?php echo $file;?>" <?php if( $module['customize_theme']==$file){?> selected="selected" <?php } ?>><?php echo $file ;?></option>
			<?php } ?>
		</select>
		<hr>
 
		<a href="<?php echo $live_customizing_url;?>" class="btn btn-danger"><span class="fa fa-magic"></span> <?php echo $olang->get('text_live_edit');?></a>
		<hr>	
		<p><i><?php echo $olang->get('text_explain_customize_theme'); ?></i></p>
 
	</div>
</div>

<h4><?php echo $olang->get('text_heading_customize_code');?></h4>

 
<?php echo $olang->get('text_customcss'); ?>

<div class="form-group">
	<label class="col-sm-2 control-label" id="text_customize_theme"><?php echo $olang->get('text_explain_custom_css');?></label>
	<div class="col-sm-10">
		<textarea name="themecontrol[custom_css]" rows="16" cols="80"><?php echo $module['custom_css'];?></textarea>
	</div>
</div>


<h4><?php echo $olang->get('text_customjavascript');?></h4>
 
 <div class="form-group">
	<label class="col-sm-2 control-label" id="text_explain_custom_js"><?php echo $olang->get('text_explain_custom_js');?></label>
	<div class="col-sm-10">
		<textarea name="themecontrol[custom_javascript]" rows="16" cols="80"><?php echo $module['custom_javascript'];?></textarea>
	</div>
</div>
 