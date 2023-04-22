<?php if (isset($widget_heading) && !empty($widget_heading)) {?>
<div class="widget-accordion hidden-xs hidden-sm <?php echo $addition_cls;?> <?php if (isset($stylecls)&&$stylecls){echo "block-".$stylecls;}?>">
	<div class="space-padding-tb-40">
        <div class="box-heading">
            <div class="heading text-center <?php if ($headingstyle != 'heading-icon' && $headingstyle) { echo $headingstyle;} ?>">
                <?php if($headingstyle == 'heading-icon' && isset($iconurl) && $iconfile) { ?>
					<img class="fa" src="<?php echo $iconurl;?>" alt="<?php echo $widget_heading;?>">
				<?php }elseif($iconclass){ ?>
					<i class="fa <?php echo $iconclass;?>"></i>
				<?php } ?>
				<?php if($sub_title){?><span><?php echo $sub_title;?></span><?php }?>
                <?php if( $show_title ) { ?>
                    <h3 class="panel-title"><span><?php echo $widget_heading; ?></span></h3>
                <?php } ?>
                <?php if($content_html) {?>
                	<small><?php echo $content_html; ?></small>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php } ?>