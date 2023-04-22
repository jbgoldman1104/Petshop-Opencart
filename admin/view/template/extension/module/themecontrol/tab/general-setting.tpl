
 
	<div class="tab-inner ">
 

		<div class="form-group">
 
			<label class="col-sm-2 control-label"><?php echo $olang->get('text_default_theme');?></label>
			<div class="col-sm-10">
				 <div class="group-options theme-skins clear">
					<select class="form-control" name="themecontrol[skin]">
						<option value="">default</option>
					<?php foreach( $skins as $skin ): ?>
						<option value="<?php echo $skin;?>" <?php if( $skin==$module['skin']){ ?> selected="selected" <?php } ?>><?php echo $skin;?></option>
					<?php endforeach;?>
					</select>
					
					<div class="clear"></div>
				</div>
			</div>
		</div>


		<?php if( $hasskinsprofile ) { ?>
		<tr>
			<td><label class="label badge bred"><?php echo $olang->get('text_auto_active_profiles'); ?></label></td>
			<td>
				<select class="form-control form-switch" name="themecontrol[enable_activeprofile]">
			
				<?php foreach( $yesno as $v=>$op ): ?>
					<option value="<?php echo $v;?>" ><?php echo $op;?></option>
				<?php endforeach;?>
				</select>
				<p><i><?php echo $olang->get('enable_explain_activeprofile');?></i></p>
			</td>
		<tr>
		<?php } ?>

		<div class="form-group">
 
			<label class="col-sm-2 control-label" id="entry_theme_width"><?php echo $olang->get('entry_theme_width');?></label>
			<div class="col-sm-10">
				  <input class="form-control"  name="themecontrol[theme_width]" value="<?php echo $module['theme_width'];?>">
					<p><i><?php echo $olang->get('text_explain_theme_width');?></i></p>
			</div>
		</div>

		<div class="form-group">
 
			<label class="col-sm-2 control-label" id="entry_enable_copyright"><?php echo $olang->get('entry_enable_copyright');?></label>
			<div class="col-sm-10">
				 <select class="form-control form-switch" name="themecontrol[enable_custom_copyright]">
			
				<?php foreach( $yesno as $v=>$op ): ?>
					<option value="<?php echo $v;?>" <?php if( $v==$module['enable_custom_copyright']){ ?> selected="selected" <?php } ?>><?php echo $op;?></option>
				<?php endforeach;?>
				</select>
			</div>
		</div>

 

		<div class="form-group">
 
			<label class="col-sm-2 control-label"><?php echo $olang->get('copyright');?></label>
			<div class="col-sm-10">
				<textarea cols="40" class="form-control" rows="3" name="themecontrol[copyright]"><?php echo $module['copyright'];?></textarea>
			</div>
		</div>

		<div class="form-group">
 
			<label class="col-sm-2 control-label"><?php echo $olang->get('entry_enable_offsidebars');?></label>
			<div class="col-sm-10">
				 <select class="form-control" name="themecontrol[enable_offsidebars]">
					<option value="0" <?php if( $module['enable_offsidebars'] == 0 ){ echo 'selected="selected"';} ;?>><?php echo $olang->get('no');?></option>
					<option value="1" <?php if( $module['enable_offsidebars'] == 1 ){ echo 'selected="selected"';} ;?>><?php echo $olang->get('yes');?></option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $olang->get('entry_enable_paneltool');?></label>
			<div class="col-sm-10">
				<select class="form-control" name="themecontrol[enable_paneltool]">
					<option value="0" <?php if( $module['enable_paneltool'] == 0 ){ echo 'selected="selected"';} ;?>><?php echo $olang->get('no');?></option>
					<option value="1" <?php if( $module['enable_paneltool'] == 1 ){ echo 'selected="selected"';} ;?>><?php echo $olang->get('yes');?></option>
				</select>
			</div>
		</div>

 
</div>