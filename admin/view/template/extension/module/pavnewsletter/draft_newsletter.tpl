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
						<h3><?php echo $objlang->get("text_draft_newsletter"); ?></h1>
					</div>
					<div class="toolbar"><?php require( dirname(__FILE__).'/action_bar.tpl' ); ?></div>
<!-- ###################################### -->
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<input type="hidden" id="action" name="action" value=""/>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
							<td class="left">
								<?php if ($sort == 'date') { ?>
								<a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
								<?php } ?>
							</td>
							<td class="left">
								<?php if ($sort == 'subject') { ?>
								<a href="<?php echo $sort_subject; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subject; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_subject; ?>"><?php echo $column_subject; ?></a>
								<?php } ?>
							</td>
							<td class="left">
								<?php if ($sort == 'to') { ?>
								<a href="<?php echo $sort_to; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_to; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_to; ?>"><?php echo $column_to; ?></a>
								<?php } ?>
							</td>
							<td class="right">
								<?php if ($sort == 'store_id') { ?>
								<a href="<?php echo $sort_store; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_store; ?>"><?php echo $column_store; ?></a>
								<?php } ?>
							</td>
							<td class="right"><?php echo $column_actions; ?></td>
						</tr>
					</thead>
					<tbody>
						<tr class="filter">
							<td></td>
							<td><input class="form-control" type="text" name="filter_date" value="<?php echo $filter_date; ?>" class="date" /></td>
							<td><input class="form-control" type="text" name="filter_subject" value="<?php echo $filter_subject; ?>" /></td>
							<td>
								<select class="form-control" name="filter_to">
									<?php if ($filter_to == '') { ?>
									<option value="" selected="selected"></option>
									<?php } else { ?>
									<option value=""></option>
									<?php } ?>
									<?php if ($filter_to == 'newsletter') { ?>
									<option value="newsletter" selected="selected"><?php echo $text_newsletter; ?></option>
									<?php } else { ?>
									<option value="newsletter"><?php echo $text_newsletter; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'customer_all') { ?>
									<option value="customer_all" selected="selected"><?php echo $text_customer_all; ?></option>
									<?php } else { ?>
									<option value="customer_all"><?php echo $text_customer_all; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'customer_group') { ?>
									<option value="customer_group" selected="selected"><?php echo $text_customer_group; ?></option>
									<?php } else { ?>
									<option value="customer_group"><?php echo $text_customer_group; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'customer') { ?>
									<option value="customer" selected="selected"><?php echo $text_customer; ?></option>
									<?php } else { ?>
									<option value="customer"><?php echo $text_customer; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'affiliate_all') { ?>
									<option value="affiliate_all" selected="selected"><?php echo $text_affiliate_all; ?></option>
									<?php } else { ?>
									<option value="affiliate_all"><?php echo $text_affiliate_all; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'affiliate') { ?>
									<option value="affiliate" selected="selected"><?php echo $text_affiliate; ?></option>
									<?php } else { ?>
									<option value="affiliate"><?php echo $text_affiliate; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'product') { ?>
									<option value="product" selected="selected"><?php echo $text_product; ?></option>
									<?php } else { ?>
									<option value="product"><?php echo $text_product; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'subscriber') { ?>
										<option value="subscriber" selected="selected"><?php echo $text_subscriber_all; ?></option>
									<?php } else { ?>
										<option value="subscriber"><?php echo $text_subscriber_all; ?></option>
									<?php } ?>
									<?php if ($filter_to == 'all') { ?>
										<option value="all" selected="selected"><?php echo $text_all; ?></option>
									<?php } else { ?>
										<option value="all"><?php echo $text_all; ?></option>
									<?php } ?>
								  </select>
							</td>
							<td class="right">
								<select class="form-control" name="filter_store">
									<option value=""></option>
									<?php if ($filter_store == '0') { ?>
									<option value="0" selected="selected"><?php echo $text_default; ?></option>
									<?php } else { ?>
									<option value="0"><?php echo $text_default; ?></option>
									<?php } ?>
									<?php foreach ($stores as $store) { ?>
									<?php if ($filter_store == $store['store_id']) { ?>
									<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</td>
							<td align="right"><a onclick="filter();" class="btn btn-warning"><span><?php echo $button_filter; ?></span></a></td>
						</tr>
						<?php if ($draft) { ?>
						<?php foreach ($draft as $entry) { ?>
						<tr>
							<td style="text-align: center;">
								<?php if ($entry['selected']) { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $entry['email_id']; ?>" checked="checked" />
								<?php } else { ?>
								<input type="checkbox" name="selected[]" value="<?php echo $entry['email_id']; ?>" />
								<?php } ?>
							</td>
							<td class="left"><?php echo $entry['date_added']; ?></td>
							<td class="left"><?php echo $entry['subject']; ?></td>
							<td class="left">
								<?php if ($entry['to'] == 'newsletter') { 
									echo $text_newsletter; 
								} elseif ($entry['to'] == 'customer_all') { 
									echo $text_customer_all;
								} elseif ($entry['to'] == 'customer_group') {
									echo $text_customer_group;
								} elseif ($entry['to'] == 'customer') {
									echo $text_customer;
								} elseif ($entry['to'] == 'affiliate_all') {
									echo $text_affiliate_all;
								} elseif ($entry['to'] == 'affiliate') {
									echo $text_affiliate;
								} elseif ($entry['to'] == 'product') {
									echo $text_product;
								} elseif ($entry['to'] == 'subscriber') {
									echo $text_subscriber_all;
								} elseif ($entry['to'] == 'all') {
									echo $text_all;
								} ?>
							</td>
							<td class="right">
								<?php if ($entry['store_id'] == '0') { ?>
									<?php echo $text_default; ?>
								<?php } else { ?>
									<?php foreach ($stores as $store) { ?>
										<?php if ($entry['store_id'] == $store['store_id']) { ?>
											<?php echo $store['name']; ?>
											<?php break; ?>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</td>
							<td align="right"><a href="<?php echo $detail . $entry['email_id']; ?>">[<?php echo $text_view; ?>]</a></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td class="center" colspan="6"><?php echo $text_no_results; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</form>
			<div class="pagination"><?php echo $pagination; ?></div>
		</div>
<!-- ###################################### -->
				</div>
			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=extension/module/pavnewsletter/draft&token=<?php echo $token; ?>';
	
	var filter_date = $('input[name=\'filter_date\']').attr('value');
	
	if (filter_date) {
		url += '&filter_date=' + encodeURIComponent(filter_date);
	}
	
	var filter_subject = $('input[name=\'filter_subject\']').attr('value');
	
	if (filter_subject) {
		url += '&filter_subject=' + encodeURIComponent(filter_subject);
	}

	var filter_to = $('select[name=\'filter_to\']').attr('value');
	
	if (filter_to) {
		url += '&filter_to=' + encodeURIComponent(filter_to);
	}

	var filter_store = $('select[name=\'filter_store\']').attr('value');
	
	if (filter_store) {
		url += '&filter_store=' + encodeURIComponent(filter_store);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script>
<?php echo $footer; ?>