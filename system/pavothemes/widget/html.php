<?php 
/******************************************************
 *  Leo Opencart Theme Framework for Opencart 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@theme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 * ******************************************************/

class PtsWidgetHtml extends PtsWidgetPageBuilder {

		public $name = 'html';

		
		public static function getWidgetInfo(){
			return  array('label' =>  ('HTML'), 'explain' => 'Create HTML With multiple Language', 'group' => 'others'  );
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
	                    'name' => 'htmlcontent',
	                    'cols' => 40,
	                    'rows' => 10,
	                    'value' => true,
	                    'lang'  => true,
	                    'default'=> '',
	                    'autoload_rte' => true,
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
	            ////    
	                'id_language' => $default_lang
        	);  


			return  $helper->generateForm( $this->fields_form );

		}
		
		public function renderContent(  $args, $setting ){
			
			$t  = array(
				'name'=> '',
				'html'   => '',
			);
			$setting = array_merge( $t, $setting );
			
			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$setting['html'] = isset($setting['htmlcontent_'.$languageID])?($setting['htmlcontent_'.$languageID]): "";
			
			$output = array('type'=>'html','data' => $setting );

	  		return $output;
		}

		 
	}
?>