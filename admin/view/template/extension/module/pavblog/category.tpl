<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php
	echo $header;
	echo $column_left; 
	$module_row=0; 
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button class="btn btn-primary" title="<?php echo $button_save; ?>" onclick="$('#form').submit();"><?php echo $button_save; ?></button>
				<a class="btn btn-info" title="<?php echo $objlang->get('button_save_edit'); ?>" onclick="$('#save_mode').val('save-edit');$('#form').submit();"><?php echo $objlang->get('button_save_edit'); ?></a>
				<a class="btn btn-success" title="<?php echo $objlang->get('button_save_new'); ?>" onclick="$('#save_mode').val('save-new');$('#form').submit();"><?php echo $objlang->get('button_save_new'); ?></a> | 
				<a class="btn btn-danger" title="<?php echo $button_cancel; ?>" href="<?php echo $cancel; ?>" ><?php echo $button_cancel; ?></a>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<input type="hidden" value="" name="save_mode" id="save_mode"/>
				<div class="megamenu">
					<div class="tree-megamenu col-ms-4">
						<h4><?php echo $objlang->get('text_tree_category_menu');?></h4>
						<input class="btn btn-success btn-sm" type="button" name="serialize" id="serialize" value="Update Tree" />
						<?php echo $tree; ?>
						<input class="btn btn-success btn-sm" type="button" name="serialize" id="serialize_2" value="Update Tree" />
						<p class="note"><i><?php echo $objlang->get("text_explain_drapanddrop");?></i></p>
					</div>
					
					<div class="megamenu-form col-ms-8">
						<div id="megamenu-form">
							<?php require( "category_form.tpl" );?>
						</div>
					</div>
				</div>
				</form>
			</div><!-- end div .panel-body -->

		</div><!-- end div .panel -->

	</div><!-- end div #page-content -->

</div><!-- end div #content -->
<!-- Modal confirm dialog -->
<div id="cmodal" class="modal fade deleteTree-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    	<div class="modal-body">
         	<?php echo $objlang->get('message_delete_category');?>
        </div>
     	<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $objlang->get('text_close'); ?></button>
          <button type="button" class="btn btn-primary" id="btnDeleteTree"><?php echo $objlang->get('text_save'); ?></button>
        </div>
        <input id="menuid" type="hidden" name="menuid" value="0"/>
    </div>
  </div>
</div>
<script type="text/javascript">
// 1. Sortable
$('ol.sortable').nestedSortable({
	forcePlaceholderSize: true,
	handle: 'div',
	helper:	'clone',
	items: 'li',
	opacity: .6,
	placeholder: 'placeholder',
	revert: 250,
	tabSize: 25,
	tolerance: 'pointer',
	toleranceElement: '> div',
	maxLevels: 4,

	isTree: true,
	expandOnHover: 700,
	startCollapsed: true
});
	
$('#serialize, #serialize_2').click(function(){
		var serialized = $('ol.sortable').nestedSortable('serialize');
		 $.ajax({
		async : false,
		type: 'POST',
		dataType:'json',
		url: "<?php echo str_replace("&amp;","&",$updateTree);?>",
		data : serialized, 
		success : function (r) {
			 if ($('#msg-tree').length > 0 ) {
				$("#page-content").remove('#msg-tree');
			} else {
				var html = "<div id='msg-tree' class='alert alert-success'><i class='fa fa-check-circle'></i> <?php echo $objlang->get('text_success_update_tree') ?><button type='button' class='close' data-dismiss='alert'>×</button></div>";
				$("#ajaxloading").before(html);
				//Scroll up
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
});
// 2. QuickEdit
$(".quickedit").click( function(){
	var id = $(this).attr("rel").replace("id_","");
	$.post( "<?php echo str_replace("&amp;","&",$actionGetInfo);?>", {
		"id":id,	
		"rand":Math.random()},
		function(data){
			$("#megamenu-form").html( data );
		}
	);
});

// 3. QuickDel
$('#btnDeleteTree').click(function() {
	var id = $("#menuid").val();
	if(id == 0) {
	} else {
		window.location.href="<?php echo str_replace("&amp;","&",$actionDel);?>&id="+id;
	}
	
});

$(".quickdel").on('click', function(){ 
	$('#cmodal .modal-body').html( "<?php echo $objlang->get('message_delete');?>" );
	$('#cmodal').modal();
	var id = $(this).attr("rel").replace("id_","");
	$("#menuid").val(id);
	return false;
});


// 3. Ajax loading
$(document).ajaxSend(function() {
	$("#ajaxloading").show();
});
$(document).ajaxComplete(function() {
	$("#ajaxloading").hide();
});
</script>
<?php echo $footer; ?>