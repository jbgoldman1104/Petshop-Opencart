<div id="newsletter_block_footer" class="block pavo-newsletter <?php echo $addition_cls;?> <?php if(isset($stylecls)&&$stylecls){echo "block-".$stylecls;} ?>">
<?php if($newsletter_style == 'newsletter-v1'){ ?>
    <div class="newsletter-v1">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                     <?php if( $show_title ) { ?><h3 class="newsletter-label"><?php echo $heading_title;?></h3><?php }?>
                    <?php if($information){ ?>
                        <p><?php echo $information;?></p>
                    <?php }?>
                </div>
                <div class="col-md-6 col-lg-6">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input   class="form-control radius-6x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                            <input type="hidden" name="action" value="0" />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-lg radius-6x space-left-10" name="submitNewsletter" >Subscribe</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div><!--/end row-->
        </div><!--/end container-->
    </div>
<?php }elseif($newsletter_style == 'newsletter-v2'){?>
    <div class="newsletter-v2 background-img-v3 space-50">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                     <?php if( $show_title ) { ?><h4 class="newsletter-label"><?php echo $heading_title;?></h4><?php }?>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="input-group">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input   class="form-control radius-left-5x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                                <input type="hidden" name="action" value="0" />
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-lg radius-right-5x" name="submitNewsletter" >Subscribe</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div><!--/end row-->
        </div><!--/end container-->
    </div>
<?php }elseif($newsletter_style == 'newsletter-v3'){?>
    <div class="newsletter-v3 bg-primary space-padding-tb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                     <?php if( $show_title ) { ?><h4 class="newsletter-label"><?php echo $heading_title;?></h4><?php }?>
                    <?php if($information){?>
                        <p class="text-muted"><?php echo $information;?></p>
                    <?php }?>
                </div>
                <div class="col-md-6 col-lg-6">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input   class="form-control radius-6x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                            <input type="hidden" name="action" value="0" />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-lg radius-6x space-left-10" name="submitNewsletter" >Subscribe</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div><!--/end row-->
        </div><!--/end container-->
    </div>
<?php }elseif($newsletter_style == 'newsletter-v4'){?>
    <div class="newsletter-v4 newsletter-center space-50">
        <div class="container">
            <div class="newsletter-heading">
                 <?php if( $show_title ) { ?><h4 class="newsletter-label"><?php echo $heading_title;?></h4><?php }?>
                <?php if($information){ ?>
                    <p><?php echo $information;?></p>
                <?php }?>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 input-group">
                    <form action="#" method="post">
                        <input   class="form-control radius-left-5x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                        <input type="hidden" name="action" value="0" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-success btn-lg radius-right-5x" name="submitNewsletter" >Subscribe</button>
                        </div>
                    </form>
                </div>
            </div><!--/end row-->
        </div><!--/end container-->
    </div>
<?php }elseif($newsletter_style == 'newsletter-v6'){?>
    <div class="newsletter-v6 bg-primary light-style space-50">
        <div class="row">
            <div class="col-md-3 col-md-offset-1 text-right xs-space-20">
                 <?php if( $show_title ) { ?><h4 class="newsletter-label"><?php echo $heading_title;?></h4><?php }?>
                <?php if($information){?>
                    <p><?php echo $information;?></p>
                <?php }?>
            </div>
            <div class="col-md-6">
                <form action="#" method="post">
                    <div class="input-group">
                        <input class="form-control radius-left-5x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                        <input type="hidden" name="action" value="0" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-outline-light radius-right-5x" name="submitNewsletter" >Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!--/end row-->
    </div><!--/end container-->
<?php }elseif($newsletter_style == 'newsletter-v7'){?>
    <div class="newsletter-v7 newsletter-border background-img-v3 space-50">
        <div class="row">
            <div class="col-md-3 col-md-offset-1 text-right xs-space-20">
                <?php if( $show_title ) { ?><span class="special-label">Newsletter:</span><?php }?>
            </div>
            <div class="col-md-6">
                <form action="#" method="post">
                    <div class="input-group">
                        <input class="form-control radius-left-5x" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                        <input type="hidden" name="action" value="0" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-default radius-right-5x" name="submitNewsletter" >Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!--/end row-->
    </div><!--/end container-->
<?php }elseif($newsletter_style == 'newsletter-v8'){?>
    <div class="newsletter-v8 space-50 bg-success">
        <div class="container">
            <div class="heading heading-light">
                 <?php if( $show_title ) { ?><h2>Sign up for newsletter</h2><?php }?>
                <?php if($information){?>
                    <span><?php echo $information;?></span>
                <?php } ?>
            </div>

            <form role="form">
                <form action="#" method="post">
                    <div class="input-group newsletter-group">
                        <input class="newsletter-input form-control radius-6x input-lg" id="newsletter-input-footer" type="text" name="email"  placeholder="<?php if(isset($value) && $value){ echo $value; }else{ echo "your e-mail";} ?>" />
                        <input type="hidden" name="action" value="0" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-primary radius-6x" name="submitNewsletter" >Subscribe</button>
                        </div>
                    </div>
                </form>
            </form>
        </div>
    </div>
<?php }?>
</div>
<!-- /Block Newsletter module-->



<script type="text/javascript">
    var placeholder = "{l s='your e-mail' mod='ptspagebuilder' js=1}";
    {literal}
        $(document).ready(function() {
            $('#newsletter-input-footer').on({
                focus: function() {
                    if ($(this).val() == placeholder) {
                        $(this).val('');
                    }
                },
                blur: function() {
                    if ($(this).val() == '') {
                        $(this).val(placeholder);
                    }
                }
            });

            $("#newsletter_block_footer form").submit( function(){
                if ( $('#newsletter-input-footer').val() == placeholder) {
                    $("#newsletter_block_footer .alert").removeClass("hide");
                    return false;
                }else {
                     $("#newsletter_block_footer .alert").addClass("hide");
                     return true;
                }
            } );
        });

    {/literal}
</script>