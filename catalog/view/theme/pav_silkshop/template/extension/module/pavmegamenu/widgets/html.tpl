
<div class="widget-html  <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>-<?php echo $stylecls;?><?php } ?>">
    <?php if( $show_title ){ ?>
    <h4 class="widget-heading title">
        <?php echo $heading_title; ?>
    </h4>
    <?php } ?>
	<div class="widget-inner -content clearfix">
		 <?php echo html_entity_decode( $html ); ?>
	</div>
</div>
