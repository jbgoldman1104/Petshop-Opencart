<div class="interactive-banner interactive-banner-<?php echo $banner_type;?> <?php echo $effect_type;?> <?php echo $position;?>">
	<div class="interactive-banner-body">
        <?php if($thumbnailurl){?><img alt="" src="<?php echo $thumbnailurl;?>" class="img-responsive"><?php }?>
        <div class="interactive-banner-profile text-center">
        	<div class="banner-title">
        		<?php if($sub_title){?><small><?php echo $sub_title;?></small><?php }?>
            	<?php if( $show_title ) { ?>
					<h2><?php echo $heading_title?></h2>
				<?php } ?>
        	</div>
        	<div class="light-style">
				<?php if($facebook_use){?>
                    <a href="https://www.facebook.com/<?php echo $facebook_use?>"><i class="icons icons-bodered radius-x fa fa-facebook"></i></a>
                    <?php }?>
                    <?php if($twitter_id){?>
                    <a href="https://twitter.com/<?php echo $twitter_id;?>"><i class="icons icons-bodered radius-x fa fa-twitter"></i></a>
                    <?php }?>
                    <?php if($pinterest_user){?>
                    <a href="https://www.pinterest.com/<?php echo $pinterest_user?>"><i class="icons icons-bodered radius-x fa fa-pinterest"></i></a>
                    <?php }?>
                    <?php if($google_plus){?>
                    <a href="https://plus.google.com/u/0/<?php echo $google_plus;?>"><i class="icons icons-bodered radius-x fa fa-google"></i></a>
                    <?php }?>
                    <?php if($vimeo_user){?>
                    <a href="https://vimeo.com/<?php echo $vimeo_user;?>"><i class="icons icons-bodered radius-x fa fa-vimeo-square"></i></a>
                    <?php }?>
                    <?php if($youtube_user){?>
                    <a href="https://www.youtube.com/user/<?php echo $youtube_user;?>"><i class="icons icons-bodered radius-x fa fa-youtube-square"></i></a>
                    <?php }?>
			</div>
            <?php if($htmlcontent){echo $htmlcontent; }?>
        </div>
        <?php if($mask_link){?>
            <a class="mask-link" href="<?php echo $mask_link;?>"></a>
        <?php } ?>
    </div>
</div>

