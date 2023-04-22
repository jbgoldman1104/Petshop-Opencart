<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ControllerExtensionModulePavbloglatest 
 */
class ControllerExtensionModulePavbloglatest extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->response->redirect($this->url->link('extension/module/pavblog/frontmodules', 'mod=pavbloglatest&token=' . $this->session->data['token'], 'SSL'));	
		
	}
	
}
?>
