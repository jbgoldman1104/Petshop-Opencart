<?php 

/******************************************************
 * @package Pavo Opencart Theme Framework for Opencart 1.5.x
 * @version 3.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) May 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class PavCache {
		
		/**
		 *
		 */
		private $expire = 3600; 
		
		/**
		 *
		 */
		private $ext = 'css';
		
		/**
		 *
		 */
		public function setExtension( $ext='css'){
			if( !is_dir(PAV_CSS_CACHE) ){ 
				mkdir( PAV_CSS_CACHE, 0777 );
			}
			$this->ext = $ext; 
			return $this;
		}
		
		/**
		 *
		 */
		public function get($key) {
			$files = glob(PAV_CSS_CACHE . 'c-' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.'. $this->ext );

			if ($files) {
				$cache = file_get_contents($files[0]);
				
				$data = unserialize($cache);
				
				foreach ($files as $file) {
					$time = substr(strrchr($file, '.'), 1);

					if ($time < time()) {
						if (file_exists($file)) {
							unlink($file);
						}
					}
				}
				
				return $data;			
			}
		}
		
		/**
		 *
		 */
		public function isExisted( $key ){
			return is_file( PAV_CSS_CACHE . $key.'.'.$this->ext ); 
		}
		
		/**
		 *
		 */
		public function set($key, $value) {
			$this->delete($key);
			$file = PAV_CSS_CACHE . $key .'.'.$this->ext;
			
			$handle = fopen($file, 'w');
			fwrite($handle,($value));
			
			fclose($handle);
		}
		
		/**
		 *
		 */
		public function delete($key) {
			$files = glob(PAV_CSS_CACHE . $key . '.*');
			if ($files) {
				foreach ($files as $file) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}
		}
	}
?>