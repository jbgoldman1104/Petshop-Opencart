<?php 
	echo $header; 
 
?>

<div id="content" class="list-btn-mods" >

	<div class="row">
		<?php foreach($ocmodules as $ocmod ) { // echo '<pre>'.print_r( $ocmod, 1 );die ; ?>

			<div class="col-sm-4 ">
				<div class="btn-addmod">
				<strong>
					<?php echo $ocmod['name']; ?>
				</strong>
				
				<a href="<?php echo $ocmod['install'];?>" title="<?php echo $olang->get( 'text_explain_active_module' ); ?>"  class="btn btn-danger btn-xs pull-right btn-install <?php if( !$ocmod['installed']) { ?> active <?php } else { ?> hide <?php } ?>">
					<i class="fa fa-plus-circle"></i>
				</a>
		 
				<a href="<?php echo $ocmod['edit'];?>" title="<?php echo $olang->get( 'text_explain_add_module' ); ?>" class="btn btn-primary btn-edit btn-xs pull-right btn-edit <?php if( !$ocmod['installed']) { ?> hide <?php } ?>">
					<i class="fa fa-pencil"></i>
				</a>
		 
				</div>
			</div>	
		<?php } ?>
	</div>
	<hr>
	<div class="alert alert-info"><?php echo $olang->get( 'text_explain_create_new_module' ); ?></div>
</div>
<script type="text/javascript">
	$(".btn-addmod").each( function(){
		var $btn = $(this);
		 $(".btn-install",$btn).click( function (){
		 	$.ajax({
				url: $(".btn-install",$btn).attr('href')
			}).done(function() {		
				 $(".btn-install",$btn).remove();
				 $(".btn-edit",$btn).removeClass("hide");
			});
			return false; 
		 } );
		
	} );
	

</script>
<?php // echo $footer; ?>