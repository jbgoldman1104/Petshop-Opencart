<?php
class ControllerExtensionModulePavblogcategory extends Controller {

	private $mdata = array();

	public function index($setting) {

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
		
		
		if (file_exists('catalog/view/theme/' . $config_theme . '/stylesheet/pavblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $config_theme . '/stylesheet/pavblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavblog.css');
		}
		
		$this->document->addScript('catalog/view/javascript/jquery/pavblog_script.js');	
		$default = array(
			'latest' => 1,
			'limit' => 9
		);

		$category_id = 0;

		if($this->request->get['route'] == 'pavblog/category' && isset($this->request->get['id'])) {
			$category_id = $this->request->get['id'];
		}

		$typeTree = isset($setting['type'])?$setting['type']:'default';

		if($typeTree == "vertical") {
			$template = "/pavblogcategory/vertical";
			$tree = $this->model_pavblog_category->getTreeVertical(null, $category_id);
		} elseif($typeTree == "accordion") {
			$template = "/pavblogcategory/accordion";
			$tree = $this->model_pavblog_category->getTreeAccordion(null, $category_id);
		} else {
			$template = "/pavblogcategory";
			$tree = $this->model_pavblog_category->getTree(null, $category_id);
		}
		
		$this->mdata['tree'] = $tree;
		
		return $this->load->view("extension/module/".$template, $this->mdata);
	}
	
}
?>