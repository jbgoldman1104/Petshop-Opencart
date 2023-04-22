<?php
class ModelExtensionModule extends Model {
	public function addModule($code, $data) {

		
		if( $code == 'pavhomebuilder' || $code == 'pavbannerbuilder' ){  
			$setting =  @serialize($data);
		}else {
			$setting = $this->db->escape(json_encode($data)); 
		}


		$this->db->query("INSERT INTO `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($data['name']) . "', `code` = '" . $this->db->escape($code) . "', `setting` = '" . $setting . "'");
	}

	public function getLastId(){
		return $this->db->getLastId();
	}
	
	public function editModule($module_id, $data) { 
		

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . $this->db->escape($module_id) . "'");

		if( $query->row['code'] == 'pavhomebuilder' || $query->row['code'] == 'pavbannerbuilder' ){  
			$setting =  serialize( $data );
		}else {
			$setting = $this->db->escape(json_encode($data)); 
		}
 
		$this->db->query("UPDATE `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($data['name']) . "', `setting` = '" . $setting . "' WHERE `module_id` = '" . (int)$module_id . "'");
	}

	public function deleteModule($module_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . (int)$module_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '%." . (int)$module_id . "'");
	}
		
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . $this->db->escape($module_id) . "'");
	 
		if ($query->row) {
			if( $query->row['code'] == 'pavhomebuilder' || $query->row['code'] == 'pavbannerbuilder' ){  
				return @unserialize( trim($query->row['setting'])) ;
			}
			return json_decode($query->row['setting'], true);
		} else {
			return array();	
		}
	}
	
	public function getModules() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` ORDER BY `code`");

		return $query->rows;
	}	
		
	public function getModulesByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "' ORDER BY `name`");

		return $query->rows;
	}	
	
	public function deleteModulesByCode($code) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '" . $this->db->escape($code) . "' OR `code` LIKE '" . $this->db->escape($code . '.%') . "'");
	}	
}