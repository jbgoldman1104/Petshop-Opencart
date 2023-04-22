<?php
	echo $header;
	echo $column_left;
?>
<div id="content">

	<div class="page-header">
		<div class="container-fluid">
			<?php /*  ?>
			<div class="pull-right">
				<a onclick="$('#form').submit();" class="btn btn-primary"><?php echo $objlang->get("button_save"); ?></a>
			</div>
			<?php */  ?>
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
				
				<div class="box-columns">
					
					<ul class="nav nav-tabs" id="grouptab">
						<li><a href="#tab-module-pavblogcategory" role="tab" data-toggle="tab"><?php echo $objlang->get("tab_pavblogcategory"); ?></a></li>
						<li><a href="#tab-module-pavblogcomment" role="tab" data-toggle="tab"><?php echo $objlang->get("tab_pavblogcomment"); ?></a></li>
						<li><a href="#tab-module-pavbloglatest" role="tab" data-toggle="tab"><?php echo $objlang->get("tab_pavbloglatest"); ?></a></li>
					</ul>

					<div class="tab-content">

						<div id="tab-module-pavblogcategory" class="tab-pane">
							<?php require(dirname(__FILE__).'/modules/pavblogcategory.tpl'); ?>
						</div>

						<div id="tab-module-pavblogcomment" class="tab-pane">
							<?php require(dirname(__FILE__).'/modules/pavblogcomment.tpl'); ?>
						</div>

						<div id="tab-module-pavbloglatest" class="tab-pane">
							<?php require(dirname(__FILE__).'/modules/pavbloglatest.tpl'); ?>
						</div>

				 	</div><!-- end div.tab-content -->

				</div><!-- end div.box-columns -->
			</div>
			<!-- end div.panel-body -->

		</div>
		<!-- end div.panel -->

	</div><!-- end div #page-content -->
</div><!-- end div #content -->
<script type="text/javascript">
	$('#grouptab li:first-child a').tab('show');

	// Save Tab When click
	$('#grouptab a').click( function(){
		$.cookie("sactived_tab", $(this).attr("href") );
	});

	if( $.cookie("sactived_tab") !="undefined" ){
		$('#grouptab a').each( function(){ 
			if( $(this).attr("href") ==  $.cookie("sactived_tab") ){
				$(this).click();
				return ;
			}
		});
	}

</script>
<?php echo $footer; ?>
