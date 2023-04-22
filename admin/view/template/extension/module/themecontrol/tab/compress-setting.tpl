<p><i><?php echo $olang->get('text_explain_compression');?></i></p>

<div class="form-group">
 
	<label class="col-sm-2 control-label" id="enable_compress_css"><?php echo $olang->get('enable_compress_css');?></label>
	<div class="col-sm-10">
		<select class="form-control" name="themecontrol[enable_compress_css]">
			<?php foreach( $compressions as $v=>$op ): ?>
			<option value="<?php echo $v;?>" <?php if( $v===$module['enable_compress_css']){ ?> selected="selected" <?php } ?>><?php echo $op;?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>

<div class="form-group">
 
	<label class="col-sm-2 control-label" id="enable_compress_css"><?php echo $olang->get('exclude_css_files');?></label>
	<div class="col-sm-10">
		<textarea cols="30" rows="5" name="themecontrol[exclude_css_files]"><?php echo $module['exclude_css_files'];?></textarea>
			<p><i><?php echo $olang->get('text_exclude_compression_files');?></i></p>
	</div>
</div>


 