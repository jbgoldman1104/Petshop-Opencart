<?php
/******************************************************
 * @package Pav pavblog_category module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php
	if( $menu ) {
		$module_row= 'ss'; 
?>
<?php if( $menu['category_id'] > 0 ) { ?>
<h3><?php echo sprintf($text_edit_menu, $menu['title'], $menu['category_id']);?></h3>
<?php } else { ?>
<h3><?php echo $text_create_new;?></h3>
<?php } ?>
<h4><?php echo $objlang->get('text_category_information');?></h4>

<ul class="nav nav-tabs" id="language-<?php echo $module_row; ?>">
	<?php foreach ($languages as $language) { ?>
	<li>
		<a href="#tab-language-<?php echo $language['language_id']; ?>" data-toggle="tab">
			<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>
		</a>
	</li>
	<?php } ?>
</ul>

<div class="tab-content">
	<?php foreach ($languages as $language) { ?>
	<div class="tab-pane" id="tab-language-<?php echo $language['language_id']; ?>">
		<table class="table no-border">
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('Title');?></td>
				<td class="col-sm-10">
					<input class="form-control" name="pavblog_category_description[<?php echo $language['language_id'];?>][title]" value="<?php echo $menu_description[$language['language_id']]['title'];?>"/>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('entry_description');?></td>
				<td class="col-sm-10">
					<textarea class="form-control" id="input-description-language<?php echo $language['language_id']; ?>" name="pavblog_category_description[<?php echo $language['language_id'];?>][description]" value=""><?php echo $menu_description[$language['language_id']]['description'];?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
</div>

<table class="table">
	<tr>
		<td class="col-sm-2"><?php echo $objlang->get('entry_parent_id');?></td>
		<td class="col-sm-10"><?php echo $menus;?></td>
	</tr>
	<tr>
		<td class="col-sm-2"><?php echo $entry_image;  ?></td>

		<td class="col-sm-10">
			<a href="" id="thumb-img" data-toggle="image" class="img-thumbnail">
				<img src="<?php echo empty($thumb)?$no_image:$thumb; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" />
			</a>
			 <input type="hidden" name="pavblog_category[image]" value="<?php echo $menu['image']; ?>" id="image" />
		</td>
    </tr>
	<tr>
		<td class="col-sm-2"><?php echo $objlang->get('entry_menuclass');?></td>
		<td class="col-sm-10">
			<input class="form-control" type="text" name="pavblog_category[menu_class]" value="<?php echo $menu['menu_class']?>"/>
		</td>
	</tr>	
</table>

<div id="tab-meta">
	<h3><?php echo $objlang->get('text_seo_data');?></h3>
	<div class="pav-content" style="width:100%">
		<table class="table">
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('entry_keyword'); ?></td>
				<td class="col-sm-10">
					<input class="form-control" type="text" name="pavblog_category[keyword]" value="<?php echo $menu['keyword'];?>"/>
					<p><?php echo $objlang->get('help_entry_keyword'); ?></p>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('entry_meta_title');?></td>
				<td class="col-sm-10">
					<input class="form-control" type="text" name="pavblog_category[meta_title]" value="<?php echo $menu['meta_title'];?>"/>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('entry_meta_keyword');?></td>
				<td class="col-sm-10">
					<textarea class="form-control" name="pavblog_category[meta_keyword]"><?php echo $menu['meta_keyword'];?></textarea></td>
			</tr>
			<tr>
				<td class="col-sm-2"><?php echo $objlang->get('entry_meta_description');?></td>
				<td class="col-sm-10">
					<textarea class="form-control" name="pavblog_category[meta_description]" rows="6" cols="40"><?php echo $menu['meta_description'];?></textarea></td>
			</tr>
		</table>
	</div>
</div>
<input type="hidden" name="pavblog_category[category_id]" value="<?php echo $menu['category_id']?>"/>











<?php } ?>

<script type="text/javascript">
// First li active
$('#language-<?php echo $module_row; ?> li:first-child a').tab('show');

// Description
<?php foreach ($languages as $language) { ?>
$('#input-description-language<?php echo $language['language_id']; ?>').summernote({
	height: 160
});
<?php } ?>

</script>