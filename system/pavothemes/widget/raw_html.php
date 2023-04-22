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

class PtsWidgetRaw_html extends PtsWidgetPageBuilder {

		public $name = 'raw_html';

		
		public static function getWidgetInfo(){
			return array('label' =>  ('Raw HTML'), 'explain' => 'Put Raw HTML Code', 'group' => 'others'  );
		}


		public function renderForm( $args, $data ){
			$helper = $this->getFormHelper();

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
 
	                array(
	                    'type' => 'textarea',
	                    'label' => $this->l('Content'),
	                    'name' => 'raw_html',
	                    'cols' => 40,
	                    'rows' => 10,
	                    'value' => true,
	    
	                    'default'=> '',
	                    'autoload_rte' => false,
	                    'desc'	=> 'Enter HTML CODE in here'
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
			
			$t  = array(
				'name'=> '',
				'raw_html'   => '',
			);

			$setting = array_merge( $t, $setting );
			$html =  $setting['raw_html'];
			
	 		$html = html_entity_decode( $html, ENT_QUOTES, 'UTF-8' );
			$header= '';
			$content = $html;

			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';
			
			$output = array('type'=>'raw_html','data' => $setting );
	  		return $output;
		}
	}
?>