	<?php 
/******************************************************
 * @package Pav Opencart Theme Framework for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) October 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
$objlang    = $this->language;
$themeName  =  $this->theme;
$t 		   = DIR_TEMPLATE.$this->theme;
$patterns   =  $this->getPattern( $themeName );

if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
    $base = $this->config->get('config_ssl');
} else {
    $base = $this->config->get('config_url');
}


$backgroundImageURL = $base.'catalog/view/theme/'.$themeName.'/image/pattern/';
$directories = glob( $this->_themeScssDir . '/skins/*', GLOB_ONLYDIR );

$layouts = array( 'fullwidth' => 'Full Width', 'boxed-lg' => 'Boxed Desktop Large');
$productlayouts  =	array( 'default' => 'Default');
?>
<script type="text/javascript">
$(document).ready( function (){
	$(".paneltool .panelbutton").click( function(){	
		$(this).parent().toggleClass("active");
	} );
} );

</script>

<div id="pav-paneltool" class="hidden-sm hidden-xs">
<div class="paneltool themetool">
	<div class="panelbutton">
		<i class="fa fa-cog"></i>
	</div>
	<div class="panelcontent ">
		<div class="panelinner">
			<h4>Panel Tool</h4>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="clearfix"><div class="clearfix">
				<div class="group-input row">
					<label class="col-sm-5">Theme</label>
					<select class="col-sm-7" name="userparams[skin]">
							<option value=""><?php echo $this->language->get('default');?></option>
						<?php foreach( $directories as $skin ) {  $skin = str_replace(".css","", basename($skin) ); ?>
						<option <?php echo isset($_COOKIE[$themeName.'_skin']) ? ($skin == $_COOKIE[$themeName.'_skin']?'selected':'') : '' ; ?>
						 value="<?php echo ($skin); ?>" <?php if( $this->getParam('skin') == $skin ) { ?> selected="selected" <?php } ?>><?php echo ($skin);?></option>
						<?php } ?>
					</select>					
				</div>
				<div class="group-input row">
					<label class="col-sm-5">Layout</label>
					<select class="col-sm-7" name="userparams[layout]">
						<?php foreach( $layouts as $k=>$skin ) {  $skin = basename($skin) ; ?>
						<option value="<?php echo ($k);?>" <?php if( $this->getParam('layout') == $k ) { ?> selected="selected" <?php } ?>><?php echo ($skin);?></option>
						<?php } ?>
					</select>					
				</div>

				<hr>
				<div class="clearfix"></div>
				<p class="group-input pull-right">
					<button value="Apply" class="btn button btn-small" name="btn-save" type="submit">Apply</button>
					<a class="btn button btn-small" href="<?php echo HTTP_SERVER; ?>?pavreset=?"><span>Reset</span></a>
				</p>
			</div></form>
		</div>	
	</div>
</div>
	
<div class="paneltool editortool">
	<div class="panelbutton">
		<i class="fa fa-adjust"></i>
	</div>
	<div class="panelcontent editortool"><div class="panelinner">
		<?php if( class_exists("ThemeControlHelper") ){ ?>				
			<h4><?php echo $objlang->get( 'text_color_tools' ); ?></h4>					
			<?php $xmlselectors = ThemeControlHelper::renderEdtiorThemeForm( $this->theme ); ?>
				<div class="clearfix" id="customize-body">			
					<ul class="nav nav-tabs" id="myTab">
						<?php foreach( $xmlselectors as $for => $output ) { ?>
						<li><a href="#tab-<?php echo $for ?>"><?php echo $objlang->get( 'text_'.$for );?></a></li>		
						<?php } ?>
					</ul>										
					<div class="tab-content" > 
						<?php foreach( $xmlselectors as $for => $output ) { ?>
						<div class="tab-pane" id="tab-<?php echo $for; ?>">
							<?php if( !empty( $output) ){?>
							<div class="accordion"  id="custom-accordion<?php echo $for; ?>">
							<?php $i=0; foreach ( $output as $group ) { ?>
							  	            	   <div class="accordion-group panel panel-default">
		                            <div class="accordion-heading">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordion<?php echo $for; ?>" href="#collapse<?php echo $group['match'];?>">
											<?php echo $group['header']; ?>	 
										</a>
									</div>

		                            <div id="collapse<?php echo $group['match'];?>" class="accordion-body panel-collapse collapse <?php if( $i++ ==0) { ?> in <?php } ?>">
			                            <div class="accordion-inner panel-body clearfix">
			                              	<?php foreach ($group['selector'] as $item ) {  ?>
												 <?php  if (isset($item['type'])&&$item['type']=="image") { ?>
												  <div class="form-group background-images"> 
														<label><?php echo $item['label']?></label>
														<a class="clear-bg btn btn-primary" href="#">Clear</a>
														<input value="" type="hidden" name="customize[<?php echo $group['match'];?>][]" data-match="<?php echo $group['match'];?>" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="background-image">

														<div class="clearfix"></div>
														 <p><em style="font-size:10px">Those Images in folder YOURTHEME/img/patterns/</em></p>
														<div class="bi-wrapper clearfix">
														<?php foreach ( $patterns as $pattern ){ ?>
														<div style="background:url('<?php echo $backgroundImageURL.$pattern;?>') no-repeat center center;" class="pull-left" data-image="<?php echo $backgroundImageURL.$pattern;?>" data-val="../../img/patterns/<?php echo $pattern; ?>">

														</div>
														<?php } ?>
				                                    </div>
				                                  </div>
				                                  <?php } elseif( $item['type'] == "fontsize" ) { ?>
				                                   <div class="form-group">
					                                   <label><?php echo $item['label']?></label>
					                                  	<select name="customize[<?php echo $group['match'];?>][]" data-match="<?php echo $group['match']?>"  class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="<?php echo $item['attrs']?>">
															<option value="">Inherit</option>
													<?php for( $fs=9; $fs<=16; $fs++ ) { ?>
													<option value="<?php echo $fs; ?>"><?php echo $fs; ?></option>
															<?php } ?>
														</select>
															<a href="#" class="clear-bg btn btn-primary">Clear</a>
				                                  </div>
				                                  <?php } else { ?>
				                                  <div class="form-group">
														<label><?php echo $item['label']?></label>
														<input value="" size="10" name="customize[<?php echo $group['match']?>][]" data-match="<?php echo $group['match']?>" type="text" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="<?php echo $item['attrs']?>"><a href="#" class="clear-bg btn btn-primary">Clear</a>
												  </div>
				                                  <?php } ?>


											<?php } ?>
			                            </div>
		                            </div>
			                    </div>         	
								<?php } ?>
							 </div>
							<?php } ?>
						</div>
					   <?php } /* endforeach  */?>
					</div>   
				</div>    
			<?php }  ?></div>
	</div>
	
</div>

</div> 
 
<script type="text/javascript">
$('#myTab a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
})
$('#myTab a:first').tab('show'); 
 

var $MAINCONTAINER = $("html");

/**
 * BACKGROUND-IMAGE SELECTION
 */
$(".background-images").each( function(){
	var $parent = this;
	var $input  = $(".input-setting", $parent ); 
	$(".bi-wrapper > div",this).click( function(){
		 $input.val( $(this).data('val') ); 
		 $('.bi-wrapper > div', $parent).removeClass('active');
		 $(this).addClass('active');

		 if( $input.data('selector') ){  
			$($input.data('selector'), $($MAINCONTAINER) ).css( $input.data('attrs'),'url('+ $(this).data('image') +')' );
		 }
	} );
} ); 

$(".clear-bg").click( function(){
	var $parent = $(this).parent();
	var $input  = $(".input-setting", $parent ); 
	if( $input.val('') ) {
		if( $parent.hasClass("background-images") ) {
			$('.bi-wrapper > div',$parent).removeClass('active');	
			$($input.data('selector'),$("#main-preview iframe").contents()).css( $input.data('attrs'),'none' );
		}else {
			$input.attr( 'style','' )	
		}
		$($input.data('selector'), $($MAINCONTAINER) ).css( $input.data('attrs'),'inherit' );

	}	
	$input.val('');

	return false;
} );



 $('.accordion-group input.input-setting').each( function(){
 	 var input = this;
 	 $(input).attr('readonly','readonly');
 	 $(input).ColorPicker({
 	 	onChange:function (hsb, hex, rgb) {
 	 		$(input).css('backgroundColor', '#' + hex);
 	 		$(input).val( hex );
 	 		if( $(input).data('selector') ){  
				$( $MAINCONTAINER ).find($(input).data('selector')).css( $(input).data('attrs'),"#"+$(input).val() )
			}
 	 	}
 	 });
	} );
 $('.accordion-group select.input-setting').change( function(){
	var input = this; 
		if( $(input).data('selector') ){  
		var ex = $(input).data('attrs')=='font-size'?'px':"";
		$( $MAINCONTAINER ).find($(input).data('selector')).css( $(input).data('attrs'), $(input).val() + ex);
	}
 } );
 

</script>