<div class="panel store">
  <div class="penl-heading">
    <span><?php echo $heading_title; ?></span>
    <em class="shapes right"></em>  
    <em class="line"></em>
  </div>
  <div class="panel-body">
    <p style="text-align: center;"><?php echo $text_store; ?></p>
    <?php foreach ($stores as $store) { ?>
    <?php if ($store['store_id'] == $store_id) { ?>
    <a href="<?php echo $store['url']; ?>"><b><?php echo $store['name']; ?></b></a><br />
    <?php } else { ?>
    <a href="<?php echo $store['url']; ?>"><?php echo $store['name']; ?></a><br />
    <?php } ?>
    <?php } ?>    
  </div>
</div>
