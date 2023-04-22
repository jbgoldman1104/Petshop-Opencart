<div class="panel panel-default">
  <?php if ($position == 'content_top' || $position == 'content_bottom') { ?>
    <div class="panel-body" style="text-align: right;">
  <?php } else { ?>
    <div class="panel-body" style="text-align: center;">
  <?php } ?>
      <span id="AmazonCheckoutWidgetModule<?php echo $layout_id ?>-<?php echo $position ?>"></span>
    </div>
</div>
<script type="text/javascript"><!--
	new CBA.Widgets.InlineCheckoutWidget({
		merchantId: "<?php echo $merchant_id; ?>",
		buttonSettings: {
			color: '<?php echo $button_colour; ?>',
			background: '<?php echo $button_background; ?>',
			size: '<?php echo $button_size; ?>',
		},
		onAuthorize: function(widget) {
			var redirectUrl = '<?php echo html_entity_decode($amazon_checkout); ?>';
			if (redirectUrl.indexOf('?') == -1) {
				redirectUrl += '?contract_id=' + widget.getPurchaseContractId();
			} else {
				redirectUrl += '&contract_id=' + widget.getPurchaseContractId();
			}

			window.location = redirectUrl;
		}
	}).render("AmazonCheckoutWidgetModule<?php echo $layout_id; ?>-<?php echo $position; ?>");
//--></script>