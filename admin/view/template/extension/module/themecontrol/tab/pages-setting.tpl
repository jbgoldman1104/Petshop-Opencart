

	  				 <ul class="nav nav-tabs" id="tabpages">
	  					<li class="active"><a href="#tab-pcategory"  role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> <?php echo $olang->get('text_category_listing_page');?></a></li>
	  					<li><a href="#tab-pproduct"  role="tab" data-toggle="tab"><i class="fa fa-wrench" ></i> <?php echo $olang->get('text_product_page');?></a></li>
	  					<li><a href="#tab-pcontact"  role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> <?php echo $olang->get('text_contact_page');?></a></li>
	  				 </ul>

	  				 <div class="tab-content">
			  			 <div  class="tab-pane active"  id="tab-pcategory">
			  			 	<div class="tab-inner">

							 		<div class="form-group">

										<label class="col-sm-2 control-label" id="text_product_display_mode"><?php echo $olang->get('text_product_display_mode');?></label>
										<div class="col-sm-10">
											 <select class="form-control" name="themecontrol[cateogry_display_mode]">
			  			 						<?php foreach( $cateogry_display_modes as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['cateogry_display_mode']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  			 					</select>
										</div>
									</div>

									<div class="form-group">

										<label class="col-sm-2 control-label" id="entry_listing_products_columns"><?php echo $olang->get('entry_listing_products_columns');?></label>
										<div class="col-sm-10">
											 <select class="form-control" name="themecontrol[listing_products_columns]">
			  			 						<?php foreach( $product_rows as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['listing_products_columns']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  			 					</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" id="entry_listing_products_columns"><?php echo $olang->get('entry_listing_products_columns_small');?></label>
										<div class="col-sm-10">
											<select class="form-control" name="themecontrol[listing_products_columns_small]">
			  			 						<?php foreach( $product_rows_tablet as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['listing_products_columns_small']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  			 					</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" id="entry_listing_products_columns"><?php echo $olang->get('entry_listing_products_columns_minismall');?></label>
										<div class="col-sm-10">
										 	<select class="form-control" name="themecontrol[listing_products_columns_minismall]">
			  			 						<?php foreach( $product_rows_mobile as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['listing_products_columns_minismall']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  			 					</select>
										</div>
									</div>

 									<div class="form-group">
										<label class="col-sm-2 control-label" id="entry_listing_products_columns"><?php echo $olang->get('text_show_product_zoom');?></label>
										<div class="col-sm-10">
										 	 <select class="form-control form-switch" name="themecontrol[category_pzoom]">
			  			 						<?php foreach( $yesno  as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['category_pzoom']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  			 					</select>
										</div>
									</div>

			  			 	</div>
			  			 </div>


			  			  <div class="tab-pane" id="tab-pproduct">
			  				<div class="tab-inner">

			  						<div class="form-group">
										<label class="col-sm-2 control-label" id="entry_listing_products_columns"><?php echo $olang->get('text_enable_productzoom');?></label>
										<div class="col-sm-10">
											<select class="form-control form-switch" name="themecontrol[product_enablezoom]">
			  									<?php foreach( $yesno  as $k=>$v ) { ?>
			  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['product_enablezoom']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
			  			 						<?php }  ?>
			  								</select>
										</div>
									</div>


										<div class="form-group hide">
											<label class="col-sm-2 control-label" id="text_product_zoomgallery"><?php echo $olang->get('text_product_zoomgallery');?></label>
											<div class="col-sm-10">
												<select class="form-control" name="themecontrol[product_zoomgallery]">
				  									<?php foreach( $product_zoomgallery  as $k=>$v ) { ?>
				  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['product_zoomgallery']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
				  			 						<?php }  ?>
				  								</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" id="text_product_zoomgallery"><?php echo $olang->get('text_product_zoommode');?></label>
											<div class="col-sm-10">
												<select class="form-control" name="themecontrol[product_zoommode]">
				  									<?php foreach( $product_zoom_modes  as $k=>$v ) { ?>
				  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['product_zoommode']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
				  			 						<?php }  ?>
				  								</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" id="text_product_zoomgallery"><?php echo $olang->get('text_product_zoomlenssize');?></label>
											<div class="col-sm-10">
												<input class="form-control" value=<?php echo $module['product_zoomlenssize'];?> name="themecontrol[product_zoomlenssize]"/>
											</div>
										</div>


			  					 		<div class="form-group">
											<label class="col-sm-2 control-label" id="text_product_zoomgallery"><?php echo $olang->get('text_product_zoomeasing');?></label>
											<div class="col-sm-10">
												<select class="form-control form-switch" name="themecontrol[product_zoomeasing]">
				  									<?php foreach( $yesno  as $k=>$v ) { ?>
				  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['product_zoomeasing']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
				  			 						<?php }  ?>
				  								</select>
											</div>
										</div>

			  							<div class="form-group">
											<label class="col-sm-2 control-label" id="text_product_zoomgallery"><?php echo $olang->get('text_product_zoomlensshapes');?></label>
											<div class="col-sm-10">
												<select class="form-control" name="themecontrol[product_zoomlensshape]">
				  									<?php foreach( $product_zoomlensshapes  as $k=>$v ) { ?>
				  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['product_zoomlensshape']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
				  			 						<?php }  ?>
				  								</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" id="text_product_related_column"><?php echo $olang->get('text_related_columns');?></label>
											<div class="col-sm-10">
												<select class="form-control" name="themecontrol[product_related_column]">
					  			 						<?php  foreach( $product_rows as $k=>$v ) { ?>
					  			 					 			<option value="<?php echo $k;?>"  <?php if( $k==$module['product_related_column']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
					  			 						<?php  }  ?>
			  			 						</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label" id="text_add_product_tab"><?php echo $olang->get('text_add_product_tab');?></label>
											<div class="col-sm-10">
												<select class="form-control form-switch" name="themecontrol[enable_product_customtab]">
				  			 						<?php foreach( $yesno as $k=>$v ) { ?>
				  			 					 		<option value="<?php echo $k;?>"  <?php if( $k==$module['enable_product_customtab']){ ?> selected="selected" <?php } ?>><?php echo $v;?></option>
				  			 						<?php }  ?>
				  			 					</select>
											</div>
										</div>


										<div class="product-customhtml">
											<label class="col-sm-2 control-label" id="text_add_product_tab"><?php echo $olang->get('text_customhtml');?></label>

											<div class="col-sm-10">
												<ul class="nav nav-tabs" id="tab-customhtml">
											  	<?php foreach ($languages as $language) { ?>
											  		<li><a href="#tab-customhtml<?php echo $language['language_id'];?>" role="tab" data-toggle="tab">
											  			<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
											  		</li>
											  	<?php } ?>
											  	</ul>
                                                <div class="tab-content">
                                                    <?php
                                                    foreach( $languages as $language ) {
				  			 							$customtab_name = isset($module['product_customtab_name'][$language['language_id']])?$module['product_customtab_name'][$language['language_id']] :"";
				  			 							$customtab_content = isset($module['product_customtab_content'][$language['language_id']])?$module['product_customtab_content'][$language['language_id']]:"";
                                                    ?>
                                                    <div class="tab-pane" id="tab-customhtml<?php echo $language['language_id'];?>">
				  			 					 		<label id="text_add_product_tab"><?php echo $olang->get('entry_customtab_name');?></label>
						  			 					 <p><input class="form-control" size="80" type="text"  name="themecontrol[product_customtab_name][<?php echo $language['language_id'];?>]" value="<?php echo $customtab_name;?>"/></p>
						  			 					 <label> <?php echo $olang->get('entry_customtab_content');?>
				  			 							<textarea id="customtab-content-<?php echo $language['language_id']; ?>"  style="width:90%; height:300px" name="themecontrol[product_customtab_content][<?php echo $language['language_id'];?>]"><?php echo $customtab_content;?></textarea>
                                                    </div>
                                                    <?php } ?>
                                                </div>
				  			 				</div>

										</div>


			  				</div>
			  			 </div>

			  			 <div class="tab-pane" id="tab-pcontact">
			  			 	<div class="tab-inner">
			  			 			<h4><?php echo $olang->get('text_contact_googlemap'); ?></h4>
			  			 			<div class="form-group">
										<label class="col-sm-2 control-label" id="text_contact_googlemap"><?php echo $olang->get('help_location_address');?></label>
										<div class="col-sm-10">
											<input class="form-control" id="searchTextField" name="themecontrol[location_address]" type="text" value="<?php echo isset($module['location_address'])?$module['location_address']:''; ?>" placeholder="<?php echo $olang->get('text_location_address'); ?>" autocomplete="on" runat="server" size="60"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" id="text_contact_googlemap"><?php echo $olang->get('location_latitude');?></label>
										<div class="col-sm-10">
											<input class="form-control" id="location_latitude" name="themecontrol[location_latitude]" value="<?php echo isset($module['location_latitude'])?$module['location_latitude']:''; ?>" size="30"/>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label" id="text_contact_googlemap"><?php echo $olang->get('location_longitude');?></label>
										<div class="col-sm-10">
											<input class="form-control" id="location_longitude" name="themecontrol[location_longitude]" value="<?php echo isset($module['location_longitude'])?$module['location_longitude']:''; ?>" size="30"/>
										</div>
									</div>

								<div>
									<h4 class="col-sm-2"><?php echo $olang->get('text_contact_html');?></h4>
									<div class="col-sm-10">
										<ul class="nav nav-tabs nav-tablangs" id="tab-lang-contact-page">
									  	<?php foreach ($languages as $language) { ?>
									  		<li><a href="#tab-lang-contact-page<?php echo $language['language_id'];?>" role="tab" data-toggle="tab">
									  			<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
									  		</li>
									  	<?php } ?>
									  	</ul>

									  	<div class="tab-content">
				  			 			<?php foreach( $languages as $language ) {  ?>
				  			 				<div class="tab-pane" id="tab-lang-contact-page<?php echo $language['language_id'];?>">
				  			 					<?php
				  			 						$contact_customhtml = isset($module['contact_customhtml'][$language['language_id']])?
				  			 						$module['contact_customhtml'][$language['language_id']]:"";
				  			 					 ?>
				  			 					<textarea style="width:90%; height:300px" id="contact_customhtml<?php echo $language['language_id'];?>" name="themecontrol[contact_customhtml][<?php echo $language['language_id'];?>]"><?php echo $contact_customhtml;?></textarea>
				  		 					</div>
				  			 			<?php } ?>
			 							</div>
			 						</div>
		 						</div>
			  			 	</div>
			  			 </div>

			  			</div>  <div class="clear clearfix"></div>


<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {  $('#tabpages a:first').tab('show'); });
    $('#tab-customhtml a:first').tab('show');
	function initialize() {
		var input = document.getElementById('searchTextField');
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();

			var lat = place.geometry.location.lat();
			var lon = place.geometry.location.lng();

			document.getElementById('location_latitude').value = lat;
			document.getElementById('location_longitude').value = lon;
		});
	}
    google.maps.event.addDomListener(window, 'load', initialize);
</script>