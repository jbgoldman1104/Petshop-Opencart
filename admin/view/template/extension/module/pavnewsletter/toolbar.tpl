<div class="sidebar-nav">
	<ul class="nav nav-pills nav-stacked">
		<?php
			if(isset($menus)){
				foreach($menus as $key=>$menu){
					$class_active = "";
					if(isset($menu_active) && $menu_active == $key){
						$class_active = "active";
					}
					?>
					<li class="<?php echo $class_active; ?>"><a href="<?php echo $menu['link'];?>"><?php echo $menu['title']; ?></a></li>
					<?php
				}
			}
		?>
	</ul>
</div>