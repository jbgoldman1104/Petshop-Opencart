<?php 
	$typoFile = HTTP_CATALOG."catalog/view/theme/default/stylesheet/sliderlayer/css/typo.css";	
	if( file_exists( DIR_CATALOG ."view/theme/". $objconfig->get('theme_default_directory')."/stylesheet/sliderlayer/css/typo.css" ) ){
		$typoFile = HTTP_CATALOG."catalog/view/theme/". $objconfig->get('theme_default_directory')."/stylesheet/sliderlayer/css/typo.css";	
	}	
?>
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_CATALOG;?>catalog/view/javascript/layerslider/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_CATALOG;?>catalog/view/javascript/layerslider/jquery.themepunch.revolution.js"></script>
<link rel="stylesheet" href="<?php echo $typoFile; ?>" type="text/css"/>
<style>
	.rev_slider{ position: relative; overflow: hidden; }
	.bannercontainer { position: relative;margin: 18px auto }
</style>


<div class="modal-dialog modal-lg previewLayer" style="width:1170px;">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $heading_title; ?></h4>
		</div>
		<div class="modal-body">

<!-- START THE BODY LAYER SLIDER -->
<div class="bannercontainer" style="width:<?php echo $sliderParams['width'];?>px;height:<?php echo $sliderParams['height'];?>px; ">
	<div class="banner rev_slider" style="width:<?php echo $sliderParams['width'];?>px;height:<?php echo $sliderParams['height'];?>px; " >
		<ul>
			<!-- THE FIRST SLIDE -->
				<li data-transition="random" data-slotamount="7" >
					
						<?php  foreach ( $slider->layers as $i => $layer )  {
							$type = $layer->layer_type;

							$endeffect = '';
							if(  $layer->layer_endanimation == 'auto' ){
								$layer->layer_endanimation = '' ;
							}
							if( (int)$layer->layer_endtime ){
								$endeffect = ' data-end="'.(int)$layer->layer_endtime.'"';
								$endeffect .= ' data-endspeed="'.(int)$layer->layer_endspeed.'" ';
								if( $layer->layer_endeasing != 'nothing') {
									$endeffect .= ' data-endeasing="'.$layer->layer_endeasing.'" ';	
								}
							}else {
								$layer->layer_endanimation = '' ;
							}
						 ?>	
						
						 
							<!-- THE MAIN IMAGE IN THE SLIDE -->
							<img src="<?php echo HTTP_CATALOG."image/".$slider->image; 	?>" >
						<div class="caption <?php echo $layer->layer_class; ?> <?php echo $layer->layer_animation;?> 
							<?php echo $layer->layer_easing;?> <?php echo $layer->layer_endanimation;?>"
							 data-x="<?php echo $layer->layer_left;?>"
							 data-y="<?php echo $layer->layer_top;?>"
							 data-speed="300"
							 data-start="<?php echo $layer->time_start;?>"
							 data-easing="easeOutExpo" <?php echo $endeffect;?> >
							 	<?php if( $type=='image') { ?> 
							 	<img src="<?php echo HTTP_CATALOG."image/".$layer->layer_content;?>">
								 	<?php } else if( $type == 'video' ) { ?>
									 	<?php if( $layer->layer_video_type == 'vimeo')  { ?>
								 		<iframe src="http://player.vimeo.com/video/<?php echo $layer->layer_video_id;?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer->layer_video_width;?>" height="<?php echo $layer->layer_video_height;?>"></iframe>
								 		<?php } else { ?>
								 			<iframe width="<?php echo $layer->layer_video_width;?>" height="<?php echo $layer->layer_video_height;?>" src="http://www.youtube.com/embed/<?php echo $layer->layer_video_id;?>" frameborder="0" allowfullscreen></iframe>
							 		<?php } ?>
							 <?php	} else { ?>
							 		<?php echo html_entity_decode( $layer->layer_caption, ENT_QUOTES, 'UTF-8');?>
							 	<?php } ?>

							</div>
						
						<?php } ?>		
			</li>			
						 
		 
					<li data-transition="random" data-slotamount="7" >
					
						<?php
							 	
						 foreach ( $slider->layers as $i => $layer )  {
							$type = $layer->layer_type;

							$endeffect = '';
							if(  $layer->layer_endanimation == 'auto' ){
								$layer->layer_endanimation = '' ;
							}
							if( (int)$layer->layer_endtime ){
								$endeffect = ' data-end="'.(int)$layer->layer_endtime.'"';
								$endeffect .= ' data-endspeed="'.(int)$layer->layer_endspeed.'" ';
								if( $layer->layer_endeasing != 'nothing') {
									$endeffect .= ' data-endeasing="'.$layer->layer_endeasing.'" ';	
								}
							}else {
								$layer->layer_endanimation = '' ;
							}
							
							

							
						 ?>	
						
						 
								<!-- THE MAIN IMAGE IN THE SLIDE -->
							<img src="<?php echo HTTP_CATALOG."image/".$slider->image; 	?>" >
						<div class="caption <?php echo $layer->layer_class; ?> <?php echo $layer->layer_animation;?> 
							<?php echo $layer->layer_easing;?> <?php echo $layer->layer_endanimation;?>"
							 data-x="<?php echo $layer->layer_left;?>"
							 data-y="<?php echo $layer->layer_top;?>"
							 data-speed="300"
							 data-start="<?php echo $layer->time_start;?>"
							 data-easing="easeOutExpo" <?php echo $endeffect;?> >
							 	<?php if( $type=='image') { ?> 
							 	<img src="<?php echo HTTP_CATALOG."image/".$layer->layer_content;?>">
								 	<?php } else if( $type == 'video' ) { ?>
									 	<?php if( $layer->layer_video_type == 'vimeo')  { ?>
								 		<iframe src="http://player.vimeo.com/video/<?php echo $layer->layer_video_id;?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer->layer_video_width;?>" height="<?php echo $layer->layer_video_height;?>"></iframe>
								 		<?php } else { ?>
								 			<iframe width="<?php echo $layer->layer_video_width;?>" height="<?php echo $layer->layer_video_height;?>" src="http://www.youtube.com/embed/<?php echo $layer->layer_video_id;?>" frameborder="0" allowfullscreen></iframe>
							 		<?php } ?>
							 <?php	} else { ?>
							 	<?php echo html_entity_decode( str_replace( "_ASM_", "&", $layer->layer_caption), ENT_QUOTES, 'UTF-8');?>
							 	<?php } ?>

							</div>
						
						<?php } ?>		
			</li>			
						 
		 
			 
		</ul>

		<div class="tp-bannertimer tp-bottom"></div>
	</div>
</div>
<!-- END THE BODY LAYER SLIDER -->


		</div>
	</div>
</div>
 





<!--
##############################
 - ACTIVATE THE BANNER HERE -
##############################
-->
<script type="text/javascript">

	var tpj=jQuery;
	tpj.noConflict();

	tpj(document).ready(function() {

	if (tpj.fn.cssOriginal!=undefined)
		tpj.fn.css = tpj.fn.cssOriginal;

		tpj('.banner').revolution(
			{
				delay:9000,
				startheight:<?php echo $sliderParams['height'];?>,
				startwidth:<?php echo $sliderParams['width'];?>,

				hideThumbs:200,

				thumbWidth:100,							// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
				thumbHeight:50,
				thumbAmount:5,

				navigationType:"none",				// bullet, thumb, none
				navigationArrows:"verticalcentered",				// nexttobullets, solo (old name verticalcentered), none

				navigationStyle:"round",				// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item), custom

				touchenabled:"on",						// Enable Swipe Function : on/off
				onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

				stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
				stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

				hideCaptionAtLimit:0,					// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
				hideAllCaptionAtLilmit:0,				// Hide all The Captions if Width of Browser is less then this value
				hideSliderAtLimit:0,					// Hide the whole slider, and stop also functions if Width of Browser is less than this value

				shadow:1					 
			});
	});
</script>