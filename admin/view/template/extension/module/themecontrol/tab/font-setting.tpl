<div class="form-group">
	<label class="col-sm-2 control-label" id="entry_enable_customfont"><?php echo $olang->get('entry_enable_customfont');?></label>
	<div class="col-sm-10">
	 	<select class="form-control form-switch" name="themecontrol[enable_customfont]">
		
			<?php foreach( $yesno as $v=>$op ): ?>
				<option value="<?php echo $v;?>" <?php if( $v==$module['enable_customfont']){ ?> selected="selected" <?php } ?>><?php echo $op;?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<hr>

 
<?php for( $i=1; $i<=3;$i++ ){ ?>	
	<div class="form-group">
		<label class="col-sm-2 control-label" id="entry_enable_customfont"><?php echo $fontbase[$i]['label']?></label>
		<div class="col-sm-10">
		  		<div  class="group-change">
						<select class="form-control type-fonts" name="themecontrol[type_fonts<?php echo $i;?>]" class="type-fonts">

							<?php foreach( $type_fonts as $font ) {   ?>
							<option value="<?php echo $font[0];?>"<?php if( $module['type_fonts'.$i] == $font[0]) { ?> selected="selected"<?php } ?>><?php echo $font[1];?></option>
							<?php } ?>
						</select>
 
						<div class="items-group-change group-standard ">
							<div><?php echo $olang->get('entry_normal_font');?></div>
							<div>
								<select class="form-control" name="themecontrol[normal_fonts<?php echo $i;?>]">
									<option value="inherit"><?php echo $olang->get('text_inherit');?></option>
									<?php foreach( $normal_fonts as $font ) {   ?>
									<option value="<?php echo htmlspecialchars($font[0]);?>"<?php if( $module['normal_fonts'.$i] == htmlspecialchars($font[0])) { ?> selected="selected"<?php } ?>><?php echo $font[1];?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="items-group-change group-google">
							<label><?php echo $olang->get('entry_body_google_url');?>
							
							</label>
							<div>
								<input class="form-control" type="text" name="themecontrol[google_url<?php echo $i;?>]" size="65" value="<?php echo $module['google_url'.$i];?>"/>
								<p><i><?php echo $olang->get('text_explain_google_url')?></i></p>
							</div>
						</div>

						<div class="items-group-change group-google">
							<label>Google Family:</label>
							<div><input class="form-control" type="text" name="themecontrol[google_family<?php echo $i?>]" size="65" value="<?php echo $module['google_family'.$i];?>"/>
							<p><i><?php echo $olang->get('text_explain_google_family');?></i></p>
							</div>
						</div>
					 
					</div>
					<div>
						<p><?php echo $olang->get("fontsize");?> 
							<select class="form-control" name="themecontrol[fontsize<?php echo $i;?>]">
								<option value="inherit"><?php echo $olang->get('text_inherit');?></option>
							<?php foreach ( $fontsizes as $key => $value ): ?>
								<?php  $selected = $value == $module['fontsize'.$i]?'selected="selected"':'';	?>	
								<option value="<?php echo $value;?>" <?php echo $selected; ?>><?php echo  $value; ?></option>
							<?php endforeach; ?>
							</select>
						</p>
					</div>
		</div>
	</div>
	<hr>
<?php } ?>
	
  
 
	<?php for( $i=4; $i<=4;$i++ ){ ?>	

	<div class="form-group">
		<label class="col-sm-2 control-label" id="text_customize_theme"><?php echo $olang->get('entry_font_setting');?></label>
		<div class="col-sm-10">
			 <div  class="group-change">
				<select class="form-control type-fonts" name="themecontrol[type_fonts<?php echo $i;?>]" class="type-fonts">
					<?php foreach( $type_fonts as $font ) {   ?>
					<option value="<?php echo $font[0];?>"<?php if( $module['type_fonts'.$i] == $font[0]) { ?> selected="selected"<?php } ?>><?php echo $font[1];?></option>
					<?php } ?>
				</select>
				
	 
						<div class="items-group-change group-standard">
							<label><?php echo $olang->get('entry_normal_font');?></label>
							<div>
								<select class="form-control" name="themecontrol[normal_fonts<?php echo $i;?>]">
									<?php foreach( $normal_fonts as $font ) {   ?>
									<option value="<?php echo htmlspecialchars($font[0]);?>"<?php if( $module['normal_fonts'.$i] == htmlspecialchars($font[0])) { ?> selected="selected"<?php } ?>><?php echo $font[1];?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="items-group-change group-google">
							<div><?php echo $olang->get('entry_body_google_url');?>
							
							</div>
							<div>
								<input class="form-control" type="text" name="themecontrol[google_url<?php echo $i;?>]" size="65" value="<?php echo $module['google_url'.$i];?>"/>
								<p><i><?php echo $olang->get('text_explain_google_url')?></i></p>
							</div>
						</div>
						<div class="items-group-change group-google">
							<div>Google Family:</div>
							<div><input class="form-control" type="text" name="themecontrol[google_family<?php echo $i?>]" size="65" value="<?php echo $module['google_family'.$i];?>"/>
							<p><i><?php echo $olang->get('text_explain_google_family');?></i></p>
							</div>
						</div>
		 
			</div>

		</div>
	</div>
 	
 	<div class="form-group">
		<label class="col-sm-2 control-label" id="text_customize_theme"><?php echo $olang->get('entry_body_selector');?></label>
		<div class="col-sm-10">
			<textarea name="themecontrol[body_selector<?php echo $i?>]" rows="5" cols="50"><?php echo $module['body_selector'.$i];?></textarea>
			<p><i><?php echo $olang->get('text_explain_body_selector');?></i></p>
		</div>
	</div>
<?php } ?>
 