<link rel="stylesheet" href="<?php echo $typoFile;?>" type="text/css">
<style>
	.typo{ position: relative; width: 90%; min-height: 50px; padding:12px 0;}
	.typo .tp-caption {
	    display: block;
	    left: 0;
	    margin: 0;
	    padding: 0;
	    top: 0;
	}
	.note{ font-size: 12px;}
	.note a { color: #003A88 }
</style>
<div class="modal-dialog modal-lg previewLayer" style="width:980px;">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $heading_title; ?></h4>
		</div>
		<div class="modal-body">
			<!-- START CONTENT TYPOS -->
			<div class="typos">
				<div class="note"> 
					NOTE: <p>These Below Typos are getting in the file:<a href="<?php echo $typoFile ?>" target="_blank"><?php echo $typoFile; ?></a>
					<br>you can open this file and add yours css style and it will be listed in here!!!</p>
					<p>To Select One, You Click The Text Of Each Typo</p>
				</div>
				 <!-- TYPO CAPTIOn -->
				<div class="typos-wrap">	
					<?php foreach( $captions as $caption ) {  ?>
			  		<div style="cursor: pointer;" class="typo" data-dismiss="modal"><div class="iview-caption tp-caption <?php echo $caption;?>" data-class="<?php echo $caption;?>">Use This Caption Typo</div></div><br>
			  		<?php } ?>	
				 </div>
			</div>
			<!-- END CONTENT TYPOS -->
		</div>
	</div>
</div>
<script type="text/javascript">
	$('div.typo').on('click', function(e) {
		e.preventDefault();

		$('#<?php echo $field; ?>', window.parent.document).val( $("div", this).attr("data-class") );

		$('#<?php echo $field; ?>', window.parent.document).attr("value", $("div", this).attr("data-class") );
		
		// 1, Remove old and Add New class
		$("#<?php echo $layer_id; ?>", window.parent.document).removeClass('<?php echo $layer_class; ?>').addClass( $("div", this).attr("data-class") );

		// 2, Save Data Edit change
		var $pavoEditor = $(document).pavoSliderEditor(); 
		$pavoEditor.state = false;

		// 3. only save layer-text color 
		$("#<?php echo $layer_id; ?>.draggable-item.tp-caption.layer-text.ui-draggable.ui-draggable-handle.layer-active").data( "data-form", $( '#slider-form', window.parent.document ).serializeArray() );

	});
</script>