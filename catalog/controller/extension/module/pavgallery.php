<?php  
class ControllerExtensionModulePavgallery extends Controller {
	private $data = array();

	public function index($setting) {
		static $module = 0;

		$this->load->model('tool/image');
	
		$this->language->load('extension/module/pavgallery');

		if (file_exists('catalog/view/theme/' . $this->config->get('theme_default_directory') . '/stylesheet/pavgallery.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('theme_default_directory') . '/stylesheet/pavgallery.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavgallery.css');
		}
		
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
	
		$this->data['heading_title'] = $setting['name'];
		
		$this->data['prefix'] = $setting['prefix_class'];
		
		$this->data['banners'] = array();
		
			if (isset($setting['banner_id'])) {
				$this->load->model('design/banner');
				$results = $this->model_design_banner->getBanner($setting['banner_id']);
				
				foreach ($results as $result) {
					if (file_exists(DIR_IMAGE . $result['image'])) {
						$t = array(
							'title' => $result['title'],
							'link'  => $result['link'],
							
							'thumb' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
						);
						
						if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
							$t['image'] = $this->config->get('config_ssl') . 'image/' .  $result['image'];
						} else {
							$t['image'] =  $this->config->get('config_url') . 'image/' .  $result['image'];
						}	
						
						$this->data['banners'][] = $t;
					}
				}
			}

		$this->data['module'] = $module++;
						
		
		return $this->load->view('extension/module/pavgallery', $this->data);
		
	}
}
?>