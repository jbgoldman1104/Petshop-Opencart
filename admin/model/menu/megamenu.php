<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) September 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class ModelMenuMegamenu extends Model { 
	/**
	 * @var Array $children as collections of childrent menus 
	 * 
	 * @accesss protected
	 */
	protected $children = array();
	
	/**
	 * Get menu information by id
	 */
	public function getInfo( $id ){	
		$sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'megamenu m LEFT JOIN '
							.DB_PREFIX.'megamenu_description md ON m.megamenu_id=md.megamenu_id AND language_id='.(int)$this->config->get('config_language_id') ;
	
		$sql .= ' WHERE m.megamenu_id='.(int)$id;						
	
		$query = $this->db->query( $sql );
		return $query->row;
	}
	
	/**
	 * get menu description by id
	 */
	public function getMenuDescription( $id ){
		$sql = 'SELECT * FROM '.DB_PREFIX."megamenu_description WHERE megamenu_id=".$id;
		$query = $this->db->query( $sql );
		return $query->rows;
	}


	/**
	 * get get all  Menu Childrens by Id
	 */
	public function getChild( $id=null, $store_id = 0){
		$sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'megamenu m LEFT JOIN '
								.DB_PREFIX.'megamenu_description md ON m.megamenu_id=md.megamenu_id AND language_id='.(int)$this->config->get('config_language_id') ;

        	$sql .= ' WHERE store_id='.(int)$store_id;
                if( $id != null ) {
			$sql .= ' AND parent_id='.(int)$id;
		}
		$sql .= ' ORDER BY `position`  ';
		$query = $this->db->query( $sql );						
		return $query->rows;
	}

	/**
	 * whethere parent has menu childrens
	 */
	public function hasChild( $id ){
		return isset($this->children[$id]);
	}	
	
	/**
	 * get collection of menu childrens by parent ID.
	 */
	public function getNodes( $id ){
		return $this->children[$id];
	}

	//start fix delete tree
	/**
	 * delete mega menu data by id
	 */ 
	public function delete( $id, $store_id){
		$childs = $this->getChild( null, $store_id );
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		$this->recursiveDelete($id, $store_id); 
	}
	/**
	 * recursive delete tree
	 */ 
	public function recursiveDelete($parent_id, $store_id)
	{
		$sql = " DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id=".(int)$parent_id .";";
		$this->db->query($sql);
		$sql = " DELETE FROM ".DB_PREFIX ."megamenu WHERE store_id = ".$store_id." AND megamenu_id=".(int)$parent_id .";";
		$this->db->query($sql);

		if( $this->hasChild($parent_id) ){
			$data = $this->getNodes( $parent_id );
			foreach( $data as $menu ){
				if($menu['megamenu_id'] > 1) {
					 $this->recursiveDelete( $menu['megamenu_id'], $store_id );
				}	
			}
		}
	}
	//end fix delete tree
	
	/**
	 * Render Tree Menu by ID
	 */
	public function getTree( $id=null, $store_id = 0 , $selected ){
		$childs = $this->getChild( $id, $store_id );
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		$parent = 1 ;
		$output = $this->genTree( $parent, 1, $store_id , $selected );
		return $output;
	}

	

	public function genTree( $parent, $level, $store_id = 0, $selected=0 ){
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			$t = $level == 1?" sortable":"";
			$output = '<ol class="level'.$level. $t.' ">';

			$store = ($store_id > 0)?'&store_id='.$store_id:'';

			foreach( $data as $menu ){
				$url  = $this->url->link('extension/module/pavmegamenu', 'id='.$menu['megamenu_id'].$store.'&token=' . $this->session->data['token'], 'SSL') ;
				$cls = $menu['megamenu_id'] == $selected ? 'class="active"':"";
				$output .='<li id="list_'.$menu['megamenu_id'].'" '.$cls.' >
				<div><span class="disclose"><span></span></span>'.($menu['title']?$menu['title']:"").' (ID:'.$menu['megamenu_id'].') <a class="quickedit" rel="id_'.$menu['megamenu_id'].'" href="'.$url .'">E</a><span class="quickdel" rel="id_'.$menu['megamenu_id'].'">D</span></div>';
				if($menu['megamenu_id'] > 1) {
					$output .= $this->genTree( $menu['megamenu_id'], $level+1, $store_id, $selected );
				}
				$output .= '</li>';
			}
			$output .= '</ol>';
			return $output;
		}
		return ;
	}

	/**
	 * render dropdown menu
	 */
	public function getDropdown( $id=null, $selected=1, $store_id = 0  ){
		$this->children = array();
		$childs = $this->getChild( $id, $store_id );
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		
		$output = '<select class="form-control" name="megamenu[parent_id]" >';
		$output .='<option value="1">ROOT</option>';	
		$output .= $this->genOption( 1 ,1, $selected );
		$output .= '</select>';
		return $output ;
	}

	/**
	 * render option of dropdown as subs
	 */
	public function genOption( $parent, $level=0, $selected){
		$output = '';
		if( $this->hasChild($parent) ){
			$data = $this->getNodes( $parent );
			
			foreach( $data as $menu ){
				$select = $selected == $menu['megamenu_id'] ? 'selected="selected"':"";
				$output .= '<option value="'.$menu['megamenu_id'].'" '.$select.'>'.str_repeat("-",$level) ." ".$menu['title'].' (ID:'.$menu['megamenu_id'].')</option>';
				$output .= $this->genOption(  $menu['megamenu_id'],$level+1, $selected );
			}				
		}
		
		return $output;
	}

	/**
	 * Mass Update Data for list of childrens by prent IDs
	 */
	public function massUpdate( $data, $root ){
		$child = array();
		foreach( $data as $id => $parentId ){
			if( $parentId <=0 ){
				$parentId = $root;
			}
			$child[$parentId][] = $id;
		}
		
		foreach( $child as $parentId => $menus ){
			$i = 1;
			foreach( $menus as $menuId ){
				$sql = " UPDATE  ". DB_PREFIX . "megamenu SET parent_id=".(int)$parentId.', position='.$i.' WHERE megamenu_id='.(int)$menuId;
				$this->db->query( $sql );
				$i++;
			}
		}
	}
	
	
	//start import category
	public function checkExitItemMenu($category, $store_id){
		$query = $this->db->query("SELECT megamenu_id FROM ".DB_PREFIX."megamenu WHERE store_id = ".$store_id." AND `type`='category' AND item=".$category['category_id']);
		return $query->num_rows;
	}
	public function deletecategories($store_id) {
		$query = $this->db->query("SELECT megamenu_id FROM ".DB_PREFIX."megamenu WHERE store_id = ".$store_id);
		if ($query->num_rows) {
			foreach ($query->rows as $row) {
				$this->db->query( "DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id = ".$row['megamenu_id'] );
			}
		}
		$this->db->query( "DELETE FROM ".DB_PREFIX ."megamenu WHERE store_id = ".$store_id );
	}

	public function importCategories($store_id = 0){
		$sql = "SELECT cd.`name`,c.* FROM ".DB_PREFIX ."category c
				LEFT JOIN ".DB_PREFIX ."category_description cd ON c.category_id = cd.category_id
				WHERE  cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				ORDER BY parent_id ASC";
		$query = $this->db->query( $sql );
		if($query->num_rows){
			$categories = $query->rows;
		}
		$this->load->model('catalog/category');
		foreach ($categories as &$category){
			$category['language'] = $this->model_catalog_category->getCategoryDescriptions($category['category_id']);
			
			if($this->checkExitItemMenu($category, $store_id) == 0){
				if((int)$category['parent_id'] > 0){
					$query1 = $this->db->query("SELECT megamenu_id FROM ".DB_PREFIX."megamenu WHERE store_id = ".$store_id." AND `type`='category' AND item='".$category['parent_id']."'");
					if($query1->num_rows){
						$megamenu_parent_id = (int)$query1->row['megamenu_id'];
					}
				} else {
					$megamenu_parent_id = 1;
				}
				$this->insertCategory($category, $megamenu_parent_id, $store_id);
			}
		}
	}
	public function insertCategory($category = array(), $megamenu_parent_id, $store_id = 0){
		$data = array();
		$data['megamenu']['position'] = 99;
		$data['megamenu']['item'] = $category['category_id'];
		$data['megamenu']['published'] = 1;
		$data['megamenu']['parent_id'] = $megamenu_parent_id;
		$data['megamenu']['show_title'] = 1;
		$data['megamenu']['widget_id'] = 1;
		$data['megamenu']['type_submenu'] = 'menu';
		$data['megamenu']['type'] = 'category';
		$data['megamenu']['colums'] = 1;
		$data['megamenu']['store_id'] = $store_id;
		$data['megamenu']['is_group'] = 0;

		$sql = "INSERT INTO ".DB_PREFIX . "megamenu ( `";
		$tmp = array();
		$vals = array();
		foreach( $data["megamenu"] as $key => $value ){
			$tmp[] = $key;
			$vals[]=$this->db->escape($value);
		}
	 	$sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
	 	$this->db->query( $sql );
	 	$data['megamenu']['megamenu_id'] = $this->db->getLastId();
	 	
	 	$this->load->model('localisation/language');
	 	$languages = $this->model_localisation_language->getLanguages();
	 	
	 	if( isset($category["language"]) ){
	 		$sql = " DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id=".(int)$data["megamenu"]['megamenu_id'] ;
	 		$this->db->query( $sql );
	 		
	 		foreach( $category["language"] as $key => $categorydes ){
	 			
	 			$sql = "INSERT INTO ".DB_PREFIX ."megamenu_description(`language_id`, `megamenu_id`,`title`)
							VALUES(".$key.",'".$data['megamenu']['megamenu_id']."','".$this->db->escape($categorydes['name'])."') ";
	 			$this->db->query( $sql );
	 		}
	 	}
	}
	//end import category

	/**
	 * Edit Or Create new children
	 */
	public function editData( $data ){

		$query = $this->db->query( "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE()
        AND COLUMN_NAME='badges' AND TABLE_NAME='".DB_PREFIX."megamenu'");
		if(count($query->rows) <= 0){
			$query = $this->db->query("ALTER TABLE `".DB_PREFIX."megamenu` ADD COLUMN `badges` text DEFAULT ''");
		}

		if( $data["megamenu"] ){
			if(  (int)$data['megamenu']['megamenu_id'] > 0 ){
				$sql = " UPDATE  ". DB_PREFIX . "megamenu SET  ";
				$tmp = array();
				foreach( $data["megamenu"] as $key => $value ){
					if( $key != "megamenu_id" ){
						$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
					}
				}
				$sql .= implode( " , ", $tmp );
				$sql .= " WHERE megamenu_id=".$data['megamenu']['megamenu_id'];
				
				//	echo '<pre>'.print_r( $sql, 1 ); die;
				$this->db->query( $sql );
			} else {
				$data['megamenu']['position'] = 99;
				$sql = "INSERT INTO ".DB_PREFIX . "megamenu ( `";
				$tmp = array();
				$vals = array();
				foreach( $data["megamenu"] as $key => $value ){
					$tmp[] = $key;
					$vals[]=$this->db->escape($value);
				}				
				
			 	$sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
				$this->db->query( $sql );
				$data['megamenu']['megamenu_id'] = $this->db->getLastId();
			}
		
		
		}
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
	
		if( isset($data["megamenu_description"]) ){
			$sql = " DELETE FROM ".DB_PREFIX ."megamenu_description WHERE megamenu_id=".(int)$data["megamenu"]['megamenu_id'] ;
			$this->db->query( $sql );
	 
			foreach( $languages as $language ){
				$sql = "INSERT INTO ".DB_PREFIX ."megamenu_description(`language_id`, `megamenu_id`,`title`,`description`) 
							VALUES(".$language['language_id'].",'".$data['megamenu']['megamenu_id']."','".$this->db->escape($data["megamenu_description"][$language['language_id']]['title'])."','"
							.$this->db->escape($data["megamenu_description"][$language['language_id']]['description'])."') ";
				$this->db->query( $sql );					
			}
		}
		return $data['megamenu']['megamenu_id'];
	}
	
	
	 
	
	 

	 /**
	  * Automatic checking installation to whethere creating tables and data sample, configuration of modules.
	  */
	public function install(){

		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){
			//$file = DIR_APPLICATION.'model/sample/module.php';
			$file = (DIR_APPLICATION).'model/sample/'.$this->config->get('theme_default_directory').'/sample.php';
			if( file_exists($file) ){
				require_once( DIR_APPLICATION.'model/sample/module.php' );
		 		$sample = new ModelSampleModule( $this->registry );
		 	    $result = $sample->installSampleQuery( $this->config->get('theme_default_directory'),'pavmegamenu', true );
		 	    $result = $sample->installSample( $this->config->get('theme_default_directory'),'pavmegamenu', true );
			}
		}	


		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu_widgets'";
		$query = $this->db->query( $sql );
		$sql = array();
		if( count($query->rows) <=0 ){ 
			$sql[]  = "	
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_widgets` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(250) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `params` text NOT NULL,
				  `store_id` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; ";

$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (1, 'Video Opencart Installation', 'video_code', 'a:1:{s:10:\"video_code\";s:168:\"&lt;iframe width=&quot;300&quot; height=&quot;315&quot; src=&quot;//www.youtube.com/embed/cUhPA5qIxDQ&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;\";}', 0);";
$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (2, 'Demo HTML Sample', 'html', 'a:1:{s:4:\"html\";a:1:{i:1;s:275:\"Dorem ipsum dolor sit amet consectetur adipiscing elit congue sit amet erat roin tincidunt vehicula lorem in adipiscing urna iaculis vel. Dorem ipsum dolor sit amet consectetur adipiscing elit congue sit amet erat roin tincidunt vehicula lorem in adipiscing urna iaculis vel.\";}}', 0);";
$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (3, 'Products Latest', 'product_list', 'a:4:{s:9:\"list_type\";s:6:\"newest\";s:5:\"limit\";s:1:\"6\";s:11:\"image_width\";s:3:\"120\";s:12:\"image_height\";s:3:\"120\";}', 0);";
$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (4, 'Products In Cat 20', 'product_category', 'a:4:{s:11:\"category_id\";s:2:\"20\";s:5:\"limit\";s:1:\"6\";s:11:\"image_width\";s:3:\"120\";s:12:\"image_height\";s:3:\"120\";}', 0);";
$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (5, 'Manufactures', 'banner', 'a:4:{s:8:\"group_id\";s:1:\"8\";s:11:\"image_width\";s:2:\"80\";s:12:\"image_height\";s:2:\"80\";s:5:\"limit\";s:2:\"12\";}', 0);";
$sql[] = "INSERT INTO `".DB_PREFIX."megamenu_widgets` VALUES (6, 'PavoThemes Feed', 'feed', 'a:1:{s:8:\"feed_url\";s:55:\"http://www.pavothemes.com/opencart-themes.feed?type=rss\";}', 0);";

			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}


		$sql = " SHOW TABLES LIKE '".DB_PREFIX."megamenu'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){
			$sql = array();
			$sql[]  = "	
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu` (
				  `megamenu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `image` varchar(255) NOT NULL DEFAULT '',
				  `parent_id` int(11) NOT NULL DEFAULT '0',
				  `is_group` smallint(6) NOT NULL DEFAULT '2',
				  `width` varchar(255) DEFAULT NULL,
				  `submenu_width` varchar(255) DEFAULT NULL,
				  `colum_width` varchar(255) DEFAULT NULL,
				  `submenu_colum_width` varchar(255) DEFAULT NULL,
				  `item` varchar(255) DEFAULT NULL,
				  `colums` varchar(255) DEFAULT '1',
				  `type` varchar(255) NOT NULL,
				  `is_content` smallint(6) NOT NULL DEFAULT '2',
				  `show_title` smallint(6) NOT NULL DEFAULT '1',
				  `type_submenu` varchar(10) NOT NULL DEFAULT '1',
				  `level_depth` smallint(6) NOT NULL DEFAULT '0',
				  `published` smallint(6) NOT NULL DEFAULT '1',
				  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0',
				  `position` int(11) unsigned NOT NULL DEFAULT '0',
				  `show_sub` smallint(6) NOT NULL DEFAULT '0',
				  `url` varchar(255) DEFAULT NULL,
				  `target` varchar(25) DEFAULT NULL,
				  `privacy` smallint(5) unsigned NOT NULL DEFAULT '0',
				  `position_type` varchar(25) DEFAULT 'top',
				  `menu_class` varchar(25) DEFAULT NULL,
				  `description` text,
				  `content_text` text,
				  `submenu_content` text,
				  `level` int(11) NOT NULL,
				  `left` int(11) NOT NULL,
				  `right` int(11) NOT NULL,
				  `widget_id` int(11) DEFAULT '0',
				  `badges` text DEFAULT '',
				  PRIMARY KEY (`megamenu_id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;
			";
			$sql[] = "	
						CREATE TABLE IF NOT EXISTS `".DB_PREFIX."megamenu_description` (
						  `megamenu_id` int(11) NOT NULL,
						  `language_id` int(11) NOT NULL,
						  `title` varchar(255) NOT NULL,
						  `description` text NOT NULL,
						  PRIMARY KEY (`megamenu_id`,`language_id`),
						  KEY `name` (`title`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;		
											
			";
					
					
			$sql[] = " 
			
INSERT INTO `".DB_PREFIX."megamenu` (`megamenu_id`, `image`, `parent_id`, `is_group`, `width`, `submenu_width`, `colum_width`, `submenu_colum_width`, `item`, `colums`, `type`, `is_content`, `show_title`, `type_submenu`, `level_depth`, `published`, `store_id`, `position`, `show_sub`, `url`, `target`, `privacy`, `position_type`, `menu_class`, `description`, `content_text`, `submenu_content`, `level`, `left`, `right`) VALUES
(1, '', 0, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 0, 0, NULL, NULL, 0, 'top', NULL, NULL, NULL, NULL, -5, 34, 47),
(2, '', 1, 0, NULL, NULL, NULL, 'col1=3, col2=3, col3=6', '20', '3', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(3, '', 1, 0, NULL, NULL, NULL, '', '18', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', 'pav-parrent', NULL, '', '', 0, 0, 0),
(4, '', 3, 0, NULL, NULL, NULL, '', '25', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', 'pav-parrent', NULL, '', '', 0, 0, 0),
(5, '', 1, 0, NULL, NULL, NULL, '', '17', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-parrent', NULL, '', '', 0, 0, 0),
(7, '', 1, 0, NULL, NULL, NULL, '', '33', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(8, '', 2, 1, NULL, NULL, NULL, '', '27', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '&lt;p&gt;test&lt;/p&gt;\r\n', 0, 0, 0),
(9, '', 2, 1, NULL, NULL, NULL, '', '26', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(10, '', 8, 0, NULL, NULL, NULL, '', '59', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(11, '', 8, 0, NULL, NULL, NULL, '', '60', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(12, '', 8, 0, NULL, NULL, NULL, '', '61', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(13, '', 8, 0, NULL, NULL, NULL, '', '62', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(14, '', 8, 0, NULL, NULL, NULL, '', '63', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(15, '', 8, 0, NULL, NULL, NULL, '', '64', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(16, '', 8, 0, NULL, NULL, NULL, '', '65', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(17, '', 9, 0, NULL, NULL, NULL, '', '66', '1', 'category', 0, 1, 'menu', 0, 1, 0, 1, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(18, '', 9, 0, NULL, NULL, NULL, '', '67', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(19, '', 9, 0, NULL, NULL, NULL, '', '68', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(20, '', 9, 0, NULL, NULL, NULL, '', '71', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(21, '', 9, 0, NULL, NULL, NULL, '', '72', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(22, '', 9, 0, NULL, NULL, NULL, '', '69', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(23, '', 9, 0, NULL, NULL, NULL, '', '70', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '', '', 0, 0, 0),
(24, '', 2, 0, NULL, NULL, NULL, '', '', '1', 'html', 1, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', 'pav-menu-child', NULL, '&lt;div class=&quot;pav-menu-video&quot;&gt;&lt;iframe allowfullscreen=&quot;&quot; frameborder=&quot;0&quot; height=&quot;157&quot; src=&quot;http://www.youtube.com/embed/NBuLeA7nNFk&quot; width=&quot;279&quot;&gt;&lt;/iframe&gt;\r\n&lt;h3&gt;Lorem ipsum dolor sit&lt;/h3&gt;\r\n\r\n&lt;p&gt;Dorem ipsum dolor sit amet consectetur adipiscing elit congue sit amet erat roin tincidunt vehicula lorem in adipiscing urna iaculis vel.&lt;/p&gt;\r\n&lt;/div&gt;\r\n', '', 0, 0, 0),
(25, '', 3, 0, NULL, NULL, NULL, '', '79', '1', 'category', 0, 1, 'menu', 0, 1, 0, 2, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(26, '', 3, 0, NULL, NULL, NULL, '', '74', '1', 'category', 0, 1, 'menu', 0, 1, 0, 3, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(27, '', 3, 0, NULL, NULL, NULL, '', '73', '1', 'category', 0, 1, 'menu', 0, 1, 0, 4, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(28, '', 3, 0, NULL, NULL, NULL, '', '80', '1', 'category', 0, 1, 'menu', 0, 1, 0, 5, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(29, '', 3, 0, NULL, NULL, NULL, '', '', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(30, '', 3, 0, NULL, NULL, NULL, '', '46', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(31, '', 3, 0, NULL, NULL, NULL, '', '75', '1', 'category', 0, 1, 'menu', 0, 1, 0, 8, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(32, '', 3, 0, NULL, NULL, NULL, '', '78', '1', 'category', 0, 1, 'menu', 0, 1, 0, 9, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(33, '', 3, 0, NULL, NULL, NULL, '', '77', '1', 'category', 0, 1, 'menu', 0, 1, 0, 10, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(34, '', 3, 0, NULL, NULL, NULL, '', '77', '1', 'category', 0, 1, 'menu', 0, 1, 0, 11, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(35, '', 3, 0, NULL, NULL, NULL, '', '45', '1', 'category', 0, 1, 'menu', 0, 1, 0, 12, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(36, '', 3, 0, NULL, NULL, NULL, '', '45', '1', 'category', 0, 1, 'menu', 0, 1, 0, 13, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(37, '', 1, 0, NULL, NULL, NULL, '', '25', '1', 'category', 0, 1, 'menu', 0, 1, 0, 6, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(38, '', 1, 0, NULL, NULL, NULL, '', '57', '1', 'category', 0, 1, 'menu', 0, 1, 0, 7, 0, '', NULL, 0, 'top', '', NULL, '', '', 0, 0, 0),
(40, '', 1, 0, NULL, NULL, NULL, '', '', '1', 'url', 0, 1, 'menu', 0, 1, 0, 1, 0, '?route=common/home', NULL, 0, 'top', 'home', NULL, '', '', 0, 0, 0);


";

			$sql[] = "
INSERT INTO `".DB_PREFIX."megamenu_description` (`megamenu_id`, `language_id`, `title`, `description`) VALUES
(2, 2, 'Electronics', ''),
(3, 1, 'Digital', ''),
(3, 2, 'Digital', ''),
(4, 2, 'Watches', ''),
(2, 1, 'Electronics', ''),
(4, 1, 'Watches', ''),
(5, 2, 'Books', ''),
(5, 1, 'Books', ''),
(37, 2, 'Watches', ''),
(7, 2, 'Office', ''),
(7, 1, 'Office', ''),
(8, 1, 'Computers', ''),
(9, 1, 'Printer', ''),
(8, 2, 'Computers', ''),
(10, 2, 'Duis tempor', ''),
(10, 1, 'Duis tempor', ''),
(11, 2, 'Pellentesque eget', ''),
(11, 1, 'Pellentesque eget ', ''),
(12, 2, 'Nam nunc ante', ''),
(12, 1, 'Nam nunc ante', ''),
(13, 2, 'Condimentum eu', ''),
(13, 1, 'Condimentum eu', ''),
(14, 2, 'Lehicula lorem', ''),
(14, 1, 'Lehicula lorem', ''),
(15, 2, 'Integer semper', ''),
(15, 1, 'Integer semper', ''),
(16, 2, 'Sollicitudin lacus', ''),
(16, 1, 'Sollicitudin lacus', ''),
(9, 2, 'Mobiles', ''),
(17, 2, 'Nam ipsum ', ''),
(17, 1, 'Nam ipsum ', ''),
(18, 2, 'Curabitur turpis ', ''),
(18, 1, 'Curabitur turpis ', ''),
(19, 1, 'Molestie eu mattis ', ''),
(19, 2, 'Molestie eu mattis ', ''),
(20, 1, 'Suspendisse eu ', ''),
(20, 2, 'Suspendisse eu ', ''),
(21, 1, 'Nunc imperdiet ', ''),
(21, 2, 'Nunc imperdiet ', ''),
(22, 1, 'Mauris mattis', ''),
(22, 2, 'Mauris mattis', ''),
(23, 1, 'Lacus sed iaculis ', ''),
(23, 2, 'Lacus sed iaculis ', ''),
(24, 2, 'Lorem ipsum dolor sit ', ''),
(24, 1, 'Lorem ipsum dolor sit ', ''),
(37, 1, 'Watches', ''),
(25, 1, 'Aliquam', ''),
(25, 2, 'Aliquam', ''),
(26, 1, 'Claritas', ''),
(26, 2, 'Claritas', ''),
(27, 2, 'Consectetuer', ''),
(27, 1, 'Consectetuer', ''),
(28, 1, 'Hendrerit', ''),
(28, 2, 'Hendrerit', ''),
(29, 1, 'Litterarum', ''),
(29, 2, 'Litterarum', ''),
(30, 1, 'Macs', ''),
(30, 2, 'Macs', ''),
(31, 1, 'Sollemnes', ''),
(31, 2, 'Sollemnes', ''),
(32, 1, 'Tempor', ''),
(32, 2, 'Tempor', ''),
(33, 1, 'Vulputate', ''),
(33, 2, 'Vulputate', ''),
(34, 1, 'Vulputate', ''),
(34, 2, 'Vulputate', ''),
(35, 1, 'Windows', ''),
(35, 2, 'Windows', ''),
(36, 1, 'Windows', ''),
(36, 2, 'Windows', ''),
(38, 1, 'Tablets', ''),
(38, 2, 'Tablets', ''),
(40, 2, 'Home', ''),
(40, 1, 'Home', '');
";
			
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}
		$query = $this->db->query( "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE()
        AND COLUMN_NAME='widget_id' AND TABLE_NAME='".DB_PREFIX."megamenu'");
		if(count($query->rows) <= 0){
			$query = $this->db->query("ALTER TABLE `".DB_PREFIX."megamenu` ADD COLUMN `widget_id` int DEFAULT '0'");
		}
		
	}
	 
}

?>