<?php 	
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogBlog 
 */
class ModelPavblogBlog extends Model {		
	
	
	public function __construct( $registry ){
		parent::__construct( $registry );
		$this->isInstalled();

	}
	/**
	 * Get Blog Information by Id 
	 */
	public function getInfo( $id ){
		
		$query = ' SELECT b.*,bd.title,bd.description,cd.title as category_title,bd.content  FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON (c.category_id=cd.category_id AND cd.language_id='.(int)$this->config->get('config_language_id').')' ;
				
		$query .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		$query .= " AND b.blog_id=".(int)$id;
		
		
		$query = $this->db->query( $query );
		$blog = $query->row;
		return $blog; 
	}
	
	/**
	 * update hit time after read
	 */
	public function updateHits( $id ){
		$sql = ' UPDATE '.DB_PREFIX.'pavblog_blog SET hits=hits+1 WHERE blog_id='.(int)$id;
		$this->db->query( $sql );
	}
	
	/**
	 * get list of blogs in same category of current
	 */
	public function getSameCategory( $category_id, $blog_id, $limit=10 ){
		$data = array(
			'filter_category_id' => $category_id,

			'not_in'           => $blog_id,
			'sort'               => 'created',
			'order'              => 'DESC',
			'start'              => 0,
			'limit'              => $limit
		);

		return $this->getListBlogs( $data );
	}
	
	/**
	 * get total blog
	 */
	public function getTotal( $data ){
		$sql = ' SELECT count(b.blog_id) as total FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id')." LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id  and cd.language_id='.(int)$this->config->get('config_language_id') ;
				
		$sql .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		
		if( isset($data['filter_category_id']) && $data['filter_category_id'] ){
			$sql .= " AND b.category_id=".(int)$data['filter_category_id'];
		}
		if( isset($data['filter_tag']) && $data['filter_tag'] ){
			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'b.tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND b.tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}
	
		$query = $this->db->query( $sql );
		return $query->row['total'];

	}
	
	/**
	 *  get list blogs 
	 */
	public function getListBlogs( $data ){
		
		$sql = ' SELECT b.*,bd.title,bd.description,cd.title as category_title FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id')." LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id  and cd.language_id='.(int)$this->config->get('config_language_id') ;
				
		$sql .=" WHERE b.status = '1' AND bd.language_id=".(int)$this->config->get('config_language_id');
		
		if( isset($data['filter_category_id']) && $data['filter_category_id'] ){
			$sql .= " AND b.category_id=".(int)$data['filter_category_id'];
		}
		
		
		if( isset($data['filter_tag']) && $data['filter_tag'] ){
			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'b.tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND b.tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}
		
		if( isset($data['featured']) ){
			$sql .= ' AND featured=1 '; 
		}
		
		if( isset($data['not_in']) && $data['not_in'] ){
			$sql .= ' AND b.blog_id NOT IN('.$data['not_in'].')';
		}
		$sort_data = array(
			'bd.title',
			
			'b.hits',
			'b.`position`',
			'b.`created`',
			'b.created'
		);	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			}else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY b.`position`";	
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(bd.title) DESC";
		} else {
			$sql .= " ASC, LCASE(bd.title) ASC";
		} 
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
	
		$query = $this->db->query( $sql );
		$blogs = $query->rows;
		return $blogs; 
	}

	public function isInstalled() {
		$sql = " SHOW TABLES LIKE '".DB_PREFIX."pavblog_blog'";
		$query = $this->db->query( $sql );
		if( count($query->rows) <=0 ){ 
			$file = dirname(DIR_APPLICATION).'/admin/model/sample/module.php';
			if( file_exists($file) ){
				require_once( $file );
		 		$sample = new ModelSampleModule( $this->registry );
		 	    $result = $sample->installSampleQuery( $this->config->get('theme_default_directory'),'pavblog', true );  
		 	    
			}
			return false;
		}
		return true;
	}


	public function getDefaultConfig(){


 
		return array(
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
			'cat_columns_leading_blog'=> 1,
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
	}
	
}
?>
