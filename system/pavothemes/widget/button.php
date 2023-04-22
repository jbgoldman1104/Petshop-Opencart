<?php 

class PtsWidgetButton extends PtsWidgetPageBuilder {

	public $name = 'button';

	public  static function getWidgetInfo(){
		return array( 'label' => 'Button', 'explain' => 'Edit Button', 'group' => 'typo' );
	}

	public function renderForm( $args, $data ){
			
		$helper = $this->getFormHelper();

		$type_button = array(
			array('id' => 'btn-default', 'name' => $this->l('Default')),
			array('id' => 'btn-primary', 'name' => $this->l('Primary')),
			array('id' => 'btn-success', 'name' => $this->l('Success')),
			array('id' => 'btn-info', 'name' => $this->l('Info')),
			array('id' => 'btn-warning', 'name' => $this->l('Warning')),
			array('id' => 'btn-danger', 'name' => $this->l('Danger')),
			array('id' => 'btn-link', 'name' => $this->l('Link')),
		);
		$size = array(
			array('id' => '', 'name' => $this->l('Default')),
			array('id' => 'btn-lg', 'name' => $this->l('Large')),
			array('id' => 'btn-sm', 'name' => $this->l('Small')),
			array('id' => 'btn-xs', 'name' => $this->l('Extra small')),
		);

		$this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Widget Button Form.'),
            ),

            'input' => array(
                array(
					'type' => 'text',
					'label' => $this->l('Text on the button'),
					'name' => 'button_title',
					//'lang' => true,
					'desc' => $this->l('will be showed on button.'),
					'default' => 'Save',
				),
				array(
					'type' => 'text',
					'label' => $this->l('URL (link)'),
					'name' => 'href',
					'desc' => $this->l('Button link.'),
					'default' => 'http://www.leotheme.com',
				),
				array(
                    'type' => 'select',
                    'label' => $this->l('Type button'),
                    'desc' => $this->l('Select types suitable for your button'),
                    'name' => 'color_button',
                    'options' => array(
                        'query' => $type_button,
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'default' => 'btn-default',
                ),
                array(
					'type' => 'text',
					'label' => $this->l('Icon'),
					'name' => 'icon',
					'desc' => $this->l('Button icon.'),
					'default' => '',
				),
                array(
                    'type' => 'select',
                    'label' => $this->l('Size button'),
                    'desc' => $this->l('Select size suitable for your button'),
                    'name' => 'size',
                    'options' => array(
                        'query' => $size,
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'default' => 'btn-sm',
                ),
                array(
					'type' => 'text',
					'label' => $this->l('Extra class name'),
					'name' => 'el_class',
					'desc' => $this->l('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.'),
					'default' => '',
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
			'button_title' => 'Save',
			'href'         => '',
			'color_button' => '',
			'icon'         => '',
			'size'         => '',
			'el_class'     => '',
		);
		$setting = array_merge( $t, $setting );

		$languageID = $this->config->get('config_language_id');
		$setting['heading_title'] = isset($setting['widget_title_'.$languageID])?$setting['widget_title_'.$languageID]:'';

		$output = array('type'=>'button','data' => $setting );
		return $output;
	}
}