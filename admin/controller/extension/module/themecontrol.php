<?php
/******************************************************
 * @package Pav Opencart Theme Framework for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) October 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

require_once( DIR_SYSTEM . 'pavothemes/framework.php' );
require_once( DIR_SYSTEM . 'pavothemes/theme.php' );

/**
 *
 *
 */
class ControllerExtensionModuleThemeControl extends Controller {

	/**
	 *
	 */
	private $error = array(); 
	
	/**
	 *
	 */
	private $theme = ''; 
	
	/**
	 *
	 */
	private $moduleName = 'themecontrol';
	
	/**
	 *
	 */
	private $theme_path = '';
	
	private $store_id = 0;
	/**
	 *
	 */
	public function setTheme( $theme ){
		$this->theme = $theme;
		return $this;
	}
	
	/**
	 *
	 */
	public function getTheme(){
		return $this->theme;
	}
	

	public $mdata = array();
	/**
	 *
	 */
	public function index() {   

		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		$this->load->language("module/themecontrol");

		$this->mdata['module'] = array(	
						'default_theme' =>'',
						'skin' 			=> '',
						'theme_width'   => 'auto',
						'fontsize'		=>'12',
						'enable_custom_copyright' =>0,
						'copyright' => 'Copyright 2013 ThemeLexus.Com.',
						'responsive' => 1,
						'enable_offsidebars' => 1,
						'enable_customfont' => 0,
						'enable_paneltool'  => 0,
						'enable_footer_center' => 1,
						'block_showcase'  => '',
						'block_promotion' => '',
						'block_footer_top'=>'',
						'block_footer_center' => '',
						'block_footer_bottom'=>'',
						'body_pattern' => '',
						'enable_product_customtab'=>'',
						'product_related_column'=> '',
						'product_customtab_content' => '',
						'product_customtab_name' => '',

						'fontsize1'   => '',
						'type_fonts1' => array(),
						'normal_fonts1' => array(),
						'google_url1' => '',
						'google_family1' => '',
						'body_selector1' => '',
						
						'fontsize2'   => '',
						'type_fonts2' => array(),
						'normal_fonts2' => array(),
						'google_url2' => '',
						'google_family2' => '',
						'body_selector2' => '',
						
						'fontsize3'   => '',
						'type_fonts3' => array(),
						'normal_fonts3' => array(),
						'google_url3' => '',
						'google_family3' => '',
						'body_selector3' => '',

						'fontsize4'   => '',
						'type_fonts4' => array(),
						'normal_fonts4' => array(),
						'google_url4' => '',
						'google_family4' => '',
						'body_selector4' => '',

						'custom_css' =>'',
						'custom_javascript' =>'',
						'bg_image'   => '',
						'use_custombg' => 0,
						'enable_custom_background'=>'',
						'bg_repeat' => 'repeat'	,
						'bg_position' => 'left top'	,
						'listing_products_columns' => '0',
						'listing_products_columns_small' => '2',
						'listing_products_columns_minismall'=> '1',
						'cateogry_display_mode'=>'grid',
						'category_saleicon' => 1,
						'category_pzoom' => 1,	
						'product_enablezoom' => 1,
						'product_zoommode' => 'basic',
						'product_zoomeasing' => 1,		
						'product_zoomlenssize' => 150,
						'product_zoomlensshape' => 'normal',		
						'product_zoomgallery'   => 0,		
						'show_swap_image'			=> 0,	
						'location_address' => '79-99 Beaver Street, New York, NY 10005, USA',
						'location_latitude' => '40.705423',
						'location_longitude' => '-74.008616',
						//end edit code
						'contact_customhtml'    => '',
						'enable_compress_css'   => 0,
						'exclude_css_files'     => 'bootstrap.css',
						'enable_development_mode' => 0,
						'customize_theme' => ''
											
		);
		if( !isset($this->session->data['store_id']) ){
			$this->session->data['store_id'] = $this->store_id;
		}
		if( isset($this->request->get['store_id']) ){
			$this->session->data['store_id'] =  $this->request->get['store_id'];
		}

		$this->store_id =	$this->session->data['store_id'];
		

		// store listing 
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
			$store['option'] = $this->url->link('extension/module/pavmegamenu', $url.'&token=' . $this->session->data['token'], 'SSL');
		}
		$this->mdata['stores'] = $stores;
	 

		$storeConfig = $this->model_setting_setting->getSetting('theme_default', $this->store_id );

	
 		$module = $this->getSettingByStore( $this->moduleName );

 		if ( $this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
		 	if(  isset($this->request->post['action_type']) &&  $this->request->post['action_type'] == 'save-importprofile' && ($this->request->server['REQUEST_METHOD'] == 'POST') ){

				if( isset($_FILES['upload']['tmp_name']) && $_FILES['upload']['tmp_name'] ){
					$content = trim(file_get_contents( $_FILES['upload']['tmp_name'] ));
					if( !empty($content) ) {
						$profile = @unserialize( $content ); 
						if( isset($profile['modules']) ) { 
							$this->load->model('sample/module');
							$this->model_sample_module->importProfiles(  $profile, array(), $this->themeName );
						} 
				 		$this->mdata['alert_info'] = $this->language->get('alert_import_profile_success');
					}	
				}
				$this->request->server['REQUEST_METHOD'] = 'GET';
				$this->request->post = null;

			}
		}

		if( empty($module) ) {  
			$default_data = array();
			$default_data[$this->moduleName]=$this->mdata['module'];
			$this->model_setting_setting->editSetting( $this->moduleName, $default_data, $this->store_id );	 
			$this->mdata['first_installation'] = 1;
		}


		if (isset($this->request->post[$this->moduleName])) {
			$this->mdata['module'] = $this->request->post[$this->moduleName];
		} elseif (  $this->getSettingByStore( $this->moduleName ) ) {  
			$this->mdata['module'] = array_merge($this->mdata['module'],$module);
		}	

		$this->mdata['module']['default_theme'] = $storeConfig['theme_default_directory'];

		$this->document->addStyle('view/stylesheet/themecontrol.css');
		$this->document->addScript('view/javascript/jquery/jquerycookie.js');
		$this->document->addScript('view/javascript/jquery/themecontrol.js');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');

		$this->document->addStyle('view/javascript/jquery/ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/jquery/ui/jquery-ui.min.js');



		$this->load->language('extension/module/'.$this->moduleName);	
		
		$this->document->setTitle( strip_tags($this->language->get('heading_title')) );
				
		$this->mdata['heading_title'] = $this->language->get('heading_title');
		
		// themes 
		$directories = (array)glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		$this->mdata['templates'] = array();
		if(isset($directories) && !empty($directories)){
			foreach ($directories as $directory) {	 
				if( file_exists($directory."/etc/config.ini") ){
					$this->mdata['templates'][] = basename($directory);
				}
			}
		}


		if( count($this->mdata['templates']) && empty($this->mdata['module']['default_theme'])  ){  
			$this->mdata['module']['default_theme'] = $this->mdata['templates'][0];	
		}	
	
		$this->setTheme( $this->mdata['module']['default_theme']  ); 		
	
		$this->mdata['skins']	 = PavoThemeHelper::getSkins( $this->getTheme() );

		$this->mdata['hasskinsprofile'] = false; 
		if( $this->mdata['skins'] ){
			foreach( $this->mdata['skins'] as $skin ){
				if( file_exists(PavoThemeHelper::getPathProfileBySkin( $this->getTheme(), $skin )) ){
					$this->mdata['hasskinsprofile'] = true;
					break;
				}
			}	
		}

		$this->mdata['theme_url'] = HTTP_CATALOG."/catalog/view/theme/".$this->getTheme()."/";
		$this->themePath 	 	 = DIR_CATALOG . 'view/theme/'.$this->getTheme().'/';

		if( is_file($this->themePath.'stylesheet/font-awesome.css') ){     
			$this->document->addStyle(  HTTP_CATALOG."/catalog/view/theme/".$this->getTheme()."/stylesheet/font-awesome.css" );
		}	
		//

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 

			$data = $this->request->post['themecontrol'];
			$a = $this->request->post['action_type']; 
 
			$this->request->post= array();
			$this->request->post['themecontrol'] = $data;
 			/**/
 			 

			if( is_dir($this->themePath.'stylesheet/local/') ){
				$t = $this->themePath.'stylesheet/local/custom.css';
				if( $data['custom_css'] ) {
					PavoThemeHelper::writeToCache( $this->themePath.'stylesheet/local/', 'custom', $data['custom_css'], 'css' );	
				}else if( file_exists($t) && filesize($t) ){
					@unlink($t);
					PavoThemeHelper::writeToCache( $this->themePath.'stylesheet/local/', 'custom', "", 'css' );	
				}
			}

			$this->request->post['themecontrol']['custom_css'] = '';
			$this->model_setting_setting->editSetting($this->moduleName, $this->request->post, $this->store_id );	 
			$this->session->data['success'] = $this->language->get('text_success');

			if( isset($data['enable_activeprofile']) && $data['enable_activeprofile'] ){
				$this->load->model('sample/module');
			 	$this->model_sample_module->setActiveByProfileSkin( $this->getTheme(), $data['skin'] );
			}
			 
			if( $a == 'save-edit'  ){
				$this->response->redirect($this->url->link('extension/module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
			}else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL'));
			}
		}
		

		$this->mdata['text_saveandstay'] = $this->language->get( 'text_saveandstay' );
		$this->mdata['text_save'] = $this->language->get( 'text_save' );

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
		$this->mdata['button_save_keep'] = $this->language->get('button_save_keep');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		$this->mdata['default_theme'] = '';
		$this->mdata['text_image_manager'] = $this->language->get('text_image_manager'); 
		// table
		$this->mdata['tab_general'] = $this->language->get( 'tab_general' );
		$this->mdata['tab_layout'] = $this->language->get( 'tab_layout' );
		$this->mdata['tab_font'] = $this->language->get( 'tab_font' );
		$this->mdata['tab_custom'] = $this->language->get( 'tab_custom' );
		$this->mdata['yesno'] = array(0=>$this->language->get('text_no'),1=>$this->language->get('text_yes'));
		$this->mdata['bg_thumb'] =  '';
		$this->mdata['no_image'] =  $this->model_tool_image->resize('no_image.jpg', 180, 180);
		
		$this->mdata['patterns'] = PavoThemeHelper::getPattern( $this->getTheme() );

		$this->mdata['product_rows'] = array('0'=> $this->language->get('text_auto'), 4=>4,5=>5,6=>6 );

		$this->mdata['product_rows_tablet'] = array('0'=> $this->language->get('text_auto'), 1=>1, 2=>2, 3=>3, 4=>4);

		$this->mdata['product_rows_mobile'] = array('0'=> $this->language->get('text_auto'), 1=>1, 2=>2 );


		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['category_saleicons'] = array(
			'text_sale' => 'Sale',
			'text_sale_detail' => 'Saved %s',
			'text_sale_percent' => 'Number %'
		);

		$this->themeLayoutCustomize();

		$this->mdata['product_zoomgallery'] = array( 
			'basic'  => $this->language->get('text_basic_zoom'),
			'slider' => $this->language->get('text_slider_gallery_zoom')
		);

		$this->mdata['product_zoom_modes'] = array(
			'basic' => $this->language->get('text_basic_zoom'),
			'inner'	=> $this->language->get('text_inner_zoom'),
			'lens'	=> $this->language->get('text_lens_zoom')
		);
	 
		$this->mdata['product_zoomlensshapes'] = array(
			'basic' => $this->language->get('text_len_zoom_basic'),
			'round'	=> $this->language->get('text_len_zoom_round'),
			 
		);
		$this->mdata['type_fonts'] = array(
								array( 'standard', 'Standard'),
								array( 'google', 'Google Fonts'),						
		);
		$this->mdata['compressions'] = array(
			'' => $this->language->get('text_compress_select'),
			'compress-only'  => $this->language->get('text_compress_only'),
			'compress-merge' => $this->language->get('text_compress_merge')
		);
		$this->mdata['bg_repeat'] = array('repeat','repeat-x','repeat-y','no-repeat');	
		$this->mdata['bg_position'] = array('left top','left center','left bottom','center top','center','center bottom','right top','right center','right bottom');	
		
		if( is_dir(DIR_APPLICATION.'model/sample/') && $this->getTheme() ){
			$this->mdata['unexpectedModules']  = array();
			$this->mdata['modulesQuery'] = array();

			$this->load->model('sample/module');
			$this->mdata['samples'] = $this->model_sample_module->getSamplesByTheme( $this->getTheme() );
			$this->mdata['backup_restore'] = $this->model_sample_module->getBackupByTheme( $this->getTheme() );

			if( !empty($this->mdata['samples']) ){
				$this->mdata['modulesQuery'] = $this->model_sample_module->getModulesQuery( $this->getTheme() );
				$tmodules = array_merge($this->mdata['samples'],$this->mdata['modulesQuery']);
				$this->mdata['unexpectedModules'] = $this->getUnexpectedModules( 1, $tmodules );
			}
			
			if( isset($this->request->get['exportprofile']) && $this->hasPermission() ){
				 $this->model_sample_module->exportProfiles( $this->getTheme() );
			}

	
			if( isset($this->request->get['export']) && $this->hasPermission() ){
				 $this->model_sample_module->export( $this->getTheme() );
			}

			if( isset($this->request->get['backup']) && $this->hasPermission() ){
				 $this->model_sample_module->backup( $this->getTheme() );
				 $this->response->redirect($this->url->link('extension/module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'));
			}
		
			if( isset($this->request->get['ajax_massinstall']) && !empty($this->mdata['samples']) ) { 
				$this->model_sample_module->massInstallSample( $this->getTheme(), $this->mdata['samples'] );
				die('done');
			}
		}
		
		$this->mdata['normal_fonts'] = PavoThemeHelper::getLocalFonts();
							
		 //general 
		$this->mdata['fontsizes'] = PavoThemeHelper::getFontSizes();

	 	$fontbase = array();
	 	$fontbase[1] = array(
	 		'label'	=> $this->language->get('text_body_font_setting'),
	 		'selector' => 'body',
	 		'fontsize'	=> 12
	 	);
	 	$fontbase[2] = array(
	 		'label'	=> $this->language->get('text_pageheading_font_setting'),
	 		'selector' => 'h1, #content h1',
	 		'fontsize'	=> 12
	 	);
	 	$fontbase[3] = array(
	 		'label'	=> $this->language->get('text_moduleheading_font_setting'),
	 		'selector' => 'h2,h3,h4,h5, .box-heading, .box-heading span',
	 		'fontsize'	=> 12
	 	);

	 	$this->mdata['fontbase'] = $fontbase;


		$this->mdata['cateogry_display_modes'] = array( 'grid'=> $this->language->get('text_grid') , 'list' => $this->language->get('text_list') );
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
		
		$this->mdata['token'] = $this->session->data['token'];
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
			'href'      => $this->url->link('extension/module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->mdata['action'] = $this->url->link('extension/module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['exportprofile_action'] = $this->url->link('extension/module/'.$this->moduleName, 'exportprofile=1&token=' . $this->session->data['token'], 'SSL');

		$this->mdata['ajax_modules_position'] = $this->url->link('extension/module/'.$this->moduleName."/ajaxsave", 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['ajax_massinstall'] = $this->url->link('extension/module/'.$this->moduleName."", 'ajax_massinstall=1&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['ajax_clearcache'] = $this->url->link('extension/module/'.$this->moduleName."/clearcache", 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['ajax_compileless'] =HTTP_CATALOG.'?compileless=1';
		
		$this->mdata['live_customizing_url'] =  $this->url->link('extension/module/'.$this->moduleName."/customize", 'store_id='.$this->store_id.'&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
					
		$this->load->model('design/layout');
		
		
		$t = DIR_CATALOG . 'view/theme/'.$this->getTheme().'/template/common/admin/modules.tpl';
		$this->mdata['layouttpl'] = 	DIR_CATALOG . 'view/theme/'.$this->getTheme().'/template/common/admin/layout-setting.tpl'; 

		if( file_exists($t) ){
			$this->mdata['admin_modules'] = $t;
		}
	
		$this->mdata['layouts'] = $this->model_design_layout->getLayouts();
		$this->load->model('design/banner');
		
		$this->mdata['banners'] = $this->model_design_banner->getBanners();	
		$this->mdata['imodules'] = PavoThemeHelper::getInternalModules( $this->getTheme() );	
	 
		
		$this->tabModules();
		$this->load->model('localisation/language');
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();
		$this->mdata['logo_types'] = array(
			'' => $this->language->get('logo_system'),
			'logo-text' => $this->language->get('logo_text'),
			'logo-image' =>  $this->language->get('logo_image'),
		);
	 	
	 	/** CUSTOMIZATION THEME */
	 
	 	$this->themeCustomizePath = $this->themePath.'stylesheet/customize/';
	 	$this->mdata['customizeFolderURL'] = HTTP_CATALOG.'catalog/view/theme/'.$this->getTheme().'/stylesheet/customize/';
	 	$this->mdata['files'] = PavoThemeHelper::getFileList( $this->themeCustomizePath , '.css' );
	 	$this->mdata['development_mode'] = array(
	 		'' 				 => $this->language->get( 'text_no' ),
	 		'compile-export' => $this->language->get( 'text_compile_export' ),
	 		'compile'		 => $this->language->get( 'text_compile_only' )
	 	);
 	
 		if( file_exists($this->themePath.'stylesheet/local/custom.css') ){
 			$content = file_get_contents( $this->themePath.'stylesheet/local/custom.css' );
 			$this->mdata['module']['custom_css'] = $content;
 		}

 		$this->mdata['themeinfo'] = PavoThemeHelper::getThemeInfo( $this->getTheme() );

 		 
 		$this->checkingInfo();

 


		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
		$this->mdata['placeholder']  = $this->model_tool_image->resize('no_image.png', 100, 100);
		$this->mdata['toolimage']  = $this->model_tool_image;
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');
		$this->mdata['olang'] = $this->language; 
		$this->mdata['store_id'] = $this->store_id;
		$this->mdata['ourl'] = $this->url;
		$this->mdata['refreshmodify'] = $this->model_setting_themecontrol->checkModifycation( );	
		$this->mdata['refreshmodifylink'] =  $this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL');
		$this->response->setOutput($this->load->view(   'extension/module/themecontrol/'.$this->moduleName.'.tpl', $this->mdata) );



	}

	public function install(){

		 $this->load->model('setting/themecontrol');
		 $this->model_setting_themecontrol->checkModifycation( );	
	}

	public function themeLayoutCustomize(){
		$this->mdata['theme_customizations'] =  PavoThemeHelper::getLayoutSettingByTheme( $this->getTheme() );
	}

	public function checkingInfo(){
		$customFilesWarning = array();
		$developmentWraning = array();
		if( !is_writable($this->themePath.'stylesheet/local/custom.css') ) {
			$customFilesWarning[] = $this->language->get( 'warning_file_permssion_local_custom' )
						. ': <span>'.$this->themePath.'stylesheet/local/custom.css'.'</span>';
		}

		if( !is_writable($this->themePath.'stylesheet/customize') ) {
			$customFilesWarning[] = $this->language->get( 'warning_file_permssion_live_custom' )
					. ': <span>'.$this->themePath.'stylesheet/customize'.'</span>';
		}

		if( !is_writable($this->themePath.'stylesheet') ){
			$developmentWraning[] = $this->language->get( 'warning_file_permssion_development_folder' )
					. ': <span>'.$this->themePath.'stylesheet'.'</span>';
		}

		$this->mdata['warning_custom_files_permission'] 		= $customFilesWarning;
		$this->mdata['warning_development_files_permission'] = $developmentWraning;

	}

	public function redirect( $route, $param, $ssl ){
		return $this->response->redirect( $route, $param, $ssl );
	}

	public function getSettingByStore( $group ){
		$data = $this->model_setting_setting->getSetting( $group, $this->store_id );
		return isset( $data[$group] )?$data[$group] :array();
	}
	/**
	 *
	 */
	public function customize(){ 

		$this->load->model('setting/setting');
		$this->language->load( 'extension/module/themecontrol' ) ;
	 
		$storeConfig = $this->model_setting_setting->getSetting('theme_default', $this->store_id );
		
		if( empty($storeConfig) ){
			die(  $this->language->get('text_has_error_missing_config_store') );
		}
		
		$theme = $storeConfig['theme_default_directory'];

	 	$this->theme = $theme;  

	 	$this->mdata['heading_title'] = $this->language->get('heading_title');
		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
	 		$siteURL = HTTPS_CATALOG;
	 		$adminURL = HTTPS_SERVER;
	 	}else {
	 		$siteURL  = HTTP_CATALOG;
	 		$adminURL = HTTP_SERVER;
	 	}	

	 	$this->themePath 				   = DIR_CATALOG . 'view/theme/'.$theme.'/';
	 	$this->themeCustomizePath 		   = $this->themePath.'stylesheet/customize/';
	 	$this->mdata['customize_form_path'] = '';
	 	$this->mdata['themeName'] 		   = $theme;
	 	$this->mdata['siteURL'] 			   = $siteURL;
	 	$this->mdata['adminURL'] 		   = $adminURL;
	 	$this->mdata['themePath'] 		   = $this->themePath;
	 	$this->mdata['customizeFolderURL']  = $siteURL.'catalog/view/theme/'.$theme.'/stylesheet/customize/';
	 	$this->mdata['backgroundImageURL']  = $siteURL.'catalog/view/theme/'.$theme.'/image/pattern/';
	 	$this->mdata['token'] 			   = $this->session->data['token'];
	 	$this->mdata['patterns'] 		   = PavoThemeHelper::getPattern( $this->getTheme() );


 		$this->mdata['xmlselectors'] 	= PavoThemeHelper::getThemeEditor( $this->getTheme() ); 
 

	 	if( !is_dir($this->themeCustomizePath) ){
	 		$this->mdata['warning'][] = $this->language->get('warning_theme_customize_folder_not_exists');
	 	}
 
	 	if( !is_writable($this->themeCustomizePath) ){
	 		$this->mdata['warning'][] = $this->language->get('warning_theme_customize_folder_writeable');
	 	}
	 	 
 
		$this->document->setTitle( strip_tags($this->language->get('heading_title')) );
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$data = $this->request->post;

			$selectors = $this->request->post['customize'];
			$matches = $this->request->post["customize_match"];
			$output = '';

			$cache = array();
			$tmpss = array();
			foreach( $selectors as $match => $customizes  ){
		 
				foreach( $customizes as $key => $customize ){
					if( isset($matches[$match]) && isset($matches[$match][$key]) ){
						$tmp = explode("|", $matches[$match][$key]);
						if( trim($customize) ) {
							if( strtolower(trim($tmp[1])) == 'background-image'){
								$tmpss[$tmp[0]][] =  $tmp[1] . ':url('.$customize .')';	
							}else {
								$prefix = preg_match( "#color#i", $tmp[1] )?"#":"";
								$suffix = preg_match( "#size#i", $tmp[1] )?"px":"";
								$tmpss[$tmp[0]][] =  $tmp[1] . ':'.$prefix.$customize.$suffix; 		
							}
						}
						$cache[$match][] =  array('val'=>$customize,'selector'=>$tmp[0], 'attr' => $tmp[1] );
					}
				}	

			}

			$output = '';

			foreach( $tmpss as $key => $values ){
				$output .= "\r\n/* customize for $key */ \r\n";
				$output .= $key ." { \r\n".implode( ";\r\n", $values )." \r\n} \r\n";
			}
			 
			if(  !empty($data['saved_file'])  ){
				if( $data['saved_file'] && file_exists($this->themeCustomizePath.$data['saved_file'].'.css') ){
					unlink( $this->themeCustomizePath.$data['saved_file'].'.css' );
				}
				if( $data['saved_file'] && file_exists($this->themeCustomizePath.$data['saved_file'].'.json') ){
					unlink( $this->themeCustomizePath.$data['saved_file'].'.json' );
				}
				$nameFile = $data['saved_file'];
			}else {
				if( empty($this->request->post['newfile']) ){
					$nameFile = time();
				}else {
					$nameFile = preg_replace("#\s+#", "-", trim($this->request->post['newfile']));
				}
			}
		
			if( $data['action-mode'] != 'save-delete' ){
				
			 	if( !empty($output) ){
			 		PavoThemeHelper::writeToCache( $this->themeCustomizePath, $nameFile, $output,"css" );
			 	}
			 	if( !empty($cache) ){
			 		PavoThemeHelper::writeToCache(  $this->themeCustomizePath, $nameFile, json_encode($cache),"json" );
			 	}

			 }	
			  
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module/'.$this->moduleName.'/customize', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->mdata['heading_title'] = $this->language->get('heading_title');
		$this->mdata['back_url']     = $this->url->link('extension/module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['upload_link']  = $this->url->link('extension/module/'.$this->moduleName.'/upload', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['list_file'] = $this->language->get('list_file');
	 	
	 	$this->mdata['files'] = PavoThemeHelper::getFileList( $this->themeCustomizePath , '.css' );

	 	

 		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}

  	 
		
		$this->mdata['action'] = $this->url->link('extension/module/'.$this->moduleName.'/customize', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['themeName'] = $theme;
	  	$this->mdata['localfonts'] =  PavoThemeHelper::getLocalFonts();
  	 	$this->mdata['header'] = $this->load->controller('common/header');
  	 	$this->mdata['footer'] = $this->load->controller('common/footer');
		$this->mdata['store'] = $siteURL;
		
		$customizeForm = '';
		 
		$this->template = 'extension/module/themecontrol/customize.tpl';
		$this->response->setOutput( $this->render() );
	}

	public function render(){
		$this->mdata['olang'] = $this->language; 
		$this->mdata['oconfig'] = $this->config; 
		return $this->load->view( $this->template, $this->mdata );
	}
	/**
	 *
	 */
	public function upload(){
		if( $this->hasPermission() ){
			 
		}else {
			die( $this->language->get('error_permission') );
		}
	}

	/**
	 * 
	 */
	public function getUnexpectedModules( $layout_id, $tmodules ){ return array();
		$this->load->model('setting/themecontrol');
		$extensions = $this->model_setting_themecontrol->getExtensions('module');		
		$module_data = array();
		foreach ($extensions as $extension) {
			if ( file_exists(DIR_APPLICATION . 'controller/module/' . $extension['code'] . '.php')) {	
				$modules = $this->config->get($extension['code'] . '_module');
				$this->language->load('extension/module/'.$extension['code']);	
				if ($modules) {
					foreach ($modules as $index => $module) {  
						if( ($module['layout_id'] == $layout_id || $module['layout_id'] == 99999) && $module['status'] && !isset($tmodules[$extension['code']]) ){
							$module_data[] = array(
								'title'      => ($this->language->get('heading_title')),
								'code'       => $extension['code'],
								'setting'    => $module,
								'sort_order' => $module['sort_order'],
								'status'     => $module['status'],
								'index'      => $index
							);				
						}
					}
				}
			}	
			$this->language->load('extension/module/'.$this->moduleName);	
		}
		return $module_data;
	}
	
	
	
	 
	/**
	 * 
	 */
	public function tabModules() {
		$this->mdata['elayout_default'] = 1;
		if( isset($this->request->get['elayout_id']) ){
			$this->mdata['elayout_default'] = $this->request->get['elayout_id'];	
		}
		

		$this->load->model('setting/themecontrol');
		$this->load->language('design/layout');

		$layout_mods = $this->model_setting_themecontrol->getLayoutModules(  $this->mdata['elayout_default'] );

 
		$this->load->model('extension/extension');
		$this->load->model('extension/module');

		
		$data['modules'] = array();
		
		 $data['extensions'] = array();
		
		// Get a list of installed modules
		$extensions = $this->model_extension_extension->getInstalled('module');
		
		$module_data = array();

		// Add all the modules which have multiple settings for each module
		foreach ($extensions as $code) {
			$this->load->language('extension/module/' . $code);
			$modules = $this->model_extension_module->getModulesByCode($code);
			
			foreach ($modules as $module) {

				$module_data[$code . '.' .  $module['module_id']] = array(
					'title' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
					'name' => $this->language->get('heading_title') . ' &gt; ' . $module['name'],
					'code' => $code,
					'module_id' => $module['module_id'],
					'status'	=> 1,
					'index' => $code . '.' .  $module['module_id'],
				);
			}
			if ( $this->config->has($code . '_status') && count($modules) <= 0  ){
				$module_data[$code] = array(
					'title' => $this->language->get('heading_title'),
					'name' => $this->language->get('heading_title'),
					'code' => $code,
					'module_id' => '',
					'status'	=> 1,
					'index' => $code,
				);
			}
		}
  	 	
  	 	$mls = array(); 

  	 	foreach( $layout_mods as $lmod ){
  	 		if( isset($module_data[$lmod['code']]) ) { 
  	 			$mls[$lmod['position']][] = $module_data[$lmod['code']];
  	 			unset( $module_data[$lmod['code']] );
  	 		}
  	 	}
  	
  		
  		//  echo '<Pre>'.print_r( $module_data ,1 );die; 

		$this->mdata['layout_modules'] = $mls;
		$this->mdata['unhookmodules']  = $module_data;
	
		//$this->mdata['modslays'] = $modslays;

	}
	

	
	/**
	 *
	 */
	public function getLang( $key ){
		return $this->language->get( $key ); 
	}
	
	/**
	 *
	 */
	public function getConfig( $config ){
		return ''.$config;
	}
	
	/**
	 *
	 */	
	public function hasPermission(){
		return $this->user->hasPermission('modify', 'extension/module/'.$this->moduleName);
	}

	/**
	 * Validation
	 */
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
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
	public function installsample(){

		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}	
		
		if( is_dir(DIR_APPLICATION.'model/sample/') ){
			$this->load->model('sample/module');
			if( isset($this->request->get['type']) && $this->request->get['type']== 'query' ){
				$this->model_sample_module->installSampleQuery( $this->request->get['theme'] , $this->request->get['module'] );
			}else {
				$this->model_sample_module->installSample( $this->request->get['theme'] , $this->request->get['module'] );
			}
		}
		die( "done" );
	}

	/**
	 * 
	 */
	public function restore(){

		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}	
		
		if( is_dir(DIR_APPLICATION.'model/sample/') ){
			$this->load->model('sample/module');
			if( isset($this->request->get['type']) && $this->request->get['type']== 'query' ){
				//$this->model_sample_module->installSampleQuery( $this->request->get['theme'] , $this->request->get['module'] );
			}else {
				$this->model_sample_module->restoreDataModule( $this->request->get['theme'] , $this->request->get['module'] );
			}
		}
		die( "done" );
	}
	 
	/**
	 * 
	 */
	public function storesample(){
		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}	

		if( is_dir(DIR_APPLICATION.'model/sample/') ){
			$this->load->model('sample/module');
			$this->model_sample_module->installStoreSample( $this->request->get['theme']  );
		}	
	}
	
	/**
	 *
	 */	
	public function clearcache(){
		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}

		define( "PAV_CSS_CACHE", DIR_CACHE."pavo-asset/" );
		if( is_dir(PAV_CSS_CACHE) ) {
			$files = glob( PAV_CSS_CACHE . '*.css' );
			if ($files) {
				foreach ($files as $file) {
					if ( is_file($file) ) {
						@unlink($file);
					}
				}
			}
		}
		die('done');	
	}

	 
	/**
	 * Ajax Save Content
	 */
	public function ajaxsave(){

		if (!$this->user->hasPermission('modify', 'extension/module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
		}	

		$this->load->model('setting/setting');
		$this->load->model('design/layout');
		if( isset($this->request->post['modules']) ){
			$modules = $this->request->post['modules'];
			$layout_info = $this->model_design_layout->getLayout($this->request->get['layout_id']);

			$data = array();	
			$data['name'] =  $layout_info['name'];
			$data['name'] =  $layout_info['name'];
			
			$data['layout_route'] = $this->model_design_layout->getLayoutRoutes($this->request->get['layout_id']);
			$data['layout_module']  = array();// $this->model_design_layout->getLayoutModules($this->request->get['layout_id']);		
			$layout_module = array();

			$i = 0;
			if( isset($modules['unhookpos']) ){
				$modules['unhookpos'] = null;
				unset($modules['unhookpos']);
			}


			foreach( $modules  as $position => $mods ){	
			
				foreach( $mods as $mod ){
					$layout_module [] = array(
						'code'		 => $mod ,
						'position'   => $position,
						'sort_order' =>  $i++
					);
				}
				$i = 0;
			 
			}
			$data['layout_module'] = $layout_module;
	 // echo '<pre>'.print_r( $data ,1 );die; 
			if( $layout_module ){  
				$this->model_design_layout->editLayout($this->request->get['layout_id'], $data);
			}
		}
		die();
	}
}