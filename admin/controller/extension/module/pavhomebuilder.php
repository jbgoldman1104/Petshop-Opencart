<?php
/******************************************************
 * @package Pav Banner Manager for Opencart 1.5.x
 * @version 1.0
 * @author pavotheme (http://pavotheme.com)
 * @copyright	Copyright (C) May 2013 pavotheme.com <@emai:pavotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 1
*******************************************************/
require_once(DIR_SYSTEM . 'pavothemes/widgets_loader.php');	

class ControllerExtensionModulepavhomebuilder extends Controller {
	/**
	 *
	 */
	private $error = array();

	/**
	 *
	 */
	private $mdata = array();

	/**
	 *
	 */
	public function index() {
		
		$this->load->language('extension/module/pavhomebuilder');

		$this->load->model('setting/setting');
		$this->load->model('extension/module');
		$this->load->model('extension/pavwidget');

		$this->model_extension_pavwidget->checkInstall();
		
		$this->load->model('tool/image');
		//$this->load->model('pavhomebuilder/banner');
		$this->document->setTitle( strip_tags( $this->language->get('heading_title') ) );
		 
		$this->document->addStyle('view/javascript/jquery/ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/jquery/ui/jquery-ui.min.js');

			
		$this->document->addScript( 'view/javascript/summernote/summernote.js');
		$this->document->addStyle( 'view/javascript/summernote/summernote.css');


		$this->document->addScript('view/javascript/pavhomebuilder/script.js');
		$this->document->addScript('view/javascript/pavhomebuilder/gallery.js');
		$this->document->addScript('view/javascript/pavhomebuilder/widget.js');
		$this->document->addStyle('view/stylesheet/pavhomebuilder/style.css');


		$this->document->addScript('view/javascript/colorpicker/js/colorpicker.js');
		$this->document->addStyle('view/javascript/colorpicker/css/colorpicker.css');

		if( isset($this->request->get['module_id']) && isset($this->request->get['delete']) ){
			$this->model_extension_module->deleteModule( $this->request->get['module_id'] );
			$this->response->redirect($this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
 
			$action = $this->request->post['pavhomebuilder_module']['action'];
			$store_id = $this->request->post['pavhomebuilder_module']['store_id'];
			$surl = isset($store_id)?'&store_id='.$store_id:'';

			unset( $this->request->post['pavhomebuilder_module']['action'] );
			unset( $this->request->post['pavhomebuilder_module']['store_id']);
			unset( $this->request->post['pavhomebuilder_module']['stores']);
			unset( $this->request->post['pavhomebuilder_module']['banners']);	

		 	$data = array();

		 	foreach ($this->request->post['pavhomebuilder_module'] as $key => $value) {
		 	 	$data = $value;	
		 	 	$data['layout'] = ( htmlspecialchars_decode($value['layout']) );
		 	 	break;
		 	}
		  	
		 	
			if( empty($data['name']) ){
				$this->error['warning'] = $this->language->get('error_permission');
				$this->response->redirect($this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'], 'SSL'));
			}	

		 	if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('pavhomebuilder', $data );
				$module_id = $this->model_extension_module->getLastId();
			} else {
				$this->model_extension_module->editModule( $this->request->get['module_id'], $data );
				$module_id =  $this->request->get['module_id'];
			}	
	
 			if(  isset($this->request->post['widget_data']) ){ 
		  		$this->model_extension_pavwidget->addWidgets( $this->request->post['widget_data'], $module_id ); 
		  	}
		  	$data['module_id'] = $module_id; 
		  	$this->model_extension_module->editModule( $module_id, $data );

			$this->session->data['success'] = $this->language->get('text_success');
			if($action == "save_stay"){
				if( isset($this->request->get['module_id']) ) {
					$this->response->redirect($this->url->link('extension/module/pavhomebuilder', 'module_id='.$this->request->get['module_id'].'&token=' . $this->session->data['token'], 'SSL'));
				}else{
					$this->response->redirect($this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}else{
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL'));
			}

		}

		$this->_getLanguage();
		$this->_breadcrumbs();
		$this->_alert();
		
		// Get Stores
		$this->mdata['stores'] = $this->_getStores();
		$store_id = isset($this->request->get['store_id'])?$this->request->get['store_id']:0;
		$this->mdata['store_id'] = $store_id;


		$storeConfig = $this->model_setting_setting->getSetting('theme_default', $this->store_id );
		$theme = $storeConfig['theme_default_directory'];
		
	 	
	 	$dir = DIR_CATALOG.'view/theme/'.$theme.'/template/extension/module/pavhomebuilder';  
	 	$output = array();
	 	if( is_dir($dir) ){
	 		$dir = $dir.'/*.tpl';
	 		$files = glob($dir);
	 		$output = array();

	 		foreach( $files as $file ){
	 			
	 			$name =  str_replace( ".tpl", "", basename( $file ) );
	 			$a = file_get_contents( $file );  

	 			if( preg_match( "#Template\s*:\s*([\w+\s+]+)+(\r\n)?#", $a,$match) ){ 
	 				$output[$name] = $match[1];
	 			}else {
	 				$output[$a] = $name;
	 			}
	 		}
	 	}
 
		// Language
		$this->load->model('localisation/language');
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();

		// Get Banners
		$this->load->model('design/banner');	
		$banners = $this->model_design_banner->getBanners();

		foreach( $banners as $key => $banner  ){
			$banners[$key]['total'] = count( $this->model_design_banner->getBannerImages( $banner['banner_id']) );
		
		}

		$this->mdata['banners'] = $banners; 
		$this->mdata['templates'] = $output;
	
		// Get Setting Status
		if (isset($this->request->post['pavhomebuilder_status'])) {
			$this->mdata['pavhomebuilder_status'] = $this->request->post['pavhomebuilder_status'];
		} else {
			$this->mdata['pavhomebuilder_status'] = $this->config->get('pavhomebuilder_status');
		}

		// Get Data Setting
		if (isset($this->request->post['pavhomebuilder_module'])) {
			$modules = $this->request->post['pavhomebuilder_module'];
		} else {
			$setting = $this->model_setting_setting->getSetting("pavhomebuilder", $store_id);
			$modules = isset($setting['pavhomebuilder_module'])?$setting['pavhomebuilder_module']:array();
		}
 		
 		$default = array(
 			'name' => '',
 			'class' => '',
 			'layout' => '',
 			'status' => 0
 		);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
			$this->mdata['selectedid'] = $this->request->get['module_id'];

			
			$this->mdata['subheading'] = 'Edit Module: '. $module_info['name'];
			$this->mdata['action'] = $this->url->link('extension/module/pavhomebuilder', 'module_id='.$this->request->get['module_id'].'&token=' . $this->session->data['token'], 'SSL');
		}else {
			$module_info = $default;
			$this->mdata['selectedid'] = 0;
			$this->mdata['subheading'] = 'Create New A Home Page Module';
			$this->mdata['action'] = $this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'], 'SSL');
		}
	 	
	 	$moduletabs = $this->model_extension_module->getModulesByCode( 'pavhomebuilder' );
	 	$this->mdata['link'] = $this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'] . '', 'SSL');
	 	


		$modules = array( 0=> $module_info );

		// echo '<Pre>'.print_r( json_decode( $module_info['layout'] ) ,1  );die; 
 		$sfxclss = $this->detectSfxClasses( $this->config->get('theme_default_directory') );
	 	
 		$this->mdata['modules'] = $modules; 
 		$this->mdata['moduletabs'] = $moduletabs;

		$this->mdata['edit_action'] = $this->url->link('design/banner/edit', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['add_action'] = $this->url->link('design/banner/add', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['entry_banner_group'] = $this->language->get( 'entry_banner_group' );
		$this->mdata['entry_banner_template'] = $this->language->get( 'entry_banner_template' );
		
		$this->load->model('tool/image');
		$this->mdata['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		// Render
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');
		$template = 'extension/module/pavhomebuilder/modules.tpl';
		$this->mdata['olang'] = $this->language;
		$this->mdata['ourl'] = $this->url;

		$this->mdata['extensions'] = $this->_modulesInstalled();
		$this->mdata['widgets'] = $this->_getWidgets();
		$this->mdata['groups'] = array();
		foreach( $this->mdata['widgets'] as $key => $w ){
			$this->mdata['groups'][$w->group] = $this->language->get( ucfirst($w->group) );
		}	

		$widget_data = isset($this->request->get['module_id'])?$this->model_extension_pavwidget->getWidgetsByModuleId( $this->request->get['module_id'] ):array();

		foreach ($widget_data as $key => $value) {
			$widget_data[$key]['setting'] = html_entity_decode( $value['setting'] ); 
			$widget_data[$key]['id'] = str_replace(  ".", "-", $value['code'] );

		}

	
		$this->mdata['widget_data']  = $widget_data;
 

		$this->mdata['sfxclss']  = $sfxclss;  
		$this->mdata['ifmocmod'] = $this->url->link('extension/module/pavhomebuilder/listmodules', 'token=' . $this->session->data['token'] . '', 'SSL');
		

		$this->response->setOutput($this->load->view($template, $this->mdata));
	}

	protected function _getWidgets(){  
	 
		$widgets = PavWidgetHelper::loadWidgets( $this->registry );

		return $widgets;
	}

	protected function showModules(){

		$data['extensions'] = array();
		$extensions = $this->model_extension_extension->getInstalled('module');
		
		$files = glob(DIR_APPLICATION . 'controller/module/*.php');

		if ($files) {
			foreach ($files as $file) {

				$content = file_get_contents( $file );

				if( !preg_match( "#editModule#", $content ) ){
					continue;
				}

				$extension = basename($file, '.php');

				$this->load->language('extension/module/' . $extension);

				$module_data = array();

				$data['extensions'][] = array(
					'name'      => $this->language->get('heading_title'),
					'module'    => $module_data,
					'install'   => $this->url->link('extension/module/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
					'uninstall' => $this->url->link('extension/module/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
					'installed' => in_array($extension, $extensions),
					'edit'      => $this->url->link('extension/module/' . $extension, 'token=' . $this->session->data['token'], 'SSL')
				);
			}
		}
	//	echo '<pre>'.print_r( $data['extensions'] ,1 ); die; 

		return $data['extensions'];
	}

	public function widget(){
		
		if( isset($this->request->post['savedata']) ){

			foreach( $this->request->post as $key => $value ){
				if( !is_array($value) ){
					$this->request->post[$key] = ( $value );
				}
			}


			$data = base64_encode( serialize( $this->request->post ) );
			echo $data;die;
		}
		
		if(  isset($this->request->post['module']) ){
			$this->request->post['wkey'] = $this->request->post['module']; 

			$module    = explode( ".", $this->request->post['module'] );
			$widget = $module[0];
			$key 	   = $module[1];

			$args   = array();
			$data 	= array();

			$object = PavWidgetHelper::loadWidget( $widget, $this->registry );


			if( isset($this->request->post['data']) &&  $this->request->post['data'] ){
				$m = htmlspecialchars_decode( $this->request->post['data'] ); 

 
				$m = $m?  @unserialize( base64_decode( trim($m) ) ):null;
				$data = $object->parseWidgetsData(  $m ); 

				// echo '<pre>'.print_r( unserialize( base64_decode($data) ),1 );die; 

			}

			$form   = $object->renderForm( $args, $data );

			echo $form; die; 
		}
		die( $this->language->get('text_form_not_avairiable')  );
	}

	/**
	 *
	 */
	public  function detectSfxClasses( $template ){

		$pagestyle =  DIR_CATALOG.'view/theme/default/stylesheet/homebuilder.css';
		$tcss =  DIR_CATALOG.'view/theme/'.$template.'/stylesheet/homebuilder.css';

		$captions  = array( 'col' => array() , 'row' => array() );
	 
	 
		 
		if( file_exists($tcss) ){
			$content =  file_get_contents( $tcss );
		}else {
			$content   =  file_get_contents( $pagestyle );
		}
		
		

		$a = preg_match_all( "#\.pav-col\.(\w+)\s*{\s*#", $content, $matches );
			if( isset($matches[1]) ){
            $captions['col']  = $matches[1];
        }

        $a = preg_match_all( "#\.pav-row\.(\w+)\s*{\s*#", $content, $matches );
			if( isset($matches[1]) ){
            $captions['row']  = $matches[1];
        }
        $a = preg_match_all( "#\.widget\.(\w+)\s*{\s*#", $content, $matches );
			if( isset($matches[1]) ){
				foreach( $matches[1] as $class ){
					$captions['widget']  = $matches[1];
				}
        }
		return $captions;
	}

	public function _modulesInstalled(){
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$data['extensions'] = array();
		
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
				
		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			if( $code =='pavmegamenu' || $code=="pavverticalmegamenu" || $code == "pavhomebuilder" ){
				continue;
			}
			$this->load->language('extension/module/' . $code);
		
			$module_data = array();
			
			$modules = $this->model_extension_module->getModulesByCode($code);
			
			foreach ($modules as $module) {
				$module_data[] = array(
					'name' => strip_tags( $this->language->get('heading_title') ) . ' &gt; ' . $module['name'],
					'code' => $code . '.' .  $module['module_id'],
					'id' 	=>  $module['module_id']
				);
			}
			
			if( $modules  ){
				if ($this->config->has($code . '_status') || $module_data) {
					$data['extensions'][$code] = array(
						'name'   => strip_tags( $this->language->get('heading_title') ),
						'code'   => $code,
						'module' => $module_data

					);
				}
			}	
		}
		return $data['extensions'];
	}
	public function _alert(){
 		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}
	}

	/**
	 *
	 */
	public function _breadcrumbs(){
		$this->mdata['breadcrumbs'] = array();

		$this->mdata['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->mdata['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
		'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL'),
			'separator' => ' :: '
		);

		$this->mdata['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('extension/module/pavhomebuilder', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
	}

	/**
	 *
	 */
	public function _getStores(){

		$this->load->model('setting/store');

		$action = array();
		$action[] = array(
			'text' => $this->language->get('text_edit'),
			'href' => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL')
		);
		$store_default = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG,
		);
		$stores = $this->model_setting_store->getStores();
		array_unshift($stores, $store_default);
		
		foreach ($stores as &$store) {
			$url = '';
			if ($store['store_id'] > 0 ) {
				$url = '&store_id='.$store['store_id'];
			}
			$store['option'] = $this->url->link('extension/module/pavhomebuilder', $url.'&token=' . $this->session->data['token'], 'SSL');
		}
		return $stores;
	}

	/**
	 *
	 */
	public function _getLanguage(){
		$this->mdata['objlang'] = $this->language;

		$this->mdata['heading_title'] = $this->language->get('heading_banner_title');
		$this->mdata['tab_module'] = $this->language->get('tab_module');
		// Text
		$this->mdata['prefix_class'] = $this->language->get('prefix_class');
		// Button
		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_save_stay'] = $this->language->get('button_save_stay');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		// Entry
		$this->mdata['entry_layout'] = $this->language->get('entry_layout');
		$this->mdata['entry_status'] = $this->language->get('entry_status');
		$this->mdata['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->mdata['entry_position'] = $this->language->get('entry_position');
		$this->mdata['entry_tabs'] = $this->language->get('entry_tabs');
		$this->mdata['entry_banner_layouts'] = $this->language->get('entry_banner_layouts');
		$this->mdata['entry_caption'] = $this->language->get('entry_caption');
		$this->mdata['text_disabled'] = $this->language->get('text_disabled');
		$this->mdata['text_enabled'] = $this->language->get('text_enabled');
 	
 		$this->mdata['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);	

		// Token
		$this->mdata['token'] = $this->session->data['token'];

		
		$this->mdata['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
	}

	/**
	 *
	 */
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/pavhomebuilder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 */
	public function listmodules(){

		$this->load->language('extension/module/pavhomebuilder');
		$this->load->model('setting/setting');
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$this->load->model('tool/image');
		$this->mdata['olang'] = $this->language;

		$this->document->addStyle('view/stylesheet/pavhomebuilder/style.css');

		//$this->document->addScript( 'view/javascript/summernote/summernote.js');
		//$this->document->addStyle( 'view/javascript/summernote/summernote.css');


		$this->mdata['ocmodules'] = $this->showModules();
		$template = 'extension/module/pavhomebuilder/ocmodules.tpl' ;
			
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');
		$this->mdata['install'] = $this->url->link('extension/install', 'token=' . $this->session->data['token'], 'SSL');


		$this->response->setOutput($this->load->view($template, $this->mdata));
	}
}
?>
