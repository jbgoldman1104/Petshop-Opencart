<?php 
	echo $header; 
	echo $column_left; 
?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- end div .page-header -->
	<div id="page-content" class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body" >

				<div class="col-sm-2">
					<div class="logo"><h3><?php echo $heading_title; ?></h3></div>
					<div class="slidebar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
					<div class="clear clr"></div>
				</div>

				<div class="col-sm-10">
					<div class="heading">
						<h3><?php echo $objlang->get("text_create_newsletter"); ?></h1>
					</div>
					<div class="toolbar"><?php require( dirname(__FILE__).'/action_bar.tpl' ); ?></div>
					
					<div class="content">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
							<input type="hidden" name="id" value="<?php echo $id; ?>" />
							<input type="hidden" name="spam_check" value="" />
							<input type="hidden" id="action" name="action" value=""/>

							<table class="table">
								<tr>
									<td><?php echo $entry_template; ?></td>
									<td><select class="form-control" name="template_id"><option value="9999"><?php echo $objlang->get('entry_template_default'); ?></option>
										<?php foreach ($templates as $template) { ?>
										<?php if ($template['template_id'] == $template_id) { ?>
										<option value="<?php echo $template['template_id']; ?>" selected="selected"><?php echo $template['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $template['template_id']; ?>"><?php echo $template['name']; ?></option>
										<?php } ?>
										<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td><?php echo $entry_language; ?></td>
									<td><select class="form-control" name="language_id">
										<?php foreach ($languages as $language) { ?>
										<?php if ($language['language_id'] == $language_id) { ?>
										<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
										<?php } ?>
										<?php } ?>
										</select><br/>
										<?php if ($only_selected_language) { ?>
										<label><input type="checkbox" name="only_selected_language" value="1" checked="checked" />
										<?php } else { ?>
										<label><input type="checkbox" name="only_selected_language" value="1" />
										<?php } ?>
										<?php echo $text_only_selected_language; ?></label>
									</td>
								</tr>
								<tr>
									<td><?php echo $entry_currency; ?></td>
									<td><select class="form-control" name="currency">
										<?php foreach ($currencies as $cur) { ?>
										<?php if ($cur['code'] == $currency) { ?>
										<option value="<?php echo $cur['code']; ?>" selected="selected"><?php echo $cur['title']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $cur['code']; ?>"><?php echo $cur['title']; ?></option>
										<?php } ?>
										<?php } ?>
									</select></td>
								</tr>
								<tr>
									<td><?php echo $entry_store; ?></td>
									<td><select class="form-control" name="store_id">
										<?php array_unshift($stores, array('store_id' => 0, 'name' => $text_default)); ?>
										<?php foreach ($stores as $store) { ?>
										<?php if ($store['store_id'] == $store_id) { ?>
										<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select></td>
								</tr>
								<tr>
									<td><?php echo $entry_to; ?></td>
									<td><select id="groupto" class="form-control" name="to">
										<?php if ($to == 'newsletter') { ?>
										<option value="newsletter" selected="selected"><?php echo $text_newsletter; ?></option>
										<?php } else { ?>
										<option value="newsletter"><?php echo $text_newsletter; ?></option>
										<?php } ?>
										<?php if ($to == 'customer_all') { ?>
										<option value="customer_all" selected="selected"><?php echo $text_customer_all; ?></option>
										<?php } else { ?>
										<option value="customer_all"><?php echo $text_customer_all; ?></option>
										<?php } ?>

										<?php if ($to == 'customer_group') { ?>
										<option value="customer_group" selected="selected"><?php echo $text_customer_group; ?></option>
										<?php } else { ?>
										<option value="customer_group"><?php echo $text_customer_group; ?></option>
										<?php } ?>

										<?php if ($to == 'customer') { ?>
										<option value="customer" selected="selected"><?php echo $text_customer; ?></option>
										<?php } else { ?>
										<option value="customer"><?php echo $text_customer; ?></option>
										<?php } ?>

										<?php if ($to == 'product') { ?>
										<option value="product" selected="selected"><?php echo $text_product; ?></option>
										<?php } else { ?>
										<option value="product"><?php echo $text_product; ?></option>
										<?php } ?>

									</select></td>
								</tr>
								<!-- to-customer-group -->
								<tbody id="to-customer-group" class="to">
									<tr>
									<td><?php echo $entry_customer_group; ?></td>
									<td><select class="form-control" name="customer_group_id">
										<?php foreach ($customer_groups as $customer_group) { ?>
										<?php if ($customer_group['customer_group_id'] == $customer_group_id && $to == 'customer_group') { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
										<?php } ?>
										<?php } ?>
										</select>&nbsp;
										<?php if ($customer_group_only_subscribers) { ?>
										<label><input type="checkbox" name="customer_group_only_subscribers" value="1" checked="checked" />
										<?php } else { ?>
										<label><input type="checkbox" name="customer_group_only_subscribers" value="1" />
										<?php } ?>
										<?php echo $text_only_subscribers; ?></label>
										</td>
									</tr>
								</tbody>

								<!-- to-customer -->
								<tbody id="to-customer" class="to" style="display: none;">
									<tr>
										<td><label class="col-sm-2 control-label" for="input-customer"><span data-toggle="tooltip" title="<?php echo $objlang->get("help_customer"); ?>"><?php echo $entry_customer; ?></span></label></td>
										<td>
											<input type="text" name="customers" value="" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											<div id="items-customer" class="well well-sm" style="height: 150px; overflow: auto;">
												<?php foreach ($customers as $customer) { ?>
												<div id="item-customer<?php echo $customer['customer_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $customer['name']; ?>
													<input type="hidden" name="customer[]" value="<?php echo $customer['customer_id']; ?>" />
												</div>
												<?php } ?>
											</div>
										</td>
									</tr>
								</tbody>
							
								<!-- to-product -->
								<tbody id="to-product" class="to" style="display: none;">
									<tr>
										<td><label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $objlang->get("help_customer"); ?>"><?php echo $entry_product; ?></span></label></td>
										<td>
											<input type="text" name="products" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											<div id="items-product" class="well well-sm" style="height: 150px; overflow: auto;">
												<?php foreach ($products as $product) { ?>
												<div id="item-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
													<input type="hidden" name="product[]" value="<?php echo $product['product_id']; ?>" />
												</div>
												<?php } ?>
											</div>
										</td>
									</tr>
								</tbody>

								<tr>
									<td><?php echo $entry_special; ?></td>
									<td>
										<?php if($special) {
										$checked1 = ' checked="checked"';
										$checked0 = '';
										} else {
										$checked1 = '';
										$checked0 = ' checked="checked"';
										} ?>
										<label for="special_1"><?php echo $entry_yes; ?></label>
										<input type="radio"<?php echo $checked1; ?> id="special_1" name="special" value="1" />
										<label for="special_0"><?php echo $entry_no; ?></label>
										<input type="radio"<?php echo $checked0; ?> id="special_0" name="special" value="0" />
									</td>
								</tr>
								<tr>
									<td><?php echo $entry_latest; ?></td>
									<td>
										<?php if($latest) {
										$checked1 = ' checked="checked"';
										$checked0 = '';
										} else {
										$checked1 = '';
										$checked0 = ' checked="checked"';
										} ?>
										<label for="latest_1"><?php echo $entry_yes; ?></label>
										<input type="radio"<?php echo $checked1; ?> id="latest_1" name="latest" value="1" />
										<label for="latest_0"><?php echo $entry_no; ?></label>
										<input type="radio"<?php echo $checked0; ?> id="latest_0" name="latest" value="0" />
									</td>
								</tr>
								<tr>
									<td><?php echo $entry_popular; ?></td>
									<td>
										<?php if($popular) {
										$checked1 = ' checked="checked"';
										$checked0 = '';
										} else {
										$checked1 = '';
										$checked0 = ' checked="checked"';
										} ?>
										<label for="popular_1"><?php echo $entry_yes; ?></label>
										<input type="radio"<?php echo $checked1; ?> id="popular_1" name="popular" value="1" />
										<label for="popular_0"><?php echo $entry_no; ?></label>
										<input type="radio"<?php echo $checked0; ?> id="popular_0" name="popular" value="0" />
									</td>
								</tr>
							
								<tr>
									<td><span class="required">*</span> <?php echo $entry_subject; ?></td>
									<td>
										<input type="text" name="subject" value="<?php echo $subject; ?>" size="60" />
										<?php if ($error_subject) { ?>
										<span class="error"><?php echo $error_subject; ?></span>
										<?php } ?>
									</td>
								</tr>

								<tr>
									<td><span class="required">*</span> <?php echo $entry_message; ?></td>
									<td>
										<textarea name="message" rows="5" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control"><?php echo $message; ?></textarea>

										<?php if ($error_message) { ?>
										<span class="error"><?php echo $error_message; ?></span>
										<?php } ?>
										<p><?php echo $text_message_info; ?></p>
									</td>
								</tr>
							</table>

						</form>
					</div>
				</div>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->



<script type="text/javascript">

// Customer Auto Complete
$('#items-customer').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
$('input[name=\'customers\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'customers\']').val('');
		
		$('#items-customer' + item['value']).remove();
		
		$('#items-customer').append('<div id="item-customer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="customer[]" value="' + item['value'] + '" /></div>');	
	}	
});

// product Auto Complete
$('#items-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
$('input[name=\'products\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'products\']').val('');
		
		$('#items-product' + item['value']).remove();
		
		$('#items-product').append('<div id="item-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');	
	}	
});

$('#input-message').summernote({height: 300});

$('#groupto').bind('change', function() {
	var val = $(this).val();
	if(val == "customer") {
		$("#to-customer").show();
		$("#to-product").hide();
	} else if(val == "product"){
		$("#to-product").show();
		$("#to-customer").hide();
	} else {
		$("#to-customer").hide();
		$("#to-product").hide();
	}
});
</script>
<?php echo $footer; ?>





