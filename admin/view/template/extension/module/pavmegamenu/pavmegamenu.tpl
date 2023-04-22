<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
	echo $header; 
	echo $column_left;
	$module_row=0; 
?>
<!-- <script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> -->
<div id="content">
	
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button class="btn btn-primary" title="<?php echo $button_save; ?>" onclick="$('#form').submit();"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
				<a class="btn btn-info" title="<?php echo $objlang->get('button_save_edit'); ?>" onclick="$('#save_mode').val('save-edit');$('#form').submit();"><i class="fa fa-save"></i> <?php echo $objlang->get('button_save_edit'); ?></a>
				<a class="btn btn-success" title="<?php echo $objlang->get('button_save_new'); ?>" onclick="$('#save_mode').val('save-new');$('#form').submit();"><i class="fa fa-book"></i> <?php echo $objlang->get('button_save_new'); ?></a> | 
				<a class="btn btn-warning" title="<?php echo $objlang->get('text_live_edit'); ?>" href="<?php echo $liveedit_url; ?>"><i class="fa fa-magic"></i> <?php echo $objlang->get('text_live_edit'); ?></a>
				<a class="btn btn-danger" title="<?php echo $button_cancel; ?>" href="<?php echo $cancel; ?>" ><i class="fa fa-book"></i> <?php echo $button_cancel; ?></a> | 
				<a class="btn btn-info" title="<?php echo $objlang->get('Guide'); ?>" id="btn-guide" href="http://www.pavothemes.com/guides/pav_megamenu/">
					<i class="fa fa-book"></i>
					<?php echo $objlang->get('Guide');?>
				</a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div id="page-content" class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
	
		<div id="ajaxloading" class="hide">
			<div class="alert alert-warning" role="alert"><?php echo $objlang->get('text_process_request'); ?></div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">
				<ul id="grouptabs" class="nav nav-tabs hidden" role="tablist">
					<li class="active"><a href="#manage-menus" role="tab" data-toggle="tab"><?php echo $objlang->get('tab_manage_megamenus'); ?></a></li>
					<li><a href="#manage-widgets" role="tab" data-toggle="tab"><?php echo $objlang->get('tab_manage_widgets');?></a></li>
				</ul>
				<div class="tab-content">

					<div class="tab-pane hidden" id="manage-widgets">
						<p><i><?php echo $objlang->get('text_explain_widgets'); ?></i></p>
						<a class="btn btn-info btn-modal" href="index.php?route=extension/module/pavmegamenu/addwidget&token=<?php echo $token; ?>" ><?php echo $objlang->get('text_create_widget'); ?></a>
						<br/><br/>
						<table class="table">
							<tr>	
								<td><?php echo $objlang->get('text_widget_name'); ?></td>
								<td><?php echo $objlang->get('text_widget_type'); ?></td>
								<td><?php echo $objlang->get('text_action'); ?></td>
							</tr>

							<?php if( is_array($widgets) ) { ?>
							<?php foreach( $widgets	as $widget ) { ?>
							<tr>
								<td><?php echo $widget['name']; ?></td>
								<td><?php echo $objlang->get( 'text_widget_'.$widget['type'] ); ?></td>
								<td><a class="btn-action-widget btn-modal" rel="edit" href="index.php?route=extension/module/pavmegamenu/addwidget&token=<?php echo $token; ?>&id=<?php echo $widget['id'];?>&wtype=<?php echo $widget['type'];?>"><?php echo $objlang->get('text_edit'); ?></a>
								| 
								<a onclick="return confirm('<?php echo $objlang->get('text_confirm_delete');?>');"	rel="edit" href="index.php?route=extension/module/pavmegamenu/delwidget&token=<?php echo $token; ?>&id=<?php echo $widget['id'];?>&wtype=<?php echo $widget['type'];?>"><?php echo $objlang->get('text_delete'); ?></a>
								</td>
							<?php } ?>
							</tr>
							<?php } ?>
						</table>
					</div><!-- div.panel > manage-widgets -->

					<div class="tab-pane active" id="manage-menus">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
							<div class="buttons">
								<span class="" style="font-weight:bold;"><?php echo $objlang->get('entry_filter_store');?></span>
								<select class="form-control" name="stores" id="pavstores" style="width: 20%;">
									<?php foreach($stores as $store):?>
									<?php if($store['store_id'] == $store_id):?>
										<option value="<?php echo $store['store_id'];?>" selected="selected"><?php echo $store['name'];?></option>
									<?php else:?>
										<option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>
									<?php endif;?>
									<?php endforeach;?>
								</select>
								<input type="hidden" value="<?php echo $store_id;?>" name="megamenu[store_id]"/></br></br>
								<a class="btn btn-primary" title="<?php echo $objlang->get('button_import_categories'); ?>" onclick="$('#save_mode').val('import-categories');$('#form').submit();"><?php echo $objlang->get('button_import_categories'); ?></a>
								<a class="btn btn-danger" title="<?php echo $objlang->get('button_delete_categories'); ?>" data-toggle="modal" data-target=".deleteTree-modal-sm"><?php echo $objlang->get('button_delete_categories'); ?></a>
							</div><br/><br/>

							<div class="megamenu">
								<div class="tree-megamenu">
									<h4><?php echo $objlang->get('text_treemenu');?></h4>
									<a class="btn btn-success btn-updatetree" name="serialize" id="serialize"><?php echo $objlang->get('button_update_order'); ?></a>	
									<?php echo $tree; ?>
									<a class="btn btn-success btn-updatetree" name="serialize" id="serialize"><?php echo $objlang->get('button_update_order'); ?></a>
									<p class="note"><i><?php echo $objlang->get("text_explain_drapanddrop");?></i></p>
								</div>

							</div><!-- end div.megamenu -->

							<div class="megamenu-form">
								<div id="megamenu-form">
									<?php require( "pavmegamenu_form.tpl" );?>
								</div>
							</div>
							<!-- end div.megamenu-form -->

							<input type="hidden" value="" name="save_mode" id="save_mode"/>
						</form>
					</div><!-- div.panel > manage-menus -->


				</div>
			</div>

		</div><!-- end div.panel panel-default -->
		<div id="info" style="font-size:10px;color:#666"><p>Pav Mega Menu is free to use. it's released under GPL/V2. Powered By <a href="http://www.pavothemes.com">PavoThemes.Com</a></div>

	</div><!-- container-fluid -->
</div>

 <!-- Modal Form-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo $objlang->get('text_preview_on_live_site');?></h4>
        </div>
        <div class="modal-body">
         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $objlang->get('text_close'); ?></button>
        </div>
      </div> 
    </div> 
  </div>

<!-- Modal confirm dialog -->
<div id="cmodal" class="modal fade deleteTree-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    	<div class="modal-body">
         	<?php echo $objlang->get('message_delete_category');?>
        </div>
     	<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $objlang->get('text_close'); ?></button>
          <button type="button" class="btn btn-primary" id="btnDeleteTree"><?php echo $button_save; ?></button>
        </div>
        <input id="menuid" type="hidden" name="menuid" value="0"/>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
	
	// Drag and Drop menu Item
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
	
	$('#serialize, .btn-updatetree').click(function(){
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
					var html = "<div id='msg-tree' class='alert alert-success'><i class='fa fa-check-circle'></i><?php echo $objlang->get('text_success_update_tree') ?><button type='button' class='close' data-dismiss='alert'>×</button></div>";
					$("#ajaxloading").before(html);
					//Scroll up
					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			}
		});
	});

	// Mutiple Store
	$('#pavstores').bind('change', function () {
		url = 'index.php?route=extension/module/pavmegamenu&token=<?php echo $token; ?>';
		var id = $(this).val();
		if (id) {
			url += '&store_id=' + encodeURIComponent(id);
		}
		window.location = url;
	});

	// Modal delete tree categories
	$('#btnDeleteTree').click(function() {
		var id = $("#menuid").val();
		if(id == 0) {
			$("#save_mode").val('delete-categories');
			$('#form').submit();	
		} else {
			window.location.href="<?php echo str_replace("&amp;","&",$actionDel);?>&id="+id;
		}
		
	});

	$(".quickdel").click(function(){
		$('#cmodal .modal-body').html( "<?php echo $objlang->get('message_delete');?>" );
		$('#cmodal').modal();
		var id = $(this).attr("rel").replace("id_","");
		$("#menuid").val(id);
		return false;
	});

	// Ajax load
	$(document).ajaxSend(function() {
		$("#ajaxloading").show();
	});
	$(document).ajaxComplete(function() {
		$("#ajaxloading").hide();
	});

	// Cookies tab
	$('#grouptabs a').click( function(){
		$.cookie("megaactived_tab", $(this).attr("href") );
	});

	if($.cookie("megaactived_tab") !="undefined"){
		$('#grouptabs a').each( function(){
			if( $(this).attr("href") ==  $.cookie("megaactived_tab")){
				$(this).click();
				return ;
			}
		});
	}

	// Modal Link guide
	$("#btn-guide").click( function(){
		$('#myModal .modal-dialog').css('width',980);
		var a = $( '<span class="glyphicon glyphicon-refresh"></span><iframe frameborder="0" scrolling="no" src="'+$(this).attr('href')+'" style="width:100%;height:900px; display:none"/>'  );
		$('#myModal .modal-body').html( a );
			
		$('#myModal').modal();
		$('#myModal').attr('rel', $(this).attr('rel') );
		$(a).load( function(){  
			$('#myModal .modal-body .glyphicon-refresh').hide();
	 		$('#myModal .modal-body iframe').show();
		} );
		return false;
	});

	// Modal Create widget
	$(".btn-modal").click( function(){ 
		$('#myModal .modal-dialog').css('width',980);
		var a = $( '<span class="glyphicon glyphicon-refresh"></span><iframe frameborder="0" scrolling="no" src="'+$(this).attr('href')+'" style="width:100%;height:900px; display:none"/>'  );
		$('#myModal .modal-body').html( a );
			
		$('#myModal').modal( );
		$('#myModal').attr('rel', $(this).attr('rel') );
		$(a).load( function(){  
			$('#myModal .modal-body .glyphicon-refresh').hide();
	 		$('#myModal .modal-body iframe').show();
		});

		return false;
	});
	$('#myModal').on('hidden.bs.modal', function () { 
	 	 if( $(this).attr('rel') == 'refresh-page' ){
	 	 	window.parent.location.reload();
	 	 }
	});
//-->
</script>

<?php echo $footer; ?>
