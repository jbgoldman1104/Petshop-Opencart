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

class PtsWidgetModule extends PtsWidgetPageBuilder {

		public $name = 'alert';

		public $group = 'typo';

		public $usemeneu = false;

		public static function getWidgetInfo(){
			return array('label' =>  ('Load Opencart Module'), 'explain' => 'Load Opencart Module as Widget', 'group' => 'opencart' );
		}


		public function renderForm( $args, $data ){

			$helper = $this->getFormHelper();
			// $hooks = Hook::getHooks();
			$id_shop = Context::getContext()->shop->id;
			
			if( isset($data['params']['hookmodule']) ){
				$hid = Hook::getIdByName( $data['params']['hookmodule'] );
				
				if( $hid ){ 
					$hms = Hook::getModulesFromHook( $hid );

					foreach( $hms as $hm ){

						if( $data['params']['loadmodule'] == $hm['name'] ){
							$id_module  = $hm['id_module'];
						 	$module = Module::getInstanceById($id_module);
							if ( Validate::isLoadedObject($module) ) {
								!$module->unregisterHook( (int)$hid, array($id_shop) );
							}
						}
					}
				}
			}

			$modules = Module::getModulesInstalled(0);
			$output = array();
			/*
			foreach( $hooks as $k => $hook ){
				if( preg_match("#display#", $hook['name'] ) && $hook['live_edit'] ){
					$output[] = $hook;
				}
			}
			*/

			$hooks =  array(
				'displayHome',
				'displayLeftColumn',
				'displayRightColumn',
	            'displayTop',
	            'displayHeaderRight',
	            'displaySlideshow',
	            'topNavigation',
				'displayMainmenu',
	            'displayPromoteTop',
	            'displayRightColumn',
	            'displayLeftColumn',
	            'displayHome',
	            'displayFooter',
	            'displayBottom',
	            'displayContentBottom',
	            'displayFootNav',
	            'displayFooterTop',
	            'displayMapLocal',
	            'displayFooterBottom',
	        );
 			
 			foreach( $hooks as $hook ){
 				$output[] = array( 'name' => $hook, 'id'=> $hook );
 			}

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	            
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Select A Module' ),
	                    'name' 	  => 'loadmodule',
	                    'options' => array(  'query' => $modules ,
	                    'id' 	  => 'name',
	                    'name' 	  => 'name' ),
	                    'default' => "1",
	                    'desc'    => $this->l( 'Select A Module is used as widget. the hook of this module was unhooked.' )
	                ),

	                 array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Select A Hook' ),
	                    'name' 	  => 'hookmodule',
	                    'options' => array(  'query' => $output ,
	                    'id' 	  => 'name',
	                    'name' 	  => 'name' ),
	                    'default' => "1",
	                    'desc'    => $this->l( 'Select A hook is used to render module\'s content. the hook of this module was unhooked. You could not rollback it\'s position. So you need asign it in position management of opencart.' )
	                )
	            ),
	      		 'submit' => array(
	                'title' => $this->l('Save'),
	                'class' => 'button'
           		 )
	        );

 
		 	$default_lang = (int)$this->config->get('config_language_id');
			$a = $this->getConfigFieldsValues( $data  );
 
			$helper->tpl_vars = array(
	                'fields_value' => $a,
	                
	                'id_language' => $default_lang
        	);  


			return  $helper->generateForm( $this->fields_form );
		}

		public function renderContent(  $args, $setting ){
			
			$t  = array(
				'name'=> '',
				'loadmodule'   => '',
				'hookmodule' => '' 
			);
				
			$setting = array_merge( $t, $setting );
			$html = '';
			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

	 	 	// $data = PtsPagebuilderHelper::moduleExec( $setting['hookmodule'], $setting['loadmodule'] );
 			
	 	 	// $setting['content'] = $data;
	 	 	$setting['tabname'] = 'blogs'.time();

			$output = array('type'=>'module','data' => $setting );

	  		return $output;
		}
	}
?>