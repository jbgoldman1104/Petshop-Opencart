
function reloadLanguage( langcls ){
     $('.switch-langs').hide();

      $('.'+langcls).show();

      $(".group-langs ul li").click( function(){
           $('.switch-langs').hide();
            $('.'+ $(this).data('lang') ).show();
      } );
} 

$( document).ready( function(){
	widgetsFillter();
} );
 function widgetsFillter(){  

 

		 	$("#searchwidgets").keypress( function( event ){
			
				if ( event.which == 13 ) {
				    event.preventDefault();
				}
				var $this = this;
				setTimeout( function(){
			 		 if( $.trim($("#searchwidgets").val()) !="" ) {
						$(".wpo-wg-button").hide(); 
						$( "div.widget-title:contains("+$("#searchwidgets").val()+")" ).parent().parent().show();
					}else { 
					 	$(".wpo-wg-button").show();
					}

				 }, 300 );

			} );

		 	$( '.filter-option' ,"#filterbygroups").click( function(){
		 		$( '.filter-option' ,"#filterbygroups").removeClass( 'active' );
		 		$(this).addClass( 'active' );
		 		if( $(this).data('option') == 'all' ) {
		 			$(".wpo-wg-button").show();  
		 		}else {
		 			$(".wpo-wg-button").hide();  
		 			$('[data-group='+$(this).data('option')+']').show();
		 		}	
		 		return false; 
		 	} );

	}
(function($) {
	$.fn.PavWidgetOperator = function(opts) {
		// default configuration
		var config = $.extend({}, {
		 	url:null
		}, opts);

 		var wid = 0;

 		this.delete = function( col, update ){
 			wid = $(this).attr( 'id' ).replace('pavowid-','');		
 			var $this = this;
 			$.ajax({
	            type: 'POST',
	            url: config.url+'&delete=1',
	            data: 'id=' + wid,
	            dataType:'JSON',
	            success: function (data) {
	                $(this).remove();
	            }
	        });

 			this.remove();
 		};

 		this.add = function( col ){
 			$('#myModal .btn-submit').unbind(  'click' );
 			var $this = this;
 			var type = $(this).children('div').data('widget');
 			// alert(type);
 			$.ajax({
				url: config.url,
				data:'id='+wid+'&type='+type,
				type:'POST',
				}).done(function( data ) {		
	 				$('#myModal .modal-body').html( data );
	 				$('#myModal').modal();
	 				$('#mdwidgetbuttons').modal('hide');
	 				  $('.input-langs').summernote({focus: true});
 		    });	 	


			$('#myModal .btn-submit').bind( 'click', function() {
				//var aHTML = $('.input-langs').code(); //save HTML If you need(aHTML: array).
 				//$('.input-langs').destroy();	
				$.ajax({
		            type: 'POST',
		            url: config.url+'&savedata=1',
		            data: $('#myModal form').serialize(),
		            dataType:'JSON',
		            success: function (data) {
		            var d = new Date();
					var n = d.getTime(); 

		             var w = $('#wpo_'+data.type).clone();

		             w.attr( 'id', w.attr('id')+n );

		             var ww = $('<div id="pavowid-'+data.id+'" class="pavo-widget"></div>')  

		             ww.append( w );
		             col.children('div').append( ww );
		             var a =  $(col).data( 'widgets') ;

		             if( $(col).data( 'widgets') ){   
 						if( $(col).data( 'widgets').indexOf("wid-"+data.id ) == -1 ) { 
 							$(col).data( 'widgets', a +"|wid-"+data.id );

 						}
 					}else { 
 						$(col).data( 'widgets', "wid-"+data.id );
 				 	}

 				 	$this.saveMenuData();	
		            $('#myModal').modal( 'hide' ); 
		                if( $('#pavowid-'+data.id).length > 0 ){  
		                	$('#pavowid-'+data.id + ' .widget-desc' ).html( data.name );
		                }
		            }
		          	

		        });


				return false; 
			} );

 		};

 		this.saveMenuData = function(){
	 	 	var output = new Array();	
	 	 	 $("#megamenu-content #mainmenutop li.parent").each( function() {
				 	var data = $(this).data();
				 	data.rows = new Array();

				 	$(this).children('.dropdown-menu').children('div').children('.row').each( function(){
				 		var row =  new Object();
				 		row.cols = new Array();
			 			$(this).children(".mega-col" ).each( function(){
			 				row.cols.push( $(this).data() );
			 			} );
			 			data.rows.push(row);
				 	} );

				 	output.push( data );  
	 	 	 }  );
 	 	 	var j = JSON.stringify( output ); 
 	 	 	var params = 'params='+j;
 	 	 	$.ajax({
				url: config.action_menu,
				data:params,
				type:'POST',
				}).done(function( data ) {
		 	  
		   });
	 	};


		this.edit = function(){
			wid = $(this).attr( 'id' ).replace('pavowid-','');				
			// $('#myModal .modal-body').html( a );
			$('#myModal .btn-submit').unbind(  'click' );
			$.ajax({
				url: config.url,
				data:'id='+wid,
				type:'POST',
				}).done(function( data ) {		
	 				$('#myModal .modal-body').html( data );
	 				$('#myModal').modal( );

	 				
 				 	  $('.input-langs').summernote({focus: true});

 		    });	
			//	alert('input-langs');
		 		
			$('#myModal .btn-submit').bind( 'click', function() {
				
				//var aHTML = $('.input-langs').code(); //save HTML If you need(aHTML: array).
 				//$('.input-langs').destroy();	

				$.ajax({
		            type: 'POST',
		            url: config.url+'&savedata=1',
		            data: $('#myModal form').serialize(),
		            dataType:'JSON',
		            success: function (data) {
		               
		                $('#myModal').modal( 'hide' ); 

		                if( $('#pavowid-'+data.id).length > 0 ){  
		                	$('#pavowid-'+data.id + ' .widget-desc' ).html( data.name );
		                }
		            }
		        });


				return false; 
			} );
	

		}
	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {  
			




		});
		 

		return this;
	};
	
})(jQuery);