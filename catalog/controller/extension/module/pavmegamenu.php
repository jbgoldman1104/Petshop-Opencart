<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2012 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

 require_once(DIR_SYSTEM . 'pavothemes/loader.php');	
class ControllerExtensionModulePavmegamenu extends Controller {

	public $data;
	public function index($setting) {
		static $module = 0;
			
		$this->load->model('catalog/product'); 
		$this->load->model('tool/image');
		$this->load->model( 'menu/megamenu' );
		
		$this->language->load('extension/module/pavmegamenu');

		// fix bug version 2.2.0.0
		$config_theme = $this->config->get('theme_default_directory');

	
		$this->data['button_cart'] = $this->language->get('button_cart');
		if (file_exists('catalog/view/theme/' . $config_theme . '/stylesheet/pavmegamenu/style.css')) {
			$this->document->addStyle('catalog/view/theme/' . $config_theme . '/stylesheet/pavmegamenu/style.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavmegamenu/style.css');
		}
		
		 
		$params = $this->config->get( 'params' );
	 	
		$this->load->model('setting/setting');
		$params = $this->model_setting_setting->getSetting( 'pavmegamenu_params' );

		 
		if( isset($params['pavmegamenu_params']) && !empty($params['pavmegamenu_params']) ){
	 		$params = json_decode( $params['pavmegamenu_params'] );
	 	}
		
		//get store
		$store_id = $this->config->get('config_store_id');
		$this->data['store_id'] = $store_id;

		$parent = '1';
		$this->data['treemenu'] = $this->model_menu_megamenu->getTree( $parent, true, $params, $store_id);
 

		$template = 'extension/module/pavmegamenu';
		return $this->load->view($template, $this->data);

	}

	public function ajxgenmenu( ){ 
 	 	
	}

	public function renderwidget(){

		$this->load->model( 'menu/widget' );
		$this->model_menu_widget->loadWidgets();

		if( isset($this->request->post['widgets']) ){
		
			
			$widgets = $this->request->post['widgets'];
			$widgets = explode( '|wid-', '|'.$widgets );
			if( !empty($widgets) ){
				unset( $widgets[0] );
			
				$output = '';
				foreach( $widgets as $wid ){
					$output .= $this->model_menu_widget->renderButton( $wid );
				}

				echo $output;
			}
		 
		}
		exit();
	}
	

}
?>