<?php 
class PtsWidgetProduct_list_home2 extends PtsWidgetPageBuilder {

		public $name = 'product_list_home2';
		public $group = 'product';
		public $usemeneu = false;
		
		public static function getWidgetInfo(){
			return array('label' =>  ('Product List'), 'explain' => 'Product list support home2', 'group' => 'opencart'  );
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
                'width'             => '200',
                'height'            => '200',
                //first_product
                'f_width'             => '400',
                'f_height'            => '400',

                'limit'             => 8,
                'itemsperpage'      => 4,
                'cols'              => 4,
			);
			$setting = array_merge( $t, $setting );

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

			// PRODUCTS
            
				
            	switch ( $setting['list_type'] ) {
            		case 'special':
            			$results = $this->model_catalog_product->getProductSpecials( $filter_special_data, $setting );
            			$data = $this->getProducts($results, $setting);
            			$setting['first_product'] = $data['first_product'];
						$setting['products'] = $data['products'];
	                    break;

	                case 'latest': 

	               		$results = $this->model_catalog_product->getProductSpecials( $filter_special_data, $setting );
            			$data = $this->getProducts($results, $setting);
            			$setting['first_product'] = $data['first_product'];
						$setting['products'] = $data['products'];
	                    break;

	                case 'popular':
	                	$results = $this->model_catalog_product->getPopularProducts( $setting['limit'] );
	                   	$data = $this->getProducts($results, $setting);
	                	$setting['first_product'] = $data['first_product'];
						$setting['products'] = $data['products'];
	                    break;

					case 'bestseller':
				 		$results = $this->model_catalog_product->getBestSellerProducts( $setting['limit'] );
				 		$data = $this->getProducts($results, $setting);
				 		$setting['first_product'] = $data['first_product'];
						$setting['products'] = $data['products'];
						break;

            		case 'featured':
            			if (!empty($setting['product'])) {
		            		$products = array_slice($setting['product'], 0, (int)$setting['limit']);
			            	$i = 0;
	            			foreach ($products as $product_id) { $i++;
								$product_info = $this->model_catalog_product->getProduct($product_id);
								if($i==1){
									$setting['first_product'] = $this->getProduct($product_info, $setting, 1);
								} else {
									$setting['products'][] = $this->getProduct($product_info, $setting, 0);
								}
							}
						} else {
							$setting['first_product'] = array();
							$setting['products'] = array();
						}
						break;
					default:
						$setting['first_product'] = array();
						$setting['products'] = array();
						break;
				}
			
			

			// OUTPUT
			$output = array('type'=>'products','data' => $setting );
			return $output;
		}

		public function getProducts($results, $setting){
			
			$data = array();
			$products = array_slice($results, 0, (int)$setting['limit']);
			$i = 0;
			if ($results) {
				foreach ($results as $result) { $i++;
					if($i==1){
						$data['first_product'] = $this->getProduct($result, $setting, 1);
					} else {
						$data['products'][] = $this->getProduct($result, $setting, 0);
					}
				}
			}
			return $data;
		}

		public function getProduct($product_info, $setting, $flag){
			$data = array();

			if ($product_info) {

				if($flag == 1){
					$width = $setting['f_width'];
					$height = $setting['f_height'];
				} else {
					$width = $setting['width'];
					$height = $setting['height'];
				}

				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $width, $height);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $width, $height);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}

				$data = array(
					'product_id'  => $product_info['product_id'],
					'thumb'       => $image,
					'name'        => $product_info['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
				);
			}

			return $data;
		}


	}
?>