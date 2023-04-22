<?php
/******************************************************
 * @package Pav blog module for Opencart 1.5.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @copyright   Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license     GNU General Public License version 2
 *******************************************************/

/**
 * class ModelPavblogcategory
 */
class ModelPavblogcategory extends Model {

    private $children;

    /**
     * Get List Admin Users
     */
    public function getUsers(){
        $sql = "SELECT * FROM `" . DB_PREFIX . "user`";
        $query = $this->db->query( $sql );
        $users = $query->rows;
        $output = array();
        foreach( $users as $user ){
            $output[$user['user_id']] = $user['username'];
        }
        return $output;
    }

    /**
     * Get Category Information by Id
     */
    public function getInfo( $id ){
        $sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'pavblog_category m LEFT JOIN '
            .DB_PREFIX.'pavblog_category_description md ON m.category_id=md.category_id AND language_id='.(int)$this->config->get('config_language_id') ;

        $sql .= ' WHERE m.category_id='.(int)$id;

        $query = $this->db->query( $sql );
        return $query->row;
    }

    /**
     * Get  Sub Categories by Parent ID
     */
    public function getChildren( $category_id ){

        $sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'pavblog_category m LEFT JOIN '
            .DB_PREFIX.'pavblog_category_description md ON m.category_id=md.category_id AND language_id='.(int)$this->config->get('config_language_id') ;

        $sql .= ' WHERE m.parent_id='.(int)$category_id . ' ORDER BY position ' ;

        $query = $this->db->query( $sql );
        return $query->rows;
    }

    /**
     * Get  Sub Categories by Parent ID
     */
    public function getChild( $id=null ){
        $sql = ' SELECT m.*, md.title,md.description FROM ' . DB_PREFIX . 'pavblog_category m LEFT JOIN '
            .DB_PREFIX.'pavblog_category_description md ON m.category_id=md.category_id AND language_id='.(int)$this->config->get('config_language_id') ;
        if( $id != null ) {
            $sql .= ' WHERE parent_id='.(int)$id;
        }
        $sql .= ' ORDER BY `position`  ';
        $query = $this->db->query( $sql );
        return $query->rows;
    }

    /**
     * get full tree menu built in with HTML
     */
    public function getTree( $id=null, $category_id = 0){

        $childs = $this->getChild( $id );

        foreach($childs as $child ){
            $this->children[$child['parent_id']][] = $child;
        }
        $parent = 1 ;
        $output = $this->genTree( $parent, 1, '', $category_id);
       
        return $output;
    }
    public function genTree( $parent, $level , $class="", $category_id ){
        if( $this->hasChild($parent) ){
            $data = $this->getNodes( $parent );
            $t = $class;
            $output = '<ul class="level'.$level. " ".$t.' ">';
            
            foreach( $data as $menu ){
                $output .='<li >';
                    $output .= '<a href="'.$this->url->link('pavblog/category',"blogcategory_id=".$menu['category_id']).'" title="'.$menu['title'].'">'.$menu['title']."</a>";
                    if( $this->hasChild($menu['category_id']) ){
                        $output .= '<span class="head"><a style="float:right;" href="#">-</a></span>';
                    }
                $output .= $this->genTree( $menu['category_id'], $level+1, "", $menu['category_id']);
                
                $output .= '</li>';
            }   
            $output .= '</ul>';
            return $output;
        }
        return ;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    public function getTreeAccordion( $id=null, $category_id = 0 ){
        $childs = $this->getChild( $id );
        foreach($childs as $child ){
            $this->children[$child['parent_id']][] = $child;
        }
        $parent = 1 ;
        $output = $this->genTreeAccordion( $parent, 1, 'pav-category', $category_id );
        return $output;
    }
    public function genTreeAccordion( $parent, $level , $class="", $category_id){
        if( $this->hasChild($parent) ){
            $data = $this->getNodes( $parent );
            $t = $class;
            $output = '<ul class="list-group accordion level'.$level.' '.$t.'">';
            foreach( $data as $menu ){
                if ($level > 1) {
                    $active = ($menu['category_id'] == $category_id)?"active":'';
                } else {
                    $active = ($menu['category_id'] == $category_id)?"":'active';
                }
                
                $output .= '<li class="list-group-item">';
                $output .= '<a class="'.$active.'" href="'.$this->url->link('pavblog/category',"blogcategory_id=".$menu['category_id']).'" >';
                $output .= '<span class="blog-name">'.$menu['title'].'</span>';
                if( $this->hasChild($menu['category_id']) ){
                    if ($level > 1) {
                        $output .= '<i><span>-</span></i>';
                    } else {
                        $output .= '<i><span>+</span></i>';
                    }
                }
                $output .= '</a>';
                $output .= $this->genTreeAccordion( $menu['category_id'], $level+1, '', $category_id );
                $output .= '</li>';
            }
            $output .= '</ul>';
            return $output;
        }
        return ;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////
    public function getTreeVertical( $id=null, $category_id = 0 ){
        $childs = $this->getChild( $id );
        foreach($childs as $child ){
            $this->children[$child['parent_id']][] = $child;
        }
        $parent = 1 ;
        $output = $this->genTreeVertical( $parent, 1, '', $category_id );
        return $output;
    }
    public function genTreeVertical( $parent, $level , $class="", $category_id){
        if( $this->hasChild($parent) ){
            $data = $this->getNodes( $parent );
            $output = '<div class="level'.$level.' '.$class.'"><ul class="nav navbar-nav vertical">';
            foreach( $data as $menu ){
                

                if( $this->hasChild($menu['category_id']) ){
                    $output .= '<li class="parent dropdown-submenu">';
                    $output .= '<a class="dropdown-toggle" data-toggle="dropdown" href="'.$this->url->link('pavblog/category',"blogcategory_id=".$menu['category_id']).'" >';
                    $output .= '<span class="blog-name">'.$menu['title'].'</span>';
                    $output .= '<b class="caret"></b></a>';
                } else {
                    $output .= '<li>';
                    $output .= '<a href="'.$this->url->link('pavblog/category',"blogcategory_id=".$menu['category_id']).'" >'.$menu['title'].'</a>';
                }
                $output .= $this->genTreeVertical( $menu['category_id'], $level+1, 'dropdown-menu', $category_id );
                $output .= '</li>';
            }
            $output .= '</ul></div>';
            return $output;
        }
        return ;
    }

    public function hasChild( $id ){
        return isset($this->children[$id]);
    }

    public function getNodes( $id ){
        return $this->children[$id];
    }
}
?>