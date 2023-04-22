<?php
class ModelSettingThemecontrol extends Model {
	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "'");

		return $query->rows;
	}

	public function getLayoutModules($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' ORDER BY `sort_order` ");

		return $query->rows;
	}

	public function checkModifycation(){
		return false;
	}
}
?>