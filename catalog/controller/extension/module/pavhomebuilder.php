<?php
 /**
  * Homepagebuilder module creates structure layout with rows and columns which standard bootstrap 3
  * and show modules inside each column in very flexiabel way without coding.
  * 
  * @version    $Id$
  * @package    Opencart 2
  * @author     PavoThemes Team <pavothemes@gmail.com>
  * @copyright  Copyright (C) 2014 pavothemes.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @addition   this license does not allow theme provider using in theirs themes to sell on marketplaces.
  * @website  http://www.pavothemes.com
  * @support  http://www.pavothemes.com/support/forum.html
  */
require_once(DIR_SYSTEM . 'pavothemes/widgets_loader.php');
class ControllerExtensionModulepavhomebuilder extends Controller {

	private $mdata = array();

	private $url = '';

	private $widgets = array(); 

	/**
	 * index action 
	 */
	public function index( $setting ) { 
		$this->load->model('tool/image');
		$this->load->model('design/banner');
		$this->load->model('extension/module');
		$this->load->model('extension/pavwidget');

	 

		if( isset($this->request->get['home_id']) ){
			$mod = $this->model_extension_module->getModule( $this->request->get['home_id'] );
			if( isset($mod['layout']) ){
				$setting = $mod;
			}
		}	

		$d = array("banner_layout" => 1, "prefix" => '', 'module_id'=>0);
		$setting = array_merge($d, $setting);

		if( $setting['module_id'] ){
			$this->widgets = $this->model_extension_pavwidget->getWidgetsByModuleId( $setting['module_id'] );  
		}
	

		$this->mdata['objimg'] = $this->model_tool_image;
		$layouts = ( trim($setting['layout']) );
		$this->mdata['layouts'] = $layouts;

		$tpl = 'pavhomebuilder.tpl';

		if( isset($setting['template']) ){
			$tpl = 'pavhomebuilder/'.$setting['template'].'.tpl'; 
		}	
		if (file_exists('catalog/view/theme/' . $this->config->get('theme_default_directory') . '/stylesheet/homebuilder.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_default_directory') . '/stylesheet/homebuilder.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/homebuilder.css');
		}
		$this->url = $this->config->get('config_secure') ? $this->config->get('config_ssl') : $this->config->get('config_url');

		$layout = json_decode( $layouts );



        $layouts = $this->buildLayoutData( $layout,  1 );

		 // echo '<pre>'.print_r( $layouts ,1 );die; 

		$this->mdata['layouts'] = $layouts;
		$this->mdata['url'] =  $this->config->get('config_secure') ? $this->config->get('config_ssl') : $this->config->get('config_url');
		
 		$this->mdata['class'] = isset($setting['class'])?$setting['class']:'';
 		$this->mdata['heading'] = isset($setting['heading'])?$setting['heading']:'';

		return $this->load->view('extension/module/'.$tpl, $this->mdata);
	}
	
	protected function buildStyles( $element ){
		$styles = array();
		if( isset($element->padding) && $element->padding ){
			$styles[]= 'padding:'.$element->padding;
		}
		if( isset($element->margin) && $element->margin ){
			$styles[]= 'margin:'.$element->margin;
		}

		if( isset($element->bgcolor) && $element->bgcolor ){
			$styles[] = 'background-color:#'.$element->bgcolor;
		}
		if( isset($element->bgimage) && $element->bgimage ){
			$styles[] = 'background-image:url(\''.$this->url .'image/'.$element->bgimage.'\')';
			if( isset($element->iposition) && $element->iposition ){
				$styles[] ='background-position:'.$element->iposition;
			}
			if( isset($element->iattachment) && $element->iattachment ){
				$styles[] = 'background-attachment'.$element->iattachment;
			}
		}
		if( !empty($styles) ){
			$element->attrs = $element->attrs . ' style="'.implode(";", $styles).'"';
		}

		return $element; 
	}

	/**
	 * looping render layout structures and module content inside cols and rows.
	 *
	 * @return Array $layout
	 */
    public function buildLayoutData( $rows , $rl=1  ){ 
        $layout = array();
    	
    	$this->templatepath = DIR_TEMPLATE . 'default/template/extension/module/pavbuilder/';

        foreach( $rows as $rkey =>  $row ){
            $row->level=$rl;

            $row = $this->mergeRowData( $row );
 
            foreach( $row->cols as $ckey => $col ){
             	$col = $this->mergeColData( $col );
                foreach( $col->widgets as  $wkey => $w ){
                   if( isset($w->module) ){
	               		if( isset($w->type) && $w->type != "module" && isset($this->widgets[$w->module]) && $this->widgets[$w->module]['setting'] ){
	               			$object = "PtsWidget".ucfirst( $w->type );
	               			$object = new $object( $this->registry );
	               			$w->content = $object->renderWidgetContent( @unserialize( base64_decode( $this->widgets[$w->module]['setting'] ) ) );	
	               		}else {
	               			$w->content = $this->renderModule( array('code'=>$w->module) );	
	               		}
                   }
                }
                if( isset($col->rows) ){
                    $col->rows = $this->buildLayoutData( $col->rows, $rl+1 );     
                }
                $row->cols[$ckey] = $col;
            }
   
            $layout[$rkey] = $row;
        }

        return $layout;
    }

    /**
	 * direct rendering content of module by code
	 * 
	 * @return HTML Stream
	 */
	protected function renderModule( $module  ){
		$part = explode('.', $module['code']);
			
		if (isset($part[0]) && $this->config->get($part[0] . '_status')) {
			return $this->load->controller('extension/module/' . $part[0]);
		}
		
		if (isset($part[1])) {
			$setting_info = $this->model_extension_module->getModule($part[1]);
			if ($setting_info && $setting_info['status']) {
				return $this->load->controller('extension/module/' . $part[0], $setting_info);
			}
		}
		return ;
	}

	/**
	 * make attributes information for column
	 *
	 * @param Array $col
	 * @return Array $col
	 */
	protected function mergeColData( $col ){
		$col->attrs = '';
        $col = $this->buildStyles( $col );
        if( isset($col->sfxcls) && $col->sfxcls ){
			$col->sfxcls = trim( $col->sfxcls );
		}else {
			$col->sfxcls = '';
		}
        return $col;
	}

	/**
	 * make attributes information for rows such as background,padding, margin
	 * 
	 * @param Array $row
	 * @return Array $row
	 */
	public function mergeRowData( $row ){
		$row->attrs = '';
		$styles = array();
		$row = $this->buildStyles( $row );  

		if( isset($row->sfxcls) && $row->sfxcls ){
			$row->sfxcls =  trim( $row->sfxcls );
		}else {
			$row->sfxcls = '';
		}

		return $row;
	}
}
?>