<div class="panel panel-default hightlight">
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title; ?></h4></div>
	<div id="pav-categorymenu">
		<div class="panel-body">
			<?php echo $tree;?>
		</div>
	</div>
 </div>
<script>
$(document).ready(function(){
	// applying the settings
	 $("#pav-categorymenu li.active span.head").addClass("selected");
	 	$('#pav-categorymenu ul').Accordion({
	 		active: 'span.selected',
	 		header: 'span.head',
	 		alwaysOpen: false,
	 		animated: true,
	 		showSpeed: 400,
	 		hideSpeed: 800,
	 		event: 'click'
	 	});

	 $("#pav-categorymenu .pav-category ul").addClass('list-group');
	 $("#pav-categorymenu .pav-category ul > li").addClass('list-group-item');
		
	});

</script>