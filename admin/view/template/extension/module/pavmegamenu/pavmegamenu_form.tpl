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
if( $menu ): 
$module_row= 'ss';
?>
<?php if( $menu['megamenu_id'] > 0 ) { ?>
<h3><?php echo sprintf($text_edit_menu, $menu['title'], $menu['megamenu_id']);?></h3>
<?php } else { ?>
<h3><?php echo $text_create_new;?></h3>
<?php } ?>
<div>
<?php 
// echo '<pre>'.print_r( $menu_description,1 ); die;
?>
	<h4><?php echo $objlang->get('entry_menu_information');?></h4>

	<ul class="nav nav-tabs" id="language-<?php echo $module_row; ?>">
		<?php foreach ($languages as $language) { ?>
		<li>
			<a href="#tab-language-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
		</li>
		<?php } ?>
	</ul>
	
	<div class="tab-content">
		<?php foreach ($languages as $language) { ?>
		<div class="tab-pane" id="tab-language-<?php echo $language['language_id']; ?>">
			<table class="table no-border">
				<tr>
					<td><?php echo $objlang->get('entry_menu_title');?></td>
					<td>
						<input class="form-control" name="megamenu_description[<?php echo $language['language_id'];?>][title]" value="<?php echo (isset($menu_description[$language['language_id']]['title'])?$menu_description[$language['language_id']]['title']:"" );?>"/>
					</td>
				</tr>
				<tr>
					<td><?php echo $objlang->get('entry_description');?></td>
					<td>
						<textarea class="form-control" name="megamenu_description[<?php echo $language['language_id'];?>][description]" value=""><?php echo (isset($menu_description[$language['language_id']]['description'])?$menu_description[$language['language_id']]['description']:"");?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<?php } ?>
	</div>

	<h4><?php echo $objlang->get('entry_menu_type');?></h4>
	<input type="hidden" name="megamenu[item]" value="<?php echo $menu['item'];?>" />
	<table class="table">
		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_publish');?></td>
				
			<td class="col-sm-9">
				<select class="form-control"type="list" name="megamenu[published]" >
					<?php foreach( $yesno as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['published']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_type');?></td>
				
			<td class="col-sm-9">
				<select class="form-control" name="megamenu[type]" id="megamenutype">
					<?php foreach(  $megamenutypes as $mt => $val ){ ?>
					<option value="<?php echo $mt; ?>" <?php if($mt == $menu['type']) {?> selected="selected" <?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr id="megamenutype-url" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_url');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu[url]" value="<?php echo $menu['url'];?>" size="50"/>
			</td>
		</tr>
		<tr id="megamenutype-category" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_category');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="path" value="<?php echo $menu['megamenu-category'];?>" size="100" />
                <i><?php echo $objlang->get('text_explain_input_auto');?></i>
			</td>
		</tr>
		<tr id="megamenutype-product" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_product');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu-product" value="<?php echo $menu['megamenu-product'];?>" size="50"/>
				<i><?php echo $objlang->get('text_explain_input_auto');?></i>
			</td>
		</tr>
		<tr id="megamenutype-manufacturer" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_manufacturer');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu-manufacturer" value="<?php echo $menu['megamenu-manufacturer'];?>" size="50"/>
				<i><?php echo $objlang->get('text_explain_input_auto');?></i>
			</td>
		</tr>
		<tr id="megamenutype-information" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_information');?></td>
			<td class="col-sm-9">
				
				<select class="form-control" type="text" name="megamenu-information" id="megamenu-information">
					<?php foreach( $informations as $info ){ ?>
					<option value="<?php echo $info['information_id'];?>" <?php if( $menu['megamenu-information'] == $info['information_id']){ ?> selected="selected" <?php } ?>><?php echo $info['title'];?></option>
					<?php } ?>
				</select>
				
			</td>
		</tr>
		<tr id="megamenutype-html" class="megamenutype">
			<td class="col-sm-3"><?php echo $objlang->get('entry_html');?></td>
			<td class="col-sm-9">
				<textarea type="text" name="megamenu[content_text]"  size="50"><?php echo $menu['content_text'];?></textarea>
				<i><?php echo $objlang->get('text_explain_input_html');?></i>
			</td>
		</tr>
	</table>	
	<h4><?php echo $objlang->get('entry_menu_param');?></h4>	  
	 <table class="table">
		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_parent_id');?></td>
				
			<td class="col-sm-9">
				<?php echo $menus;?>
 			</td>
		</tr>
	 	<tr>
			<td class="col-sm-2 control-label"><?php echo $entry_image; ?></td>
			<td class="col-sm-10">
				<a href="" id="thumb-img" data-toggle="image" class="img-thumbnail">
					<img src="<?php echo empty($thumb)?$placeholder:$thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
				</a>
				<input type="hidden" name="megamenu[image]" value="<?php echo $menu['image']; ?>" id="input-icon-menu" />
			</td>
        </tr>
		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_menuclass');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu[menu_class]" value="<?php echo $menu['menu_class']?>"/>
			</td>
		</tr>

		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_badges');?></td>
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu[badges]" value="<?php echo isset($menu['badges'])?$menu['badges']:''; ?>"/>
			</td>
		</tr>

		<tr>
			<td class="col-sm-3"><?php echo $objlang->get('entry_showtitle');?></td>
				
			<td class="col-sm-9">
				<select class="form-control" type="list" name="megamenu[show_title]" >
					<?php foreach( $yesno as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['show_title']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		<tr class="hiade">
			<td class="col-sm-3"><?php echo $objlang->get('entry_isgroup');?></td>
				
			<td class="col-sm-9">
				<select class="form-control" type="list" name="megamenu[is_group]" value="">
					<?php foreach( $yesno as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['is_group']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
				<i><?php echo $objlang->get('text_explain_group');?></i>
 			</td>
		</tr>
		<tr style="display:none">
			<td class="col-sm-3"><?php echo $objlang->get('entry_iscontent');?></td>
			<td class="col-sm-9">
				<select class="form-control" type="list" name="megamenu[is_content]">
					<?php foreach( $yesno as $key => $val ){ ?>
					<option value="<?php echo $key;?>" <?php if( $key==$menu['is_content']){ ?> selected="selected"<?php } ?>><?php echo $val; ?></option>
					<?php } ?>
				</select>
 			</td>
		</tr>
		
		<tr class="hiade">
			<td class="col-sm-3">
				<?php echo $objlang->get("entry_columns");?>
			</td>
				
			<td class="col-sm-9">
				<input type="text" class="form-control" name="megamenu[colums]" value="<?php echo $menu['colums']?>"/>
				<i><?php echo $objlang->get('text_explain_columns');?></i>
 			</td>
		</tr>
		
		
		 
		<tr class="hide">
			<td class="col-sm-3">
			<?php echo $objlang->get("entry_detail_columns");?>	
			</td>
				
			<td class="col-sm-9">
				<textarea type="text" name="megamenu[submenu_colum_width]" rows="5"><?php echo $menu['submenu_colum_width']?></textarea>
				<i><?php echo $objlang->get('text_explain_submenu_cols');?></i>
 			</td>
		</tr>
		<tr>
			<td class="col-sm-3"><?php echo $objlang->get("entry_sub_menutype");?></td>
			<td class="col-sm-9">
				<?php //echo '<pre>'.print_r( $menu,1 ); die ;?>
				<select class="form-control" name="megamenu[type_submenu]" id="megamenu-type_submenu">
					<?php foreach( $submenutypes as $stype => $text ) { ?>
					<option value="<?php echo $stype;?>" <?php if($stype==$menu['type_submenu']) { ?> selected="selected"<?php } ?>><?php echo $text;?></option>
					<?php } ?>
				</select>
				<i><?php echo $objlang->get('text_explain_submenu_type');?></i>
			</td>
		</tr>
		<tr class="type_submenu" id="type_submenu-html" style="display:none;">
			<td class="col-sm-3"><?php echo $objlang->get('entry_submenu_content');?></td>
			<td class="col-sm-9">
				<textarea name="megamenu[submenu_content]" id="submenu_content"><?php echo $menu['submenu_content'];?></textarea>
			
			</td>
		<tr>

		<tr class="type_submenu" id="type_submenu-widget" style="display:none;">
			<td class="col-sm-3"><?php echo $objlang->get('entry_widget_id');?></td>
			<td class="col-sm-9">
				 <?php if( is_array($widgets) )  { ?>
				 <select class="form-control" name="megamenu[widget_id]">
				 	<?php foreach( $widgets as $w => $t ) { ?>
				 	<option <?php if($t['id'] == $menu['widget_id']) { ?> selected="selected" <?php } ?>value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
				 	<?php } ?>
				 </select>
				 <?php } ?>
			</td>
		<tr>

	</table>
	<input type="hidden" name="megamenu[megamenu_id]" value="<?php echo $menu['megamenu_id']?>"/>
</div>
<?php endif; ?>

<script type="text/javascript"> 
$("#type_submenu-"+$("#megamenu-type_submenu").val()).show();
$("#megamenu-type_submenu").change( function(){
	$(".type_submenu").hide();
	$("#type_submenu-"+$(this).val()).show();
} );


$('#submenu_content').summernote({
	height: 300
});

$('megamenu[content_text]').summernote({
	height: 300
});


$('#language-<?php echo $module_row; ?> li:first-child a').tab('show');


$(".megamenutype").hide();
$("#megamenutype-"+ $("#megamenutype").val()).show();
$("#megamenutype").change( function(){
	$(".megamenutype").hide();
	$("#megamenutype-"+$(this).val()).show();
} );

   

$('input[name=\'megamenu-manufacturer\']').autocomplete({
	delay: 500,
	source: function(request, response) {		
		$.ajax({
			url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'manufacturer_id':  0,
					'name':  '<?php echo $text_none; ?>'
				});
				
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.manufacturer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'megamenu-manufacturer\']').val(ui.item.label);
		$('input[name=\'megamenu[item]\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$("#megamenu-information").change( function(){ 
	$('input[name=\'megamenu[item]\']').val($(this).val());
} );

$('input[name=\'megamenu-product\']').autocomplete({
	delay: 500,
	source: function(request, response) {		
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'product_id':  0,
					'name':  '<?php echo $text_none; ?>'
				});
				
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'megamenu-product\']').val(ui.item.label);
		$('input[name=\'megamenu[item]\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'path\']').autocomplete({
	delay: 500,
	source: function(request, response) {		
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'category_id':  0,
					'name':  '<?php echo $text_none; ?>'
				});
				
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'path\']').val(ui.item.label);
		$('input[name=\'megamenu[item]\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
</script>