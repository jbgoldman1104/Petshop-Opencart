<?php 
/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 1.1
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php

/* configuration column width follow grid 12 of bootstrap framework 3 */
$column_left  = trim($column_left);
$column_right  = trim($column_right);
 
if( !empty($column_left) && !empty($column_right) ){
		$layout = 'full';
	} elseif( empty($column_left) && !empty($column_right) ){
		$layout = 'center-right';
	}elseif( !empty($column_left) && empty($column_right) ){
		$layout = 'center-left';
	}else {
		$layout = 'center';
	}
	
	$spans = array( 'full' 			=> array("3", "6", "3" ), /* for layout has left - center - right */
					'center-right'  => array("0", "9", "3" ), /* for layout has center - right */
					'center-left'   => array("3", "9", "0" ), /* for layout has left -center */
					'center'		=> array("0", "12", "0" ) /* for layout only have center */
	);
	$SPAN = $spans[$layout];
?>