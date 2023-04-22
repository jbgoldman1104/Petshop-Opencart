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
				$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="'+PTS_PAGEBUILDER_FILE_MANAGEMENT+'&field='+encodeURIComponent(fid)+'&modal=true&rad='+Math.random()+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
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
	 		$rm = $( '<span class="btn btn-danger" id="rmbutton'+config.key+'">x</span>' );
		 	$btn = $( '<hr><div class="btn btn-warning" id="button'+config.key+'">Select Image</div>' );
		 	$content = $( '<div class="images-content row" id="imagescontent'+config.key+'"></div>' );
		 	$this.parent().append( $rm );
	 		$this.parent().append( $content );

		 	$this.parent().append( $btn );

 			$rm.click( function(){ $this.val(''); } );

		 	$content.delegate(".image-item", "click",function(){
 				if( confirm(config.confirmdel) ){
 					var value = $this.val().replace( $(this).attr('data-image'), '' ).replace(/,,/,'').replace(/,$/,'');
 				 	$this.val( value );

 					$(this).remove();
 				}
 			});


		 	var a = $this.val().split(/,/);
		 	if(  $this.val() && a.length > 0 && config.preview ){
		 	 	$.each(a, function(i,v){
		 	 		if( $.trim(v) != "" ){
		 	 	 		var img = $('<div data-image="'+v+'" class="col4 image-item image-preview active"><img src="'+PTS_PAGEBUILDER_FILE_URI+v+'"></div>');
		 	 	 		$content.append(img);
		 	 	 	}
		 	 	} );
		 	 } 


		 	$btn.click( function(){
		 		showGalleryModal(  $this );
		 	} );


		});
	 
		return this;
	};
	
})(jQuery);