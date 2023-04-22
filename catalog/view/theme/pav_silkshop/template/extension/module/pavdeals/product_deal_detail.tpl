<?php
	if(isset($style)){
		echo '<link rel="stylesheet" type="text/css" href="'.$base.$style.'" />';
	}
	if(isset($script)){
		echo '<script type="text/javascript" src="'.$base.$script.'"></script>';
	}
?>
<div class="product_deal_detail productdeals">
	<div class="box-content">
	  <div class="product-block"><div class="product-inner">
		<div class="sales-logo">
			<img src="<?php echo $saleoff_icon; ?>" alt="<?php echo $objlang->get("sale_off");?>"/>
	  	</div>
		<div id="item<?php echo $module; ?>countdown_<?php echo $product['product_id']; ?>" class="item-countdown"></div>
			<script type="text/javascript">
			jQuery(document).ready(function($){
					$("#item<?php echo $module; ?>countdown_<?php echo $product['product_id']; ?>").lofCountDown({
						formatStyle:2,
						TargetDate:"<?php echo date('m/d/Y G:i:s', strtotime($product['date_end_string'])); ?>",
						DisplayFormat:"<ul><li>%%D%% <div><?php echo $objlang->get("text_days");?></div></li><li> %%H%% <div><?php echo $objlang->get("text_hours");?></div></li><li> %%M%% <div><?php echo $objlang->get("text_minutes");?></div></li><li> %%S%% <div><?php echo $objlang->get("text_seconds");?></div></li></ul>",
						FinishMessage: "<?php echo $objlang->get('text_finish');?>"
					});
				});
			</script>
			<br class="clear clr"/>
	  </div></div>
	</div>
	<br class="clear clr"/>
</div>
