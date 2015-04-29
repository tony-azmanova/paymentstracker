	<body>
		<table>
			
			<tr>
			
				<td>Type product</td>
				<td>Category</td>
				<td>Action</td>
			
			</tr>
			<tr> 
			<?php foreach($items as $item){ ?>
			
				<td> <?php echo $item['type_name'];?> </td>
				<td> <?php echo $item['category_name'];?> </td>
				
				<td> <a href="<?php echo site_url('items/editItems/'.$item['id']);?>">EDIT</a>
				<a href="<?php echo site_url('items/deleteItemType/'.$item['id']);?>">DELETE</a>
				
			</tr>
			<?php } ?>
		</table>
		
		<p><?php echo $links; ?></p><br>
		<a href="<?php echo site_url('items/newItems');?>">Add new Item type!</a><br>

	</body>

</html>
