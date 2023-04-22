<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Steptember 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
require_once(DIR_SYSTEM . 'pavothemes/loader.php');	
/**
 * class ControllerExtensionModulePavmegamenu 
 */
class ControllerExtensionModulePavmegamenu extends Controller {

	/**
	 * @var Array $error.
	 *
	 * @access private 
	 */
	private $error = array(); 

	/**
	 * @var Array $error.
	 *
	 * @access private 
	 */
	private $moduleName = 'pavmegamenu';

	public $mdata;


	/**
	 * Index Action 
	 */
	public function __construct($registry) {
		$this->registry = $registry;
		// check tables created or not
		$this->load->model('menu/megamenu');
		
	}

	public function install(){
		$this->model_menu_megamenu->install();
	}

	public function index() {   
		
		$this->language->load('extension/module/pavmegamenu');
		
	
		$this->document->setTitle( strip_tags($this->language->get('heading_title')) );
		$this->document->addStyle('view/stylesheet/pavmegamenu.css');
		$this->document->addScript('view/javascript/pavmegamenu/jquerycookie.js');

		$this->document->addStyle('view/javascript/jquery/ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/jquery/ui/jquery-ui.min.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');

		$this->document->addScript('view/javascript/pavmegamenu/jquery.nestable.js');


		// check tables created or not
		
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST')  && !empty($this->request->post) ) {
			if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
				$this->error['warning'] = $this->language->get('error_permission');
				 
			}else { 
				$id = 0;
				$this->load->model('menu/megamenu');


		                $megamenu = $this->request->post['megamenu'];
		                $store_param = isset($megamenu['store_id'])?'&store_id='.$megamenu['store_id']:'';

				if(  $this->validate() ) {
					$id = $this->model_menu_megamenu->editData( $this->request->post );				
				}
				
				$this->session->data['success'] = $this->language->get('text_success');
				if($this->request->post['save_mode']=='delete-categories'){
					$this->model_menu_megamenu->deletecategories($megamenu['store_id']);
				}
				if($this->request->post['save_mode']=='import-categories'){
					$this->model_menu_megamenu->importCategories($megamenu['store_id']);
				}
				if( isset($id) && $this->request->post['save_mode']=='save-edit'){
                    $this->redirect($this->url->link('extension/module/pavmegamenu', 'id='.$id.'&token=' . $this->session->data['token'].$store_param, 'SSL'));
				}	else {
					$this->redirect($this->url->link('extension/module/pavmegamenu', 'token=' . $this->session->data['token'].$store_param, 'SSL'));
				}
				$this->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'].$store_param, 'SSL'));
			}
		}
				
		$this->mdata['heading_title'] = $this->language->get('heading_title');
		$this->mdata['text_enabled'] = $this->language->get('text_enabled');
		$this->mdata['text_disabled'] = $this->language->get('text_disabled');
		$this->mdata['text_content_top'] = $this->language->get('text_content_top');
		$this->mdata['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->mdata['text_column_left'] = $this->language->get('text_column_left');
		$this->mdata['text_column_right'] = $this->language->get('text_column_right');

		$this->mdata['entry_banner'] = $this->language->get('entry_banner');
		$this->mdata['entry_dimension'] = $this->language->get('entry_dimension'); 
		$this->mdata['entry_layout'] = $this->language->get('entry_layout');
		$this->mdata['entry_position'] = $this->language->get('entry_position');
		$this->mdata['entry_status'] = $this->language->get('entry_status');
		$this->mdata['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		
	
		//#2 edit code
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
			$store['option'] = $this->url->link('extension/extension/pavmegamenu', $url.'&token=' . $this->session->data['token'].'&type=module', 'SSL');
		}
		$this->mdata['stores'] = $stores;

		if (isset($this->request->get['store_id'])){
			$store_id = $this->request->get['store_id'];
			$store_param = "&store_id=".$store_id;
		} else {
			$store_id = 0;
			$store_param = "";
		}
		$this->mdata['store_id'] = $store_id;
		
 		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$this->mdata['error_dimension'] = $this->error['dimension'];
		} else {
			$this->mdata['error_dimension'] = array();
		}
		
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
			'href'      => $this->url->link('extension/module/pavmegamenu', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->mdata['action'] = $this->url->link('extension/module/pavmegamenu', 'token=' . $this->session->data['token'].$store_param, 'SSL');
		$this->mdata['actionGetTree'] = $this->url->link('extension/module/pavmegamenu/gettree', 'token=' . $this->session->data['token'].$store_param, 'SSL');
		$this->mdata['actionDel'] = $this->url->link('extension/module/pavmegamenu/delete', 'token=' . $this->session->data['token'].$store_param, 'SSL');
		$this->mdata['actionGetInfo'] = $this->url->link('extension/module/pavmegamenu/info', 'token=' . $this->session->data['token'].$store_param, 'SSL');
		$this->mdata['updateTree'] = $this->url->link('extension/module/pavmegamenu/update', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL');
		
		$this->mdata['liveedit_url'] = $this->url->link('extension/module/pavmegamenu/liveedit', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL');
		
		$this->mdata['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].$store_param.'&type=module', 'SSL');
		

		$this->load->model('menu/widget');
		$this->mdata['widgets'] = $this->model_menu_widget->getWidgets();
		//get current language id
		$this->mdata['language_id'] = $this->config->get('config_language_id');		
		
		$this->mdata['modules'] = array();
		
		if (isset($this->request->post['pavmegamenu_module'])) {
			$this->mdata['modules'] = $this->request->post['pavmegamenu_module'];
		} elseif ($this->config->get('pavmegamenu_module')) { 
			$this->mdata['modules'] = $this->config->get('pavmegamenu_module');
		}	
		$tmp = array('layout_id'=>'','position'=>'','status'=>'','sort_order'=>'');				
		if( count($this->mdata['modules']) ){
			$tmp = array_merge($tmp, $this->mdata['modules'][0] );
		}
		$this->mdata['module'] = $tmp;
		$this->load->model('design/layout');
		
		$this->mdata['currentID'] = 0 ;
		if( isset($this->request->get['id'] ) ){
			$this->mdata['currentID'] = $this->request->get['id'];
		}


		$this->mdata['tree'] = $this->model_menu_megamenu->getTree(null, $store_id, $this->mdata['currentID'] );

		$this->mdata['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->info();
		$this->mdata['layouts'] = array();
		$this->mdata['layouts'][] = array('layout_id'=>99999, 'name' => $this->language->get('all_page') );		
		$this->mdata['layouts'] = array_merge($this->mdata['layouts'],$this->model_design_layout->getLayouts());

		
		
		$this->template = 'extension/module/pavmegamenu/pavmegamenu.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function render(){

		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');


		$this->mdata['objlang'] = $this->language;
		$this->mdata['olang'] = $this->language; 
		return $this->load->view( $this->template, $this->mdata) ;
	}

	public function redirect( $url ){
		return $this->response->redirect( $url );
	}

	protected function hasPermssion(){
		return $this->user->hasPermission( 'modify', 'extension/module/'.$this->moduleName );	
	}
	/**
	 * Delete Mega Menu Action
	 */
	public function delete(){
		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}
		if( isset($this->request->get['id']) ){
			$this->load->model('menu/megamenu');

			$store_id = isset($this->request->get['store_id'])?$this->request->get['store_id']:0;

			$store = ($store_id == 0)?'':'&store_id='.$store_id;

			$this->model_menu_megamenu->delete( (int)$this->request->get['id'], $store_id );
			
		}
		$this->redirect($this->url->link('extension/module/pavmegamenu', 'token=' . $this->session->data['token'].$store, 'SSL'));
	}

	/**
	 * Update Action
	 */
	public function update(){
		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}
		$data =  ( ($this->request->post['list']) );
		$root = $this->request->get['root'];
	
		$this->load->model('menu/megamenu');
		$this->model_menu_megamenu->massUpdate( $data, $root  );
	}

	/**
	 * Infor Action to Get Mega menu information by id
	 */
	public function info(){
		$id=0;
		
		if( isset($this->request->post) && isset($this->request->post['id']) ){
			$id = (int)$this->request->post['id'] ;
		}else if( isset($this->request->get["id"]) ){
			$id = (int)$this->request->get['id'];
		}
		if (isset($this->request->get['store_id'])){
			$store_id = $this->request->get['store_id'];
			$store_param = "&store_id=".$store_id;
		} else {
			$store_id = 0;
			$store_param = "";
		}
		$default = array(
			'megamenu_id'=>'',
			'title' => '',
			'parent_id'=> '',
			'image' => '',
			'is_group'=>'',
			'width'=>'12',
			'menu_class'=>'',
			'submenu_colum_width'=>'',
			'is_group'=>'',
			'submenu_width'=>'12',
			'column_width'=>'200',
			'submenu_column_width'=>'',
			'colums'=>'1',
			'type' => '',
			'item' => '',
			'is_content'=>'',
			'show_title'=>'1',
			'type_submenu'=>'',
			'level_depth'=>'',
			'status'    => '',
			'position'  => '',
			'show_sub' => '',
			'url' => '',
			'targer' => '',
			'level'=> '',
			'content_text'=>'',
			'submenu_content'=>'',
			'megamenu-information'=>'',
			'megamenu-product'=>'',
			'megamenu-category'=>'',
			'published' => 1,
			'megamenu-manufacturer'=>'',
			'widget_id'=> 0,
			'badges' =>''
		);
		
		$this->language->load('extension/module/pavmegamenu');
		$this->load->model('menu/megamenu');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/information');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$this->mdata['no_image'] = $this->model_tool_image->resize('no_image.jpg', 16, 16);
	
		$this->mdata['entry_image'] = 'Image:';
		$this->mdata['text_image_manager'] = $this->language->get('text_image_manager');
		$this->mdata['text_clear'] = $this->language->get('text_clear');		
		$this->mdata['text_browse'] = $this->language->get('text_browse');
		$this->mdata['tab_module'] = $this->language->get('tab_module');
		$this->mdata['text_none'] = $this->language->get('text_none');
		$this->mdata['yesno'] = array( '0' => $this->language->get('text_no'),'1'=> $this->language->get('text_yes') );
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();
		$this->mdata['informations'] = $this->model_catalog_information->getInformations();
		
		$menu = $this->model_menu_megamenu->getInfo( $id );
		$menu = array_merge( $default, $menu );
		
		
		
		$this->mdata['menu'] = $menu;  
		$this->mdata['menus'] = $this->model_menu_megamenu->getDropdown(null, $menu['parent_id'], $store_id );
		$this->mdata['thumb'] = $this->model_tool_image->resize($menu['image'], 32, 32);
		$this->mdata['menu_description'] = array();
		$descriptions  = $this->model_menu_megamenu->getMenuDescription( $id );
		$this->mdata['menu_description'] = array();
		
		$this->mdata['megamenutypes'] = array(
			'url' => 'URL',
			'category' => 'Category',
			'information' => 'information',
			'product' => 'Product',
			'manufacturer' => 'Manufacturer',
			'html'  => "HTML"
		);
		
		if( $menu['item'] ){
			switch( $menu['type'] ){
				case 'category':
					$category = $this->model_catalog_category->getCategory( $menu['item'] );
					$menu['megamenu-category'] = isset($category['name'])?$category['name']:"";
					
					break;
				case 'product':
					$product = $this->model_catalog_product->getProduct( $menu['item'] );
					$menu['megamenu-product'] = isset($product['name'])?$product['name']:"";
					break;
				case 'information':
						$menu['megamenu-information'] = $menu['item'] ;
					break;
				case 'manufacturer':
					$manufacturer = $this->model_catalog_manufacturer->getManufacturer( $menu['item'] );
					$menu['megamenu-manufacturer'] = isset($manufacturer['name'])?$manufacturer['name']:"";
					break;					
			}
		}
		foreach( $descriptions as $d ){
			$this->mdata['menu_description'][$d['language_id']] = $d;
		}

		if( empty($this->mdata['menu_description']) ){
			foreach(  $this->mdata['languages'] as $language ){
				$this->mdata['menu_description'][$language['language_id']]['title'] = '';
				$this->mdata['menu_description'][$language['language_id']]['description'] = '';
			}
		}
		
		if( isset($this->request->post['megamenu']) ){
			$menu = array_merge($menu, $this->request->post['megamenu'] );
		}


		$this->mdata['menu'] = $menu;
		
		
		$this->mdata['submenutypes'] = array('menu'=>'Menu', 'html'=>'HTML' );
		$this->mdata['text_edit_menu'] = $this->language->get('text_edit_menu');
		$this->mdata['text_create_new'] = $this->language->get('text_create_new');
		$this->template = 'extension/module/pavmegamenu/pavmegamenu_form.tpl';
		$this->response->setOutput($this->render());
	
	}
 	
 	/**
 	 * Check Validation
 	 */
	protected function validate() {
	
		if (!$this->user->hasPermission('modify', 'extension/module/pavmegamenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['pavmegamenu_module'])) { 
	
			foreach ($this->request->post['pavmegamenu_module'] as $key => $value) {
				if (!$value['position'] || !$value['layout_id']) { 
					$this->error['dimension'][$key] = $this->language->get('error_dimension');
				}				
			}
			$languageId = (int)$this->config->get('config_language_id');
			$d = isset($this->request->post['megamenu_description'][$languageId]['title'])?$this->request->post['megamenu_description'][$languageId]['title']:"";
			if( empty($d) ){  
				$this->error['missing_title'][]=$this->language->get('error_missing_title');
			}
			foreach ( $this->request->post['megamenu_description'] as $key => $value) {
				if( empty($value['title']) ){ 
					$this->request->post['megamenu_description'][$key]['title'] = $d; 
				}
				
			}
			if( isset($this->error['missing_title']) ){
				$this->error['warning'] = implode( "<br>", $this->error['missing_title'] );
			}
		}	
						
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	/**
	 * Ajax Menu Information Action
	 */
	public function ajxmenuinfo(){
			$this->language->load('extension/module/pavmegamenu');
		$this->language->load('extension/module/pavmegamenu');
		if (!$this->user->hasPermission('modify', 'extension/module/pavmegamenu')) {
			die( $this->language->get('error_permission') );
		}
		
		$this->load->model('setting/setting');

		if( isset($this->request->post['params']) ) {
			$params = trim(html_entity_decode($this->request->post['params'])); 
			$a = json_decode(($params));
	 
			$this->model_setting_setting->editSetting( 'pavmegamenu_params', array('pavmegamenu_params'=> $params) );

			// die( $this->language->get('message_save_done') );
		}

		return $this->ajxgenmenu();
		
	}

	/**
	 * Live Edit Mega Menu Action
	 */
	public function liveedit(){
		

		$this->language->load('extension/module/pavmegamenu');
		$this->document->addStyle('view/stylesheet/pavmegamenu_live.css');

		$this->template = 'extension/module/pavmegamenu/liveedit.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		 

		$theme = 'default';

		$theme =  $this->config->get('theme_default_directory');
		$this->mdata['filemagement_uri'] = $this->url->link('common/filemanager', '1=1&token=' . $this->session->data['token'], 'SSL'); 

 		$this->document->addStyle('view/javascript/pavbuilder/style.css');
 		
		$this->document->addScript( 'view/javascript/summernote/summernote.js');
		$this->document->addStyle( 'view/javascript/summernote/summernote.css');

		$this->document->addScript( 'view/javascript/pavmegamenu/editor.js');
		$this->document->addScript( 'view/javascript/pavmegamenu/image_gallery.js');
		$this->document->addScript( 'view/javascript/pavmegamenu/widget.js');
		
		$this->document->addStyle(  'view/javascript/font-awesome/css/font-awesome.min.css');

		// $this->document->addStyle( HTTP_CATALOG.'catalog/view/theme/default/stylesheet/stylesheet.css');
		//$this->document->addStyle( HTTP_CATALOG.'catalog/view/theme/default/stylesheet/pavmegamenu/style.css');
 
		$this->load->model( 'menu/widget' );

		$this->mdata['live_site_url'] = HTTP_CATALOG;
		$this->mdata['widgets'] =  $this->model_menu_widget->getWidgets();
		
		
		$store_param = isset($this->request->get['store_id'])?'&store_id='.$this->request->get['store_id']:'';
		
		$this->mdata['liveedit_action'] = $this->url->link('extension/module/pavmegamenu/livesave', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['action_backlink'] = $this->url->link('extension/module/pavmegamenu', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['action_widget'] =  HTTP_CATALOG.'index.php?route=extension/module/pavmegamenu/renderwidget';
		$this->mdata['action_addwidget'] = $this->url->link('extension/module/pavmegamenu/addwidget', 'token=' . $this->session->data['token'].$store_param, 'SSL'); 

		$this->mdata['action_wform'] = $this->url->link('extension/module/pavmegamenu/widgetform', 'token=' . $this->session->data['token'].$store_param, 'SSL'); 



		$this->mdata['ajxgenmenu'] 	   = $this->url->link('extension/module/pavmegamenu/ajxgenmenu', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL'); 
		$this->mdata['ajxmenuinfo'] 	   = $this->url->link('extension/module/pavmegamenu/ajxmenuinfo', 'root=1'.$store_param.'&token=' . $this->session->data['token'], 'SSL'); 
 		$this->mdata['styles']  		   = $this->document->getStyles();
 		$this->mdata['scripts']  	   = $this->document->getScripts();

 

	    $this->model_menu_widget->loadWidgetsEngines();

		$widgets = $this->model_menu_widget->getButtons();

		$this->mdata['widgets'] = $widgets['widgets'];
		$this->mdata['groups'] = $widgets['groups'];

		$this->response->setOutput($this->render());
	}
 

	/**
	 *  Ajax Live Save Action.
	 */
	public function livesave(){
		$this->ajxgenmenu();
	}

	/**
	 * Ajax Render List Tree Mega Menu Action
	 */
	public function ajxgenmenu( ){ 
		
		$this->language->load('extension/module/pavmegamenu');
 		$this->load->model('setting/setting');
		$this->load->model( 'menu/tree' );
	 	$this->load->model( 'menu/widget' );
		$parent 				= '1';
	
		$this->template 		= 'extension/module/pavmegamenu/megamenu-tree.tpl';
		
		/* unset mega menu configuration */
		if( isset($this->request->post['reset']) && $this->hasPermssion() ){
	 		$this->model_setting_setting->editSetting( 'pavmegamenu_params', array('pavmegamenu_params'=>'') ); 
	 	}

	 	$params = $this->model_setting_setting->getSetting( 'pavmegamenu_params' );
	 	
	
	 	if( isset($params['pavmegamenu_params']) && !empty($params['pavmegamenu_params']) ){
	 		$params = json_decode( $params['pavmegamenu_params'] );
	 	}
		
		if (isset($this->request->get['store_id'])){
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

	 
	 	$this->mdata['treemenu'] = $this->model_menu_tree->getTree( 1, true, $params, $store_id );

		echo $this->render();
	}

	/**
	 * Add / Edit  Widget Action
	 */
	public function addwidget(){

		$this->language->load('extension/module/pavmegamenu');
		$this->template = 'extension/module/pavmegamenu/widget_form.tpl';
		$this->document->addStyle( 'view/stylesheet/pavmegamenu/widget.css');
		
		$this->mdata['heading_title'] = $this->language->get('heading_widget_title');

		$this->load->model('setting/setting');
		$this->load->model( 'menu/widget' );

		$model = $this->model_menu_widget; 

		$this->mdata['types'] = $model->getTypes();

		$disabled  		 = false;
		$form 	  		 = '';
		$widget_selected = '';
		$id 			 = 0;
 
		if( isset($this->request->get['id']) && ($id=$this->request->get['id']) ) { 
			$id = (int)$this->request->get['id'];  
		}	


		if( isset($this->request->post['widget']) && isset($this->request->post['params']) ){
			$this->request->post['widget']['params'] = $this->request->post['params'];
			$row = $model->saveData( $this->request->post['widget'] );
			$this->redirect( $this->url->link('extension/module/pavmegamenu/addwidget', 'done=1&id='.$row['id'].'&wtype='.$row['type'].'&token=' . $this->session->data['token'], 'SSL') ); 
		}

		$data = $model->getWidetById( $id );

		if( $data['id'] ){
			$disabled = true;
		}

		if( isset($this->request->get['wtype']) ) {
			$widget_selected =  trim(strtolower($this->request->get['wtype']));	
			$form = $model->getForm( $widget_selected, $data['params'] );
		}
		$this->mdata['widget_data'] = $data;

		if( isset($this->request->get['done']) ){
			 $this->mdata['message'] = $this->language->get('message_update_data_done');
		}
		$this->mdata['id'] 		 = $id;
		$this->mdata['form'] 	 = $form;
		$this->mdata['disabled']  = $disabled; 
		$this->mdata['widget_selected'] = $widget_selected;

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->mdata['languages'] = $languages;



		$this->mdata['action'] = $this->url->link('extension/module/pavmegamenu/addwidget', 'token=' . $this->session->data['token'], 'SSL'); 
		$this->model_menu_widget->getForm( 'html' );

  
 		$this->children = array(
			'common/header',
			'common/footer'
		);
		echo $this->render();
	}


	/**
	 *  Delete Widget Action
	 */
	public function delwidget(){
		if( isset($this->request->get['id']) && $this->hasPermssion() ){
			$this->load->model( 'menu/widget' );

			$id = (int)$this->request->get['id'];

			$this->model_menu_widget->delete( $id );
			 
		}
		$this->redirect($this->url->link('extension/module/pavmegamenu', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function getLang( $text ){
		return $this->language->get($text);
	}
	
	public function widgetform(){
		$this->load->model('setting/setting');
		$this->load->model( 'menu/widget' );
		
		$model = $this->model_menu_widget; 

		if( isset($this->request->get['delete']) &&  $this->hasPermssion() ){
			$model->delete( (int)$this->request->post['id'] );
			die('done');
		}
		if( isset($this->request->get['savedata']) && $this->hasPermssion() && isset($this->request->post['wtype']) ){

			$data = array();
			$data['id'] = $this->request->post['wkey'];
			$data['params'] = $this->request->post; 
			$data['type'] = $this->request->post['wtype'];

		 	$info = $model->saveData( $data );
		 	 
		 	$output = new stdClass();
		 	$output->status = true; 
		 	$output->name =  $this->request->post['widget_name'];
		 	$output->id = $info['id'] ; 
		 	$output->msg = '';
		 	$output->type = $data['type'];
		 	$output->update = $data['id']?true:false;
			
			echo json_encode ( $output );exit();
		}

		if( isset($this->request->post['id']) && $this->hasPermssion() ){
			$id = (int) $this->request->post['id']; 
			$data = array( 'type'=>'', 'params'=> array() );

			if( $id <= 0 && isset($this->request->post['type']) ){
				$data['type'] = $this->request->post['type'];
			}else {	
				$data = $model->getWidetById( $id );	
			}	
			$this->request->post['wkey'] = $id; 
			$data['params']['wkey'] =   $id ;

			 

			$this->model_menu_widget->loadWidgetsEngines();

			$form = $this->model_menu_widget->renderForm( $data['type'], array(), array('params'=>$data['params']) );



			 
			echo '
			<div>
				<div class="wpo-widget-form">
					'.$form.'
				</div>
			</div>';


		 	exit(); 
		}
	}
}
?>
