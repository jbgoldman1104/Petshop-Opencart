<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a class="btn btn-danger" onclick="__submit('delete')" class="button"><?php echo $objlang->get("button_delete"); ?></a>
				<a class="btn btn-primary" onclick="__submit('published')" class="button"><?php echo $objlang->get("button_publish"); ?></a>
				<a class="btn btn-success" onclick="__submit('unpublished')" class="button"><?php echo $objlang->get("button_unpublish"); ?></a>
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

					<form id="form" enctype="multipart/form-data" method="post" action="<?php echo $action ;?>">
					<input type="hidden" name="do-action" value="" id="do-action">
						<table class="table">
							<thead>
								<tr>
									<td width="1" style="text-align: center;">
										<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
									</td>
									<td class="left"><?php echo $objlang->get('text_comment');?></td>
									<td class="right"><?php echo $objlang->get('text_blog_title');?></td>
									<td class="right" width="180"><?php echo $objlang->get('text_email');?></td>
									<td class="right"  width="140"><?php echo $objlang->get('text_created');?></td>
									<td class="right"  width="80"><?php echo $objlang->get('text_status');?></td>
								<td class="right"  width="50">Action</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $comments as $comment ) { ?>
								<tr>
									<td width="1" style="text-align: center;">
										<input type="checkbox" name="selected[]" value="<?php echo $comment['comment_id'];?>">
									</td>
									<td class="left"><?php echo $comment['comment'];?></td>
									<td class="left">
										<a href="<?php echo $objurl->link('extension/module/pavblog/blog','id='.$comment['blog_id'].'&token='.$token);?>">
											<?php echo $comment['title'];?>
										</a>
									</td>
									<td class="right" ><?php echo $comment['email'];?></td>
									<td class="right"><?php echo $comment['created'];?></td>
									<td class="right" ><?php echo ($comment['status']?$objlang->get('text_enable'):$objlang->get('text_disable'));?></td>
									<td class="right">
										<a href="<?php echo $objurl->link('extension/module/pavblog/comment','id='.$comment['comment_id'].'&token='.$token);?>"><?php echo $objlang->get('text_edit');?></a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</form>

				</div>

			</div>
		</div>

	</div><!-- end div #page-content -->
</div><!-- end div #content -->
 
  
<script type="text/javascript">
	$(".action-delete").click( function(){ return confirm('<?php echo $objlang->get('txt_confirm_delete');?>') } );
	function __submit( val ){
		$("#do-action").val( val );
		$("#form").submit();
	}
</script>
<?php echo $footer; ?>