		<div class= "container_list">
			<div class = "row" style="background:#337ab7;">
				<div class= "visible-md col-md-4">Type product</div>
				<div class= "visible-md col-md-4">Category</div>
				<div class= "visible-md col-md-4">Action</div>
			</div>
			
			<div class = "row"> 
				<?php foreach($items as $item){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Type product:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $item['type_name'];?> </div>
					<div class= "visible-md col-md-4"><?php echo $item['type_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">>Category:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $item['category_name'];?> </div>
					<div class= "visible-md col-md-4"><?php echo $item['category_name'];?> </div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Action:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md">
						<a href="<?php echo site_url('items/editItems/'.$item['id']);?>">EDIT</a>
						<a href="<?php echo site_url('items/deleteItemType/'.$item['id']);?>">DELETE</a>
					</div>
					<div class= "visible-md col-md-4">	
						<a href="<?php echo site_url('items/editItems/'.$item['id']);?>">EDIT</a>
						<a href="<?php echo site_url('items/deleteItemType/'.$item['id']);?>">DELETE</a>
					</div>
				<?php } ?>
			</div>	
		</div>
		<br>
		<p><?php echo $links; ?></p><br>
		<a href="<?php echo site_url('items/newItems');?>">Add new Item type!</a><br>

	</body>

</html>
