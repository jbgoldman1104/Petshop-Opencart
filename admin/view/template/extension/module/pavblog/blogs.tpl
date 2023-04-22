<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button class="btn btn-primary" onclick="$('#do-action').val('published');$('#form').submit();"><?php echo $objlang->get("button_publish"); ?></button>
				<a class="btn btn-success" onclick="$('#do-action').val('unpublished');$('#form').submit();"><?php echo $objlang->get('button_unpublish'); ?></a> | 
				<a class="btn btn-danger" onclick="$('#do-action').val('delete');$('#form').submit();"><?php echo $objlang->get("button_delete"); ?></a>
			</div>
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
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php if( is_array($error_warning) ) { echo implode("<br>",$error_warning); } else { echo $error_warning; } ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div id="ajaxloading" class="hide">
			<div class="alert alert-warning" role="alert"><?php echo $objlang->get('text_process_request'); ?></div>
		</div>

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">


				<div class="box-columns">
					<form id="filter" method="post" action="<?php echo $action;?>">
						<table class="table no-border">
							<tr>
								<td class="col-sm-4"><input placeholder="<?php echo $objlang->get('text_filter_title');?>" class="form-control" name="filter[title]" value="<?php echo $filter['title'];?>" size="50"></td>
								<td class="col-sm-6"><?php //echo $objlang->get('text_category');?><?php echo $menus;?></td>
								<td class="col-sm-2">
									<button class="btn btn-primary btn-sm" type="submit" name="submit"><?php echo $objlang->get('text_filter');?></button> <a class="btn btn-warning btn-sm" href="<?php echo $action_reset;?>"><?php echo $objlang->get('text_reset');?></a>
								</td>
							</tr>
						</table>
					</form>
					<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $action;?>">
						<input type="hidden" name="do-action" value="" id="do-action">
						<table class="table">
							<thead>
								<tr>
									<td width="1" style="text-align: center;">
										<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
									</td>
									<td class="left"><?php echo $objlang->get("entry_title");?></td>
									<td class="center" width="200"><?php echo $objlang->get('text_position');?>
										<a class="btn btn-primary btn-xs" onclick="$('#do-action').val('position');$('#form').submit();" class="button"><?php echo $objlang->get("save"); ?></a>
									</td>
									<td class="right"  width="100"><?php echo $objlang->get('text_status');?></td>
									<td class="right"  width="100"><?php echo $objlang->get('text_created');?></td>
									<td class="right"  width="60"><?php echo $objlang->get('text_hits');?></td>
									<td class="right"  width="100"><?php echo $objlang->get('text_edit');?></td>
								</tr>
							</thead>
							
							<tbody>
								<?php foreach( $blogs as $blog ) {  // echo '<pre>'.print_r( $blog, 1 ); die;?>
								<tr>
									<td width="1" style="text-align: center;">
										<input type="checkbox" name="selected[]" value="<?php echo $blog['blog_id'];?>">
									</td>
									<td class="left"><?php echo $blog['title'];?></td>
									<td class="center"  ><input class="form-control" name="position[<?php echo $blog['blog_id'];?>]" value="<?php echo $blog['position'];?>" style="width:40%"></td>
									<td class="right"><?php echo ($blog['status']?$objlang->get('text_enable'):$objlang->get('text_disable'));?></td>
									<td class="right"><?php echo $blog['created'];?></td>
									<td class="right"><?php echo $blog['hits'];?></td>
									<td class="right"><a href="<?php echo sprintf($edit_link, $blog['blog_id']) ?>"><?php echo $objlang->get('text_edit');?></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</form>
					<div class="pagination">
						<?php echo $pagination;?>
					</div>
				</div>

			</div>
		</div>

	</div><!-- end div #page-content -->
</div><!-- end div #content -->

<script type="text/javascript">
$(".action-delete").click( function(){ return confirm('<?php echo $objlang->get('text_confirm_delete');?>') } );
function __submit( val ){
	$("#do-action").val( val );
	$("#form").submit();
}
</script>
<?php echo $footer; ?>