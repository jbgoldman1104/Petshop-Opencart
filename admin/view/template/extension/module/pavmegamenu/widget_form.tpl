
 <?php 
 echo $header; 
?>
 
<div id="content">
	<?php if( isset($message) ) { ?> 
	<div class="success"><?php echo $message; ?></div>
	<?php } ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<table class="form">
			<input value="<?php echo $id;?>" name="widget[id]" type="hidden"/>
			 <?php if( !$disabled ){ ?> 
			<tr>
				<td><?php echo $olang->get("text_widget_type");?></td>
				<td>
					<select name="widget[type]" id="widget_type">
						<option  value=""><?php echo $olang->get("text_widget_select_one");?></option>	
						<?php foreach( $types as $widget => $text ) { ?>
						<option value="<?php echo $widget; ?>" <?php if( $widget_selected == $widget ) { ?> selected="selected" <?php } ?>><?php echo $text; ?></option>
						<?php } ?>
					</select>
					<script type="text/javascript">
						$('#widget_type').change( function(){
							location.href = '<?php echo html_entity_decode($action); ?>&wtype='+$(this).val();
						} );
					</script>
				</td>
			</tr>
			<?php }   ?>
			<tr>
				<td><?php echo $olang->get("text_widget_name");?></td>
				<td>
					<input type="text" name="widget[name]" value="<?php echo $widget_data['name'];?>">
					 <?php if( $disabled ){ ?> 
					 <input type="hidden" name="widget[type]" value="<?php echo $widget_data['type'];?>">
					 <?php } ?>
				</td>
			</tr>
		</table>
		
		<div>
			<?php echo $form; ?>
		</div>
		<div>
			<button type="submit" class="btn button">Save</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	 $("#form").submit( function(){ 
	 	var er = false;
	 	$.each( $("#form").serializeArray(), function(i, e){
	 		 if( e.value == '' ){
	 		 	er = true;
	 		 }
	 	} );
	 	if( er ){
	 		alert(  '<?php echo $olang->get("text_please_fill_data"); ?>' );
	 		return false; 
	 	}
	 	return true;
	 });
</script>
<?php echo $footer; ?>

 