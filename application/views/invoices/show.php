
	
		<h2>Invoice # nomer <?php echo $invoice_info['id'];?></h2>
		<br>
		Shop:<?php echo $invoice_info['shop_name'];?>
		<br>
		Addres of shop: <?php echo $invoice_info['shop_addres'];?>
		<br>
		Shop phone:<?php echo $invoice_info['shop_phone'];?>
		<br>
		Shop city:<?php echo $invoice_info['city_name'];?>
		<br>
		Category:<?php echo $invoice_info['category_name'];?>
		<br>
		Created by:<?php echo $invoice_info['username'];?>
		<br>
		On date:<?php echo $invoice_info['date_invoices'];?>
		<br>
		First name:<?php echo $invoice_info['first_name'];?>
		<br>
		Last name:<?php echo $invoice_info['last_name'];?>
		<br>
		Email:<?php echo $invoice_info['email'];?>
		<br>
		Prodycts
		<br>
		<?php $i=1; ?>
		<?php 
		foreach($items_info as $item){?>
			Type:<?php echo $item['type_name'];?>   
			name: <?php echo $item['item_name'];?> 
			quantity:<?php echo $item['quantity'];?>    
			price per unt:<?php echo $item['item_price'];?>
			subtotal:<?php echo $item['subtotal'];?>
			<br>
		<?php $i++;?>
		<?php } ?>	
		<br>
		TOTAL:<?php echo $total['total_invoice'];?> <br>
		<br>
		<br> <a href="<?php echo site_url('invoices/editInvoice/'.$invoice_info['id']);?>">EDIT</a>
		
	</body>
	

