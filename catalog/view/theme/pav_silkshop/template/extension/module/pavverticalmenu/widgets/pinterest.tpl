<?php if ( $select_type ) { ?>
	<div class="widget-priterest {$addition_cls} {if isset($stylecls)&&$stylecls}block-{$stylecls}{/if}">
		<div class="widget-inner block_content">
			<a href="http://www.pinterest.com/pin/create/button/?url=<?php echo $url?>&media=<?php echo $media?>&description=<?php echo $description?>"
				class="pin-it-button" count-layout="<?php echo $select_type?>"
			    <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" title="Pin It" />
			</a>

		</div>
	</div>
<?php } ?>
 
<script type="text/javascript">
	(function(d){
	    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
	    p.type = 'text/javascript';
	    p.async = true;
	    p.src = '//assets.pinterest.com/js/pinit.js';
	    f.parentNode.insertBefore(p, f);
	}(document));
</script>
 