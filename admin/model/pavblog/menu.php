<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavbloginstall 
 */
class Modelpavblogmenu extends Model { 
	protected $children = array();
	
	public function getInfo( $id ){
		$sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'pavblog_category m LEFT JOIN '
							.DB_PREFIX.'pavblog_category_description md ON m.category_id=md.category_id AND language_id='.(int)$this->config->get('config_language_id') ;
	
		$sql .= ' WHERE m.category_id='.(int)$id;						
	
		$query = $this->db->query( $sql );

		return $query->row;
	}
	
	public function getMenuDescription( $id ){
		$sql = 'SELECT * FROM '.DB_PREFIX."pavblog_category_description WHERE category_id=".$id;
		$query = $this->db->query( $sql );
		return $query->rows;
	}
	public function getChild( $id=null ){
		$sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'pavblog_category m LEFT JOIN '
								.DB_PREFIX.'pavblog_category_description md ON m.category_id=md.category_id AND language_id='.(int)$this->config->get('config_language_id') ;
		if( $id != null ) {						
			$sql .= ' WHERE parent_id='.(int)$id;						
		}
		$sql .= ' ORDER BY `position`  ';
		$query = $this->db->query( $sql );						
		return $query->rows;
	}
	public function hasChild( $id ){
		return isset($this->children[$id]);
	}	
	
	public function getNodes( $id ){
		return $this->children[$id];
	}
	
	public function getTree( $id=null ){
		
		$childs = $this->getChild( $id );
		
		foreach($childs as $child ){
			$this->children[$child['parent_id']][] = $child;	
		}
		$parent = 1 ;
		$output = $this->genTree( $parent, 1 );
		return $output;
	}

	public function getOption( $id=null, $selected=1){
		if( !$this->children ) {
			$childs = $this->getChild( $id );
			foreach($childs as $child ){
				$this->children[$child['parent_id']][] = $child;	
			}
		}
	
		$output ='<option value="1">ROOT</option>';	
		$output .= $this->genOption( 1 ,1, $selected );
	
		return $output ;
	}
	
	public function getDropdown( $id=null, $selected=1, $name="pavblog_category[parent_id]" ){
		if( !$this->children ) {
			$childs = $this->getChild( $id );
			foreach($childs as $child ){
				$this->children[$child['parent_id']][] = $child;	
			}
		}
		
		$output = '<select name="'.$name.'" >';
		$output .='<option value="1">ROOT</option>';	
		$output .= $this->genOption( 1 ,1, $selected );
		$output .= '</select>';
		return $output ;
	}
	
	public function genOption( $parent, $level=0, $selected ){
		$output = '';
		if( $this->hasChild($parent)){
			$data = $this->getNodes( $parent );
			
			foreach( $data as $menu ){
				$select = $selected == $menu['category_id'] ? 'selected="selected"':"";
				$output .= '<option value="'.$menu['category_id'].'" '.$select.'>'.str_repeat("-",$level) ." ".$menu['title'].' (ID:'.$menu['category_id'].')</option>';
				if($menu['category_id'] > 1)
					$output .= $this->genOption(  $menu['category_id'],$level+1, $selected );
			}				
		}
		
		return $output;
	}
	public function massUpdate( $data, $root ){
		$child = array();
		foreach( $data as $id => $parentId ){
			if( $parentId <=0 ){
				$parentId = $root;
			}
			
		//	$this->db->query( $sql );
			$child[$parentId][] = $id;
		}
		
		foreach( $child as $parentId => $menus ){
			$i = 1;
			foreach( $menus as $menuId ){
				$sql = " UPDATE  ". DB_PREFIX . "pavblog_category SET parent_id=".(int)$parentId.', position='.$i.' WHERE category_id='.(int)$menuId;
				$this->db->query( $sql );
				$i++;
			}
		}
 
	}
	public function genTree( $parent, $level ){
		if( $this->hasChild($parent)){
			$data = $this->getNodes( $parent );
			$t = $level == 1?" sortable":"";
			$output = '<ol class="level'.$level. $t.' ">';
			
			foreach( $data as $menu ){
				$output .='<li id="list_'.$menu['category_id'].'">
				<div><span class="disclose"><span></span></span>'.($menu['title']?$menu['title']:"").' (ID:'.$menu['category_id'].') <span class="quickedit" rel="id_'.$menu['category_id'].'">E</span><span class="quickdel" rel="id_'.$menu['category_id'].'">D</span></div>';
				if($menu['category_id'] > 1)
					$output .= $this->genTree( $menu['category_id'], $level+1 );
				$output .= '</li>';
			}	
			
			$output .= '</ol>';
			return $output;
		}
		return ;
	}
	
	public function editData( $data ){

		if( $data["pavblog_category"] ){
			if(  (int)$data['pavblog_category']['category_id'] > 0 ){
				$sql = " UPDATE  ". DB_PREFIX . "pavblog_category SET  ";
				$tmp = array();
				foreach( $data["pavblog_category"] as $key => $value ){
					if( $key != "category_id" ){
						$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
					}
				}
				$sql .= implode( " , ", $tmp );
				$sql .= " WHERE category_id=".$data['pavblog_category']['category_id'];
				
				  
				$this->db->query( $sql );
			} else {
				$sql = "INSERT INTO ".DB_PREFIX . "pavblog_category ( `";
				$tmp = array();
				$vals = array();
				foreach( $data["pavblog_category"] as $key => $value ){
					$tmp[] = $key;
					$vals[]=$this->db->escape($value);
				}				
				
			 	$sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
				$this->db->query( $sql );
				$data['pavblog_category']['category_id'] = $this->db->getLastId();
			}
			$this->load->model('pavblog/seo');
			if( isset($data['pavblog_category']['keyword']) && $data['pavblog_category']['category_id'] ) {
				$this->model_pavblog_seo->saveKeyword( 'blogcategory_id='.$data['pavblog_category']['category_id'], $data['pavblog_category']['keyword'] );
			}
		}
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
	
		if( isset($data["pavblog_category_description"]) ){
			$sql = " DELETE FROM ".DB_PREFIX ."pavblog_category_description WHERE category_id=".(int)$data["pavblog_category"]['category_id'] ;
			$this->db->query( $sql );
	 
			foreach( $languages as $language ){
				$sql = "INSERT INTO ".DB_PREFIX ."pavblog_category_description(`language_id`, `category_id`,`title`,`description`) 
							VALUES(".$language['language_id'].",'".$data['pavblog_category']['category_id']."','".$this->db->escape($data["pavblog_category_description"][$language['language_id']]['title'])."','"
							.$this->db->escape($data["pavblog_category_description"][$language['language_id']]['description'])."') ";
				$this->db->query( $sql );					
			}
		}
		return $data['pavblog_category']['category_id'];
	}
	 
	 
	 public function delete( $id ){
	  
	 	 if( $id ){
		  
			$sql = " DELETE FROM ".DB_PREFIX ."pavblog_category WHERE category_id=".(int)$id ;
			$this->db->query( $sql );
			$sql = " DELETE FROM ".DB_PREFIX ."pavblog_category_description WHERE category_id=".(int)$id ;
			$this->db->query( $sql );
		 	$this->load->model('pavblog/seo');
		 	$this->model_pavblog_seo->delete( 'pavblog/category='.$id ); 
	 	 }
	 }
	 
	public function install(){  
	
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavblog_category'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){ 
			$sql = array();
			$sql[]  = "
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_category` (
					  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
					  PRIMARY KEY (`category_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;
				
				
				
			";
			$sql[] = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavblog_category_description` (
					  `category_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `description` text NOT NULL,
					   PRIMARY KEY (`category_id`,`language_id`),
					  KEY `name` (`title`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
					
					
			$sql[] = "INSERT INTO `".DB_PREFIX."pavblog_category_description` (`category_id`, `image`, `parent_id`, `is_group`, `width`, `submenu_width`, `colum_width`, `submenu_colum_width`, `item`, `colums`, `type`, `is_content`, `show_title`, `type_submenu`, `level_depth`, `published`, `store_id`, `position`, `show_sub`, `url`, `target`, `privacy`, `position_type`, `menu_class`, `description`, `content_text`, `submenu_content`, `level`, `left`, `right`) VALUES
(1, '', 0, 2, NULL, NULL, NULL, NULL, NULL, '1', '', 2, 1, '1', 0, 1, 0, 0, 0, NULL, NULL, 0, 'top', NULL, NULL, NULL, NULL, -5, 34, 47);";

			$sql[] = "INSERT INTO `".DB_PREFIX."pavblog_category_description` (`category_id`, `language_id`, `title`, `description`) VALUES
(1, 1, 'ROOT', 'Menu Root');";
			
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
		}	
		
		
	}
	 
}

?>
