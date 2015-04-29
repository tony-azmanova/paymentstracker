	<?php if(isset($invoice_info['id'])) { ?>
		<h2>Editing invoice # nomer <?php echo $invoice_info['id'];?></h2>
	<?php } ?>
	<?php if(isset($succses)) { ?>
		<div style="background:#00FF00;">Success!</div>
		<?php } ?>
		<form action = "<?php echo site_url('invoices/editInvoice'."/".$invoice_id);?>" method = "post">
			<label for="date" style="display: inline-block; width:100px;">Invoice Date:</label>
			<input type="date" name="invoice_date" value="<?php  echo  date("Y-m-d", strtotime($invoice_info['date_invoices'])) ;?>">
			<?php echo form_error('invoice_date');?>
			<label for="category" style= "display: inline-block; width:100px;">Category:</label>
			<?php 
			$d_category= array(''=>"Select");
				foreach($categories as $category) {
					$d_category[] = $category['category_name'];
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
			
			<h3>Products</h3>	

			<div id="all_products">
			
				<?php $i=0; ?>
				<?php foreach($invoice_products as $products_i){ ?>
				<div>
					<label for="products" style="display: inline-block; width:60px;">Products:</label>
					<?php $d_items = array(''=>"Select"); 		
						foreach($products as $product) {
							$d_items[$product['id']] = $product['type_name'];
						}
						echo form_dropdown('products[type_id][]', $d_items, set_value('products[type_id][]',$products_i['type_id'])); 
					?>
							
					<label for="quantity" style="display: inline-block; width:100px;">Quantity:</label>
					<input type="text" name="products[quantity][]" value="<?php echo set_value('products[quantity][]',$products_i['quantity']); ?>">		
					
					<label for="price" style="display: inline-block; width:100px;">Price per unit:</label>
					<input type="text" name="products[item_price][]" value="<?php echo set_value('products[item_price][]',$products_i['item_price']); ?>">
						
					<label for="product_name" style="display: inline-block; width:100px;">Product name:</label>
					<input type="text" name="products[item_name][]" value="<?php  echo set_value('products[item_name][]',$products_i['item_name']); ?>" ><br>
					
					<div class="product_errors" style="background-color:#FF0000;">
						<?php echo form_error('products[type_id]['.$i.']'); ?>
						<?php echo form_error('products[quantity]['.$i.']'); ?>			
						<?php echo form_error('products[item_price]['.$i.']'); ?>			
						<?php echo form_error('products[item_name]['.$i.']'); ?>	
					</div>
					
					
				</div>
				<?php $i++; ?>
				<?php } ?>
			</div>
			<button id="addMore">Add more</button>
			<input type = "submit" name = "update" value ="update"><br>	
		</form>
