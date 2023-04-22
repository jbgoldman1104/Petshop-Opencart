<?php 

/******************************************************
 * @package Pavo Opencart Theme Framework for Opencart 1.5.x
 * @version 3.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) May 2014 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

if(!class_exists("PavoLayoutPositions") ) {	
	class PavoLayoutPositions{ 
		public static function getList(){
			return array( 
			  'mainmenu',
			  'slideshow',
			  'promotion',
			  'showcase',
			  'content_top',
			  'column_left',
			  'column_right',
			  'content_bottom',
			  'mass_bottom_top',
			  'mass_bottom',
			  'footer_top',
			  'footer_center',
			  'footer_bottom',
			); 
		}
	}	
}	
?>