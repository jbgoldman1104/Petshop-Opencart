<!DOCTYPE html>
<?php 
$typoFile = 	HTTP_CATALOG."catalog/view/theme/default/stylesheet/sliderlayer/css/typo.css";	
if( file_exists( DIR_CATALOG ."view/theme/". $objconfig->get('theme_default_directory')."/stylesheet/sliderlayer/css/typo.css" ) ){
	$typoFile = 	HTTP_CATALOG."catalog/view/theme/". $objconfig->get('theme_default_directory')."/stylesheet/sliderlayer/css/typo.css";	
}
		
?>

<!--
#######################################
	- THE HEAD PART -
######################################
-->
<head>
	<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_CATALOG;?>catalog/view/javascript/layerslider/jquery.themepunch.plugins.min.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_CATALOG;?>catalog/view/javascript/layerslider/jquery.themepunch.revolution.js"></script>
	<link rel="stylesheet" href="<?php echo $typoFile; ?>" type="text/css"/>
	<style>
		.rev_slider{ position: relative; overflow: hidden; }
		.bannercontainer { position: relative;margin: 18px auto }
	</style>
</head>



<!--
#######################################
	- THE BODY PART -
######################################
-->
<body class="body-dark">

 		<?php // echo '<pre>'.print_r( $sliders,1 ); die; ?>
			 <?php 
	$randID = rand( 20,   rand() );  	 // echo '<pre>'.print_r( $sliderParams ,1 ); die;


	$sliderParams['hide_navigator_after'] = $sliderParams['show_navigator']?0:$sliderParams['hide_navigator_after']
?>
<div class="bannercontainer" style="padding: <?php echo $sliderParams['padding'];?>; max-width:<?php echo $sliderParams['width'];?>px;height:<?php echo $sliderParams['height'];?>px; ">
					<div id="sliderlayer<?php echo $randID; ?>" class="rev_slider" style="width:100%;height:100%; " >
						
						 
						<ul>
								<?php foreach( $sliders as $slider )  { 

										// echo '<pre>'.print_r( $slider,1 ); die;	
									$thumbnail = '';
									$link = $slider['params']['slider_link'] ?' data-link="'.$slider['params']['slider_link'].'"':'';
								 	$sliderDelay = (int)$slider['params']['slider_delay']?'data-delay="'.(int)$slider['params']['slider_delay'].'"':"";
									?>
						
									<li <?php echo $link.' ' .$sliderDelay; 	?> data-masterspeed="<?php echo $slider['params']['slider_duration'];?>"  data-transition="<?php echo $slider['params']['slider_transition'];?>" data-slotamount="<?php echo $slider['params']['slider_slot'];?>" data-thumb="<?php echo $slider['thumbnail'];?>">

										<?php if( $slider['params']['slider_usevideo'] == 'youtube' || $slider['params']['slider_usevideo'] == 'vimeo' ) { ?>

										<?php 
											$vurl  = 'http://player.vimeo.com/video/'.$slider['params']['slider_videoid'].'/';
											if(  $slider['params']['slider_usevideo'] == 'youtube' ){
											 	$vurl  = 'http://www.youtube.com/embed/'.$slider['params']['slider_videoid'].'/';
											}

										?>
								<div class="caption fade fullscreenvideo" data-autoplay="true" data-x="0" data-y="0" data-speed="500" data-start="10" data-easing="easeOutBack"><iframe src="<?php echo $vurl;?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="100%" height="100%"></iframe></div>
										<?php }elseif( $slider['main_image'] ) { ?>
											
											<img src="<?php echo $slider['main_image']; ?>" >
										<?php } ?>
										
										<?php
											 	
										 foreach ( $slider['layersparams']->layers as $i => $layer )  {
											$type = $layer['layer_type'];

											$endeffect = '';
											if(  $layer['layer_endanimation'] == 'auto' ){
												$layer['layer_endanimation'] = '' ;
											}
											if( (int)$layer['layer_endtime'] ){
												$endeffect = ' data-end="'.(int)$layer['layer_endtime'].'"';
												$endeffect .= ' data-endspeed="'.(int)$layer['layer_endspeed'].'"';
												if( $layer['layer_endeasing'] != 'nothing') {
													$endeffect .= ' data-endeasing="'.$layer['layer_endeasing'].'" ';	
												}
											}else {
												$layer['layer_endanimation'] = '' ;
											}
											

											
										 ?>	
										<div class="caption <?php echo $layer['layer_class']; ?> <?php echo $layer['layer_animation'];?> 
											<?php echo $layer['layer_easing'];?>   <?php echo $layer['layer_easing'];?> 
											<?php echo $layer['layer_endanimation'];?>"
											 data-x="<?php echo $layer['layer_left']; ?>"
											 data-y="<?php echo $layer['layer_top']; ?>"
											 data-speed="300"
											 data-start="<?php echo $layer['time_start']; ?>"
											 data-easing="easeOutExpo" <?php echo $endeffect;?> >
											 	<?php if( $type=='image') { ?> 
											 	<img src="<?php echo HTTP_CATALOG."image/".$layer['layer_content'];?>">
												 	<?php } else if( $type == 'video' ) { ?>
													 	<?php if( $layer['layer_video_type'] == 'vimeo')  { ?>
												 		<iframe src="http://player.vimeo.com/video/<?php echo $layer['layer_video_id'];?>?title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>"  style="width:<?php echo (int) $layer['layer_video_width'];?>px;height:<?php echo (int)$layer['layer_video_height'];?>px"></iframe>
												 		<?php } else { ?>
												 			<iframe width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>" src="http://www.youtube.com/embed/<?php echo $layer['layer_video_id'];?>" style="width:<?php echo (int) $layer['layer_video_width'];?>px;height:<?php echo (int)$layer['layer_video_height'];?>px"></iframe>
											 		<?php } ?>
											 <?php	} else { ?>
											 	<?php echo html_entity_decode( $layer['layer_caption'], ENT_QUOTES, 'UTF-8');?>
											
											 	<?php } ?>

											</div>
										
										<?php } ?>		
							</li>			
										 
						 
							<?php } ?>			 	
										 
						 
							 
						</ul>
						<?php if( $sliderParams['show_time_line']  ) { ?> 
						<div class="tp-bannertimer tp-<?php echo $sliderParams['time_line_position']; ?>"></div>
						<?php } ?>
					</div>
				</div>



<?php 
 // 
?>

			<!--
			##############################
			 - ACTIVATE THE BANNER HERE -
			##############################
			-->
			<script type="text/javascript">

				var tpj=jQuery;
				 

				tpj(document).ready(function() {

				if (tpj.fn.cssOriginal!=undefined)
					tpj.fn.css = tpj.fn.cssOriginal;

					tpj('#sliderlayer<?php echo $randID; ?>').revolution(
						{
							delay:<?php echo $sliderParams['delay'];?>,
							startheight:<?php echo $sliderParams['height'];?>,
							startwidth:<?php echo $sliderParams['width'];?>,


							hideThumbs:<?php echo (int)$sliderParams['hide_navigator_after'];?>,

							thumbWidth:<?php echo (int)$sliderParams['thumbnail_width'];?>,						
							thumbHeight:<?php echo (int)$sliderParams['thumbnail_height'];?>,
							thumbAmount:<?php echo (int)$sliderParams['thumbnail_amount'];?>,

							navigationType:"<?php echo $sliderParams['navigator_type'];?>",				
							navigationArrows:"<?php echo $sliderParams['navigator_arrows'];?>",				
							<?php if( $sliderParams['navigation_style'] != 'none' ) {   ?>
							navigationStyle:"<?php echo $sliderParams['navigation_style'];?>",			 
							<?php } ?>
 					
							navOffsetHorizontal:<?php echo (int)$sliderParams['offset_horizontal'];?>,
							navOffsetVertical:<?php echo (int)$sliderParams['offset_vertical'];?>, 	

							touchenabled:"<?php echo ($sliderParams['touch_mobile']?'on':'off') ?>",			
							onHoverStop:"<?php echo ($sliderParams['stop_on_hover']?'on':'off') ?>",						
							shuffle:"<?php echo ($sliderParams['shuffle_mode']?'on':'off') ?>",	
							stopAtSlide:-1,						
							stopAfterLoops:-1,						

							hideCaptionAtLimit:0,				
							hideAllCaptionAtLilmit:0,				
							hideSliderAtLimit:0,			
								fullWidth:"on",
							shadow:<?php echo (int)$sliderParams['shadow_type'];?>	 
							 				 


						});



					});

			</script>



	</body>
</html>	