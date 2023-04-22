<?php
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2012 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/


class ControllerExtensionModulePavblog extends Controller {

	protected function index($setting) {

		// pavo 2.2 fix
		$config_theme = $this->config->get('theme_default_directory');
		$this->mdata['objlang']   = $this->language;
		$this->mdata['ourl']      = $this->url;
		$this->mdata['themename'] = $config_theme;
		// pavo 2.2 fix

		static $module = 0;
		$this->load->model('pavblog/category');
		$this->load->model('tool/image');
		$this->load->language('extension/module/pavblog');
		$this->mdata['heading_title'] = $this->language->get('blog_category_heading_title');

		if (file_exists('catalog/view/theme/' . $config_theme . '/stylesheet/pavmegamenu.css')) {
			$this->document->addStyle('catalog/view/theme/' . $config_theme . '/stylesheet/pavmegamenu.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavmegamenu.css');
		}
		
		$this->data['module'] = $module++;
		return $this->load->view("extension/module/pavblog", $this->mdata);
	}
}
?>