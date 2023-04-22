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

class PtsWidgetProduct_specials extends PtsWidgetPageBuilder {

		public $name = 'product_specials';
		public $group = 'product';
		public $usemeneu = false;

		public static function getWidgetInfo(){
			return array('label' =>  ('Product special carousel'), 'explain' => 'Dislay product special carousel', 'group' => 'product'  );
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();
			$types = array();


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
	                    'type'    => 'text',
	                    'label'   => $this->l('Limit'),
	                    'name'    => 'limit',
	                    'default' => 6,
	                ),
	     			array(
	                    'type'  => 'text',
	                    'label' => $this->l('Column'),
	                    'name'  => 'column',
	                    'default'=> 4,
	                    'desc'	=> $this->l('Show In Carousel with N Column in each page')
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Items Per Page'),
	                    'name'  => 'itemsperpage',
	                    'default'=> 4,
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Special'),
	                    'name'  => 'icon_special',
	                    'default'=> 'fa-star',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
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
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Auto play'),
	                    'name'  => 'auto_play',
	                    'default'=> 3000,
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


		private function getProducts( $results, $setting ){

			$products = array();

			$themeConfig = $this->config->get('themecontrol');

			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
					// Image Attribute for product

				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}



				$products[] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'description'=> (html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					'thumb2'     => isset($thumb2)?$thumb2:'',
				);
			}
			return $products;
		}

		/**
		 *
		 */
		public function renderContent( $args, $setting ){


			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			$this->language->load('extension/module/pavproducttabs');

			$t = array(
				'list_type'=> '',
				'limit' => 8,
				'image_width'=>'200',
				'image_height' =>'200',
				'itemsperpage'	=> 4,
				'column'		=> 4,
			);

			$products = array();
			$setting = array_merge( $t, $setting );
			$data = array(
				'sort'  => 'p.date_added',
				'order' => 'DESC',
				'start' => 0,
				'limit' => $setting['limit']
			);


			$setting['cols'] = $setting['column'];


			$setting['specials'] = $this->getProducts( $this->model_catalog_product->getProductSpecials( $data ), $setting );

			//echo "<pre>".print_r($setting['specials'],1);die;

			$languageID = $this->config->get('config_language_id');

			$setting['objlang'] = $this->language;

			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$output = array('type'=>'product_specials','data' => $setting );

			return $output;
		}
	}
?>