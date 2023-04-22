<div class="widget">
    <?php if( $show_title ) { ?>
        <div class="widget-heading panel-heading block-borderbox">
            <h4 class="panel-title"><?php echo $heading_title?></h4>
        </div>
    <?php } ?>
    <div class="widget-inner introduce <?php echo $addition_cls;?> <?php if (isset($stylecls)&&$stylecls){echo "block-".$stylecls;}?>">

        <div class="introduce-banner">

            <div class="text-center media-introduce">
                <div class="image-item text-center">
                    <?php if($thumbnailurl){ ?>
                            <img class="img-responsive" src="https://shop.phillipspet.com/storefrontCommerce/imageContent.do?contentKey=3ad57be3-0140-47db-8757-b90468a65245&size=PRIMARY&fileName=291219.jpg" alt="">
                    <?php }elseif($id_video){ ?>
                            <iframe width="<?php echo $width;?>" height="<?php echo $height;?>" src="https://www.youtube.com/embed/<?php echo $id_video;?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    <?php } ?>
                </div>
            </div>
            <div class="content-introduce text-center">
                <div class="heading heading-v9">
                    <?php if($iconclass){ ?>
                    <i class="fa <?php echo $iconclass;?>"></i>
                    <?php } ?>
                </div>
                <div class="detail space-30">
                    <?php if($content_html) { ?>
                    <?php echo $content_html; ?>
                    <?php }?>
                </div>
            </div>
        </div>

    </div>
</div>