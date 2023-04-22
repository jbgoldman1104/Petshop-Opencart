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


var WPO_DataRow = function () {
    this.index   =  0;
    this.cls   = '';
    this.bgcolor = '';
    this.bgimage = '';
    this.fullwidth = 0;
    this.parallax = 0;
    this.sfxcls = '';
}

var WPO_DataCol = function () {
    this.index = 0;
    this.cls = '';
    this.sfxcls = '';
    this.bgcolor = '';
    this.bgimage = '';
    this.inrow = 0;
    this.lgcol = 4;
    this.mdcol = 4;
    this.smcol = 6;
    this.xscol = 12; 
	     
}

var WPO_DataWidget = function () {
    this.cls = '';
    this.wtype = '';
    this.wkey ='';
    this.name = '';
         
}

$(document).ready( function(){
      $('input.input-color').each( function(){
         var input = this;
             $(input).ColorPicker( {
                onChange:function (hsb, hex, rgb) {
                  $(input).css('backgroundColor', '#' + hex);
                  $(input).val( hex );
                }
             } ); 
       });  
} ); 
 

function reloadLanguage( langcls ){
     $('.switch-langs').hide();

      $('.'+langcls).show();

      $(".group-langs ul li").click( function(){
           $('.switch-langs').hide();
            $('.'+ $(this).data('lang') ).show();
      } );
}
 
 function updateAllMessageForms(){
      
  }