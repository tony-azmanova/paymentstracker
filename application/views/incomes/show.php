	<body>
		<h2>Incomes # number <?php echo $incomes_info['id'];?></h2>
	
	Income name:<?php echo $incomes_info['income_name'];?>
		<br>
	Income date:
	<?php echo $incomes_info['date_incomes'];?>
		<br>
	Income category:
	<?php echo $incomes_info['category_name'];?>
		<br>	
	From company:
	<?php echo $incomes_info['company'];?>
		<br>
	Client first name:
	<?php echo $incomes_info['client_first_name'];?>
		<br>
	 Client last name :
	<?php echo $incomes_info['client_last_name'];?>
		<br>
	Email company/client:
	<?php echo $incomes_info['email'];?>
		<br>
	Phone company/client:
	<?php echo $incomes_info['phone'];?>
		<br>
	
	Total income:<?php echo $incomes_info['total_income'];?>
		<br>
	
	<br> <a href="<?php echo site_url('invoices/editInvoice/'.$incomes_info['id']);?>">EDIT</a>
	
	
	
	
	</body>
