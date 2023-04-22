 <?php if ( isset($accordions) ) { ?>
<div class="widget-accordion  <?php $addition_cls?> <?php if ( isset($stylecls)&&$stylecls) { ?>-<?php echo $stylecls; ?><?php } ?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading -heading"><?php echo $heading_title?></div>
	<?php } ?>
	<div class="widget-inner -content">	<div id="accordion<?php $id?>" class="panel-group">
	 	<?php foreach ( $accordions as $key => $ac ) { ?>
		
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h4 class="panel-title">
				      <a href="#collapseAc<?php $id?><?php $key?>" data-parent="#accordion<?php $id?>" data-toggle="collapse" class="accordion-toggle collapsed">
				       	<?php echo $ac['header'];?>  
				      </a>
				    </h4>
				  </div>
				  <div class="panel-collapse collapse <?php if ( $key==0 ) { ?> in <?php } else { ?> out<?php } ?>" id="collapseAc<?php echo $id?><?php echo $key; ?>"  >
				    <div class="panel-body">
				      <?php echo $ac['content'];?>  
				    </div>
				  </div>
				</div>
			
	 	<?php } ?>
	</div>	</div>
</div>
<?php } ?>


