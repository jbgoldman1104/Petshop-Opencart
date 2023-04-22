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
	
	/**
	 * Abstract Class PtsWidgetBase
	 */
abstract class  PtsWidgetPageBuilder extends Model {
	

	public $modName = 'ptsmegamenu';
	
	public $name = 'base';
	
	public $group = 'others';

	public $id_shop = 0;

	public $fields_form = array();

	public $types = array();

	public $langID=1;

	public $token ;  
	/**
	 * abstract method to return html widget form
	 */
	public static function getWidgetInfo(){
		return array('key'=>'base','label'=>'Widget Base');
	}

	public static function renderButton(){
		return 'nono';
	}

	public function processAdminPost(){

		}

	public function processFontEndPost(){
	
	}

	public function beforeAdminProcess( $controller ){

	}

	public function beforeRender( $controller ){

	}

	public function renderAdminContent(){
		
	}
	/**
	 * abstract method to return html widget form
	 */
	public function renderForm( $args, $data ){
		return ;
	}

	/**
	 * abstract method to return widget data 
	 */
	public function renderContent( $args, $data ){
		return ;
	}

	/**
	 *
	 */
	public function renderWidgetContent( $atts = array(), $content='' ){

		$data = $this->renderContent( array(), $atts ); 
		$output = $this->renderWidgetInLayout(  $this->name, $data['data'] );
		return $output;
	}

	/**
	 *
	 */
	public function getLayout( $layout ){ 

		$config = $this->registry->get("config");
		$config_template = $config->get("theme_default_directory");

		if (file_exists(DIR_TEMPLATE . $config_template . '/template/extension/module/widgets/'.$layout.'.tpl')) {
			$template = DIR_TEMPLATE. $config_template . '/template/extension/module/widgets/'.$layout.'.tpl';
		} else {
			$template = DIR_TEMPLATE.'default/template/extension/module/widgets/'.$layout.'.tpl';
		}
		return $template;
	}

	/**
	 *
	 */
	public function renderWidgetInLayout( $layout , $data ){  
	 	$file = $this->getLayout( $layout );
	 	if( is_file($file) ) {
	 		$data['widget_heading'] = "";
	 	 	if( isset($data['widget_title_'.$this->config->get('config_language_id')]) && $data['show_title'] ){
	 	 		$data['widget_heading'] = $data['widget_title_'.$this->config->get('config_language_id')];
	 	 	}	
	 	 	$data['heading_title'] =  $data['widget_heading'];
	    	extract( $data );  
	    	ob_start();
	  		require( $file );
	  		$output = ob_get_contents();
	  		ob_end_clean( );
 		
  			return $output;
  		}
    }


	/**
	 * Get translation for a given module text
	 *
	 * Note: $specific parameter is mandatory for library files.
	 * Otherwise, translation key will not match for Module library
	 * when module is loaded with eval() Module::getModulesOnDisk()
	 *
	 * @param string $string String to translate
	 * @param boolean|string $specific filename to use in translation key
	 * @return string Translation
	 */
	public function l($string, $specific = false)
	{
		return $this->language->get( $string );
	}

	/**
     * Asign value for each input of Data form
     */
    public function getConfigFieldsValues( $data=null ) {      
 
 
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
 

        $fields_values = array();
        $obj = isset($data['params'])?$data['params']:array();

    
        foreach(  $this->fields_form as $k=> $f ){ 
            foreach( $f['form']['input']  as $j=> $input ){
        
               	if( isset($input['lang']) ) {
                    foreach ( $languages as $lang ){ 
                    	$lang['id_lang']= $lang['language_id'];
                        $fields_values[$input['name'].'_'.$lang['id_lang']] = isset($obj[$input['name']."_".$lang['id_lang']]) ? $obj[$input['name']."_".$lang['id_lang']] : $input['default'];
                    }
                }else {
      
	                if( isset($obj[trim($input['name'])]) ){
	                    $value = $obj[trim($input['name'])];  
	          			
	                    if( $input['name'] == 'image' &&  $value  ){ 
	                        $thumb = __PS_BASE_URI__.'modules/'.$this->name.'/img/'. $value;   
	                        $this->fields_form[$k]['form']['input'][$j]['thumb'] =  $thumb; 
	                    }
	          			$fields_values[$input['name']] = $value;	
	                }else{
 
 	                    $v = Tools::getValue( $input['name'] );
	                    $fields_values[$input['name']] =$v?$v:$input['default'];
 	 
	                } 
	            }    
            }   
        }
 
        if( isset($data['id_widget']) ){
        	$fields_values['id_widget'] =  $data['id_widget'];
        }
        return $fields_values;
    }

    public function getFormHelper(){

    	// echo $this->token;die;

    	$default_lang = (int)$this->config->get('config_language_id');
    	// $action = AdminController::$currentIndex.'&configure='.$this->modName.'&save'.$this->modName.'&token='.Tools::getAdminTokenLite('AdminModules').'&widgets=1&rand='.rand().'&wtype='.Tools::getValue('wtype');
          
        $styles = $this->detectSfxClasses( $this->config->get('theme_default_directory') );      
    
    	$this->fields_form[0]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Info.'),
	                'id'	=> 'widgetinfo'
	            ),
	            'input' => array(
	                
 					 array(
	                    'type' => 'hidden',
	                    'label' => $this->l('Widget Key'),
	                    'name' => 'wkey',
	                    'default'=> $this->request->post['wkey'],
	                    'desc' 	=> $this->l( 'Using for show in Listing Widget Management' )
 
	                ),
 					  array(
	                    'type' => 'hidden',
	                    'label' => $this->l('Widget Type'),
	                    'name' => 'wtype',
	                    'default'=> $this->name,
	                    'desc' 	=> $this->l( 'Using for show in Listing Widget Management' )
 
	                ),
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Widget Name'),
	                    'name' => 'widget_name',
	                    'default'=> '',
	                    'desc' 	=> $this->l( 'Using for show in Listing Widget Management' )
 
	                ),
 
	                array(
	                    'type' => 'switch',
						'label' => $this->l('Display Title'),
						'desc' => $this->l('Show the title on the widget block'),
						'name' => 'show_title',
						'default'=>1,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						),
	                ),
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Widget Title'),
	                    'name' => 'widget_title',
	                    'default'=> '',
	                    'lang'	=> true,
	                    'desc' 	=> $this->l( 'This tile will be showed as header of widget block. Empty to disable' )
 
	                ),
	             
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Addition Class'),
	                    'name' => 'addition_cls',
	                    'default'=> '',
	                    'desc' 	=> $this->l( 'This class is used to make owner style for the widget.' )
 
	                ),
	                

	            ),
	      		 'submit' => array(
	                'title' => $this->l('Save'),
	                'class' => 'button'
           		 )
	        );
			if( $styles['widget'] ){
				$this->fields_form[0]['form']['input'][]  = array(
		                    'type' 	  => 'select',
		                    'label'   => $this->l( 'Widget Box Style' ),
		                    'name' 	  => 'stylecls',
		                    'options' => array(  'query' => $styles['widget'] ,
		                    'id' 	  => 'class',
		                    'name' 	  => 'name' ),
		                    'default' => "",
		                    'desc'    => $this->l( 'These classes are automatic loaded in file pagebuider.css in module or actived theme' )
		        ); 
			}
			//d( $styles );
	    	$helper = new HelperForm( $this->registry );
	        $helper->module = $this;
	        $helper->name_controller = $this->modName;
	        $helper->identifier = $this->modName;
	        $helper->token = $this->token;

	        /* 
	        foreach (Language::getLanguages(false) as $lang)
	            $helper->languages[] = array(
	                'id_lang' => $lang['id_lang'],
	                'iso_code' => $lang['iso_code'],
	                'name' => $lang['name'],
	                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
	            );

	 		* /	

	        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->modName.'&widgets=1&rand='.rand().'&wtype='.Tools::getValue('wtype');
	        $helper->default_form_language = $default_lang;
	        $helper->allow_employee_form_lang = $default_lang;
	        $helper->toolbar_scroll = true;
	        $helper->title = $this->modName;
	        $helper->submit_action = 'save'.$this->modName;
	        
	        $liveeditorURL = AdminController::$currentIndex.'&configure='.$this->modName.'&edit=1&token='.Tools::getAdminTokenLite('AdminModules'); 

	       * / 	
	        $helper->toolbar_btn =  array(
	            /*'save' =>
	            array(
	                'desc' => $this->l('Save'),
	                'href' => $action,
	            ),* /
	             'back' =>
	            array(
	                'desc' => $this->l('Back'),
	                'href' => AdminController::$currentIndex.'&configure='.$this->modName.'&save'.$this->modName.'&token='.Tools::getAdminTokenLite('AdminModules').'&widgets=1&rand='.rand(),
	            ),
	             
	        );
	        */ 
	        return $helper;
   		}

   		public function getValueByLang( $setting, $key ){
			return isset($setting[$key."_".$this->config->get('config_language_id')])?$setting[$key."_".$this->config->get('config_language_id')]:0; 
		}

		public function parseWidgetsData( $data ){
			return array( 'params' => $data ); 
		}


		/**
		 *
		 */
		public  function detectSfxClasses( $template ){

			$pagestyle =  DIR_CATALOG.'view/theme/default/stylesheet/stylesheet.css';
			$tcss =  DIR_CATALOG.'view/theme/'.$template.'/stylesheet/stylesheet.css';

			$captions  = array( 'col' => array() , 'row' => array(), 'widget' => array() );
		 
		 
			 
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

	}
?>