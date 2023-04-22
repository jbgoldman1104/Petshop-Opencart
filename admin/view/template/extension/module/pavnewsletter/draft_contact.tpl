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
							<form action="<?php echo $url_delete; ?>" method="post" enctype="multipart/form-data" id="form-draft">

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<td style="width: 1px;" class="text-center">
												<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
											</td>
											<td class="text-left">
												<?php if ($sort == 'subject') { ?>
												<a href="<?php echo $sort_subject; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subject; ?></a>
												<?php } else { ?>
												<a href="<?php echo $sort_subject; ?>"><?php echo $column_subject; ?></a>
												<?php } ?>
											</td>
											<td class="text-left">
												<?php echo $column_to; ?>
											</td>
											<td class="text-right"><?php echo $column_date_added; ?></td>

											<td class="text-right"><?php echo $column_action; ?></td>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($drafts)) { ?>
										<?php foreach ($drafts as $draft) { ?>
										<tr>
											<td class="text-center"><?php if (in_array($draft['draft_id'], $selected)) { ?>
											<input type="checkbox" name="selected[]" value="<?php echo $draft['draft_id']; ?>" checked="checked" />
											<?php } else { ?>
											<input type="checkbox" name="selected[]" value="<?php echo $draft['draft_id']; ?>" />
											<?php } ?></td>
											<td class="text-left"><?php echo $draft['subject']; ?></td>
											<td class="text-right"><?php echo $draft['to']; ?></td>
											<td class="text-right"><?php echo $draft['date_added']; ?></td>

											<td class="text-right"><a href="<?php echo $draft['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php } ?>
										<?php } else { ?>
										<tr>
											<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>

							</form>

							<div class="row">
								<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
								<div class="col-sm-6 text-right"><?php echo $results; ?></div>
							</div>
							
						</div>
						<!-- end content form -->
					</div>
				</div>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<?php echo $footer; ?>
