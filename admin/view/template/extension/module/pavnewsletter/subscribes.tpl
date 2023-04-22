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

				<div class="col-sm-3">
					
					<div class="logo"><h3><?php echo $heading_title; ?></h3></div>
					<div class="slidebar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
					<div class="clear clr"></div>
					
				</div>

				<div class="col-sm-9">
					<div class="heading">
						<h3><?php echo $objlang->get("text_subscribes"); ?></h1>
					</div>
					<div class="toolbar"><?php require( dirname(__FILE__).'/action_bar.tpl' ); ?></div>
<!-- ###################################### -->
	  <div class="content">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		  <input type="hidden" name="action" id="action" value=""/>
		  <table class="table table-bordered table-hover">
			<thead>
			  <tr>
				<td class="left"><input class="form-control" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"></td>
				<td class="left"><?php if ($sort == 'name') { ?>
				  <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
				  <?php } else { ?>
				  <a href="<?php echo $sort_name; ?>"><?php echo $objlang->get("column_name"); ?></a>
				  <?php } ?></td>
				<td class="left"><?php if ($sort == 'email') { ?>
				  <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
				  <?php } else { ?>
				  <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
				  <?php } ?></td>
				<td class="right"><?php if ($sort == 'customer_group_id') { ?>
				  <a href="<?php echo $sort_customer_group_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
				  <?php } else { ?>
				  <a href="<?php echo $sort_customer_group_id; ?>"><?php echo $column_customer_group; ?></a>
				  <?php } ?></td>
				<td class="right"><?php if ($sort == 's.action') { ?>
				  <a href="<?php echo $sort_subscribe; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subscribe; ?></a>
				  <?php } else { ?>
				  <a href="<?php echo $sort_subscribe; ?>"><?php echo $column_subscribe; ?></a>
				  <?php } ?></td>
				<td class="right"><?php if ($sort == 's.store_id') { ?>
				  <a href="<?php echo $sort_store_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_store; ?></a>
				  <?php } else { ?>
				  <a href="<?php echo $sort_store_id; ?>"><?php echo $column_store; ?></a>
				  <?php } ?></td>
				<td class="right"><?php echo $column_action; ?></td>
			  </tr>
			</thead>
			<tbody>
			  <tr class="filter">
				<td>&nbsp;</td>
				<td><input class="form-control" type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
				<td><input class="form-control" type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
				<td align="right"><select class="form-control" name="filter_customer_group_id">
					<option =""></option>
					<?php if(isset($customer_groups)):?>
					<?php foreach($customer_groups as $key=>$val):?>
					  <option value="<?php echo $key;?>" <?php if($key==$filter_customer_group_id) echo 'selected="selected"';?>><?php echo $val;?></option>
				  <?php endforeach; ?>
				  <?php endif;?>
				</select></td>
				<td align="right"><select class="form-control" name="filter_action">
					<option value=""></option>
					<?php if ($filter_action == "1") { ?>
					<option value="1" selected="selected"><?php echo $objlang->get("text_yes"); ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $objlang->get("text_yes"); ?></option>
					<?php } ?>
					<?php if ($filter_action == "0") { ?>
					<option value="0" selected="selected"><?php echo $objlang->get("text_no"); ?></option>
					<?php } else { ?>
					<option value="0"><?php echo $objlang->get("text_no"); ?></option>
					<?php } ?>
				  </select></td>
				<td align="right"><select class="form-control" name="filter_store_id">
					<option value=""></option>
					<?php
					if(isset($stores)):
					  foreach($stores as $key=>$val):
						  ?>
						  <option value="<?php echo $key;?>" <?php if($filter_store_id!="" && $key==$filter_store_id) echo 'selected="selected"';?>><?php echo $val; ?></option>
						<?php
					  endforeach;
					  endif;
					?>
				  </select></td>
				<td align="right"><a onclick="filter();" class="btn btn-warning"><?php echo $button_filter; ?></a></td>
			  </tr>
			  <?php if ($subscribes) { ?>
			  <?php foreach ($subscribes as $subsribe) { ?>
			  <tr>
				<td><input type="checkbox" value="<?php echo $subsribe['subscribe_id'] ?>" name="selected[]"></td>
				<td class="left"><?php echo $subsribe['name']; ?></td>
				<td class="left"><?php echo $subsribe['email']; ?></td>
				<td class="left"><?php echo $subsribe['customer_group']; ?></td>
				<td class="right"><?php echo $subsribe['subscribe'];?></td>
				<td class="right"><?php echo $subsribe['store']; ?></td>
				<td class="right"><?php foreach ($subsribe['action'] as $action) { ?>
				  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				  <?php } ?></td>
			  </tr>
			  <?php } ?>
			  <?php } else { ?>
			  <tr>
				<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
			  </tr>
			  <?php } ?>
			</tbody>
		  </table>
		</form>
		<div class="pagination"><?php echo $pagination; ?></div>
	  </div>
	  </div>
<!-- ###################################### -->
				</div>
			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<?php echo $footer; ?>