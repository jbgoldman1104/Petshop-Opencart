<?php 
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavnewsletterSubscribe 
 */
class ModelPavnewsletterSubscribe extends Model {		
	
 	
 	public function __construct( $registry ){
		parent::__construct( $registry );
		$this->isInstalled();

	}

	/**
	 * check installed
	 */
	public function isInstalled() {
		
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavnewsletter_email'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){ 
			$file = require(dirname(DIR_APPLICATION).'/admin/model/pavnewsletter/newsletter.php');
			$o = new ModelPavnewsletterNewsletter( $this->registry );
			$o->installModule();
			return false;
		}
		return true;
	}


	public function getDefaultSetting(){
		return array(
			'theme' => 'default',
			'latest' => 1,
			'limit' => 9,
			'width' => 180,
			'height' => 180,
			'auto_play' => '0',
			'auto_play_mode' => '',
			'interval' => 1000,
			'cols' => 1,
			'itemsperpage' => 2
		);
	}
	public function checkExists($email = ""){
		if(!empty($email)){
			$query = $this->db->query("SELECT `subscribe_id` FROM ".DB_PREFIX."pavnewsletter_subscribe WHERE `email`='".$this->db->escape($email)."'");
			if($query->num_rows > 0)
				return true;
		}
		return false;
	}
	public function storeSubscribe($data = array()){
		if(!empty($data)){
			if(!$this->checkExists($data['email'])){
				$sql = "INSERT INTO ".DB_PREFIX."pavnewsletter_subscribe ( `";
				$tmp = array();
				$vals = array();
				foreach( $data as $key => $value ){
					$tmp[] = $key;
					$vals[]=$this->db->escape($value);
				}
				$sql .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
				$this->db->query( $sql );
				return true;
			}
			
		}
		return false;
	}

}
?>