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

class PtsWidgetProduct_category extends PtsWidgetPageBuilder {

		public $name = 'product_category';
		public $group = 'product';
		
		public static function getWidgetInfo(){
			return array('label' => ('Products By Category ID'), 'explain' => 'Created Product List From Category ID', 'group' => 'opencart'  );
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
 

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Category ID'),
	                    'name'  => 'category_id',
	                    'default'=> 5,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> 8,
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

		private function getProducts( $results, $setting ){

			$data = array();

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['image_width'], $setting['image_height']);
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

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data[] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			return $data;
		}

		public function renderContent(  $args, $setting ) {
			
			$t  = array(
				'category_id'   => '',
				'limit'         => '4',
				'image_width'   => '200',
				'image_height'  => '200',
				'column'		=> 4,
			);
			$setting = array_merge( $t, $setting );

			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$setting['width']  = $setting['image_width'];
			$setting['height'] = $setting['image_height'];
			$setting['cols']   = $setting['column'];


			$this->load->model('catalog/product');
			$filter_data = array(
				'filter_category_id' => $setting['category_id'],
				'filter_filter'      => "",
				'sort'               => "p.sort_order",
				'order'              => "DESC",
				'start'              => 0,
				'limit'              => $setting['limit'],
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			$products = $this->getProducts($results, $setting);

			$setting['products'] = $products;

			$setting['products'] = $products;

			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$output = array('type'=>'products','data' => $setting );

			return $output;

		 
		}	
	}
?>