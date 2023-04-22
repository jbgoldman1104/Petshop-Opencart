<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" class="<?php echo $helper->getDirection(); ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/head.tpl' ) );   ?>
<body class="<?php echo $class; ?> <?php echo $helper->getPageClass();?>">
<div class="row-offcanvas row-offcanvas-left layout-<?php echo $template_layout; ?>">
<div id="page">
<div class="toggle-overlay-container">
    <div class="search-box"> <?php echo $search; ?> </div>
    <div class="dropdown-toggle-button" data-target=".toggle-overlay-container">x</div>
</div>
<nav id="top" class="topbar topbar-v2">
    <div class="container">
        <div class="info-topbar pull-left hidden-xs">
            <?php if( $content=$helper->getLangConfig('widget_call') ) { ?>
            <?php echo $content; ?>
            <?php } ?>
        </div>
        <div id="top-links" class="nav top-link pull-right">
            <ul class="list-inline">

                <li><?php echo $currency; ?></li>
                <li><?php echo $language; ?></li>
                <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"
                                        class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span
                                class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <?php if ($logged) { ?>
                        <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
                        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                        <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
                        <?php } else { ?>
                        <li><a href="<?php echo $register; ?>"><i class="fa fa-user-plus"></i><?php echo $text_register; ?></a></li>
                        <li><a href="<?php echo $login; ?>"><i class="fa fa-users"></i><?php echo $text_login; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown"><a href="<?php echo $objlang->get("text_setting"); ?>" title="<?php echo $objlang->get("text_setting"); ?>"
                                        class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> <span
                                class="hidden-xs hidden-sm hidden-md"><?php echo $objlang->get("text_setting"); ?></span> <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-list-alt"></i><?php echo $text_wishlist; ?></a></li>
                        <li><a class="shoppingcart" href="<?php echo $shopping_cart; ?>"><i class="fa fa-bookmark"></i><?php echo $text_shopping_cart; ?></a></li>
                        <li><a class="last checkout" href="<?php echo $checkout; ?>"><i class="fa fa-share"></i><?php echo $text_checkout; ?></a></li>
                        <li><a class="account" href="<?php echo $account; ?>"><i class="fa fa-user"></i><?php echo $text_account; ?></a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<header class="header header-v2">
    <div class="part-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 pull-left">
                    <div class="logo">
                        <?php if ($logo) { ?>
                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>"
                                                            alt="<?php echo $name; ?>" class="img-responsive"/></a>
                        <?php } else { ?>
                        <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                        <?php } ?>
                    </div>
                </div>
                <div class="search-cart col-md-4 col-sm-6 col-xs-6 pull-right">
                    <?php echo $cart; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="part-2">
        <div class="container">
            <div class="row">

                    <div class="bo-mainmenu">
                        <?php  require( ThemeControlHelper::getLayoutPath( 'common/parts/mainmenu.tpl' ) );   ?>
                    </div>

                    <div class="search-cart">
                        <div id="search-container" class="search-box-wrapper pull-right">
                            <div class="pbr-dropdow-search dropdown">
                                <button class="btn btn-search radius-x dropdown-toggle-overlay" type="button"
                                        data-target=".toggle-overlay-container">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>
                        </div>

                    </div>

            </div>
        </div>
    </div>

</header>
<!-- sys-notification -->
<div id="sys-notification">
    <div class="container">
        <div id="notification"></div>
    </div>
</div>
<!-- /sys-notification -->
  <?php
  /**
  * Showcase modules
  * $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
  */
  //$modules = $helper->getCloneModulesInLayout( $blockid, $layoutID );
  $blockid = 'slideshow';
  $blockcls = "hidden-xs hidden-sm";
  $ospans = array(1=>12);
  require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
  ?>
  <?php
  /**
  * Showcase modules
  * $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
  */
  $blockid = 'showcase';
  $blockcls = 'hidden-xs hidden-sm';
  $ospans = array(1=>12);
  require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
  ?>
  <?php
  /**
  * promotion modules
  * $ospans allow overrides width of columns base on thiers indexs. format array( column-index=>span number ), example array( 1=> 3 )[value from 1->12]
  */
  $blockid = 'promotion';
  $blockcls = "hidden-xs hidden-sm";
  $ospans = array(1=>12, 2=>12);
  require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
  ?>
 <div class="maincols">