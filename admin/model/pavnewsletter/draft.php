<?php

class ModelPavnewsletterDraft extends Model {

	// pavo 2.2 edited
	public function getTotalEmail() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pavnewsletter_subscribe");
		return $query->row['total'];
	}

	public function getEmails() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pavnewsletter_subscribe");
		return $query->rows;
	}

	public function deletedraft($draft_id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "pavnewsletter_draft WHERE draft_id = '" . (int)$draft_id . "'");
	}

	public function getTotalDraft() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pavnewsletter_draft");
		return $query->row['total'];
	}

	public function getDraft($draft_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pavnewsletter_draft WHERE draft_id = " . (int)$draft_id);
		return $query->row;
	}

	public function getDrafts($data = array()) {

		$sql = "SELECT * FROM " . DB_PREFIX . "pavnewsletter_draft";

		if (!empty($data['filter_name'])) {
			$sql .= " AND subject LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'subject',
			'to'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY to";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function savebasic($data){

		$tmp =  array(
			'draft_id'          => 0,
			'store_id'          => 0,
			'to'                => 'list_subscribes',
			'customer_group_id' => '1',
			'customers'         => '',
			'affiliates'        => '',
			'products'          => '',
			'subject'           => '',
			'message'           => '',
			'files'             => '',
		);
		$data = array_merge( $tmp, $data );

		if (isset($data['draft_id']) && $data['draft_id'] != 0) {
			$this->db->query("UPDATE " . DB_PREFIX . "pavnewsletter_draft SET 
				`to` = '" . $this->db->escape($data['to']) . "', 
				`store_id` = '" . (int)$data['store_id'] . "', 
				`subject` = '" . $this->db->escape($data['subject']) . "', 
				`message` = '" . $this->db->escape($data['message']) . "',
				`customer_group_id`= " . (int)$data['customer_group_id'] . ",
				`affiliate` = '" . $this->db->escape((isset($data['affiliates']) && $data['to'] == 'affiliate') ? serialize($data['affiliate']) : '') . "',
				`customer` = '". $this->db->escape((isset($data['customers']) && $data['to'] == 'customer') ? serialize($data['customer']) : '') . "',
				`product` = '" . $this->db->escape((isset($data['products']) && $data['to'] == 'product') ? serialize($data['product']) : '') . "'
				WHERE `draft_id` = " . (int)$data['draft_id']);

		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pavnewsletter_draft SET 
				`date_added` = NOW(),
				`to` = '" . $this->db->escape($data['to']) . "',
				`store_id` = '" . (int)$data['store_id'] . "',
				`subject` = '" . $this->db->escape($data['subject']) . "',
				`message` = '" . $this->db->escape($data['message']) . "',
				`customer_group_id` = ".(int)$data['customer_group_id'] . ",
				`affiliate` = '" . $this->db->escape((isset($data['affiliate']) && $data['to'] == 'affiliate') ? serialize($data['affiliate']) : '') . "',
				`customer` = '" . $this->db->escape((isset($data['customers']) && $data['to'] == 'customer') ? serialize($data['customer']) : '') . "',
				`product` = '" . $this->db->escape((isset($data['products']) && $data['to'] == 'product') ? serialize($data['product']) : '') . "'");
			//$data['draft_id'] = $this->db->getLastId();
		}
		//return $data['draft_id'];
	}
	// pavo 2.2 end edited
	
	public function getTotal($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "pavnewsletter_email` WHERE 1=1";
		
		if (isset($data['filter_date']) && !is_null($data['filter_date'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date']) . "')";
		}
		
		if (isset($data['filter_subject']) && !is_null($data['filter_subject'])) {
			$sql .= " AND LCASE(subject) LIKE '" . $this->db->escape(mb_strtolower($data['filter_subject'], 'UTF-8')) . "%'";
		}

		if (isset($data['filter_to']) && !is_null($data['filter_to'])) {
			$sql .= " AND `to` = '" . $this->db->escape($data['filter_to']) . "'";
		}

		if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
			$sql .= " AND `store_id` = '" . (int)$data['filter_store'] . "'";
		}
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}

	public function getList($data = array()) {
		if ($data) {
			$sql = "SELECT `email_id`, `subject`, `date_added`, `to`, `store_id` FROM " . DB_PREFIX . "pavnewsletter_email WHERE 1=1"; 
			
			if (isset($data['filter_date']) && !is_null($data['filter_date'])) {
				$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date']) . "')";
			}

			if (isset($data['filter_subject']) && !is_null($data['filter_subject'])) {
				$sql .= " AND LCASE(subject) LIKE '" . $this->db->escape(mb_strtolower($data['filter_subject'], 'UTF-8')) . "%'";
			}

			if (isset($data['filter_to']) && !is_null($data['filter_to'])) {
				$sql .= " AND `to` = '" . $this->db->escape($data['filter_to']) . "'";
			}

			if (isset($data['filter_store']) && !is_null($data['filter_store'])) {
				$sql .= " AND `store_id` = '" . (int)$data['filter_store'] . "'";
			}
			
			$sort_data = array(
				'email_id',
				'subject',
				'date_added',
				'to',
				'store_id'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY `" . $data['sort'] . "`";	
			} else {
				$sql .= " ORDER BY date_added";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
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
			
			$query = $this->db->query($sql);
			
			$results = $query->rows;
			
			return $results;
		} else {
			return false;
		}
	}

	public function detail($email_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pavnewsletter_email WHERE email_id = '" . (int)$email_id . "'"); 
		$data = $query->row;

		if ($data) {
			$path = dirname(DIR_DOWNLOAD) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'pavdraft_' . $data['email_id'];
			if (file_exists($path) && is_dir($path)) {
				$data['attachments'] = $this->attachments($path);
			} else {
				$data['attachments'] = array();
			}
		}

		$data['customer'] = unserialize($data['customer']);
		$data['affiliate'] = unserialize($data['affiliate']);
		$data['product'] = unserialize($data['product']);
		$data['defined_product'] = unserialize($data['defined_products']);
		$data['defined_product_more'] = unserialize($data['defined_products_more']);
		$data['defined_category'] = unserialize($data['defined_categories']);

		return $data;
	}



	public function save($data) {

		$tmp =  array(
			'template_id'=>0,
			'defined_product' => '',
			'defined_category' => '',
			'defined' => '',
			'defined_categories' => '',
			'defined_product_more' => '',
			'defined_products' => '',
		);
		$data = array_merge( $tmp, $data );

		if (isset($data['id']) && $data['id']) {
			$this->db->query("UPDATE " . DB_PREFIX . "pavnewsletter_email SET `to` = '" . $this->db->escape($data['to']) . "', store_id = '" . (int)$data['store_id'] . "', `template_id` = ".(int)$data['template_id'].",`language_id`= ".(int)$data['language_id'].", `subject`='".$this->db->escape($data['subject'])."', `message`='".$this->db->escape($data['message'])."',`customer_group_id`=".(int)$data['customer_group_id'].",`affiliate`='".$this->db->escape((isset($data['affiliate']) && $data['to'] == 'affiliate') ? serialize($data['affiliate']) : '')."',`customer`='". $this->db->escape((isset($data['customer']) && $data['to'] == 'customer') ? serialize($data['customer']) : '') ."', `product` = '" . $this->db->escape((isset($data['product']) && $data['to'] == 'product') ? serialize($data['product']) : '') . "', defined = '" . $this->db->escape($data['defined']) . "', special = '" . $this->db->escape($data['special']) . "',  latest = '" . $this->db->escape($data['latest']) . "',popular = '" . $this->db->escape($data['popular']) . "', `defined_categories` = '" . $this->db->escape(isset($data['defined_category']) ? serialize($data['defined_category']) : '') . "', categories = '" . $this->db->escape($data['defined_categories']) . "',`defined_products_more` = '" . $this->db->escape(isset($data['defined_product_more']) ? serialize($data['defined_product_more']) : '') . "', `defined_products` = '" . $this->db->escape(isset($data['defined_product']) ? serialize($data['defined_product']) : '') . "', `only_selected_language` = '" . (int)$data['only_selected_language'] . "'WHERE `email_id`=".(int)$data['id']);
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pavnewsletter_email SET `date_added`=NOW(),`to` = '" . $this->db->escape($data['to']) . "', store_id = '" . (int)$data['store_id'] . "', `template_id` = ".(int)$data['template_id'].",`language_id`= ".(int)$data['language_id'].", `subject`='".$this->db->escape($data['subject'])."', `message`='".$this->db->escape($data['message'])."',`customer_group_id`=".(int)$data['customer_group_id'].",`affiliate`='".$this->db->escape((isset($data['affiliate']) && $data['to'] == 'affiliate') ? serialize($data['affiliate']) : '')."',`customer`='". $this->db->escape((isset($data['customer']) && $data['to'] == 'customer') ? serialize($data['customer']) : '') ."', `product` = '" . $this->db->escape((isset($data['product']) && $data['to'] == 'product') ? serialize($data['product']) : '') . "', defined = '" . $this->db->escape($data['defined']) . "', special = '" . $this->db->escape($data['special']) . "',  latest = '" . $this->db->escape($data['latest']) . "',popular = '" . $this->db->escape($data['popular']) . "', `defined_categories` = '" . $this->db->escape(isset($data['defined_category']) ? serialize($data['defined_category']) : '') . "', categories = '" . $this->db->escape($data['defined_categories']) . "',`defined_products_more` = '" . $this->db->escape(isset($data['defined_product_more']) ? serialize($data['defined_product_more']) : '') . "', `defined_products` = '" . $this->db->escape(isset($data['defined_product']) ? serialize($data['defined_product']) : '') . "', `only_selected_language` = '" . (int)$data['only_selected_language'] . "'");
			$data['id'] = $this->db->getLastId();
		}
		return $data['id'];
	}

	public function delete($email_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pavnewsletter_email WHERE email_id = '" . (int)$email_id . "'");

		$path = dirname(DIR_DOWNLOAD) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'pavdraft_' . $email_id;
		if (file_exists($path) && is_dir($path)) {
			$this->rrmdir($path);
		}
	}

	private function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file)) {
				$this->rrmdir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dir);
	}

	private function attachments($dir) {
		$attachments = array();

		$files = (array) glob($dir);
		if (!empty($files))
			foreach ($files as $file) {
				$attachments[] = array(
					'filename' => basename($file),
					'path'     => $file
				);
			}

		return $attachments;
	}
}

?>