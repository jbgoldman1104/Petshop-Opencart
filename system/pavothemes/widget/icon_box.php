<?php
/******************************************************
 *  Leo Opencart Theme Framework for Opencart 2.0.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

class PtsWidgetIcon_box extends PtsWidgetPageBuilder {

		/**
		 *
		 */
		protected $max_image_size = 1048576;

		/**
		 *
		 */
		public $name = 'icon_box';
		public $group = 'others';
		public $usemeneu = false;
	    /**
		 *
		 */
		public static function getWidgetInfo()
		{
			return array('label' =>  ('Icon Box'), 'explain' => 'Create a block Icon Box', 'group' => 'others'  );
		}

		/**
		 *
		 */
		public function renderForm($args=null, $data)
		{
			$key = time();

			$helper = $this->getFormHelper();

		 	$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
                	array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon File'),
	                    'name'  => 'iconfile',
	                    'class' => 'imageupload',
	                    'default'=> '',
	                    'id'	 => 'iconfile'.$key,
	                    'desc'	=> 'Put image folder in the image folder ROOT_SHOP_DIR/image/'
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Class'),
	                    'name'  => 'iconclass',
	                    'class' => 'image',
	                    'default'=> '',
	                    'desc'	=> $this->l('Example: fa-umbrella fa-2 radius-x')
	                ),
	                array(
	                    'type' => 'textarea',
	                    'label' => $this->l('Content'),
	                    'name' => 'htmlcontent',
	                    'cols' => 40,
	                    'rows' => 20,
	                    'value' => '',
	                    'lang'  => true,
	                    'default'=> '',
	                    'autoload_rte' => false,
	                ),
	                array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Styles' ),
	                    'name' => 'icon_box_style',
	                    'options' => array(  'query' => array(
	                        array('id' => '', 'name' => $this->l('Feature Box')),
	                        array('id' => 'feature-box-v1', 'name' => $this->l('Feature box v1')),
                          	array('id' => 'light-style', 'name' => $this->l('Light style')),
                          	array('id' => 'feature-box-v2', 'name' => $this->l('Feature box v2')),
                          	array('id' => 'feature-box-v3', 'name' => $this->l('Feature box v3')),
                          	array('id' => 'feature-box-v4', 'name' => $this->l('feature box v4')),
                          	array('id' => 'feature-box-v5', 'name' => $this->l('feature box v5')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "",
	                ),
					array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Text Align' ),
	                    'name' => 'text_align',
	                    'options' => array(  'query' => array(
	                        array('id' => 'feature-box-left', 'name' => $this->l('Left')),
                          	array('id' => 'feature-box-right', 'name' => $this->l('Right')),
                          	array('id' => 'feature-box-center', 'name' => $this->l('Center')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "",
	                ),
	                array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Background Color' ),
	                    'name' => 'background',
	                    'options' => array(  'query' => array(
	                        array('id' => '', 'name' => $this->l('None')),
	                        array('id' => 'bg-primary', 'name' => $this->l('Primary')),
                          	array('id' => 'bg-info', 'name' => $this->l('Info')),
                          	array('id' => 'bg-danger', 'name' => $this->l('Danger')),
                          	array('id' => 'bg-warning', 'name' => $this->l('Warning')),
                          	array('id' => 'bg-success', 'name' => $this->l('Success')),
                          	array('id' => 'bg-purple', 'name' => $this->l('Purple')),
                          	array('id' => 'bg-red', 'name' => $this->l('Red')),
                          	array('id' => 'bg-orange', 'name' => $this->l('Orange')),
                          	array('id' => 'bg-yellow', 'name' => $this->l('Yellow')),
                          	array('id' => 'bg-default', 'name' => $this->l('Default')),
                          	array('id' => 'bg-darker', 'name' => $this->l('Darker')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "",
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
		public function renderContent($args, $setting)
		{

			$t  = array(
				'name'=> '',
				'iconfile'	=> '',
			 	'iconclass' => '',
			 	'linkurl' => '',
			 	'icon_box_style' => '',
			 	'text_align' => '',
			 	'htmlcontent' => '',
			 	'background' => '',
			 	'iconurl' => ''
			);

			$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? HTTPS_SERVER : HTTP_SERVER;
	        $url .= 'image/';
			$setting = array_merge( $t, $setting );
            $languageID = $this->config->get('config_language_id');
			$setting['htmlcontent'] = isset($setting['htmlcontent_'.$languageID])?($setting['htmlcontent_'.$languageID]): '';
			$settizng['linkurl'] = isset($setting['linkurl_'.$languageID])?($setting['linkurl_'.$languageID]): '';
			$setting['sub_title'] = isset($setting['widget_title_'.$languageID])?($setting['widget_title_'.$languageID]): '';

			if(!empty($setting['iconfile'])){
				$setting['iconurl'] = $url.$setting['iconfile'];
			}

			//d($setting);

			$output = array('type'=>'icon_box','data' => $setting );

	  		return $output;
		}


	}
?>