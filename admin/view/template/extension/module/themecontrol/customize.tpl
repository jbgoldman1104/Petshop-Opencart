<?php echo $header; ?>
<link type="text/css" href="view/stylesheet/customizetheme.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo $siteURL; ?>catalog/view/javascript/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo $siteURL; ?>catalog/view/javascript/jquery/colorpicker/js/colorpicker.js"></script>



<div class="page-wrapper row row-offcanvas row-offcanvas-left active" id="contentdd" >

<div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
<form  enctype="multipart/form-data" action="<?php echo str_replace("&amp;","&",$action); ?>" id="form" method="post">
	<div class="pav-customize" id="pav-customize">
	 
		<div class="wrapper">	
			<div id="customize-form">
<hr>		
					<div class="buttons-group">
						<input type="hidden" name="action-mode" id="action-mode" >	
						<button type="button"  class="btn btn-primary btn-sm" onclick="$('#action-mode').val('save-edit');$('#form').submit();"><?php echo $olang->get('text_submit');?></button>
						<button type="button" class="btn btn-danger btn-sm" onclick="$('#action-mode').val('save-delete');$('#form').submit();"><?php echo $olang->get('text_delete');?></button>
					</div>

<hr>
					<div class="groups">

							<div class="form-group">
								<label><?php echo $olang->get('text_css_profiles'); ?></label>	
								<select class="form-control input-sm" name="saved_file" id="saved-files">
									<option value=""> ------------- </option>
									<?php foreach( $files as $file ){ $file = str_replace( ".css","", $file); ?>
										<option value="<?php echo $file;?>"><?php echo $file; ?></option>
									<?php } ?>
								</select> 
							</div>

							<div class="form-group ">
								<label class="show-for-notexisted"><?php echo $olang->get('text_named_this'); ?></label>
								<label class="show-for-existed"><?php echo $olang->get('text_rename_this'); ?></label>
								<input type="text" name="newfile" class="form-control input-sm" />
							</div>	
					</div>

				<div class="clearfix" id="customize-body">
					<ul class="nav nav-tabs" id="myTab">
					<?php foreach( $xmlselectors as $for => $output ) { ?>
			          <li><a href="#tab-<?php echo $for ?>"><?php echo $olang->get( 'text_'.$for );?></a></li>
			
			          <?php } ?>
			        </ul>
								        <div class="tab-content" > 
								             	
								     

								             	<?php foreach( $xmlselectors as $for => $output ) { ?>
								            	<div class="tab-pane" id="tab-<?php echo $for; ?>">

								            	<?php if( !empty( $output ) ){?>
								            	<div class="accordion"  id="custom-accordion<?php echo $for; ?>">
								            	<?php $i=0; foreach ( $output as $group ) { ?>
								            	   <div class="accordion-group panel panel-default">
								                            <div class="accordion-heading panel-heading">
								                              <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordion<?php echo $for; ?>" href="#collapse<?php echo $group['match'];?>">
								                               		<?php echo $group['header']; ?>	 
								                              </a>
								                            </div>

								                            <div id="collapse<?php echo $group['match'];?>" class="accordion-body collapse <?php if( $i++ ==0) { ?> in <?php } ?>">
								                              <div class="accordion-inner  panel-body  clearfix">
								                              	<?php foreach ($group['selector'] as $item ) { ?>
																 <?php  if (isset($item['type'])&&$item['type']=="image") { ?>
																  <div class="form-group background-images"> 
																		<label><?php echo $item['label']?></label>
																		<a class="clear-bg label label-success" href="javascript:void(0);"><span class="fa fa-gear"></span></a>
																		<input value="" type="hidden" name="customize[<?php echo $group['match'];?>][]" data-match="<?php echo $group['match'];?>" type="text" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="background-image">

																		<div class="clearfix"></div>
																		 <p><em style="font-size:10px">Those Images in folder YOURTHEME/img/patterns/</em></p>
																		<div class="bi-wrapper clearfix">
																		<?php foreach ( $patterns as $pattern ){ ?>
																		<div style="background:url('<?php echo $backgroundImageURL.$pattern;?>') no-repeat center center;" class="pull-left" data-image="<?php echo $backgroundImageURL.$pattern;?>" data-val="../../image/pattern/<?php echo $pattern; ?>">

																		</div>
																		<?php } ?>
								                                    </div>
								                                  </div>
								                                  <?php } elseif( $item['type'] == "fontfamily" ) { ?>
								                                   <div class="form-group">
								                                   	<?php 
								                                   	// 	echo '<pre>'.print_r( $localfonts ,1 );die;
								                                   	?>
								                                     <label><?php echo $item['label']?></label>
								                                  	<select name="customize[<?php echo $group['match'];?>][]" data-match="<?php echo $group['match']?>" type="text" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="<?php echo $item['attrs']?>">
																		<option value="inherit">Inherit</option>
																		<?php foreach( $localfonts as $i => $v ) { ?>
																		<option value="<?php echo str_replace( '"',"'",$v[0]); ?>"><?php echo $v[1]; ?></option>
																		<?php } ?>
																	</select>	<a href="javascript:void(0);" class="clear-bg label label-success"><span class="fa fa-gear"></span></a>
								                                  </div>
                             
								                                  <?php } elseif( $item['type'] == "fontsize" ) { ?>
								                                   <div class="form-group">
								                                   <label><?php echo $item['label']?></label>
								                                  	<select name="customize[<?php echo $group['match'];?>][]" data-match="<?php echo $group['match']?>" type="text" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="<?php echo $item['attrs']?>">
																		<option value="">Inherit</option>
																		<?php for( $i=9; $i<=20; $i++ ) { ?>
																		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																		<?php } ?>
																	</select>	<a href="javascript:void(0);" class="clear-bg label label-success"><span class="fa fa-gear"></span></a>
								                                  </div>
								                                  <?php } else { ?>
								                                  <div class="form-group">
																	<label><?php echo $item['label']?></label>
																	<input value="" size="10" name="customize[<?php echo $group['match']?>][]" data-match="<?php echo $group['match']?>" type="text" class="input-setting" data-selector="<?php echo $item['selector']?>" data-attrs="<?php echo $item['attrs']?>"><a href="javascript:void(0);" class="clear-bg label label-success"><span class="fa fa-gear"></span></a>
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

			 
			</div>
	 	</div>
</div>	
 
 
</form>
</div>

	<div id="main-preview" class="col-xs-12 col-sm-12">

		<div class="toppanel row">
			<button data-toggle="offcanvas" class="btn btn-primary btn-xs pull-left" type="button"><span class="fa fa-list"></span> Toggle Panel</button> 
			<div class="col-sm-3">Live Theme Editor: <?php echo $themeName; ?></div>
			<div class="col-sm-6">
 
				  <a  href="<?php echo $back_url;?>" class="btn btn-danger btn-xs pull-right"><?php echo $olang->get('text_back');?></a> 
			</div>	 	


		</div>

		<iframe src="<?php echo $store;?>index.php?pavtoken=<?php echo $oconfig->get('config_encryption');?>" ></iframe> 
	</div>

</div>

<script type="text/javascript">


var theme_list_open=false;
$(document).ready(function(){function e(){var e=$("#switcher")
	.height();$("#main-preview")
	.css("height",
	$(window).height()-e+"px")}
	IS_IPAD=navigator.userAgent.match(/iPad/i)!=null;
	$(window).resize(function(){e()}).resize();
		$("#theme_select").click(function(){if(theme_list_open==true){
		$(".center ul li ul").hide();theme_list_open=false}else{
		$(".center ul li ul").show();theme_list_open=true}return false});
		$("#theme_list ul li a").click(function(){var e=$(this).attr("rel").split(",");
		$("li.purchase a").attr("href",e[1]);
		$("li.remove_frame a").attr("href",e[0]);
		$("#main-preview").attr("src",e[0]);
		window.location.href = "?theme="+e[2]+""
		$("li.close a").attr("src",e[0]);
		$("#theme_list a#theme_select").text($(this).text());
		$(".center ul li ul").hide();theme_list_open=false;return false});
		$("#header-bar").hide();clicked="desktop";var t={desktop:"100%",tabletlandscape:1040,tabletportrait:788,mobilelandscape:500,mobileportrait:340,placebo:0};jQuery(".responsive a").on("click",function(){var e=jQuery(this);for(device in t){if(e.hasClass(device)){clicked=device;jQuery("#main-preview").width(t[device]);if(clicked==device){jQuery(".responsive a").removeClass("active");e.addClass("active")}}}return false});if(IS_IPAD){
		$("#main-preview").css("padding-bottom","60px")
	}}
)  
    
   

$("#custom-accordion .accordion-group:first .accordion-body").addClass('in');


$("#custom-accordion .accordion-group:first .accordion-body").addClass('in');
$(document).ready(function () {
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});
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
			$($input.data('selector'),$("#main-preview iframe").contents()).css( $input.data('attrs'),'url('+ $(this).data('image') +')' );
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
		$($input.data('selector'),$("#main-preview iframe").contents()).css( $input.data('attrs'),'inherit' );

	}	
	$input.val('');

} );
	
/**
 *  FORM SUBMIT
 */
 $( "#form" ).submit( function(){ 
	$('.input-setting').each( function(){
		if( $(this).data("match") ) {
			var val = $(this).data('selector')+"|"+$(this).data('attrs');
			$(this).parent().append('<input type="hidden" name="customize_match['+$(this).data("match")+'][]" value="'+val+'"/>');
		}	 
	} );
	return true; 
} );
$("#main-preview iframe").ready(function(){  
	 $('.accordion-group input.input-setting').each( function(){
	 	 var input = this;
	 	 $(input).attr('readonly','readonly');
	 	 $(input).ColorPicker({
	 	 	onChange:function (hsb, hex, rgb) {
	 	 		$(input).css('backgroundColor', '#' + hex);
	 	 		$(input).val( hex );
	 	 		if( $(input).data('selector') ){   
					$("#main-preview iframe").contents().find($(input).data('selector')).css( $(input).data('attrs'),"#"+$(input).val() )
				}
	 	 	}
	 	 });
 	} );
	 $('.accordion-group select.input-setting').change( function(){
		var input = this; 
			if( $(input).data('selector') ){  
			var ex = $(input).data('attrs')=='font-size'?'px':"";	
			$("#main-preview iframe").contents().find($(input).data('selector')).css( $(input).data('attrs'), $(input).val() + ex);
		}
	 } );
})
 
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
	
$('#myTab a:first').tab('show'); 

 $('#myCollapsible').collapse({
  toggle: false
})

$("#pav-customize .btn-show").click( function(){

	$("body").toggleClass("off-customize");
} );
 
$(".show-for-existed").hide();
$("#saved-files").change( function() {

	if( $(this).val() ){  
		$(".show-for-notexisted").hide();
		$(".show-for-existed").show();
	}else {
		$(".show-for-notexisted").show();
		$(".show-for-existed").hide();
	}
	if( $(this).val()==""){
		return ;
	}
	var url  = '<?php echo $customizeFolderURL; ?>'+$(this).val()+".json?rand"+Math.random();

	$.getJSON( url, function(data) {
		var items = data;
			if( items ){
				$('#customize-body .accordion-group').each( function(){
		 			var i = 0;
					$("input, select", this).each( function(){
						if( $(this).data('match') ){ 
							if( items[$(this).data('match')] && items[$(this).data('match')][i] ){ 
								var el = items[$(this).data('match')][i];
								var pf = '';
								var sf = '';
								var bval = el.val;
							 	$(this).val( el.val );

								if( el.attr == 'font-size' ){
									sf = 'px';
								}else if( el.attr == 'color' || el.attr == 'background-color' ){
									pf = '#';
									$(this).ColorPickerSetColor(el.val );
									$(this).css(  el.attr ,pf+el.val+sf );

								}else if( el.attr =='background-image' ){
									$("div.active", $(this).parent() ).removeClass('active');
									if( el.val  ) { 
 										var img = $("[data-val='"+el.val+"']", $(this).parent() ); 
 										img.addClass('active') ; 
 										pf='url(';
 										sf= ')';
										bval = img.data( 'image' );
 									}
								}

							 	if( el.val !== '') {
						
							 		$("#main-preview iframe").contents().find( el.selector ).css(  el.attr ,pf+bval+sf );
							 	}
							 	else { 
									//$("#main-preview iframe").contents().find( el.selector ).css(  el.attr ,"inherit" );
						 			// $(this).css( el.attr ,"inherit");
							 	}
							}
							i++;
						}
					} );
					 
				});
			}
		});

	$("#main-preview iframe").contents().find("#customize-theme").remove();
	if( $(this).val() ){
		var _link = $('<link rel="stylesheet" href="" id="customize-theme">');
		_link.attr('href', '<?php echo $customizeFolderURL?>'+$(this).val()+".css?rand="+Math.random() );
		$("#main-preview iframe").contents().find("head").append( _link );
	}
});
</script>
</body>





</html>

