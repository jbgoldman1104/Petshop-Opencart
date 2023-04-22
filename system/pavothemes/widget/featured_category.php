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

class PtsWidgetFeatured_category extends PtsWidgetPageBuilder {

		public $name = 'featured_category';
		public $group = 'product';
		public $usemeneu = false;

		public static function getWidgetInfo(){
			return array('label' => ('Featured Category'), 'explain' => 'Featured Category List', 'group' => 'product'  );
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
			
			
			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	            	array(
	                    'type'  => 'featured-category',
	                    'label' => $this->l(''),
	                    'name'  => 'categories_featured',
	                    'default'=> '',
	                    'desc'	=> 'Add List Featured Category',
	                ),
					// width && height
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Width'),
	                    'name'  => 'image_width',
	                    'default'=> 200,
	                    'desc'	=> '',
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Height'),
	                    'name'  => 'image_height',
	                    'default'=> 200,
	                    'desc'	=> '',
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

		public function renderContent(  $args, $setting ){
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->language('extension/module/themecontrol');
			$default = array(
					'widget_name' => '',
					'show_title' => 1,
					'addition_cls' => '',
					'image_width' => 200,
					'image_height' => 200,
					'categories_featured' => array(),
				);
			$setting = array_merge( $default, $setting );

			$categories = isset($setting['categories_featured']) ? $setting['categories_featured'] : array();

			$data = array();
			foreach ($categories as $category) {
                //toDo Custom changies
			    if($category['id'] == 20){
                    $category['id'] = 15;
                }
                if($category['id'] == 18){
                    $category['id'] = 13;
                }
                if($category['id'] == 25){
                    $category['id'] = 35;
                }
                if($category['id'] == 57){
                    $category['id'] = 52;
                }
                if($category['id'] == 24){
                    $category['id'] = 1;
                }
				$filter_data = $this->model_catalog_category->getCategory($category['id']);

				$datap = array(
					'filter_category_id'  => $filter_data['category_id'], 
					'filter_sub_category' => true
				);
				$product_total = $this->model_catalog_product->getTotalProducts($datap);

				$data[] = array(
					'items' => $product_total." ".$this->language->get('text_items'),
					'image' => $category['image'],
					'thumb' => $this->model_tool_image->resize($category['image'], 30, 30),
					'category_id' => $filter_data['category_id'], 
					'name' => $filter_data['name'], 
					'href' => $this->url->link('product/category', 'path=' . $filter_data['category_id']),
				);
			}

			$setting['categories'] = $data;

			$languageID = $this->config->get('config_language_id');
        	$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			
			$output = array('type'=>'image','data' => $setting );

	  		return $output;
		}
	}
?>