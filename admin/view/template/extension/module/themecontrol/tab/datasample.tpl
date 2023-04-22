
<div class="alert alert-info">
		<i><?php echo $olang->get('text_message_datasample_modules');?></i>
</div>
	<div class="panel panel-info">
		<div class=" panel-heading">
				<h3>A. <?php echo $olang->get('text_installation');?></h3>
		</div>
		<div class=" panel-body">
			<p class="alert alert-success">
				   <span><a rel="install" class="btn   btn-danger" href="<?php echo $ourl->link('extension/module/themecontrol/storesample', 'theme='.$module['default_theme'].'&token=' . $token, 'SSL');?>">
						<?php echo $olang->get('text_install_store_sample');?> <br>
						<i><?php echo $olang->get('text_install_store_sample_explain'); ?></i>
					</a></span>

				
				|
			
				-  <span><a href="<?php echo $ajax_massinstall;?>"  id="btnmassinstall"    class="button btn  btn-warning btn-save"><span class="fa fa-save"></span>
				 <?php echo $olang->get('text_mass_install');?> <br>
				 <i><?php echo $olang->get('text_explain_massup');?> </i>
				</a></span>
				</p>	
		</div>
	</div>	
	
	
	

	<div class="panel panel-default">
		<div class="panel-heading"><h3>B. <?php echo $olang->get('text_installation_from_profile');?> </h3>
			 </div>
		<div class="panel-body">
			A. <?php echo $olang->get('text_installation_profile');?> / <i><?php echo $olang->get('text_installation_profile_explain');?></i> 
			<div class="storeconfig-up" style=" margin:0 30px">
				 <div class="form-group"><label>Or Upload A Theme Profile (*.txt):	</label><input  type="file" name="upload"> </div>
			  <div class="form-group">
				 
				 <button class="btn btn-danger save-data" title="Save" data-toggle="tooltip" onclick="$('#action_type').val('save-importprofile');" type="button"><i class="fa fa-save save-data"></i> Import</button>	 

			 	<span><a href="<?php echo $exportprofile_action; ?>" class="button btn btn-primary">Export Profile</a></span>	
			</div>	

				 
			</div>	
		</div>
	</div>
 
 

<?php if( !empty($unexpectedModules) ) { ?>

<div class="panel-installs clearfix">
	<div class="panel ">
		<div class="panel-heading"> <?php echo $olang->get('disable_expected_module_in_home_page'); ?> <i><?php echo $olang->get('text_message_disable_expected_module_in_home_page');?></i></div>
		<div class="panel-body">
			<table class="form">
				<?php foreach(  $unexpectedModules as $umodule )  { ?>
				<tr>
					<td>
						<a href="<?php echo $ourl->link('extension/module/'.$umodule['code'], 'token=' . $token, 'SSL');?>"><?php echo $umodule['title']; ?></a>
					</td>
					<td>
						<a  rel="install-extension" class="label badge bdanger" href="<?php echo $ourl->link('extension/module/uninstall', 'extension='.$umodule['code'].'&token=' . $token, 'SSL');?>">
							<?php echo $olang->get('text_uninstall_now'); ?> </a>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>	
	</div>
</div>

<?php } ?>
<script type="text/javascript">

$("#btnmassinstall").click( function(){
	var $this = $(this);
	var flag = confirm( '<?php echo $olang->get('text_message_install_sample'); ?>' );
	if( flag ){
		$.ajax( {url: $(this).attr('href'),'type':'GET', complete:function(  ){
		 	$this.parent().html('<?php echo $olang->get("text_install_done");?>');	
		} }  );
	}
	return false;
} );

$("#tab-datasample a").click( function(){
var flag = false; 
if( $(this).attr('rel') == 'override' ){
	var flag = confirm( '<?php echo $olang->get('text_message_override_sample'); ?>' );
}else if( $(this).attr('rel') == 'install' ){
	var flag = confirm( '<?php echo $olang->get('text_message_install_sample'); ?>' );
}else if( $(this).attr('rel') == 'restore' ){
	var flag = confirm( '<?php echo $olang->get('text_message_restore_sample'); ?>' );
}else if(  $(this).attr('rel') == 'install-extension' ){
	flag = 1;
}else {
	return true; 
}
if( flag ){
	var $this = $( this );
	$this.html('processing');	
	$.post( $(this).attr('href'), function(data) {
		// $('.result').html(data);
		if( $this.attr("rel") == "install-extension" ){
			$this.remove();
		}else {
			$this.parent().html('<?php echo $olang->get("text_install_done");?>');	
		}
	});
	return false;
}
return false; 
} );		
</script>
				