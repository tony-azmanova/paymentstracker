
	<body>
		
	<table>
			
		<tr>
			<td>Company Name</td>
			<td>Client first name</td>
			<td>Client last name</td>
			<td>Client phone</td>
			<td>Client email</td>
			<td>Action</td>
		
		</tr>
		<tr> 
		<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>
			
		<?php foreach($clients as $client){ ?>
			<td> <?php echo $client['company_name'];?> </td>
			<td> <?php echo $client['first_name'];?></td>
			<td> <?php echo $client['last_name'];?></td>
			<td> <?php echo $client['phone'];?></td>
			<td> <?php echo $client['email'];?></td>
			<td> <a href="<?php echo site_url('clients/editClients/'.$client['id']);?>">EDIT</a>
			<a href="<?php echo site_url('clients/deleteClient/'.$client['id']);?>">DELETE</a>
			<a href="<?php echo site_url('clients/clientInfo/'.$client['id']);?>">INFO</a></td>
		</tr>
		<?php } ?>
	</table>
	<p><?php echo $links; ?></p><br>
	
	<br> <a href="<?php echo site_url('clients/newClients');?> ">Add new client!</a>
	
	
	</body>
