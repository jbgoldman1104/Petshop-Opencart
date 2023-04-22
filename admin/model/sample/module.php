<?php
/******************************************************
 * @package Pav Opencart Theme Framework for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) October 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class ModelSampleModule extends Model {
	
	public $extensions = array();
	/**
	 * get data sample by actived theme
	 */
	public function getSamplesByTheme( $theme ){ 	 
	 
		$files = glob(  dirname(__FILE__).'/'.$theme.'/modules/*.php' );

		$this->load->model('extension/extension');
		$extensions = $this->model_extension_extension->getInstalled('module');
		$output = array();
		if( $files ){
			foreach( $files as $dir ){
				$module = str_replace(".php","",basename( $dir ));
				if( !is_file(DIR_APPLICATION."controller/module/".$module.".php") ){	
					$moduleName = $module;
					$existed = 0;
				}else {
					$this->load->language( 'extension/module/'.$module );		
					$moduleName = $this->language->get('heading_title');
					$existed = 1;
				}
 		
				$modules = $this->config->get( $module . '_module');
		 
				$output[$module] = array('extension_installed' => in_array( $module, $extensions ), 
										 "module"    => $module ,
										 'existed'   => $existed, 
										 'installed' => empty($data)?0:1, 
										 'moduleName'=> $moduleName );
		
			}		
		}	
		else if( file_exists(dirname(__FILE__).'/'.$theme.'/profile.txt') ){
			$data = unserialize( file_get_contents(  dirname(__FILE__).'/'.$theme.'/profile.txt' ) ); 
			$output = isset($data['modules'])?$data['modules']:array(); 

		}
		return $output;
	}
	
	/**
	 * get modules having queries
	 */
	public function getModulesQuery( $theme ){

		if( is_file(dirname(__FILE__).'/'.$theme.'/sample.php') ) {

			require( dirname(__FILE__).'/'.$theme.'/sample.php' );
			$dir = dirname(__FILE__).'/'.$theme.'/';

			$query 	    =  ModuleSample::getModulesQuery();
			$modules    = array();
			
			foreach( $query as $key=>$q ) {  
				if( !is_file(DIR_APPLICATION."controller/extension/module/".$key.".php") ){	
		 			$this->load->language('extension/module/' . $key);	 	
					$modules[$key] = $this->language->get( 'heading_title' );
				}
			}
 
			return $modules;
		}	
		return array();
	}
	
	/**
	 *
	 */
	public function massInstallSample( $theme, $tmp_modules ){ 


		$file = (dirname(__FILE__).'/'.$theme.'/profile.txt');
		if(  file_exists($file) ){
			$content = file_get_contents( $file );

		

			if( !empty($content) ) {
				$profile = @unserialize( $content );
				if( isset($profile['modules']) ) {
					$this->importProfiles(  $profile, array(), $theme );
				} 
 
			}
		}

		$modules = ModuleSample::getModules();

		if( is_array($modules) ) {
			$this->load->model('extension/extension');
			$extensions = $this->model_extension_extension->getInstalled('module');
			foreach( $modules as $key=>$value ){
				$module = $value;
				if( file_exists(DIR_APPLICATION . 'controller/extension/module/' . $module . '.php') ){
					if ( !in_array($module, $extensions))  {
						$this->installModule(  $module );	
					}
					$this->installSampleQuery(  $theme, $module );	
					//$this->installSample( $theme, $module );
				}	
			}
		} die ("done");
	}

	/**
	 *
	 */
	public function getModuleInstalled(){

		if( !$this->extensions ){
			$this->load->model('extension/extension');
			$extensions = $this->model_extension_extension->getInstalled('module');

			foreach ($extensions as $key => $value) {
				if (!file_exists(DIR_APPLICATION . 'controller/extension/module/' . $value . '.php')) {
					// $this->model_setting_extension->uninstall('module', $value);
					unset($extensions[$key]);
				}
			}
			$this->extensions = $extensions;
		}

		return $this->extensions;
	}

	/**
	 *
	 */
	public function setActiveByProfileSkin( $theme, $skin ){

 		$skin = empty($skin) ? 'default' : $skin; 
		$file = DIR_CATALOG . 'view/theme/'.$theme.'/development/profiles/'.$skin.'.txt'; 
 		if( file_exists($file) ){
 			$content = file_get_contents( $file );
			if( !empty($content) ) {
				$profile = @unserialize( $content );
				if( isset($profile['modules']) ) {
					$this->importProfiles(  $profile, array(), $theme );
				} 
 
			}	
 		}

		// die ('fds');
	}

	public function installModule( $extension ){

 		$this->load->model( 'extension/extension' );
		$this->model_extension_extension->install('module', $extension );

		$this->load->model('user/user_group');

		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/module/' . $extension );
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/module/' . $extension );

		// Call install method if it exsits
		$this->load->controller( 'extension/module/' . $extension . '/install' );

	}
	/**
	 *
	 */
	public function importProfiles( $profile, $exmodules=array(), $theme='' ){ 
		$this->load->model('setting/setting');
		$this->load->model('extension/module');
 	
		
		if( isset($profile['modules']) && is_array($profile['modules']) ){

		    $extensions = $this->getModuleInstalled();
		 
 			foreach( $profile['modules'] as $module => $content ){
 			
				if ( !in_array($module, $extensions))  {
					$this->installModule(  $module );	
					$this->installSampleQuery( $theme, $module );
					$this->installSample( $theme, $module );
				}
 			} 
		 

		    $this->db->query("DELETE FROM `" . DB_PREFIX . "module`");

			foreach( $profile['modules'] as $module => $mdata ){
				foreach( $mdata as $data ){
					if( isset($data['module_id']) ){ 
						$this->db->query("INSERT INTO `" . DB_PREFIX . "module` SET module_id=".$data['module_id'].", `name` = '" . $this->db->escape($data['name']) . "', `code` = '" . $this->db->escape($data['code']) . "', `setting` = '" . $this->db->escape($data['setting']) . "'");
					}
				}
			}	
		}
 	
 		if( isset($profile['config']) && is_array($profile['config']) ){
 			foreach( $profile['config'] as $module => $data ){
 				foreach( $data as $k=>$v){
 					$data[$k] = str_replace( '\n', " ", str_replace('\r', ' ', $v ) );
 				}
				$this->model_setting_setting->editSetting( $module, array($module=>$data)  );
 			}
 		
 		}
		if( isset($profile['store']) && is_array($profile['store']) ){
			$store_id = 0;	
			$data = $this->model_setting_setting->getSetting('config', $store_id );
			$new = array_merge( $data, $profile['store'] );
			$this->model_setting_setting->editSetting('config', $new, $store_id ); 
		}
	

		if( isset($profile['module_layout']) ){
			$pos = array();	
			foreach( $profile['module_layout']as $module ){
				$pos[$module['position']][] = $module;
			}

	
			foreach( $pos as $ipos => $mods ){
				$this->db->query('DELETE FROM '.DB_PREFIX.'layout_module WHERE position="'.$ipos.'"');
				
				foreach( $mods as   $mod ){
					$f = array();
					foreach( $mod as $k=> $v ){
						$f[] = '`'.$k.'`';

					}
					$query = 'INSERT INTO '.DB_PREFIX.'layout_module('.implode(",", $f).') VALUES("'.implode('","', $mod).'")';

					$this->db->query( $query ); 
				} 
				
			} 	
		}
	}

	public function _exportProfiles( $theme ){
		$this->load->model('setting/themecontrol');
		$this->load->model('extension/extension');
		$this->load->model('extension/module');
		$modules = array();
	 
 		$output = array( 'modules'=> array(), 'store'=> array() , 'module_layout' => array(), 'config'=>array() );



		$files = glob(DIR_APPLICATION . 'controller/extension/module/*.php');
		 
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$this->load->language('extension/module/' . $extension);
				$modules = $this->model_extension_module->getModulesByCode($extension);
				foreach ($modules as $module) {
					$output['modules'][$extension][] = $module;
				}
				$config = $this->config->get($extension);
				if( $config ){

					foreach( $config as $k => $tconfig ){
						
						if( is_array($tconfig) ){
							foreach( $tconfig as $tk =>$tv ){
								$search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
								$replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
									
								$tv = str_replace($search, $replace, $tv);
								
								$tconfig[$tk] =  $tv; //str_replace( "\r\n", "", $tv );
							}
							$config[$k] = $tconfig; 
						}
					}
					$output['config'][$extension] = $config;
				}	 
			}
		}

		


		// Default Image Config Theme Store
		$sc = ModuleSample::getStoreConfigs();
		foreach($sc as $key => $value ){
			$sc[$key] = $this->config->get( $key );
		}

		$output['store'] = $sc; 
		$output['module_layout'] = array();

		$sql = ' SELECT * FROM '.DB_PREFIX.'layout_module';
		$query = $this->db->query( $sql );
		$rows =  $query->rows;

 		if( $rows ){
 			$output['module_layout'] = $rows; 
 		}

		return $output;
	}
	/**
	 *
	 */
	public function exportProfiles( $theme ){
	
 		$output = $this->_exportProfiles( $theme );

 		$dir = DIR_CACHE;
		if( !is_dir($dir) ){
			mkdir($dir,0777);
		}
		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename="'.$theme.'_profile_setting_'.time().'.txt'.'"');

		print( serialize($output)  ); exit;
		
	 
	 
	}

	/**
	 * export data sample of modules
	 */
	public function export( $theme ) {
		if( is_file(dirname(__FILE__).'/'.$theme.'/sample.php') ) {
			require( dirname(__FILE__).'/'.$theme.'/sample.php' );
			$dir = dirname(__FILE__).'/'.$theme.'/modules/';
			if(  !is_dir($dir) ){
				mkdir( $dir, 0755 );
			}
			$modules = ModuleSample::getModules();

			
			if( method_exists("ModuleSample", "getTables") ){

				$infotables = ModuleSample::getTables();
				$output = array();
				$ctables = array();

				foreach( $infotables as $module => $tables ){

					foreach( $tables as $tableName => $table ){

						$sql = " SHOW TABLES LIKE '".DB_PREFIX.$table['table']."'";
						$query = $this->db->query( $sql );
						$sql = array();
						if( count($query->rows) <=0 ){ 
							continue;
						}	
						// export sql database structures
						$sql = ' SHOW CREATE TABLE  '.DB_PREFIX.$table['table'];
						$query = $this->db->query( $sql );
						$row =  $query->row;
					
						if( isset($row['Create Table']) ){
							$tmp = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS ", $row['Create Table'] );
							$tmp = str_replace( DB_PREFIX, '".DB_PREFIX."', $tmp );
							$ctables[] = '$query[\''.$module.'\'][]="'.$tmp.'";'."\r\n\r\n"; 
						}
						// export data;
						$sql = ' SELECT * FROM '.DB_PREFIX.$table['table'];

						if( isset($table['lang']) && $table['lang'] ){
							$sql .= ' WHERE language_id='.(int)$this->config->get('config_language_id') ;
						}

						$query = $this->db->query( $sql );
						$rows =  $query->rows;
					
						if( $rows ){
							
							foreach( $rows as   $row ){
								$fs = array();
								$vs = array();
								
								foreach( $row as $key => $value ){ 
									$fs[] = $key;
									if( $key == 'language_id' ){
										$value="LANGUAGEID";
									}
									$vs[] = "'".$this->db->escape( $value )."'";
								}

								$output[] = ' $query[\''.$table['table'].'\'][]="INSERT INTO ".DB_PREFIX."'.$table['table'].'( `'.implode( "`,`", $fs).'` ) VALUES('.implode(", ",  $vs).')"; '. "\r\n" ;	
							}

						}

					}
				}

	

				if( !empty($ctables) ){
					$string = "<?php \r\n \r\n ".implode( ' ', $ctables ) ." ?>";  
					$fp = fopen( dirname($dir).'/query-tables.php', 'w');
					fwrite($fp, $string );
					fclose($fp);
				}


				if( !empty($output) ){
					$string = "<?php \r\n \r\n ".implode( ' ', $output ) ." ?>";  
					$fp = fopen( dirname($dir).'/query-data.php', 'w');
					fwrite($fp, $string );
					fclose($fp);
				}
		 	}
			
			if( isset($modules) && isset($this->request->get['mods']) ){
				foreach( $modules as $module ){
					$data = serialize($this->config->get($module . '_module'));
					$fp = fopen( $dir.$module.'.php', 'w');
					fwrite($fp, $data );
					fclose($fp);
				}
		
			}

			$output = $this->_exportProfiles( $theme );
			$fp = fopen( dirname($dir).'/profile.txt', 'w');
			fwrite($fp, serialize($output) );
			fclose($fp);
		}
	}

	/**
	 *
	 */
	public function backup( $theme ){
		
		$expdir = DIR_CACHE.'backup_'.trim($theme).'/';
		
		if( !is_dir($expdir) ){
			mkdir( $expdir, 0777 );
		}


		if( is_file(dirname(__FILE__).'/'.$theme.'/sample.php') ) {
			require( dirname(__FILE__).'/'.$theme.'/sample.php' );
			$dir =  $expdir;
			$modules = ModuleSample::getModules();
			if( isset($modules) ){
				foreach( $modules as $module ){
					$data = serialize($this->config->get($module . '_module'));
					$fp = fopen( $dir.$module.'.php', 'w');
					fwrite($fp, $data );
					fclose($fp);
				}
		
			}
		}
		return ;
	}

	/**
	 *
	 */
	public function getBackupByTheme( $theme ){
		$output = array();

		$files = glob(  DIR_CACHE.'backup_'.trim($theme).'/*.php');
		if( $files ){
			foreach( $files as $dir ){
				$module = str_replace(".php","",basename( $dir ));
				$output[$module] = $module;
			}
		}	
		return $output;
	}

	/**
	 *
	 */
	public function restoreDataModule( $theme, $module ){
		$this->load->model('setting/setting');
		$dir = DIR_CACHE.'backup_'.trim($theme).'/';
		if( is_file($dir.$module.'.php') ){
			$data = unserialize(file_get_contents( $dir.$module.'.php' ));
			if( is_array($data) ){
				$output = array();
				$output[$module."_module"] = $data; 
				$this->model_setting_setting->editSetting( $module, $output );	
			}
		}	 
	}
	
	/**
	 *
	 */
	public function isTableExisted( $table ){
		$sql = " SHOW TABLES LIKE '".DB_PREFIX.$table."'";

		$query = $this->db->query( $sql );
		$sql = array();

		return count($query->rows);
	}

	/**
	 * install sample query
	 */
	public function installSampleQuery( $theme, $module ){
		if( is_file(dirname(__FILE__).'/'.$theme.'/sample.php') ) {
			require( dirname(__FILE__).'/'.$theme.'/sample.php' );
			$dir = dirname(__FILE__).'/'.$theme.'/';
			
			/* execute SQL queries */
			$query =  ModuleSample::getModulesQuery();
			$modules = array();
			
			$checked = true;

			if( $module == 'pavblog'){
				$sql = " SELECT * FROM `".DB_PREFIX."layout` WHERE `name` LIKE '%Pav%'";
				$sq = $this->db->query( $sql );
		 		$checked = count($sq->rows)?false:true;
			}
 
			if( isset($query[$module])){
				foreach( $query[$module] as $query ){
					$this->db->query( $query );
				}
			}

			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();

			if( method_exists("ModuleSample", "getTables") ){
				$tables = ModuleSample::getTables();

				if( is_file(dirname(__FILE__).'/'.$theme.'/query-data.php') ){

					$query = array();
					require( dirname(__FILE__).'/'.$theme.'/query-data.php' );

					if(  isset($tables[$module]) && !empty($query) ){

						foreach( $tables[$module] as $table => $info ){

							if( isset($query[$table]) ) {
								$sql = ' SELECT * FROM '.DB_PREFIX.$table.'';
								$sq = $this->db->query( $sql );
								if( count($sq->rows) <= 0 ){
									if( isset($info['lang']) && (int)$info['lang'] ){
										foreach( $languages as $language ){
											foreach( $query[$table] as $s ){
												$this->db->query( str_replace( 'LANGUAGEID', $language['language_id'], $s ) );
											}
										}
									}else{
										foreach( $query[$table] as $s ){
											$this->db->query( $s );
										}
									}
								}	
							}
						}			 
					}
				}
			}	
			return ('done');
		}			
		return( 'could not install data sample for this' );
	}

	/**
	 * install store sample
	 */
	public function installStoreSample( $theme ){
		if( is_file(dirname(__FILE__).'/'.$theme.'/sample.php') ) {
			require( dirname(__FILE__).'/'.$theme.'/sample.php' );
			$dir = dirname(__FILE__).'/'.$theme.'/';
			$configs = ModuleSample::getStoreConfigs();
			//echo "<pre>"; print_r($configs); 
			if( isset($configs) ){
				$this->load->model('setting/setting');
				foreach( $configs as $key => $value ){
					// $group = 'config'; // use for opencart 2.1 and 1.5
					$group = 'theme_default'; // use for opencart 2.2
					$store_id = 0;
					//echo "\n"; print_r("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "' WHERE `code` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'"); 
					$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "' WHERE `code` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
				}
			}
			
		}
	}
	
	/**
	 * install sample module
	 */
	public function installSample( $theme, $module ){
		return ;
		$this->load->model('setting/setting');
		$dir = dirname(__FILE__).'/'.$theme.'/modules/'; 
		if( is_file($dir.$module.'.php') ){
			$data = unserialize(file_get_contents( $dir.$module.'.php' ));

			if( is_array($data) ){
				$output = array();
				$output[$module."_module"] = $data; 
				$output[$module."_status"] = 1; 
				$this->model_setting_setting->editSetting( $module, $output );	
			}
		}	 
	}
}
?>