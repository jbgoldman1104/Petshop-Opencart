<div class="<?php echo $additional_class; ?> box search_block">
	<form method="GET" action="index.php">
	<?php if(!empty($categories)) { ?>
	<div class="filter_type category_filter pull-left">
		<span class="fa fa-caret-down"></span>
		<select name="category_id">
			<option value="0"><?php echo $this->language->get("text_category_all"); ?></option>
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
	<div id="search<?php echo $module ?>" class="search pull-left">
		<input type="text" name="search" autocomplete="off" placeholder="<?php echo $this->language->get("text_search");?>" value="" class="input-search form-control">
		<span class="button-search fa fa-search"></span>
	</div>
	<input type="hidden" name="sub_category" value="1" id="sub_category"/>
	<input type="hidden" name="route" value="product/search"/>
	<input type="hidden" name="description" value="true" id="description"/>
	</form>
	<div class="clear clr"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".search_block span:first").mouseover(function(){
		var $this = $(this);
		var $input = $(".category_filter select[name=\"category_id\"]"); 
		if ($input.is("select") && !$('.lfClon').length) {
			var $clon = $input.clone();
			var getRules = function($ele){ return {
				position: 'absolute',
				left: $ele.offset().left,
				top: $ele.offset().top,
				width: $ele.outerWidth(),
				height: $ele.outerHeight(),
				background: '#f9f9f9',
				fontSize: '13px',
				color: '#8c8c8c',
				opacity: 0,
				margin: 0,
				padding: 0
			};};
			var rules = getRules($input);
			$clon.css(rules);
			$clon.on("mousedown.lf", function(){
				$clon.css({
					marginLeft: $input.offset().left - rules.left,
					marginTop: $input.offset().top - rules.top,
				});
				$clon.on('change blur', function(){
					$input.val($clon.val()).show();
					$clon.remove();
				});
				$clon.off('.lf');
			});
			$clon.on("mouseout.lf", function(){
				$(this).remove();
			});
			$clon.prop({id:'',className:'lfClon'});
			$clon.appendTo('body');
		}
	});

	var selector = '#search<?php echo $module ?>';
	var text_price = "<?php echo $this->language->get("text_price");?>";
	var total = 0;
	var show_image = <?php echo ($show_image==1)?'true':'false';?>;
	var show_price = <?php echo ($show_price==1)?'true':'false';?>;
	var search_sub_category = true;
	var search_description = true;

	$(selector).find('input[name=\'search\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			var category_id = $(".category_filter select[name=\"category_id\"]").first().val();
			if(typeof(category_id) == 'undefined')
				category_id = 0;
			var limit = <?php echo $limit;?>;
			var search_sub_category = search_sub_category?'&sub_category=true':'';
			var search_description = search_description?'&description=true':'';
			$.ajax({
				url: 'index.php?route=extension/module/pavautosearch/autocomplete&filter_category_id='+category_id+'&limit='+limit+search_sub_category+search_description+'&filter_name='+encodeURIComponent(request.term),
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
							price: item.price,
							label: item.name,
							image: item.image,
							link:  item.link,
							value: item.product_id
						}
					}));
				}
			});
		},
		select: function(event, ui) {
			return false;
		},
		focus: function(event, ui) {
			return false;
		}
	})
		$(selector).find('input[name=\'search\']').data( "autocomplete" )._renderMenu = function(ul,b){
			var g=this;
			$.each(b,function(c,f){g._renderItem(ul,f)});
			var category_id = $(".category_filter select[name=\"category_id\"]").first().val();
			category_id = parseInt(category_id);
			var text_view_all = '<?php echo $this->language->get("text_view_all"); ?>';
			text_view_all = text_view_all.replace(/%s/gi, total);
			return $(ul).append('<li><a href="index.php?route=product/search&search='+g.term+'&category_id='+category_id+'&sub_category=true&description=true" onclick="window.location=this.href">'+text_view_all+'</a></li>');
		};
		$(selector).find('input[name=\'search\']').data( "autocomplete" )._renderItem = function( ul, item ) {
			var html = '';
			if(show_image){
				html += '<img class="pull-left" style="margin-right:10px;" src="'+item.image+'">';
			}
			html += '<div class="name">'+item.label+'</div>';
			if(show_price){
				var text_price = "";
				if (item.price) {
					text_price += '<div class="price">';
					if (!item.special) {
					 text_price += item.price;
					} else {
					 text_price += '  <span class="price-old">'+item.price+'</span> <span class="price-new">'+item.special+'</span>';
					}
					if (item.tax) {
						item.text_price += '<br />';
						item.text_price += '<span class="price-tax"><?php echo $this->language->get("text_tax");?> '+item.tax+'</span>';
					}
					text_price += '</div>';
				}
				html += '<div class="price"><?php echo $this->language->get("text_price");?>'+item.price;	
			}
			
			html += '</div><br class="clear clr"/>';
			var li_element = $("<li></li>").data("item.autocomplete",item).append(html).appendTo(ul);
			
			$(li_element).click(function(el){
				$(selector+' input[name=\'search\']').val('');
				if(item.link){
					window.location = item.link.replace(/&amp;/gi,'&');
				}
			});
			
			return li_element;
		};
})
</script>