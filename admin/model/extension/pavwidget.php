<?php
 /**
  * Homepagebuilder module creates structure layout with rows and columns which standard bootstrap 3
  * and show modules inside each column in very flexiabel way without coding.
  * 
  * @version    $Id$
  * @package    Opencart 2
  * @author     PavoThemes Team <pavothemes@gmail.com>
  * @copyright  Copyright (C) 2014 pavothemes.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @addition   this license does not allow theme provider using in theirs themes to sell on marketplaces.
  * @website  http://www.pavothemes.com
  * @support  http://www.pavothemes.com/support/forum.html
  */

class ModelExtensionPavwidget extends Model {

	public function checkInstall(){
		
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavwidget'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){ 
			$sql = 'CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'pavwidget` (
					  `pavwidget_id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(64) NOT NULL,
					  `code` varchar(32) NOT NULL,
					  `setting` text NOT NULL,
					  `module_id` int(11) NOT NULL,
					  `key` int(11) NOT NULL,
					  PRIMARY KEY (`pavwidget_id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=190 ;';

			$this->db->query( $sql );
		}	
	}


	public function addWidgets( $widgets, $module_id ){
	 	
	 	// echo '<Pre>'.print_r( $widgets ,1 );die; 

		$this->deleteWidgetByModuleId( $module_id );
		foreach( $widgets as $key => $widget ) {
			$key = str_replace("-", '.', $key );
			$this->addWidget( $key, array( 'module_id' => $module_id,  'name'=>'content', 'setting'=>$widget) );
		}
	}
	
	/**
	 *
	 */
	public function addWidget($code, $data) { 
 
		$this->db->query("INSERT INTO `" . DB_PREFIX . "pavwidget` SET `module_id`='". $this->db->escape($data['module_id'])."', `name` = '" . $this->db->escape($data['name']) . "', `code` = '" . $this->db->escape($code) . "', `setting` = '" . $this->db->escape( $data['setting'] ) . "'");
	}
	
	/**
	 *
	 */
	public function editWidget($pavwidget_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "pavwidget` SET `name` = '" . $this->db->escape($data['name']) . "', `setting` = '" . $this->db->escape(serialize($data)) . "' WHERE `pavwidget_id` = '" . (int)$pavwidget_id . "'");
	}

	/**
	 *
	 */
	public function deleteWidget($pavwidget_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pavwidget` WHERE `pavwidget_id` = '" . (int)$pavwidget_id . "'");
	}
	
	/**
	 *
	 */	
	public function getWidget($pavwidget_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pavwidget` WHERE `pavwidget_id` = '" . $this->db->escape($pavwidget_id) . "'");

		if ($query->row) {
			return unserialize($query->row['setting']);
		} else {
			return array();	
		}
	}
	
	/**
	 *
	 */
	public function getWidgetsByModuleId( $module_id ) {
		if( !$module_id ){
			return array();
		}
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pavwidget` WHERE `module_id`=".(int)$module_id." ORDER BY `code`");
		return $query->rows;
	}	
	
	/**
	 *
	 */		
	public function getWidgetsByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pavwidget` WHERE `code` = '" . $this->db->escape($code) . "' ORDER BY `name`");

		return $query->rows;
	}	
	
	/**
	 *
	 */
	public function deleteWidgetByCode($code) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pavwidget` WHERE `code` = '" . $this->db->escape($code) . "'");
	}	

	/**
	 *
	 */
	public function deleteWidgetByModuleId($id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pavwidget` WHERE `module_id` = '" . $this->db->escape($id) . "'");
	}	
}