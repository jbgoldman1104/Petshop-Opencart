<?php
class ControllerExtensionPaymentAmazonLoginPay extends Controller {

	private $error = array();

	public function index() {

		$this->load->language('extension/payment/amazon_login_pay');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('extension/payment/amazon_login_pay');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('amazon_login_pay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['language_reload'])) {
				$this->response->redirect($this->url->link('payment/amazon_login_pay', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_amazon_join'] = $this->language->get('text_amazon_join');
		$data['text_ready_status'] = $this->language->get('text_ready_status');
		$data['text_us'] = $this->language->get('text_us');
		$data['text_de'] = $this->language->get('text_de');
		$data['text_uk'] = $this->language->get('text_uk');
		$data['text_fr'] = $this->language->get('text_fr');
		$data['text_it'] = $this->language->get('text_it');
		$data['text_es'] = $this->language->get('text_es');
		$data['text_live'] = $this->language->get('text_live');
		$data['text_sandbox'] = $this->language->get('text_sandbox');
		$data['text_auth'] = $this->language->get('text_auth');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_guest'] = $this->language->get('text_guest');
		$data['text_no_capture'] = $this->language->get('text_no_capture');
		$data['text_sort_order'] = $this->language->get('text_sort_order');
		$data['text_minimum_total'] = $this->language->get('text_minimum_total');
		$data['text_all_geo_zones'] = $this->language->get('text_all_geo_zones');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_upload_success'] = $this->language->get('text_upload_success');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_geo_zone'] = $this->language->get('text_geo_zone');
		$data['text_status'] = $this->language->get('text_status');
		$data['text_declined_codes'] = $this->language->get('text_declined_codes');
		$data['text_amazon_signup'] = $this->language->get('text_amazon_signup');
		$data['text_credentials'] = $this->language->get('text_credentials');
		$data['text_validate_credentials'] = $this->language->get('text_validate_credentials');
		$data['text_amazon_no_declined'] = $this->language->get('text_amazon_no_declined');

		$data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$data['entry_access_key'] = $this->language->get('entry_access_key');
		$data['entry_access_secret'] = $this->language->get('entry_access_secret');
		$data['entry_client_id'] = $this->language->get('entry_client_id');
		$data['entry_client_secret'] = $this->language->get('entry_client_secret');
		$data['entry_login_pay_test'] = $this->language->get('entry_login_pay_test');
		$data['entry_login_pay_mode'] = $this->language->get('entry_login_pay_mode');
		$data['entry_checkout'] = $this->language->get('entry_checkout');
		$data['entry_capture_status'] = $this->language->get('entry_capture_status');
		$data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_payment_region'] = $this->language->get('entry_payment_region');
		$data['entry_ipn_token'] = $this->language->get('entry_ipn_token');
		$data['entry_ipn_url'] = $this->language->get('entry_ipn_url');
		$data['entry_debug'] = $this->language->get('entry_debug');

		$data['help_pay_mode'] = $this->language->get('help_pay_mode');
		$data['help_checkout'] = $this->language->get('help_checkout');
		$data['help_capture_status'] = $this->language->get('help_capture_status');
		$data['help_debug'] = $this->language->get('help_debug');
		$data['help_ipn_url'] = $this->language->get('help_ipn_url');
		$data['help_ipn_token'] = $this->language->get('help_ipn_token');
		$data['help_minimum_total'] = $this->language->get('help_minimum_total');
		$data['help_declined_codes'] = $this->language->get('help_declined_codes');

		$data['error_credentials'] = $this->language->get('error_credentials');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error_merchant_id'])) {
			$data['error_merchant_id'] = $this->error['error_merchant_id'];
		} else {
			$data['error_merchant_id'] = '';
		}

		if (isset($this->error['error_access_key'])) {
			$data['error_access_key'] = $this->error['error_access_key'];
		} else {
			$data['error_access_key'] = '';
		}

		if (isset($this->error['error_access_secret'])) {
			$data['error_access_secret'] = $this->error['error_access_secret'];
		} else {
			$data['error_access_secret'] = '';
		}

		if (isset($this->error['error_client_secret'])) {
			$data['error_client_secret'] = $this->error['error_client_secret'];
		} else {
			$data['error_client_secret'] = '';
		}

		if (isset($this->error['error_client_id'])) {
			$data['error_client_id'] = $this->error['error_client_id'];
		} else {
			$data['error_client_id'] = '';
		}

		if (isset($this->error['error_minimum_total'])) {
			$data['error_minimum_total'] = $this->error['error_minimum_total'];
		} else {
			$data['error_minimum_total'] = '';
		}

		if (isset($this->error['error_curreny'])) {
			$data['error_curreny'] = $this->error['error_curreny'];
		} else {
			$data['error_curreny'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/amazon_login_pay', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/amazon_login_pay', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['amazon_login_pay_merchant_id'])) {
			$data['amazon_login_pay_merchant_id'] = $this->request->post['amazon_login_pay_merchant_id'];
		} elseif ($this->config->get('amazon_login_pay_merchant_id')) {
			$data['amazon_login_pay_merchant_id'] = $this->config->get('amazon_login_pay_merchant_id');
		} else {
			$data['amazon_login_pay_merchant_id'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_access_key'])) {
			$data['amazon_login_pay_access_key'] = $this->request->post['amazon_login_pay_access_key'];
		} elseif ($this->config->get('amazon_login_pay_access_key')) {
			$data['amazon_login_pay_access_key'] = $this->config->get('amazon_login_pay_access_key');
		} else {
			$data['amazon_login_pay_access_key'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_access_secret'])) {
			$data['amazon_login_pay_access_secret'] = $this->request->post['amazon_login_pay_access_secret'];
		} elseif ($this->config->get('amazon_login_pay_access_secret')) {
			$data['amazon_login_pay_access_secret'] = $this->config->get('amazon_login_pay_access_secret');
		} else {
			$data['amazon_login_pay_access_secret'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_client_id'])) {
			$data['amazon_login_pay_client_id'] = $this->request->post['amazon_login_pay_client_id'];
		} elseif ($this->config->get('amazon_login_pay_client_id')) {
			$data['amazon_login_pay_client_id'] = $this->config->get('amazon_login_pay_client_id');
		} else {
			$data['amazon_login_pay_client_id'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_client_secret'])) {
			$data['amazon_login_pay_client_secret'] = $this->request->post['amazon_login_pay_client_secret'];
		} elseif ($this->config->get('amazon_login_pay_client_secret')) {
			$data['amazon_login_pay_client_secret'] = $this->config->get('amazon_login_pay_client_secret');
		} else {
			$data['amazon_login_pay_client_secret'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_test'])) {
			$data['amazon_login_pay_test'] = $this->request->post['amazon_login_pay_test'];
		} elseif ($this->config->get('amazon_login_pay_test')) {
			$data['amazon_login_pay_test'] = $this->config->get('amazon_login_pay_test');
		} else {
			$data['amazon_login_pay_test'] = 'sandbox';
		}

		if (isset($this->request->post['amazon_login_pay_mode'])) {
			$data['amazon_login_pay_mode'] = $this->request->post['amazon_login_pay_mode'];
		} elseif ($this->config->get('amazon_login_pay_mode')) {
			$data['amazon_login_pay_mode'] = $this->config->get('amazon_login_pay_mode');
		} else {
			$data['amazon_login_pay_mode'] = 'payment';
		}

		if (isset($this->request->post['amazon_login_pay_checkout'])) {
			$data['amazon_login_pay_checkout'] = $this->request->post['amazon_login_pay_checkout'];
		} elseif ($this->config->get('amazon_login_pay_checkout')) {
			$data['amazon_login_pay_checkout'] = $this->config->get('amazon_login_pay_checkout');
		} else {
			$data['amazon_login_pay_checkout'] = 'payment';
		}

		if (isset($this->request->post['amazon_login_pay_payment_region'])) {
			$data['amazon_login_pay_payment_region'] = $this->request->post['amazon_login_pay_payment_region'];
		} elseif ($this->config->get('amazon_login_pay_payment_region')) {
			$data['amazon_login_pay_payment_region'] = $this->config->get('amazon_login_pay_payment_region');
		} elseif (in_array($this->config->get('config_currency'), array('EUR', 'GBP', 'USD'))) {
			$data['amazon_login_pay_payment_region'] = $this->config->get('config_currency');
		} else {
			$data['amazon_login_pay_payment_region'] = 'USD';
		}

		if ($data['amazon_login_pay_payment_region'] == 'EUR') {
			$data['amazon_login_pay_language'] = 'de-DE';
			$data['sp_id'] = 'AGGDPRPDPL7SL';
			$data['locale'] = 'EUR';
			$ld = 'SPEXDEAPA-OpencartPL';
		} elseif ($data['amazon_login_pay_payment_region'] == 'GBP') {
			$data['amazon_login_pay_language'] = 'en-GB';
			$data['sp_id'] = 'A1P8WV11EWOP9H';
			$data['locale'] = 'GBP';
			$ld = 'SPEXUKAPA-OpencartPL';
		} else {
			$data['amazon_login_pay_language'] = 'en-US';
			$data['sp_id'] = 'A3GK1RS09H3A7D';
			$data['locale'] = 'US';
			$ld = 'SPEXUSAPA-OpencartPL';
		}

		if (isset($this->request->post['amazon_login_pay_language'])) {
			$data['amazon_login_pay_language'] = $this->request->post['amazon_login_pay_language'];
		} elseif ($this->config->get('amazon_login_pay_language')) {
			$data['amazon_login_pay_language'] = $this->config->get('amazon_login_pay_language');
		}

		if (isset($this->request->post['amazon_login_pay_capture_status'])) {
			$data['amazon_login_pay_capture_status'] = $this->request->post['amazon_login_pay_capture_status'];
		} elseif ($this->config->get('amazon_login_pay_capture_status')) {
			$data['amazon_login_pay_capture_status'] = $this->config->get('amazon_login_pay_capture_status');
		} else {
			$data['amazon_login_pay_capture_status'] = '';
		}

		if (isset($this->request->post['amazon_login_pay_pending_status'])) {
			$data['amazon_login_pay_pending_status'] = $this->request->post['amazon_login_pay_pending_status'];
		} elseif ($this->config->get('amazon_login_pay_pending_status')) {
			$data['amazon_login_pay_pending_status'] = $this->config->get('amazon_login_pay_pending_status');
		} else {
			$data['amazon_login_pay_pending_status'] = '0';
		}

		if (isset($this->request->post['amazon_login_pay_ipn_token'])) {
			$data['amazon_login_pay_ipn_token'] = $this->request->post['amazon_login_pay_ipn_token'];
		} elseif ($this->config->get('amazon_login_pay_ipn_token')) {
			$data['amazon_login_pay_ipn_token'] = $this->config->get('amazon_login_pay_ipn_token');
		} else {
			$data['amazon_login_pay_ipn_token'] = sha1(uniqid(mt_rand(), 1));
		}

		$data['ipn_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/amazon_login_pay/ipn&token=' . $data['amazon_login_pay_ipn_token'];

		if (isset($this->request->post['amazon_login_pay_minimum_total'])) {
			$data['amazon_login_pay_minimum_total'] = $this->request->post['amazon_login_pay_minimum_total'];
		} elseif ($this->config->get('amazon_login_pay_minimum_total')) {
			$data['amazon_login_pay_minimum_total'] = $this->config->get('amazon_login_pay_minimum_total');
		} else {
			$data['amazon_login_pay_minimum_total'] = '0.01';
		}

		if (isset($this->request->post['amazon_login_pay_geo_zone'])) {
			$data['amazon_login_pay_geo_zone'] = $this->request->post['amazon_login_pay_geo_zone'];
		} elseif ($this->config->get('amazon_login_pay_geo_zone')) {
			$data['amazon_login_pay_geo_zone'] = $this->config->get('amazon_login_pay_geo_zone');
		} else {
			$data['amazon_login_pay_geo_zone'] = '0';
		}

		if (isset($this->request->post['amazon_login_pay_debug'])) {
			$data['amazon_login_pay_debug'] = $this->request->post['amazon_login_pay_debug'];
		} elseif ($this->config->get('amazon_login_pay_debug')) {
			$data['amazon_login_pay_debug'] = $this->config->get('amazon_login_pay_debug');
		} else {
			$data['amazon_login_pay_debug'] = '0';
		}

		if (isset($this->request->post['amazon_login_pay_sort_order'])) {
			$data['amazon_login_pay_sort_order'] = $this->request->post['amazon_login_pay_sort_order'];
		} elseif ($this->config->get('amazon_login_pay_sort_order')) {
			$data['amazon_login_pay_sort_order'] = $this->config->get('amazon_login_pay_sort_order');
		} else {
			$data['amazon_login_pay_sort_order'] = '0';
		}

		if (isset($this->request->post['amazon_login_pay_status'])) {
			$data['amazon_login_pay_status'] = $this->request->post['amazon_login_pay_status'];
		} elseif ($this->config->get('amazon_login_pay_status')) {
			$data['amazon_login_pay_status'] = $this->config->get('amazon_login_pay_status');
		} else {
			$data['amazon_login_pay_status'] = '0';
		}

		if (isset($this->request->post['amazon_login_pay_declined_code'])) {
			$data['amazon_login_pay_declined_code'] = $this->request->post['amazon_login_pay_declined_code'];
		} elseif ($this->config->get('amazon_login_pay_declined_code')) {
			$data['amazon_login_pay_declined_code'] = $this->config->get('amazon_login_pay_declined_code');
		} else {
			$data['amazon_login_pay_declined_code'] = '';
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['declined_codes'] = array($this->language->get('text_amazon_invalid'), $this->language->get('text_amazon_rejected'), $this->language->get('text_amazon_timeout'));

		//SIMPLE PATH

		$data['unique_id'] = 'oc-' . str_replace(' ', '-', strtolower($this->config->get('config_name'))) . '_' . mt_rand();
		$data['allowed_login_domain'] = html_entity_decode(HTTPS_CATALOG);
		$data['login_redirect_urls'][] = HTTPS_CATALOG . 'index.php?route=payment/amazon_login/login';
		$data['login_redirect_urls'][] = HTTPS_CATALOG . 'index.php?route=payment/amazon_pay/login';
		$data['store_name'] = $this->config->get('config_name');

		if ($data['amazon_login_pay_payment_region'] == 'USD') {
			$data['registration_url'] = "https://sellercentral.amazon.com/hz/me/sp/redirect?ld=" . $ld;

			$data['languages'] = array(
				'en-US' => $this->language->get('text_us')
			);
		} else {
			$data['registration_url'] = "https://sellercentral-europe.amazon.com/hz/me/sp/redirect?ld=" . $ld;

			$data['languages'] = array(
				'de-DE' => $this->language->get('text_de'),
				'es-ES' => $this->language->get('text_es'),
				'fr-FR' => $this->language->get('text_fr'),
				'it-IT' => $this->language->get('text_it'),
				'en-GB' => $this->language->get('text_uk')
			);
		}

		$data['payment_regions'] = array(
			'EUR' => $this->language->get('text_eu_region'),
			'GBP' => $this->language->get('text_uk_region'),
			'USD' => $this->language->get('text_us_region')
		);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/amazon_login_pay', $data));
	}

	public function install() {
		$this->load->model('extension/payment/amazon_login_pay');
		$this->load->model('extension/event');
		$this->model_extension_payment_amazon_login_pay->install();
		$this->model_extension_event->addEvent('amazon_edit_capture', 'catalog/model/checkout/order/after', 'extension/payment/amazon_login_pay/capture');
		$this->model_extension_event->addEvent('amazon_history_capture', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/payment/amazon_login_pay/capture');
	}

	public function uninstall() {
		$this->load->model('extension/payment/amazon_login_pay');
		$this->load->model('extension/event');
		$this->model_extension_payment_amazon_login_pay->uninstall();
		$this->model_extension_event->deleteEvent('amazon_edit_capture');
		$this->model_extension_event->deleteEvent('amazon_history_capture');
	}

	public function order() {

		if ($this->config->get('amazon_login_pay_status')) {

			$this->load->model('extension/payment/amazon_login_pay');

			$amazon_login_pay_order = $this->model_extension_payment_amazon_login_pay->getOrder($this->request->get['order_id']);

			if (!empty($amazon_login_pay_order)) {

				$this->load->language('extension/payment/amazon_login_pay');

				$amazon_login_pay_order['total_captured'] = $this->model_extension_payment_amazon_login_pay->getTotalCaptured($amazon_login_pay_order['amazon_login_pay_order_id']);

				$amazon_login_pay_order['total_formatted'] = $this->currency->format($amazon_login_pay_order['total'], $amazon_login_pay_order['currency_code'], true, true);
				$amazon_login_pay_order['total_captured_formatted'] = $this->currency->format($amazon_login_pay_order['total_captured'], $amazon_login_pay_order['currency_code'], true, true);

				$data['amazon_login_pay_order'] = $amazon_login_pay_order;

				$data['text_payment_info'] = $this->language->get('text_payment_info');
				$data['text_order_ref'] = $this->language->get('text_order_ref');
				$data['text_order_total'] = $this->language->get('text_order_total');
				$data['text_total_captured'] = $this->language->get('text_total_captured');
				$data['text_capture_status'] = $this->language->get('text_capture_status');
				$data['text_cancel_status'] = $this->language->get('text_cancel_status');
				$data['text_refund_status'] = $this->language->get('text_refund_status');
				$data['text_transactions'] = $this->language->get('text_transactions');
				$data['text_yes'] = $this->language->get('text_yes');
				$data['text_no'] = $this->language->get('text_no');
				$data['text_column_authorization_id'] = $this->language->get('text_column_authorization_id');
				$data['text_column_capture_id'] = $this->language->get('text_column_capture_id');
				$data['text_column_refund_id'] = $this->language->get('text_column_refund_id');
				$data['text_column_amount'] = $this->language->get('text_column_amount');
				$data['text_column_type'] = $this->language->get('text_column_type');
				$data['text_column_status'] = $this->language->get('text_column_status');
				$data['text_column_date_added'] = $this->language->get('text_column_date_added');
				$data['text_confirm_cancel'] = $this->language->get('text_confirm_cancel');
				$data['text_confirm_capture'] = $this->language->get('text_confirm_capture');
				$data['text_confirm_refund'] = $this->language->get('text_confirm_refund');

				$data['button_capture'] = $this->language->get('button_capture');
				$data['button_refund'] = $this->language->get('button_refund');
				$data['button_cancel'] = $this->language->get('button_cancel');

				$data['order_id'] = $this->request->get['order_id'];
				$data['token'] = $this->request->get['token'];

				return $this->load->view('extension/payment/amazon_login_pay_order', $data);
			}
		}
	}

	public function cancel() {
		$this->load->language('extension/payment/amazon_login_pay');
		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '') {
			$this->load->model('extension/payment/amazon_login_pay');

			$amazon_login_pay_order = $this->model_extension_payment_amazon_login_pay->getOrder($this->request->post['order_id']);

			$cancel_response = $this->model_extension_payment_amazon_login_pay->cancel($amazon_login_pay_order);

			$this->model_extension_payment_amazon_login_pay->logger($cancel_response);

			if ($cancel_response['status'] == 'Completed') {
				$this->model_extension_payment_amazon_login_pay->addTransaction($amazon_login_pay_order['amazon_login_pay_order_id'], 'cancel', $cancel_response['status'], 0.00);
				$this->model_extension_payment_amazon_login_pay->updateCancelStatus($amazon_login_pay_order['amazon_login_pay_order_id'], 1);
				$json['msg'] = $this->language->get('text_cancel_ok');
				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['type'] = 'cancel';
				$json['data']['status'] = $cancel_response['status'];
				$json['data']['amount'] = $this->currency->format(0.00, $amazon_login_pay_order['currency_code'], true, true);
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($cancel_response['StatuesDetail']) && !empty($cancel_response['StatuesDetail']) ? (string)$cancel_response['StatuesDetail'] : 'Unable to cancel';
			}
		} else {
			$json['error'] = true;
			$json['msg'] = $this->language->get('error_data_missing');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function capture() {
		$this->load->language('extension/payment/amazon_login_pay');
		$json = array();

		if (isset($this->request->post['order_id']) && $this->request->post['order_id'] != '' && isset($this->request->post['amount']) && $this->request->post['amount'] > 0) {
			$this->load->model('extension/payment/amazon_login_pay');

			$amazon_login_pay_order = $this->model_extension_payment_amazon_login_pay->getOrder($this->request->post['order_id']);

			$capture_response = $this->model_extension_payment_amazon_login_pay->capture($amazon_login_pay_order, $this->request->post['amount']);
			$this->model_extension_payment_amazon_login_pay->logger($capture_response);

			if ($capture_response['status'] == 'Completed' || $capture_response['status'] == 'Pending') {
				$this->model_extension_payment_amazon_login_pay->addTransaction($amazon_login_pay_order['amazon_login_pay_order_id'], 'capture', $capture_response['status'], $this->request->post['amount'], $capture_response['AmazonAuthorizationId'], $capture_response['AmazonCaptureId']);

				$total_captured = $this->model_extension_payment_amazon_login_pay->getTotalCaptured($amazon_login_pay_order['amazon_login_pay_order_id']);

				if ($total_captured >= (double)$amazon_login_pay_order['total']) {
					$this->model_extension_payment_amazon_login_pay->closeOrderRef($amazon_login_pay_order['amazon_order_reference_id']);
					$this->model_extension_payment_amazon_login_pay->updateCaptureStatus($amazon_login_pay_order['amazon_login_pay_order_id'], 1);
					$capture_status = 1;
					$json['msg'] = $this->language->get('text_capture_ok_order');
				} else {
					$capture_status = 0;
					$json['msg'] = $this->language->get('text_capture_ok');
				}

				$json['data'] = array();
				$json['data']['date_added'] = date("Y-m-d H:i:s");
				$json['data']['type'] = 'capture';
				$json['data']['status'] = $capture_response['status'];
				$json['data']['amazon_authorization_id'] = $capture_response['AmazonAuthorizationId'];
				$json['data']['amazon_capture_id'] = $capture_response['AmazonCaptureId'];
				$json['data']['amount'] = $this->currency->format($this->request->post['amount'], $amazon_login_pay_order['currency_code'], true, true);
				$json['data']['capture_status'] = $capture_status;
				$json['data']['total'] = $this->currency->format($total_captured, $amazon_login_pay_order['currency_code'], true, true);
				$json['error'] = false;
			} else {
				$json['error'] = true;
				$json['msg'] = isset($capture_response['status_detail']) && !empty($capture_response['status_detail']) ? (string)$capture_response['status_detail'] : 'Unable to capture';
			}
		} else {
			$json['error'] = true;
			$json['msg'] = $this->language->get('error_data_missing');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function refund() {
		$this->load->language('extension/payment/amazon_login_pay');
		$json = array();

		if (isset($this->request->post['order_id']) && !empty($this->request->post['order_id'])) {
			$this->load->model('extension/payment/amazon_login_pay');

			$amazon_login_pay_order = $this->model_extension_payment_amazon_login_pay->getOrder($this->request->post['order_id']);

			$refund_response = $this->model_extension_payment_amazon_login_pay->refund($amazon_login_pay_order, $this->request->post['amount']);

			$this->model_extension_payment_amazon_login_pay->logger($refund_response);

			$refund_status = '';
			$total_captured = '';
			$total_refunded = '';

			foreach ($refund_response as $response) {
				if ($response['status'] == 'Pending') {
					$this->model_extension_payment_amazon_login_pay->addTransaction($amazon_login_pay_order['amazon_login_pay_order_id'], 'refund', $response['status'], $response['amount'] * -1, $response['amazon_authorization_id'], $response['amazon_capture_id'], $response['AmazonRefundId']);

					$total_refunded = $this->model_extension_payment_amazon_login_pay->getTotalRefunded($amazon_login_pay_order['amazon_login_pay_order_id']);
					$total_captured = $this->model_extension_payment_amazon_login_pay->getTotalCaptured($amazon_login_pay_order['amazon_login_pay_order_id']);

					if ($total_captured <= 0 && $amazon_login_pay_order['capture_status'] == 1) {
						$this->model_extension_payment_amazon_login_pay->updateRefundStatus($amazon_login_pay_order['amazon_login_pay_order_id'], 1);
						$refund_status = 1;
						$json['msg'][] = $this->language->get('text_refund_ok_order') . '<br />';
					} else {
						$refund_status = 0;
						$json['msg'][] = $this->language->get('text_refund_ok') . '<br />';
					}

					$data = array();
					$data['date_added'] = date("Y-m-d H:i:s");
					$data['type'] = 'refund';
					$data['status'] = $response['status'];
					$data['amazon_authorization_id'] = $response['amazon_authorization_id'];
					$data['amazon_capture_id'] = $response['amazon_capture_id'];
					$data['amazon_refund_id'] = $response['AmazonRefundId'];
					$data['amount'] = $this->currency->format(($response['amount'] * -1), $amazon_login_pay_order['currency_code'], true, true);
					$json['data'][] = $data;
				} else {
					$json['error'] = true;
					$json['error_msg'][] = isset($response['status_detail']) && !empty($response['status_detail']) ? (string)$response['status_detail'] : 'Unable to refund';
				}
			}
			$json['refund_status'] = $refund_status;
			$json['total_captured'] = $this->currency->format($total_captured, $amazon_login_pay_order['currency_code'], true, true);
			$json['total_refunded'] = $this->currency->format($total_refunded, $amazon_login_pay_order['currency_code'], true, true);
		} else {
			$json['error'] = true;
			$json['error_msg'][] = $this->language->get('error_data_missing');
		}
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		$this->load->model('localisation/currency');

		if (!$this->user->hasPermission('modify', 'extension/payment/amazon_login_pay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['amazon_login_pay_merchant_id']) {
			$this->error['error_merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['amazon_login_pay_access_key']) {
			$this->error['error_access_key'] = $this->language->get('error_access_key');
		}

		if (empty($this->error)) {
			$this->load->model('extension/payment/amazon_login_pay');
			$errors = $this->model_extension_payment_amazon_login_pay->validateDetails($this->request->post);
			if (isset($errors['error_code']) && $errors['error_code'] == 'InvalidParameterValue') {
				$this->error['error_merchant_id'] = $errors['status_detail'];
			} elseif (isset($errors['error_code']) && $errors['error_code'] == 'InvalidAccessKeyId') {
				$this->error['error_access_key'] = $errors['status_detail'];
			}
		}

		if (!$this->request->post['amazon_login_pay_access_secret']) {
			$this->error['error_access_secret'] = $this->language->get('error_access_secret');
		}

		if (!$this->request->post['amazon_login_pay_client_id']) {
			$this->error['error_client_id'] = $this->language->get('error_client_id');
		}

		if (!$this->request->post['amazon_login_pay_client_secret']) {
			$this->error['error_client_secret'] = $this->language->get('error_client_secret');
		}

		if ($this->request->post['amazon_login_pay_minimum_total'] <= 0) {
			$this->error['error_minimum_total'] = $this->language->get('error_minimum_total');
		}

		if (isset($this->request->post['amazon_login_pay_region'])) {
			$currency_code = $this->request->post['amazon_login_pay_region'];

			$currency = $this->model_localisation_currency->getCurrency($this->currency->getId($currency_code));

			if (empty($currency) || $currency['status'] != '1') {
				$this->error['error_curreny'] = sprintf($this->language->get('error_curreny'), $currency_code);
			}
		}

		return !$this->error;
	}

}