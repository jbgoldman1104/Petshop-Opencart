<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogcomment 
 */
class ModelPavblogcomment extends Model { 

	public function getList( $limit="15", $order="created",$m="DESC" ){
		$sql = 'SELECT c.*,bd.title FROM '.DB_PREFIX.'pavblog_comment c LEFT JOIN '
				. DB_PREFIX.'pavblog_blog b ON b.blog_id=c.blog_id LEFT JOIN '
				. DB_PREFIX.'pavblog_blog_description bd ON bd.blog_id=b.blog_id AND language_id='.(int)$this->config->get('config_language_id')
				.' ORDER BY '.$order.' '.$m;
		
		
		$query = $this->db->query( $sql ); 
		$data = $query->rows;
		
		return $data;
	}
	
	public function getComment( $id ){
		$sql = 'SELECT * FROM '.DB_PREFIX.'pavblog_comment WHERE comment_id='.$id;
		$query = $this->db->query( $sql ); 
		return (array)$query->row;
	}
	public function getNewest(){
		return $this->getList( 15 );
	}
	
	public function saveComment( $data ){
		$sql = 'UPDATE '.DB_PREFIX.'pavblog_comment SET comment="'.$this->db->escape($data['comment']).'", `status`='.(int)$data['status'];
		$sql .= ' WHERE comment_id='.(int)$data['comment_id'];

		$this->db->query( $sql );
		return $data['comment_id'];
	}
	
	public function savePublished( $comment_id, $val ){
		$sql = 'UPDATE '.DB_PREFIX.'pavblog_comment SET `status`='.(int)$val;
		$sql .= ' WHERE comment_id='.(int)$comment_id;

		$this->db->query( $sql );
		return $comment_id;
	
	}
	public function delete( $id ){
		$sql = 'DELETE FROM '.DB_PREFIX.'pavblog_comment WHERE comment_id='.$id;
		$query = $this->db->query( $sql ); 
		return ;
	}
}

?>