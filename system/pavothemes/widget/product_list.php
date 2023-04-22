<?php 
class PtsWidgetProduct_list extends PtsWidgetPageBuilder {

		public $name = 'product_list';
		public $group = 'product';
		
		public static function getWidgetInfo(){
			return array('label' =>  ('Product List'), 'explain' => 'Product List With Option: Special, Latest, Popular, Bestseller,  Featured, Top Rating', 'group' => 'opencart'  );
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();

			$products = (isset($data['params']['product']) && $data['params']['product']) ? $data['params']['product'] : array();
			$list_product = array();
			if($products){
				$this->load->model('catalog/product');
				foreach($products as $id_product){
					$product = $this->model_catalog_product->getProduct($id_product);
					$list_product[$id_product] = 	$product['name'];
				}
			}

			$types = array();	

		 	$types[] = array(
		 		'value' => 'special',
		 		'text'  => $this->l('Products Special')
		 	);
		 	$types[] = array(
		 		'value' => 'latest',
		 		'text'  => $this->l('Products Latest')
		 	);
		 	$types[] = array(
		 		'value' => 'popular',
		 		'text'  => $this->l('Products Popular')
		 	);
		 	$types[] = array(
		 		'value' => 'bestseller',
		 		'text'  => $this->l('Products Bestseller')
		 	);

		 	$types[] = array(
		 		'value' => 'featured',
		 		'text'  => $this->l('Products Featured')
		 	);
		 	$types[] = array(
		 		'value' => 'toprating',
		 		'text'  => $this->l('Products TopRating')
		 	);

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	                
 					array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> 8,
	                ),
	                array(
						'type'  => 'text',
						'label' => $this->l('Items'),
						'name'  => 'itemsperpage',
						'default'=> 4,
						'description' => 'input number show items per page.',
					),
					array(
						'type'  => 'text',
						'label' => $this->l('Columns'),
						'name'  => 'cols',
						'default'=> 4,
					),

 					array(
	                    'type'  => 'text',
	                    'label' => $this->l('width'),
	                    'name'  => 'width',
	                    'default'=> 200,
	                ),

 					 array(
	                    'type'  => 'text',
	                    'label' => $this->l('height'),
	                    'name'  => 'height',
	                    'default'=> 200,
	                ),
	     
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Products List Type' ),
	                    'name' 	  => 'list_type',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "",
	                ),
	                array(
	                    'type'  	=> 'ajax_product',
	                    'label' 	=> $this->l('List Products Featured'),
	                    'name'  	=> 'product[]',
	                    'default'	=> array(),
	                    'desc'		=> '',
						'products' 	=> $list_product,
						'desc'    => $this->l('Add List Products type Featured')
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

			$this->load->model('catalog/product'); 
			$this->load->model('tool/image');
			$this->language->load('extension/module/themecontrol');

			// HEADDING TITLE
			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			// SETTING
			$t = array(
                'list_type'         => 'featured',
                'width'             => '200',
                'height'            => '200',
                'limit'             => 8,
                'itemsperpage'      => 4,
                'cols'              => 4,
			);
			$setting = array_merge( $t, $setting );

			// THEME CONFIG
			$setting['objlang'] = $this->registry->get('language');
			$setting['ourl'] = $this->registry->get('url');

			$config = $this->registry->get("config");
			$setting['sconfig'] = $config;
			$setting['themename'] = $config->get("theme_default_directory");

			// PRODUCTS
            $filter_special_data = array(
				'sort'  => 'pd.name',
				'order' => 'ASC',
				'start' => 0,
				'limit' => $setting['limit']
			);

			$filter_latest_data = array(
				'sort'  => 'p.date_added',
				'order' => 'DESC',
				'start' => 0,
				'limit' => $setting['limit']
			);
			$filter_rating_data = array(
				'sort'  => 'rating',
				'order' => 'DESC',
				'start' => 0,
				'limit' => $setting['limit']
			);
		
            $products = array();
			switch ( $setting['list_type'] ) {

                case 'special':
                	$result = $this->model_catalog_product->getProductSpecials( $filter_special_data );
                    $products = $this->getProducts($result, $setting);
                    break;

                case 'latest':
                	$result = $this->model_catalog_product->getProducts( $filter_latest_data );
                    $products = $this->getProducts($result, $setting);
                    break;

                case 'popular':
                	$result = $this->model_catalog_product->getPopularProducts( $setting['limit'] );
                    $products = $products = $this->getProducts($result, $setting);
                    break;

				case 'bestseller':
			 		$result = $this->model_catalog_product->getBestSellerProducts( $setting['limit'] );
			 		$products = $products = $this->getProducts($result, $setting);
					break;
				
				case 'featured':
			 		$products = $this->getFeaturedProducts( $setting );
					break;

				case 'toprating':
					$result = $this->model_catalog_product->getProducts( $filter_rating_data );
					$products = $this->getProducts($result, $setting);
					break;

				default:
					break;
			}
			$setting['products'] = $products; 

			//echo "<pre>"; print_r($products); die;

			// OUTPUT
			$output = array('type'=>'products','data' => $setting );
			return $output;
		}

		public function getFeaturedProducts($setting){
			$data = array();

			if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

				foreach ($products as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						if ($product_info['image']) {
							$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
						}

						if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$price = false;
						}

						if ((float)$product_info['special']) {
							$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
						} else {
							$special = false;
						}

						if ($this->config->get('config_tax')) {
							$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
						} else {
							$tax = false;
						}

						if ($this->config->get('config_review_status')) {
							$rating = $product_info['rating'];
						} else {
							$rating = false;
						}

						$data[] = array(
							'product_id'  => $product_info['product_id'],
							'thumb'       => $image,
							'name'        => $product_info['name'],
							'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'rating'      => $rating,
							'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
						);
					}
				}
			}

			return $data;
		}


		public function getProducts($results, $setting){
			$data = array();
			if ($results) {
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}

					$data[] = array(
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}
			return $data;
		}

	}
?>