<?php if( isset($flickr_id) ) { ?>
<div class="widget-blogs  <?php $addition_cls?> <?php if ( isset($stylecls)&&$stylecls) { ?>-<?php echo $stylecls; ?><?php } ?>">
	<?php if( $show_title ) { ?>
	<div class="widget-heading -heading"><?php echo $heading_title?></div>
	<?php } ?>
	<div class="widget-inner block_content">

		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $flickr_photos;?>&amp;display=<?php echo $flickr_display;?>&amp;size=s&amp;layout=x&amp;source=<?php echo $flickr_type;?>&amp;<?php echo $flickr_type;?>=<?php echo $flickr_id;?>"></script>
		</br>

		<p class="flickr_stream_wrap">
			<a class="btn btn-success btn-sm" href="http://www.flickr.com/photos/<?php echo $flickr_id;?>">View details</a>
		</p>

	</div>
</div>
<?php  }  ?>