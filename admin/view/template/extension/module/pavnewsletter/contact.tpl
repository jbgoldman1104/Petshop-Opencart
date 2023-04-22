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
					<br/>
					
					<div class="content">
						<!-- content -->
						<div class="panel-body">
							<form class="form-horizontal">
								<input type="hidden" name="draft_id" value="<?php echo $draft_id; ?>" />
								<div class="form-group"> 
									<label class="col-sm-2 control-label" for="input-store"><?php echo $entry_store; ?></label>
									<div class="col-sm-10">
										<select name="store_id" id="input-store" class="form-control">
											<option value="0"><?php echo $text_default; ?></option>
											<?php foreach ($stores as $store) { ?>
											<?php $selected = ($store == $store_id)?"selected='selected'":''; ?>
											<option <?php echo $selected; ?> value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-to"><?php echo $entry_to; ?></label>
									<div class="col-sm-10">
										<select name="to" id="input-to" class="form-control">
											<?php foreach ($tos as $item) { ?>
											<?php $selected = ($item == $to)?"selected='selected'":''; ?>
											<option <?php echo $selected; ?> value="<?php echo $item; ?>"><?php echo $objlang->get('text_'.$item); ?></option>	
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group to" id="to-customer-group">
									<label class="col-sm-2 control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
									<div class="col-sm-10">
										<select name="customer_group_id" id="input-customer-group" class="form-control">
											<?php foreach ($customer_groups as $customer_group) { ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group to" id="to-customer">
									<label class="col-sm-2 control-label" for="input-customer"><span data-toggle="tooltip" title="<?php echo $help_customer; ?>"><?php echo $entry_customer; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="customers" value="" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
										<div class="well well-sm" style="height: 150px; overflow: auto;">
											<?php if(!empty($customers)) { ?>
											<?php foreach ($customers as $item) { ?>
											<div id="customer<?php echo $item['customer_id']; ?>">
												<i class="fa fa-minus-circle"></i> <?php echo $item['name']; ?>
												<input type="hidden" name="customer[]" value="<?php echo $item['customer_id']; ?>">
											</div>	
											<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="form-group to" id="to-affiliate">
									<label class="col-sm-2 control-label" for="input-affiliate"><span data-toggle="tooltip" title="<?php echo $help_affiliate; ?>"><?php echo $entry_affiliate; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="affiliates" value="" placeholder="<?php echo $entry_affiliate; ?>" id="input-affiliate" class="form-control" />
										<div class="well well-sm" style="height: 150px; overflow: auto;">
										<?php if(!empty($affiliates)) { ?>
											<?php foreach ($affiliates as $item) { ?>
											<div id="affiliate<?php echo $item['affiliate_id']; ?>">
												<i class="fa fa-minus-circle"></i> <?php echo $item['name']; ?>
												<input type="hidden" name="affiliate[]" value="<?php echo $item['affiliate_id']; ?>">
											</div>	
											<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="form-group to" id="to-product">
								<label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="products" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
										<div class="well well-sm" style="height: 150px; overflow: auto;">
											<?php if(!empty($products)) { ?>
											<?php foreach ($products as $item) { ?>
											<div id="product<?php echo $item['product_id']; ?>">
												<i class="fa fa-minus-circle"></i> <?php echo $item['name']; ?>
												<input type="hidden" name="product[]" value="<?php echo $item['product_id']; ?>">
											</div>	
											<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-subject"><?php echo $entry_subject; ?></label>
									<div class="col-sm-10">
										<input type="text" name="subject" value="<?php echo $subject; ?>" placeholder="<?php echo $entry_subject; ?>" id="input-subject" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
									<div class="col-sm-10">
										<textarea name="message" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control"><?php echo $message; ?></textarea>
									</div>
								</div>
							</form>
						</div>
						<!-- end content form -->
					</div>
				</div>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->

<script type="text/javascript"><!--
$('#input-message').summernote({
	height: 300
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'to\']').on('change', function() {
	$('.to').hide();

	$('#to-' + this.value.replace('_', '-')).show();
});
$('select[name=\'to\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
// Customers
$('input[name=\'customers\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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

		$('#input-customer' + item['value']).remove();

		$('#input-customer').parent().find('.well').append('<div id="customer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="customer[]" value="' + item['value'] + '" /></div>');
	}
});

$('#input-customer').parent().find('.well').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Affiliates
$('input[name=\'affiliates\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['affiliate_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'affiliates\']').val('');

		$('#input-affiliate' + item['value']).remove();

		$('#input-affiliate').parent().find('.well').append('<div id="affiliate' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="affiliate[]" value="' + item['value'] + '" /></div>');
	}
});

$('#input-affiliate').parent().find('.well').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

// Products
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

		$('#input-product' + item['value']).remove();

		$('#input-product').parent().find('.well').append('<div id="product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');
	}
});

$('#input-product').parent().find('.well').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

function draft(url) {
	$('textarea[name=\'message\']').val($('#input-message').code());
	$.ajax({
		url: url,
		type: 'post',
		data: $('#content select, #content input, #content textarea'),
		dataType: 'json',
		complete: function() {
			$('#button-draft').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
				}

				if (json['error']['subject']) {
					$('input[name=\'subject\']').after('<div class="text-danger">' + json['error']['subject'] + '</div>');
				}

				if (json['error']['message']) {
					$('textarea[name=\'message\']').parent().append('<div class="text-danger">' + json['error']['message'] + '</div>');
				}
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
			}

		}
	});
}

function send(url) {
	$('textarea[name=\'message\']').val($('#input-message').code());

	$.ajax({
		url: url,
		type: 'post',
		data: $('#content select, #content input, #content textarea'),
		dataType: 'json',
		complete: function() {
			$('#button-send').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '</div>');
				}

				if (json['error']['subject']) {
					$('input[name=\'subject\']').after('<div class="text-danger">' + json['error']['subject'] + '</div>');
				}

				if (json['error']['message']) {
					$('textarea[name=\'message\']').parent().append('<div class="text-danger">' + json['error']['message'] + '</div>');
				}
			}
			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
			}
			
		}
	});
}
//--></script>
<?php echo $footer; ?>
