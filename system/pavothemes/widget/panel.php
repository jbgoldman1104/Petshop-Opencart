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

class PtsWidgetPanel extends PtsWidgetPageBuilder {

		public $name = 'panel';

		public $group = 'typo';

		public $usemeneu = false;
		
		public static function getWidgetInfo(){
			return array('label' =>  ('Panel'), 'explain' => 'Create a Panel for theme', 'group' => 'typo' );
		}


		public function renderForm( $args, $data ){

	 
			$helper = $this->getFormHelper();

			$types[] = array(
		 		'value' => 'text-left',
		 		'text'  => $this->l('Left')
		 	);

		 	$types[] = array(
		 		'value' => 'text-right',
		 		'text'  => $this->l('Right')
		 	);
		 	$types[] = array(
		 		'value' => 'text-center',
		 		'text'  => $this->l('Center')
		 	);

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
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Panel Type' ),
	                    'name' 	  => 'panel_type',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "1",
	                    'desc'    => $this->l( 'Select a panel style' )
	                ),
					 array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Hight light' ),
	                    'name' => 'hightlight',
	                    'desc'  => 'Select Hightlight',
	                    'options' => array(  'query' => array(
	                        array('id' => 'yes', 'name' => $this->l('Yes')),
	                        array('id' => 'no', 'name' => $this->l('No')),
	                    ),
	                    'id' => 'id',
	                    'name' => 'name' ),
	                    'default' => "yes",
	                 ),

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
				'html'   => '',
				'panel_type'	=> ''
			);
			$setting = array_merge( $t, $setting );
			$html = '';
			
			$languageID = $this->config->get('config_language_id');
			$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

			$setting['html'] = isset($setting['htmlcontent_'.$languageID])?html_entity_decode($setting['htmlcontent_'.$languageID],ENT_QUOTES,'UTF-8'): "";
			
			$setting['hight_light']	=	"";
			
			if($setting['hightlight']){
				$setting['hight_light'] = 'hightlight';
			}
 
			$output = array('type'=>'alert','data' => $setting );

	  		return $output;
		}
	}
?>