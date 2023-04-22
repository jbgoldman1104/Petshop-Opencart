
<div class="widget-html panel-default box <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>box-<?php echo $stylecls;?><?php } ?>">
    <?php if($show_title && $heading_title) { ?>
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $heading_title?></h3>
    </div>
    <?php } ?>
    <?php echo htmlspecialchars_decode( $html ); ?>
</div>
