 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author     WPOpal  Team <wpopal@gmail.com, support@wpopal.com>
  * @copyright  Copyright (C) 2014 wpopal.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  * @addition this license does not allow theme provider using in themes to sell on marketplaces.
  * 
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/support/forum.html
  */

(function($) {
	/**
 	* WPO_Layout Plugin
 	*/

	$.fn.WPO_Layout = function( opts, datajson ) {
		
		/*
		 * default configuration
		 */
		var config = $.extend({}, {
			gutter	   :   30,
			coldwith   :   54,
			defaultcol :   3,
			col 	   :   12,
			confirmdel :   'Are you sure to delete?',
			urlwidgets :   'widgets.php',
			urlwidget  :   'form.php',
			urlwidgetdata: 'data.php',
			formsellector: '#frmsavealll',
			controller : 'AdminPtspagebuilderProfile'
		}, opts);

		/**
		 * store wrapper layout editor.
		 */
		var $wpolayout = null;

		/**
		 * store instances of WPO_Widget
		 */
		var $wpowidget = $("body").WPO_Widget( config );

		var $screenmode = 'large-screen';
		
		var $colkey = 'lgcol';

		/** 
		 * caculate total layout width based on column's width and gutter + number of columns 
		 */
		var layoutwidth = config.coldwith*config.col + ((config.col-1)*config.gutter);
	 	
	 	/**
	  	 *  preload widgets using for layout edtior and add some elements as suggest row to click add to new row.
	  	 */				
	  	function init(){ 
	  		$wpolayout.append('<div class="inner"></div>');
	  		$wpolayout.width( layoutwidth );
	  		addSuggestRow();
	  	};

	  		
	  	/**
	  	 * add new column element and append it before suggest column.
	  	 * 
	  	 * return Object col: jquery object of that column
	  	 */	
	  	function addColumn( scol, row ){
	  		$( ".lg-col", $wpolayout ).removeClass( "active" );	
	  		var col = $( '<div class="active lg-col wpo-col">\n\
                            <div class="inner clearfix"><div class="wpo-delete wpo-icon ptstooltip" data-toggle="tooltip" data-placement="top" title="Delete"></div>\n\
                            <div class="wpo-edit wpo-icon ptstooltip" data-toggle="tooltip" data-placement="top" title="Edit"></div>\n\
                            <div class="wpo-addrow wpo-icon ptstooltip" data-toggle="tooltip" data-placement="top" title="Add row"></div>\n\
                            <div class="wpo-addwidget wpo-icon ptstooltip" data-toggle="tooltip" data-placement="top" title="Add Widget"></div>\n\
                            <div class="wpo-content"></div></div></div>' );
	  		col.width( config.coldwith*3+2*config.gutter 	);
	  		col.insertBefore( scol );
	  		col.data( "colcfg", new WPO_DataCol() );

	  		bindingColEventS( col , row );		
	  		
	  		return col;
	  	}

	  	/* binding events for column */
	  	function bindingColEventS( col, row ){
	  		var maxWidth = layoutwidth; 
	  		col.resizable({
			    stop: function(event, ui) {  

				 	setTimeout( function(){
				 		var c =  Math.floor(config.col*col.width()/row.width())+1;
				 		maxWidth = row.width();
				 		if( c > 12 ){
				 			c = 12;
				 		}
						updateColsWidth(col,c);
					
						 
					 }, 200 );	
		 	
			    },
			     handles: 'e',
			     maxWidth:maxWidth+config.gutter,
			     minWidth:config.coldwith
			}); 
	  		col.click( function(event) {
	  			// $( ".wpo-edit", col ).click();
  				$( ".wpo-col", $wpolayout ).removeClass( "active" );	
	  			col.addClass( 'active' );
	  			$( "#col-builder" ).hide();
	  			event.stopPropagation();
	  		} );
			$( ".wpo-delete" ,col).click( function(){
				if( confirm(config.confirmdel) ){
					col.remove();  
		 			recalculateColsWidth( row );
		 		}
			} );

			// set default values or element'data 
			$( ".wpo-edit", col ).click( function(event){   
	  			var cfg = col.data("colcfg") ; 
	  			for( var k in cfg ){   
	  				if( $("[name="+k+"]", "#col-builder") ) {
	  					$("[name="+k+"]", "#col-builder").val( cfg[k] ); 
	  				}
	  				if( k.indexOf('color') != -1 ){ 
	  					if( cfg[k] ){  
	  						$("[name="+k+"]", "#col-builder").css({'background-color':'#'+cfg[k]}); 
	  					}else{
	  						$("[name="+k+"]", "#col-builder").css({'background-color':'#FFFFFF'}); 	
	  					}
	  				}	
	  			}
	  			$( ".wpo-col", $wpolayout ).removeClass( "active" );	
	  			col.addClass( 'active' );
	  			
	  			var pos = $( ".wpo-edit", col ).offset();
	  			var l = pos.left;  
	  			$( "#col-builder" ).css( {top:pos.top-$( "#col-builder" ).height()/2, left:l} ).show();

	  			
	  			event.stopPropagation();
	  		} );

			$( ".wpo-addwidget", col ).click( function(){
				$wpowidget.showWigetsList( col );
			} );

			// bind sortable event to re-sort widgets inside.
			$( ".wpo-content", col ).sortable({
				connectWith: ".wpo-col .wpo-content",
				 placeholder: "ui-state-highlight-widget",
				 over:function(event, ui ){   ui.item.width(ui.placeholder.width() ) }
			}); 

			$( '.wpo-addrow', col ).click( function(){
				addRow( col.children( '.inner' ), true ); 
			} );	
	  	}

	  	/* recaculate column width */
	  	function recalculateColsWidth( row ){
 	 	
			var childnum = $(row).children('.inner').children( ".wpo-col" ).length;
			var dcol = Math.floor( 12/childnum );
			var a = 12%childnum;

			$(row).children('.inner').children( ".wpo-col" ).each( function(i, col ) {
				if( a > 0 && (i == childnum-1) ){
		 			dcol = dcol+a;
				}
 				updateColsWidth( this, dcol );
	 		
			});
		 
		}

		function updateColsWidth( col, dcol ){  
			 
	     	$(col).css( {'width':dcol/config.col*100 +'%'} );  
 			var data =  $(col).data( 'colcfg' );
			data[$colkey] = dcol;
			$(col).data( 'colcfg', data );
		}

	  	function createColForm( idx, col ){

	  	}

	  	/**
	  	 * add new row element and append it before suggest row.
	  	 * 
	  	 * return Object col: jquery object of that column
	  	 */	
	  	function addRow( srow, sub ){

	  		var row = $( '<div class="wpo-row lg-row"><div class="wpo-tool"><div class="wpo-sortable ptstooltip" data-toggle="tooltip" data-placement="top" title="Sort"></div></div><div class="inner clearfix"></div></div>' );
	  		var edit = $('<div class="wpo-edit ptstooltip" data-toggle="tooltip" data-placement="top" title="Edit"></div>');
	  		var copy = $('<div class="wpo-copy ptstooltip" data-toggle="tooltip" data-placement="top" title="Duplicate"></div>');
	  		var del = $('<div class="wpo-delete ptstooltip" data-toggle="tooltip" data-placement="top" title="Delete"></div>');
	  		
	  		$(row).children(".wpo-tool").append(del).append(copy).append(edit);	
	  		
	  		bindingRowEvents( row , srow, sub );
	  		
			//row.insertBefore( srow );
			if( sub !=null && sub== true ){
				srow.append( row );	
				srow.addClass('hd-widgets-func');
				addSuggestColumn( row );
				row.addClass( 'active' );
			}else {
				$wpolayout.children('.inner').append( row );	
				addSuggestColumn( row );
				$wpolayout.children('.inner').children( ".wpo-row").removeClass( "active" );	
				row.addClass( 'active' );
			}
		
		
			row.data( "rowcfg", new WPO_DataRow() );

			return row;
	  	};

	  	/* clone data from orginal for new */
	  	function cloneData( data, target ){
			for( var k in target ){   
			 	target[k] = data[k];
			}
	  		return target;
	  	}

  		/* ROW PROCESS: add and create a setting form */	
	  	function bindingRowEvents( row , srow ){
	  		$(".wpo-tool .wpo-delete", row).click( function(){
	  			if( confirm(config.confirmdel) ){
	  				if( row.parent().children('.wpo-row').length<= 1 ){
	  					row.parent().removeClass( 'hd-widgets-func' );
	  				}
	  				
	  				row.remove();
	  			}
	  		} );

	  		$(".wpo-copy", row).click( function( event ){
	  			cloneLayoutInRow( row, srow );
	  		} );

	  		// set default values or element'data 
	  		$( ".wpo-edit", row ).click( function(event){ 
	  			var cfg = row.data("rowcfg") ; 
	  			for( var k in cfg ){
	  				$("[name="+k+"]", "#row-builder").val( cfg[k] ); 

	  				if( k.indexOf('color') != -1 ){ 
	  					if( cfg[k] ){  
	  						$("[name="+k+"]", "#row-builder").css({'background-color':'#'+cfg[k]}); 
	  					}else{
	  						$("[name="+k+"]", "#row-builder").css({'background-color':'#FFFFFF'}); 	
	  					}
	  				}	
	  			}

	  			var pos = $( row ).offset(); 
	  			var l = pos.left;
	  			var ll = $(this).offset().left
  				$( "#row-builder" ).css( {top:pos.top-$( "#row-builder" ).height()/2, left:ll} ).show();

  				$(".wpo-row.active").removeClass( 'active' );
  				$(row).addClass( 'active' );
				 event.stopPropagation();
	  		} );

	  		row.click( function( event ){
	  			$( ".wpo-row", $wpolayout ).removeClass( "active" );
	  			row.addClass( "active" );
	  			$( "#row-builder" ).hide();
	  			event.preventDefault();

	  		} );

	  		row.delegate( ".sg-col", "click", function(){ 
	  			addColumn( $(this), row );
	  		 	recalculateColsWidth( row ); 
	  		} );	
	  		 
	  		// bind sortable for this to sort columns on current row and other rows.	
		 	$( row ).children('.inner').sortable({
				connectWith: ".wpo-row > .inner", 
				placeholder: "ui-state-highlightcol",
	 			update:function( event, ui ){  
	 			
	 			},
	 			
	 			remove:function(){  
	 			 	var trow = $(this).parent();
 			   		 recalculateColsWidth( trow );
	 			},
	 			start:function( event, ui ){
	 		 		$( '.ui-state-highlightcol', row ).width( $(ui.item).width() );
	 			},
	 			receive: function( event, ui ) {
	 			   	 var trow = $(this).parent();
 			   		 recalculateColsWidth( trow );
	 			},
	 			cancel: ".wpo-sortable, .add-col"
			});	 
		 	 		
	  	}
		
		function cloneLayoutInRow( row, sub, incol ){
			
			var cr = addRow( sub==true?incol.children( '.inner' ):$(".add-row",$wpolayout), sub );
			cr.data( 'rowcfg', cloneData(row.data( 'rowcfg'),new WPO_DataRow()) );
		 
			$(row).children('.inner').children( ".lg-col" ).each( function(){	
				var cc = addColumn( $(cr).children('.inner').children(".wpo-row.active .sg-col"), cr );
				 
  				 $(this).children('.inner').children('.wpo-content').children( '.wpo-ijwidget' ).each( function(){   
  				 	var rwd   = cloneData( $(this).data('wgcfg'), new WPO_DataWidget() );  
		  			rwd.wkey  = $wpowidget.getWidgetKey();
  				 	var cwkey = $wpowidget.createWidgetButton( cc, $("#wpo_"+rwd.wtype) , rwd );	
  				 	$wpowidget.cloneFormData( cwkey, $(this).data('wgcfg').wkey );	

  				} );
  		 		var rcd = $(this).data('colcfg'); 
  				cc.data( 'colcfg', cloneData(rcd,new WPO_DataCol()) );
  				
  				$(cc).css( {'width':(rcd.lgcol/config.col*100)+'%'} );  
  				if( $(this).children('.inner').children( '.wpo-row' ).length > 0 ){  

	  				$(this).children('.inner').children( '.wpo-row' ).each( function(){   
	  					cloneLayoutInRow( $(this), true, cc );
	  				});
  				}

			} );
	 	}

  		/**
	  	 * add suggest row using to click to this for adding new real row
	  	 */
	  	function addSuggestRow(){
	  		var srow = $(  '<div class="add-row sg-row"></div>' );
	  		$wpolayout.append( srow );
	  		srow.click( function(){
	  			addRow( this );
 				
	  		} );
	  	};

	  	/**
	  	 * add suggest column using to click to this for adding new real row
	  	 */
	  	function addSuggestColumn( row ){
	  		var scol = $(  '<div class="add-col sg-col ptstooltip" data-toggle="tooltip" data-placement="top" title="Add Column"></div>' );
	  		// scol.width( config.coldwith );
	  		$(row).children(".inner").append( scol );	
	  	 
	  	};


	  	/**
	  	 * binding some delegate events
	  	 */
	  	function bindDelegateEvents(){

 			$( ".popover" ).each( function(){
 				var pop = this;
 				$( '.popover-title',this ).click( function(){
 					$( pop ).hide();	
 				} );
 			} );

 			$(".button-alignments button").click( function (){
 				$screenmode = $(this).data('option');
 				$(".button-alignments button").removeClass('active');
 				$(this).addClass( 'active' );
 				updateColWidthByScreen();

 			} );
	  	}

	  	function updateColWidthByScreen(){
	  	
	  		switch( $screenmode ){
	  			case 'medium-screen':
	  				$colkey = 'mdcol';
	  				break;
	  			case 'tablet-screen':
	  				$colkey = 'smcol';
	  				break;
	  			case 'mobile-screen':
	  				$colkey = 'xscol';
	  				break;
	  			default: 
	  				$colkey = 'lgcol';	
	  		}

	  		$("#layout-builder .wpo-row").each( function(){
	 			var _row = $(this);
	 			$( '.wpo-col', _row ).each( function(){
	 				var rcd = $(this).data('colcfg');  
	 				$(this).css( {'width':rcd[$colkey]/config.col*100+'%'} );  
	 			});
		 	});		
	  	}

	 	/**
	 	 * add event triggers to operator in form of selected column and selected row 
	 	 */
	 	function triggerFormsEvent(){
	 		/* ROW SETTING HANDLER */
	 		$("#row-builder form").submit( function(){ 
	 			if( $(".wpo-row.active") ){
	 				var cfg = $(".wpo-row.active").data( 'rowcfg' );
	 				for( var k in cfg ){
	  					cfg[k] = $("[name="+k+"]", "#row-builder").val(  ); 
	  				}
	 
	  				$(".wpo-row.active").data( 'rowcfg' ,cfg );
	 			}  
 				$( "#row-builder" ).hide();
	 			return false;
	 		} );

	 		/* COLUMN SETTING HANDLER */
	 		$("#col-builder form").submit( function(){ 
	 		 
	 			if( $(".wpo-col.active") ){
	 				var cfg = $(".wpo-col.active").data( 'colcfg' );
	 				for( var k in cfg ){
	  				 	var val = $("[name="+k+"]", "#col-builder").val( ); 
	  			 		if( val ){
	  			 			cfg[k] = val;
	  			 		}
	  				}
	  				$(".wpo-col.active").data( 'colcfg' ,cfg );
	 			}  
 				$( "#col-builder" ).hide();
	 			return false;
	 		} );
	 	}


	 	function getLayoutData( container ){
 			var output = new Array();	
 			$( container ).children('.inner ').children(".wpo-row").each( function(){
 		 
	 			var _row = $(this);
	 			var data = _row.data('rowcfg');
	 			data.cols = new Array();
	 			$(_row).children('.inner').children( '.wpo-col' ).each( function(){
	 				var _col = $(this).data('colcfg');
	 				_col.widgets = new Array();

	 				$(this).children('.inner').children('.wpo-content ').children( '.wpo-ijwidget' ).each( function() {  
	 					_col.widgets.push( $(this).data('wgcfg') );
	 				} ); 
	 				_col.rows = new Array();
	 				if( $(this).children('.inner').children( '.wpo-row' ).length > 0 ){
	 					_col.rows = getLayoutData( this );
	 				}
	 				data.cols.push( _col );
	 			} );
	 			output.push( data );  
		 	} );
	 		return output;	
	 	}

	 	/**
	 	 * add event triggers to operator in form of selected column and selected row 
	 	 */
	 	function triggerSaveForm(){

	 		$( config.formsellector ).submit( function(){
	 			
	 			var output = getLayoutData( '#layout-builder' );
	 		    var j = JSON.stringify( output ); 
	 		     
	 		    if( $(config.formsellector + " .hidden-layout-input").length<=0 ){
					var ws = $('<textarea name="wpolayout"  class="hidden-layout-input"></textarea>');
					ws.val( j );
					$( config.formsellector ).append( ws );
	 			}
	 	 		
	 			return true; 
	 		} );
	 	}

	 	/**
	 	 * build layout having rows, columns and widgets.
	 	 */
	 	function renderLayoutInRow( rows, widgetids, sub, incol ){
	 		$(rows).each( function() {
	  			// add row here
	  			var row = addRow( sub==true?incol.children( '.inner' ):$(".add-row",$wpolayout), sub );
	  			$( this.cols ).each( function(){ 

	  				var col = addColumn( $(row).children('.inner').children(".wpo-row.active .sg-col"), row, sub );

	  				$( this.widgets ).each( function(){   
	  				 	$wpowidget.createWidgetButton( col, $("#wpo_"+this.wtype) , this );	
	  				 	widgetids.push( this.wkey ); 
	  				} );
	  				
	  				this.widgets = null;
	  				col.data( 'colcfg', this );
	  			    $(col).css( {'width':(this.lgcol/config.col*100)+'%'} );  
  					if( this.rows.length > 0 ){
	  					 renderLayoutInRow( this.rows, widgetids, true, col ); 
	  				}
	  				this.rows = null;
	  			} );

	  			this.cols = null;
	  			row.data( 'rowcfg', this );
  			} );
  			return true;
	 	}

	 	/**
	 	 *
	 	 *
	 	 */
	 	function buildLayoutByJson( json ) {  
	 		var widgetids = new Array(); 
	 		if( json ) {
		  		var rows = $.parseJSON( json  );
	  			renderLayoutInRow( rows , widgetids, false );
		  	}	 
		  	$wpolayout.fadeIn( 600 );	
		   	
		   	$( "#layout-builder > .inner" ).sortable({
				connectWith: ".layout-builder",
				placeholder: "ui-state-highlight",
				handle:'.wpo-sortable' 
			});	

		   	$( ".wpo-col > .inner" ).sortable({
				connectWith: ".layout-builder",
				placeholder: "ui-state-highlight",
				handle:'.wpo-sortable',
				cancel:'.wpo-icon, .wpo-content' 
			});	

	   		$wpowidget.loadWidgetByIds( widgetids );	
	 	}

	 
	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {  
			 
			$wpolayout = $(this);
		 
			
			init(); 

			/* add some global delegate events */
			bindDelegateEvents();

			/* add event triggers to operator in form of selected column and selected row */
			triggerFormsEvent();

			/* add trigger saving setting layout form */
			triggerSaveForm(); 

			/* preload all widgets types by ajax then calling buildLayoutByJson to render layout follow setting*/
		 	$wpowidget.loadWidgets( false, buildLayoutByJson, datajson  );	
                        
                        $("body").delegate(".wpo-row", "mouseenter", function(){
                            $(".ptstooltip").tooltip();
                        });

		});
                
                
		return this;
	};
	
})(jQuery);
