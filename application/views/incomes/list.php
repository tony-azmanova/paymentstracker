	<body>
	
	<table>
			
			<tr>
				<td>Reason</td>
				<td>Date</td>
				<td>Category</td>
				<td>To user</td>
				<td>From company</td>
				<td>Client first name</td>
				<td>Client last name</td>
				<td>Action</td>
			
			</tr>
			<tr>
			<?php if(isset($success)) { ?>
				<div style="background:#00FF00;">Success!</div>
			<?php } ?>  
				
			<?php foreach($income_list as $income){ ?>
				<td> <?php echo $income['income_name'];?> </td>
				<td> <?php echo $income['date_incomes'];?> </td>
				<td> <?php echo $income['category_name'];?> </td>
				<td> <?php echo $income['username'];?></td>
				<td> <?php echo $income['company'];?></td>
				<td> <?php echo $income['client_first_name'];?></td>
				<td> <?php echo $income['client_last_name'];?></td>
				<td> <a href="<?php echo site_url('incomes/editIncome/'.$income['id']);?>">EDIT</a>
				<a href="<?php echo site_url('incomes/deleteIncome/'.$income['id']);?>">DELETE</a>
				<a href="<?php echo site_url('incomes/incomeInfo/'.$income['id']);?>">INFO</a></td>
			</tr>
			<?php } ?>
		</table>
		<p><?php echo $links; ?></p><br>
		
	<br> <a href="<?php echo site_url('incomes/newIncome');?> ">Add new income!</a>
	
	<br> <a href="<?php echo site_url('clients/index');?> ">Add new client!</a>
	
	</body>
	
</html>
