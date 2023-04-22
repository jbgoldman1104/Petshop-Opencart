<?php $id = rand(); ?>

<?php ?>
<div class="box gallery">
    <div class="box-content">
		<div class="banner-img <?php echo $prefix; ?> row">
			<?php foreach( $banners as $banner ) { ?>
                <div class="col-sm-25">
                    <a href="<?php echo $banner['image'];?>" class="group<?php echo $id;?>" title="<?php echo $banner['title'];?>">
                    <img alt="" src="<?php echo $banner['thumb'];?>" title="<?php echo $banner['title'];?>">
                    </a>
                </div>
            <?php } ?>
		</div>
	</div>
</div> 
<script type="text/javascript">
$(document).ready(function() {
	$('.banner-img').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
</script>