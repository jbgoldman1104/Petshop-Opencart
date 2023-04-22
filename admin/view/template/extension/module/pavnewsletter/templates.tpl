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
						<h3><?php echo $objlang->get("text_templates"); ?></h1>
					</div>
					<div class="toolbar clearfix"><?php require( dirname(__FILE__).'/action_bar.tpl' ); ?></div>
					<hr>	

					<div class="content">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
							<input type="hidden" name="action" id="action" value=""/>
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<td class="left" style="width:3%"></td>
										<td class="left" style="width:4%">Id</td>
										<td class="left" style="width:40%">
										<?php echo $objlang->get("column_name"); ?></td>
										<td class="left" style="width:40%">
										<?php echo $objlang->get("column_lastchange"); ?></td>
										<td class="right"><?php echo $objlang->get("column_actions"); ?></td>
									</tr>
								</thead>
								<tbody>
									<?php if ($templates) { ?>
									<?php foreach ($templates as $key=>$template) { ?>
									<tr>
										<td><input type="checkbox" name="templates[]" id="template<?php echo $key;?>" value="<?php echo $template["template_id"];?>"/></td>
										<td><?php echo $template["template_id"]; ?></td>
										<td class="left"><?php echo $template['name']; ?></td>
										<td class="left"><?php echo !empty($template['date_modified'])?$template['date_modified']:$template['date_added']; ?></td>
										<td class="right">
										[ <a href="<?php echo 'index.php?route=extension/module/pavnewsletter/template&id='.$template['template_id'].'&token='.$token; ?>"><?php echo $objlang->get("text_edit"); ?></a> ]</td>
									</tr>
									<?php } ?>
									<?php } else { ?>
									<tr>
										<td class="center" colspan="5"><?php echo $objlang->get("text_no_results"); ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</form>
						<div class="pagination"><?php echo $pagination; ?></div>
					</div>

				</div>

			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<?php echo $footer; ?>