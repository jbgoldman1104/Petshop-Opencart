<div id="blog-accordion" class="box">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="box-content">
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