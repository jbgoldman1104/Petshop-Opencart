<?php 
class ModelPavblogSeo extends Model {	
	
	public function getKeyword( $uquery ){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape( $uquery ) . "'");
		return $query->row;
	}
	
	public function saveKeyword( $uquery, $keyword ){
		$this->delete( $uquery );
		$query = "INSERT INTO  ".DB_PREFIX."url_alias(`query`,`keyword`) VALUES('".$this->db->escape($uquery)."','".$this->db->escape($keyword)."') ";
		return $this->db->query( $query );

	}

	public function delete( $uquery ){
		return $query = $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape( $uquery ) . "'");
	}
}
?>