/**
 * Slider Editor
 *
 * @copyright Commercial License By PavoThemes.Com 
 * @email pavothemes@gmail.com
 * @visit http://www.pavothemes.com
 */

(function( $ ) {
 
	$.fn.pavoSliderEditor = function( initvar ) {

 		/**
 		 * Variables.
 		 */
 		this.data = null; 
 		this.currentLayer = null;
 	 	this.stoolbar = $( "#slider-toolbar .slider-toolbar" );
		this.seditor  = $( "#slider-toolbar .slider-editor" );
		this.ilayers  = $( "#slider-toolbar .layer-collection" );
		this.lform    = $("#layer-form");
		this.siteURL  = null;
		this.adminURL = null;
		this.countItem = 0;
		this.delayTime = 9000;
		this.state = false;
		/**
		 * Create List Layers By JSON Data.
		 */
		this.createList = function( JSLIST  ){

 			 var list  = jQuery.parseJSON( JSLIST );
 			 var $this = this;
			 var $stoolbar = $( "#slider-toolbar .slider-toolbar" );	
			 var layer = '';
			 if( list ) {
	 			 $.each( list, function(i, jslayer ){
	 			 	var type = list[i]['layer_type']?'add-'+list[i]['layer_type']:'add-text';

			 		layer = $this.createLayer( type, list[i] , list[i]['layer_id'] );

			 		$this.countItem++;
	 			 });
 			}
 		}

 		/**
 		 * Crete A Layer By Type with Default data or specified data.
 		 */
 		this.createLayer = function( type, data, slayerID ){
			var $this=this;
 			var layer = $('<div class="draggable-item tp-caption"><div class="caption-layer"></div></div>');
	 		layer.attr('id','slayerID'+ slayerID ); 
	 		var ilayer = $('<div class="layer-index"></div>').attr("id","i-"+layer.attr("id"));
	 		ilayer.append( '<div class="slider-wrap"><div class="t-start">0ms</div><div class="t-end">'+$this.delayTime+'ms</div><div class="slider-timing" id="islider'+slayerID+'"></div></div><div class="clearfix"></div>' );
	 		ilayer.append( '<span class="i-no">'+($(".draggable-item",$this.seditor).length+1)+'</span>' );
	 		ilayer.append( '<span class="layer-index-caption"></span>' );
	 		ilayer.append( '<div class="input-time"><input type="text" id="input-islider'+slayerID+'" name="layer_time['+slayerID+']" size="3" value="400"/></div>' );
	 		ilayer.append( '<span class="status">show</span>' );

	 		switch( type ){
	 			case 'add-text':  
	 				$this.addLayerText( layer , ilayer,  "Your Caption Here " + slayerID );
	 				break;
	 			case 'add-video': 
	 				$this.addLayerVideo( layer , ilayer,  "Your Video Here "+ slayerID  );
	 				break;
	 			case 'add-image': 
	 				$this.addLayerImage(layer , ilayer,  "Your Image Here " + slayerID );
	 				break;	
	 			
	 		}
	 	 
 	
	 		$("#layer_id").val( slayerID );
	 		
	 		// create slider timing 
	 		$('#islider'+slayerID).slider( { max:$this.delayTime,
	 										 value:(400*$this.countItem),	
	 										 slide:function(event, ui ){
	 										 	$('#input-islider'+slayerID).val( ui.value );	
	 										 }
	 									} ); 
	 		$('#input-islider'+slayerID).val( 400*$this.countItem );	
 			// auto set current active.
 			
	 		$this.setCurrentLayerActive( layer );	
	 		//auto bind the drag and drap for this 
	 		$(layer).draggable({ containment: "#slider-toolbar .slider-editor",
	 							 drag:function(){
	 							 	$this.setCurrentLayerActive( layer );
	 							 	$this.updatePosition( layer.css('left'), layer.css("top") );
	 							 },
	 							 create:function(){
	 							 	$this.createDefaultLayerData( layer, data );
	 							 }
	 		});

	 	
			// bind current layer be actived when this selected. 	    
	 	    layer.click( function() { 
	 			$this.setCurrentLayerActive( layer );	 
	 		});
	 		$("#i-"+layer.attr("id") ).click( function(){
	 		  if( $this.currentLayer != null ){
	 		  	$this.storeCurrentLayerData();
	 		  }
	 		  $this.setCurrentLayerActive(layer); 
	 		} );


	 		/// insert typo

	 		
	 		return layer;
 		};

 		
 		/**
 		 * Process All First Handler.
  		 */
		this.process = function( siteURL , adminURL, delayTime ) {
		
			this.siteURL =  siteURL;
			this.adminURL = adminURL;
			this.delayTime = delayTime;
			var $this=this;

			$( "div.btn-create", $this.stoolbar ).click( function(){  
				 
				var layer = $this.createLayer( $(this).attr("data-action"), null, ++$this.countItem );
				if( $(this).attr("data-action") == 'add-image' ){

					$this.showDialogImage(  'img-'+layer.attr('id') );
				}
				if( $(this).attr("data-action") == 'add-video' ){
					$this.showDialogVideo(  );
				}
		 		return false;
			} );
			
			$(".btn-delete").click( function(){
				$this.deleteCurrentLayer();
			} );
			
			/////////// FORM SETTING ///////////
			// auto save when any change of element form.
			$('input, select ,textarea', '#slider-form' ).change( function(){  
				if( $(this).attr('name') =='layer_top' || $(this).attr('name') == 'layer_left' ) {  
					$this.currentLayer.css( { top:$( '[name="layer_top"]','#slider-form' ).val()+"px",			
					 						  left:$( '[name="layer_left"]','#slider-form' ).val()+"px"				
					 						});	
				}
				$this.state=true;
				$this.storeCurrentLayerData();  
				
			});
			// auto fill text for name or any.
			$('#input-slider-caption', '#slider-form' ).keypress( function(){  
				 
				 	
				 setTimeout(function ()
				 { 
				    $(".caption-layer",$this.currentLayer).html( $('#input-slider-caption', '#slider-form' ).val()  );
				 	$('.layer-index-caption',"#i-"+$this.currentLayer.attr("id") ).text( $(".caption-layer",$this.currentLayer).text() );	
				 }, 6);
				$this.state = true;
			});

	
			/**** GLOBAL PROCESS ****/
		    $(".draggable-item", this.seditor).draggable({ containment: "#slider-toolbar .slider-editor" });
		    $(".layer-collection").sortable({ accept:"div",
		    								  update:function() {   
		    								  		var j = 1;
		    								  		$(".layer-index",$this.ilayers).each( function(i, e){ 
		    								  			$(".i-no",e).html( (j++) ) ;
		    								  		//	$("#"+e.replace("i-","").css('z-index',j));
		    								  		});		
		     							      } 
		    });
		  	$this.ilayers.delegate( '.status','click', function(){
		     	$(this).toggleClass('in-active');  
		     	$('#'+($(this).parent('.layer-index').attr("id").replace("i-","") ) ).toggleClass("in-active");	
		    } );
	 		
	 		// change image 

 			$this.seditor.delegate( '.btn-change-img','click', function(){
	     		$this.showDialogImage(  'img-'+$this.currentLayer.attr('id') );	
		    } );
		    $this.seditor.delegate( '.btn-change-video','click', function(){
	     		$this.showDialogVideo	(   );	
		    } );

		    $("#dialog-video .layer-find-video").click( function (){
		    	if( $("#dialog_video_id").val() ){
		    		$this.videoDialogProcess( $("#dialog_video_id").val() );	
		    	}
		    	else {  
					$("#video-preview").html( '<div class="error">Could not find any thing</div>' );
				}
		    	
			});
			$("#apply_this_video").click( function(){   
 				$("#video-"+ $this.currentLayer.attr('id') ).html('<img  width="'+$( '[name="layer_video_width"]','#slider-form' ).val()+'"  height="'+$( '[name="layer_video_height"]','#slider-form' ).val()+'" src="'+$("#layer_video_thumb").val()+'"/>') 	;
 				$("#dialog-video").hide();
 				 
 				$this.storeCurrentLayerData();
 			} );


			// BUTTON CLICK
 			$("#btn-insert-typo").bind('click', function(){ 
 				$this.insertTypo();
 			});

 			$("#btn-preview-slider").bind('click', function(){
 				$this.preview();
 			});


 			/** SUBMIT FORM **/
 		 	this.submitForm();
		};

		this.submitForm = function(){
			var $this = this;
			$("#slider-form").submit( function(){
					 var data =[];
					 var i = 0;
					 var params = 'id='+$("#slider_id").val()+"&"+$("#slider-editor-form").serialize()+"&";
 
 					

					 var times = '';
					 $( "#slider-toolbar .slider-editor .draggable-item" ).each( function(){
			 			var param = '';
			 			$.each( $(this).data("data-form"), function(_,e ) {
								if( $(this).attr('name').indexOf('layer_time') ==-1 ){
									if( e.name == 'layer_caption' ){
										 e.value = e.value.replace(/\&/,'_ASM_');
									}  
 									param += 'layers['+i+']['+e.name+']='+e.value+'&';
								}
								
			 			}  );
			 			params += 	param+"&";
					 	i++
					 } );

					 $(".input-time input", $("#slider-form") ).each( function(i,e){
					 	params += $(e).attr('name') + "="+ $(e).val() + "&";
					 	 
					 } ); 


					 $.ajax( {url:$("#slider-form").attr('action'),  dataType:"JSON",type: "POST", 'data':params}  ).done( function(output){
				 		  if( output.error == 1 ){
				 		  	$("#slider-warning").html('<div class="warning">'+output.message+'</div>');
				 		  }else {
				  	  	 location.reload();
				 		  }
					 } );
					return false; 
			}  );
		};

 		this.getFormsData=function(){

 			 var data =[];
			 var i = 0;
			 var params = 'id='+$("#slider_id").val()+"&"+$("#slider-editor-form").serialize()+"&";
			 var times = '';
			 var objects = new Object();
			 objects.layers = new Object();
			 $( "#slider-toolbar .slider-editor .draggable-item" ).each( function(){
			 	var iobject = new Object();
	 			$.each( $(this).data("data-form"), function(_,e ) {
					if( $(this).attr('name').indexOf('layer_time') ==-1 ){
						iobject[e.name] = e.value;
					}
	 			}  );  

	 			iobject.time_start = $( "#input-islider"+iobject.layer_id ).val();

	 			objects.layers[i] = iobject; i++;
			 } );

		 	objects.params = new Object();
		 	objects.title = $('[name="slider_title"]',"#slider-editor-form").val();
		 	objects.status = $('[name="slider_status"]',"#slider-editor-form").val();
		 	objects.image = $('[name="slider_image"]',"#slider-editor-form").val();
		 	$.each( $("#slider-editor-form").serializeArray(), function(_,e ) {
		 		objects.params[e.name] = e.value;
		 	});	

		 	//	objects.params
			objects.times = new Object();

		 	return ( JSON.stringify(objects) );
 		}

		this.preview=function(){

			var params = this.getFormsData();

			$('#modal-previewLayer').remove();

			$.ajax({
				url: 'index.php?route=extension/module/pavsliderlayer/previewLayer&token=' + getURLVar('token'),
				type: "POST",
				data: { slider_preview_data: params },
				dataType: 'html',
				success: function(html) {
					$('body').append('<div id="modal-previewLayer" class="modal">' + html + '</div>');
					$('#modal-previewLayer').modal('show');
				}
			});
		};

		// 2. Fix Bug Cho Nay
		this.insertTypo=function(){
			var $this = this;
			var field = 'input-layer-class'; 
			var layer_id = 'slayerID' + $('#layer_id').val();
			var layer_class = $("#"+field).val();

			$('#modal-typo').remove();
			$.ajax({
				url: 'index.php?route=extension/module/pavsliderlayer/typo&token=' + getURLVar('token'),
				type: "POST",
				data: { field: field, layer_id: layer_id, layer_class: layer_class },
				dataType: 'html',
				success: function(html) {
					$('body').append('<div id="modal-typo" class="modal">' + html + '</div>');
					$('#modal-typo').modal('show');
				}
			});
			return false;
 		}

 		/**
 		 *
 		 */
 		this.showDialogVideo=function(  ){
			$("#dialog-video").show();	 
			this.videoDialogProcess( '' );
		}	
 		this.videoDialogProcess=function( videoID ){
 			var $this = this;
 			 
			var error = false;
			 
			if( videoID !="" ) {
 				
 				if( $("#layer_video_type").val() == 'vimeo' ) {
					$.getJSON('http://www.vimeo.com/api/v2/video/' + videoID + '.json?callback=?', {format: "json"}, function(data) {
					
						$this.showVideoPreview( data[0].title, data[0].description, data[0].thumbnail_large );
					});
				}else {
					$.getJSON('http://gdata.youtube.com/feeds/api/videos/'+videoID+'?v=2&alt=jsonc',function(data,status,xhr){ 
				 		$this.showVideoPreview( data.data.title, data.data.description, data.data.thumbnail.hqDefault )
					});
				}
			}
 		};

 		this.showVideoPreview=function( title, description, image ){
			
		 	if( title ){
		 		var html = '';
				html += '<div class="video-title">'+title+'</div>';	
			 	html += '<img src="'+image+'">';
			 	html += '<div class="video-description">'+description+'</div>';	
			 	$("#layer_video_thumb").val(image);	
		 		$("#video-preview").html( html );
		 		$("#apply_this_video").show();
		 	}else {
		 		$("#video-preview").html( '<div class="error">Could not find any thing</div>' );
		 	}
 		}
 		/**
 		 * Set Current Layer is Actived And Show Form Setting For It.
 		 */
 		this.setCurrentLayerActive = function ( layer ){
			$(".draggable-item", this.seditor).removeClass("layer-active");
	 		$( layer ).addClass("layer-active");
	 	 	
	 	 	$(".layer-index",this.layers).removeClass("layer-active");
	 	 	$("#i-"+layer.attr("id") ).addClass("layer-active");

	 	 	this.currentLayer = layer;

	 	 	this.showLayerForm( layer );	
		};	 	

		/**
		 * Add Layer Having Type Text
		 */
		this.addLayerText=function( layer, ilayer , caption ){  
			layer.addClass('layer-text');
			$(".caption-layer",layer ).html( caption );
			this.seditor.append( layer );
			$("#layer_type").val('text');
			this.ilayers.append( ilayer ); $(".layer-index-caption", ilayer).html( caption );
		};

		/**
		 * Add Layer Having Type Video: Support YouTuBe And Vimeo.
		 */
		this.addLayerVideo = function( layer, ilayer , caption ){
			layer.addClass('layer-content');
			$(".caption-layer",layer ).html( caption );
			this.seditor.append( layer );

			this.ilayers.append( ilayer ); $(".layer-index-caption", ilayer).html( caption );
			
			$("#layer_type").val('video');
			layer.append( '<div class="layer_video" id="'+'video-'+layer.attr('id')+'"><div class="content-sample"></div></div><div class="btn-change-video">Chang Video</div>' );

		};

		/**
		 * Add Layer Having Type Image.
		 */
		this.addLayerImage=function( layer, ilayer , caption ){
			layer.addClass('layer-content');
			$(".caption-layer",layer ).html( caption );
			layer.append( '<div class="layer_image" id="'+'img-'+layer.attr('id')+'"><div class="content-sample"></div></div><div class="btn-change-img">Chang Image</div>' );

			this.seditor.append( layer );
			this.ilayers.append( ilayer ); $(".layer-index-caption", ilayer).html( caption );
			
			$("#layer_type").val('image');
			$("#layer_content").val('');
			// show input form
		
		};

	
		this.showDialogImage=function( thumb ){
			$('#modal-image').remove();
			$.ajax({
				url: 'index.php?route=extension/module/pavsliderlayer/filemanager&token=' + getURLVar('token') + '&thumb=' + thumb,
				dataType: 'html',
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
					$('#modal-image').modal('show');
				}
			});
		}
		/**
		 * Delete Current Layer: Remove HTML and Data. Hidden Form When Delete All Layers.
		 */
		this.deleteCurrentLayer=function(){
			var $this = this;

			if( $this.currentLayer ){
				$( "#i-"+$this.currentLayer.attr("id") ).remove();
				$this.currentLayer.remove();	
				$this.currentLayer.data( "data-form", null );
				$this.currentLayer = null;
		//		if( $(".draggable-item",$this.seditor).length <= 0 ) {
					$this.lform.hide();
					$('#dialog').remove();
					$('#dialog-video').hide();
		//		}
			}else {
				alert( "Please click  one to delete" );
			}
		};

		/**
		 * Set Default Value For Data Element Form Of Layer With Default Setting Or Sepecified Data.
		 */
		this.createDefaultLayerData = function( layer, data ){
	 		var $this = this;	
	 		if( data !=null && data ) { 
		 		$.each( data , function(key, valu){	
		 			if( key!= 'layer_slider_id' ) {  
		 			 	if( key=='layer_caption' ){
		 			 		valu = valu.replace( /_ASM_/,'&' );
		 			 	}
	 					$( '[name="'+key+'"]','#slider-form' ).val(  valu );
	 				}
	 				
	 				if( key =='layer_top' ) {  
						$this.currentLayer.css( 'top', valu+'px');	
					}
					if( key == 'layer_left' ){
						$this.currentLayer.css( 'left', valu+'px');		
					}
			 	} ); 

		 		if(  data['layer_type'] == 'image' ){
					var thumb = 'img-'+$this.currentLayer.attr('id');
					var src = $this.siteURL+"image/"+data['layer_content'];
					$('#' + thumb).replaceWith('<img src="' + src + '" alt="" id="' + thumb + '" />');
					// this.siteURL 	
				}
				if(  data['layer_type'] == 'video' ){
					var thumb = 'video-'+$this.currentLayer.attr('id');
					var src = data['layer_video_thumb'];
					$(".content-sample",$this.currentLayer).html( '<img height="'+data['layer_video_height']+'" width="'+data['layer_video_width']+'" src="'+src+'"/>');
					// this.siteURL 	
				}
				if(  data['layer_type'] == 'text' ){
					 $this.currentLayer.addClass(  data['layer_class'] );
				}
				data['layer_caption'] = data['layer_caption'].replace(/_ASM_/,'&');
			 
				 $(".caption-layer",$this.currentLayer).html( data['layer_caption'] );
				  $(".layer-index-caption", '#i-slayerID'+data['layer_id']).text( $(".caption-layer",$this.currentLayer).text()  );

				 $( '[name="layer_time['+data['layer_id']+']"]','#slider-form' ).val( data['time_start'] );
	 			 $("#islider"+data['layer_id']).slider( 'value', data['time_start'] );

			 	//$this.currentLayer = layer;
	 		}else {

				$( '[name="layer_caption"]','#slider-form' ).val(  $(".caption-layer",layer).html() );
				$( '[name="layer_speed"]','#slider-form' ).val(  350 );
				$( '[name="layer_left"]','#slider-form' ).val(  0 );
				$( '[name="layer_top"]','#slider-form' ).val(  0 );
				$( '[name="layer_class"]','#slider-form' ).val(  '' );
				$( '[name="layer_speed"]','#slider-form' ).val(  350 );
				$( '[name="layer_endtime"]','#slider-form' ).val(  0 );
				$( '[name="layer_endspeed"]','#slider-form' ).val(  300 );
				$( '[name="layer_endanimation"]','#slider-form' ).val(  'auto' );
				$( '[name="layer_endeasing"]','#slider-form' ).val(  'nothing' );
				$( '[name="layer_content"]','#slider-form' ).val(  'no_image.png' );
		 	}
		 	this.storeCurrentLayerData();
		  
		};

		/**
		 * Update Position In Element Form Of Current When Draping.
		 */
		this.updatePosition = function( left, top ){
			 $( '[name="layer_top"]','#slider-form' ).val( parseInt(top) );
			 $( '[name="layer_left"]','#slider-form' ).val( parseInt(left) );

			this.storeCurrentLayerData();
		};

		/**
		 * Show Layer Form When A Layer Is Actived.
		 */
		this.showLayerForm = function( layer ){
		 	 // restore data form for
		 	 var $currentLayer = this.currentLayer;

			 if( $currentLayer.data("data-form") ){ 
			 	$.each( $currentLayer.data("data-form"), function(_, kv) {
			 		if( $(this).attr('name').indexOf('layer_time') ==-1 ){
						$( '[name="'+kv.name+'"]','#slider-form' ).val( kv.value );

					}
				} ); 
			 }
			 $("#layer-form").show();
		};

		/**
		 * Set Current Layer Data.
		 */
	 	this.storeCurrentLayerData=function(){

	 		 this.state = false; 
	 		 this.currentLayer.data( "data-form", $( '#slider-form' ).serializeArray() );
	 	};

		//THIS IS VERY IMPORTANT TO KEEP AT THE END
		return this;
	};
 
})( jQuery );
/***/