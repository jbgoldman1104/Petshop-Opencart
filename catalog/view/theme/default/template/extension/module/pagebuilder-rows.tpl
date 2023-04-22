<?php foreach ( $rows as $row2) {  ?>
<div class="row row-level-<?php echo $row2->level; ?> <?php echo $row2->sfxcls?>">
	<div class="row-inner clearfix" >
        <?php foreach( $row2->cols as $col2 ) { ?>
            <div class="col-lg-<?php echo $col2->lgcol; ?> col-md-<?php echo $col2->mdcol;?> col-sm-<?php echo $col2->smcol;?> col-xs-<?php echo $col2->xscol;?> <?php echo $col2->sfxcls?>">
            	<div class="col-inner <?php echo $col2->cls;?>" <?php echo $col2->attrs?>>

            		 <?php foreach ( $col2->widgets as $widget ){ ?>
	                	<?php if( isset($widget->content) ) { ?>
	                     		<?php echo $widget->content; ?>
                   		<?php } ?>
	                <?php } ?>
            	</div>
        	</div>
        <?php } ?>
	</div>
</div>
<?php } ?>