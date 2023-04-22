<?php
class ControllerExtensionModulepavblogcomment extends Controller {
	
	private $mdata = array();

	public function index($setting) {

		// pavo 2.2 fix
		$config_theme = $this->config->get('theme_default_directory');
		$this->mdata['objlang']   = $this->language;
		$this->mdata['ourl']      = $this->url;
		$this->mdata['themename'] = $config_theme;
		// pavo 2.2 fix

		static $module = 0;
		
		$this->load->model('pavblog/comment');
		$this->load->model('catalog/product'); 
		$this->load->model('tool/image');
		$this->load->language('extension/module/pavblog');
		
		if (file_exists('catalog/view/theme/' . $config_theme . '/stylesheet/pavblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $config_theme . '/stylesheet/pavblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/pavblog.css');
		}
		
		 
		$this->mdata['heading_title'] = $this->language->get('blogcomment_heading_title');
		
		$comments = $this->model_pavblog_comment->getLatest( (int)$setting['limit'] );
		foreach( $comments as $k => $comment ){
			$comments[$k]['link'] = $this->url->link( 'pavblog/blog',"blog_id=".$comment['blog_id']."#comment".$comment['comment_id'] );
		}
		$this->mdata['comments'] = $comments;
	
		$this->mdata['module'] = $module++;
		
		return $this->load->view('extension/module/pavblogcomment', $this->mdata);
	}
	
}
?>