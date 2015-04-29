	<body>
		
		<table>
			
			<tr>
				<td>Shop</td>
				<td>City</td>
				<td>Category</td>
				<td>Action</td>
			
			</tr>
			<tr> 
			<?php foreach($shops as $shop){ ?>
				<td> <?php echo $shop['shop_name'];?> </td>
				<td> <?php echo $shop['city_name'];?> </td>
				<td> <?php echo $shop['category_name'];?> </td>
				
				<td> <a href="<?php echo site_url('shops/editShop/'.$shop['id']);?>">EDIT</a>
					<a href="<?php echo site_url('shops/deleteShop/'.$shop['id']);?>">DELETE</a>
					<a href="<?php echo site_url('shops/shopInfo/'.$shop['id']);?>">INFO</a>
				</td>
			</tr>
			<?php } ?>
		</table>
		
		<p><?php echo $links; ?></p><br>
	
		
		
		<a href="<?php echo site_url('shops/newShop');?>">Add new shop!</a><br>
	</body>

</html>
