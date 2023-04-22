<?php 	
/******************************************************
 * @package Pav Slider Layer module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogBlog 
 */
class Modelpavsliderlayerslider extends Model {	
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
			'padding'=> '5px 0px',
			'margin' => '0px 0px',
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

	/**
	 *
	 */
	public function getSlidersByGroupId( $groupID, $languageID ){
		$query = ' SELECT * FROM '. DB_PREFIX . "pavosliderlayers   ";
		$query .= ' WHERE group_id='.(int)$groupID .' AND `language_id`='.(int)$languageID.' AND `status` = 1 ORDER BY position ASC';

		$query = $this->db->query( $query );
		return $query->rows;

	}


	/**
	*	
	*	@param filename string
	*	@param width 
	*	@param height
	*	@param type char [default, w, h]
	*				default = scale with white space, 
	*				w = fill according to width, 
	*				h = fill according to height
	*	
	*/
	public function resize($filename, $width, $height, $type = "") {
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
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

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);
		 
			if ($width_orig != $width || $height_orig != $height) {
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
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {
			return $this->config->get('config_url') . 'image/' . $new_image;
		}	
	}
}

?>