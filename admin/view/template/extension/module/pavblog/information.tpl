<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div><!-- end div .page-header -->
	<div id="page-content" class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php if( is_array($error_warning) ) { echo implode("<br>",$error_warning); } else { echo $error_warning; } ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>

		<div id="ajaxloading" class="hide">
			<div class="alert alert-warning" role="alert"><?php echo $objlang->get('text_process_request'); ?></div>
		</div>

		<div class="toolbar"><?php require( dirname(__FILE__).'/toolbar.tpl' ); ?></div>
		<!-- tools bar blog -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
			</div>
			<div class="panel-body">

				<div class="content">
						
					<div id="tab-support">
						<h4>Pavo Blogs Management</h4>
						<p><i>
						We are proud to announce the next release of our Pav Blogs Module, version 1.0. 
						This release coincides with the new version of Opencart released which is version 1.5.5.1. 
						
						</i>
						</p>
						
						<h4>About The Module</h4>
						<div>
							<p class="pavo-copyright">Its is Free Opencart Module released under license GPL/V2. Powered by <a href="http://www.pavothemes.com" title="PavoThemes - Opencart Theme Clubs">PavoThemes</a></p>
						</div>
						<h4>Supports</h4>
						<div>
							Follow me on <b>twitter </b>or join my <b>facebook </b>page to get noticed about all theme updates and news!
							<ul>
								<li><a href="http://www.pavothemes.com">Forum</a></li>
								<li><a href="http://www.pavothemes.com">Ticket</a></li>
								<li><a href="http://www.pavothemes.com">Contact us</a></li>
								<li>Email: <a href="mailto:pavothemes@gmail.com">pavothemes@gmail.com</a> </li>
								<li>Skype Support: hatuhn</li>
								<li><a href="">YouTuBe</a></li>
							</ul>
						</div>
						
						<h4>CheckUpdate</h4>
						<ul>
							<li><a href="http://www.pavthemes.com/updater/?product=pavblog&list=1" title="PavoThemes - Opencart Themes Club">Check</a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>

	</div><!-- end div #page-content -->
</div><!-- end div #content -->
<script type="text/javascript">
	$(".pavhtabs a").tabs();
	$(".pavmodshtabs a").tabs();
	function __submit( val ){
		$("#action_mode").val( val );
		$("#form").submit();
	}
</script>
<?php echo $footer; ?>