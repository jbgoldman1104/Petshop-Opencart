<div class="call-to-action <?php echo $style;?>">
    <div class="call-to-action-inner">
    	<?php if(isset($widget_heading)&&!empty($widget_heading)) {?>
		<div class="<?php if($style == 'call-to-action-v2'){ echo "heading-v9"; }elseif($style == 'call-to-action-v4 light-style'){ echo "heading-v3 heading-light";}elseif($style == ''){ echo "";} ?>">
			<?php if($style == 'light-style'){?>
				<?php if(isset($iconurl) && $iconfile){?>
					<img class="fa" src="<?php echo $iconurl;?>" alt="<?php echo $widget_heading;?>">
				<?php }elseif($iconclass){?>
					<i class="fa <?php echo $iconclass;?>"></i>
				<?php } ?>
			<?php } ?>
            <?php if( $show_title ) { ?><h1><?php echo $widget_heading;?></h1><?php } ?>
        </div>
		<?php }?>
        <p><span><?php echo html_entity_decode($htmlcontent, ENT_QUOTES, 'UTF-8'); ?></span></p>
    </div>
    <?php if($text_link_1 || $text_link_2){?>
    <div class="call-to-action-inner action-button">
    	<?php if($text_link_1){?>
        	<a class="btn btn-sm btn-primary radius-3x" href="<?php echo $link_1;?>"><?php echo $text_link_1;?></a>
        <?php }?>
        <?php if($text_link_2) {?>
        	<a class="btn btn-sm btn-primary radius-5x" href="<?php echo $link_2;?>"><?php echo $text_link_2;?></a>
        <?php }?>
    </div>
    <?php }?>
</div>