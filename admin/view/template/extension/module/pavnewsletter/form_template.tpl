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
						<h3><?php echo $objlang->get("text_templates"); ?></h1>
					</div>
					<div class="toolbar">
						<div class="pull-left pavbtn">
							<a onclick="$('#form').submit();" class="btn btn-success"><?php echo $button_save; ?></a>
							<a href="<?php echo $cancel; ?>" class="btn btn-danger"><?php echo $button_cancel; ?></a>
						</div>		
					</div> 

			 		<div class="content">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
							<input type="hidden" name="template[template_id]" value="<?php echo $template_id;?>" />
							<input type="hidden" name="action" id="action" value=""/>
							<table class="table">
									<tr>
										<td colspan="2"><strong><?php echo $objlang->get("entry_general_template");?></strong></td>
									</tr>
									<tr>
										<td><?php echo $objlang->get("entry_name"); ?></td>
										<td><input class="form-control" type="text" name="template[name]" value="<?php echo isset($template['name'])?$template['name']:""; ?>" size="50" /></td>
									</tr>
									<tr>
										<td><?php echo $objlang->get("entry_sort_order"); ?></td>
										<td><input class="form-control" type="text" name="template[ordering]" value="<?php echo isset($template['ordering'])?$template['ordering']:""; ?>" size="3" /></td>
									</tr>
							</table>
							<p><strong><?php echo $objlang->get("entry_template");?></strong></p> 
							<div class="tab-panel">
								<ul class="nav nav-tabs" id="language">
									<?php foreach ($languages as $language) { ?>
									<li><a href="#tab-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
									<?php } ?>
								</ul>
								<div class="tab-content">
									<?php foreach ($languages as $language) { ?>
									<div class="tab-pane" id="tab-language<?php echo $language['language_id']; ?>">
										<table class="table">
											<tr>
												<td><?php echo $objlang->get("entry_subject"); ?></td>
												<td><input class="form-control" name="template_description[subject][<?php echo $language['language_id']; ?>]" id="module_subject-1-<?php echo $language['language_id']; ?>" value="<?php echo isset($template_description[$language['language_id']]['subject']) ? $template_description[$language['language_id']]['subject'] : ''; ?>"/>
													<?php if ( isset($error['subject']) ) { ?>
													<span class="error"><?php echo $error['subject']; ?></span>
													<?php } ?>
												</td>
											</tr>
								
											<tr>
												<td><?php echo $objlang->get("entry_message"); ?></td>
												<td>
													<?php if ( isset($error['message']) ) { ?>
													<span class="error"><?php echo $error['message']; ?></span>
													<?php } ?>
													<textarea name="template_description[template_message][<?php echo $language['language_id']; ?>]" id="template_message-1-<?php echo $language['language_id']; ?>"><?php echo isset($template_description[$language['language_id']]['template_message']) ? $template_description[$language['language_id']]['template_message'] : ''; ?></textarea><br/>
													<?php echo $objlang->get("text_template_help");?>
												</td>
											</tr>
									</table>
									</div>
									<?php } ?>
								</div>
							</div>


						</form>
					</div>

				</div>
			</div><!-- end div .panel-body -->
		</div><!-- end div .panel -->
	</div><!-- end div #page-content -->

</div><!-- end div #content -->


<script type="text/javascript">

	$('#language li:first-child a').tab('show');

	<?php foreach ($languages as $language) { ?>
	$('#template_message-1-<?php echo $language['language_id']; ?>').summernote({ height: 300 });
	<?php } ?>
</script> 


<?php echo $footer; ?>