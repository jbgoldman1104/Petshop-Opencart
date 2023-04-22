<?php 
	$randID = rand( 20,   rand() );  	 //  echo '<pre>'.print_r( $sliders ,1 ); die;


	$sliderParams['hide_navigator_after'] = $sliderParams['show_navigator']?0:$sliderParams['hide_navigator_after'];
	$class 	   = isset( $sliderParams['fullwidth'] ) && !empty($sliderParams['fullwidth']) ? $sliderParams['fullwidth']: 'boxed';
	$fullwidth = $class =="boxed"?"off":"on";

 
?>
<?php if( $class =="boxed") { ?>
<div class="layerslider-wrapper" style="max-width:<?php echo $sliderParams['width'];?>px;">
<?php } ?>
			<div class="bannercontainer banner-<?php echo trim($class);?>" style="padding: <?php echo $sliderParams['padding'];?>;margin: <?php echo $sliderParams['margin'];?>;">
					<div id="sliderlayer<?php echo $randID; ?>" class="rev_slider <?php echo trim($class);?>banner" style="width:100%;height:<?php echo $sliderParams['height'];?>px; " >
						
						 
						<ul>
								<?php foreach( $sliders as $_key => $slider )  { 
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
											
											<img src="<?php echo $slider['main_image']; ?>"  alt="Image <?php echo $_key; ?>"/>
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
										
										 
												<!-- THE MAIN IMAGE IN THE SLIDE -->
											<?php // if( $slider['slider_usevideo'] )?>	
											
										<div class="caption <?php echo $layer['layer_class']; ?> <?php echo $layer['layer_animation'];?> 
											<?php echo $layer['layer_easing'];?>   <?php echo $layer['layer_easing'];?> 
											<?php echo $layer['layer_endanimation'];?>"
											 data-x="<?php echo $layer['layer_left']; ?>"
											 data-y="<?php echo $layer['layer_top']; ?>"
											 data-speed="300"
											 data-start="<?php echo $layer['time_start']; ?>"
											 data-easing="easeOutExpo" <?php echo $endeffect;?> >
											 	<?php if( $type=='image') { ?> 
											 	<img src="<?php echo $url."image/".$layer['layer_content'];?>" alt="<?php echo $layer['layer_content']; ?>" />
												 	<?php } else if( $type == 'video' ) { ?>
													 	<?php if( $layer['layer_video_type'] == 'vimeo')  { ?>
												 		<iframe src="http://player.vimeo.com/video/<?php echo $layer['layer_video_id'];?>?wmode=transparent&amp;title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>"></iframe>
												 		<?php } else { ?>
												 			<iframe width="<?php echo $layer['layer_video_width'];?>" height="<?php echo $layer['layer_video_height'];?>" src="http://www.youtube.com/embed/<?php echo $layer['layer_video_id'];?>?wmode=transparent" frameborder="0" allowfullscreen="1"></iframe>
											 		<?php } ?>
											 <?php	} else { ?>
											 	<?php echo html_entity_decode( str_replace( '_ASM_', '&', $layer['layer_caption']) , ENT_QUOTES, 'UTF-8'); ?>
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

 
<?php if( $class =="boxed") { ?>
 </div>
<?php } ?>
 
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
							fullWidth:"<?php echo $fullwidth; ?>",
							shadow:<?php echo (int)$sliderParams['shadow_type'];?>	 
							 				 


						});



				

			</script>
