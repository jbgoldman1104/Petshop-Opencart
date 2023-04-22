<?php
class ControllerExtensionModulePavnewsletter extends Controller {
	
	private $error = array();
	private $mdata = array();

	public function initData(){

		$this->mdata['objlang'] = $this->language;
		$this->mdata['objurl'] = $this->url;

		$this->load->language('extension/module/pavnewsletter');

		$this->load->model('localisation/language');

		$this->load->model('setting/setting');

		$this->load->model('localisation/order_status');

		$this->load->model('pavnewsletter/newsletter');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->_getLanguage();

		// Stores
		$this->mdata['stores'] = $this->_getStores();
		$store_id = isset($this->request->get['store_id'])?$this->request->get['store_id']:0;
		$this->mdata['store_id'] = $store_id;
    	
    	// Alert
    	if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}
		
		// Get Menu template
		$menus = array();
		$menus["dashboard"] = array("link"=>$this->url->link('extension/module/pavnewsletter', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_dashboard'));
		//$menus["create_newsletter"] = array("link"=>$this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_create_newsletter'));
		//$menus["draft"] = array("link"=>$this->url->link('extension/module/pavnewsletter/draft', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_manage_draft_newsletters'));
		$menus["subscribes"] = array("link"=>$this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_manage_subscribes'));
		//$menus["templates"] = array("link"=>$this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_templates'));
		$menus["modules"] = array("link"=>$this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_manage_modules'));
		//$menus["config"] = array("link"=>$this->url->link('extension/module/pavnewsletter/config', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_global_config'));
		

		$menus["draft_contact"] = array("link"=>$this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_draft_contact'));
		$menus["contact"] = array("link"=>$this->url->link('extension/module/pavnewsletter/contact', 'token=' . $this->session->data['token'], 'SSL'),"title"=>$this->language->get('menu_contact'));
		

   		$this->mdata["menus"] = $menus;
		
   		$this->document->addStyle('view/stylesheet/pavnewsletter.css');
	}

	public function _getStores(){
		$this->load->model('setting/store');
		$action = array();
		$action[] = array(
			'text' => $this->language->get('text_edit'),
			'href' => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL')
		);
		$store_default = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG,
		);
		$stores = $this->model_setting_store->getStores();
		array_unshift($stores, $store_default);
		
		foreach ($stores as &$store) {
			$url = '';
			if ($store['store_id'] > 0 ) {
				$url = '&store_id='.$store['store_id'];
			}
			$store['option'] = $this->url->link('extension/module/pavnewsletter/modules', $url.'&token=' . $this->session->data['token'], 'SSL');
		}
		return $stores;
	}

	public function _getLanguage() {
		$this->mdata['heading_title'] = $this->language->get('heading_title');
		$this->mdata['text_enabled'] = $this->language->get('text_enabled');
		$this->mdata['text_disabled'] = $this->language->get('text_disabled');
		$this->mdata['text_yes'] = $this->language->get('text_yes');
		$this->mdata['text_no'] = $this->language->get('text_no');
		$this->mdata['text_content_top'] = $this->language->get('text_content_top');
		$this->mdata['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->mdata['text_column_left'] = $this->language->get('text_column_left');
		$this->mdata['text_column_right'] = $this->language->get('text_column_right');

		$this->mdata['entry_limit'] = $this->language->get('entry_limit');
		$this->mdata['entry_username'] = $this->language->get('entry_username');
		$this->mdata['entry_layout'] = $this->language->get('entry_layout');
		$this->mdata['entry_position'] = $this->language->get('entry_position');
		$this->mdata['entry_status'] = $this->language->get('entry_status');
		$this->mdata['entry_sort_order'] = $this->language->get('entry_sort_order');
    	$this->mdata['entry_width_height'] = $this->language->get('entry_width_height');
    	$this->mdata['entry_image_selector']	= $this->language->get('entry_image_selector');
    	$this->mdata['entry_image_selector_help'] = $this->language->get('entry_image_selector_help');
    	$this->mdata['entry_additional_width_height'] = $this->language->get('entry_additional_width_height');

		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');

		$this->mdata['button_add'] = $this->language->get('button_add');
		$this->mdata['button_rebuild'] = $this->language->get('button_rebuild');

		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		$this->mdata['button_copy_default'] = $this->language->get('button_copy_default');
		$this->mdata['button_copy'] = $this->language->get('button_copy');
		$this->mdata['button_edit'] = $this->language->get('button_edit');
		$this->mdata['button_insert'] = $this->language->get('button_insert');
		$this->mdata['button_delete'] = $this->language->get('button_delete');
    	$this->mdata['tab_module'] = $this->language->get('tab_module');

		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();

		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL');
   		$this->mdata['yesno'] = array(0=>$this->language->get('text_no'),1=>$this->language->get('text_yes'));

	}
	/**
	 * set breadcrumb
	 */
	public function setBreadcrumb(){


		$this->mdata['breadcrumbs'] = array();

   		$this->mdata['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->mdata['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->mdata['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/pavnewsletter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	}
	public function index() {

		$this->initData();

		$model = $this->model_pavnewsletter_newsletter;

		$model->installModule();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pavnewsletter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavnewsletter', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->setBreadcrumb();

		// Get Data Setting
		$this->mdata['modules'] = array();
		if (isset($this->request->post['pavnewsletter_module'])) {
			$this->mdata['modules'] = $this->request->post['pavnewsletter_module'];
		} elseif ($this->config->get('pavnewsletter_module')) {
			$this->mdata['modules'] = $this->config->get('pavnewsletter_module');
		}

		$this->mdata['general'] = $this->config->get('pavnewsletter_config');


		// Render
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');

		$template = 'extension/module/pavnewsletter/panel.tpl';
		$this->response->setOutput($this->load->view($template, $this->mdata));
	
	}
	public function subsribes(){
		$this->initData();
		$this->load->model('pavnewsletter/subscribe');
		$this->load->model('setting/store');
		$this->load->model('customer/customer_group');
		$data = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$post = $this->request->post;
			
			if(isset($post) && $post['action'] == "delete" && !empty($post['selected'])){
				$selected = $post['selected'];
				// Delete Subsribes
				foreach ($selected as $key => $value) {
					$this->model_pavnewsletter_subscribe->delete($value);
				}

			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['page'] = isset($this->request->get['page'])?$this->request->get['page']:1;
		$data['limit'] = $this->config->get('config_admin_limit');
		$data['filter'] = array();
		$data['filter']['name'] = isset($this->request->get['filter_name'])?$this->request->get['filter_name']:"";
		$data['filter']['email'] = isset($this->request->get['filter_email'])?$this->request->get['filter_email']:"";
		$data['filter']['action'] = isset($this->request->get['filter_action'])?$this->request->get['filter_action']:"";
		$data['filter']['customer_group_id'] = isset($this->request->get['filter_customer_group_id'])?$this->request->get['filter_customer_group_id']:"";
		$data['filter']['store_id'] = isset($this->request->get['filter_store_id'])?$this->request->get['filter_store_id']:"";
		$data['sort'] = isset($this->request->get['sort'])?$this->request->get['sort']:"name";
		$data['order'] = isset($this->request->get['order'])?$this->request->get['order']:"DESC";


		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_action'])) {
			$url .= '&filter_action=' . $this->request->get['filter_action'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->mdata["menu_active"] = "subscribes";

		$subscribe_total = $this->model_pavnewsletter_subscribe->getTotalSubscribers($data);

		$results = $this->model_pavnewsletter_subscribe->getSubscribers($data);
		$stores = $this->model_setting_store->getStores();

		$tmp = array();
		$tmp[0] = $this->language->get("text_default_store");
		if(!empty($stores)){
			foreach($stores as $store ){
				$tmp[$store["store_id"]] = $store["name"];
			}
		}
		$stores = $tmp;
		$this->mdata["stores"] = $stores;
		$customer_groups = $this->model_pavnewsletter_subscribe->getCustomerGroups();
		$tmp = array();
		if(!empty($customer_groups)){
			foreach($customer_groups as $group ){
				$tmp[$group["customer_group_id"]] = $group["name"];
			}
		}
		$customer_groups = $tmp;
		$this->mdata["customer_groups"] = $customer_groups;
		$this->mdata['subscribes'] = array();
		foreach ($results as $result) {
			$action = array();
			$action_name = "";
			if($result['action'] == 1){
				$action_name =  $this->language->get('text_yes');
				$action[] = array(
				'text' => $this->language->get('text_unsubscribe'),
				'href' => $this->url->link('extension/module/pavnewsletter/unsubsribe', 'token=' . $this->session->data['token'] . '&subscribe_id=' . $result['subscribe_id'] . $url, 'SSL')
				);
			}else{
				$action_name =  $this->language->get('text_no');
				$action[] = array(
				'text' => $this->language->get('text_subscribe'),
				'href' => $this->url->link('extension/module/pavnewsletter/subsribe', 'token=' . $this->session->data['token'] . '&subscribe_id=' . $result['subscribe_id'] . $url, 'SSL')
				);
			}
			$customer_group_name = isset($customer_groups[$result["customer_group_id"]])?$customer_groups[$result["customer_group_id"]]:"";
			$store_name = isset($stores[$result["store_id"]])?$stores[$result["store_id"]]:$this->language->get("text_default_store");
      		$this->mdata['subscribes'][] = array(
				'subscribe_id' => $result['subscribe_id'],
				'name'       => $result['name'],
				'email'      => $result['email'],
				'subscribe'      => $action_name,
				'store'    => $store_name,
				'customer_group'   => $customer_group_name,
				'action'     => $action
			);
    	}

    	$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_action'])) {
			$url .= '&filter_action=' . $this->request->get['filter_action'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}

		if ($data['order'] == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->mdata['button_filter'] = $this->language->get("button_filter");
		$this->mdata['column_name'] = $this->language->get("column_name");
		$this->mdata['column_email'] = $this->language->get("column_email");
		$this->mdata['column_customer_group'] = $this->language->get("column_customer_group");
		$this->mdata['column_subscribe'] = $this->language->get("column_subscribe");
		$this->mdata['column_store'] = $this->language->get("column_store");
		$this->mdata['column_action'] = $this->language->get("column_action");
		$this->mdata['text_no_results'] = $this->language->get("text_no_results");

		$this->mdata['token'] = $this->session->data['token'];
		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}

		$this->mdata['sort_name'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->mdata['sort_email'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
		$this->mdata['sort_subscribe'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . '&sort=s.action' . $url, 'SSL');
		$this->mdata['sort_customer_group_id'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . '&sort=customer_group_id' . $url, 'SSL');
		$this->mdata['sort_store_id'] = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . '&sort=s.store_id' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_action'])) {
			$url .= '&filter_action=' . $this->request->get['filter_action'];
		}

		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $subscribe_total;
		$pagination->page = $data['page'];
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->mdata['pagination'] = $pagination->render();

		$this->setBreadcrumb();


		$this->mdata['filter_name'] = $data['filter']['name'];
		$this->mdata['filter_email'] = $data['filter']['email'];
		$this->mdata['filter_action'] = $data['filter']['action'];
		$this->mdata['filter_store_id'] = $data['filter']['store_id'];
		$this->mdata['filter_customer_group_id'] = $data['filter']['customer_group_id'];

		$this->mdata['sort'] = $data['sort'];
		$this->mdata['order'] = $data['order'];

		$template = 'extension/module/pavnewsletter/subscribes.tpl';
		$this->_render($template);
	}
	public function unsubsribe(){
		$this->load->model('pavnewsletter/subscribe');
		if (isset($this->request->get['subscribe_id'])) {
			$subscribe_id = $this->request->get['subscribe_id'];
		} else {
			$subscribe_id = 0;
		}
		if(!empty($subscribe_id)){
			$this->model_pavnewsletter_subscribe->updateAction($subscribe_id, 0);
		}
		$this->response->redirect($this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function subsribe(){
		$this->load->model('pavnewsletter/subscribe');
		if (isset($this->request->get['subscribe_id'])) {
			$subscribe_id = $this->request->get['subscribe_id'];
		} else {
			$subscribe_id = 0;
		}
		if(!empty($subscribe_id)){
			$this->model_pavnewsletter_subscribe->updateAction($subscribe_id, 1);
		}
		$this->response->redirect($this->url->link('extension/module/pavnewsletter/subsribes', 'token=' . $this->session->data['token'], 'SSL'));
	}
	public function draft(){
		$this->initData();
		$this->setBreadcrumb();
		$this->load->model("pavnewsletter/template");
    	$this->load->model("pavnewsletter/draft");
		$this->mdata["menu_active"] = "draft";
		$this->mdata['cancel'] = $this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL');
		$template_id = isset($this->request->get['id'])?$this->request->get['id']:0;
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			  $action = isset($this->request->post["action"])?$this->request->post["action"]:"";
        if($action == "delete"){
            foreach ($this->request->post['selected'] as $draft_id) {
                $this->model_pavnewsletter_draft->delete($draft_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
        }

        $this->response->redirect($this->url->link('extension/module/pavnewsletter/draft', 'token=' . $this->session->data['token'], 'SSL'));

		}
      if (isset($this->request->get['filter_date'])) {
          $filter_date = $this->request->get['filter_date'];
      } else {
          $filter_date = null;
      }

      if (isset($this->request->get['filter_subject'])) {
          $filter_subject = $this->request->get['filter_subject'];
      } else {
          $filter_subject = null;
      }

      if (isset($this->request->get['filter_to'])) {
          $filter_to = $this->request->get['filter_to'];
      } else {
          $filter_to = null;
      }

      if (isset($this->request->get['filter_store'])) {
          $filter_store = $this->request->get['filter_store'];
      } else {
          $filter_store = null;
      }

      if (isset($this->request->get['sort'])) {
          $sort = $this->request->get['sort'];
      } else {
          $sort = 'draft_id';
      }

      if (isset($this->request->get['order'])) {
          $order = $this->request->get['order'];
      } else {
          $order = 'DESC';
      }

      if (isset($this->request->get['page'])) {
          $page = $this->request->get['page'];
      } else {
          $page = 1;
      }

      $url = '';

      if (isset($this->request->get['filter_date'])) {
          $url .= '&filter_date=' . $this->request->get['filter_date'];
      }

      if (isset($this->request->get['filter_subject'])) {
          $url .= '&filter_subject=' . $this->request->get['filter_subject'];
      }

      if (isset($this->request->get['filter_to'])) {
          $url .= '&filter_to=' . $this->request->get['filter_to'];
      }

      if (isset($this->request->get['filter_store'])) {
          $url .= '&filter_store=' . $this->request->get['filter_store'];
      }

      if (isset($this->request->get['sort'])) {
          $url .= '&sort=' . $this->request->get['sort'];
      }

      if (isset($this->request->get['order'])) {
          $url .= '&order=' . $this->request->get['order'];
      }

      if (isset($this->request->get['page'])) {
          $url .= '&page=' . $this->request->get['page'];
      }

      $this->mdata['breadcrumbs'] = array();

      $this->mdata['breadcrumbs'][] = array(
          'text'      => $this->language->get('text_home'),
          'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
          'separator' => false
      );

      $this->mdata['breadcrumbs'][] = array(
          'text'      => $this->language->get('heading_title'),
          'href'      => $this->url->link('extension/module/pavnewsletter', 'token=' . $this->session->data['token'], 'SSL'),
          'separator' => ' :: '
      );


      $data = array(
          'filter_date'		=> $filter_date,
          'filter_subject'	=> $filter_subject,
          'filter_to'			=> $filter_to,
          'filter_store'		=> $filter_store,
          'sort'				=> $sort,
          'order'				=> $order,
          'start'				=> ($page - 1) * $this->config->get('config_admin_limit'),
          'limit'				=> $this->config->get('config_admin_limit')
      );

      $total = $this->model_pavnewsletter_draft->getTotal($data);

      $this->mdata['draft'] = array();

      $results = $this->model_pavnewsletter_draft->getList($data);

      foreach ($results as $result) {
          $this->mdata['draft'][] = array_merge($result, array(
              'selected' => isset($this->request->post['selected']) && is_array($this->request->post['selected']) && in_array($result['draft_id'], $this->request->post['selected'])
          ));
      }
      unset($result);

      $this->mdata['heading_title'] = $this->language->get('heading_title');

      $this->mdata['text_no_results'] = $this->language->get('text_no_results');

      $this->mdata['column_subject'] = $this->language->get('column_subject');
      $this->mdata['column_date'] = $this->language->get('column_date');
      $this->mdata['column_to'] = $this->language->get('column_to');
      $this->mdata['column_actions'] = $this->language->get('column_actions');
      $this->mdata['column_store'] = $this->language->get('column_store');

      $this->mdata['button_delete'] = $this->language->get('button_delete');
      $this->mdata['button_filter'] = $this->language->get('button_filter');

      $this->mdata['text_marketing'] = $this->language->get('text_marketing');
      $this->mdata['text_marketing_all'] = $this->language->get('text_marketing_all');
      $this->mdata['text_subscriber_all'] = $this->language->get('text_subscriber_all');
      $this->mdata['text_all'] = $this->language->get('text_all');
      $this->mdata['text_newsletter'] = $this->language->get('text_newsletter');
      $this->mdata['text_customer_all'] = $this->language->get('text_customer_all');
      $this->mdata['text_customer'] = $this->language->get('text_customer');
      $this->mdata['text_customer_group'] = $this->language->get('text_customer_group');
      $this->mdata['text_affiliate_all'] = $this->language->get('text_affiliate_all');
      $this->mdata['text_affiliate'] = $this->language->get('text_affiliate');
      $this->mdata['text_product'] = $this->language->get('text_product');
      $this->mdata['text_view'] = $this->language->get('text_view');
      $this->mdata['text_default'] = $this->language->get('text_default');

      $this->mdata['token'] = $this->session->data['token'];

      if (isset($this->error['warning'])) {
          $this->mdata['error_warning'] = $this->error['warning'];
      } else {
          $this->mdata['error_warning'] = '';
      }

      if (isset($this->session->data['success'])) {
          $this->mdata['success'] = $this->session->data['success'];

          unset($this->session->data['success']);
      } else {
          $this->mdata['success'] = '';
      }

      $url = '';

      if (isset($this->request->get['filter_date'])) {
          $url .= '&filter_date=' . $this->request->get['filter_date'];
      }

      if (isset($this->request->get['filter_subject'])) {
          $url .= '&filter_subject=' . $this->request->get['filter_subject'];
      }

      if (isset($this->request->get['filter_to'])) {
          $url .= '&filter_to=' . $this->request->get['filter_to'];
      }

      if ($order == 'ASC') {
          $url .= '&order=' .  'DESC';
      } else {
          $url .= '&order=' .  'ASC';
      }

      if (isset($this->request->get['page'])) {
          $url .= '&page=' . $this->request->get['page'];
      }

      $this->mdata['sort_date'] = $this->url->link('ne/draft', 'token=' . $this->session->data['token'] . '&sort=datetime' . $url, 'SSL');
      $this->mdata['sort_subject'] = $this->url->link('ne/draft', 'token=' . $this->session->data['token'] . '&sort=subject' . $url, 'SSL');
      $this->mdata['sort_to'] = $this->url->link('ne/draft', 'token=' . $this->session->data['token'] . '&sort=to' . $url, 'SSL');
      $this->mdata['sort_store'] = $this->url->link('ne/draft', 'token=' . $this->session->data['token'] . '&sort=store_id' . $url, 'SSL');

      $url = '';

      if (isset($this->request->get['filter_date'])) {
          $url .= '&filter_date=' . $this->request->get['filter_date'];
      }

      if (isset($this->request->get['filter_subject'])) {
          $url .= '&filter_subject=' . $this->request->get['filter_subject'];
      }

      if (isset($this->request->get['filter_to'])) {
          $url .= '&filter_to=' . $this->request->get['filter_to'];
      }

      if (isset($this->request->get['filter_store'])) {
          $url .= '&filter_store=' . $this->request->get['filter_store'];
      }

      if (isset($this->request->get['sort'])) {
          $url .= '&sort=' . $this->request->get['sort'];
      }

      if (isset($this->request->get['order'])) {
          $url .= '&order=' . $this->request->get['order'];
      }

      $this->mdata['detail'] = $this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'] . $url . '&id=', 'SSL');
      $this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/draft', 'token=' . $this->session->data['token'], 'SSL');

      $pagination = new Pagination();
      $pagination->total = $total;
      $pagination->page = $page;
      $pagination->limit = $this->config->get('config_admin_limit');
      $pagination->text = $this->language->get('text_pagination');
      $pagination->url = $this->url->link('extension/module/pavnewsletter/draft', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

      $this->mdata['pagination'] = $pagination->render();

      $this->load->model('setting/store');

      $this->mdata['stores'] = $this->model_setting_store->getStores();

      $this->mdata['filter_date'] = $filter_date;
      $this->mdata['filter_subject'] = $filter_subject;
      $this->mdata['filter_to'] = $filter_to;
      $this->mdata['filter_store'] = $filter_store;

      $this->mdata['sort'] = $sort;
      $this->mdata['order'] = $order;

      $template = 'extension/module/pavnewsletter/draft_newsletter.tpl';
    

      $this->_render($template);
	}
	public function preview_newsletter(){

	}
	public function get_template(){
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$post = http_build_query($this->request->post, '', '&');

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$store_url = (defined('HTTPS_CATALOG') ? HTTPS_CATALOG : HTTP_CATALOG);
			} else {
				$store_url = HTTP_CATALOG;
			}

			if (isset($this->request->post['store_id'])) {
				$this->load->model('setting/store');
				$store = $this->model_setting_store->getStore($this->request->post['store_id']);
				if ($store) {
					$url = rtrim($store['url'], '/') . '/index.php?route=extension/module/pavnewsletter/get_template/json';
				} else {
					$url = $store_url . 'index.php?route=extension/module/pavnewsletter/get_template/json';
				}
			} else {
				$url = $store_url . 'index.php?route=extension/module/pavnewsletter/get_template/json';
			}

			$result = $this->do_request(array(
				'url' => $url,
				'header' => array('Content-type: application/x-www-form-urlencoded', "Content-Length: ". strlen($post), "X-Requested-With: XMLHttpRequest"),
				'method' => 'POST',
				'content' => $post
			));

			$response = $result['response'];

			$this->response->addHeader('Content-type: application/json');
			$this->response->setOutput($response);
		} else {
			$this->response->redirect($this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	private function do_request($options) {
		$options = $options + array(
			'method' => 'GET',
			'content' => false,
			'header' => false,
			'async' => false,
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $options['url']);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_USERAGENT, 'PavNewsletter for Opencart');

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		if ($options['header']) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']);
		}

		if ($options['async']) {
			curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		} else {
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		}

		switch ($options['method']) {
			case 'HEAD':
				curl_setopt($ch, CURLOPT_NOBODY, 1);
				break;
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $options['content']);
				break;
			case 'PUT':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $options['content']);
				break;
			default:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $options['method']);
				if ($options['content'])
					curl_setopt($ch, CURLOPT_POSTFIELDS, $options['content']);
				break;
		}

		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		return array(
			'header' => substr($result, 0, $info['header_size']),
			'response' => substr($result, $info['header_size']),
			'status' => $status,
			'info' => $info
		);
	}
	public function save_draft(){
      if ($this->request->server['REQUEST_METHOD'] == 'POST') {
          $this->load->model('pavnewsletter/draft');
          $this->load->language('extension/module/pavnewsletter');
          $this->model_pavnewsletter_draft->save($this->request->post);
          $this->session->data['success'] = $this->language->get('text_success_save');
      }

      $this->response->redirect($this->url->link('extension/module/pavnewsletter/draft', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validateSend() {
		$post = array(
			'subject' => '',
			'message' => ''
		);
		$this->request->post = array_merge( $post, $this->request->post );
		
		if (!$this->user->hasPermission('modify', 'extension/module/pavnewsletter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['subject']) < 1)) {
			$this->error['subject'] = $this->language->get('error_newsletter_subject');
		}

		if ((utf8_strlen($this->request->post['message']) < 1)) {
			$this->error['message'] = $this->language->get('error_newsletter_message');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}



		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	// basic send mail version 2.x
	public function draft_contact(){
		$this->load->language('extension/module/pavnewsletter');
		$this->load->model('pavnewsletter/draft');

		// LOAD INIT DATA
		$this->initData();
		$this->setBreadcrumb();
		$this->mdata["menu_active"] = "draft_contact";

		// LANGUAGE
		$this->mdata['text_list'] = $this->language->get('text_list');
		$this->mdata['text_no_results'] = $this->language->get('text_no_results');
		$this->mdata['text_confirm'] = $this->language->get('text_confirm');

		$this->mdata['column_subject'] = $this->language->get('column_subject');
		$this->mdata['column_to'] = $this->language->get('column_to');
		$this->mdata['column_date_added'] = $this->language->get('column_date_added');

		$this->mdata['column_action'] = $this->language->get('column_action');

		$this->mdata['url_delete'] = $this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}

		// SUBMIT
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if ( isset($this->request->post['selected']) ) {
				foreach ($this->request->post['selected'] as $draft_id) {
					$this->model_pavnewsletter_draft->deleteDraft($draft_id);
				}
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		// PROCESS
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'subject';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$draft_total = $this->model_pavnewsletter_draft->getTotalDraft();

		$results = $this->model_pavnewsletter_draft->getDrafts($filter_data);

		foreach ($results as $result) {
			$this->mdata['drafts'][] = array(
				'draft_id'   => $result['draft_id'],
				'subject'    => $result['subject'],
				'to'         => $this->language->get("text_".$result['to']),
				'date_added' => $result['date_added'],
				'edit'       => $this->url->link('extension/module/pavnewsletter/contact', 'token=' . $this->session->data['token'] . '&draft_id=' . $result['draft_id'] . $url, 'SSL'),
				'delete'     => $this->url->link('extension/module/pavnewsletter/draft_contact/delete', 'token=' . $this->session->data['token'] . '&draft_id=' . $result['draft_id'] . $url, 'SSL')
			);
		}

		if (isset($this->request->post['selected'])) {
			$this->mdata['selected'] = (array)$this->request->post['selected'];
		} else {
			$this->mdata['selected'] = array();
		}

		// ORDER
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->mdata['sort_subject'] = $this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'] . '&sort=subject' . $url, 'SSL');
		$this->mdata['sort_to'] = $this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'] . '&sort=to' . $url, 'SSL');

		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		// PAGINAtiON 
		$pagination = new Pagination();
		$pagination->total = $draft_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$this->mdata['pagination'] = $pagination->render();

		$this->mdata['results'] = sprintf($this->language->get('text_pagination'), ($draft_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($draft_total - $this->config->get('config_limit_admin'))) ? $draft_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $draft_total, ceil($draft_total / $this->config->get('config_limit_admin')));

		$this->mdata['sort'] = $sort;
		$this->mdata['order'] = $order;

		$this->mdata['add'] = $this->url->link('extension/module/pavnewsletter/contact', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->mdata['repair'] = $this->url->link('extension/module/pavnewsletter/draft_contact', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// LOAD TEMPLATE
		$template = 'extension/module/pavnewsletter/draft_contact.tpl';
		$this->_render($template);
	}

	public function contact(){
		$this->load->language('extension/module/pavnewsletter');
		$this->mdata['objlang'] = $this->language;

		// LOAD INIT DATA
		$this->initData();
		$this->setBreadcrumb();
		$this->mdata["menu_active"] = "contact";

		// LOAD MODEL
		$this->load->model('pavnewsletter/draft');
		$this->load->model('setting/store');
		$this->load->model('customer/customer_group');

		// LANGUAGE
		$this->mdata['text_default']         = $this->language->get('text_default');
		$this->mdata['text_loading']         = $this->language->get('text_loading');

		$this->mdata['entry_store']          = $this->language->get('entry_store');
		$this->mdata['entry_to']             = $this->language->get('entry_to');
		$this->mdata['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->mdata['entry_customer']       = $this->language->get('entry_customer');
		$this->mdata['entry_affiliate']      = $this->language->get('entry_affiliate');
		$this->mdata['entry_product']        = $this->language->get('entry_product');
		$this->mdata['entry_subject']        = $this->language->get('entry_subject');
		$this->mdata['entry_message']        = $this->language->get('entry_message');

		$this->mdata['help_customer']        = $this->language->get('help_customer');
		$this->mdata['help_affiliate']       = $this->language->get('help_affiliate');
		$this->mdata['help_product']         = $this->language->get('help_product');

		$this->mdata['button_send']          = $this->language->get('button_send');
		$this->mdata['button_check']         = $this->language->get('button_check');
		$this->mdata['button_draft']         = $this->language->get('button_draft');

		$this->mdata['token'] = $this->session->data['token'];

		$this->mdata['url_draft'] = $this->url->link('extension/module/pavnewsletter/ajaxdraft', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['url_send'] = $this->url->link('extension/module/pavnewsletter/ajaxsend', 'token=' . $this->session->data['token'], 'SSL');

		// DATA
		$tos = array(
				'list_subscribes',
				'newsletter',
				'customer_all',
				'customer',
				'customer_group',
				'affiliate_all',
				'affiliate',
				'product',
			);
		$this->mdata['tos'] = $tos;
		$this->mdata['stores'] = $this->model_setting_store->getStores();
		$this->mdata['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->get['draft_id'])) {
			$draft_info = $this->model_pavnewsletter_draft->getDraft($this->request->get['draft_id']);
			$this->mdata['draft_id']          = $this->request->get['draft_id'];
			$this->mdata['store_id']          = $draft_info['store_id'];
			$this->mdata['to']                = $draft_info['to'];
			$this->mdata['subject']           = $draft_info['subject'];
			$this->mdata['message']           = $draft_info['message'];
			$this->mdata['customer_group_id'] = $draft_info['customer_group_id'];
			// get list customers
			$this->mdata['customers'] = array();
			if($draft_info['to'] == 'customer') {
				$customers = unserialize($draft_info['customer']);
				$this->load->model('customer/customer');
				foreach ($customers as $customer_id) {
					$customer = $this->model_customer_customer->getCustomer($customer_id);
					$this->mdata['customers'][] = array(
							'customer_id'       => $customer['customer_id'],
							'name'              => strip_tags(html_entity_decode($customer['firstname'].' '.$customer['lastname'], ENT_QUOTES, 'UTF-8')),
						);
				}
			}
			// get list products
			$this->mdata['products'] = array();
			if($draft_info['to'] == 'product') {
				$products = unserialize($draft_info['product']);
				$this->load->model('catalog/product');
				foreach ($products as $product_id) {
					$product = $this->model_catalog_product->getProduct($product_id);
					$this->mdata['products'][] = array(
							'product_id'       => $product['product_id'],
							'name'             => strip_tags(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')),
						);
				}
			}
			// get list affilates
			$this->mdata['affiliates'] = array();
			if($draft_info['to'] == 'affiliate') {
				$affiliates = unserialize($draft_info['affiliate']);
				$this->load->model('marketing/affiliate');
				foreach ($affiliates as $affiliate_id) {
					$affiliate = $this->model_marketing_affiliate->getAffiliate($affiliate_id);


					$this->mdata['affiliates'][] = array(
							'affiliate_id'       => $affiliate['affiliate_id'],
							'name'               => strip_tags(html_entity_decode($affiliate['firstname'].' '.$affiliate['lastname'], ENT_QUOTES, 'UTF-8')),
						);
				}
			}
			$this->mdata['date_added']        = $draft_info['date_added'];
		} else {
			$this->mdata['draft_id']          = 0;
			$this->mdata['to']                = 'list_subscribes';
			$this->mdata['subject']           = '';
			$this->mdata['message']           = '';
			$this->mdata['customer_group_id'] = 1;
			$this->mdata['customers']         = array();
			$this->mdata['affiliates']        = array();
			$this->mdata['products']          = array();
		}

		// LOAD TEMPLATE
		$template = 'extension/module/pavnewsletter/contact.tpl';
		$this->_render($template);
	}

	// AJAX Draft
	public function ajaxdraft(){

		$this->load->language('extension/module/pavnewsletter');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'extension/module/pavnewsletter')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}

			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}

			if (!$json) {

				// SAVE DATA
				$this->load->model('pavnewsletter/draft');

				$this->model_pavnewsletter_draft->savebasic($this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function ajaxsend() {
		$this->load->language('extension/module/pavnewsletter');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'extension/module/pavnewsletter')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}

			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}

			if (!$json) {

				// LOAD MODEL 
				$this->load->model('setting/store');
				$this->load->model('customer/customer');
				$this->load->model('customer/customer_group');
				$this->load->model('marketing/affiliate');
				$this->load->model('sale/order');

				$this->load->model('pavnewsletter/draft');

				// STORE
				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);
				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}
				// PAGE 
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
				
				$email_total = 0;
				$emails = array();

				switch ($this->request->post['to']) {
					case 'list_subscribes':
						$email_total = $this->model_pavnewsletter_draft->getTotalEmail();
						$results = $this->model_pavnewsletter_draft->getEmails();
					
						foreach ($results as $result) {
							$emails[] = $result['email'];
						}
						break;
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter' => 1,
							'start'             => ($page - 1) * 10,
							'limit'             => 10
						);
						$email_total = $this->model_customer_customer->getTotalCustomers($customer_data);
						$results = $this->model_customer_customer->getCustomers($customer_data);
						foreach ($results as $result) {
							$emails[] = $result['email'];
						}
						break;
					case 'customer_all':
						$customer_data = array(
							'start' => ($page - 1) * 10,
							'limit' => 10
						);

						$email_total = $this->model_customer_customer->getTotalCustomers($customer_data);

						$results = $this->model_customer_customer->getCustomers($customer_data);

						foreach ($results as $result) {
							$emails[] = $result['email'];
						}
						break;
					case 'customer_group':
						$customer_data = array(
							'filter_customer_group_id' => $this->request->post['customer_group_id'],
							'start'                    => ($page - 1) * 10,
							'limit'                    => 10
						);

						$email_total = $this->model_customer_customer->getTotalCustomers($customer_data);

						$results = $this->model_customer_customer->getCustomers($customer_data);

						foreach ($results as $result) {
							$emails[$result['customer_id']] = $result['email'];
						}
						break;
					case 'customer':
						if (!empty($this->request->post['customer'])) {
							foreach ($this->request->post['customer'] as $customer_id) {
								$customer_info = $this->model_customer_customer->getCustomer($customer_id);

								if ($customer_info) {
									$emails[] = $customer_info['email'];
								}
							}
						}
						break;
					case 'affiliate_all':
						$affiliate_data = array(
							'start' => ($page - 1) * 10,
							'limit' => 10
						);

						$email_total = $this->model_marketing_affiliate->getTotalAffiliates($affiliate_data);

						$results = $this->model_marketing_affiliate->getAffiliates($affiliate_data);

						foreach ($results as $result) {
							$emails[] = $result['email'];
						}
						break;
					case 'affiliate':
						if (!empty($this->request->post['affiliate'])) {
							foreach ($this->request->post['affiliate'] as $affiliate_id) {
								$affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

								if ($affiliate_info) {
									$emails[] = $affiliate_info['email'];
								}
							}
						}
						break;
					case 'product':
						if (isset($this->request->post['product'])) {
							$email_total = $this->model_sale_order->getTotalEmailsByProductsOrdered($this->request->post['product']);

							$results = $this->model_sale_order->getEmailsByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);

							foreach ($results as $result) {
								$emails[] = $result['email'];
							}
						}
						break;
				}

				if ($emails) {
					$start = ($page - 1) * 10;
					$end = $start + 10;

					if ($end < $email_total) {
						$json['success'] = sprintf($this->language->get('text_sent'), $start, $email_total);
					} else {
						$json['success'] = $this->language->get('text_success');
					}

					if ($end < $email_total) {
						$json['next'] = str_replace('&amp;', '&', $this->url->link('pavnewsletter/contact/send', 'token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
					} else {
						$json['next'] = '';
					}

					$message  = '<html dir="ltr" lang="en">' . "\n";
					$message .= '  <head>' . "\n";
					$message .= '    <title>' . $this->request->post['subject'] . '</title>' . "\n";
					$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
					$message .= '  </head>' . "\n";
					$message .= '  <body>' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
					$message .= '</html>' . "\n";

					foreach ($emails as $email) {
						if (preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
							$mail = new Mail();
							$mail->protocol = $this->config->get('config_mail_protocol');
							$mail->parameter = $this->config->get('config_mail_parameter');
							$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
							$mail->smtp_username = $this->config->get('config_mail_smtp_username');
							$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
							$mail->smtp_port = $this->config->get('config_mail_smtp_port');
							$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

							$mail->setTo($email);
							$mail->setFrom($this->config->get('config_email'));
							$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
							$mail->setSubject(html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8'));
							$mail->setHtml($message);
							$mail->send();
						}
					}
				} // END IF


			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	// basic send mail end edit 
	
	public function create_newsletter(){
		$this->load->model('pavnewsletter/newsletter');
		$this->load->model('pavnewsletter/draft');

		if( isset($this->request->get['id']) ){
			$this->request->post = $this->model_pavnewsletter_draft->detail($this->request->get['id']);
		}
		if (isset($this->request->get['id']) && $this->request->server['REQUEST_METHOD'] != 'POST'  && $this->validateSend()) {
			
			$this->request->post = $this->model_pavnewsletter_draft->detail($this->request->get['id']);

			if (!$this->request->post) {
				$this->response->redirect($this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
	
		$this->initData();
		$this->setBreadcrumb();
		$this->load->model("pavnewsletter/template");
		$this->load->model("pavnewsletter/newsletter");
		$this->mdata["menu_active"] = "create_newsletter";
		$this->mdata['cancel'] = $this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata["templates"] = $this->model_pavnewsletter_template->getTemplates();

		$this->load->language('sale/contact');
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->mdata['languages'] = $languages;
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['button_attach'] = $this->language->get('button_attach');
		$this->mdata['button_upload'] = $this->language->get('button_upload');
		$this->mdata['button_preview'] = $this->language->get('button_preview');
		$this->mdata['button_save_draft'] = $this->language->get('button_save_draft');
		$this->mdata['button_send'] = $this->language->get('button_send');
		$this->mdata['button_spam'] = $this->language->get('button_spam');
		$this->mdata['entry_template'] = $this->language->get('entry_template');
		$this->mdata['entry_yes'] = $this->language->get('entry_yes');
		$this->mdata['entry_no'] = $this->language->get('entry_no');
		$this->mdata['entry_defined'] = $this->language->get('entry_defined');
		$this->mdata['entry_latest'] = $this->language->get('entry_latest');
		$this->mdata['entry_popular'] = $this->language->get('entry_popular');
		$this->mdata['entry_special'] = $this->language->get('entry_special');
		$this->mdata['entry_product'] = $this->language->get('entry_product');
		$this->mdata['entry_attachments'] = $this->language->get('entry_attachments');
		$this->mdata['entry_store'] = $this->language->get('entry_store');
		$this->mdata['entry_language'] = $this->language->get('entry_language');
		$this->mdata['entry_to'] = $this->language->get('entry_to');
		$this->mdata['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->mdata['entry_customer'] = $this->language->get('entry_customer');
		$this->mdata['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->mdata['entry_product'] = $this->language->get('entry_product');
		$this->mdata['entry_subject'] = $this->language->get('entry_subject');
		$this->mdata['entry_message'] = $this->language->get('entry_message');
		$this->mdata['entry_marketing'] = $this->language->get('entry_marketing');
		$this->mdata['entry_defined_categories'] = $this->language->get('entry_defined_categories');
		$this->mdata['entry_section_name'] = $this->language->get('entry_section_name');
		$this->mdata['entry_currency'] = $this->language->get('entry_currency');

		$this->mdata['button_add_file'] = $this->language->get('button_add_file');
		$this->mdata['button_add_defined_section'] = $this->language->get('button_add_defined_section');
		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		$this->mdata['button_send'] = $this->language->get('button_send');
		$this->mdata['button_reset'] = $this->language->get('button_reset');
		$this->mdata['button_back'] = $this->language->get('button_back');
		$this->mdata['button_update'] = $this->language->get('button_update');
		$this->mdata['button_preview'] = $this->language->get('button_preview');
		$this->mdata['button_check'] = $this->language->get('button_check');

		$this->mdata['text_marketing'] = $this->language->get('text_marketing');
		$this->mdata['text_marketing_all'] = $this->language->get('text_marketing_all');
		$this->mdata['text_subscriber_all'] = $this->language->get('text_subscriber_all');
		$this->mdata['text_all'] = $this->language->get('text_all');
		$this->mdata['text_clear_warning'] = $this->language->get('text_clear_warning');
		$this->mdata['text_message_info'] = $this->language->get('text_message_info');
		$this->mdata['text_default'] = $this->language->get('text_default');
		$this->mdata['text_newsletter'] = $this->language->get('text_newsletter');
		$this->mdata['text_customer_all'] = $this->language->get('text_customer_all');
		$this->mdata['text_customer'] = $this->language->get('text_customer');
		$this->mdata['text_customer_group'] = $this->language->get('text_customer_group');
		$this->mdata['text_affiliate_all'] = $this->language->get('text_affiliate_all');
		$this->mdata['text_affiliate'] = $this->language->get('text_affiliate');
		$this->mdata['text_product'] = $this->language->get('text_product');
		$this->mdata['text_loading'] = $this->language->get('text_loading');
		$this->mdata['text_only_subscribers'] = $this->language->get('text_only_subscribers');
		$this->mdata['text_only_selected_language'] = $this->language->get('text_only_selected_language');
		$this->mdata['text_rewards'] = $this->language->get('text_rewards');
		$this->mdata['text_rewards_all'] = $this->language->get('text_rewards_all');

		$this->load->model('catalog/product');

		$this->mdata['defined_products'] = array();

		if (isset($this->request->post['defined_product']) && is_array($this->request->post['defined_product'])) {
			foreach ($this->request->post['defined_product'] as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					$this->mdata['defined_products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
			unset($product_info);
			unset($product_id);
		}
		$this->mdata['defined_products_more'] = array();

		if (isset($this->request->post['defined_product_more']) && is_array($this->request->post['defined_product_more'])) {
			foreach ($this->request->post['defined_product_more'] as $dpm) {
				if (!isset($dpm['products'])) {
					$dpm['products'] = array();
				}
				if (!isset($dpm['text'])) {
					$dpm['text'] = '';
				}
				$defined_products_more = array('text' => $dpm['text'], 'products' => array());
				foreach ($dpm['products'] as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						$defined_products_more['products'][] = array(
							'product_id' => $product_info['product_id'],
							'name'       => $product_info['name']
						);
					}
				}
				$this->mdata['defined_products_more'][] = $defined_products_more;
			}
			unset($defined_products_more);
			unset($product_info);
			unset($product_id);
		}

		$this->load->model('catalog/category');

		$this->mdata['categories'] = $this->model_catalog_category->getCategories(0);

		if (isset($this->request->get['id']) || isset($this->request->post['id'])) {
			$this->mdata['id'] = (isset($this->request->get['id']) ?$this->request->get['id'] : $this->request->post['id']);
		} else {
			$this->mdata['id'] = false;
		}

		if (isset($this->request->post['defined'])) {
			$this->mdata['defined'] = $this->request->post['defined'];
		} else {
			$this->mdata['defined'] = false;
		}

		if (isset($this->request->post['defined_categories'])) {
			$this->mdata['defined_categories'] = $this->request->post['defined_categories'];
		} else {
			$this->mdata['defined_categories'] = false;
		}

		if (isset($this->request->post['defined_category'])) {
			$this->mdata['defined_category'] = $this->request->post['defined_category'];
		} else {
			$this->mdata['defined_category'] = array();
		}

		if (isset($this->request->post['special'])) {
			$this->mdata['special'] = $this->request->post['special'];
		} else {
			$this->mdata['special'] = false;
		}

		if (isset($this->request->post['latest'])) {
			$this->mdata['latest'] = $this->request->post['latest'];
		} else {
			$this->mdata['latest'] = false;
		}

		if (isset($this->request->post['popular'])) {
			$this->mdata['popular'] = $this->request->post['popular'];
		} else {
			$this->mdata['popular'] = false;
		}

		if (isset($this->request->post['attachments'])) {
			$this->mdata['attachments'] = $this->request->post['attachments'];
		} else {
			$this->mdata['attachments'] = false;
		}

		$this->load->model('customer/customer_group');

		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}


		if (isset($this->error['subject'])) {
			$this->mdata['error_subject'] = $this->error['subject'];
		} else {
			$this->mdata['error_subject'] = array();
		}

		if (isset($this->error['message'])) {
			$this->mdata['error_message'] = $this->error['message'];
		} else {
			$this->mdata['error_message'] = array();
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSend()) { 
			$action = isset($this->request->post['action'])?$this->request->post['action']:"";
			set_time_limit(0);

			$emails = array();

			$this->load->model('localisation/language');
			$language = $this->model_localisation_language->getLanguage((isset($this->request->post['language_id']) ? $this->request->post['language_id'] : $this->config->get('config_language_id')));
			
			if($action == 'save_draft'){
				$this->save_draft();
			}
			elseif ($action =='check_spam') {
				$emails['check@isnotspam.com'] = array(
					'firstname' => 'John',
					'lastname' => 'Doe'
				);
			} else {
				switch ($this->request->post['to']) {
					case 'subscriber':
						$customer_data = array(
							'filter_newsletter' => 1
						);

						$results = $this->model_pavnewsletter_newsletter->getCustomers($customer_data);

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							if ($result['store_id'] == $this->request->post['store_id']) {
								$emails[$result['email']] = array(
									'firstname' => $result['firstname'],
									'lastname' => $result['lastname']
								);
							}
						}
						break;
					case 'all':

						$results = $this->model_pavnewsletter_newsletter->getCustomers();

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							if ($result['store_id'] == $this->request->post['store_id']) {
								$emails[$result['email']] = array(
									'firstname' => $result['firstname'],
									'lastname' => $result['lastname']
								);
							}
						}
						break;
					case 'newsletter':
							$this->load->model('pavnewsletter/subscribe');
							$customer_data = array(
								'filter_action' => 1
							);

							$results = $this->model_pavnewsletter_subscribe->getSubscribers($customer_data); 

							foreach ($results as $result) {
								// if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								// 	continue;
								// }
								if ($result['store_id'] == $this->request->post['store_id']) {
									$emails[$result['email']] = array(
										'firstname' => 'Mr/Ms',
										'lastname' => 'Guest'
									);
								}
							}
						break;
					case 'customer_all':
						$results = $this->model_pavnewsletter_newsletter->getCustomers();
						
						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							if (empty($result['store_id']) || ($result['store_id'] == $this->request->post['store_id'] )) {
								$emails[$result['email']] = array(
									'firstname' => $result['firstname'],
									'lastname' => $result['lastname']
								);
							}
						}
						break;
					case 'customer_group':
						$customer_data = array(
							'filter_customer_group_id' => $this->request->post['customer_group_id']
						);

						if (isset($this->request->post['customer_group_only_subscribers'])) {
							$customer_data['filter_newsletter'] = 1;
						}

						$results = $this->model_pavnewsletter_newsletter->getCustomers($customer_data);

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							if ($result['store_id'] == $this->request->post['store_id']) {
								$emails[$result['email']] = array(
									'firstname' => $result['firstname'],
									'lastname' => $result['lastname']
								);
							}
						}
						break;
					case 'customer':
						if (isset($this->request->post['customer']) && !empty($this->request->post['customer'])) {
							foreach ($this->request->post['customer'] as $customer_id) {
								$customer_info = $this->model_pavnewsletter_newsletter->getCustomer($customer_id);

								if ($customer_info) {
									/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
										continue;
									}*/
									$emails[$customer_info['email']] = array(
										'firstname' => $customer_info['firstname'],
										'lastname' => $customer_info['lastname']
									);
								}
							}
						}
						break;
					case 'affiliate_all':
						$results = $this->model_pavnewsletter_newsletter->getAffiliates();

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							$emails[$result['email']] = array(
								'firstname' => $result['firstname'],
								'lastname' => $result['lastname']
							);
						}
						break;
					case 'affiliate':
						if (isset($this->request->post['affiliate']) && !empty($this->request->post['affiliate'])) {
							foreach ($this->request->post['affiliate'] as $affiliate_id) {
								$affiliate_info = $this->model_pavnewsletter_newsletter->getAffiliate($affiliate_id);

								if ($affiliate_info) {
									/*if (isset($this->request->post['only_selected_language']) && (($language['code'] != $affiliate_info['language_code'] && $affiliate_info['language_code']) || (!$affiliate_info['language_code'] && $language['language_id'] != $this->config->get('config_language_id')))) {
										continue;
									}*/
									$emails[$affiliate_info['email']] = array(
										'firstname' => $affiliate_info['firstname'],
										'lastname' => $affiliate_info['lastname']
									);
								}
							}
						}
						break;
					case 'product':
						if (isset($this->request->post['product']) && $this->request->post['product']) {
							$results = $this->model_pavnewsletter_newsletter->getEmailsByProductsOrdered($this->request->post['product']);

							foreach ($results as $result) {
								/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
									continue;
								}*/
								if ($result['store_id'] == $this->request->post['store_id']) {
									$emails[$result['email']] = array(
										'firstname' => $result['firstname'],
										'lastname' => $result['lastname']
									);
								}
							}
						}
						break;
					case 'rewards_all':
						$results = $this->model_pavnewsletter_newsletter->getRecipientsWithRewardPoints();

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							$emails[$result['email']] = array(
								'firstname' => $result['firstname'],
								'lastname' => $result['lastname'],
								'reward' => $result['points'],
							);
						}
						break;
					case 'rewards':
						$results = $this->model_pavnewsletter_newsletter->getSubscribedRecipientsWithRewardPoints();

						foreach ($results as $result) {
							/*if (isset($this->request->post['only_selected_language']) && $this->request->post['only_selected_language'] ) {
								continue;
							}*/
							$emails[$result['email']] = array(
								'firstname' => $result['firstname'],
								'lastname' => $result['lastname'],
								'reward' => $result['points'],
							);
						}
						break;
				}
			}

			if ($emails) {
				$default = array(
					'attachments_count'	=> 0,
					'defined'			=> 0,
					'defined_product'	=> 0

				);
				$this->request->post = array_merge($default, $this->request->post);
				$data = array(
					'emails' => $emails,
					'to' => $this->request->post['to'],
					'subject' => $this->request->post['subject'],
					'message' => $this->request->post['message'],
					'store_id' => $this->request->post['store_id'],
					'template_id' => $this->request->post['template_id'],
					'language_id' => $language['language_id'],
					'attachments_count' => $this->request->post['attachments_count'],
					'attachments_upload' => $this->request->files,
					'attachments' => false,
					'language_code' => $language['code']
				);
				
				$data_products = array();
				//get list products
				$this->load->model('pavnewsletter/product');
				$setting = array(
					'currency' => $this->request->post['currency'],
					'width' => 80,
					'height' => 80,
					'limit' => 5,
				);
			
				
				if($this->request->post['defined'] && isset($this->request->post['defined_product']) ) {
					$defined_product = $this->request->post['defined_product'];
					$selectedProducts = array();
					$products = $this->model_pavnewsletter_product->getProducts();
					foreach($products as $product) {
						if(in_array($product['product_id'],$defined_product)) {
							$selectedProducts[] = $product;
						}
					}
					$test = $this->getItemProducts($selectedProducts, $setting);
					$data_products['selected'] = $this->getItemProducts($selectedProducts, $setting);
				}
			
				if($this->request->post['special']) {
					$specialProducts = $this->model_pavnewsletter_product->getProductSpecials($setting['limit']);
					$data_products['special'] = $this->getItemProducts($specialProducts, $setting);
				}
				
				if($this->request->post['latest']) {
					$latestProducts = $this->model_pavnewsletter_product->getLatestProducts($setting['limit']);
					$data_products['latest'] = $this->getItemProducts($latestProducts, $setting);
				}
				
				if($this->request->post['popular']) {
					$popularProducts = $this->model_pavnewsletter_product->getPopularProducts($setting['limit']);
					$data_products['popular'] = $this->getItemProducts($popularProducts, $setting);
				}
				
				if( isset($this->request->post['defined_categories']) && isset($this->request->post['defined_category']) ) {
					


					$defined_category = $this->request->post['defined_category'];
					$categoriesProducts = array();
					$products = $this->model_pavnewsletter_product->getProducts();
					foreach($products as $product) {
						if(in_array($product['product_id'],$defined_category)) {
							$categoriesProducts[] = $product;
						}
					}
					$data_products['category'] = $this->getItemProducts($categoriesProducts, $setting);
				}
				$data['lstproduct'] = $data_products;
				$this->model_pavnewsletter_newsletter->send($data);
			} else {
				$this->error['warning'] = $this->language->get("text_error_empty_email");
			}
		}
		
		
		
		$this->mdata['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}

 		if (isset($this->error['subject'])) {
			$this->mdata['error_subject'] = $this->error['subject'];
		} else {
			$this->mdata['error_subject'] = '';
		}

		if (isset($this->error['message'])) {
			$this->mdata['error_message'] = $this->error['message'];
		} else {
			$this->mdata['error_message'] = '';
		}

  		$this->mdata['breadcrumbs'] = array();

   		$this->mdata['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->mdata['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}

		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/create_newsletter', 'token=' . $this->session->data['token'], 'SSL');

    	$this->mdata['save'] = $this->url->link('extension/module/pavnewsletter/save_draft', 'token=' . $this->session->data['token'], 'SSL');

    	if (isset($this->request->post['template_id'])) {
			$this->mdata['template_id'] = $this->request->post['template_id'];
		} else {
			$this->mdata['template_id'] = '';
		}

		$this->load->model('pavnewsletter/template');
		$this->mdata['templates'] = $this->model_pavnewsletter_template->getTemplates();

		if (isset($this->request->post['store_id'])) {
			$this->mdata['store_id'] = $this->request->post['store_id'];
		} else {
			$this->mdata['store_id'] = '';
		}

		$this->load->model('setting/store');

		$this->mdata['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['language_id'])) {
			$this->mdata['language_id'] = $this->request->post['language_id'];
		} else {
			$this->mdata['language_id'] = '';
		}

		$this->load->model('localisation/language');

		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['currency'])) {
			$this->mdata['currency'] = $this->request->post['currency'];
		} else {
			$this->mdata['currency'] = '';
		}

		$this->load->model('localisation/currency');

		$this->mdata['currencies'] = $this->model_localisation_currency->getCurrencies();

		if (isset($this->request->post['to'])) {
			$this->mdata['to'] = $this->request->post['to'];
		} else {
			$this->mdata['to'] = '';
		}

		if (isset($this->request->post['customer_group_id'])) {
			$this->mdata['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$this->mdata['customer_group_id'] = '';
		}

		if (isset($this->request->post['customer_group_only_subscribers'])) {
			$this->mdata['customer_group_only_subscribers'] = $this->request->post['customer_group_only_subscribers'];
		} else {
			$this->mdata['customer_group_only_subscribers'] = '';
		}

		if (isset($this->request->post['only_selected_language'])) {
			$this->mdata['only_selected_language'] = $this->request->post['only_selected_language'];
		} else {
			$this->mdata['only_selected_language'] = 1;
		}

		$this->load->model('customer/customer_group');

		$this->mdata['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		$this->mdata['customers'] = array();

		if (isset($this->request->post['customer']) && is_array($this->request->post['customer'])) {
			foreach ($this->request->post['customer'] as $customer_id) {
				$customer_info = $this->model_pavnewsletter_newsletter->getCustomer($customer_id);

				if ($customer_info) {
					$this->mdata['customers'][] = array(
						'customer_id' => $customer_info['customer_id'],
						'name'        => $customer_info['firstname'] . ' ' . $customer_info['lastname']
					);
				}
			}
		}

    $this->mdata['affiliates'] = array();

      if (isset($this->request->post['affiliate']) && is_array($this->request->post['affiliate'])) {
          foreach ($this->request->post['affiliate'] as $affiliate_id) {
              $affiliate_info = $this->model_pavnewsletter_newsletter->getAffiliate($affiliate_id);

              if ($affiliate_info) {
                  $this->mdata['affiliates'][] = array(
                      'affiliate_id' => $affiliate_info['affiliate_id'],
                      'name'         => $affiliate_info['firstname'] . ' ' . $affiliate_info['lastname']
                  );
              }
          }
      }
		$this->load->model('catalog/product');

		$this->mdata['products'] = array();

		if (isset($this->request->post['product']) && is_array($this->request->post['product'])) {
			foreach ($this->request->post['product'] as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					$this->mdata['products'][] = array(
						'product_id' => $product_info['product_id'],
						'name'       => $product_info['name']
					);
				}
			}
		}

		if (isset($this->request->post['subject'])) {
			$this->mdata['subject'] = $this->request->post['subject'];
		} else {
			$this->mdata['subject'] = '';
		}

		if (isset($this->request->post['message'])) {
			$this->mdata['message'] = $this->request->post['message'];
		} else {
			$this->mdata['message'] = '';
		}

		$template = 'extension/module/pavnewsletter/form_newsletter.tpl';
		$this->_render($template);
	}

	public function _render($template){
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($template, $this->mdata));
	}
	public function templates(){
		$this->initData();
		$this->setBreadcrumb();
		$this->load->model("pavnewsletter/template");
		$this->mdata["menu_active"] = "templates";
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$action = isset($this->request->post['action'])?$this->request->post['action']:"";
			switch ($action) {
				case 'copy_default':

					break;
				case 'copy':
					$templates = isset($this->request->post["templates"])?$this->request->post["templates"]:array();
					$check = false;
					if(!empty($templates)){
						$check = $this->model_pavnewsletter_template->copy($templates);
					}
					if($check){
						$this->mdata["success"] = $this->language->get("text_success_copy_template");
					}else{
						$this->mdata["error_warning"] = $this->language->get("text_error_cannot_copy_template");
					}
					break;
				case 'insert':
					return $this->template();
					break;
				case 'delete':
					$templates = isset($this->request->post["templates"])?$this->request->post["templates"]:array();
					$check = false;
					if(!empty($templates)){
						$check = $this->model_pavnewsletter_template->delete($templates);
					}
					if($check){
						$this->mdata["success"] = $this->language->get("text_delete_template");
					}else{
						$this->mdata["error_warning"] = $this->language->get("text_error_delete_template");
					}
					break;
				default:

					break;
			}
		}
		$templates = $this->model_pavnewsletter_template->getTemplates();
		$this->mdata["templates"] = $templates;
		$this->mdata["pagination"] = "";
		$this->mdata['token'] = $this->session->data['token'];
		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}
		$this->mdata['insert_link'] = $this->url->link('extension/module/pavnewsletter/template', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL');
		
		$template = 'extension/module/pavnewsletter/templates.tpl';
		$this->_render($template);
	}
	public function upload() {
		$this->load->language('sale/order');

		$json = array();

		if (!$this->user->hasPermission('modify', 'extension/module/pavnewsletter')) {
      		$json['error'] = $this->language->get('error_permission');
    	}

		if (!isset($json['error'])) {
			if (!empty($this->request->files['file']['name'])) {
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					$json['error'] = $this->language->get('error_filename');
				}

				// Allowed file extension types
				$allowed = array();

				$filetypes = explode("\n", $this->config->get('config_file_extension_allowed'));

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array();

				$filetypes = explode("\n", $this->config->get('config_file_mime_allowed'));

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = md5(mt_rand());

				$json['filename'] = $filename . '.' . $ext;
				$json['mask'] = $filename;

				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD .'pavnewsletter/'. $filename . '.' . $ext);
			}

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->setOutput(json_encode($json));
	}
	public function template_from_file(){
		$template = isset($this->request->post["template"])?$this->request->post["template"]:array();
		$template_file = isset($template["template_file"])?$template["template_file"]:"";
		$json = array();
		if(!empty($template_file)){
			$file_path = DIR_DOWNLOAD."pavnewsletter/".$template_file;
			$json["template"] = file_get_contents($file_path);
		}

		$this->response->setOutput(json_encode($json));
	}
	public function template(){
		$this->initData();
		$this->setBreadcrumb();
		$this->load->model("pavnewsletter/template");
		$this->mdata["menu_active"] = "templates";
		$this->mdata['cancel'] = $this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL');
		$template_id = isset($this->request->get['id'])?$this->request->get['id']:0;
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$action = isset($this->request->post["action"])?$this->request->post["action"]:"";
			if($action == "get_template"){

			}else{
				$check = $this->model_pavnewsletter_template->insertTemplate($this->request->post);
				if($check)
				 	$this->session->data['success'] = $this->language->get('text_pavnewsletter_success');
				else
					$this->session->data['error_warning'] = $this->language->get('text_pavnewsletter_error_warning');

				$this->response->redirect($this->url->link('extension/module/pavnewsletter/templates', 'token=' . $this->session->data['token'], 'SSL'));
			}

		}
		$template = $this->model_pavnewsletter_template->getTemplate($template_id);
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->mdata['languages'] = $languages;
		$this->mdata['template_id'] = $template_id;
		$this->mdata["template"] = $template;
		$this->mdata["template_description"] = isset($template["template_description"])?$template["template_description"]:array();
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['button_upload'] = $this->language->get('button_upload');
		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}
		if (isset($this->error['filename'])) {
			$this->mdata['error_filename'] = $this->error['filename'];
		} else {
			$this->mdata['error_filename'] = '';
		}

		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/template', 'token=' . $this->session->data['token'], 'SSL');
		

		$template = 'extension/module/pavnewsletter/form_template.tpl';
		$this->_render($template);
	}
	public function modules(){
		$this->initData();

		$model = $this->model_pavnewsletter_newsletter;
		$module_info = array();
		$model->installModule();

		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->load->model("extension/module");

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('pavnewsletter', $this->request->post);
				$this->response->redirect( $this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'], 'SSL') );
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
				$this->response->redirect( $this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], 'SSL') );
			}
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->mdata['extensions'] = $this->module("pavnewsletter", "&module_id");

		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}
		$this->setBreadcrumb();
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata["menu_active"] = "modules";
		


		if (isset($this->request->get['module_id'])) {
			$module_id = $this->request->get['module_id'];
			$url = '&module_id='.$module_id;
		} else {
			$module_id = '';
			$url = '';
		}
		$this->mdata['module_id'] = $module_id;

		$d = array(
			'displaymode' => 'default',
			'name' => '',
			'status'	 => 1, 
			'description' => '',
			'social'	=> ''
		);
		// action
		$this->mdata['delete'] = $this->url->link('extension/module/pavnewsletter/ndelete', 'token=' . $this->session->data['token'].$url, 'SSL');
		$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'].$url, 'SSL');

		// GET DATA SETTING
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		 $module_info = array_merge( $d, $module_info ); 
		// status
		if (isset($this->request->post['status'])) {
			$this->mdata['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$this->mdata['status'] = $module_info['status'];
		} else {
			$this->mdata['status'] = 1;
		}

		// name
		if (isset($this->request->post['name'])) {
			$this->mdata['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$this->mdata['name'] = $module_info['name'];
		} else {
			$this->mdata['name'] = '';
		}

		// description
		if (isset($this->request->post['description'])) {
			$this->mdata['description'] = $this->request->post['description'];
		} elseif (!empty($module_info)) {
			$this->mdata['description'] = $module_info['description'];
		} else {
			$this->mdata['description'] = '';
		}

		$this->mdata['displaymode'] = $module_info['displaymode'];
		// social
		if (isset($this->request->post['social'])) {
			$this->mdata['social'] = $this->request->post['social'];
		} elseif (!empty($module_info)) {
			$this->mdata['social'] = $module_info['social'];
		} else {
			$this->mdata['social'] = '';
		}

		$modes = array(
			'default' => $this->language->get( 'txt_none'), 
			'flybot' => $this->language->get( 'txt_flybot'),
			// 'modalbox' => $this->language->get( 'txt_modalshow'),
		);
		$this->mdata['modes'] = $modes;
		$template = 'extension/module/pavnewsletter/frontend_modules.tpl';
		$this->_render($template);
	}

	// tab module
	public function module($extension, $module_id){
		$module_data = array();
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$extensions = $this->model_extension_extension->getInstalled('module');
		$modules = $this->model_extension_module->getModulesByCode($extension);
		foreach ($modules as $module) {
			$module_data[] = array(
				'module_id' => $module['module_id'],
				'name'      => $module['name'],
				'edit'      => $this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'] . $module_id.'=' . $module['module_id'], 'SSL'),
			);
		}
		$ex[] = array(
			'name'      => $this->language->get("create_module"),
			'module'    => $module_data,
			'edit'      => $this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'], 'SSL')
		);
		return $ex;
	}

	public function ndelete(){
		$this->load->model('extension/module');
		if (isset($this->request->get['module_id'])) {
			$this->model_extension_module->deleteModule($this->request->get['module_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module/pavnewsletter/modules', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function config(){
		$this->initData();
		$this->setBreadcrumb();

		$model = $this->model_pavnewsletter_newsletter;

		$model->installModule();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pavnewsletter_config', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavnewsletter/config', 'token=' . $this->session->data['token'], 'SSL'));
		}

		// Alert
		if (isset($this->session->data['success'])) {
			$this->mdata['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->mdata['success'] = '';
		}

		$this->mdata['token'] = $this->session->data['token'];
    	$this->mdata["menu_active"] = "config";
    	$this->mdata["mail_protocals"] = array("mail"=>"Mail", "smtp"=>"SMTP");
    	$this->mdata['action'] = $this->url->link('extension/module/pavnewsletter/config', 'token=' . $this->session->data['token'], 'SSL');

    	// Get Data Setting
		$this->mdata['general'] = array();
		if (isset($this->request->post['pavnewsletter_config'])) {
			$this->mdata['general'] = $this->request->post['pavnewsletter_config'];
		} elseif ($this->config->get('pavnewsletter_config')) {
			$this->mdata['general'] = $this->config->get('pavnewsletter_config');
		}

		// Render
		$template = 'extension/module/pavnewsletter/config.tpl';
		$this->_render($template);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/pavnewsletter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['pavnewsletter_module'])) {

		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getItemProducts($results = array(), $setting){
	
		global $registry;	
		
		$this->load->model('pavnewsletter/product');		
		$this->load->model('tool/image'); 
		
		require_once( DIR_SYSTEM."/library/currency.php");
		$currency = new Currency($registry);
		$products = array();
		$i = 0;
		foreach ($results as $result) {
			if($i < $setting['limit']) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = false;
				}
				
				$price = $currency->format($result['price'], $setting['currency']);
				
				if (isset($result['special'])) {
					$special = $currency->format((float)$result['special'], $setting['currency']);
				} else {
					$special = false;
				}		
				
				$products[] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'price'       => $price,
					'special'     => $special,
					'href'        => str_replace("/admin/","/",$this->url->link('product/product', 'product_id=' . $result['product_id']))
				);
			}
			$i++;
		}
		return $products;
	}
}
?>
