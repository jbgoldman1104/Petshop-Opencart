<?php



$template = dirname(__FILE__).'/pagebuilder-rows.tpl';
$level = 1;
?>


<div id="pav-homebuilder<?php echo rand(); ?>" class="homebuilder clearfix <?php echo $class ?>">

    <?php foreach ( $layouts as $row) {
	 		$row->level = $level;

    ?>

    <div class="pav-container <?php echo $row->cls; ?> <?php if ( isset($row->parallax)&&$row->parallax ) { ?> pts-parallax <?php } ?>"
    <?php echo $row->attrs?>>
    <div class="pav-inner <?php if ($row->fullwidth==0 ) { ?>container<?php } ?>">

        <div class="row row-level-<?php echo $row->level; ?> <?php echo $row->sfxcls?>">
            <div class="row-inner clearfix">
                <?php foreach( $row->cols as $col ) { ?>
                <!--<div class="col-lg-<?php echo $col->lgcol; ?> col-md-<?php echo $col->mdcol;?> col-sm-<?php echo $col->smcol;?> col-xs-<?php echo $col->xscol;?> <?php echo $col->sfxcls?>">-->
                <div class="col-lg-<?php echo $col->lgcol; ?> col-md-<?php echo $col->mdcol;?> col-sm-<?php echo $col->smcol;?> col-xs-<?php echo $col->xscol;?> <?php echo $col->sfxcls?>">
                    <div class="col-inner <?php echo $col->cls;?>"
                    <?php echo $col->attrs?>>

                    <?php foreach ( $col->widgets as $widget ){ ?>
                    <?php if( isset($widget->content) ) { ?>
                    <?php echo $widget->content; ?>
                    <?php } ?>
                    <?php } ?>

                    <?php if (isset($col->rows)&&$col->rows) { ?>
                    <?php
						                        $rows = $col->rows;
                    $level = $level + 1;
                    require( $template );
                    ?>
                    <?php } ?>

                </div>
            </div>
            <?php } ?>
        </div>
    </div>

</div>
</div>
<?php } ?>

</div>

