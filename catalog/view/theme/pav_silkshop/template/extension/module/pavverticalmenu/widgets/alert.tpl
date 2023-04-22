<?php if ( isset($html)&& !empty($html) ) { ?>
<div class="alert <?php echo $alert_type; ?> <?php echo $addition_cls; ?> <?php if ( isset($stylecls)&&$stylecls ) { ?>-<?php echo $stylecls;?> <?php } ?>">
	<?php echo $html; ?>
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
</div>
<?php } ?>