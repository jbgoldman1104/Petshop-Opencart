<?php 
/**
 * class ModelPavnewsletterTemplate 
 */
class ModelPavnewsletterTemplate extends Model { 
	
	public function getTemplates($data = array()){
		$sql = "SELECT * FROM ".DB_PREFIX."pavnewsletter_template LIMIT 0,20";
		$query = $this->db->query($sql);
		return $query->rows;
	}
	public function getTemplate($template_id){
		$data = array();
		if(!empty($template_id)){
			$sql = "SELECT t.* FROM ".DB_PREFIX."pavnewsletter_template AS t 
					WHERE t.template_id = ".$template_id;
			$query =  $this->db->query($sql);
			if($query->num_rows > 0){
				$data = $query->row;
				$sql2 = "SELECT td.* FROM ".DB_PREFIX."pavnewsletter_template_description AS td WHERE td.template_id = ".$template_id;
				$query = $this->db->query($sql2);

				$data2 = ($query->num_rows > 0)?$query->rows:array();
				$languages = array();
				if($data2){
					foreach($data2 as $language){
						$languages[$language["language_id"]] = $language;
					}	
				}
				$data["template_description"] = $languages;
				
			}
		}
		return $data;
	}
	public function insertTemplate($data = array()){
		if(!empty($data["template"]["template_id"])){
			$sql = "UPDATE ".DB_PREFIX."pavnewsletter_template SET ";
			$tmp = array();
			foreach( $data["template"] as $key => $value ){
				if( $key != "template_id" ){
					$tmp[] = "`".$key."`='".$this->db->escape($value)."'";
				}
			}
			$tmp[]=" date_modified = NOW() ";
			$sql .= implode( " , ", $tmp );
			$sql .= " WHERE `template_id`=".$data["template"]["template_id"];
			$this->db->query($sql);
			$template_id = $data["template"]["template_id"];
		}else{
			$sql = "INSERT INTO ".DB_PREFIX."pavnewsletter_template ( `";

			$tmp = array();
			unset($data["template"]["template_id"]);
			$vals = array();
			foreach( $data["template"] as $key => $value ){
				$vals[] = $this->db->escape($value);
				$tmp[] = $key;
			}
			$sql .= implode("` , `",$tmp)."`,`date_added`) VALUES ('".implode("','",$vals)."',NOW()) ";
			
			$this->db->query($sql);
			$template_id = $this->db->getLastId();
		}
		if(!empty($template_id)){
			$sql = "DELETE FROM ".DB_PREFIX."pavnewsletter_template_description WHERE `template_id`=".$template_id;
			$this->db->query($sql);
			$sql = "INSERT INTO ".DB_PREFIX."pavnewsletter_template_description ( `template_id`,`language_id`,`subject`,`template_message` ) VALUES ";

			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			$tmp = array();
			foreach ($languages as $language) {
				$tmp[] = "(".$this->db->escape($template_id).",".$this->db->escape($language['language_id']).",'".$this->db->escape($data['template_description']['subject'][$language['language_id']])."','".$this->db->escape($data['template_description']['template_message'][$language['language_id']])."')";
			}
			$sql .= implode(",", $tmp).";";
			$this->db->query($sql);
			return true;
		}
		return false;
		
	}
	public function delete($templates = array()){
		$check = false;
		if(!empty($templates)){
			
			foreach($templates as $template){
				$sql = "DELETE FROM ".DB_PREFIX."pavnewsletter_template WHERE template_id = ".(int)$template;
				$sql2 = "DELETE FROM ".DB_PREFIX."pavnewsletter_template_description WHERE template_id=".(int)$template;
				if($this->db->query($sql) && $this->db->query($sql2)){
					$check = true;
				}
			}
		}
		return $check;
	}
	public function copy($templates = array()){
		if(!empty($templates)){
			$check = false;
			foreach($templates as $template){
				$sql = "SELECT t.* FROM ".DB_PREFIX."pavnewsletter_template AS t
						 WHERE t.template_id=".$template;
				$query = $this->db->query($sql);
				$data = array();
				if($query->num_rows){
					
					$data["template"] = $query->row;
					$data["template_description"] = array();
					unset($data["template"]["template_id"]);
					unset($data["template"]["date_added"]);
					unset($data["template"]["date_modified"]);
					$sql = "SELECT td.language_id,td.subject,td.template_message FROM ".DB_PREFIX."pavnewsletter_template_description AS td
							WHERE td.template_id = ".$template;
					$query2 = $this->db->query($sql);
					if($query2->num_rows){
						foreach($query2->rows as $row){
							$data["template_description"]['subject'][$row["language_id"]] = $row["subject"];
							$data["template_description"]['template_message'][$row["language_id"]] = $row["template_message"];
						}
					}
					
				}

				if(!empty($data) && $this->insertTemplate($data)){
					$check = true;
				}

			}
			return $check;
		}
		return false;
	}
	
}