(function($) {
	$.fn.WPO_Gallery = function(opts) {
		// default configuration
		var config = $.extend({}, {
		 	key:'',
		 	confirmdel:'Are you sure to remove this?',
		 	savetext:'Save Now',
		 	field:null,
		 	gallery:true,
		 	preview:true,
		 	widgetaction:true,
		 	url:''
		}, opts);

  		var $this = null;
	 	
	 	function showGalleryModal( $field, layout ){
 				
	 			if( config.widgetaction ){
 					$('#wpo-widgetform').modal().hide();
 				}	

			 	var content =  $field.val();
			 	var fid = $field.attr('id'); 
				$('#dialog').remove();
				$('#content, #page-content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="'+PTS_PAGEBUILDER_FILE_MANAGEMENT+'&field='+encodeURIComponent(fid)+'&modal=true&rad='+Math.random()+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
				$('#dialog').dialog({
						title: 'Image Management',
						close: function (event, ui) {
				 
							$field.parent().find('img').attr('src', PTS_PAGEBUILDER_FILE_URI + $field.val() );
							if( config.widgetaction ){
								$('#wpo-widgetform').modal().show();
							} 
						},
						open:function(){
						 
							$( "#gallerydialog iframe" ).load( function() { 
							   

								$( "#gallerydialog iframe" ).contents().find('body #column-right').delegate( "a", 'dblclick', function(){

								 
									$( "#gallerydialog iframe" ).contents().find('body #column-right a').removeClass('active');
								 
									$(this).find('input	').addClass('active');
									$('#dialog').close();
									$('#dialog').remove();
								} ); 

								/* 
								images.each( function() {


									var item = this;
									var img = $(item).find('input').val();
									
									if( content !="" && img !="" && content.indexOf(img) !=-1 ){
										$(item).addClass('active');
									}

									$(item).click( function () {
									 
										if( config.gallery == false ){
											$('#column-right input').removeClass('active');
										}

										$(item).find('input	').toggleClass('active');
									} );
								} ) ;
							*/		
		
							} );
						},
						 

						bgiframe: true,
						width: 990,
						height: 500,
						resizable: true,
						modal: true
				});
	 	}	


		this.each(function() {  
		 	
			var $this = $(this);
		 	if( config.gallery ){
		 			
		 			var $parent = $(this).parent();
		 			var a = $this.val().split(/,/);
		 			var name = $(this).attr( 'name' );
		 			 var $btnaddmore = $('<div class="btn btn-danger"><i class="fa fa-gear"></i></div>');
		 			$(this).parent().append("<hr>").append( $btnaddmore ); 	
		 			var ict = 0; 
				 	if(  $this.val() && a.length > 0 && config.preview ){
				 	 	$.each(a, function(i,v){
				 	 		if( $.trim(v) != "" ){
			 	 				config.key = config.key + ( ict++ );
			 	 	 			var i =  v?(config.baseurl+v):config.placehold; 
						 		var inpt = '<img src="'+i+'" alt="" title="" data-placeholder="'+config.placehold +'" />';
						 		inpt  += '<input type="hidden" name="'+name+'[]" value="'+v+'" id="imagescontent' + config.key + '" />'; 
							 	var $btn =  ( '<hr><a  href=""  data-toggle="image" class="img-thumbnail"  id="imagebutton'+config.key+'">'+inpt+'</a>' );
							 	$content = $( '<div class="images-content row" id="previewimage'+config.key+'">'+$btn+'</div>' );
					 			$this.parent().append( $content );

				 	 	 	}
				 	 	} );
				 	 } 
				 	
			 
		 			$btnaddmore.click( function(){  
		 					config.key = config.key + ( ict+ 1 );
		 					var v = '';
		 	 	 			var i =  v?(config.baseurl+v):config.placehold; 
					 		var inpt = '<img src="'+i+'" alt="" title="" data-placeholder="'+config.placehold +'" />';
					 		inpt  += '<input type="hidden" name="'+name+'[]" value="" id="imagescontent' + config.key + '" />'; 
						 	var $btn =  ( '<hr><a  href=""  data-toggle="image" class="img-thumbnail"  id="imagebutton'+config.key+'">'+inpt+'</a>' );
						 	$content = $( '<div class="images-content row" id="previewimage'+config.key+'">'+$btn+'</div>' );

					 
				 			$parent.append( $content );	
				 			return false; 
		 			} );
				 	$(this).remove();
		 	}else { 
			 	
		 	 
		 		$(this).hide();
		 		var i = $this.val()?(config.baseurl+$this.val()):config.placehold; 
		 		var inpt = '<img src="'+i+'" alt="" title="" data-placeholder="'+config.placehold +'" />';
			 	$btn = $( '<hr><a  href=""  data-toggle="image" class="img-thumbnail"  id="imagebutton'+config.key+'">'+inpt+'</a>' );
			 	$content = $( '<div class="images-content row" id="previewimage'+config.key+'"></div>' );

		 
		  	
	 			$this.parent().append( $content );

		 		$this.parent().append( $btn );

 		  	}

		});
	 
		return this;
	};
	
})(jQuery);