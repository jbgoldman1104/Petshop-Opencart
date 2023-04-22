<?php if ( isset($username) ){ ?>
<div class="widget-twitter block {$addition_cls} {if isset($stylecls)&&$stylecls}block-{$stylecls}{/if}">
	<?php if( $show_title ) { ?>
	<div class="widget-heading -heading"><?php echo $heading_title?></div>
	<?php } ?>
	<div class="widget-inner block_content">
		<a class="twitter-timeline" data-dnt="true" data-theme="<?php echo $theme ?>" data-link-color="#FFFFFF" width="<?php echo $width; ?>" height="<?php echo $height; ?>" data-chrome="<?php echo $chrome; ?>" data-border-color="#<?php echo $border_color; ?>" lang="EN" data-tweet-limit="<?php echo $count; ?>" data-show-replies="<?php echo $show_replies; ?>" href="https://twitter.com/<?php echo $username; ?>"  data-widget-id="<?php echo $twidget_id; ?>">Tweets by @<?php echo $username; ?></a>
		<?php echo $js; ?>
	</div>
</div>
<?php } ?>