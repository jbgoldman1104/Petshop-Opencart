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

class PtsWidgetNewsletter extends PtsWidgetPageBuilder {

		public $name = 'newsletter';
		public $usemeneu = false;

		public static function getWidgetInfo(){
			return array('label' => ('Newsletter Form'), 'explain' => 'Create Newsletter Form Working With Newsletter Block.', 'group' => 'others'  );
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();

			$key = time();
			$types = array();
			$types[] = array('value' => 'newsletter-v1', 'text'  => $this->l('Newsletter v1'));
			$types[] = array('value' => 'newsletter-v2', 'text'  => $this->l('Newsletter v2'));
			$types[] = array('value' => 'newsletter-v3', 'text'  => $this->l('Newsletter v3'));
			$types[] = array('value' => 'newsletter-v4', 'text'  => $this->l('Newsletter v4'));
			$types[] = array('value' => 'newsletter-v6', 'text'  => $this->l('Newsletter v5'));
			$types[] = array('value' => 'newsletter-v7', 'text'  => $this->l('Newsletter v6'));
			$types[] = array('value' => 'newsletter-v8', 'text'  => $this->l('Newsletter v7'));

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
 					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Css Class'),
	                    'name'  => 'class',
	                    'default'=> "pavo-newsletter",
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Image File'),
	                    'name'  => 'imagefile',
	                    'class' => 'imageupload',
	                    'default'=> '',
	                    'id'	 => 'imagefile'.$key,
	                    'desc'	=> 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
	                ),
	                array(
	                    'type' => 'textarea',
	                    'label' => $this->l('Information'),
	                    'name' => 'information',
	                    'cols' => 20,
	                    'rows' => 10,
	                    'value' => true,
	                    'lang'  => true,
	                    'default'=> 'Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!',
	                    'autoload_rte' => true,
	                ),
					array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Style' ),
	                    'name' 	  => 'newsletter_style',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "style1"
	                ),
	            ),
	      		 'submit' => array(
	                'title' => $this->l('Save'),
	                'class' => 'button'
           		 )
	        );


		 	$default_lang = (int)$this->config->get('config_language_id');

			$helper->tpl_vars = array(
	                'fields_value' => $this->getConfigFieldsValues( $data  ),
	                'id_language' => $default_lang
        	);

			$this->load->model('tool/image');
			$this->model_tool_image->resize('no_image.png', 100, 100);
			$placeholder  = $this->model_tool_image->resize('no_image.png', 100, 100);

			$string = '

				<script type="text/javascript">
					$(".imageupload").WPO_Gallery({key:"'.$key.'",gallery:false,placehold:"'.$placeholder.'",baseurl:"'.HTTP_CATALOG . 'image/'.'" } );
				</script>

			';
			return  '<div id="imageslist'.$key.'">'.$helper->generateForm( $this->fields_form ) .$string."</div>" ;
		}

		public function renderContent( $args, $setting ){
			$t = array(
				'newsletter_style' => "newsletter-v1",
				'class' => "pts-newsletter",
				'imagefile'=> ''
			);
			$setting = array_merge( $t, $setting );

			$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? HTTPS_SERVER : HTTP_SERVER;
	        $url .= 'image/';

			$languageID = $this->config->get('config_language_id');
			$setting['information']= isset($setting['information_'.$languageID])?html_entity_decode($setting['information_'.$languageID],ENT_QUOTES,'UTF-8'): '';

			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$setting['background'] = $url.''.$setting['imagefile']	;

			$output = array('type'=>'newsletter','data' => $setting );

			return $output;
		}

	}
?>