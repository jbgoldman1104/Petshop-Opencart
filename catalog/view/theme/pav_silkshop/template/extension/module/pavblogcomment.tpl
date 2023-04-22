<div class="panel panel-default pavblogs-comments-box">
	<div class="panel-heading"><h4 class="panel-title"><?php echo $heading_title; ?></h4></div>
	<div class="panel-body" >
		<?php if( !empty($comments) ) { ?>
		<div class="pavblog-comments clearfix">
			 <?php $default=''; foreach( $comments as $comment ) { ?>
				<div class="pav-comment clearfix">
					<a href="<?php echo $comment['link'];?>" title="<?php echo $comment['user'];?>">
					<img src="<?php echo "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment['email'] ) ) ) . "?d=" . urlencode( $default ) . "&s=60" ?>" align="left"/>
					</a>
					<div class="comment"><?php echo utf8_substr( $comment['comment'], 50 ); ?></div>
					<span class="comment-author"><?php echo $objlang->get('text_postedby');?> <?php echo $comment['user'];?>...</span>
				</div>
			 <?php } ?>
		</div>
		<?php } ?>
	</div>
 </div>
