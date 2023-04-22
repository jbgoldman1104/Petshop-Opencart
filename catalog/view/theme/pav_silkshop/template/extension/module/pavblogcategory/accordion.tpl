<div id="blog-accordion" class="panel panel-default">
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title; ?></h4></div>
	<div class="panel-body">
		<?php echo $tree;?>
	</div>
</div>

<script type="text/javascript">
$('#blog-accordion .level2, .level3, .level4').hide();
$('#blog-accordion .box-content a i').click(function(){
	$('+ ul',$(this).parent()).slideToggle(400);
	$(this).parent().toggleClass('clicked');
	$(this).html($(this).parent().hasClass('clicked')?"<span>-</span>":"<span>+</span>");
	return false;
});
</script>