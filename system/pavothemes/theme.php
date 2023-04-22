<?php 
	/******************************************************
	 * @package Pav Opencart Theme Framework for Opencart 1.5.x
	 * @version 3.0
	 * @author http://www.pavothemes.com
	 * @copyright	Copyright (C) April 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
	 * @license		GNU General Public License version 2
	*******************************************************/

	class PavoThemeHelper{
		
		/**
		 * get list of local fonts 
		 */
		public static  function getLocalFonts(){
			return array(
				array( 'Verdana, Geneva, sans-serif', 'Verdana'),
				array( 'Georgia, "Times New Roman", Times, serif', 'Georgia'),
				array( 'Arial, Helvetica, sans-serif', 'Arial'),
				array( 'Impact, Arial, Helvetica, sans-serif', 'Impact'),
				array( 'Tahoma, Geneva, sans-serif', 'Tahoma'),
				array( '"Trebuchet MS", Arial, Helvetica, sans-serif', 'Trebuchet MS'),
				array( '"Arial Black", Gadget, sans-serif', 'Arial Black'),
				array( 'Times, "Times New Roman", serif', 'Times'),
				array( '"Palatino Linotype", "Book Antiqua", Palatino, serif', 'Palatino Linotype'),
				array( '"Lucida Sans Unicode", "Lucida Grande", sans-serif', 'Lucida Sans Unicode'),
				array( '"MS Serif", "New York", serif', 'MS Serif'),
				array( '"Comic Sans MS", cursive', 'Comic Sans MS'),
				array( '"Courier New", Courier, monospace', 'Courier New'),
				array( '"Lucida Console", Monaco, monospace', 'Lucida Console')
			);
		}

		/**
		 *
		 */
		public static function getThemeInfo( $theme ){

			$xml =     DIR_CATALOG . 'view/theme/'.$theme.'/development/info.xml'; ;

	        $output = array();
	        if( file_exists($xml) ){
	       		$info = simplexml_load_file( $xml );
	       		$output = (array)$info;	 
	       	}
	       	$data = array(
	       		'guide' 	  => '',
	       		'name' 	      => '',
	       		'update'      => '',
	       		'description' => '',
	       		'support'	  => '',
	       		'guide'		  => ''
	       	);
	       	return array_merge( $data, $output );
		}

		/**
		 *
		 */
		public static function getFontSizes(){
			 return array(9,10,11,12,13,14,15,16,17,18,19,20);
		}

		/**
		 *
		 */
		public static function getThemeEditor( $theme ){

 			$customizeXML =  DIR_CATALOG . 'view/theme/'.$theme.'/development/customize/themeeditor.xml';
	 		$output = array( 'selectors' => array(), 'elements' => array() );

	 		if( file_exists($customizeXML) ){
				$info = simplexml_load_file( $customizeXML );
				if( isset($info->selectors->items) ){
					foreach( $info->selectors->items as $item ){
						$vars = get_object_vars($item);
						if( is_object($vars['item']) ){
							$tmp = get_object_vars( $vars['item'] );
							$vars['selector'][] = $tmp;
						}else {
							foreach( $vars['item'] as $selector ){
								$tmp = get_object_vars( $selector );
								if( is_array($tmp) && !empty($tmp) ){
									$vars['selector'][] = $tmp;
								}
							}
						}
						unset( $vars['item'] );
						$output['selectors'][$vars['match']] = $vars;
					}
				}

				if( isset($info->elements->items) ){
					foreach( $info->elements->items as $item ){
						$vars = get_object_vars($item);
						if( is_object($vars['item']) ){
							$tmp = get_object_vars( $vars['item'] );
							$vars['selector'][] = $tmp;
						}else {
							foreach( $vars['item'] as $selector ){
								$tmp = get_object_vars( $selector );
								if( is_array($tmp) && !empty($tmp) ){
									$vars['selector'][] = $tmp;
								}
							}
						}
						unset( $vars['item'] );
						$output['elements'][$vars['match']] = $vars;
					}
				}
			}
			return $output;
		}

		/**
		 *
		 */
		public static function getInternalModules( $theme ){

			$xml = DIR_CATALOG . 'view/theme/'.$theme.'/development/customize/theme.xml';
	        $output = array(); 
	        if( file_exists($xml) ){ 
	            $info = simplexml_load_file( $xml );
	            foreach( $info as $group => $element ){
	            	$element = (array) $element;
	            	$element['description'] = (string) $element['description'];
	            	foreach( $element['module']  as $key => $module ){
	         
	            		$element['module'][$key] =  $module;
	            	}
	            	$output[$group] = $element;
	            }
	        }
	        return $output;
		}	


		/**
		 * 
		 */
		public static function getSkins( $theme ){
			$output = array();
 
			$directories = glob(DIR_CATALOG . 'view/theme/'.$theme.'/stylesheet/skins/*.css');

			if(isset($directories) && !empty($directories)){
				foreach( $directories as $dir ){
					$output[] = str_replace(".css","",basename( $dir ));
				}
			}
  
			return $output;
		}

		/**
		 *
		 */
		public static function writeToCache( $folder, $file, $value, $e='css' ){
			$file = $folder  . preg_replace('/[^A-Z0-9\._-]/i', '', $file).'.'.$e ;
			$handle = fopen($file, 'w');
	    	fwrite($handle, ($value));
			
	    	fclose($handle);

		}


		/**
		 *
		 */
		public static function getLayoutSettingByTheme( $theme ){
 
		    $xml = DIR_CATALOG . 'view/theme/'.$theme.'/development/customize/layout.xml';

	        $output = array();

	        if( file_exists($xml) ){
	            $info = simplexml_load_file( $xml );

	          
	            if( isset($info->layout) ){
	                foreach( $info->layout as $layouts ){
	                    $vars = get_object_vars($layouts);

	                    if( is_object($vars['item']) ){
	                   
	                        $tmp = get_object_vars( $vars['item'] );
	                        $block = $tmp['block'];
	                        if( is_object($tmp['option'])){
                        	 	$options = $tmp['option']; 
                        	 	$tmp['option'] = array();
                        	 	$tmp['option'][] = get_object_vars( $options );
                        	 }
                        	 else {
                        	 	foreach( $tmp['option'] as $key => $o ){
                        	 		$tmp['option'][$key] = get_object_vars( $o );
                        	 	}
                        	 }
                        	 unset( $tmp['block'] );
	                        $vars['layout'][$block] = $tmp;
	                    }else {
	                        foreach( $vars['item'] as $selector ){
	                            $tmp = get_object_vars( $selector );

	                            
	                            if( is_array($tmp) && !empty($tmp) ){
	                            	$block = $tmp['block'];
	                            	 unset($tmp['block']);
	                            	 if( is_object($tmp['option'])){
	                            	 	$options = $tmp['option']; 
	                            	 	$tmp['option'] = array();
	                            	 	$tmp['option'][] = get_object_vars( $options );
	                            	 }else {
	                            	 	foreach( $tmp['option'] as $key => $o ){
	                            	 		$tmp['option'][$key] = get_object_vars( $o );
	                            	 	}
	                            	 }
	                            	 
	                                $vars['layout'][$block] = $tmp;
	                            }
	                        }
	                    }
	                    unset( $vars['item'] );
	                    $output = $vars;
	                }
	            }
	        }
	        return $output;
	    }


		/**
		 *
		 */
		public static function getFileList( $path , $e=null ) {
			$output = array(); 
			$directories = glob( $path.'*'.$e );
			foreach( $directories as $dir ){
				$output[] = basename( $dir );
			}			
			 
			return $output;
		}

		/**
		 * 
		 */
		public static function getPattern( $theme ){
			$output = array();
			if( $theme && is_dir(DIR_CATALOG . 'view/theme/'.$theme.'/image/pattern/') ) {
				$files = glob(DIR_CATALOG . 'view/theme/'.$theme.'/image/pattern/*');
				if(isset($files) && !empty($files)){
					foreach( $files as $dir ){
						if( preg_match("#.png|.jpg|.gif#", $dir)){
							$output[] = str_replace("","",basename( $dir ) );
						}
					}
				}			
			}
			return $output;
		}


		public static function getPathProfileBySkin( $theme, $skin ){
			return  DIR_CATALOG . 'view/theme/'.$theme.'/development/profiles/'.$skin.'.txt'; 
		}
	}
?>