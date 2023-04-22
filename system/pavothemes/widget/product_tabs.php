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

class PtsWidgetProduct_tabs extends PtsWidgetPageBuilder {

		public $name = 'product_tabs';
		public $group = 'product';
		public $usemeneu = false;
		
		public static function getWidgetInfo(){
			return array('label' =>  ('Product Tabs'), 'explain' => 'Dislay Tabs: Newest, Bestseller, Special, Featured', 'group' => 'product'  );
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
	                    'label' => $this->l('Icon Newest'),
	                    'name'  => 'icon_newest',
	                    'default'=> 'fa fa-umbrella fa-2 ',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
	                array(
	                    'type' 	  => 'switch',
	                    'label'   => $this->l( 'Enable Newest' ),
	                    'name' 	  => 'enable_newest',
	                    'values'  => $soption,
	                    'default' => "1",
	                    'desc'    => $this->l( 'Whethere to display Newest Products' )
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Featured'),
	                    'name'  => 'icon_featured',
	                    'default'=> 'fa-leaf',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Enter ID product featured'),
	                    'name'  => 'product_id',
	                    'default'=> '42,44,47,48',
	                    'desc'	=> 'Please enter ID products featured. Ex:42,44,47,48',
	                ),
	                 array(
	                    'type' 	  => 'switch',
	                    'label'   => $this->l( 'Enable Featured' ),
	                    'name' 	  => 'enable_featured',
	                    'values'  => $soption,
	                    'default' => "0",
	                    'desc'    => $this->l( 'Whethere to display featured Products' )
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Bestseller'),
	                    'name'  => 'icon_bestseller',
	                    'default'=> 'fa-paper-plane-o',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
	                  array(
	                    'type' 	  => 'switch',
	                    'label'   => $this->l( 'Enable Bestseller' ),
	                    'name' 	  => 'enable_bestseller',
	                    'values'  => $soption,
	                    'default' => "1",
	                    'desc'    => $this->l( 'Whethere to display Bestseller Products' )
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Special'),
	                    'name'  => 'icon_special',
	                    'default'=> 'fa-star',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
	                   array(
	                    'type' 	  => 'switch',
	                    'label'   => $this->l( 'Enable Special' ),
	                    'name' 	  => 'enable_special',
	                    'values'  => $soption,
	                    'default' => "1",
	                    'desc'    => $this->l( 'Whethere to display Special Products' )
	                ),
					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Icon Mostviews'),
	                    'name'  => 'icon_mostviews',
	                    'default'=> 'fa-star',
	                    'desc'	=> $this->l('Please enter icon from font-awesome')
	                ),
	                   array(
	                    'type' 	  => 'switch',
	                    'label'   => $this->l( 'Enable Mostviews' ),
	                    'name' 	  => 'enable_mostviews',
	                    'values'  => $soption,
	                    'default' => "1",
	                    'desc'    => $this->l( 'Whethere to display Mostviews Products' )
	                ),
					array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Tabs Styles' ),
	                    'name' => 'tabsstyle',
	                    'desc'  => 'Select type display tabs',
	                    'options' => array(  'query' => array(
	                        array('id' => 'tab-v1', 'name' => $this->l('Tabs Horizontal v1')),
	                        array('id' => 'tab-v2', 'name' => $this->l('Tabs Left')),
	                        array('id' => 'tab-v2-r', 'name' => $this->l('Tabs Right')),
	                        array('id' => 'tab-v3', 'name' => $this->l('Tabs Horizontal v2')),
	                        array('id' => 'tab-v4', 'name' => $this->l('Tabs Horizontal v3')),
	                        array('id' => 'tab-v5', 'name' => $this->l('Tabs Horizontal v4')),
	                        array('id' => 'tab-v6', 'name' => $this->l('Tabs Horizontal v5')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "tabs-v1",
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
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')) , $this->session->data['currency']);
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')) , $this->session->data['currency']);
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


		private function getFeatured($products_id, $setting){
		
			$products = array();
			
			$id_products = explode( ",", $products_id );
			
			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			if($id_products){
				foreach ($id_products as $id_product) {
					$result = $this->model_catalog_product->getProduct( $id_product );

					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
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
						'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
						'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);
					
				}
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
				'enable_special' => '1',
				'enable_bestseller' => '1',
				'enable_featured' => '0',
				'enable_newest' => '1',
				'mostviewed'    => 1,
				'itemsperpage'	=> 4,
				'column'		=> 4,
			);

			$products = array();
			$setting = array_merge( $t, $setting );

			// THEME CONFIG
			$setting['objlang'] = $this->registry->get('language');
			$setting['ourl'] = $this->registry->get('url');

			$config = $this->registry->get("config");
			$setting['sconfig'] = $config;
			$setting['themename'] = $config->get("theme_default_directory");
			
			$data = array(
				'sort'  => 'p.date_added',
				'order' => 'DESC',
				'start' => 0,
				'limit' => $setting['limit']
			);

			
			$tabs = array(
				'latest' 	 => array(),
				'featured'   => array( ),
				'bestseller' => array(),
				'special'   => array(),
				'mostviewed' => array()
			);	
			$setting['cols'] = $setting['column'];
			
	 		if($setting['enable_featured'] && $setting['product_id']){
				$tabs['featured'] = $this->getFeatured( $setting['product_id'], $setting );
			}
			if($setting['enable_newest']){ 
				$tabs['latest'] = $this->getProducts( $this->model_catalog_product->getProducts( $data ), $setting );
		 	}
			if($setting['enable_bestseller']){
				$tabs['bestseller'] = $this->getProducts( $this->model_catalog_product->getBestSellerProducts( $data['limit'] ), $setting );
		 	}
			if($setting['enable_special']){
				$tabs['special'] = $this->getProducts( $this->model_catalog_product->getProductSpecials( $data ), $setting );
			}
			if($setting['enable_mostviews']){
				$data['sort'] = 'p.viewed';
				$tabs['mostviewed'] = $this->getProducts( $this->model_catalog_product->getProducts( $data ), $setting );
			}

		
			$setting['tabs'] = $tabs;
			//echo "<pre>".print_r($setting,1);die;

			$languageID = $this->config->get('config_language_id');
			
			$setting['objlang'] = $this->language;
			
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';
			 
			$output = array('type'=>'product_tabs','data' => $setting );
 
			return $output;
		}
	}
?>