<form action="<?php echo $action_cat;?>" method="post" id="formcat">
<div class="form-horizontal">

	<div class="row">
		<div class="col-sm-2">
			<ul class="nav nav-pills nav-stacked">
				<?php if ($excat) { ?>
				<?php foreach ($excat as $extension) { ?>
				<?php $actived = (empty($module_catid))?"class='active'":''; ?>
				<li <?php echo $actived; ?>><a href="<?php echo $extension['edit']; ?>" ><i class="fa fa-plus-circle"></i> <?php echo $extension['name']; ?></a></li>
				<?php $i=0; foreach ($extension['module'] as $module) { $i++;?>
				<?php $active = ($module['module_id'] == $module_catid)?'class="active"':''; ?>
				<li <?php echo $active; ?>><a href="<?php echo $module['edit']; ?>" ><i class="fa fa-minus-circle"></i> <?php echo $module['name']; ?></a></li>
				<?php } //end modules?>
				<?php } //end extensions?>
				<?php } //end if?>
			</ul>
		</div>
		<!-- End ul #module -->

		<div class="col-sm-8">
			<div class="pull-left">
				<a class="btn btn-success" title="" onclick="$('#formcat').submit();" data-toggle="tooltip" data-original-title="Save"><i class="fa fa-save"> Save </i></a>
				<?php if(!empty($module_catid)) { ?>
				<a onclick="confirm('Are you sure?') ? location.href='<?php echo $delete_cat; ?>' : false;" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Delete"><i class="fa fa-trash-o"> Delete</i></a>
				<?php } ?>
			</div>
			<div class="tab-content" id="tab-content-blogcategory">
				<div class="tab-pane active" id="tab-module-pavblogcategory">
					<table class="table noborder">
						<tr>
							<td class="col-sm-2"><?php echo $objlang->get('entry_module_name'); ?></td>
							<td class="col-sm-10">
								<input class="form-control" type="text" placeholder="<?php echo $objlang->get('entry_module_name'); ?>" value="<?php echo $catname; ?>" name="pavblogcategory_module[name]" />
							</td>
						</tr>
						<tr>
							<td class="col-sm-2"><?php echo $objlang->get('entry_parent_id'); ?></td>
							<td class="col-sm-10">
								<select class="form-control" name="pavblogcategory_module[category_id]">
									<?php echo $options;?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2"><?php echo $entry_status; ?></td>
							<td class="col-sm-10">
								<select name="pavblogcategory_module[status]" id="input-status" class="form-control">
									<?php if($status_cat) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2"><?php echo $entry_tree; ?></td>
							<td class="col-sm-10">
								<select name="pavblogcategory_module[type]" class="form-control">
									<?php $selected1 = ($type=="default")?'selected="selected"':'' ?>
									<?php $selected2 = ($type=="vertical")?'selected="selected"':'' ?>
									<?php $selected3 = ($type=="accordion")?'selected="selected"':'' ?>
									<option <?php echo $selected1; ?> value="default">default</option>
									<option <?php echo $selected2; ?> value="vertical">vetical</option>
									<option <?php echo $selected3; ?> value="accordion">accordion</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div><!-- End div .tab-content module-->		
		</div>
	</div>
</div>
</form>
<style type="text/css">
	.noborder tbody > tr > td {border: 1px solid #fff;}
</style>