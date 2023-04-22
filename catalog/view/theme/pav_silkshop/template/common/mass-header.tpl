

<?php require( PAVO_THEME_DIR."/template/common/config_layout.tpl" );  ?>
<?php
	$config = $this->registry->get('config');
	$themeName =  $config->get('config_template');
	require_once(DIR_SYSTEM . 'pavothemes/loader.php');
	$helper = ThemeControlHelper::getInstance( $this->registry, $themeName );
?>
<div class="container">
	<ul class="breadcrumb">
	    <h1><?php echo $heading_title; ?></h1>
	    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
	    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	    <?php } ?>
	</ul>
</div>