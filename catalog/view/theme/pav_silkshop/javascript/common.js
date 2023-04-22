
/* Autocomplete */
(function($) {
  function Autocomplete1(element, options) {
    this.element = element;
    this.options = options;
    this.timer = null;
    this.items = new Array();

    $(element).attr('autocomplete', 'off');
    $(element).on('focus', $.proxy(this.focus, this));
    $(element).on('blur', $.proxy(this.blur, this));
    $(element).on('keydown', $.proxy(this.keydown, this));

    $(element).after('<ul class="dropdown-menu autosearch"></ul>');
    $(element).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
  }

  Autocomplete1.prototype = {
    focus: function() {
      this.request();
    },
    blur: function() {
      setTimeout(function(object) {
        object.hide();
      }, 200, this);
    },
    click: function(event) {
      event.preventDefault();
      value = $(event.target).parent().attr("href");
      if (value) {
        window.location = value.replace(/&amp;/gi,'&');
      }
    },
    keydown: function(event) {
      switch(event.keyCode) {
        case 27: // escape
          this.hide();
          break;
        default:
          this.request();
          break;
      }
    },
    show: function() {
      var pos = $(this.element).position();

      $(this.element).siblings('ul.dropdown-menu').css({
        top: pos.top + $(this.element).outerHeight(),
        left: pos.left
      });

      $(this.element).siblings('ul.dropdown-menu').show();
    },
    hide: function() {
      $(this.element).siblings('ul.dropdown-menu').hide();
    },
    request: function() {
      clearTimeout(this.timer);

      this.timer = setTimeout(function(object) {
        object.options.source($(object.element).val(), $.proxy(object.response, object));
      }, 200, this);
    },
    response: function(json) {
      console.log(json);
      html = '';

      if (json.length) {
        for (i = 0; i < json.length; i++) {
          this.items[json[i]['value']] = json[i];
        }

        for (i = 0; i < json.length; i++) {
          if (!json[i]['category']) {
            html += '<li class="media" data-value="' + json[i]['value'] + '">';
            if(json[i]['simage']) {
              html += ' <a class="media-left" href="' + json[i]['link'] + '"><img class="pull-left" src="' + json[i]['image'] + '"></a>';
            }
            html += '<div class="media-body"> <a href="' + json[i]['link'] + '"><span>' + json[i]['label'] + '</span></a>';
            if(json[i]['sprice']){
              html += ' <div class="price">';
              if (!json[i]['special']) {
                html += json[i]['price'];
              } else {
                html += '<span class="price-old">' + json[i]['price'] + '</span><span class="price-new">' + json[i]['special'] + '</span>';
              }
              if (json[i]['tax']) {
                html += '<br />';
                html += '<span class="price-tax">' + json[i]['tax'] + '</span>';
              }
              html += ' </div>';
            }
            html += '</div></li><li class="clearfix"></li>';
          }
        }
        //html += '<li><a href="index.php?route=product/search&search='+g.term+'&category_id='+category_id+'&sub_category=true&description=true" onclick="window.location=this.href">'+text_view_all+'</a></li>';

        // Get all the ones with a categories
        var category = new Array();
        for (i = 0; i < json.length; i++) {
          if (json[i]['category']) {
            if (!category[json[i]['category']]) {
              category[json[i]['category']] = new Array();
              category[json[i]['category']]['name'] = json[i]['category'];
              category[json[i]['category']]['item'] = new Array();
            }
            category[json[i]['category']]['item'].push(json[i]);
          }
        }
        for (i in category) {
          html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
          for (j = 0; j < category[i]['item'].length; j++) {
            html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
          }
        }
      }
      if (html) {
        this.show();
      } else {
        this.hide();
      }
      $(this.element).siblings('ul.dropdown-menu').html(html);
    }
  };

  $.fn.autocomplete1 = function(option) {
    return this.each(function() {
      var data = $(this).data('autocomplete');
      if (!data) {
        data = new Autocomplete1(this, option);
        $(this).data('autocomplete', data);
      }
    });
  }
})(window.jQuery);

function wpo_play_owl_carousel( owl ){
  var $ = jQuery;
  var config = {
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      pagination : $(owl).data( 'pagination' )
  };

  if( $(owl).data('show') == 1 ){
      config.singleItem = true;
  }else {
      config.items = $(owl).data( 'show' );
  }
  $(owl).owlCarousel( config );
  $('.left',$(owl).parent()).click(function(){
        owl.trigger('owl.prev');
        return false;
  });
  $('.right',$(owl).parent()).click(function(){
      owl.trigger('owl.next');
      return false;
  });
}
$(document).ready(function() {
    //search
    $('#search input[name=\'search\']').parent().find('button').on('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';
        var value = $('#search input[name=\'search\']').val();
        if (value) {
            url += '&search=' + encodeURIComponent(value);
        }
        location = url;
    });
    $('#search input[name=\'search\']').on('keydown', function(e) {
        if (e.keyCode == 13) {
            $('#search input[name=\'search\']').parent().find('button').trigger('click');
        }
    });

    // Click top scroll
    // scroll-to-top button show and hide
    jQuery(document).ready(function(){
        jQuery(window).scroll(function(){
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#push-top').fadeIn();
            } else {
                jQuery('#push-top').fadeOut();
            }
        });
        // scroll-to-top animate
        jQuery('#push-top').click(function(){
            jQuery("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
    });

      /**
       *
       */
      $(".dropdown-toggle-overlay").click( function(){
             $($(this).data( 'target' )).addClass("active");
      } );

       $(".dropdown-toggle-button").click( function(){
             $($(this).data( 'target' )).removeClass("active");
             return false;
      } );


    // Fix First Click Menu
    $(document.body).on('click', '.megamenu [data-toggle="dropdown"], .verticalmenu [data-toggle="dropdown"]' ,function(){
        if(!$(this).parent().hasClass('open') && this.href && this.href != '#'){
            window.location.href = this.href;
        }
    });

    // Automatic apply  OWL carousel
    $(".owl-carousel-play .owl-carousel").each( function(){
      var owl = $(this);
      wpo_play_owl_carousel( owl );
    });

    // Adding the clear Fix
    cols1 = $('#column-right, #column-left').length;

    if(cols1 == 2){
        $('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
    }else if(cols1 == 1){
        $('#content .product-layout:nth-child(3n+3)').after('<div class="clearfix visible-lg"></div>');
    }else{
        $('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix"></div>');
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active')
    });
    $('#offcanvasmenu a.dropdown-toggle').parent().prepend('<i class="click-canavs-menu fa fa-plus-square"></i>');
    $( "body" ).on( "click", "i.click-canavs-menu.fa-plus-square", function() {
        $this = $(this);
        $this.removeClass('fa-plus-square').addClass('fa-minus-square');
        $this.parent().find('.dropdown-menu:first').toggle();
    });

    $( "body" ).on( "click", "i.click-canavs-menu.fa-minus-square", function() {
        $(this).removeClass('fa-minus-square').addClass('fa-plus-square');
        $(this).parent().find('.dropdown-menu:first').toggle();
    });

    // Search
    $('#offcanvas-search input[name=\'search\']').parent().find('button').on('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';
        var value = $('.sidebar-offcanvas input[name=\'search\']').val();
        if (value) {
            url += '&search=' + encodeURIComponent(value);
        }
        location = url;
    });

    // offcanvase search trigger click
    $('#offcanvas-search input[name=\'search\']').on('keydown', function(e) {
        if (e.keyCode == 13) {
            $('.sidebar-offcanvas input[name=\'search\']').parent().find('button').trigger('click');
        }
    });


    $('.product-zoom').magnificPopup({
        type: 'image',
            closeOnContentClick: true,

            image: {
              verticalFit: true
            }
    });

    $('.iframe-link').magnificPopup({
      type:'iframe'
    });

    //  Fix First Click Menu /
  $(document.body).on('click', '.megamenu [data-toggle="dropdown"], .verticalmenu [data-toggle="dropdown"]' ,function(){
      if(!$(this).parent().hasClass('open') && this.href && this.href != '#'){
          window.location.href = this.href;
      }
  });

    // grid list switcher
    $("button.btn-default").bind("click", function(e){
        e.preventDefault();
        var theid = $(this).attr("id");
        var row = $("#products");

        if($(this).hasClass("active")) {
            return false;
        } else {
            if(theid == "list-view"){
                $('#list-view').addClass("active");
                $('#grid-view').removeClass("active");
                // remove class list
                row.removeClass('product-grid');
                // add class gird
                row.addClass('product-list');
                localStorage.setItem('display', 'list');
            }else if(theid =="grid-view"){
                $('#grid-view').addClass("active");
                $('#list-view').removeClass("active");
                // remove class list
                row.removeClass('product-list');
                // add class gird
                row.addClass('product-grid');
                localStorage.setItem('display', 'grid');
            }
        }
    });

    if (localStorage.getItem('display') == 'list') {
        $('#list-view').trigger('click');
    } else {
        $('#grid-view').trigger('click');
    }


    $(".quantity-adder .add-action").click(function(){
    if( $(this).hasClass('add-up') ) {
        $("[name=quantity]",'.quantity-adder').val( parseInt($("[name=quantity]",'.quantity-adder').val()) + 1 );
    }else {
      if( parseInt($("[name=quantity]",'.quantity-adder').val())  > 1 ) {
        $("input",'.quantity-adder').val( parseInt($("[name=quantity]",'.quantity-adder').val()) - 1 );
      }
    }
  });


});

// Cart add remove functions
var cart = {
    'addcart': function(product_id, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            success: function(json) {
                $('.alert, .text-danger').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['success']) {

                    $('#notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#cart #cart-total').html(json['total']);

                    $('html, body').animate({ scrollTop: 0 }, 'slow');

                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    },
    'update': function(key, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/edit',
            type: 'post',
            data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            beforeSend: function() {
                $('#cart > button').button('loading');
            },
            success: function(json) {
                $('#cart > button').button('reset');

                $('#cart #cart-total').html(json['total']);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    },
    'remove': function(key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function() {
                $('#cart > button').button('loading');
            },
            complete: function() {
                $('#cart > button').button('reset');
            },
            success: function(json) {
                $('#cart #cart-total').html(json['total']);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    }
}

var wishlist = {
    'addwishlist': function(product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.alert').remove();

                if (json['success']) {
                    $('#notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['info']) {
                    $('#notification').html('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                $('#wishlist-total').html(json['total']);

                $('#wishlist-total', window.parent.document).html(json['total']);

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    },
    'remove': function() {

    }
}

var compare = {
    'addcompare': function(product_id) {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.alert').remove();

                if (json['success']) {
                    $('#notification').html('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#compare-total').html(json['total']);
                    
                     $('#compare-total', window.parent.document).html(json['total']);

                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                }
            }
        });
    },
    'remove': function() {

    }
}


