<div class="panel pavshoplocation <?php echo $prefix ?>">
	<div class="panel-heading"><h4 class="panel-title"><?php echo $title; ?></h4></div>
	<div class="panel-body">
		<?php if(isset($des) && !empty($des)): ?>
		<div class="description"><?php echo html_entity_decode($des); ?></div>
		<?php endif; ?>
		
		<div class="pavmap">
			<div id="directory-main-bar-<?php echo $module;?>" class="gmap"></div>
		</div>
		<div class="box-shop"><?php if(isset($locations)): ?>
		<?php $i=0; foreach ($locations as $location): $i++;?>
			<ul class="list item-location" id="location-<?php echo $location["location_id"]; ?>" data-id="shop<?php echo $i ?>" data-lat="<?php echo $location["latitude"]; ?>" data-lon="<?php echo $location["longitude"]; ?>">
				<li>
					<span class="fa fa-map-marker pull-left"></span>
					<div class="shop-title pull-left">
						<?php echo $location['title'];?>
						<span class="shop-status hide"><?php echo ($location["option"])?$this->language->get('text_coming_soon'):'';?></span>
					</div>
					<div class="shop-address pull-left"><?php echo $location['address'];?></div>
				</li>
			</ul>
		<?php endforeach; ?>
		</div><?php endif; ?>
	</div>
</div>

<script type="text/javascript">
var mapDiv, map, infobox;
jQuery(document).ready(function($) {
	mapDiv = $("#directory-main-bar-<?php echo $module;?>");
	mapDiv.height(<?php echo $height; ?>).gmap3({
		map: {
			options: {
				"draggable": true
				,"mapTypeControl": true
				,"mapTypeId": google.maps.MapTypeId.ROADMAP
				,"scrollwheel": true //Alow scroll zoom in, zoom out
				,"panControl": true
				,"rotateControl": false
				,"scaleControl": true
				,"streetViewControl": true
				,"zoomControl": true
			}
		}
		,marker: {
			values: [
				<?php $i=0; foreach ($locations as $location): $i++;?>
				<?php $image = $location['image']; ?>
				{
					latLng: [<?php echo $location['latitude']; ?>, <?php echo $location['longitude']; ?>],
					options: {
						icon: "<?php echo $location['icon']; ?>",
						//shadow: "icon-shadow.png",
					},
					data: '<div class="marker-holder"><div class="marker-content with-image"><img src="<?php echo $image; ?>" alt=""><div class="map-item-info"><div class="title">'+"<?php echo $location['title']; ?>"+'</div><div class="address">'+"<?php echo $location['address']; ?>"+'</div><div class="description">'+"<?php echo $location['content']; ?>"+'</div><a href="' + "<?php echo $location['link']?>" + '" class="more-button">' + "<?php echo $text_view_more; ?>" + '</a></div><div class="arrow"></div><div class="close"></div></div></div></div>', "id":"shop<?php echo $i; ?>"
				},
				<?php endforeach; ?>
			],
			options:{
				draggable: false, //Alow move icon location
			},
			cluster:{
				radius: 20,
				// This style will be used for clusters with more than 0 markers
				0: {
					content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				// This style will be used for clusters with more than 20 markers
				20: {
					content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				// This style will be used for clusters with more than 50 markers
				50: {
					content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				events: {
					click: function(cluster) {
						map.panTo(cluster.main.getPosition());
						map.setZoom(map.getZoom() + 2);
					}
				}
			},
			events: {
				click: function(marker, event, context){
					map.panTo(marker.getPosition());

					infobox.setContent(context.data);
					infobox.open(map,marker);

					// if map is small
					var iWidth = 260;
					var iHeight = 300;
					if((mapDiv.width() / 2) < iWidth ){
						var offsetX = iWidth - (mapDiv.width() / 2);
						map.panBy(offsetX,0);
					}
					if((mapDiv.height() / 2) < iHeight ){
						var offsetY = -(iHeight - (mapDiv.height() / 2));
						map.panBy(0,offsetY);
					}

				}
			}
		}
	},"autofit");

	map = mapDiv.gmap3("get");
	infobox = new InfoBox({
		pixelOffset: new google.maps.Size(-50, -65),
		closeBoxURL: '',
		enableEventPropagation: true
	});
	mapDiv.delegate('.infoBox .close','click',function () {
		infobox.close();
	});

	$(".pavshoplocation .item-location").click(function(){
		var id = $(this).attr('data-id');
		var marker = $("#directory-main-bar-<?php echo $module;?>").gmap3({ get: { id: id } });
		google.maps.event.trigger(marker, 'click');
		map.setCenter(marker.getPosition());
		map.setZoom(15);
	});
});
</script>