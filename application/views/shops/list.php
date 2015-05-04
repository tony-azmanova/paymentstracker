		<div class= "container_list">
			<div class = "row" style="background:#337ab7;">
				<div class= "visible-md col-md-2">Shop</div>
				<div class= "visible-md col-md-4">City</div>
				<div class= "visible-md col-md-2">Category</div>
				<div class= "visible-md col-md-4">Action</div>
			</div>
			<div class = "row">
				<?php foreach($shops as $shop){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Shop:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $shop['shop_name'];?> </div>
					<div class= "visible-md col-md-2"><?php echo $shop['shop_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">City:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $shop['city_name'];?> </div>
					<div class= "visible-md col-md-4"><?php echo $shop['city_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Category:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $shop['category_name'];?> </div>
					<div class= "visible-md col-md-2"><?php echo $shop['category_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Action:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md">
						<a href="<?php echo site_url('shops/editShop/'.$shop['id']);?>">EDIT</a>
						<a href="<?php echo site_url('shops/deleteShop/'.$shop['id']);?>">DELETE</a>
						<a href="<?php echo site_url('shops/shopInfo/'.$shop['id']);?>">INFO</a>
					</div>
					<div class= "visible-md col-md-4">
					<a href="<?php echo site_url('shops/editShop/'.$shop['id']);?>">EDIT</a>
						<a href="<?php echo site_url('shops/deleteShop/'.$shop['id']);?>">DELETE</a>
						<a href="<?php echo site_url('shops/shopInfo/'.$shop['id']);?>">INFO</a>
					</div>
				
				<?php } ?>
			</div>
		</div>
		<br>
		<p><?php echo $links; ?></p><br>
	
		
		
		<a href="<?php echo site_url('shops/newShop');?>">Add new shop!</a><br>
	</body>

</html>
