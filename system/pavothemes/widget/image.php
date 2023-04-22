<?php 
/******************************************************
 *  Leo Opencart Theme Framework for Opencart 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

class PtsWidgetImage extends PtsWidgetPageBuilder {
		
		/**
		 *
		 */
		protected $max_image_size = 1048576;

		/**
		 *
		 */
		public $name = 'image';
		public $group = 'image';
		/**
		 *
		 */
		public function beforeAdminProcess( $controller ){
			if( !Tools::getValue('widgetaction') ){ 
				$controller->addJS( __PS_BASE_URI__.'modules/ptspagebuilder/assets/admin/image_gallery.js' );
			}

		}


	    /**
		 *
		 */
		public static function getWidgetInfo(){
			return array('label' =>  ('Single Image'), 'explain' => 'Create Images Mini Gallery From Folder', 'group' => 'image'  );
		}

		/**
		 *
		 */
		public function renderForm( $args, $data ){

			$key = time();

			$helper = $this->getFormHelper();
		 	$soption = array(
	            array(
	                'id' => 'active_on',
	                'value' => 1,
	                'label' => $this->l('Enabled')
	            ),
	            array(
	                'id' => 'active_off',
	                'value' => 0,
	                'label' => $this->l('Disabled')
	            )
	        );




		 	$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
                	array(
	                    'type'  => 'text',
	                    'label' => $this->l('Image File'),
	                    'name'  => 'imagefile',
	                    'class' => 'imageupload',
	                    'default'=> '',
	                    'id'	 => 'imagefile'.$key,
	                    'desc'	=> 'Put image folder in the image folder ROOT_SHOP_DIR/image/'
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Image size'),
	                    'name'  => 'size',
	                    'class' => 'image',
	                    'default'=> '',
	                    'id'	 => 'imagesize'.$key	,
	                    'desc'	=> "Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size."
	                ),
	                 array(
	                    'type' => 'select',
	                    'label' => $this->l( 'CSS3 Animation' ),
	                    'name' => 'animation',
	                    'options' => array(  'query' => array(
	                        array('id' => '1', 'name' => $this->l('1 Column')),
	                        array('id' => '2', 'name' => $this->l('2 Columns')),
                          	array('id' => '3', 'name' => $this->l('3 Columns')),
                            array('id' => '4', 'name' => $this->l('4 Columns')),
                            array('id' => '5', 'name' => $this->l('5 Columns')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "4",
	                 ),
	                  array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Image Alignment' ),
	                    'name' => 'alignment',
	                    'desc'  => 'Select image alignment',
	                    'options' => array(  'query' => array(
	                        array('id' => 'left', 'name' => $this->l('Align Left')),
	                        array('id' => 'right', 'name' => $this->l('Align Right')),
                          	array('id' => 'center', 'name' => $this->l('Align Center'))
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "left",
	                 ),

	                array(
	                    'type' => 'switch',
						'label' => $this->l('Enable Popup Image'),
						'desc' => $this->l('Show the original image on a modal box'),
						'name' => 'ispopup',
						'default'=>1,
						'values' => $soption,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Link'),
	                    'name'  => 'link',
	                    'class' => 'link',
	                    'default'=> '',
	                    'id'	 => 'link'.$key,
	                    'desc'	=> 'Enter url if you want this image to have link'
	                ),
	            ),
	      		 'submit' => array(
	                'title' => $this->l('Save'),
	                'class' => 'button'
           		 )
	        );

		 	$default_lang = (int)$this->config->get('config_language_id');
			
			$helper->tpl_vars = array(
	                'fields_value' => $this->getConfigFieldsValues( $data ),
	                
	                'id_language' => $default_lang
        	);  

			$this->load->model('tool/image');
			$this->model_tool_image->resize('no_image.png', 100, 100);
			$placeholder  = $this->model_tool_image->resize('no_image.png', 100, 100);
		//	d( $this->token );
			$string = ' 


		 
					 <script type="text/javascript">
						$(".imageupload").WPO_Gallery({key:"'.$key.'",gallery:false,placehold:"'.$placeholder.'",baseurl:"'.HTTP_CATALOG . 'image/'.'" } );
					</script>
		 
			';
			return  '<div id="imageslist'.$key.'">'.$helper->generateForm( $this->fields_form ) .$string."</div>" ;

		}
 	
		 
 		/**
		 *
		 */
		public function renderContent(  $args, $setting ){
			$t  = array(
				'name'=> '',
				'image'	=> '',
			 	'imagesize' => '200x200',
			 	'alignment' => '',
			 	'animation' => '',
			 	'ispopup' 	=> '1',
			 	'imageurl'  => '',
			);


			$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? HTTPS_SERVER : HTTP_SERVER;
	        $url .= 'image/'; 


			$setting = array_merge( $t, $setting );
			 
			$size = explode( "x", $setting['size'] );

			 
			$setting['thumbnailurl'] = $url.$setting['imagefile'];
			$setting['imageurl'] = $url.$setting['imagefile'];
		
			if( count($size) == 2 ){
			 	$this->load->model('tool/image'); 
				$setting['thumbnailurl']= $this->model_tool_image->resize( $setting['imagefile'], (int)$size[0], (int)$size[1],'w');
			}

			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$output = array('type'=>'image','data' => $setting );
	  		return $output;
		}
		

	}
?>