<?php if( isset($links) ){ ?>
 <div class="widget-links  <?php echo $addition_cls ?>  <?php if( isset($stylecls)&&$stylecls ) { ?>-<?php echo $stylecls;?><?php } ?>">
	<?php if( isset($widget_heading)&&!empty($widget_heading) ){ ?>
	<h4 class="widget-heading">
		<?php echo $widget_heading; ?>
	</h4>
	<?php } ?>
	<div class="widget-inner clearfix">
		<div id="tabs<?php echo $id;?>" class="panel-group">
			<ul class="nav-links">
			  <?php foreach( $links as $key => $ac ) { ?>
			  <li ><a href="<?php echo $ac['link'];?>" ><?php echo $ac['text'];?></a></li>
			  <?php } ?>
			</ul>
		</div>
	</div>
</div>
<?php } ?>