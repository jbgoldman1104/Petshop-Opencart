<?php
class ControllerExtensionModuleAmazonPay extends Controller {
	public function index() {

		$this->load->model('extension/payment/amazon_login_pay');

		if ($this->config->get('amazon_login_pay_status') && $this->config->get('amazon_pay_status') && !empty($this->request->server['HTTPS']) && !($this->config->get('amazon_login_pay_minimum_total') > 0 && $this->config->get('amazon_login_pay_minimum_total') > $this->cart->getSubTotal())) {
			// capital L in Amazon cookie name is required, do not alter for coding standards
			if (!$this->customer->isLogged() && isset($this->request->cookie['amazon_Login_state_cache'])) {
				setcookie('amazon_Login_state_cache', '', time() - 4815162342);
			}

			$amazon_payment_js = $this->model_extension_payment_amazon_login_pay->getWidgetJs();
			$this->document->addScript($amazon_payment_js);

			$data['amazon_login_pay_client_id'] = $this->config->get('amazon_login_pay_client_id');

			if ($this->config->get('amazon_login_pay_test') == 'sandbox') {
				$data['amazon_login_pay_test'] = true;
			}

			$data['amazon_pay_return_url'] = $this->url->link('extension/module/amazon_pay/login', '', true);

			if ($this->config->get('amazon_pay_button_type')) {
				$data['amazon_pay_button_type'] = $this->config->get('amazon_pay_button_type');
			} else {
				$data['amazon_pay_button_type'] = 'PwA';
			}

			if ($this->config->get('amazon_pay_button_colour')) {
				$data['amazon_pay_button_colour'] = $this->config->get('amazon_pay_button_colour');
			} else {
				$data['amazon_pay_button_colour'] = 'Gold';
			}

			if ($this->config->get('amazon_pay_button_size')) {
				$data['amazon_pay_button_size'] = $this->config->get('amazon_pay_button_size');
			} else {
				$data['amazon_pay_button_size'] = 'medium';
			}

			if ($this->config->get('amazon_login_pay_language')) {
				$data['amazon_login_pay_language'] = $this->config->get('amazon_login_pay_language');
			} else {
				$data['amazon_login_pay_language'] = 'en-US';
			}

			return $this->load->view('extension/module/amazon_pay', $data);
		}
	}

	public function login() {
		$this->load->model('extension/payment/amazon_login_pay');
		$this->load->model('account/customer');
		$this->load->model('account/customer_group');
		$this->load->language('extension/payment/amazon_login_pay');

		unset($this->session->data['lpa']);
		unset($this->session->data['access_token']);

		if (isset($this->request->get['access_token'])) {
			$this->session->data['access_token'] = $this->request->get['access_token'];
			$user = $this->model_extension_payment_amazon_login_pay->getUserInfo($this->request->get['access_token']);
		} else {
			$user = array();
		}

		if ((array)$user) {
			if (isset($user->error)) {
				$this->model_extension_payment_amazon_login_pay->logger($user->error . ': ' . $user->error_description);
				$this->session->data['lpa']['error'] = $this->language->get('error_login');
				$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/loginFailure', '', true));
			}

			if ($this->customer->isLogged() && $this->customer->getEmail() != $user->email) {
				$this->session->data['lpa']['error'] = sprintf($this->language->get('error_login_email'), $this->config->get('config_name'));
				$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/loginFailure', '', true));
			} elseif ($this->customer->isLogged()) {
				$this->model_extension_payment_amazon_login_pay->logger('isLogged');
				$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/address', '', true));
			}

			$customer_info = $this->model_account_customer->getCustomerByEmail($user->email);
			$this->model_extension_payment_amazon_login_pay->logger($user);

			if ($this->config->get('amazon_login_pay_checkout') == 'guest') {
				$full_name = explode(' ', $user->name);
				$last_name = array_pop($full_name);
				$first_name = implode(' ', $full_name);
				$this->session->data['account'] = 'guest';
				$this->session->data['guest']['customer_group_id'] = $this->config->get('config_customer_group_id');
				$this->session->data['guest']['firstname'] = $first_name;
				$this->session->data['guest']['lastname'] = $last_name;
				$this->session->data['guest']['email'] = $user->email;
				$this->session->data['guest']['telephone'] = '';
				$this->session->data['guest']['fax'] = '';
				$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/address', '', true));
			} else if ($customer_info) {
				if ($this->validate($user->email)) {
					unset($this->session->data['guest']);

					$this->load->model('account/address');

					if ($this->config->get('config_tax_customer') == 'payment') {
						$payment_address = $this->model_account_address->getAddress($this->customer->getAddressId());
						if($payment_address){
							$this->session->data['payment_address'] = $payment_address;
						}
					}

					if ($this->config->get('config_tax_customer') == 'shipping') {
						$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());
						if($shipping_address){
							$this->session->data['shipping_address'] = $shipping_address;
						}
					}

					if ($this->config->get('config_customer_activity')) {
						$this->load->model('account/activity');

						$activity_data = array(
							'customer_id' => $this->customer->getId(),
							'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
						);

						$this->model_account_activity->addActivity('login', $activity_data);
					}

					$this->model_extension_payment_amazon_login_pay->logger('Customer logged in - ID: ' . $customer_info['customer_id'] . ', Email: ' . $customer_info['email']);
				} else {
					$this->model_extension_payment_amazon_login_pay->logger('Could not login to - ID: ' . $customer_info['customer_id'] . ', Email: ' . $customer_info['email']);
					$this->session->data['lpa']['error'] = $this->language->get('error_login');
					$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/loginFailure', '', true));
				}

				$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/address', '', true));
			} else {
				$country_id = 0;
				$zone_id = 0;

				$full_name = explode(' ', $user->name);
				$last_name = array_pop($full_name);
				$first_name = implode(' ', $full_name);

				$data = array(
					'customer_group_id' => (int)$this->config->get('config_customer_group_id'),
					'firstname' => $first_name,
					'lastname' => $last_name,
					'email' => $user->email,
					'telephone' => '',
					'fax' => '',
					'password' => uniqid(rand(), true),
					'company' => '',
					'address_1' => '',
					'address_2' => '',
					'city' => '',
					'postcode' => '',
					'country_id' => (int)$country_id,
					'zone_id' => (int)$zone_id,
				);

				$customer_id = $this->model_extension_payment_amazon_login_pay->addCustomer($data);

				$this->model_extension_payment_amazon_login_pay->logger('Customer ID created: ' . $customer_id);

				if ($this->validate($user->email)) {
					unset($this->session->data['guest']);

					$this->load->model('account/address');

					if ($this->config->get('config_tax_customer') == 'payment') {
						$payment_address = $this->model_account_address->getAddress($this->customer->getAddressId());
						if($payment_address){
							$this->session->data['payment_address'] = $payment_address;
						}
					}

					if ($this->config->get('config_tax_customer') == 'shipping') {
						$shipping_address = $this->model_account_address->getAddress($this->customer->getAddressId());
						if($shipping_address){
							$this->session->data['shipping_address'] = $shipping_address;
						}
					}

					if ($this->config->get('config_customer_activity')) {
						$this->load->model('account/activity');

						$activity_data = array(
							'customer_id' => $this->customer->getId(),
							'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
						);

						$this->model_account_activity->addActivity('login', $activity_data);
					}

					$this->model_extension_payment_amazon_login_pay->logger('Customer logged in - ID: ' . $customer_id . ', Email: ' . $user->email);
					$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/address', '', true));
				} else {
					$this->model_extension_payment_amazon_login_pay->logger('Could not login to - ID: ' . $customer_id . ', Email: ' . $user->email);
					$this->session->data['lpa']['error'] = $this->language->get('error_login');
					$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/loginFailure', '', true));
				}
			}
		} else {

			$this->session->data['lpa']['error'] = $this->language->get('error_login');
			$this->response->redirect($this->url->link('extension/payment/amazon_login_pay/loginFailure', '', true));
		}
	}

	public function logout() {
		unset($this->session->data['lpa']);
		unset($this->session->data['access_token']);

		// capital L in Amazon cookie name is required, do not alter for coding standards
		if (isset($this->request->cookie['amazon_Login_state_cache'])) {
			setcookie('amazon_Login_state_cache', '', time() - 4815162342);
		}
	}

	protected function validate($email) {
		if (!$this->customer->login($email, '', true)) {
			$this->error['warning'] = $this->language->get('error_login');
		}

		$customer_info = $this->model_account_customer->getCustomerByEmail($email);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		return !$this->error;
	}

}
