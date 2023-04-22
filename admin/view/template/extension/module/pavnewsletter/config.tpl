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
						<h3><?php echo $objlang->get("entry_mail_settings"); ?></h1>
					</div>
					<div class="toolbar"><?php require( dirname(__FILE__).'/action_bar.tpl' ); ?></div>


					<div class="content">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
							<table class="table"> 
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_use_custom_email_config'); ?></td>
									<td class="col-sm-8">
										<?php $checked = (isset($general['custom_email_config']) && $general['custom_email_config'] == 1)?'checked="checked"':''; ?>
										<select class="form-control" style="width:35%" name="pavnewsletter_config[custom_email_config]">
											<?php if($general['custom_email_config']){ ?>
											<option value="1" selected="selected"><?php echo $text_yes; ?></option>
											<option value="0"><?php echo $text_no; ?></option>
											<?php } else { ?>
											<option value="1"><?php echo $text_yes; ?></option>
											<option value="0" selected="selected"><?php echo $text_no; ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
				
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_mail_protocal'); ?></td>
									<td class="col-sm-8">
										<select class="form-control" style="width:35%" name="pavnewsletter_config[protocal]">
											<?php 
												if(isset($mail_protocals)){
													foreach($mail_protocals as $key=>$val){
														if(isset($general["protocal"]) && $key == $general["protocal"]) {
											?>
											<option value="<?php echo $key;?>" selected="selected"><?php echo $val; ?></option>
											<?php } else { ?>
											<option value="<?php echo $key;?>"><?php echo $val; ?></option>
											<?php } } } ?>
										</select><br/>
										<p><?php echo $objlang->get("help_mail_protocal");?></p>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_mail_address'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[email]" value="<?php echo isset($general['email'])?$general['email']:"";?>"/>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_smtp_host'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[smtp_host]" value="<?php echo isset($general['smtp_host'])?$general['smtp_host']:"";?>"/>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_smtp_username'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[smtp_username]" value="<?php echo isset($general['smtp_username'])?$general['smtp_username']:"";?>"/>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_smtp_password'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[smtp_password]" value="<?php echo isset($general['smtp_password'])?$general['smtp_password']:"";?>"/>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_smtp_port'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[smtp_port]" value="<?php echo isset($general['smtp_port'])?$general['smtp_port']:"";?>"/>
									</td>
								</tr>
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_smtp_timeout'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:55%" type="text" name="pavnewsletter_config[smtp_timeout]" value="<?php echo isset($general['smtp_timeout'])?$general['smtp_timeout']:"5";?>"/>
									</td>
								</tr>
					
								<tr>
									<td class="col-sm-4"><?php echo $objlang->get('entry_retries_count'); ?></td>
									<td class="col-sm-8">
										<input class="form-control" style="width:15%" type="text" name="pavnewsletter_config[retries_count]" value="<?php echo isset($general['retries_count'])?$general['retries_count']:3;?>"/>
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
<?php echo $footer; ?>
