<?php 
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogblog 
 */
class ModelPavsliderlayerSlider extends Model { 
	
	public function cloneGroupSliders($groupID, $cloneGroupID, $languageID){
		// Get SliderLayer By Group
		$sql = "SELECT * FROM ".DB_PREFIX."pavosliderlayers where group_id = "  . $cloneGroupID;
		$query = $this->db->query( $sql );
		$rows = $query->rows;
		
		if( !empty($query->rows) ){
			foreach ($rows as $row) {
				$sql2 = "INSERT INTO ".DB_PREFIX."pavosliderlayers (title, parent_id, group_id, params, layersparams, image, `status`, position, language_id) SELECT title, parent_id, '" . $groupID . "', params, layersparams, image, `status`, position, '" . $languageID . "' FROM ".DB_PREFIX."pavosliderlayers AS iv WHERE iv.id=".$row['id'];
				$this->db->query( $sql2 );
			}
		}
	}

	public function checkInstall(){

		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavoslidergroups'";
		$query = $this->db->query( $sql );
		
		if( count($query->rows) <=0 ){
			$file = DIR_APPLICATION.'model/sample/module.php';
			if( file_exists($file) ){
				require_once( $file );
		 		$sample = new ModelSampleModule( $this->registry );
		 	    $result = $sample->installSampleQuery( $this->config->get('theme_default_directory'),'pavsliderlayer', true );
		 	    $result = $sample->installSample( $this->config->get('theme_default_directory'),'pavsliderlayer', true );
			}
		}	
		$query = $this->db->query( $sql );
		if( count($query->rows) <=0 ){ 
			$this->createTables();		
			$this->createDataSample();
			$this->createDefaultConfig();
		}
	}

	protected function createTables(){
		$sql = array();

		$sql[] = "
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavoslidergroups` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`title` varchar(255) NOT NULL,
				`params` text NOT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		";
		$sql[] = "
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pavosliderlayers` (
				   	  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` varchar(255) NOT NULL,
					  `parent_id` int(11) NOT NULL,
					  `group_id` int(11) NOT NULL,
					  `params` text NOT NULL,
					  `layersparams` text NOT NULL,
					  `image` varchar(255) NOT NULL,
					  `status` tinyint(1) NOT NULL,
					  `position` int(11) NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `id` (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

		";

		$sql[]="ALTER TABLE `".DB_PREFIX."pavosliderlayers` ADD `language_id` int(11) DEFAULT '1'";

		foreach( $sql as $q ){
			$query = $this->db->query( $q );
		}
		
	}

	protected function createDataSample(){
		return ;
	}	

	protected function createDefaultConfig(){
		return ;
	}

	public function saveSliderGroupData( $data ){


		if( isset($data['id']) && $data['id'] ){
		 	$query = " UPDATE  ". DB_PREFIX . "pavoslidergroups SET  ";
		 	$tmp = array();
		 	foreach( $data as $key => $value ){
				if( $key != "id" ){
					$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
				}
			}
			$query .= implode( " , ", $tmp );
			$query .= ' WHERE id='.$data['id'];
			$this->db->query( $query );
		 }else {
	 		$query = "INSERT INTO ".DB_PREFIX . "pavoslidergroups ( `";
			$tmp = array();
			$vals = array();
			foreach( $data as $key => $value ){
				$tmp[] = $key;
				$vals[]=$this->db->escape($value);
			}				
		 
		 	$query .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
 
			$q = $this->db->query( $query );
			$data['id'] =  $this->db->getLastId();

 		 }

		 return $data['id'];		
	}

	public function saveData( $data ){
		 if( isset($data['id']) && $data['id'] ){
		 	$query = " UPDATE  ". DB_PREFIX . "pavosliderlayers SET  ";
		 	$tmp = array();
		 	foreach( $data as $key => $value ){
				if( $key != "id" ){
					$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
				}
			}
			$query .= implode( " , ", $tmp );
			$query .= ' WHERE id='.$data['id'];
			$this->db->query( $query );
		 }else {
	 		$query = "INSERT INTO ".DB_PREFIX . "pavosliderlayers ( `";
			$tmp = array();
			$vals = array();
			foreach( $data as $key => $value ){
				$tmp[] = $key;
				$vals[]=$this->db->escape($value);
			}				
		 
		 	$query .= implode("` , `",$tmp)."`) VALUES ('".implode("','",$vals)."') ";
			$this->db->query( $query );
			$data['id'] =  $this->db->getLastId();
		 }

		 return $data['id'];
	}

	/**
	 */

	public function getListSliderGroups( ){
		$query = ' SELECT * FROM '. DB_PREFIX . "pavoslidergroups   ";

		$query = $this->db->query( $query );
		$row = $query->rows;
 		
	 	return $row;
	}
	/**
	 *
	 */
	public function getSliderById( $id ){
		$query = ' SELECT * FROM '. DB_PREFIX . "pavosliderlayers   ";
		$query .= ' WHERE id='.(int)$id;

		$query = $this->db->query( $query );
		$row = $query->row;
 	
	 	return $row;
	}

	/**
	 *
	 */
	public function getSliderGroupById( $id ){
		$query = ' SELECT * FROM '. DB_PREFIX . "pavoslidergroups   ";
		$query .= ' WHERE id='.(int)$id;
		 
		$query = $this->db->query( $query );
		$sliderGroup = $query->row;
 		
	 	
	 	$params = array(
			'title' => '',
			'delay' => '9000',
			'height' => '350',
			'width'  => '960',
			
			'touch_mobile' => 1,
			'stop_on_hover' => 1,
			'shuffle_mode'=>'0',
			'image_cropping' => '0',
			'shadow_type' => '2',
			'show_time_line' => '1',
			'time_line_position' => 'top',
			'background_color' => '#d9d9d9',
			'padding'=> '5px 5px',
			'margin' => '0px 0px 18px',
			'background_image' => '0',
			'background_url'  => '',
			'navigator_type' => 'none',
			'navigator_arrows' => 'verticalcentered',
			'navigation_style' => 'round',
			'offset_horizontal' => '0',
			'offset_vertical'   => '20',
			'show_navigator' => '0',
			'hide_navigator_after' => '200',
			'thumbnail_height' => '50',
			'thumbnail_width'  => '100',
			'thumbnail_amount' => '5',
			'hide_screen_width' => ''
		);

	 	if( $sliderGroup ){
			$sliderGroup['params'] = unserialize( $sliderGroup['params'] );
			$sliderGroup['params'] = array_merge( $params, $sliderGroup['params'] );
		}else {
			$sliderGroup['params'] = $params;
		}

		return $sliderGroup;
	}

	public function deleteSlider( $id ){
		$query = ' DELETE FROM '. DB_PREFIX . "pavosliderlayers  WHERE id=".$id;
		$this->db->query( $query );
	}
	public function delete( $id ){
		$query = ' DELETE FROM '. DB_PREFIX . "pavoslidergroups  WHERE id=".$id;

		$this->db->query( $query );
		$query = ' DELETE FROM '. DB_PREFIX . "pavosliderlayers  WHERE group_id=".$id;
		$this->db->query( $query );
			
	}

	/**
	 *
	 */
	public function getSlidersByGroupId( $groupID, $language_id ){
		$query  = ' SELECT * FROM '. DB_PREFIX . "pavosliderlayers";
		$query .= ' WHERE group_id='.(int)$groupID .' AND language_id='.(int)$language_id.' ORDER BY position ASC';

		$query = $this->db->query( $query );
		return $query->rows;
	}




	public function resize($filename, $width, $height, $type='') { // die("fds");
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		// $new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;

		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			$image = new Image(DIR_IMAGE . $old_image);
			

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);
			if ($type == 'a') {
			    if ($width/$height > $width_orig/$height_orig) {
			        $image->resize($width, $height, 'w');
			    } elseif ($width/$height < $width_orig/$height_orig) {
			        $image->resize($width, $height, 'h');
			    }
			} else {
			    $image->resize($width, $height, $type);
			}

			$image->save(DIR_IMAGE . $new_image);
		}
	
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_CATALOG . 'image/' . $new_image;
		} else {
			return HTTP_CATALOG . 'image/' . $new_image;
		}	
	}

	public function updatePost( $id , $pos ){
		$sql = 'UPDATE '.DB_PREFIX.'pavosliderlayers SET `position`='.$pos.' WHERE id='.($id);
		$this->db->query( $sql );
	}
}

?>