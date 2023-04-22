<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) September 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class ModelMenuWidget extends Model {		

	private $widgets = array();

	private $engines = array();
	/**
	 * get list of supported widget types.
	 */
	public function getTypes(){

		$this->language->load('extension/module/pavmegamenu');
		return array(
			'html' 				=> $this->language->get( 'text_widget_html' ),
			'product_category'  => $this->language->get( 'text_widget_product_category' ),
			'product_list'	    => $this->language->get( 'text_widget_product_list' ),
			'product'			=> $this->language->get( 'text_widget_product' ),
			'banner'			=> $this->language->get( 'text_widget_banner' ),
			'image'				=> $this->language->get( 'text_widget_image' ),
			'video_code'		=> $this->language->get( 'text_widget_video_code' ),
			'feed'				=> $this->language->get( 'text_widget_feed' ),
			'pavo_blogs'		=> $this->language->get( 'text_pavo_blogs' )
		);
	}


	/**
	 * get list of widget rows. 
	 */
	public function getWidgets(){
		$sql = ' SELECT * FROM '.DB_PREFIX.'megamenu_widgets ';
		$query = $this->db->query( $sql );
		$a = $query->rows;
		return $a;
	}

	public function delete( $id ){
		$sql = ' DELETE FROM '.DB_PREFIX.'megamenu_widgets WHERE id='.(int)$id;
		return $this->db->query( $sql ); 
	}

	/**
	 * get widget data row by id
	 */
	public function getWidetById( $id ){

		$sql = ' SELECT * FROM '.DB_PREFIX.'megamenu_widgets WHERE id='.(int)$id;
		$query = $this->db->query( $sql );
		$row =  $query->row;

		$output = array(
			'id' => '',
			'name' => '',
			'params' => '',
		);
		if( $row ){
		 	$output = array_merge( $output, $row );
		 	$output['params'] = unserialize( $output['params'] );	

		}
		return $output;
	}

	/**
	 * Save Data Post in database
	 */
	public function saveData( $post ){
		$data = array(
			'id'	 => '',
			'params' => '',
			'type'	 => ''
		);
		
		$data = array_merge( $data, $post ); 

		if( $data['params'] ){
			$data['params'] = serialize( $data['params'] );
		}
		$id = $data['id'];

		unset( $data['id'] );
		
 
		if( $id ){ 
			$sql = ' UPDATE  '.DB_PREFIX.'megamenu_widgets SET ';
			foreach( $data as $key => $value ){
				$tmp[] = "`".$key."`='".$this->db->escape( $value )."'";
			}
			$sql .= implode( ',',$tmp ) . ' WHERE id='.(int)$id;

			$this->db->query( $sql );

		}else {
			$sql = ' INSERT INTO '.DB_PREFIX.'megamenu_widgets('.implode(',', array_flip($data) ).')';
			$tmp = array();
			foreach( $data as $value ){
				$tmp[] = "'".$this->db->escape( $value )."'";
			}
			$sql .= " VALUES(".implode(',',$tmp).") ";

			$this->db->query( $sql );
			$id = $this->db->getLastId();
			
		}

	 	$data['id'] = $id;

		return $data;
	}

	/**
	 * general function to render FORM 
	 *
	 * @param String $type is form type.
	 * @param Array default data values for inputs.
	 *
	 * @return Text.
	 */
	public function getForm( $type, $data=array() ){

		$method = "getWidget".ucfirst($type).'Form';
		$args = array();
		if( method_exists( $this, $method ) ){
			return $this->{$method}( $args, $data ); 
		}
		return $this->language->get( 'message_error_no_form_widget' );
	}

	/**
	 * render widget HTML Form.
	 */
	public function getWidgetHtmlForm( $args, $data ){
	 		
	 	$fields  = array(
	 		'html' => array( 'type' => 'textarea', 'value' => '','lang'=>1, 'values'=>array(),  'attrs' => 'cols="40" rows="6"'  )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
		 
	}

	/**
	 * render widget HTML Form.
	 */
	public function getWidgetProduct_categoryForm( $args, $data ){
	 		
	 	$fields  = array(
	 		'category_id' => array( 'type' => 'text', 'value' => '' ),
	 		'limit' 	 => array( 'type' => 'text', 'value' => ''  ),
	 		'image_width' => array( 'type' => 'text', 'value' => '' ),
	 		'image_height' => array( 'type' => 'text', 'value' => '' )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
		 
	}

	/**
	 * render widget HTML Form.
	 */
	public function getWidgetBannerForm( $args, $data ){
	 	
	 	$this->load->model('design/banner');
		$banners = $this->model_design_banner->getBanners();
 		
 		$values = array();

 		foreach( $banners as $banner ){
 			$values[] = array(
 				'value' => $banner['banner_id'],
 				'text'  => $banner['name']
 			);
 		}

	 	$fields  = array(	
	 		'group_id' => array( 'type' => 'select', 'value' => '', 'values'=>$values ),
	 		'image_width' => array( 'type' => 'text', 'value' => '' ),
	 		'image_height' => array( 'type' => 'text', 'value' => '' ),
	 		'limit' 	 => array( 'type' => 'text', 'value' => ''  )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
		 
	}

	public function getWidgetImageForm( $args, $data  ){

		$fields  = array(	
	 	 	'image_path' => array( 'type' => 'file', 'value' => '' ),
	 		'image_width' => array( 'type' => 'text', 'value' => '' ),
	 		'image_height' => array( 'type' => 'text', 'value' => '' )
	 	);


		return $this->_renderFormByFields( $fields, $data );
	}
	/**
	 * render widget HTML Form.
	 */
	public function getWidgetProduct_listForm( $args, $data ){
	 	$types = array();	
	 	$types[] = array(
	 		'value' => 'newest',
	 		'text'  => $this->language->get('text_products_newest')
	 	);
	 	$types[] = array(
	 		'value' => 'bestseller',
	 		'text'  => $this->language->get('text_products_bestseller')
	 	);

	 	$types[] = array(
	 		'value' => 'special',
	 		'text'  => $this->language->get('text_products_special')
	 	);


	 	$fields  = array(
	 		'list_type' => array( 'type' => 'select', 'value' => '', 'values'=>$types ),
	 		'limit' 	 => array( 'type' => 'text', 'value' => ''  ),
	 		'image_width' => array( 'type' => 'text', 'value' => '' ),
	 		'image_height' => array( 'type' => 'text', 'value' => '' )
	 	);
	 	return $this->_renderFormByFields( $fields, $data );
		 
	}

	/**
	 *
	 */
	public function getWidgetProductForm( $args, $data ){
		$fields  = array(
	 		'product_id' => array( 'type' => 'text', 'value' => '' ),
	 		'image_width' => array( 'type' => 'text', 'value' => '' ),
	 		'image_height' => array( 'type' => 'text', 'value' => '' )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
	}	

	public function getWidgetVideo_codeForm( $args, $data  ){  
		$fields  = array(
	 		'video_code' => array( 'type' => 'textarea', 'value' => '', 'attrs' => 'cols="40" rows="6"'  )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
	}

	public function getWidgetFeedForm( $args, $data  ){  
		$fields  = array(
	 		'feed_url' => array( 'type' => 'text', 'value' => ''  )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
	}

	public function getWidgetPavo_blogsForm( $args, $data  ){  
		$fields  = array(
	 		'limit' => array( 'type' => 'text', 'value' => ''  )
	 	);

	 	return $this->_renderFormByFields( $fields, $data );
	}

	/**
	 * render widget setting form with passed  fields. And auto fill data values in inputs.
	 */
	protected function _renderFormByFields( $fields, $data ){
		$this->language->load('extension/module/pavmegamenu');
		$output = '<table class="form">';


		foreach( $fields as $widget => $field ){
 			$output .= '<tr>';
 			$output .=  '<td>'.$this->language->get('text_widget_'.$widget).'</td>';
 			$input = '';
 			$val = isset($data[$widget])?$data[$widget]:"";
 			
			$attrs = isset($fields[$widget]['attrs'])?$fields[$widget]['attrs']:""; 

 			switch( $field['type']  ){
 				case 'text':  
 					if( isset($field['lang']) ){
 						$this->load->model('localisation/language');
						 $languages = $this->model_localisation_language->getLanguages();
						 
						 foreach( $languages as $language ){
						 	$input .= '<div class="input-language clearfix">';
						 	$input .= '<p><label>'.$language['name'].' : </label></p>';
						 	if( is_array($data) && isset($data[$widget][$language['language_id']]) ){
						 		$val = $data[$widget][$language['language_id']];
						 	}else {
						 		$val = '';
						 	}
						 	$input .= '<input '.$attrs.' type="text" value="'.$val.'" name="params['.$widget.']['.$language['language_id'].']">';
						 	$input .= '</div>';
						 }

 					}else {

 					
 						$input .= '<input '.$attrs.' type="text" name="params['.$widget.']" value="'.$val.'">';
 					}	
 					break;
 				case 'file':
 						$this->load->model('tool/image');
 						if ($val && file_exists(DIR_IMAGE . $val)) {
							$image = $val;
						} else {
							$image = 'no_image.jpg';
						}
 						$thumb = $this->model_tool_image->resize($image, 100, 100);
 						$no_image = $this->model_tool_image->resize('no_image.jpg', 100, 100);
 						$token = $this->session->data['token'];
 						$input .= '<div class="image"><img src="'.$thumb.'" alt="" id="thumb'.$widget.'" />
                          <input type="hidden" name="params['.$widget.']" value="'.$val.'" id="image'.$widget.'"  />
                          <br />
                          <a onclick="image_upload(\'image'.$widget.'\', \'thumb'.$widget.'\');">'.$this->language->get("text_browse").'</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb'.$widget.'\').attr(\'src\', \''.$no_image.'\'); $(\'#image'.$no_image.'\').attr(\'value\', \'\');">'.$this->language->get("text_clear").'</a></div>';
                        $input .= '
                        <script type="text/javascript"><!--
						function image_upload(field, thumb) {
							$(\'#dialog\').remove();
							
							$(\'#content\').prepend(\'<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token='.$token.'&field=\' + encodeURIComponent(field) + \'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>\');
							
							$(\'#dialog\').dialog({
								title: \''.$this->language->get("text_image_manager").'\',
								close: function (event, ui) {
									if ($(\'#\' + field).attr(\'value\')) {
										$.ajax({
											url: \'index.php?route=common/filemanager/image&token='.$token.'&image=\' + encodeURIComponent($(\'#\' + field).attr(\'value\')),
											dataType: \'text\',
											success: function(data) {
												$(\'#\' + thumb).replaceWith(\'<img src="\' + data + \'" alt="" id="\' + thumb + \'" />\');
											}
										});
									}
								},	
								bgiframe: false,
								width: 700,
								height: 400,
								resizable: false,
								modal: false
							});
						};
						//--></script>
                        ';
 						//$input .= '<input '.$attrs.' type="text" name="params['.$widget.']" value="'.$val.'">';
 				break;
 				case 'select':
 					$input .= '<select '.$attrs.' name="params['.$widget.']">';
 					$default_value = (isset($data['group_id']) && !empty($data['group_id']))?$data['group_id']:'';
 					$default_value = (isset($data['list_type']) && !empty($data['list_type']))?$data['list_type']:$default_value;
 						foreach( $field['values'] as $val ){
 							if($default_value == $val['value']){
 								$input .= '<option value="'.$val['value'].'" selected="selected">'.$val['text'].'</option>';
 							}else{
 								$input .= '<option value="'.$val['value'].'">'.$val['text'].'</option>';
 							}
 							 
 						}
 					$input .= '</select>';
 					
 					break;
 				case 'textarea':
 					
 					if( isset($field['lang']) ){
					
						$this->load->model('localisation/language');
						 $languages = $this->model_localisation_language->getLanguages();
						 
						 foreach( $languages as $language ){
						 	$input .= '<div class="input-language clearfix">';
						 	$input .= '<p><label>'.$language['name'].' : </label></p>';
						 	if( is_array($data) && isset($data[$widget][$language['language_id']]) ){
						 		$val = $data[$widget][$language['language_id']];
						 	} 
						 	$input .= '<textarea '.$attrs.' type="text"  name="params['.$widget.']['.$language['language_id'].']">'.$val.'</textarea>';
						 	$input .= '</div>';
						 }

 					}else {
 					  
 						$input .= '<textarea '.$attrs.' name="params['.$widget.']">'.$val.'</textarea>';
 					}	
 					break;	
 			}
			$output .= '<td>'.$input.'</td>';
			$output .= '</tr>';
 		}	
 		
 		$output .= '</table>';

 		return $output;
	}
 	

	public function renderWidgetProductContent( $args, $data ){

		$output = '';
		
		if( $data ){
			
		}	

		return $output;
	}
	/**
	 *
	 */
	public function getWidgetContent( $type, $data){
		$method = "renderWidget".ucfirst($type).'Content';
	 	$args = array(); 


		if( method_exists( $this, $method ) ){	
			return $this->{$method}( $args, $data ); 
		}
		return ;
	}

	/**
	 *
	 */
	public function renderContent( $id ){
		$output = '';
		
		if( isset($this->widgets[$id]) ){
			$output .= $this->getWidgetContent( $this->widgets[$id]['type'], unserialize($this->widgets[$id]['params']) );
		}
		
		return $output;
	}

	/**
	 *
	 */	
	public function loadWidgets(){
		if( empty($this->widgets) ){
			$widgets = $this->getWidgets();
			foreach( $widgets as $widget ){
				$this->widgets[$widget['id']] =$widget;
			}
		}
	}


	/**
	 *
	 */	
	public function loadWidgetsEngines(){

		if( empty($this->engines) ){
			$engines = glob( PAV_FRAMEWORK_WIDGET_DIR.'*.php' );
			foreach( $engines as $w ){
				//require_once( $w );
				$t = str_replace( ".php", "", basename($w) );
				$this->engines[$t] = $t;
			}
		}
	}


	/**
	 * general function to render FORM 
	 *
	 * @param String $type is form type.
	 * @param Array default data values for inputs.
	 *
	 * @return Text.
	 */
	public function renderForm( $type, $args, $data=array() ){
		
		$class = "PtsWidget".ucfirst($type);
					

		if( class_exists($class) ){
			$widget = new $class( $this->registry );
			 	$widget->token = $this->token;
			return $widget->renderForm( $args, $data );
		}

		/*
		if( isset($this->engines[$type]) ){ 
			$args = array();
			$this->engines[$type]->types = $this->getTypes(); 

			return $this->engines[$type]->renderForm( $args, $data  );
		} */
		return $this->language->get( 'Sorry, Form Setting is not avairiable for this type' );
	}


	public function getButtons(){
			// pavo 2.2 edit
			if( empty($this->engines) ){
				$engines = glob( PAV_FRAMEWORK_WIDGET_DIR.'*.php' );
				foreach( $engines as $w ){
					//require_once( $w );
					$t = str_replace( ".php", "", basename($w) );
					$this->engines[$t] = $t;
				}
			}
			// pavo 2.2 end edit
			
			$output = array();
		 	
			foreach( $this->engines as $w ){

				$class = "PtsWidget".ucfirst($w);
				
				if( class_exists($class) ){
				 	$obj = new $class( $this->registry );
				 	if( isset($obj->usemeneu) ){
				 		continue;
				 	}
					$cb_args = array();
					$info = 	call_user_func_array(array( $class, 'getWidgetInfo'), $cb_args);
					$group = isset($info['group'])?$info['group'] :  ( 'others' ); 
					$button = '
						<div id="wpo_'.$w.'" data-widget="'.$w.'"  >
							<div class="wpo-wicon wpo-icon-'.$w.'"></div>
							<div class="widget-title"> '.$this->language->get( $info['label'] ).' </div>
							 <i class="widget-desc">'.$this->language->get( $info['explain'] ).'</i>
						</div>
					';

					$output['widgets'][$w] = array('type' => $w, 'button' =>  $button, 'group' => $group );
					$output['groups'][$group]['group'] = $this->language->get(ucfirst($group));
					$output['groups'][$group]['key'] = $group;
				} 
			}
	 
			return $output;
			
		}	

}
?>