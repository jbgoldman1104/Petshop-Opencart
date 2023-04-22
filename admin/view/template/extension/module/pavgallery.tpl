<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a class="btn btn-primary" onclick="$('#form').submit();"><?php echo $button_save; ?></a>
        <a class="btn btn-success" onclick="$('#action-mode').val('save_stay');$('#form').submit();"><?php echo $button_save_edit; ?></a>
        <a class="btn btn-danger" href="<?php echo $cancel; ?>"><?php echo $button_cancel; ?></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div><!-- End div#page-header -->
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $subheading; ?></h3>
      </div>
      <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
        <input type="hidden" name="pavgallery_module[action]" id="action" value=""/>
             <!-- Nav tabs -->
                <div class="row">
                  <ul class="nav nav-tabs" role="tablist">
                    <li <?php if( $selectedid ==0 ) { ?>class="active" <?php } ?>> <a href="<?php echo $link; ?>"> <span class="fa fa-plus"></span> <?php echo $olang->get('button_module_add');?></a></li>
                    <?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
                    <li role="presentation" <?php if( $module['module_id']==$selectedid ) {?>class="active"<?php } ?>>
                      <a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>" aria-controls="bannermodule-<?php echo $key; ?>"  >
                        <span class="fa fa-pencil"></span> <?php echo $module['name']?>
                       </a>
                      </li>
                    <?php $i++ ;} ?>

                  </ul>
                </div>
                <!-- Tab panes -->
            <div class="col-sm-12">
            <div>
        <?php $module_row = 1; ?>
        <?php foreach ($modules as $module) { ?>
         <?php if( $selectedid ){ ?>
               <div class="pull-right">
                      <a href="<?php echo $action;?>&delete=1" class="remove btn btn-danger" ><span><i class="fa fa-remove"></i> Delete This</span></a>
                    </div>
                    <?php } ?>
              <div  id="tab-module<?php echo $module_row; ?>">
                <table class="table table-bordered">
                  <tr>
                  <td class="col-sm-2"><?php echo $objlang->get('entry_name'); ?></td>
                  <td class="col-sm-10"><input class="form-control" style="width:55%;" name="pavgallery_module[<?php echo $module_row; ?>][name]" value="<?php echo isset($module['name'])?$module['name']:''; ?>"/></td>
                </tr>
                <tr>
                    <td class="col-sm-2"><?php echo $objlang->get('entry_status'); ?></td>
                    <td class="col-sm-10"><select name="pavgallery_module[<?php echo $module_row; ?>][status]" class="form-control" style="width:15%;">
                      <?php if ( isset($module['status']) && $module['status'] ) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select></td>
                  </tr>

                  <tr>
                    <td class="col-md-2"><?php echo $objlang->get('entry_prefix_class'); ?></td>
                    <td class="col-md-10"><input type="text" name="pavgallery_module[<?php echo $module_row; ?>][prefix_class]" value="<?php echo isset($module['prefix_class'])?$module['prefix_class']:''; ?>" class="form-control" style="width:55%;"/></td>
                  </tr>

                  <tr>
                    <td class="col-md-2"><?php echo $objlang->get('entry_banner_group'); ?></td>
                    <td class="col-md-10"><select name="pavgallery_module[<?php echo $module_row; ?>][banner_id]" class="form-control" style="width:15%;">
                        <?php foreach ($banners as $banner) { ?>
                        <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
                        <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select></td>
                  </tr>

                  <tr>
                    <td class="col-sm-2"><?php echo $entry_dimension; ?></td>
                    <td class="col-sm-10"><input type="text" name="pavgallery_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" class="form-control" style="width:15%;"/> x
                      <input type="text" name="pavgallery_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" class="form-control" style="width:15%;"/>
                    </td>
                  </tr>
                </table>
            </div>
        <?php $module_row++; ?>
        <?php } ?>
      </form>
    </div>
  </div>
</div>


 <script type="text/javascript"><!--
$('#module li:first-child a').tab('show');
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
$('#language<?php echo $module_row; ?> li:first-child a').tab('show');
<?php $module_row++; ?>
<?php } ?>
//--></script></div>
<?php echo $footer; ?>