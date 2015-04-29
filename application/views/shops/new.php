<html>

	<head>
	
	
	</head>

	<body>
		<h2>Add new shop</h2>
	
			<form action = "<?php echo site_url('shops/newShop');?>" method = "post">
			
			<label for = "name" style = "display: inline-block; width:100px;">Name:</label>
			<input id = "text_input" type = "text" name = "shop_name" value="<?php echo set_value('shop_name'); ?>">
			<?php echo form_error('shop_name'); ?><br>
			
			<label for = "addres" style = "display: inline-block; width:100px;">Addres:</label>
			<input id = "text_input" type = "text" name = "shop_addres"  value="<?php echo set_value('shop_addres'); ?>">
			<?php echo form_error('shop_addres'); ?><br>
			
			<label for = "phone" style = "display: inline-block; width:100px;">Phone:</label>
			<input id = "text_input" type = "text" name = "shop_phone"  value="<?php echo set_value('shop_phone'); ?>">
			<?php echo form_error('shop_phone'); ?><br>
			
			<label for="city" style= "display: inline-block; width:100px;">City:</label>
			<?php $d_city = array(''=>"Select");
				foreach($cities as $city){
					$d_city[$city['id']] = $city['city_name'];	
				}	
				echo form_dropdown('city', $d_city, set_value('city'));
				?>
			<?php echo form_error('city'); ?><br>
				
			<label for="category" style= "display: inline-block; width:100px;">Category:</label>
			<?php $d_category = array(''=>"Select");
				foreach($categories as $category){
					$d_category [$category['id']] = $category['category_name'];	
				}	
				echo form_dropdown('category', $d_category , set_value('category'));
				?>
			<?php echo form_error('category'); ?><br>
				
			<input type = "submit" name = "save" value ="save"><br>	

	</body>

</html>
