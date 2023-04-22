<?php echo $header; ?>
<div class="breadcrumb">
    <div class="container">
        <ul>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a> /</li>
            <?php } ?>
        </ul>
        <h1 class="breadcrumb-heading"><?php echo $heading_title; ?></h1>
    </div>
</div>
<div class="main-columns container space-20">
<div class="container-inside">
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-md-9 col-sm-12'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>">
            <?php echo $content_top; ?>
            <div class="pav-filter-blogs">
                <div class="pav-blogs">
                    <?php $cols = $cat_columns_leading_blogs;

                    if( count($leading_blogs) ) { ?>
                    <div class="leading-blogs row">
                        <?php foreach( $leading_blogs as $key => $blog ) { $key = $key + 1;?>
                        <div class="pavcol<?php echo $cols;?>">
                            <?php require( '_item.tpl' ); ?>
                        </div>
                        <?php if( ( $key%$cols==0 || $cols == count($leading_blogs)) ){ ?>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php
                        $cols = $cat_columns_secondary_blogs;
                        $cols = !empty($cols)?$cols:1;
                        if ( count($secondary_blogs) ) { ?>
                    <div class="secondary row">

                        <?php foreach( $secondary_blogs as $key => $blog ) {  $key = $key+1; ?>
                        <div class="pavcol<?php echo $cols;?>">
                            <?php require( '_item.tpl' ); ?>
                        </div>
                        <?php if( ( $key%$cols==0 || $cols == count($leading_blogs)) ){ ?>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="pav-pagination pagination space-top-30"><?php echo $pagination;?></div>
                </div>
            </div>
            <?php echo $content_bottom; ?>
        </div>



    <?php echo $column_right; ?>
    </div>
</div>

</div>
</div><!-- End Div Container -->
<?php echo $footer; ?>