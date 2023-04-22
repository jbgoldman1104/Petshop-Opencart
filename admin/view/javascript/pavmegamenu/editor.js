/******************************************************
 * @package Pav Megamenu module for Opencart 1.5.x
 * @version 2.0
 * @author http://www.pavothemes.com
 * @copyright	Copyright (C) Steptember 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

(function($) {
	$.fn.PavMegamenuEditor = function(opts) {
		// default configuration
		var config = $.extend({}, {
			lang:null,
			opt1: null,
			action:null,
			action_menu:null,
			text_warning_select:'Please select One to remove?',
			text_confirm_remove:'Are you sure to remove this?',
			JSON:null
		}, opts);

		/**
		 * active menu 
		 */
		var activeMenu = null;
	
		/**
	 	 * fill data values for  top level menu when clicked menu.
	 	 */	

		function processMenu( item , _parent, _megamenu ){
		
			$(".form-setting").hide();
		    $("#menu-form").show();
			$.each( $("#menu-form form").serializeArray(), function(i, input ){  
				var val = '';
				if( $(_parent).data( input.name.replace("menu_","")) ){
					val = $(_parent).data( input.name.replace("menu_",""));
				}
				 $('[name='+input.name+']',"#menu-form").val(  val );	
			});

			if( activeMenu.data("align") ){ 
				$(".button-alignments button").removeClass("active");
				$( '[data-option="'+activeMenu.data("align") +'"]').addClass("active");
			}

		}

		/**
	 	 * fill data values for  top level menu when clicked Sub menu.
	 	 */	
		function processSubMenu( item , _parent, _megamenu ){
 			
			var pos =  $(item).offset();
		    $('#submenu-form').css('left',pos.left  - 30 );
			$('#submenu-form').css('top',pos.top - $('#submenu-form').height() );
	 		$("#submenu-form").show();
			
			$.each( $("#submenu-form form").serializeArray(), function(i, input ){ 
				 $('[name='+input.name+']',"#submenu-form").val( $(_parent).data( input.name.replace("submenu_",""))  );	 	
			} ) ;
	 	 
		}

		/**
	 	 * menu form handler
	 	 */	 
		function menuForm(){
			$("input, select","#menu-form").change( function (){

			 	if( activeMenu ){
			 		if( $(this).hasClass('menu_submenu')   ) {
					 	var item = $("a",activeMenu);
				 		if( $(this).val()  && !$(item).hasClass( 'dropdown-toggle' ) ) {
				 			$(item).addClass( 'dropdown-toggle' );
				 			$(item).attr( 'data-toggle', 'pavo-dropdown' );
				 			var html = ( '<div class="row-tools clearfix"> <div class="w-sicon row-addcol"></div><div class="w-sicon row-delete"></div></div>' );
				 		 	var div = '<div class="dropdown-menu"><div class="dropdown-menu-inner"><div class="row active">'+html+'</div></div></div>';
				 		 	
				 		 	

				 		 	$(activeMenu).addClass('parent').addClass('dropdown');
				 		 	$(activeMenu).append( div );

				 		 	$(activeMenu).removeClass('disable-menu');
				 		} else if(  $(this).val() == 1 ) {
			 				$(activeMenu).removeClass('disable-menu');
				 		}else {
			 				$(activeMenu).addClass('disable-menu');
				 		}
				 		$(activeMenu).data('submenu', $(this).val() );
				 	}else if( $(this).hasClass('menu_subwidth') ){
				 		var width = parseInt( $(this).val() );
				 		if( width > 200 ){
				 			$(".dropdown-menu", activeMenu ).width( width );
				 			$(activeMenu).data('subwidth', width ); 
				 		}
				 	}	
			 	}	
		 	} );


		 	$("input.menu_subwidth","#menu-form").keypress( function( event ){
			
				if ( event.which == 13 ) {
				    event.preventDefault();
				}
				var $this = this;
				 setTimeout( function(){
			 		var width = parseInt( $($this).val() );
				 	if( width > 199 ){
			 			$(activeMenu ).children('.dropdown-menu').width( width );
			 			$(activeMenu ).children('.dropdown-mega').width( width );
			 			$(activeMenu).data('subwidth', width );
			 		}

				 }, 300 );
			} );

		}

		/**
	 	 * submenu handler.
	 	 */	
		function submenuForm(){
			$("select, input", '#submenu-form').change( function(){
			 	 if( activeMenu ){
			 	 	if( $(this).attr('name') == 'submenu_group' ){ 
			 	 		if( $(this).val() == 1 ){
		 	 				$(activeMenu).addClass('mega-group');
					 		$(activeMenu).children(".dropdown-menu").addClass('dropdown-mega').removeClass('dropdown-menu');
					 		
			 	 		}else {
					 		$(activeMenu).removeClass('mega-group');
					 		$(activeMenu).children(".dropdown-mega").addClass('dropdown-menu').removeClass('dropdown-mega'); 
					 	}
					 	$( activeMenu ).data('group', $(this).val() );
			 	 	}
			 	 }
			} );
		}

		/**
	 	 * listen Events to operator Elements of MegaMenu such as link, colum, row and Process Events of buttons of setting forms.
	 	 */	
		function listenEvents( $megamenu ){

			/**
			 *  Link Action Event Handler.
			 */
			$('.form-setting').hide();
			$( 'a', $megamenu ).click( function(event){
				
				var $this = this;
				var  $parent = $(this).parent();
				/* remove all current row and column are actived */
				$(".row", $megamenu).removeClass('active');
				$(".mega-col", $megamenu).removeClass('active');
				
			//	if( $parent.parent().hasClass('megamenu') ){
				 	var pos =  $(this).offset();
				    $('#menu-form').css('left',pos.left  - 30 );
					$('#menu-form').css('top',pos.top - $('#menu-form').height() );
			//	}

				 
 

 				activeMenu = $parent;  
			 	if( $parent.hasClass('dropdown-submenu') ){
			 		 $( ".dropdown-submenu", $parent.parent() ).removeClass( 'open' );
			 		 $parent.addClass('open');
			 		 processSubMenu( $this, $parent, $megamenu );
			 	}else {   
			 		if( $parent.parent().hasClass('megamenu') ){
	                	 $("ul.navbar-nav > li" ).removeClass('open');	
	             	}
	                $parent.addClass('open');
	              
                 	processMenu ( $this, $parent, $megamenu );
	              
	             } 
		         
		         event.stopPropagation();
		         return false;  
			});


			/**
			 * Row action Events Handler
			 */
			 $("#menu-form .add-row").click( function(){
			 	var row = $( '<div class="row"></div>'  );
			 	var r = $( '<div class="row-tools clearfix"> <div class="w-sicon row-addcol"></div><div class="w-sicon row-delete"></div></div>' );
			 	row.append( r );
			 	var child = $(activeMenu).children('.dropdown-menu').children('.dropdown-menu-inner');
			 	child.append( row );
			 	child.children(".row").removeClass('active');
			 	row.addClass('active');

			 });

			  $("#menu-form .remove-row").click( function(){
			  	if( activeMenu ){
			  		 var hasMenuType = false; 
			  		 $(".row.active", activeMenu).children('.mega-col').each( function(){
			  		 	if( $(this).data('type') == 'menu' ){
			  		 		hasMenuType = true;
			  		 	}
			  		 });

			  		if( hasMenuType == false ){
		  				$(".row.active", activeMenu).remove();	
		  			}else {
		  				alert( 'You can remove Row having Menu Item(s) Inside Columns' );
		  				return true;
		  			}
		  			removeRowActive();	
		  			saveMenuData( true );
			  	}
			  	
			 });

			 $($megamenu).delegate( '.row', 'click', function(e){ 
		 		$(".row",$megamenu).removeClass('active');
		 		$(this).addClass('active');  
		 		e.stopPropagation();
	    	 }); 

			 /**
			  * Column action Events Handler
			  */ 
			 $("#menu-form .add-col").click( function(){
		 		if ( activeMenu ){ 
		 			var num = 6; 
		 			var col = $( '<div class="col-sm-'+num+' mega-col active"><div><div class="col-tools"></div></div></div>'  );

		 			$(".col-tools",col).append( '<div class="w-sicon col-widget"></div>' );
		 			$(".col-tools",col).append( '<div class="w-sicon col-setting"></div>' );

		 			$(".col-tools",col).append( '<div class="w-sicon col-delete"></div>' );

		 			$(".mega-col",activeMenu).removeClass('active');
					$( ".row.active", activeMenu ).append( col );
					col.data( 'colwidth', num );
					var cols = $(".dropdown-menu .mega-col", activeMenu ).length; 
					$(activeMenu).data('cols', cols);
					recalculateColsWidth();
		 		}
			 } );


			
		 	$($megamenu).delegate( '.mega-col', 'click', function(e){

		 		$(".mega-col",$megamenu).removeClass('active');
		 		$(this).addClass('active');
		 	
		 		$(".row",$megamenu).removeClass('active');

		 		$(this).parent().addClass('active');
		 		$("#submenu-form").hide();
		 		$.each( $(this).data(), function( i, val ){
	 				$('[name='+i+']','#column-form').val( val );
	 			} );

		 		e.stopPropagation(); 
		 	} );

		 	$($megamenu).delegate( '.mega-col .col-setting', 'click', function(e){
	 		 	var pos =  $(this).parent().offset();
		 		$("#column-form").css({'top':pos.top-$("#column-form").height()-20, 'left':pos.left}).show();
		 	});

		 	$($megamenu).delegate( '.mega-col .col-delete', 'click', function(e){
		 		var activeCol = $(this).parent().parent().parent();
	 			if( activeCol ){
			 		if( $(".mega-col.active", activeMenu).data('type') == 'menu' ) {
			 			alert('You could not remove this column having menu item(s)');
			 			return true;
			 		}else {
			 			if( confirm('Are you sure to delete?') ){ 
				 			$(".pavo-widget", activeCol ).each( function(){
			 					$(this).PavWidgetOperator( {url:config.action_wform} ).delete( $(".mega-col.active", activeMenu)  );
				 			} );
				 			$( activeCol).remove();
				 			removeColumnActive();
						  	recalculateColsWidth();	

						  	saveMenuData( true );
						}  	
			 		}
			 	}
		 	});

		 	$($megamenu).delegate( '.col-widget', 'click', function(e){
		 		 $('#mdwidgetbuttons').modal('show');
		 	});

				
			$($megamenu).delegate( '.row-delete', 'click', function(e){
				if( confirm(config.text_confirm_remove) ){
					var r = $(this).parent().parent();
		 			r.remove();
		 			saveMenuData( true );
				}
		 	});

		 		
			$($megamenu).delegate( '.row-addcol', 'click', function(e){
				if( activeMenu ) {
					var num = 6; 
					var row = $(this).parent().parent();


		 			var col = $( '<div class="col-sm-'+num+' mega-col active"><div><div class="col-tools"></div></div></div>'  );

		 			$(".col-tools",col).append( '<div class="w-sicon col-widget"></div>' );
		 			$(".col-tools",col).append( '<div class="w-sicon col-setting"></div>' );

		 			$(".col-tools",col).append( '<div class="w-sicon col-delete"></div>' );

		 			$(".mega-col",activeMenu).removeClass('active');

		 			$("#mainmenutop .row" ).removeClass('active');
		 			row.addClass('active');

					$(  row ).append( col );
					col.data( 'colwidth', num );
					var cols = $(".dropdown-menu .mega-col", activeMenu ).length; 
					$(activeMenu).data('cols', cols);
					recalculateColsWidth();
				}	
		 	});


		 		

		 	/**
		 	 * Column Form Action Event Handler
		 	 */
		 	$('input, select', '#column-form').change( function(){
		 		if( activeMenu ) {
		 			var col = $( ".mega-col.active", activeMenu );
		 			if( $(this).hasClass('colwidth') ){
		 				var cls = $(col).attr('class').replace(/col-sm-\d+/,'');
		 				$(col).attr('class', cls + ' col-sm-' + $(this).val() );
		 			}
		 			$(col).data( $(this).attr('name') ,$(this).val() );
		 		}	
	 		} );

		 	$(".form-setting").each( function(){
		 		var $p = $(this);
		 		$(".popover-title span",this).click( function(){
		 			if( $p.attr('id') == 'menu-form' ){
		 				removeMenuActive();
		 			}else if( $p.attr('id') == 'column-form' ){
		 				removeColumnActive();
		 			}else {
		 				$('#submenu-form').hide();
		 				 
		 			}
		 		} );
		 	} );
	 		
	 		$( ".form-setting" ).draggable();	

 			/**
 			 * inject widgets
 			 */
 			 $("#btn-inject-widget").click( function(){
 			 	var wid = $('select', $(this).parent() ).val();	
 				if( wid > 0 ){
 					var col = $( ".mega-col.active", activeMenu ); 
 					var a =  $(col).data( 'widgets') ;

 					if( $(col).data( 'widgets') ){  
 						if( $(col).data( 'widgets').indexOf("wid-"+wid ) == -1 ) { 
 							$(col).data( 'widgets', a +"|wid-"+wid );
 						}
 					}else { 
 						$(col).data( 'widgets', "wid-"+wid );
 				 	}
		 			$(col).children('div').html('<div class="loading">Loading....</div>');
 				 	$.ajax({
						url: config.action_widget,
						data:'widgets='+$(col).data( 'widgets'),
						type:'POST',
						}).done(function( data ) {
				 		$(col).children('div').html( data );
				   });

 				}else {
 					alert( 'Please select a widget to inject' );
 				}
 			 } );


 			 /**
 			  * unset mega menu setting
 			  */
 			  $("#unset-data-menu").click( function(){
 				 if( confirm('Are you sure to reset megamenu configuration') ){
 				    $.ajax({
						url: config.action,
						data: 'reset=1',
						type:'POST',
						}).done(function( data ) {
					 		 location.reload();
				    });
				}
				return false;			 	
 			  } ); 

 			//   console.log( $megamenu );
 			  $($megamenu).delegate( '.pavo-widget', 'mouseover', function(){ 
		 		//$(".row",$megamenu).removeClass('active');
		 		// $(this).addClass('active'); 
	    	 	 var w = $(this);   
	    	 	 	var col = $(this).parent().parent(); 
	    	 	 if( $(this).find('.w-setting').length<= 0 ){
	    	 	 	var _s = $('<span class="w-setting w-sicon"></span>');
	    	 	 	var _d = $('<span class="w-delete w-sicon"></span>');

	    	 	 	$(w).append(_s);
	    	 	 	$(w).append(_d);
	    	 	 	_d.click( function(){
	    	 	 		if( confirm(config.text_confirm_remove) ){
		    	 	 		var dws = col.data('widgets')+"|"; 
		    	 	 
		    	 	 	 	dws = dws.replace( $(w).attr('id').replace("pavo",'')+"|",'' ).replace(/\|$/,'');

		    	 	 		col.data('widgets',dws);  
		    	 	 		$(w).PavWidgetOperator( {url:config.action_wform} ).delete( col );
	    	 	 		}

	    	 	 	} );
	    	 	 	_s.click( function(){
	    	 	 		$(w).PavWidgetOperator( {url:config.action_wform} ).edit();
	    	 	 	} );
	    	 	 }
	    	 }); 


			$(".button-alignments button").click( function(){
 				if( activeMenu ){
	 				$(".button-alignments button").removeClass( "active");
	 				$(this).addClass( 'active' );

	 				$(activeMenu).data( 'align', $(this).data("option") );
	 			 	var cls = $( activeMenu ).attr("class").replace(/aligned-\w+/,"");	
	 			  	$( activeMenu ).attr( 'class', cls );
	 				$( activeMenu ).addClass( $(this).data("option") );
 				}
 			} );



		}

		function recalculateColsWidth(){
			if( activeMenu ){   	 
				var childnum = $( "#mainmenutop .row.active" ).children(".mega-col").length;

				var dcol = Math.floor( 12/childnum );
				var a = 12%childnum;
				$( "#mainmenutop .row.active" ).children(".mega-col").each( function(i, col ) {
					if( a > 0 && (i == childnum-1) ){
			 			dcol = dcol+a;
					}
		 			var cls = $(this).attr('class').replace(/col-md-\d+/,'');
		 			$(this).attr('class', cls + ' col-md-' + dcol );
					$(this).data( 'colwidth', dcol );
				});
			}
		}
		
	 	/**
	 	 * remove active status for current row.
	 	 */
	 	function removeRowActive(){
	 		$('#column-form').hide();
 			$( "#mainmenutop .row.active" ).removeClass('active');
	 	}

	 	/**
	 	 * remove column active and hidden column form.
	 	 */
	 	function removeColumnActive(){
	 		$('#column-form').hide(); 
	 		$( "#mainmenutop .mega-col.active" ).removeClass('active');
	 	}

	 	/**
	 	 * remove active status for current menu, row and column and hidden all setting forms.
	 	 */
	 	function removeMenuActive(){
	 		$('.form-setting').hide();
	 		$( "#mainmenutop .open" ).removeClass('open');
	 		$( "#mainmenutop .row.active" ).removeClass('active');
 			$( "#mainmenutop .mega-col.active" ).removeClass('active');
 			if( activeMenu ) {	
		 		activeMenu = null;
	 		}
	 	}

	 	/**
	 	 * process saving menu data using ajax request. Data Post is json string
	 	 */	
	 	function saveMenuData( noreload ){
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
				 if( noreload ){

				 }else { 
		 		 	location.reload();	
		 		 }
		   });
	 	}

	 	/**
	 	 * Make Ajax request to fill widget content into column
	 	 */
	 	function loadWidgets(){
	 		$("#pavo-progress").hide();
	 		var ajaxCols = new Array();
	 		$("#megamenu-content #mainmenutop .mega-col").each( function() {
	 		 	var col = $(this);		
	 		 	
	 		 	if( $(col).data( 'widgets') && $(col).data("type") != "menu" ){  
	 		 		ajaxCols.push( col );
				}		
	 		});

	 		var cnt = 0;
	 		if( ajaxCols.length > 0 ){
	 			$("#pavo-progress").show();
	 			$("#megamenu-content").hide();
	 		}
	 		$.each( ajaxCols, function (i, col) {
	 			$.ajax({
					url: config.action_widget,
					data:'widgets='+$(col).data( 'widgets'),
					type:'POST',
					}).done(function( data ) {
			 		col.children('div').append( data );
			 		cnt++;  
			 		$("#pavo-progress .progress-bar").css("width", (cnt*100)/ajaxCols.length+"%" );
			 		if( ajaxCols.length == cnt ){
			 			$("#megamenu-content").delay(1000).fadeIn();
			 			$("#pavo-progress").delay(1000).fadeOut();
			 		}
		 			$( "a", col ).attr( 'href', '#megamenu-content' );
			   });	
	 		});
	 	}

	 	/**
	 	 * reload menu data using in ajax complete and add healders to process events.
	 	 */	
	 	function reloadMegamenu(){
			var megamenu = $("#megamenu-content #mainmenutop");
			$( "a", megamenu ).attr( 'href', '#' );
			$( '[data-toggle="dropdown"]', megamenu ).attr('data-toggle','pavo-dropdown'); 
			listenEvents( megamenu );
			submenuForm();
			menuForm();
			

			$( '.mega-col ', megamenu ).each( function(){
				if( $(this).data('type') != 'menu' ) {
					$(this).children('div').append( '<div class="col-tools"><div class="w-sicon col-widget "></div><div class="w-sicon col-setting"></div><div class="w-sicon col-delete"></div></div>' );
				}else {
					$(this).children('div').children('ul').before( '<div class="col-tools"><div class="w-sicon col-setting"></div></div>' );
				}
			} );


			$( '.dropdown-menu-inner  .row ', megamenu ).each( function(){
				var r = $( '<div class="row-tools clearfix">  <div class="w-sicon row-addcol"></div><div class="w-sicon row-delete"></div></div>' );
				if(  $('.mega-col',this).length > 0 ){
					$(r).insertBefore( $('.mega-col',this).first() );
				}else {
					$(this).append( r );
				}
			} );


			loadWidgets();

			$('.wpo-widgets').delegate('.wpo-wg-button','click', function(){
				$(this).PavWidgetOperator( {'url':config.action_wform, 'action_menu':config.action_menu} ).add(  $(".mega-col.active", activeMenu) );
			});
	 	}

	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {  
			var megamenu = this;
 
			$("#form-setting").hide();
			
			$.ajax({
				url: config.action,
				}).done(function( data ) {
			 		$("#megamenu-content").html( data );
			 		reloadMegamenu(  );
			 		$("#save-data-menu").click( function(){
			 			saveMenuData();
			 		} );
		   });
		});
		//disable submit form with Enter key
		$(".form-setting input").keypress(function(event) {
			if (event.which == 13) {
				event.preventDefault();
				return false;
			}
		});


		return this;
	};
	
})(jQuery);
