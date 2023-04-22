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

class PtsWidgetProduct_deal extends PtsWidgetPageBuilder {

		public $name = 'product_deal';
		public $group = 'opencart';
		public $usemeneu = false;
		
		public static function getWidgetInfo(){
			return array('label' => ('Product Deal'), 'explain' => 'Play Countdown in ProductSales', 'group' => 'opencart'  );
		}


		public function renderForm( $args, $data ){

			$this->load->model('catalog/category');
			$categories = $this->model_catalog_category->getCategories(array());
 			//echo "<pre>"; print_r($categories); die;

			$helper = $this->getFormHelper();

			// get all categories


			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	            	// date
					array(
						'type'  => 'date',
						'label' => $this->l('Start Date'),
						'name'  => 'start_date',
						'default'=> '',
					),
					array(
						'type'  => 'date',
						'label' => $this->l('End Date'),
						'name'  => 'end_date',
						'default'=> '',
					),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> 2,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Columns'),
	                    'name'  => 'cols',
	                    'default'=> 1,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Item Per Page'),
	                    'name'  => 'itemsperpage',
	                    'default'=> 1,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Width'),
	                    'name'  => 'img_width',
	                    'default'=> 200,
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Height'),
	                    'name'  => 'img_height',
	                    'default'=> 200,
	                ),
					//select-multipleay(
					array(
						'type'  => 'select-multiple',
						'label' => $this->l('Choose category'),
						'name'  => 'category_ids',
						'options' => $categories,
						'default'=> '',
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

			$this->load->model('tool/image');
			$this->load->model( 'pavdeals/product' );
			$this->load->model( 'catalog/product' );
			$this->language->load('extension/module/themecontrol');

			// Heading title
			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$t  = array(
				'limit'        => '4',
				'cols'         => '1',
				'itemsperpage' => '1',
				'img_width'    =>'200',
				'img_height'   =>'200',
				'start_date'   => '0000-00-00',
				'end_date'     => date("Y-m-d"),
				'category_ids' => array(),
			);
			$setting = array_merge( $t, $setting );

			// THEME CONFIG
			$setting['objlang'] = $this->registry->get('language');
			$setting['ourl'] = $this->registry->get('url');
			$config = $this->registry->get("config");
			$setting['sconfig'] = $config;
			$setting['themename'] = $config->get("theme_default_directory");			

			$products = array();

			$sorting = isset($setting['sort_deals'])?$setting['sort_deals']:'p.date_added__desc';
			$tmp = explode("__",$sorting);
			$data = array(  
							'start_date' => $setting['start_date'],
							'to_date'    => $setting['end_date'],
							'sort'       => $tmp[0],
							'order'      => $tmp[1],
							'start'      => 0,
							'limit'      => $setting['limit'],
							'filter_categories' => $setting['category_ids']
			);

			$results = $this->model_pavdeals_product->getProductSpecials($data);
			$products = array();

			foreach ($results as $result) {
				$products[] = $this->getItemDeal($result, $setting);
			}
			$setting['products'] = $products;

			
			

			$output = array('type'=>'products','data' => $setting );
			return $output;
		}

		public function getItemDeal($product = null, $setting = array()){

			if(is_numeric($product)){
				$product = $this->model_catalog_product->getProduct((int)$product);
			}
			$deal = $this->model_pavdeals_product->getDeal($product);
			
			if(!$deal)
				 return false;

			$order_status_id = isset($setting['order_status_id'])?(int)$setting['order_status_id']:5;
			$bought = $this->model_pavdeals_product->getTotalBought($deal['product_id'], $order_status_id );
			$bought = empty($bought)?0:$bought;
			$save_price = (float)$deal['price'] - (float)$deal['special'];
			$discount = round(($save_price/$deal['price'])*100);
			$save_price = $this->currency->format($this->tax->calculate($save_price, $deal['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			
			if ($deal['image'] && isset($setting['img_width']) && $setting['img_height']) {
				$image = $this->model_tool_image->resize($deal['image'], $setting['img_width'], $setting['img_height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($deal['price'], $deal['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$price = false;
			}
					
			if ((float)$deal['special']) {
				$special = $this->currency->format($this->tax->calculate($deal['special'], $deal['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				$saleoff = floor((($deal['price']-$deal['special'])/$deal['price'])*100);
			} else {
				$special = false;
			}

			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$deal['special'] ? $deal['special'] : $deal['price'], $this->session->data['currency']);
			} else {
				$tax = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $deal['rating'];
			} else {
				$rating = false;
			}
			$date_end_string = isset($deal['date_end'])?$deal['date_end']:"";

			$product = array(
				'product_id' => $deal['product_id'],
				'deal_discount' 	 => $discount,
				'bought'	 => $bought,
				'thumb'   	 => $image,
				'name'    	 => $deal['name'],
				'tax'        => $tax,
				'quantity'	 => $deal['quantity'],
				'price'   	 => $price,
				'special' 	 => $special,
				'saleoff' 	 => isset($saleoff)?$saleoff.'%':0,
				'rating'     => $rating,
				'save_price' => $save_price,
				'date_end_string' => $date_end_string,
				'date_end'	 => explode("-", $date_end_string),
				
				'description' => utf8_substr(strip_tags(html_entity_decode($deal['description'], ENT_QUOTES, 'UTF-8')), 0, 230),
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$deal['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $deal['product_id']),
			);


			return $product;
		}
		public function pavdeal($product = null){
			static $module = 0;
			/*If current page is product detail, show deal item*/
			$route = isset($this->request->get['route'])?$this->request->get['route']:"";
			$is_product_detail = false;
			if($route == "product/product"){
				if(empty($product))
					$product = isset($this->request->get['product_id'])?$this->request->get['product_id']:"0";
				
				$is_product_detail = true;
			}
			
			/*End if*/
			if(empty($product)) 
				return;
			$this->load->language('extension/module/pavdeals');
			$this->load->model('tool/image');
			$this->load->model( 'pavdeals/product' );
			$this->load->model( 'catalog/product' );
			$default = $this->model_pavdeals_product->getDefaultSetting();

			$setting = $this->config->get("pavdeals_config");
			if(is_numeric($product)){
				$product = $this->model_catalog_product->getProduct((int)$product);
			}
			if(!empty($setting)){
				$setting = array_merge($default, $setting);
			}else{
				$setting = $default;
			}
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	         	$this->mdata['base'] = $this->config->get('config_ssl');
		    } else {
		        $this->mdata['base'] = $this->config->get('config_url');
		    }
			$theme = isset($setting['theme'])?$setting['theme']:"default";
			if(!defined("PAVDEALS_LOADED_ASSETS")){
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/pavdeals.css')) {
					$this->mdata['style'] = 'catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/pavdeals.css';
				} else {
					$this->mdata['style'] = 'catalog/view/theme/default/stylesheet/pavdeals.css';
				}
				$this->mdata['script'] = 'catalog/view/javascript/pavdeals/countdown.js';
				define("PAVDEALS_LOADED_ASSETS", 1);
			}	

			if($is_product_detail){
				$this->mdata['saleoff_icon'] = $this->model_tool_image->resize( $setting['saleoff_icon'], $setting['icon_width'], $setting['icon_height']);
			}

			$this->mdata['module'] = "deal".$module++;
			$this->mdata['product'] = $this->getItemDeal($product, $setting);

			if($is_product_detail){
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/pavdeals/product_deal_detail.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/extension/module/pavdeals/product_deal_detail.tpl';
				} else {
					$this->template = 'default/template/extension/module/pavdeals/product_deal_detail.tpl';
				}
				$output = $this->render();
			}else{
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/pavdeals/item_deal.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/extension/module/pavdeals/item_deal.tpl';
				} else {
					$this->template = 'default/template/extension/module/pavdeals/item_deal.tpl';
				}
				$output = $this->render();
			}
			return $output;
		}


	}
?>