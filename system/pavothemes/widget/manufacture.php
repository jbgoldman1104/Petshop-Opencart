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

class PtsWidgetManufacture extends PtsWidgetPageBuilder {

		public $name = 'manufacture';
		public $usemeneu = false;
		
		public static function getWidgetInfo(){
			return  array('label' => ('Manufacture Logos'), 'explain' => 'Manufacture Logo', 'group' => 'opencart'  ) ;
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
 
			$this->load->model('design/banner');

			$banners = $this->model_design_banner->getBanners();


			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	            	 array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Banner Group' ),
	                    'name' => 'target',
	                    'options' =>  array( 'query'=>$banners,
	                    'id' => 'banner_id',
	                    'name' => 'name' ),
	                    'default' => 8,
	                 ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> 12,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Column'),
	                    'name'  => 'columns',
	                    'default'=> 6,
	                ),
	                 array(
	                    'type'  => 'text',
	                    'label' => $this->l('Items Per Page'),
	                    'name'  => 'itemsperpage',
	                    'default'=> 6,
	                ),

	                 array(
	                    'type'  => 'text',
	                    'label' => $this->l('width'),
	                    'name'  => 'width',
	                    'default'=> 170,
	                ),
	                 array(
	                    'type'  => 'text',
	                    'label' => $this->l('height'),
	                    'name'  => 'height',
	                    'default'=> 59,
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


			return  $helper->generateForm( $this->fields_form );

		}

		public function renderContent( $args, $setting ){
			$t  = array(
				'name'			=> '',
				'html'  	 	=> '',
				'columns'		=> 6,
				'itemsperpage'	=> 6,
				'widgetid'		=> 'manu-'.time(),
				'banner_id'     => 8,
				'width'	        => 120,
				'height'	    => 75
 
			);
			$setting = array_merge( $t, $setting );
			

			$this->load->model('design/banner');
			$this->load->model('tool/image');
			$this->language->load('extension/module/pavcarousel');
		 

			$results = $this->model_design_banner->getBanner($setting['target']);

			$banners = array();
			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
					$banners[] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
					);
				}
			}

			$setting['banners'] = $banners;

			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$output = array('type'=>'manufacture','data' => $setting );


			return $output;
		} 

	}
?>