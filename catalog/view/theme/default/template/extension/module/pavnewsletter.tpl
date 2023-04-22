<div class="pav-newsletter <?php echo $prefix; ?> pav-newsletter" id="newsletter_<?php echo $position.$module;?>">
		<form id="formNewLestter" method="post" action="<?php echo $action; ?>" class="formNewLestter">
			<div class="content">
				<div class="wapper">
					<div class="description">
						<span class="title"><?php echo $objlang->get("entry_newsletter");?></span>
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
		<div class="description"><?php echo html_entity_decode( $social );?></div>

</div>

<script type="text/javascript"><!--

	$( document ).ready(function() {
		var id = 'newsletter_<?php echo $position.$module;?>';
		$('#'+id+' .box-heading').bind('click', function(){
			$('#'+id).toggleClass('active');
		});

		$('#formNewLestter').on('submit', function() {
			var email = $('.inputNew').val();
			$(".success_inline, .warning_inline, .error").remove();
			if(!isValidEmailAddress(email)) {				
			$('.valid').html("<div class=\"error alert alert-danger\"><?php echo $objlang->get('valid_email'); ?><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button></div></div>");
			$('.inputNew').focus();
			return false;
		}
		var url = "<?php echo $action; ?>";
		$.ajax({
			type: "post",
			url: url,
			data: $("#formNewLestter").serialize(),
			dataType: 'json',
			success: function(json)
			{
				$(".success_inline, .warning_inline, .error").remove();
				if (json['error']) {
					$('.valid').html("<div class=\"warning_inline alert alert-danger\">"+json['error']+"<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button></div>");
				}
				if (json['success']) {
					$('.valid').html("<div class=\"success_inline alert alert-success\">"+json['success']+"<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button></div>");
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