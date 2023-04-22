<?php
class ModelExtensionModule extends Model {
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$module_id . "'");
		
		if ($query->row) { 	 
			if( $query->row['code'] == 'pavhomebuilder' || $query->row['code'] == 'pavbannerbuilder' ){  
				return unserialize($query->row['setting']);
			}
			return json_decode($query->row['setting'], true);
		} else {
			return array();	
		}
	}		
}