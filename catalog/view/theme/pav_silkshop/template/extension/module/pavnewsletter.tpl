
<div class="<?php echo $prefix; ?> pav-newsletter" id="newsletter_<?php echo $position.$module;?>">
		<form id="formNewLestter" method="post" action="<?php echo $action; ?>" class="formNewLestter">
            <h5 class="heading"><?php echo $objlang->get("entry_sign_up_for_newsletter");?></h5>
                <div class="description"><p><?php echo html_entity_decode( $description );?></p></div>
                <div class="input-group">
                    <input type="text" class="form-control email" <?php if(!isset($customer_email)): ?> <?php endif; ?> placeholder="<?php echo $objlang->get("default_input_text");?>" name="email">
                	<div class="input-group-btn">
                    	<button type="submit" name="submitNewsletter" class="btn btn-primary" value="<?php echo $objlang->get("button_subscribe");?>">
                        <i class="fa fa-long-arrow-right"> </i></button>
                	</div>
                </div>
             
                <input type="hidden" value="1" name="action">
                <div class="valid"></div>
                <?php if (!empty($social)): ?>
                        <?php  echo html_entity_decode( $social );?>
                <?php endif ?>	
		</form>
		<ul class="list-inline">  
			<li><a href="#"><i class="icons icons-sm fa fa-twitter"></i></a></li>  
			<li><a href="#"><i class="icons icons-sm fa fa-facebook"></i></a></li>  
			<li><a href="#"><i class="icons icons-sm fa fa-google-plus"></i></a></li>  
			<li><a href="#"><i class="icons icons-sm fa fa-facebook"></i></a></li>
		</ul>
</div>
<script type="text/javascript"><!--

$( document ).ready(function() {

	$('#formNewLestter').on('submit', function() {
		var email = $('.email').val();
		$(".success_inline, .warning_inline, .error").remove();
		if(!isValidEmailAddress(email)) {				
			$('.valid').html("<div class=\"error alert alert-danger\"><?php echo $objlang->get('valid_email'); ?><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button></div></div>");
			$('.email').focus();
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
		}); return false;
	
	}); //end submmit
}); //end document

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}
--></script>