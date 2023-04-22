<div class="<?php echo $additional_class; ?> autosearch-wrapper hidden-xs">
	<form method="GET" action="index.php">
	<div id="search<?php echo $module ?>" class="search pull-left">
	    <input class="autosearch-input" type="text" value="" size="35" autocomplete="off" placeholder="<?php echo $objlang->get("text_search");?>" name="search">
	    
	    <?php if(!empty($categories)) { ?>
		<div class="filter_type category_filter autosearch-category">
			<i class="fa fa-angle-down"></i>
			<select name="category_id">
				<option value="0"><?php echo $objlang->get("text_category_all"); ?></option>
				<?php foreach ($categories as $category_1) { ?>
		        <?php if ($category_1['category_id'] == $category_id) { ?>
		        <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
		        <?php } else { ?>
		        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
		        <?php } ?>
		        <?php foreach ($category_1['children'] as $category_2) { ?>
		        <?php if ($category_2['category_id'] == $category_id) { ?>
		        <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
		        <?php } else { ?>
		        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
		        <?php } ?>
		        <?php foreach ($category_2['children'] as $category_3) { ?>
		        <?php if ($category_3['category_id'] == $category_id) { ?>
		        <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
		        <?php } else { ?>
		        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
		        <?php } ?>
		        <?php } ?>
		        <?php } ?>
		        <?php } ?>
			</select>
		</div>
		<?php } ?>
	</div>
	<button type="submit" class="button-search autosearch-submit btn btn-outline-inverse" name="submit_search"><?php echo $objlang->get('text_search'); ?></button>
	<input type="hidden" name="route" value="product/search"/>
	<input type="hidden" name="sub_category" value="true" id="sub_category"/>
	<input type="hidden" name="description" value="true" id="description"/>
	</form>
	<div class="clear clr"></div>
</div>
<script type="text/javascript">

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
							html += '	<a class="media-left" href="' + json[i]['link'] + '"><img class="pull-left" src="' + json[i]['image'] + '"></a>';	
						}
						html += '<div class="media-body">	<a href="' + json[i]['link'] + '"><span>' + json[i]['label'] + '</span></a>';
						if(json[i]['sprice']){
							html += '	<div class="price">';
							if (!json[i]['special']) {
								html += json[i]['price'];
							} else {
								html += '<span class="price-old">' + json[i]['price'] + '</span><span class="price-new">' + json[i]['special'] + '</span>';
							}
							if (json[i]['tax']) {
								html += '<br />';
								html += '<span class="price-tax"><?php echo $objlang->get("text_tax");?>' + json[i]['tax'] + '</span>';
							}
							html += '	</div>';
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
$(document).ready(function() {
	var selector = '#search<?php echo $module ?>';
	var total = 0;
	var show_image = <?php echo ($show_image==1)?'true':'false';?>;
	var show_price = <?php echo ($show_price==1)?'true':'false';?>;
	var search_sub_category = true;
	var search_description = true;
	var width = 64;
	var height = 64;

	$(selector).find('input[name=\'search\']').autocomplete1({
		delay: 500,
		source: function(request, response) {
			var category_id = $(".category_filter select[name=\"category_id\"]").first().val();
			if(typeof(category_id) == 'undefined')
				category_id = 0;
			var limit = <?php echo $limit;?>;
			var search_sub_category = search_sub_category?'&sub_category=true':'';
			var search_description = search_description?'&description=true':'';
			$.ajax({
				url: 'index.php?route=extension/module/pavautosearch/autocomplete&filter_category_id='+category_id+'&width='+width+'&height='+height+'&limit='+limit+search_sub_category+search_description+'&filter_name='+encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						if($('.pavautosearch_result')){
							$('.pavautosearch_result').first().html("");
						}
						total = 0;
						if(item.total){
							total = item.total;
						}
						return {
							price:   item.price,
							speical: item.special,
							tax:     item.tax,
							label:   item.name,
							image:   item.image,
							link:    item.link,
							value:   item.product_id,
							sprice:  show_price,
							simage:  show_image,
						}
					}));
				}
			});
		},
	}); // End Autocomplete 

});// End document.ready

</script>