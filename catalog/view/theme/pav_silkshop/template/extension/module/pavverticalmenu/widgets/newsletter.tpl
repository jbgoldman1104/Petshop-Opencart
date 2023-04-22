<?php $objlang = $this->registry->get('language'); ?>
<div class="widget-accordion  <?php $addition_cls?> <?php if ( isset($stylecls)&&$stylecls) { ?>-<?php echo $stylecls; ?><?php } ?>" id="newsletter_<?php echo $position.$module;?>">
		<form id="formNewLestter<?php echo $module?>" method="post" action="<?php echo $action; ?>" class="formNewLestter">
			<div class="content">
				<div class="wapper">
					<div class="description">
						<span class="title"><?php echo $widget_heading?></span>
						<br/>
						<?php echo html_entity_decode( $description );?></div>
					<div class="input-form">
						<input type="text" class="form-control input-md inputNew" <?php if(!isset($customer_email)): ?> onblur="javascript:if(this.value=='')this.value='<?php echo $objlang->get("default_input_text");?>';" onfocus="javascript:if(this.value=='<?php echo $objlang->get("default_input_text");?>')this.value='';"<?php endif; ?> value="<?php echo isset($customer_email)?$customer_email:$objlang->get("default_input_text");?>" size="18" name="email">
					</div>
					<div class="button-submit">
							<button type="submit" name="submitNewsletter" class="btn btn-outline"><?php echo $objlang->get("button_subscribe");?></button>
						</div>	
					<input type="hidden" value="1" name="action">
					<div class="valid"></div>
				</div>
			</div>	

		</form>
</div>

<script type="text/javascript"><!--

	$( document ).ready(function() {
		var id = 'newsletter_<?php echo $position.$module;?>';
		var cw = $("#"+id);
		$('#'+id+' .-heading').bind('click', function(){
			$('#'+id).toggleClass('active');
		});

		$('#formNewLestter<?php echo $module?>').on('submit', function() {  
			var email = $('.inputNew', cw ).val();
			$(".success_inline, .warning_inline, .error", cw ).remove();
			if(!isValidEmailAddress(email)) {				
			$('.valid', cw ).html("<div class=\"error alert alert-danger\"><?php echo $objlang->get('valid_email'); ?></div>");
			$('.inputNew', cw).focus();
			return false;
		}
		var url = "<?php echo $action; ?>";
		$.ajax({
			type: "post",
			url: url,
			data: $("#formNewLestter<?php echo $module?>").serialize(),
			dataType: 'json',
			success: function(json)
			{
				$(".success_inline, .warning_inline, .error").remove();
				if (json['error']) {
					$('.valid', cw ).html("<div class=\"warning_inline alert alert-danger\">"+json['error']+"</div>");
				}
				if (json['success']) {
					$('.valid', cw ).html("<div class=\"success_inline alert alert-success\">"+json['success']+"</div>");
				}
			}
		});
		return false;
	});
});

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}
--></script>