<html>

	<head>
	
	
	</head>

	<body>
	<h2>Add new Items type</h2>
		<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>	
		<form action = "<?php echo site_url('items/newItems');?>" method = "post">
		<label for = "product_type" style = "display: inline-block; width:100px;">Name:</label>
		<input id = "text_input" type = "text" name = "product_type" value="<?php echo set_value('product_type'); ?>">
		<?php echo form_error('product_type'); ?><br>
	
		
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
