<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.1
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
/**
 * class ControllerExtensionModulePavblog
 */
class ControllerExtensionModulePavblog extends Controller {


	private $error = array();

	private $module_folder = 'modules';
	private $moduleName = 'pavblog';
	private $list_modules = array();

	private $mdata = array();
	/**
	 * set template layout
	 */
	public function setTemplate( $tpl ){

		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		$this->document->addStyle('view/javascript/summernote/summernote.css');

		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');

		$this->mdata['token'] =  $this->session->data['token'];
		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}

		if (isset($this->error['dimension'])) {
			$this->mdata['error_dimension'] = $this->error['dimension'];
		} else {
			$this->mdata['error_dimension'] = array();
		}

		$this->mdata['manage_category_link'] = $this->url->link('extension/module/pavblog/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['add_category_link'] = $this->url->link('extension/module/pavblog/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['manage_blog_link'] = $this->url->link('extension/module/pavblog/blogs', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['add_blog_link'] = $this->url->link('extension/module/pavblog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['manage_comment_link'] = $this->url->link('extension/module/pavblog/comments', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['modules_setting_link'] = $this->url->link('extension/module/pavblog/modules', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['frontend_modules_link'] = $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['dashboard_link'] = $this->url->link('extension/module/pavblog', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['information'] = $this->url->link('extension/module/pavblog/information', 'token=' . $this->session->data['token'], 'SSL');

		$this->mdata['token'] = $this->session->data['token'];

		$this->document->addStyle('view/stylesheet/pavblog.css');

		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');

		$template = 'extension/module/pavblog/'.$tpl.".tpl";
		$this->response->setOutput($this->load->view($template, $this->mdata));
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
			'href'      => $this->url->link('extension/module/pavblog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	}

	/**
	 * Dardboard Page
	 */
	public function index(){

		$this->mdata['objlang'] = $this->language;
		$this->mdata['objurl'] = $this->url;

		$this->preProcess();
		$this->load->model('pavblog/comment');
		$this->setBreadcrumb();

		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}

		if (isset($this->error['dimension'])) {
			$this->mdata['error_dimension'] = $this->error['dimension'];
		} else {
			$this->mdata['error_dimension'] = array();
		}

		$this->mdata['newest'] = $this->model_pavblog_blog->geNewest();
		$this->mdata['mostread'] = $this->model_pavblog_blog->getMostRead();
		$this->mdata['comments'] = $this->model_pavblog_comment->getNewest();

		$this->mdata['heading_title'] = $this->language->get('panel_page_heading_title');
		$this->mdata['module_setting'] = $this->getModuleSetting();
		$this->document->setTitle( $this->mdata['heading_title'] );
		
		return $this->setTemplate( 'panel' );
	}

	/**
	 * Category Page
	 */
	public function category(){
		$this->setBreadcrumb();
		$this->load->language('extension/module/pavblog');

		$this->document->setTitle( strip_tags( $this->language->get('heading_title') ));
		$this->document->addStyle('view/stylesheet/pavblog.css');

		$this->document->addStyle('view/javascript/jquery/ui/jquery-ui.min.css');
		$this->document->addScript('view/javascript/jquery/ui/jquery-ui.min.js');

		$this->document->addScript('view/javascript/pavblog/jquery.nestable.js');


		$this->load->model('pavblog/menu');
		// check tables created or not
		$this->model_pavblog_menu->install();
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')  && !empty($this->request->post) ) {

			if( (int)$this->request->post['pavblog_category']['category_id'] <= 0 ){
				$this->request->post['pavblog_category']['position'] = '99';
			}
			if(  $this->validateCategory() ) {
				$id = $this->model_pavblog_menu->editData(  $this->request->post );
				$this->session->data['success'] = $this->language->get('text_success');
				if( $this->request->post['save_mode']=='save-edit'){
					$this->response->redirect($this->url->link('extension/module/pavblog/category', 'id='.$id.'&token=' . $this->session->data['token'], 'SSL'));
				}	else {
					$this->response->redirect($this->url->link('extension/module/pavblog/category', 'token=' . $this->session->data['token'], 'SSL'));
				}
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'].'&type=module', 'SSL'));
			}
		}

		$this->mdata['heading_title'] = $this->language->get('category_page_heading_title');

 		if (isset($this->error['warning'])) {
			$this->mdata['error_warning'] = $this->error['warning'];
		} else {
			$this->mdata['error_warning'] = '';
		}

		if (isset($this->error['dimension'])) {
			$this->mdata['error_dimension'] = $this->error['dimension'];
		} else {
			$this->mdata['error_dimension'] = array();
		}

		$this->mdata['action'] = $this->url->link('extension/module/pavblog/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['actionGetTree'] = $this->url->link('extension/module/pavblog/gettree', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['actionDel'] = $this->url->link('extension/module/pavblog/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['actionGetInfo'] = $this->url->link('extension/module/pavblog/info', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['updateTree'] = $this->url->link('extension/module/pavblog/update', 'root=1&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['cancel'] = $this->url->link('extension/module/pavblog', 'token=' . $this->session->data['token'], 'SSL');

		$this->mdata['modules'] = array();


		$this->mdata['tree'] = $this->model_pavblog_menu->getTree(  );

		$this->info();

		return $this->setTemplate( 'category' );
	}

 	/**
 	 * Delete Category Menu By Id
 	 */
	public function delete(){
		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if( isset($this->request->get['id']) ){
			$this->load->model('pavblog/menu');
			$this->model_pavblog_menu->delete( (int)$this->request->get['id'] );

		}
		$this->response->redirect($this->url->link('extension/module/pavblog/category', 'token=' . $this->session->data['token'], 'SSL'));
	}

	/**
	 * Update Category Tree Menu
	 */
	public function update(){
		$json = array();
		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
			die(  $this->error['warning'] );
			$json['error'] = $this->error['warning'];
		}
		$data =  ( ($this->request->post['list']) );
		if( !empty($data) ){
			$root = $this->request->get['root'];
			$this->load->model('pavblog/menu');
			$this->model_pavblog_menu->massUpdate( $data, $root  );
			
			$json['success'] = 'success';
			$this->response->setOutput(json_encode($json));
		}
		$json['error'] = 'Could not update any thing';
	}

	/**
	 * Get Category Menu infomration by Id in request
	 *
	 */
	public function info() {
		$this->mdata['objlang'] = $this->language;
		$this->mdata['objurl'] = $this->url;
		
		$id=0;
		if( isset($this->request->post) && isset($this->request->post['id']) ){
			$id = (int)$this->request->post['id'] ;
		}else if( isset($this->request->get["id"]) ){
			$id = (int)$this->request->get['id'];
		}
		$default = array(
			'category_id'=>'',
			'title' => '',
			'parent_id'=> '',
			'tags' => '',
			'image' => '',
			'is_group'=>'',
			'width'=>'12',
			'menu_class'=>'',
			'submenu_colum_width'=>'',
			'is_group'=>'',
			'submenu_width'=>'12',
			'column_width'=>'200',
			'submenu_column_width'=>'',
			'colums'=>'1',
			'type' => '',
			'item' => '',
			'is_content'=>'',
			'show_title'=>'1',
			'type_submenu'=>'',
			'level_depth'=>'',
			'status'    => '',
			'position'  => '',
			'show_sub' => '',
			'url' => '',
			'targer' => '',
			'level'=> '',
			'content_text'=>'',
			'submenu_content'=>'',
			'blog-information'=>'',
			'blog-product'=>'',
			'blog-category'=>'',
			'published' => 1,
			'blog-manufacturer'=>'',
			'thumb' => '',
			'meta_keyword'=>'',
			'meta_description'=>'',
			'meta_title'=>'',
			'keyword' => ''
		);

		$this->load->language('extension/module/pavblog');
		$this->load->model('pavblog/menu');

		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		$this->mdata['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$this->mdata['entry_image'] = 'Image:';
		$this->mdata['text_image_manager'] = $this->language->get('text_image_manager');
		$this->mdata['text_clear'] = $this->language->get('text_clear');
		$this->mdata['text_browse'] = $this->language->get('text_browse');
		$this->mdata['tab_module'] = $this->language->get('tab_module');
		$this->mdata['text_none'] = $this->language->get('text_none');
		$this->mdata['yesno'] = array( '0' => $this->language->get('text_no'),'1'=> $this->language->get('text_yes') );
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();

		$menu = $this->model_pavblog_menu->getInfo( $id );
		$menu = array_merge( $default, $menu );

		$this->mdata['menu'] = $menu;
		$this->mdata['menus'] = $this->model_pavblog_menu->getDropdown(null, $menu['parent_id'] );
		$this->mdata['thumb'] = $this->model_tool_image->resize($menu['image'], 150, 150);
		$this->mdata['menu_description'] = array();
		$descriptions  = $this->model_pavblog_menu->getMenuDescription( $id );
		$this->mdata['menu_description'] = array();

		foreach( $descriptions as $d ){
			$this->mdata['menu_description'][$d['language_id']] = $d;
		}


		foreach(  $this->mdata['languages'] as $language ){
			if( empty($this->mdata['menu_description'][$language['language_id']]) ){
				$this->mdata['menu_description'][$language['language_id']]['title'] = '';
				$this->mdata['menu_description'][$language['language_id']]['description'] = '';
			}
		}

		if( isset($this->request->post['blog']) ){
			$menu = array_merge($menu, $this->request->post['blog'] );
		}
		$this->mdata['menu'] = $menu;

		$this->mdata['submenutypes'] = array('menu'=>'Menu', 'html'=>'HTML');
		$this->mdata['text_edit_menu'] = $this->language->get('text_edit_menu');
		$this->mdata['text_create_new'] = $this->language->get('text_create_new');

		// Data Layout
		$this->mdata['header'] = $this->load->controller('common/header');
		$this->mdata['column_left'] = $this->load->controller('common/column_left');
		$this->mdata['footer'] = $this->load->controller('common/footer');

		$template = 'extension/module/pavblog/category_form.tpl';
		$this->response->setOutput($this->load->view($template, $this->mdata));	
	}

 	/**
 	 * check validation for category
  	 */
	protected function validateCategory() {

		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['pavblog_category_description'])) {

			$language_id = $this->config->get('config_language_id');

			if( empty($this->request->post['pavblog_category_description'][$language_id ]['title']) ){
				$this->error['warning'][]=$this->language->get('error_missing_title');
			}

		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * check validation for blog
	 */
	protected function validateBlog() {

		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['pavblog_blog_description'])) {

			$language_id = $this->config->get('config_language_id');

			if( empty($this->request->post['pavblog_blog_description'][$language_id ]['title']) ){
				$this->error['warning'][]=$this->language->get('error_missing_title');
			}
			if( empty($this->request->post['pavblog_blog_description'][$language_id ]['description']) ){
				$this->error['warning'][]=$this->language->get('error_missing_description');
			}
			if( empty($this->request->post['pavblog_blog_description'][$language_id ]['content']) ){
				$this->error['warning'][]=$this->language->get('error_missing_content');
			}

		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * pre process for loading needed models and check installation of this module.
	 */
	protected function preProcess(){
		$this->load->model('pavblog/blog');
		$this->load->language('extension/module/pavblog');

		$this->mdata['objlang'] = $this->language;
		$this->mdata['objurl'] = $this->url;

		$this->load->model('pavblog/install');
		$this->getModel( 'install' )->checkInstall();
	}

	/**
	 * Blog Management Page
	 */
	public function blog(){

		$this->preProcess();
		$this->load->model('pavblog/menu');

		$this->load->model('tool/image');
		$this->load->model('user/user');
		// save to database
		$issubmitfalse = false; 
		if (isset($this->request->post) && isset($this->request->post['pavblog_blog']) ) {
			if( $this->validateBlog() ) {
				$id = $this->model_pavblog_blog->saveData( $this->request->post );
				$action = $this->request->post['action_mode'];
				if( $action == 'save-edit' ){
					$this->response->redirect($this->url->link('extension/module/pavblog/blog', 'id='.$id.'&token=' . $this->session->data['token'], 'SSL'));
				}elseif( $action == 'save-new' ){
					$this->response->redirect($this->url->link('extension/module/pavblog/blog', 'token=' . $this->session->data['token'], 'SSL'));
				}else {
					$this->response->redirect($this->url->link('extension/module/pavblog/blogs', 'token=' . $this->session->data['token'], 'SSL'));
				}
			} else {
				$issubmitfalse = true;
			}
		}
		$this->mdata['text_image_manager'] = $this->language->get('text_image_manager');
 		$this->mdata['text_browse'] = $this->language->get('text_browse');
		$this->mdata['text_clear'] = $this->language->get('text_clear');

		$this->document->setTitle( $this->language->get('blog_page_heading_title') );
		$blog = array(
			'blog_id'=>0,
			'featured' => 0,
			'category_id'=>0,
			'position'=>'99',
			'status'=>'1',
			'image'=>'',
			'thumb' => '',
			'video_code'=>'',
			'user_id'=>'',
			'tags' => '',
			'hits'=>'0',
			'created'=>date("Y-m-d"),
			'image'=>'',
			'meta_keyword'=>'',
			'meta_description'=>'',
			'meta_title'=>'',
			'keyword' => ''
		);


		$blog['thumb'] = $this->mdata['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$this->load->model('localisation/language');
		$data = array();
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();
		if( isset($this->request->get['id']) ){
			$data = $this->model_pavblog_blog->getBlog( (int)$this->request->get['id'] );
			$blog = array_merge( $blog, $data['blog'] );
			if( $blog['image'] ){
				$blog['thumb'] = $this->model_tool_image->resize($blog['image'], 180, 180);
			}
		}
		$blog_descriptions = array();

		$this->mdata['users'] = $this->model_user_user->getUsers();


		foreach( $this->mdata['languages'] as $k => $language ){
			if( isset($data['blog_description']) && isset($data['blog_description'][$language['language_id']]) ){
				$blog_descriptions[$language['language_id']] = $data['blog_description'][$language['language_id']];
			}else {
				$blog_descriptions[$language['language_id']] = array('title'=>'','description'=>'','content'=>'');
			}
		}

		$this->mdata['action'] = $this->url->link('extension/module/pavblog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['action_delete'] = $this->url->link('extension/module/pavblog/deleteblog', 'id='.$blog['blog_id'].'&token=' . $this->session->data['token'], 'SSL');
		$this->mdata['menus'] = $this->model_pavblog_menu->getDropdown(null, $blog['category_id'], 'pavblog_blog[category_id]' );
		$this->mdata['yesno'] = array( 0 => $this->language->get('no'), 1=>$this->language->get('yes') );

		if( $issubmitfalse && isset($this->request->post['pavblog_blog'])  ) {
			$blog = array_merge( $blog, $this->request->post['pavblog_blog'] );

		}

		$this->mdata['blog'] = $blog;
		$this->mdata['pavblog_blog_descriptions'] = $blog_descriptions;
		$this->mdata['heading_title'] =  $this->language->get('blog_page_heading_title');
		$this->setBreadcrumb();
		$this->setTemplate("blog");
	}

	/**
	 * Listing Blogs Management Page.
	 */
	public function blogs(){
		$this->load->model('pavblog/menu');
		$this->preProcess();
		$filter = array('title'=>'','category_id'=> '');
		if( isset($this->request->post['filter']) ){
			$this->session->data['blog_filter'] = $this->request->post['filter'];
		}
		if( isset($this->request->get['reset']) ){
			$this->session->data['blog_filter'] = null;
		}
		if( isset($this->session->data['blog_filter'])  ){
			 $filter = array_merge($filter,$this->session->data['blog_filter']);
		}

		if( isset($this->request->post['selected']) ){
			$ids = $this->request->post['selected'];
			$this->getModel('blog')->saveAction( $ids, $this->request->post['do-action'] );
		}
		if( isset($this->request->post['do-action'])  && $this->request->post['do-action'] == 'position' ){
			$this->getModel('blog')->savePosition( $this->request->post['position'] );
		}
		$this->mdata['menus'] = $this->model_pavblog_menu->getDropdown(null, $filter['category_id'], 'filter[category_id]' );

		$this->mdata['filter'] = $filter;
		$this->mdata['create_blog_link'] = $this->url->link('extension/module/pavblog/blog', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['edit_link'] = $this->url->link('extension/module/pavblog/blog', 'id=%s&token=' . $this->session->data['token'], 'SSL');
		$this->document->setTitle( $this->language->get('blogs_page_heading_title') );
		$this->mdata['heading_title'] =  $this->language->get('blogs_page_heading_title');
		$this->mdata['action'] = $this->url->link('extension/module/pavblog/blogs', 'token=' . $this->session->data['token'], 'SSL');
		$this->mdata['action_reset'] = $this->url->link('extension/module/pavblog/blogs', 'reset=true&token=' . $this->session->data['token'], 'SSL');


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}



		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		$this->mdata['blogs'] = $this->model_pavblog_blog->getList( $data, $filter );
		$total =  $this->model_pavblog_blog->getTotal( $data, $filter );
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/module/pavblog/blogs', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->mdata['pagination'] = $pagination->render();
		$this->setBreadcrumb();
		$this->setTemplate("blogs");
	}

	public function deleteblog(){
		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if( isset($this->request->get['id']) && $id=$this->request->get['id'] ){
			$this->loadModel( 'blog' );
			$this->model_pavblog_blog->delete( $id );
		}
		$this->response->redirect( $this->url->link('extension/module/pavblog/blogs', 'token=' . $this->session->data['token'], 'SSL') );
	}

	public function getModel( $model ){
		return $this->{"model_pavblog_".$model};
	}

	public function loadModel( $model ){
		$this->load->model( 'pavblog/'.$model );
	}

	/**
	 *
	 */
	public function comments(){
		$this->preProcess();

		$this->setBreadcrumb();
		$this->loadModel( 'comment' );
		if( isset($this->request->post['selected']) ){
			switch(  $this->request->post['do-action'] ){
				case 'delete':
					if( isset($this->request->post['selected']) ){
						foreach( $this->request->post['selected'] as $id ){
							$this->getModel('comment')->delete( (int)$id );
						}
					}
					break;
				case 'published':
					if( isset($this->request->post['selected']) ){
						foreach( $this->request->post['selected'] as $id ){
							$this->getModel('comment')->savePublished( (int)$id, 1 );
						}
					}
					break;
				case 'unpublished':
					if( isset($this->request->post['selected']) ){
						foreach( $this->request->post['selected'] as $id ){
							$this->getModel('comment')->savePublished( (int)$id, 0 );
						}
					}
					break;
			}
		}
		$this->document->setTitle( $this->language->get('comments_page_heading_title') );
		$this->mdata['heading_title'] =  $this->language->get('comments_page_heading_title');
		$this->mdata['comments'] =  $this->getModel('comment')->getList();
		$this->mdata['action'] = $this->url->link('extension/module/pavblog/comments', 'token=' . $this->session->data['token'], 'SSL');

		$this->setTemplate("comments");

	}
	/**
	 * Comment Page
	 */
	public function comment(){
		if( isset($this->request->get['id']) && $id=$this->request->get['id'] ){
			$this->load->model('pavblog/comment');
			$id = $this->request->get['id'];
			$this->preProcess();

			if( isset($this->request->post['action_mode']) && isset($this->request->post['pavblog_comment']) ){
				$this->getModel('comment')->saveComment( $this->request->post['pavblog_comment'] );
				if( $this->request->post['action_mode']=='save-edit' ){
					$this->response->redirect( $this->url->link('extension/module/pavblog/comment', 'id='.$id.'&token=' . $this->session->data['token'], 'SSL' ) );
				}else {
					$this->response->redirect( $this->url->link('extension/module/pavblog/comments', 'token=' . $this->session->data['token'], 'SSL' ) );
				}
			}
			$this->setBreadcrumb();
			$this->document->setTitle( $this->language->get('blogs_page_heading_title') );
			$this->mdata['heading_title'] =  $this->language->get('blogs_page_heading_title');
			$this->mdata['action'] = $this->url->link('extension/module/pavblog/comment', 'id='.$id.'&token=' . $this->session->data['token'], 'SSL');
			$this->mdata['action_delete'] = $this->url->link('extension/module/pavblog/deletecomment', 'id='.$id.'&token=' . $this->session->data['token'], 'SSL');

			$this->mdata['yesno'] = array( 0 => $this->language->get('no'), 1=>$this->language->get('yes') );
			$comment = array(
				'blog_id' => '',
				'comment' => '',
				'status' => '0',
				'created' => '',
				'user'    => '',
				'email'   => '',
			);
			$tmp = $this->model_pavblog_comment->getComment( $id );
			if( $tmp ){
				$comment = array_merge( $comment, $tmp );
			}




			$this->mdata['comment'] = $comment ;
			$this->setTemplate("comment");
		}else {
			$this->response->redirect( $this->url->link('extension/module/pavblog/comments', 'token=' . $this->session->data['token'], 'SSL') );
		}
	}

	/**
	 * Delete Comments
	 */
	public function deletecomment(){
		if (!$this->user->hasPermission('modify', 'extension/module/pavblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		$this->loadModel('comment');
		if( isset($this->request->get['id']) ){
			$this->getModel('comment')->delete( (int)$this->request->get['id'] );
		}
		if( isset($this->request->post['selected']) ){
			foreach( $this->request->post['selected'] as $id ){
				$this->getModel('comment')->delete( (int)$id );
			}
		}
		$this->response->redirect( $this->url->link('extension/module/pavblog/comments', 'token=' . $this->session->data['token'], 'SSL') );
	}

	private function getModuleSetting(){
		$default = array(
			'children_columns' => '3',
			'general_cwidth' => '250',
			'general_cheight' => '250',
			'general_lwidth'=> '620',
			'general_lheight'=> '300',
			'general_sheight'=> '250',
			'general_swidth'=> '250',
			'general_xwidth' => '80',
			'general_xheight' => '80',
			'cat_show_hits' => '1',
			'cat_limit_leading_blog'=> '1',
			'cat_limit_secondary_blog'=> '5',
			'cat_leading_image_type'=> 'l',
			'cat_secondary_image_type'=> 's',
			'cat_show_title'=> '1',
			'cat_show_image'=> '1',
			'cat_show_author'=> '1',
			'cat_show_category'=> '1',
			'cat_show_created'=> '1',
			'cat_show_readmore' => 1,
			'cat_show_description' => '1',
			'cat_show_comment_counter'=> '1',

			'blog_image_type'=> 'l',
			'blog_show_title'=> '1',
			'blog_show_image'=> '1',
			'blog_show_author'=> '1',
			'blog_show_category'=> '1',
			'blog_show_created'=> '1',
			'blog_show_comment_counter'=> '1',
			'blog_show_comment_form'=>'1',
			'blog_show_hits' => 1,
			'cat_columns_leading_blogs'=> 1,
			'cat_columns_secondary_blogs' => 2,
			'comment_engine' => 'local',
			'diquis_account' => 'pavothemes',
			'facebook_appid' => '100858303516',
			'facebook_width'=> '600',
			'comment_limit'=> '10',
			'auto_publish_comment'=>0,
			'enable_recaptcha' => 1,
			'recaptcha_public_key'=>'6LcoLd4SAAAAADoaLy7OEmzwjrf4w7bf-SnE_Hvj',
			'recaptcha_private_key'=>'6LcoLd4SAAAAAE18DL_BUDi0vmL_aM0vkLPaE9Ob',
			'rss_limit_item' => 12,
			'keyword_listing_blogs_page'=>'blogs'

		);
		$general_setting = $this->config->get('pavblog');
		$general_setting = !empty($general_setting)?$general_setting:array();

		if( $general_setting ){
			$general_setting =  array_merge( $default,$general_setting);
		}else{
			$general_setting = $default;
		}
		return $general_setting;
	}

	/**
	 * Modules Setting Page
	 */
	public function modules(){
		$this->preProcess();
		$this->load->model('setting/setting');
		if( isset($this->request->post['pavblog']) ){
			$data = array();

			$data['pavblog'] = $this->request->post['pavblog'];
			$this->model_setting_setting->editSetting('pavblog', $data );

			$this->response->redirect( $this->url->link('extension/module/pavblog/modules', 'token=' . $this->session->data['token'], 'SSL') );

		}

		$general_setting = $this->getModuleSetting();

		$this->mdata['general_setting'] = $general_setting;
		$this->setBreadcrumb();
		$this->load->model('localisation/language');
		$this->document->setTitle( $this->language->get('modules_page_heading_title') );
		$this->mdata['heading_title'] =  $this->language->get('modules_page_heading_title');

		$this->mdata['comment_engine'] = array('facebook'=>'Facebook','diquis' => 'Diquis', 'local'=>'Local' );
		$this->mdata['yesno'] = array( '0' => $this->language->get('text_no'),'1'=> $this->language->get('text_yes') );
		$this->mdata['image_types'] = array( 'l' => $this->language->get('text_large_image'),'s'=> $this->language->get('text_small_image') );
		$this->mdata['token'] = $this->session->data['token'];
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();
		$this->mdata['action'] = $this->url->link('extension/module/pavblog/modules', 'token=' . $this->session->data['token'], 'SSL');




		


		// $this->mdata['positions'] = array( 'mainmenu',
		// 								  'slideshow',
		// 								  'showcase',
		// 								  'mass_bottom',
		// 								  'promotion',
		// 								  'content_top',
		// 								  'column_left',
		// 								  'column_right',
		// 								  'content_bottom',
		// 								  'footer_top',
		// 								  'footer_center',
		// 								  'footer_bottom'
		// );

		// $themeConfig = $this->config->get( 'themecontrol' );
		// if( isset($themeConfig['default_theme']) ){
		// 	$layoutxml = DIR_CATALOG.'view/theme/'.$themeConfig['default_theme'].'/development/layout/default.php';
		// 	if( file_exists($layoutxml) ){
		// 		include( $layoutxml );
		//  		$this->mdata['positions'] = PavoLayoutPositions::getList();
		// 	}
		// }	
		
		$this->mdata['entry_banner'] = $this->language->get('entry_banner');
		$this->mdata['entry_dimension'] = $this->language->get('entry_dimension');
		$this->mdata['entry_layout'] = $this->language->get('entry_layout');
		$this->mdata['entry_position'] = $this->language->get('entry_position');
		$this->mdata['entry_status'] = $this->language->get('entry_status');
		$this->mdata['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		$this->mdata['text_enabled'] = $this->language->get('text_enabled');
		$this->mdata['text_disabled'] = $this->language->get('text_disabled');
		$this->mdata['text_content_top'] = $this->language->get('text_content_top');
		$this->mdata['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->mdata['text_column_left'] = $this->language->get('text_column_left');
		$this->mdata['text_column_right'] = $this->language->get('text_column_right');

		// $this->load->model('design/layout');
		// $this->mdata['layouts'] = array();
		// $this->mdata['layouts'][] = array('layout_id'=>99999, 'name' => $this->language->get('all_page') );

		// $this->mdata['layouts'] = array_merge($this->mdata['layouts'],$this->model_design_layout->getLayouts());

		$this->setTemplate("modules");

	}

	protected function moduleValidate($module = "") {
		if ($module == "pavbloglatest_module" && isset($this->request->post[$module])) {
			foreach ($this->request->post[$module] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['dimension'][$key] = $this->language->get('error_dimension');
				}

				if (!$value['limit'] || !$value['cols']   ) {
					$this->error['dimension'][$key] = $this->language->get('error_carousel');
				}
			}

			if (!$this->error) {
				return true;
			} else {
				return false;
			}
		}
		return true;

	}

	// tab module
	public function module($extension, $module_id, $mod){
		$module_data = array();
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$extensions = $this->model_extension_extension->getInstalled('module');
		$modules = $this->model_extension_module->getModulesByCode($extension);
		foreach ($modules as $module) {
			$module_data[] = array(
				'module_id' => $module['module_id'],
				'name'      => $module['name'],
				'edit'      => $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'] . $mod . $module_id.'=' . $module['module_id'], 'SSL'),
				'delete'    => $this->url->link('extension/module/delete', 'token=' . $this->session->data['token'] . $mod . $module_id.'=' . $module['module_id'], 'SSL')
			);
		}
		$ex[] = array(
			'name'      => $this->language->get("create_module"),
			'module'    => $module_data,
			'install'   => $this->url->link('extension/module/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
			'uninstall' => $this->url->link('extension/module/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL'),
			'installed' => in_array($extension, $extensions),
			'edit'      => $this->url->link('extension/module/' . $extension, 'token=' . $this->session->data['token'], 'SSL')
		);

		return $ex;
	}
	// data module blogcategory
	public function moduleBlogCategory(){

		if (isset($this->request->get['module_catid'])) {
			$module_catid = $this->request->get['module_catid'];
			$urlcat = '&module_catid='.$module_catid;
		} else {
			$module_catid = '';
			$urlcat = '';
		}
		$this->mdata['module_catid'] = $module_catid;
		$this->mdata['action_cat'] = $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'] . '&mod=pavblogcategory' . $urlcat, 'SSL');
		$this->mdata['delete_cat'] = $this->url->link('extension/module/pavblog/catdelete', 'token=' . $this->session->data['token'].$urlcat, 'SSL');
						
		// GET DATA SETTING
		if (isset($this->request->get['module_catid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_catid']);
		}

		$this->mdata['entry_tree'] = $this->language->get("entry_tree");

		// type
		if (isset($this->request->post['pavblogcategory_module']['type'])) {
			$this->mdata['type'] = $this->request->post['pavblogcategory_module']['type'];
		} elseif (!empty($module_info)) {
			$this->mdata['type'] = $module_info['type'];
		} else {
			$this->mdata['type'] = 'default';
		}

		// name
		if (isset($this->request->post['pavblogcategory_module']['name'])) {
			$this->mdata['catname'] = $this->request->post['pavblogcategory_module']['name'];
		} elseif (!empty($module_info)) {
			$this->mdata['catname'] = $module_info['name'];
		} else {
			$this->mdata['catname'] = '';
		}

		// category_id
		if (isset($this->request->post['pavblogcategory_module']['category_id'])) {
			$category_id = $this->request->post['pavblogcategory_module']['category_id'];
		} elseif (!empty($module_info)) {
			$category_id = $module_info['category_id'];
		} else {
			$category_id = 1;
		}

		// status
		if (isset($this->request->post['pavblogcategory_module']['status'])) {
			$this->mdata['status_cat'] = $this->request->post['pavblogcategory_module']['status'];
		} elseif (!empty($module_info)) {
			$this->mdata['status_cat'] = $module_info['status'];
		} else {
			$this->mdata['status_cat'] = 1;
		}

		// status
		if (isset($this->request->post['pavblogcategory_module']['type'])) {
			$this->mdata['type'] = $this->request->post['pavblogcategory_module']['type'];
		} elseif (!empty($module_info)) {
			$this->mdata['type'] = $module_info['type'];
		} else {
			$this->mdata['type'] = '';
		}

		$this->mdata['options'] = $this->model_pavblog_menu->getOption(null, $category_id);
	}

	// data module blog comment
	public function moduleBlogComment(){
		if (isset($this->request->get['module_comid'])) {
			$module_comid = $this->request->get['module_comid'];
			$urlcom = '&module_comid='.$module_comid;
		} else {
			$module_comid = '';
			$urlcom = '';
		}
		$this->mdata['module_comid'] = $module_comid;

		$this->mdata['action_com'] = $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'] . '&mod=pavblogcomment' . $urlcom, 'SSL');
		$this->mdata['delete_com'] = $this->url->link('extension/module/pavblog/comdelete', 'token=' . $this->session->data['token'].$urlcom, 'SSL');

		// GET DATA SETTING
		if (isset($this->request->get['module_comid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_comid']);
		}

		// name
		if (isset($this->request->post['pavblogcomment_module']['name'])) {
			$this->mdata['name_com'] = $this->request->post['pavblogcomment_module']['name'];
		} elseif (!empty($module_info)) {
			$this->mdata['name_com'] = $module_info['name'];
		} else {
			$this->mdata['name_com'] = '';
		}

		// category_id
		if (isset($this->request->post['pavblogcomment_module']['limit'])) {
			$this->mdata['limit_com'] = $this->request->post['pavblogcomment_module']['limit'];
		} elseif (!empty($module_info)) {
			$this->mdata['limit_com'] = $module_info['limit'];
		} else {
			$this->mdata['limit_com'] = 1;
		}

		// status
		if (isset($this->request->post['pavblogcomment_module']['status'])) {
			$this->mdata['status_com'] = $this->request->post['pavblogcomment_module']['status'];
		} elseif (!empty($module_info)) {
			$this->mdata['status_com'] = $module_info['status'];
		} else {
			$this->mdata['status_com'] = 1;
		}
	}

	// data module blog comment
	public function moduleBlogLatest(){

		if (isset($this->request->get['module_latid'])) {
			$module_latid = $this->request->get['module_latid'];
			$urllat = '&module_latid='.$module_latid;
		} else {
			$module_latid = '';
			$urllat = '';
		}
		$this->mdata['module_latid'] = $module_latid;
		
		$this->mdata['action_lat'] = $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'] . '&mod=pavbloglatest' . $urllat, 'SSL');
		// action delete
		$this->mdata['delete_lat'] = $this->url->link('extension/module/pavblog/latdelete', 'token=' . $this->session->data['token'].$urllat, 'SSL');

		// GET DATA SETTING
		if (isset($this->request->get['module_latid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_latid']);
		}

		$selectabs = array(
			'latest' 	 => $this->language->get('text_latest'),
			'featured'   => $this->language->get('text_featured'),
			'mostviewed' => $this->language->get('text_mostviewed')
		);
		$this->mdata['selectabs'] = $selectabs;
		
		// status
		if (isset($this->request->post['pavbloglatest_module']['status'])) {
			$this->mdata['status_lat'] = $this->request->post['pavbloglatest_module']['status'];
		} elseif (!empty($module_info)) {
			$this->mdata['status_lat'] = $module_info['status'];
		} else {
			$this->mdata['status_lat'] = 1;
		}

		// name
		if (isset($this->request->post['pavbloglatest_module']['name'])) {
			$this->mdata['name_lat'] = $this->request->post['pavbloglatest_module']['name'];
		} elseif (!empty($module_info)) {
			$this->mdata['name_lat'] = $module_info['name'];
		} else {
			$this->mdata['name_lat'] = '';
		}

		// description
		if (isset($this->request->post['pavbloglatest_module']['description'])) {
			$this->mdata['description'] = $this->request->post['pavbloglatest_module']['description'];
		} elseif (!empty($module_info)) {
			$this->mdata['description'] = $module_info['description'];
		} else {
			$this->mdata['description'] = '';
		}

		// prefixclass_lat
		if (isset($this->request->post['pavbloglatest_module']['prefixclass'])) {
			$this->mdata['prefixclass'] = $this->request->post['pavbloglatest_module']['prefixclass'];
		} elseif (!empty($module_info)) {
			$this->mdata['prefixclass'] = $module_info['prefixclass'];
		} else {
			$this->mdata['prefixclass'] = "prefix class";
		}

		// tabs
		if (isset($this->request->post['pavbloglatest_module']['tabs'])) {
			$this->mdata['tabs'] = $this->request->post['pavbloglatest_module']['tabs'];
		} elseif (!empty($module_info)) {
			$this->mdata['tabs'] = $module_info['tabs'];
		} else {
			$this->mdata['tabs'] = '';
		}

		// width
		if (isset($this->request->post['pavbloglatest_module']['width'])) {
			$this->mdata['width'] = $this->request->post['pavbloglatest_module']['width'];
		} elseif (!empty($module_info)) {
			$this->mdata['width'] = $module_info['width'];
		} else {
			$this->mdata['width'] = '300';
		}

		// height
		if (isset($this->request->post['pavbloglatest_module']['height'])) {
			$this->mdata['height'] = $this->request->post['pavbloglatest_module']['height'];
		} elseif (!empty($module_info)) {
			$this->mdata['height'] = $module_info['height'];
		} else {
			$this->mdata['height'] = '300';
		}

		// cols
		if (isset($this->request->post['pavbloglatest_module']['cols'])) {
			$this->mdata['cols'] = $this->request->post['pavbloglatest_module']['cols'];
		} elseif (!empty($module_info)) {
			$this->mdata['cols'] = $module_info['cols'];
		} else {
			$this->mdata['cols'] = '4';
		}

		// limit
		if (isset($this->request->post['pavbloglatest_module']['limit'])) {
			$this->mdata['limit_lat'] = $this->request->post['pavbloglatest_module']['limit'];
		} elseif (!empty($module_info)) {
			$this->mdata['limit_lat'] = $module_info['limit'];
		} else {
			$this->mdata['limit_lat'] = '4';
		}
	}

	// delete module id
	public function catdelete(){
		$this->load->model('extension/module');
		
		if (isset($this->request->get['module_catid'])) {
			$this->model_extension_module->deleteModule($this->request->get['module_catid']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	public function comdelete(){
		$this->load->model('extension/module');
		
		if (isset($this->request->get['module_comid'])) {
			$this->model_extension_module->deleteModule($this->request->get['module_comid']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	public function latdelete(){

		$this->load->model('extension/module');
		
		if (isset($this->request->get['module_latid'])) {
			$this->model_extension_module->deleteModule($this->request->get['module_latid']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	// data language frontmodule
	public function _languageFrontModule(){
		$this->load->model('localisation/language');
		$this->mdata['languages'] = $this->model_localisation_language->getLanguages();

		$this->document->setTitle( $this->language->get('modules_page_heading_title') );
		$this->mdata['heading_title'] =  $this->language->get('modules_page_heading_title');

		$this->mdata['comment_engine'] = array('facebook'=>'Facebook','diquis' => 'Diquis', 'local'=>'Local' );
		$this->mdata['yesno'] = array( '0' => $this->language->get('text_no'),'1'=> $this->language->get('text_yes') );
		$this->mdata['image_types'] = array( 'l' => $this->language->get('text_large_image'),'s'=> $this->language->get('text_small_image') );
		$this->mdata['token'] = $this->session->data['token'];
		
		$this->mdata['entry_banner'] = $this->language->get('entry_banner');
		$this->mdata['entry_dimension'] = $this->language->get('entry_dimension');
		$this->mdata['entry_layout'] = $this->language->get('entry_layout');
		$this->mdata['entry_position'] = $this->language->get('entry_position');
		$this->mdata['entry_status'] = $this->language->get('entry_status');
		$this->mdata['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->mdata['button_save'] = $this->language->get('button_save');
		$this->mdata['button_cancel'] = $this->language->get('button_cancel');
		$this->mdata['button_add_module'] = $this->language->get('button_add_module');
		$this->mdata['button_remove'] = $this->language->get('button_remove');
		$this->mdata['text_enabled'] = $this->language->get('text_enabled');
		$this->mdata['text_disabled'] = $this->language->get('text_disabled');
		$this->mdata['text_content_top'] = $this->language->get('text_content_top');
		$this->mdata['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->mdata['text_column_left'] = $this->language->get('text_column_left');
		$this->mdata['text_column_right'] = $this->language->get('text_column_right');
		$this->mdata['tab_module'] = $this->language->get('tab_module');

		$this->mdata['entry_tree'] = $this->language->get('entry_tree');
	}

	public function frontmodules(){
		$this->preProcess();
		$this->load->model('setting/setting');

		$this->document->addScript('view/javascript/sliderlayer/jquery-cookie.js');

		$this->mdata['excat'] = $this->module("pavblogcategory", "&module_catid", "&mod=pavblogcategory");
		$this->mdata['excom'] = $this->module("pavblogcomment", "&module_comid", "&mod=pavblogcomment");
		$this->mdata['exlat'] = $this->module("pavbloglatest", "&module_latid", "&mod=pavbloglatest");

		if( $this->request->server['REQUEST_METHOD'] == 'POST'){
			if( isset($this->request->post['pavblogcategory_module']) ) { 
				if (!isset($this->request->get['module_catid'])) {
					$this->model_extension_module->addModule('pavblogcategory', $this->request->post['pavblogcategory_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL') );
				} else {
					$this->model_extension_module->editModule($this->request->get['module_catid'], $this->request->post['pavblogcategory_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'].'&mod=pavblogcategory'.'&module_catid='.$this->request->get['module_catid'], 'SSL') );
				}
			} 

			if( isset($this->request->post['pavblogcomment_module']) ) {
				if (!isset($this->request->get['module_comid'])) {
					$this->model_extension_module->addModule('pavblogcomment', $this->request->post['pavblogcomment_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL') );
				} else {
					$this->model_extension_module->editModule($this->request->get['module_comid'], $this->request->post['pavblogcomment_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'].'&mod=pavblogcomment'.'&module_comid='.$this->request->get['module_comid'], 'SSL') );
				}
			}

			if( isset($this->request->post['pavbloglatest_module']) ) {
				if (!isset($this->request->get['module_latid'])) {
					$this->model_extension_module->addModule('pavbloglatest', $this->request->post['pavbloglatest_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'], 'SSL') );
				} else {
					$this->model_extension_module->editModule($this->request->get['module_latid'], $this->request->post['pavbloglatest_module']);
					$this->response->redirect( $this->url->link('extension/module/pavblog/frontmodules', 'token=' . $this->session->data['token'].'&mod=pavbloglatest'.'&module_latid='.$this->request->get['module_latid'], 'SSL') );
				}
			}
		}
		$general_setting = $this->getModuleSetting();
		$this->mdata['general_setting'] = $general_setting;

		

		// common data
		$this->setBreadcrumb();
		$this->_languageFrontModule();

		$this->load->model('pavblog/menu');
		$this->mdata['options'] = $this->model_pavblog_menu->getOption(null, 1);

		//-- Get Data Module Pav BlogCategory
		$this->moduleBlogCategory();

		//-- Get Data Module Pav CommentCategory
		$this->moduleBlogComment();

		// Get Data Module Pav LatestCategory
		$this->moduleBlogLatest();

		$this->setTemplate("frontmodules");
	}

	/**
	 * Information Page
	 */
	public function information(){
		$this->preProcess();
		$this->setBreadcrumb();
		$this->document->setTitle( $this->language->get('modules_page_heading_title') );
		$this->mdata['heading_title'] =  $this->language->get('modules_page_heading_title');
		$this->setTemplate("information");
	}



	public function tabModules() {
		$modules_path = DIR_APPLICATION.'view/template/extension/module/'.$this->moduleName.'/'.$this->module_folder.'/';

		$this->list_modules = array();
		if( is_dir($modules_path) ) {
			$files = glob($modules_path.'*.tpl');
			foreach( $files as $dir ){
				$filename = str_replace(".tpl","",basename( $dir ) );
				$filename = trim($filename);
				$this->list_modules[$filename] = str_replace("","",basename( $dir ) );
			}
		}
		$this->mdata['layout_modules'] = $this->getModules( $this->list_modules);
	}

	public function getModules( $list_files = array() ){
		if(empty($list_files)) return false;
		$this->load->model('pavblog/blog');
		$module_data = array();
		$this->load->model('pavblog/menu');
      if(!empty($list_files)){
          foreach($list_files as $key => $file){
              $modules = $this->config->get($key.'_module' );
              $this->load->language('extension/module/blog');
              $tmp_modules = array();
              if(!empty($modules)){
                  $sort_order = array();
                  foreach ($modules as $index => $module) {
                      switch ($key) {
                          case 'pavblogcategory':
                              $module['category_id'] = isset($module['category_id'])?$module['category_id']:0;
                              $module['sort_order'] = isset($module['sort_order'])?$module['sort_order']:0;
                              $module['menus'] = $this->model_pavblog_menu->getDropdown(null, $module['category_id'], $key.'_module['.($index).'][category_id]' );
                              break;

                          default:

                              break;
                      }

                      $sort_order[$index] = isset($module['sort_order'])?$module['sort_order']:0;
                      $tmp_modules[] = $module;
                  }
                  array_multisort($sort_order, SORT_ASC, $tmp_modules);
              }else{
                  unset($list_files[$key]);
              }
              $module_data[$key] = $tmp_modules;
          }
      }
		$module_data = array_merge($list_files, $module_data);
		$this->load->language('extension/module/'.$this->moduleName);
		return $module_data;
	}
}
?>
