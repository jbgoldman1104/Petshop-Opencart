<?php
	if(isset($style)){
		echo '<link rel="stylesheet" type="text/css" href="'.$base.$style.'" />';
	}
	if(isset($script)){
		echo '<script type="text/javascript" src="'.$base.$script.'"></script>';
	}
?>
<div class="itemdeal productdeals">
	<div class="box-content">
	  <div class="product-block">
	  	<div class="product-inner">
		<div class="deal_detail">
			<ul>
				<li>
					<span><?php echo $objlang->get("text_discount");?></span>
					<span class="deal_detail_num"><?php echo $product['deal_discount'];?>%</span>
				</li>
				<li>
					<span><?php echo $objlang->get("text_you_save");?></span>
					<span class="deal_detail_num"><span class="price"><?php echo $product["save_price"]; ?></span></span>
				</li>
				<li>
					<span><?php echo $objlang->get("text_bought");?></span>
					<span class="deal_detail_num"><?php echo $product['bought'];?></span>
				</li>
			</ul>
		</div>
		<div class="deal-qty-box">
			<?php echo sprintf($objlang->get("text_quantity_deal"), $product["quantity"]);?>
		</div>
		<div class="item-detail">
			<div class="timer-explain">(<?php echo date($objlang->get("date_format_short"), strtotime($product['date_end_string'])); ?>)</div>	
	  	</div>
		<div id="item<?php echo $module; ?>countdown_<?php echo $product['product_id']; ?>" rel="<?php echo date('m/d/Y G:i:s', strtotime($product['date_end_string'])); ?>" class="item-countdown pavdeal_countdown"></div>
			
			<br class="clear clr"/>
	  </div></div>
	  <br class="clear clr"/>
	</div>
</div>
<script type="text/javascript">
function initCountDown(class_name){
	$(class_name).each(function(index,el){
		var targetdate = $(this).attr("rel");
		$(this).lofCountDown({
			formatStyle:2,
			TargetDate: targetdate,
			DisplayFormat:"<ul><li>%%D%% <div><?php echo $objlang->get("text_days");?></div></li><li> %%H%% <div><?php echo $objlang->get("text_hours");?></div></li><li> %%M%% <div><?php echo $objlang->get("text_minutes");?></div></li><li> %%S%% <div><?php echo $objlang->get("text_seconds");?></div></li></ul>",
			FinishMessage: "<?php echo $objlang->get('text_finish');?>"
		});
	})
}

initCountDown(".pavdeal_countdown");
			
</script>