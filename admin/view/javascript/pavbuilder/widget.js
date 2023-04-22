 
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
/* $.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
			
*/
(function($) {
	$.fn.WPO_Modal = function(opts) {
		// default configuration
		var config = $.extend({}, {
			confirmdel:'Are you sure to delete?',
			id:'wpo-modalbox'
		}, opts);
		var $wpolayout = null;
  
	 
		this.each(function() {  
			 
			$wpolayout = $(this);		 	
 

		});
	 
		return this;
	};
	
})(jQuery);


/**
 * WPO_Widget Plugin
 */
(function($) {
	$.fn.WPO_Widget = function(opts) {
		// default configuration
		var config = $.extend({}, {
			gutter:30,
			urlwidgets:  '',
			mdwidgets:  'wpo-widgetform',
			modaltitle: 'Widget Setting',
			backtolist:'Back to list',
			savetext : 'Save'
		}, opts);
		var $col = null;

 		var $this=this;

 		var $queeWidgetID = '';
 		function injectWrapperWidgets( id, buttons ){ 
			if( !$( "#"+id).length ) {
				var modal = $( '<div class="modal " style="display:none" id="'+id+'"></div>');
				var html = ' <div class="modal-inner" >';

				html += '  <div class="modal-dialog modal-lg">'; 
				html += ' 	    <div class="modal-content">'; 
				html += '	      <div class="modal-header clearfix">'; 
				html += '	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'; 
				html += '	        <h4 class="modal-title pull-left">'+config.modaltitle+'</h4>'; 

				html += '	      <div class="group-buttons showinform pull-right" style="padding-right:10px">'; 
				html += '	        <button type="button" class="btn btn-info backtolist">'+config.backtolist+'</button>'; 
				html += '	        <button type="button" class="btn btn-primary savechange ">'+config.savetext+'</button>';
				html += '	      </div>'; 


				html += '	      </div>'; 
				html += '	      <div class="modal-body">';




				html += '         <div class="wpo-widgetslist"></div><div class="wpo-widgetform"></div>';  
				html += '	      </div>'; 
		 
				html += '	      <div class="modal-footer">'; 
				html += '	        <button type="button" class="btn btn-info backtolist pull-left showinform">'+config.backtolist+'</button>'; 
				html += '	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'; 
				html += '	        <button type="button" class="btn btn-primary savechange showinform">Save</button>';
				html += '	      </div>'; 
			 
				html += '	    </div> '; 
				html += '	  </div> '; 
				html += '	</div>'; 
				modal.html( html );

				$('#content').append( modal );

				
			}		
		}

 		this.showWigetsList = function ( col ){
 			if( $('#'+config.mdwidgets ).find( ".wpo-widgetslist" ).length<=0 ){
			 	this.loadWidgets( true );
			}else {
				$( '#'+config.mdwidgets ).modal('toggle');	
				$('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetslist').show();
				$('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetform').hide();
			}	
 			
 		}
 		
 		this.loadWidgets = function( isshow, callback, datajson ){

 	
 			injectWrapperWidgets( config.mdwidgets, false );
 			$('#'+config.mdwidgets+" .showinform").hide();
 			$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetform' ).hide();

 			$.ajax({
				url:  config.urlwidgets,
				data:{
					rand:Math.random(),
					controller : config.controller,
    				action : 'listwidgets',
 					ajax : true,
					id_tab : current_id_tab
				},
				type:'post'
			}).done(function( html ) {
		 		 
		 		 $('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetslist').html( html );
		 		  $('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetslist').show();
		 		 if( isshow ){ 
				 	$('#'+config.mdwidgets).modal('toggle');
				 }
				 $this.widgetsAction(  $('#'+config.mdwidgets + ' .wpo-widgets' ) );

				 if(typeof callback == "function"){  
				    callback.call( this, datajson  );
				 }
				 widgetsFillter();

			});

			$('#'+config.mdwidgets+" .backtolist").click( function(){
				$('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetslist').show();
				$('#'+config.mdwidgets + ' ' +'.modal-body .wpo-widgetform').hide();
				$('#'+config.mdwidgets+" .showinform").hide();
			} );
 		}


 		this.editWidget = function( widget ){
 			 if( widget.data('wgcfg').wkey ){  
 			 	$('.ajaxloader').remove();
 			 	$(widget).append('<div class="ajaxloader"></div>');

 			 	var wkey = widget.data('wgcfg').wkey;
 			 	var data = $( "#wpowidget"+ widget.data('wgcfg').wkey  ).val();

 			 	var wtype = widget.data('wgcfg').wtype ;
 			 	$.ajax({
					url:  config.urlwidget,
					data:'rand='+Math.random()+'&wtype='+wtype+'&wkey='+wkey+'&edit=1&data='+data+"&controller="+config.controller+"&action=editwidget&ajax=true",
					type:'POST'
				}).done(function( html ) {  
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetform' ).html( html );
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetform' ).show();
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetslist' ).hide();
			 		$('#'+config.mdwidgets+" .showinform").show();
			 		$( '#'+config.mdwidgets ).modal('toggle');	
		 			$('.ajaxloader',widget).remove();
				}); 
 			 }
 		}

 	 

 		this.cloneWidget = function( widget ){
 			var data = widget.data( 'wgcfg' );
 			var target = new WPO_DataWidget();
 			for( var k in target ){   
			 	target[k] = data[k];
			}

			target.wkey = this.getWidgetKey();

 
			this.createWidgetButton( widget.parent().parent(), $("#wpo_"+target.wtype) , target );
			this.cloneFormData( target.wkey, data.wkey );	

 		}

 		this.getWidgetKey = function(){
 			var d = new Date();
			 return d.getTime();
 		}

 		this.createWidgetButton = function( col, widget , data ){
 				var name = '';
				if( data !=null ){
					var wkey = data.wkey;
					var dw = data;
					var name = data.name;
				}else {
	 
					var wkey = this.getWidgetKey();

					var dw = new WPO_DataWidget();
					dw.wkey = wkey;
					dw.wtype = $(widget).data('widget');

				}
				var $w = $( '<div class="wpo-ijwidget" id="widget'+dw.wkey+'"></div>' );
				
		 
				$w.data( 'wgcfg', dw );
			 	
				$w.html(  $(widget).html() );

				$w.append('<div class="wpo-wcopy ptstooltip" data-toggle="tooltip" data-placement="top" title="Duplicate"></div>');
				$w.append('<div class="wpo-wedit ptstooltip" data-toggle="tooltip" data-placement="top" title="Edit"></div>');
				$w.append('<div class="wpo-wdelete ptstooltip" data-toggle="tooltip" data-placement="top" title="Delete"></div>');
				$w.append( '<textarea class="wpo-cfginput" id="wpowidget'+wkey+'" name="wpowidget['+wkey+'][config]"></textarea>' );
				// alert(  $w.name );
				if( name ){
					$(".widget-desc",$w).html( '<div class="widget-name">'+name+'</div>' );
				}
				$( ".wpo-wcopy", $w ).click( function(){   
					$this.cloneWidget(  $w, col );
				} );

				$( ".wpo-wedit", $w ).click( function(){  
					$this.editWidget( $w );
				} );

				$( ".wpo-wdelete", $w ).click( function(){  
					if( confirm(config.confirmdel) ){
						$w.remove();
					}
					
				} );

				col.find( ".wpo-content" ).append( $w );

				return wkey;

 		}

 		this.cloneFormData = function( ckey, rkey ){   
			$("#wpowidget"+ckey).val( $("#wpowidget"+rkey).val() );
 		}

 		this.loadWidgetByIds = function( ids ){
 			
 			$.each( ids, function(i, wkey){
 				$.ajax({
					url:  config.urlwidgetdata,
				 
					data:{
						rand:Math.random(),
						controller : config.controller,
	    				action : 'widgetdata',
	 					ajax : true,
						id_tab : current_id_tab,
						wkey:wkey
					},

					type:'POST'
				}).done(function( html ) {
			 	 	$("#wpowidget"+wkey).val( html );
				});
 			} );

 				 
 		}

 		this.widgetsAction = function( $wwidgets ){

 			$(".wpo-wg-button > div", $wwidgets ).click( function(){

				//  var wkey = $this.createWidgetButton( $(".wpo-col.active"), this ) ;
				$('#'+config.mdwidgets+" .ajaxloader").remove();
				$(this).append('<div class="ajaxloader"></div>');
 				$queeWidgetID = this;
 				//alert( $($queeWidgetID).parent().data('widget') );
 				$.ajax({
					url:  config.urlwidget,
					data: {
						wkey:'',
						rand:Math.random(),
						controller : config.controller,
	    				action : 'widgetform',
	    				wtype: $($queeWidgetID).data('widget'),
	 					ajax : true,
						id_tab : current_id_tab
					},
					type:'POST'
				}).done(function( html ) {
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetform' ).html( html );
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetform' ).show();
			 		$( '#'+config.mdwidgets + ' .modal-body .wpo-widgetslist' ).hide();

			 		$('#'+config.mdwidgets+" .showinform").show();
			 		$('#'+config.mdwidgets+" .ajaxloader").remove();
				}); 
 			} );
 		}

		
		

		this.each(function() {  
			injectWrapperWidgets( config.mdwidgets, false ); 

			$('#'+config.mdwidgets+" .savechange").click( function(){
				updateAllMessageForms();
				var k = $.trim($('[name=wkey]',$('#'+config.mdwidgets+" form") ).val()); 
 				 
				if( k == "" ){   
					var wkey = $this.createWidgetButton( $(".wpo-col.active"), $queeWidgetID  ) ;	
					$('[name=wkey]',$('#'+config.mdwidgets+" form") ).val( wkey ); 
					$queeWidgetID = '';
				} else {
					var wkey = k;
				}
				$("#layout-builder").append('<div class="loading-setting"></div>');
				var p = "controller="+config.controller+"&action=savewidget&ajax=true&id_tab&"+current_id_tab;
				$.ajax({
					url:  config.urlwidget+"&action=save",
					data:$('#'+config.mdwidgets+" form").serialize()+"&wkey="+wkey+"&"+p,
					dataType:'json',
					type:'POST'
				}).done(function( widget ) {
					if( widget.wkey ){
						$("#wpowidget"+wkey).val(  widget.config );	
					}
	 				if( widget.name ){
	 					$("#wpowidget"+wkey).parent().find('.widget-desc').html( widget.name.substring(0, 100) );
	 					var data = $("#widget"+wkey).data('wgcfg');
	 					data.name = widget.name;
	 					$("#widget"+wkey).data('wgcfg', data);   
	 				}
	 				$("#layout-builder .loading-setting").remove();
				}); 
				$('#'+config.mdwidgets).modal('toggle');
			} );
                        
                        
 			return this;
		});
                
                
		return this;
	};
	
})(jQuery);
