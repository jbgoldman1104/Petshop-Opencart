<?php
/******************************************************
 * @package  : Pav Popular tags module for Opencart 1.5.x
 * @version  : 1.0
 * @author   : http://www.pavothemes.com
 * @copyright: Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license  : GNU General Public License version 1
*******************************************************/
?>
<div class="panel panel-default pavpopulartag <?php echo $prefix; ?>">
	<div class="panel-heading block-borderbox">
		<h4 class="panel-title"><?php echo $heading_title; ?></h4>
	</div>
	<div class="panel-body">
		<?php if($data) { ?>
			<?php echo $data; ?>
		<?php } else { ?>
			<?php echo $text_notags; ?>
		<?php } ?>
	</div>
</div>
