<div class="footer-v1">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <?php if( $content=$helper->getLangConfig('widget_contact_us') ) { ?>
                <div class="col-md-3 col-sm-6 block">
                    <h5><?php echo $objlang->get("text_contact_us"); ?></h5>
                    <div class="panel-body">
                        <?php echo $content; ?>
                    </div>
                </div>
                <?php } ?>

                <?php if ($informations) { ?>
                <div class="col-md-2 col-sm-6 block">
                    <h5><?php echo $text_information; ?></h5>
                    <ul class="list-unstyled">
                        <?php foreach ($informations as $information) { ?>
                        <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <div class="col-md-2 col-sm-6 block">
                    <h5><?php echo $text_extra; ?></h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
                        <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
                        <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
                        <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>

                    </ul>
                </div>
                <div class="col-md-2 col-sm-6 block">
                    <h5><?php echo $text_account; ?></h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
                        <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
                        <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12">
                    <?php
                    echo $helper->renderModule('pavnewsletter');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="powered">
        <div class="container">
            <?php if( $content=$helper->getLangConfig('widget_paypal') ) {?>
            <div class="paypal">
            <?php echo $content; ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <?php if( $helper->getConfig('enable_custom_copyright', 0) ) { ?>
                <?php echo html_entity_decode($helper->getConfig('copyright')); ?>
            <?php } else { ?>
                <?php echo $powered; ?>
            <?php } ?>
        </div>
    </div>
</div>