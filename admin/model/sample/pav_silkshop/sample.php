<?php 
if( !class_exists("ModuleSample") ) {
	class ModuleSample { 
		public static function getModules(){ 
			$modules = array(
				'special',
				'featured',
				'filter',
				'pavblog',
				'pavblogcategory',
				'pavblogcomment',
				'pavbloglatest',
				'pavsliderlayer',
				'pavmegamenu',
				'pavnewsletter',
                'pavgallery',
				'pavhomebuilder'
			);
	
			return $modules;
		}
		
		public static function getTables(){
			$tables = array();
			$tables['pavmegamenu']['megamenu'] = array( 'table' => 'megamenu', 'lang'=>false, 'module'=>'pavmegamenu' );
			$tables['pavmegamenu']['megamenu_description'] = array( 'table' => 'megamenu_description', 'lang'=>true, 'module'=>'pavmegamenu' );
			$tables['pavmegamenu']['megamenu_widgets'] = array( 'table' => 'megamenu_widgets', 'lang'=>false, 'module'=>'pavmegamenu' );

			$tables['pavblog']['pavblog_blog'] = array( 'table' => 'pavblog_blog', 'lang'=>false, 'module'=>'pavblog' );
			$tables['pavblog']['pavblog_blog_description'] = array( 'table' => 'pavblog_blog_description', 'lang'=>true, 'module'=>'pavblog' );
			$tables['pavblog']['pavblog_category'] = array( 'table' => 'pavblog_category', 'lang'=>false, 'module'=>'pavblog' );
			$tables['pavblog']['pavblog_category_description'] = array( 'table' => 'pavblog_category_description', 'lang'=>true, 'module'=>'pavblog' );
			$tables['pavblog']['pavblog_comment'] = array( 'table' => 'pavblog_comment', 'lang'=>false, 'module'=>'pavblog' );
			
			$tables['pavsliderlayer']['pavoslidergroups'] = array( 'table' => 'pavoslidergroups', 'lang'=>false, 'module'=>'pavsliderlayer' );
			$tables['pavsliderlayer']['pavosliderlayers'] = array( 'table' => 'pavosliderlayers', 'lang'=>true, 'module'=>'pavsliderlayer' );	

			$tables['pavhomebuilder']['pavwidget'] = array( 'table' => 'pavwidget', 'lang'=>false, 'module'=>'pavwidget' );

			return $tables; 
		}
		public static function getModulesQuery(){
			$query = array();
			if( is_file(dirname(__FILE__).'/query-tables.php') ){
				include( dirname(__FILE__).'/query-tables.php' );
				include( dirname(__FILE__).'/query.php' );
			}
			elseif( is_file(dirname(__FILE__).'/query.php') ){
				include( dirname(__FILE__).'/query.php' );
			}
			return $query;
		}
		public static function installCustomSetting( $m ){
			
			$d['pavblog'] = array(
						'children_columns' => '3',
						'general_cwidth' => '865',
						'general_cheight' => '558',
						'general_lwidth'=> '865',
						'general_lheight'=> '558',
						'general_swidth'=> '865',
						'general_sheight'=> '558',
						'general_xwidth' => '80',
						'general_xheight' => '80',
						'cat_show_hits' => '1',
						'cat_limit_leading_blog'=> '1',
						'cat_limit_secondary_blog'=> '3',
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
						'cat_columns_secondary_blogs' => 1,
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

			$m->load->model('setting/setting');
			$m->model_setting_setting->editSetting('pavblog', $d );	
		}
		
		public static function getStoreConfigs(){
			return array(
					'theme_default_image_category_width' =>870,
					'theme_default_image_category_height' => 259,
					
					'theme_default_image_thumb_width' =>570,
					'theme_default_image_thumb_height' => 532,
					
					'theme_default_image_popup_width' =>870,
					'theme_default_image_popup_height' => 812,
					
					'theme_default_image_product_width' =>400,
					'theme_default_image_product_height' => 373,
					
					'theme_default_image_additional_width' =>200,
					'theme_default_image_additional_height' => 187,
					
					'theme_default_image_related_width' =>570,
					'theme_default_image_related_height' => 532,
					
					'theme_default_image_compare_width' =>90,
					'theme_default_image_compare_height' => 84,
					
					'theme_default_image_wishlist_width' =>90,
					'theme_default_image_wishlist_height' => 84,
					
					'theme_default_image_cart_width' => 90,
					'theme_default_image_cart_height' => 84,
			);
		}
	
	}
}
?>