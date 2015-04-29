	<?php if(isset($invoice_info['id'])) { ?>
		<h2>Editing invoice # nomer <?php echo $invoice_info['id'];?></h2>
	<?php } ?>
	<?php if(isset($success)) { ?>
		<div style="background:#00FF00;">Success!</div>
	<?php } ?>
		<form action = "<?php echo site_url('invoices/'.$action."/".$invoice_id);?>" method = "post">
			<label for="date" style="display: inline-block; width:100px;">Invoice Date:</label>
			<input type="date" name="invoice_date" value="<?php  echo set_value('invoice_date',$set_date ) ;?>">
			<?php echo form_error('invoice_date');?>
			<label for="category" style= "display: inline-block; width:100px;">Category:</label>
			<?php 
			$d_category= array(''=>"Select");
				foreach($categories as $category) {
					$d_category[$category['id']] = $category['category_name'];
				}
				echo form_dropdown('category', $d_category, set_value('category',$invoice_info['category_id']));
				echo form_error('category');
			?>	
			<label for="type" style= "display: inline-block; width:100px;">Type:</label>
			<?php 
				$d_type = array(''=>"Select");
				foreach($types as $type) {
					$d_type[$type['id']] = $type['transaction_name'];
				}
				echo form_dropdown('transaction_type', $d_type, set_value('transaction_type',$invoice_info['transaction_id'])); 
			echo form_error('transaction_type');
			?>	
			<br>
			<label for="shop" style= "display: inline-block; width:100px;">Shop name:</label>
			<?php
				$d_shops = array(''=>"Select");
				foreach($shops as $shop) { 
					$d_shops[$shop['id']] = $shop['shop_name'];
				}
				echo form_dropdown('shop', $d_shops, set_value('shop',$invoice_info['shop_id']));
			echo form_error('shop');
			?>		
			<label for="status" style= "display: inline-block; width:100px;">Status:</label>
			<?php $d_statuses = array(''=>"Select");
				foreach($statuses as $status){
					$d_statuses[$status['id']] = $status['status_name'];
				}	
				echo form_dropdown('status', $d_statuses, set_value('status',$invoice_info['status_id']));
			echo form_error('status');
			?>
			<br>
			
			<h3>items</h3>	
			
			<div id="all_items">
				<?php echo form_error('items'); ?>
				<?php if(!empty($invoice_items )) { ?>
					<?php $i=0; ?>
					<?php foreach($invoice_items as $items_i){ ?>
					<div class="item">
						<label for="items" style="display: inline-block; width:60px;">items:</label>
						<?php $d_items = array(''=>"Select"); 		
							foreach($items as $item) {
								$d_items[$item['id']] = $item['type_name'];
							}
							echo form_dropdown('items[type_id][]', $d_items, set_value('items[type_id][]',$items_i['type_id'])); 
						?>
								
						<label for="quantity" style="display: inline-block; width:100px;">Quantity:</label>
						<input type="text" name="items[quantity][]" value="<?php echo set_value('items[quantity][]',$items_i['quantity']); ?>">		
						
						<label for="price" style="display: inline-block; width:100px;">Price per unit:</label>
						<input type="text" name="items[item_price][]" value="<?php echo set_value('items[item_price][]',$items_i['item_price']); ?>">
							
						<label for="item_name" style="display: inline-block; width:100px;">item name:</label>
						<input type="text" name="items[item_name][]" value="<?php  echo set_value('items[item_name][]',$items_i['item_name']); ?>" >
						<a href="#" class ="remove">REMOVE</a>
						<br>
						
						<div class="item_errors" style="background-color:#FF0000;">
							<?php echo form_error('items[type_id]['.$i.']'); ?>
							<?php echo form_error('items[quantity]['.$i.']'); ?>			
							<?php echo form_error('items[item_price]['.$i.']'); ?>			
							<?php echo form_error('items[item_name]['.$i.']'); ?>	
						</div>
						
						
					</div>
					<?php $i++; ?>
					<?php } ?>
				<?php } ?>
			</div>
			<button id="addMore">Add more</button>
			
			<input type = "submit" name = "save" value ="save"><br>	
		</form>
