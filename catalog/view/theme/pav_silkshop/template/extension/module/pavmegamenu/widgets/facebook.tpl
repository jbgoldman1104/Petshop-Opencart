
<div class="facebook-wrapper clearfix <?php echo $addition_cls ;?> <?php if ( isset($stylecls)&&$stylecls ){ ?>block-<?php echo $stylecls?><?php } ?>" style="width:<?php echo $width;?>" >
<?php if ( isset($application_id)&&$application_id ) { ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/{$displaylanguage}/all.js#xfbml=1&appId={$application_id}";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php } else { ?>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/{$displaylanguage}/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>

<div class="fb-like-" data-href="<?php echo $page_url ;?>" data-colorscheme="<?php echo $color ;?>" data-height="<?php echo $height ;?>" data-width="<?php echo $width ;?>" data-show-faces="<?php echo $show_faces ;?>" data-stream="<?php echo $show_stream ;?>" data-show-border="<?php echo $show_border ;?>" data-header="<?php echo $show_header ;?>"></div>
</div>
 