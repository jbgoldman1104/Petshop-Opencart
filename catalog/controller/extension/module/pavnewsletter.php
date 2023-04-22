<?php
class ControllerExtensionModulePavnewsletter extends Controller {

	private $mdata = array();

	public function index($setting) {

		// pavo 2.2 fix
		$this->load->language('extension/module/themecontrol');

		$config_theme = $this->config->get('theme_default_directory');
		
		$this->mdata['objlang']   = $this->language;
		$this->mdata['ourl']      = $this->url;
		$this->mdata['sconfig']   = $this->config;
		$this->mdata['themename'] = $config_theme;
		// pavo 2.2 fix

		static $module = 0;
		$this->load->language('extension/module/pavnewsletter');
		$this->load->model('account/customer');
		$this->load->model('pavnewsletter/subscribe');

		$this->mdata['objlang'] = $this->language;

		$general_setting = $this->config->get("pavnewsletter_config");
		$language_id     = $this->config->get("config_language_id");

		$show_box = true;
		if ($this->customer->isLogged()) {
			$customer_email = $this->customer->getEmail();
			if ($this->model_pavnewsletter_subscribe->checkExists($customer_email)) {
				$show_box = false;
			}
			$this->mdata['customer_email'] = $customer_email;
		}
		//if(!$show_box)
		//	return;
		if (file_exists(DIR_TEMPLATE . $config_theme  . '/stylesheet/pavnewsletter.css')) {
			$this->document->addStyle('catalog/view/theme/' . $config_theme . '/stylesheet/pavnewsletter.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavnewsletter.css');
		}

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->mdata['base'] = $this->config->get('config_ssl');
		} else {
			$this->mdata['base'] = $this->config->get('config_url');
		}
		$this->mdata['action']   = $this->url->link('extension/module/pavnewsletter/subscribe', '', 'SSL');
		$this->mdata['prefix']   = isset($setting['prefix']) ? $setting['prefix'] : '';
		$this->mdata['position'] = isset($setting['position']) ? $setting['position'] : '';

		$this->mdata['description'] = isset($setting['description'][$language_id]) ? $setting['description'][$language_id] : $this->language->get('description');
		$this->mdata['social']      = isset($setting['social'][$language_id]) ? $setting['social'][$language_id] : '';
		$this->mdata['mode']        = isset($setting['displaymode']) ? $setting['displaymode'] : "";
		$this->mdata['module']      = rand();

	
		$template = 'extension/module/pavnewsletter';
		

		return $this->load->view($template, $this->mdata);
	}

	public function subscribe() {
		$this->language->load('extension/module/pavnewsletter');
		$this->load->model('account/customer');
		$this->load->model('pavnewsletter/subscribe');

		$json = array();

		$data                = array();
		$data['store_id']    = $this->config->get('config_store_id');
		$data['customer_id'] = 0;
		$data['email']       = $this->request->post['email'];
		$data['store_id']    = 0;
		if (!$this->model_pavnewsletter_subscribe->checkExists($this->request->post['email'])) {
			if ($customer = $this->model_account_customer->getCustomerByEmail($this->request->post['email'])) {
				$data['customer_id'] = $customer['customer_id'];
			}
			$this->model_pavnewsletter_subscribe->storeSubscribe($data);

			$json['success'] = $this->language->get('success_post');

			$json['redirect'] = $this->url->link('common/home', '', 'SSL');
		} else {
			$json['error'] = $this->language->get('error_post');
		}
		$this->response->setOutput(json_encode($json));
	}

	public function subs() {
		$this->language->load('extension/module/pavnewsletter');
		$this->load->model('account/customer');
		$this->load->model('pavnewsletter/subscribe');

		$json = array();

		$data                = array();
		$data['store_id']    = $this->config->get('config_store_id');
		$data['customer_id'] = 0;
		$data['email']       = $this->request->post['email'];
		$data['store_id']    = 0;
		if (!$this->model_pavnewsletter_subscribe->checkExists($this->request->post['email'])) {

			if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL) === false) {
				if ($customer = $this->model_account_customer->getCustomerByEmail($this->request->post['email'])) {
					$data['customer_id'] = $customer['customer_id'];
				}
				$this->model_pavnewsletter_subscribe->storeSubscribe($data);

				$json['success'] = $this->language->get('success_post');

				$json['redirect'] = $this->url->link('common/home', '', 'SSL');

			} else {
				$json['error'] = $this->language->get('valid_email');
			}

		} else {
			$json['error'] = $this->language->get('error_post');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	protected function validate($data = array()) {
		if (!empty($data)) {
			if (isset($data['email']) && !empty($data['email']) && isset($data['action'])) {
				return true;
			}

		}
		return false;
	}
}
