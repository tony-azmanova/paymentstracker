<body>
		<h2>Company/client # number <?php echo $client_info['id'];?></h2>
	
	
	Company name:
	<?php echo $client_info['company_name'];?>
		<br>
	Client first name:
	<?php echo $client_info['first_name'];?>
		<br>
	 Client last name :
	<?php echo $client_info['last_name'];?>
		<br>
	Email company/client:
	<?php echo $client_info['email'];?>
		<br>
	Phone company/client:
	<?php echo $client_info['phone'];?>
		<br>
	
	
	
	<br> <a href="<?php echo site_url('clients/editClients/'.$client_info['id']);?>">EDIT</a>
	
	
	
	
	</body>
