<?php 

/******************************************************
 * @package Pavo Opencart Theme Framework for Opencart 1.5.x
 * @version 3.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) May 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

if(!class_exists("ThemeControlHelper") ) {	
	/**
	 * ThemeControlHelper Class 
	 * 
	 */
	class ThemeControlHelper extends Controller{
	
		/**
		 * @var Array $positions
		 * 
		 * @access private
		 */
		private $positions = array();
		
		/**
		 * @var Array $modulesList
		 * 
		 * @access private
		 */
		private $modulesList = array();
		
		/**
		 * @var Array $cparams
		 * 
		 * @access private
		 */
		public $cparams = array();
		
		/**
		 * @var Integer $layout_id
		 * 
		 * @access private
		 */
		public $layout_id = 0;
		
		/**
		 * @var String $theme
		 * 
		 * @access private
		 */
		private $theme = '';
		
		private $skin = '';
		/**
		 * @var String $pageClass
		 * 
		 * @access private
		 */
		private $pageClass = '';

		/**
		 * @var Array $_jsFiles
		 * 
		 * @access private
		 */
		private $_jsFiles = array();
		
		/**
		 * @var Array $positions
		 * 
		 * @access private
		 */
		private $_cssFiles = array();
		
		/**
		 * @var Array $positions
		 * 
		 * @access private
		 */
		private $_themeDir = '';

		/**
		 * @var String $_themeScssDir
		 * 
		 * @access private
		 */
		private $_themeScssDir = '';

		/**
		 * @var String $_themeURL
		 * 
		 * @access private
		 */
		private $_themeURL = '';

		/**
		 * @var String $_scssDevURL
		 * 
		 * @access private
		 */
		private $_scssDevURL = '';

		/**
		 * @var String $_scssDevDir
		 * 
		 * @access private
		 */
		private $_layoutid = '';

		/**
		 * @var String $_direction language direction;
		 * 
		 * @access private
		 */
		private  $_direction = 'ltr';

		private $languageId;
		

		private $footerModules;

		/**
		 * get instance of this 
		 */
		public static function getInstance( $registry, $theme='default'){ 	  
			static $_instance;
			if( !$_instance ){
				$_instance = new ThemeControlHelper( $registry, $theme  );
			}
			return $_instance;
		}	

		/**
		 * Constructor 
		 */
		public function __construct( $registry, $theme, $positions=array() ){ 

			/* list of pavo framework positions */
			$this->positions = array( 'mainmenu',
									  'slideshow',
									  'promotion',
									  'showcase',
									  'content_top',
									  'column_left',
									  'column_right',
									  'content_bottom',
									  'mass_bottom',
									  'footer_top',
									  'footer_center',
									  'footer_bottom',
									  'outsite_left',
									  'outsite_right',
									  'outsite_bottom',
									  'call_by_category',
									  'call_by_search',
										
			);
			
			$layoutxml = DIR_TEMPLATE.$theme.'/development/layout/default.php';

			define( "PAVO_THEME_DIR", DIR_TEMPLATE.$theme );
			define( "PAVO_THEME_NAME",  $theme );
		 	define( "PAVO_THEMENAME",  $theme );


			if( file_exists($layoutxml) ){
				include( $layoutxml );
		 		$this->positions = PavoLayoutPositions::getList();
			}


			parent::__construct( $registry );


			$config = (array)$this->config->get( 'themecontrol' );
			if( !is_array($config) ){

			}
			$this->cparams = $config;
 			
			$direction = $this->language->get('direction');   
			$this->languageId = $this->config->get( 'config_language_id' );
			 

			$this->setTheme( $theme );
	
		 	$this->setThemeDir( DIR_TEMPLATE.$theme ); 

			$this->addParam( 'skin',  isset($config['skin'])?$config['skin']:"" );
			$this->addParam('layout', isset($config['layout'])?$config['layout']:"fullwidth" );

			 
			$this->themeURL =  'catalog/view/theme/'.$theme.'/stylesheet/';



			$this->setDirection( $this->language->get( 'direction' ) );
			
			$this->language->load( 	'extension/module/themecontrol' );
			
			// reassgin usersetting with skin color.
			if( $this->getConfig('enable_paneltool') ){
				$this->assignUserParam( $this->theme."_skin" );
			}

			$this->skin = $this->getParam('skin');  
			$this->autoLoadThemeCss();
			$this->loadLocalThemeCss(); 
		 	
		 	$this->getLayoutId();
			$this->load->model('design/layout');
			$this->load->model('design/themecontrol');
			$this->modulesList = $this->loadModulesByLayout( $this->layout_id );
			$this->footerModules = $this->loadFooterModules();
			define( "PAVO_THEME_SKIN",  $this->skin ); 
		 
		}
		
		/*
		 * set direction language (rtl or ltr)
		 */
		public function setDirection( $direction ){
			$this->_direction = $direction;
		}

		public function getDirection(){
			return $this->_direction;
		}
		/**
		 * set base path and scss path of current theme. 
		 */
		public function setThemeDir( $dir ){
			$this->_themeDir = $dir; 
			$this->_themeScssDir = $dir.'/sass/';
		}
		
		/**
		 * set name of actived theme.
		 */
		public function setTheme( $theme){
			$this->theme = $theme;
			return $this;
		}
		
		/**
		 *  add script files to collection.
		 */
		public function addScript( $path ){
			$this->_jsFiles[$path] = $path;
		}

		/**
		 * add list of script files
		 */
        public  function addScriptList( $scripts ){
			if( is_array($scripts) && !empty($scripts) ){
				$this->_jsFiles = array_merge( $this->_jsFiles, $scripts ); 
			}
        }
		
		/**
		 *  get list of theme script files and opencart script files.
		 */
		public function getScriptFiles(){
			return $this->_jsFiles;
		}

		/**
		 *  add single css file to collection
		 */
		public function addCss( $path ){
			$this->_cssFiles[md5($path)] =  array( 'href' => $path, 'rel' => 'stylesheet', 'media' => 'screen' );
		}
		
		/**
		 *  add single css file to collection
		 */
		public function addCssList( $styles ){
			if( is_array($styles) && !empty($styles) ){
				$this->_cssFiles = array_merge( $this->_cssFiles, $styles ); 
			}
		}
	
		/**
		 * get all scss files in development folder matching to load css files.
		 */
		private function autoLoadThemeCss(){


            $skin =   !empty($this->skin) ? "skins/".$this->skin : "stylesheet";
            $skin2 =   !empty($this->skin) ? "rtl/".$this->skin : "stylesheet";

            if( $this->getDirection() == 'rtl' ) {
                $this->addCss($this->themeURL . $skin2 .'-rtl.css');
            }else {
                $this->addCss($this->themeURL . $skin.'.css');
            }

			/* if current language is rtl */
		 	if( $this->getDirection() == 'rtl' ){
		 		$files = glob( $this->_themeDir . '/rtl/*.css');
		 		if( !empty($files) ){
			 		foreach ($files as $file) {	 
						 $this->addCss( $this->themeURL.str_replace(".scss", ".css", basename($file)) );		
					}
				}
		 	}
		}

		/**
		 * Local Custom Css;
		 */
		public function loadLocalThemeCss(){
			$files = glob( $this->_themeDir . '/stylesheet/local/*.css' );
			foreach( $files as $file ){
				if( filesize($file) ){
					$this->addCss( $this->themeURL. 'local/'.basename($file) );
				}
			}
		}	
		/**
		 * get all css files added for the theme
		 * this process compile - merge css files base  if theme configuration enable compression
		 */
		public function getCssLinks(){ 
			$config = $this->config->get( 'themecontrol' );	
		 

		 
			/** ENABLE COMPRESSION MODE **/
			if( isset($config['enable_compress_css']) && trim($config['enable_compress_css']) && $this->_themeDir && is_dir($this->_themeDir) ){
				
				$compress = $config['enable_compress_css'];

				$excludes = explode( ",", $config['exclude_css_files'] );
				$output = array();
				
				$pcache = new PavCache(); 
				
				if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
					$siteURL = HTTPS_SERVER;
				}else {
					$siteURL = HTTP_SERVER;
				}
				$pcache->setExtension( 'css' );
				if( $compress == 'compress-merge' ){
					$all = '';
					$aKey = md5(serialize($this->_cssFiles).serialize($excludes).$siteURL);
					
					 if( !$pcache->isExisted( ($aKey) ) ){ 
						foreach( $this->_cssFiles as $key => $file ){
							$css =  preg_match("#^http#", $file['href'] ) ?$file['href']:$siteURL.$file['href'];
							$t = explode( "/", ($css) )	;	
							
							
							if( !in_array($t[count($t)-1], $excludes)  ){
								$content = file_get_contents( $css );	
								if( !empty($content)  ){
									$content  = PavoCompressHelper::process( $content, $css ); 
								}
								$all .= $content;
							} 
							
						}
						$pcache->set( ($aKey), $all );
					}

					$_cssFiles= array();
					if( $excludes ){
						foreach( $this->_cssFiles as $key => $file ){
							$css = $file['href'];
							$t = explode( "/", ($css) )	;	
							if( in_array($t[count($t)-1], $excludes)  ){
								$_cssFiles[$key] = $file;		
							}
						}
					}
					$_cssFiles[$aKey] = array( 'rel' => 'stylesheet', 'href' =>  PAV_SUB_PATH.($aKey).".css" , 'media' => '' );
					$this->_cssFiles = $_cssFiles;
					$output = $this->_cssFiles; 
				} else {
				 
					foreach( $this->_cssFiles as $key => $file ){
						$css =  preg_match("#^http#", $file['href'] ) ?$file['href']:$siteURL.$file['href'];
						$t = explode( "/", ($css) )	;	
						if( !in_array($t[count($t)-1], $excludes)  ){
							$content = file_get_contents( $css );
							if( !empty($content)  ){
								 if( !$pcache->isExisted( md5($key) ) ){
									$content  = PavoCompressHelper::process( $content, $css ); 
									$pcache->set( md5($key), $content );
								 }
								 $this->_cssFiles[$key]['href'] = PAV_SUB_PATH.md5($key).".css";
							}else {
								unset( $this->_cssFiles[$key] );
							}
						}
					}
					$output = $this->_cssFiles;
				}
				return $output;
			}
			return $this->_cssFiles;
		}
		
		public function assignUserParam( $kc ){
			if( isset($_COOKIE[$kc]) ){ 
				$this->cparams[$kc] = $_COOKIE[$kc];
			}
		}
		/**
		 * trigger to process user paramters using for demostration
		 */
		public function triggerUserParams(  $uparams=array() ){
			
			$params = array('layout', 'body_pattern','skin') ;
			$params = array_merge_recursive( $params, $uparams );
			if( $this->getConfig('enable_paneltool') ){
				if( isset($this->request->get['pavreset']) ){ 
					foreach( $params as $param ){
						$kc = $this->theme."_".$param;
						$this->addParam($param,null);	
						setcookie ($kc, null, 0, '/');
						if( isset($_COOKIE[$kc]) ){
							$this->cparams[$kc] = null;
							$_COOKIE[$kc] = null;
						}
					}
					
				}
				$exp = time() + 60*60*24*355; 
				foreach( $params as $param ){
					$kc = $this->theme."_".$param;
					if( isset($this->request->post['userparams']) && ($data = $this->request->post['userparams']) ){
						if( isset($data[$param]) ){
							setcookie ($kc, $data[$param], $exp, '/');
							$this->cparams[$kc] = $data[$param];
						}
					}
					$this->assignUserParam( $kc );
				}
				
				if( isset($this->request->post['userparams']) || isset($this->request->get['pavreset'])  ){  
				
					$this->redirect(  $this->url->link("common/home", 'changed='.time(), 'SSL') );
				}
			}		
		}
		
		public function redirect( $url ){
			return $this->response->redirect( $url );
		}
	 	/**
	 	 * get user parameter
	 	 */
		public function getParam( $param , $value= '' ){
			return isset($this->cparams[$this->theme."_".$param])?$this->cparams[$this->theme."_".$param]:$value;
		}
		
		/**
		 * add custom parameter 
		 */
		public function addParam( $key, $value ){
			$this->cparams[$this->theme."_".$key] = $value;
		}
		
		/**
		 * get current page class.
		 */
		public function getPageClass(){
			return $this->pageClass ;
		}

		public function getSkin(){
			return $this->skin;
		}
		
		public function getCategoriesById( $category_id=0, $iwidth=280, $iheight=100 ){

			if( $category_id==0 ){
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = (int)array_pop($parts);
			}

			$this->load->model('catalog/category');

			$this->load->model('tool/image');

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach( $results as $i => $result ){
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				if ($result['image']) {
					$result['thumb'] = $this->model_tool_image->resize($result['image'], $iwidth, $iheight );
				} else {
					$result['thumb'] = '';
				}
				$result['href'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id']  );

				$results[$i] = $result;
			}
 
			return $results;
		}
		/**
		 * detect layout ID by route in request
		 */
		public function getLayoutId(){
			$this->load->model('catalog/product');
			$this->load->model('catalog/category');
			$this->load->model('catalog/information');
			$this->load->model('design/layout');

			if( !$this->layout_id ) {
				if (isset($this->request->get['route'])) {
					$route = (string)$this->request->get['route'];
					$this->pageClass = 'page-'.str_replace( "/", "-", $route );
				} else {
					$route = 'common/home';
					$this->pageClass = 'page-home';
				}
		
		
				$layout_id = 0;
			
				if ($route == 'product/category' && isset($this->request->get['path'])) {
					$path = explode('_', (string)$this->request->get['path']);
						
					$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));		
					$this->pageClass = 'page-category';		

				}
				
				if ($route == 'product/product' && isset($this->request->get['product_id'])) {
					$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
					$this->pageClass = 'page-product';		
				}
				
				if ($route == 'information/information' && isset($this->request->get['information_id'])) {
					$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
					$this->pageClass = 'page-information';		
				}
				
				if (!$layout_id) {
					$layout_id = $this->model_design_layout->getLayout($route);
				}
						
				if (!$layout_id) {
					$layout_id = $this->config->get('config_layout_id');
				}
		 
				$this->layout_id = $layout_id;
			}
			return $this->layout_id;
		}
		
	 	
	 	public function loadModulesByLayout( $layout_id ){


		 	$this->load->model('extension/module');


	 		$modules = $this->model_design_themecontrol->getModulesByLayoutId( $layout_id  );
	 		$modulesList = array();

	 		foreach( $modules as $module ){
	 			$part = explode('.', $module['code']);
			 
			
				if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
					$modulesList[$module['position']][] = $this->load->controller('extension/module/' . $part[0]);
				}
				
				if (isset($part[1])) {
					$setting_info = $this->model_extension_module->getModule($part[1]);
					
					if ($setting_info && $setting_info['status']) {
						$modulesList[$module['position']][] = $this->load->controller('extension/module/' . $part[0], $setting_info);
					}
				}
	 		}


	 		return $modulesList;
	 	}	

	 	public function getCloneModulesInLayout( $position, $layout=1 ){

	 		 
			if( isset($this->modulesList[$position]) ){
				return $this->modulesList[$position];
			}
	 	}
		
		public function loadFooterModules( $pos=array() ){
			$positions = array(
				'footer_top',
				'footer_center',
				'footer_bottom'
			);

			if( $pos ){
				$positions = array_merge( $positions, $pos );
			}
			$layout_id = 1;

			$modulesList = array();
			$data = array();
			foreach( $positions as $position ){

				 
				$modules = $this->model_design_layout->getLayoutModules($layout_id, $position );
	

			

		 		foreach( $modules as $module ){
		 			$part = explode('.', $module['code']);
				 
				
					if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
						$modulesList[$module['position']][] = $this->load->controller('extension/module/' . $part[0]);
					}
					
					if (isset($part[1])) {
						$setting_info = $this->model_extension_module->getModule($part[1]);
						
						if ($setting_info && $setting_info['status']) {
							$modulesList[$module['position']][] = $this->load->controller('extension/module/' . $part[0], $setting_info);
						}
					}
		 		}

		 		$this->footerModules = $modulesList;
			} 
		 
			return $modulesList; 	
		}

		public function getFooterModule( $position ){
			 
			if( is_array($this->footerModules) && isset($this->footerModules[$position]) ){
				return $this->footerModules[$position]; 
			}
			return array();
		}
	 
		/**
		 * get collection of modules by position
		 */
		public function getModulesByPosition( $position ){ 
	 		$this->load->model('design/layout');
			$data =  $this->getCloneModulesInLayout( $position, $this->layout_id );

			if( empty($data) ){
				$data['modules'] = array();
 
				$modules = $this->model_design_layout->getLayoutModules( $this->layout_id, $position );
 
				foreach ($modules as $module) {
					$part = explode('.', $module['code']);
					
					if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
						$data['modules'][] = $this->load->controller('extension/module/' . $part[0]);
					}
								
					if (isset($part[1])) {
						$setting_info = $this->model_extension_module->getModule($part[1]);
						
						if ($setting_info && $setting_info['status']) {
							$data['modules'][] = $this->load->controller('extension/module/' . $part[0], $setting_info);
						}
					}
				}
				return $data['modules'];
			}

			return $data;
		}
		
		/**
		 * caculate span width of column base grid 12 of twitter.
		 * 
		 * @param Array $ospan 
		 * @param Numberic $cols number of columns
		 */
		public function calculateSpans( $ospans=array(), $cols ){
			$tmp = array_sum($ospans);
			$spans = array();
			$t = 0; 
			for( $i=1; $i<= $cols; $i++ ){
				if( array_key_exists($i,$ospans) ){
					$spans[$i] = 'col-lg-'.$ospans[$i]. ' col-md-'.$ospans[$i] ;
					
				}else{		
					if( (12-$tmp)%($cols-count($ospans)) == 0 ){
						$ts=((12-$tmp)/($cols-count($ospans)));
						$spans[$i] = "col-lg-".$ts.' col-md-'.$ts;
						
					}else {
						if( $t == 0 ) {
							$ts = ( floor((11-$tmp)/($cols-count($ospans))) + 1 ) ;
							$spans[$i] = "col-lg-".$ts;
						}else {
							$ts = ( floor((11-$tmp)/($cols-count($ospans))) + 0 );
							$spans[$i] = "col-lg-".$ts .' col-md-'.$ts;
						}
						$t++;
					}					
				}
			}
			return $spans;
		}

		/**
		 * 
		 */
		public static function renderEdtiorThemeForm( $theme ){ 
			$customizeXML = DIR_TEMPLATE.$theme.'/development/customize/themeeditor.xml'; 
		 	$output = array( 'selectors' => array(), 'elements' => array() );
	 		if( file_exists($customizeXML) ){
				$info = simplexml_load_file( $customizeXML );
				if( isset($info->selectors->items) ){
					foreach( $info->selectors->items as $item ){
						$vars = get_object_vars($item);
						if( is_object($vars['item']) ){
							$tmp = get_object_vars( $vars['item'] );
							$vars['selector'][] = $tmp;
						}else {
							foreach( $vars['item'] as $selector ){
								$tmp = get_object_vars( $selector );
								if( is_array($tmp) && !empty($tmp) ){
									$vars['selector'][] = $tmp;
								}
							}
						}
						unset( $vars['item'] );
						$output['selectors'][$vars['match']] = $vars;
					}
				}

				if( isset($info->elements->items) ){
					foreach( $info->elements->items as $item ){
						$vars = get_object_vars($item);
						if( is_object($vars['item']) ){
							$tmp = get_object_vars( $vars['item'] );
							$vars['selector'][] = $tmp;
						}else {
							foreach( $vars['item'] as $selector ){
								$tmp = get_object_vars( $selector );
								if( is_array($tmp) && !empty($tmp) ){
									$vars['selector'][] = $tmp;
								}
							}
						}
						unset( $vars['item'] );
						$output['elements'][$vars['match']] = $vars;
					}
				}
			}

			return $output;
		}	

		/**
		 * 
		 */
		public function getPattern( $theme ){
			$output = array(); 

 			$path = DIR_TEMPLATE .$theme .'/image/pattern/'; 
			if( $theme && is_dir($path) ) {   
				$files = glob( $path.'*' );
				foreach( $files as $dir ){
					if( preg_match("#.png|.jpg|.gif#", $dir)){
						$output[] = str_replace("","",basename( $dir ) );
					}
				}			
			}
			return $output;
		}

		/**
		 * 
		 */
		public function renderAddon( $addon, $args =array() ){
			extract($args);
			$output = '';
			$path   = $this->_themeDir.'/template/common/addon/'.$addon.'.tpl';
		
			if( file_exists($path) ){ 
				ob_start();
				require_once( $path );
				$output  = ob_get_contents();
				ob_end_clean();
			}

			return $output;
		}

		/**
		 * 
		 */
		public function renderModule( $module, $args = array() ){  
			// check xem module da install chua 
			$extension = basename($module, '.php');
			$extensions = $this->getInstalled('module');

			if (in_array($extension, $extensions)) {
				return $this->load->controller('extension/module/' . $module);
			} else {
				echo "please install module " .$module; die;
			}

			return ;
		}

		private function getInstalled($type) { 
		
			$extension_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' ORDER BY code");

			foreach ($query->rows as $result) {
				$extension_data[] = $result['code'];
			}

			return $extension_data;
		}

		/**
		 *
		 */
		public function getWrapImage( $product_id ){
			$product_images = $this->model_catalog_product->getProductImages($result['product_id']);
			if(isset($product_images) && !empty($product_images)) {
				$thumb2 = $this->model_tool_image->resize($product_images[0]['image'], $setting['width'], $setting['height']);
			}
		}

		/**
		 *
		 */
		public static function getLayoutPath( $layout ){  
			if( file_exists(DIR_TEMPLATE.PAVO_THEMENAME.'/template/skin/'.PAVO_THEME_SKIN.'/'.$layout) ){
				return DIR_TEMPLATE.PAVO_THEMENAME.'/template/skin/'.PAVO_THEME_SKIN.'/'.$layout;
			}
			 return DIR_TEMPLATE.PAVO_THEMENAME.'/template/'.$layout;
		}

		public function getLayoutBySkin( $layout ){
			return $this->_themeDir . '/template/common/skins/'.$this->skin.'/'.$layout.'.tpl';
		}

		public function getHeaderFileBySkin(){
			if( file_exists($this->getLayoutBySkin('header')) ){
				return $this->getLayoutBySkin('header');
			}
			return $this->_themeDir . '/template/common/skins/default/header.tpl';
		}

		public function getFooterFileBySkin(){
			if( file_exists($this->getLayoutBySkin('footer')) ){
				return $this->getLayoutBySkin('footer');
			}
			return $this->_themeDir . '/template/common/skins/default/footer.tpl';
		}

		/**
		 *
		 */
		public function getConfig( $config, $value='' ){
			return isset($this->cparams[$config])?$this->cparams[$config]:$value;
		}

		/**
		 *
		 */
		public function getLangConfig( $config, $value='' ){
			return isset($this->cparams[$config][$this->languageId])?html_entity_decode($this->cparams[$config][$this->languageId], ENT_QUOTES, 'UTF-8' ):$value;
		}

		/**
		 *
		 */
		public function renderCustomFont(){
			$themeConfig = $this->config->get( 'themecontrol' );	
			$css=array();
			$link = array();
			for( $i=1; $i<=3; $i++ ){
				if( trim($themeConfig['google_url'.$i]) && $themeConfig['type_fonts'.$i] == 'google' ){
					$link[] = '<link rel="stylesheet" type="text/css" href="'.trim($themeConfig['google_url'.$i]) .'"/>';
					$themeConfig['normal_fonts'.$i] = $themeConfig['google_family'.$i];
				}
				if( trim($themeConfig['body_selector'.$i]) && trim($themeConfig['normal_fonts'.$i]) ){
					$fs = (int)$themeConfig['fontsize'.$i]>0?"font-size:".$themeConfig['fontsize'.$i].'px;':'';
					$ff = $themeConfig['normal_fonts'.$i] !="inherit"? "font-family:".str_replace("'",'"',htmlspecialchars_decode(trim($themeConfig['normal_fonts'.$i]))):"";
					$css[]= trim($themeConfig['body_selector'.$i])." { ".$fs." " . $ff ."}\r\n"	;
				}
			}
			$html = implode( "\r\n",$link )."\r\n";
			$html .= '<style type="text/css"> '.implode( " ",$css ).' </style>';
			return $html;
		}

		public function removeCssFile(){

		}

		public function getRandomTags($limit, $min_font_size, $max_font_size, $font_weight){

			$this->load->model( 'pavpopulartags/tag' );

			$tags = $this->model_pavpopulartags_tag->getRandomTags($limit, $min_font_size, $max_font_size, $font_weight);
			
			return $tags;
		}

				
	}
}	
?>