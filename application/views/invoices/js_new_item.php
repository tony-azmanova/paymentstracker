<!-- New item div -->
<div id="item_container" style="display:none;">
	<label for="items" style="display: inline-block; width:60px;">Items:</label>	
	<select name="items[type_id][]" id="item_id">	
		<option value="" >Select Item</option>
		<?php foreach($items as $item){ ?>
		<option value = "<?php echo $item['id'] ;?>"><?php echo $item['type_name'];?></option>
		<?php } ?>
	</select>
	<label for="quantity" style="display: inline-block; width:100px;">Quantity:</label>
	<input type="text" name="items[quantity][]" id="item_quantity">
	<label for="price" style="display: inline-block; width:100px;">Price per unit:</label>
	<input type="text" name="items[item_price][]" id="item_price">
	<label for="item_name" style="display: inline-block; width:100px;">Item name:</label>
	<input type="text" name="items[item_name][]"  id="item_name">
	<a href="#" class ="remove">REMOVE</a>
</div>
