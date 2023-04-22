(function($) {
  $.PavWidgetsHelper = {
      init:function(){
          alert( 'dd' );
      },  

      createWidgetsString:function( name, params ){

          var content = '';
          var attrs =  '';
          var output = '['+name+' _SC_ATTS]_SC_CONTENT_[/'+name+']';
    
          $.each(params, function(key,value){
                attrs +=key+'="'+value+'" ';
          } );
          output = output.replace( '_SC_ATTS', $.trim(attrs) ).replace( '_SC_CONTENT_',  $.trim(content) );
          return output;
         // console.log( output );
      }
  }
  
  $(window).load(function() {
     // $.PavWidgetsHelper.init();
  });

})(jQuery);
 