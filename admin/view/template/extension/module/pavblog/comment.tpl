<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="$('#form').submit();" class="btn btn-primary"><?php echo $objlang->get("button_save"); ?></a>
				<a onclick="__submit('save-edit')" class="btn btn-success"><?php echo $objlang->get('button_save_edit'); ?></a>
				<a href="<?php echo $action_delete;?>" class="btn btn-danger"><?php echo $objlang->get("button_delete"); ?></a>	
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

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">

				<div class="box-columns">
					<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $action;?>">
						<input type="hidden" name="action_mode" id="action_mode" value=""/>
						<input type="hidden" name="pavblog_comment[comment_id]"  value="<?php echo $comment['comment_id'];?>"/>
						<table class="table">
							<tr>
								<td><?php echo $objlang->get('entry_created');?></td>
								<td><?php echo $comment['created'];?></td>
							</tr>
							<tr>
								<td><?php echo $objlang->get('entry_user');?></td>
								<td><?php echo $comment['user'];?></td>
							</tr>
							<tr>
								<td><?php echo $objlang->get('entry_email');?></td>
								<td><?php echo $comment['email'];?></td>
							</tr>
							<tr>
								<td><?php echo $objlang->get('entry_status');?></td>
								<td>
									<select class="form-control" name="pavblog_comment[status]">
										<?php foreach( $yesno as $k=>$v ) { ?>
										<option value="<?php echo $k;?>"<?php if( $k==$comment['status']) { ?>selected="selected"<?php } ?>><?php echo $v;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php echo $objlang->get('entry_comment');?></td>
								<td><textarea class="form-control" rows="6" cols="90" name="pavblog_comment[comment]"><?php echo $comment['comment'];?></textarea></td>
							</tr>
						</table>
					</form>
				</div>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->

	</div><!-- end div #page-content -->
		
</div>
<script type="text/javascript">
	$(".action-delete").click( function(){ 
		return confirm( "<?php echo $objlang->get("text_confirm_delete");?>" );
	} );
	function __submit( val ){
		$("#action_mode").val( val );
		$("#form").submit();
	}
</script>
<?php echo $footer; ?>