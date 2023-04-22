<?php 
/**
 * class ModelPavnewsletterSubscribe 
 */
class ModelPavnewsletterSubscribe extends Model { 
	
	public function buildQuery($data = array(), $get_total = false){		
		if($get_total){
			$sql = "SELECT count(s.subscribe_id) AS total
				FROM ".DB_PREFIX."pavnewsletter_subscribe AS s
				LEFT JOIN ".DB_PREFIX."customer AS c ON s.customer_id = c.customer_id ";
		}else{
			$sql = "SELECT s.*,c.telephone,c.newsletter,c.customer_group_id,c.status,CONCAT(c.firstname, ' ', c.lastname) AS name 
				FROM ".DB_PREFIX."pavnewsletter_subscribe AS s
				LEFT JOIN ".DB_PREFIX."customer AS c ON s.customer_id = c.customer_id ";
		}
		$limit_start = 0;
		$limit_end = isset($data['limit'])?$data['limit']:20;
		if(isset($data['page'])){
			$limit_start = ((int)$data['page'] -1) * $limit_end;
			$limit_start = $limit_start < 0?0:$limit_start;
		}
		$limit = " LIMIT ".$limit_start.",".$limit_end;

		$array_sorts = array("name",
							 "email",
							 "customer_group_id",
							 "s.action",
							 "s.store_id");
		$sort = "name";
		$order = "ASC";
		if(isset($data['sort'])){
			$sort = in_array($data['sort'], $array_sorts)?$data['sort']:$sort;
			$order = (isset($data['order'])&&!empty($data['order']))?$data['order']:$order;
		}
		$ordering = " ORDER BY `".$sort."` ".$order;
		$where = array();
		if(isset($data['filter'])){
			foreach($data['filter'] as $key=>$val){
				if(($key == "name" || $key == "email")){
					if(strlen($val) < 3)
						continue;
					if($key =="name")
						$key = " CONCAT(c.firstname, ' ', c.lastname) ";
					else
						$key = " s.{$key} ";
					$where[] = " {$key} LIKE '%".$this->db->escape($val)."%'";
				}elseif($val != NULL && $val !=""){
					$where[] = " {$key}=".$this->db->escape($val);
				}
			}
		}
		if($get_total){
			$limit = "";
			$ordering = "";
		}
		
		$sql .= !empty($where)?" WHERE ".implode(" AND ",$where):"".$ordering.$limit;
		return $sql;
	}
	public function getTotalSubscribers($data = array()){
		$sql = $this->buildQuery($data, true);
		$query = $this->db->query($sql);
		if($query->num_rows >0){
			return $query->row['total'];
		}
		return 0;
	}
	public function getSubscribers($data = array()){		
		$sql = $this->buildQuery($data);
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getCustomerGroups() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cg.sort_order ASC, cgd.name ASC");
		
		return $query->rows;
	}
	public function updateAction($subscribe_id, $action = 1){
		$query = $this->db->query("UPDATE ".DB_PREFIX."pavnewsletter_subscribe SET `action`=".(int)$action." WHERE subscribe_id=".$subscribe_id);
		return true;
	}

	public function delete($subscribe_id){
		$this->db->query("DELETE FROM `" . DB_PREFIX . "pavnewsletter_subscribe` WHERE subscribe_id = '" . (int)$subscribe_id . "'");
	}
	
}