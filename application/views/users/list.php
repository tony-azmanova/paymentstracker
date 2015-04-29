

	<head>
		
		<style>
			table, td, th {
				border: 1px solid green;
			}

			th {
				background-color: green;
				color: white;
			}
	
		</style>
		
	</head>
	
	
	<body>
		
		<table>
			
			<tr>
				<td>Username</td>
				<td>First name</td>
				<td>Last name</td>
				<td>Total incomes</td>
				<td>Total expenses</td>
				<td>Email</td>
				<td>Status</td>
				<td>Action</td>
			
			</tr>
			<tr>
				<?php if(isset($succses)) { ?>
					<div style="background:#00FF00;">Success!</div>
				<?php } ?> 
				<?php foreach($all_users as $user){ ?>
					<td> <?php echo $user['username'];?> </td>
					<td> <?php echo $user['first_name'];?> </td>
					<td> <?php echo $user['last_name'];?> </td>
					<td> <?php echo $user['total_income'];?> </td>
					<td> <?php echo $user['total_exspenses'];?> </td>
					<td> <?php echo $user['email'];?> </td>
					<td> <?php echo $user['status'];?> </td>
					<td> 
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">EDIT</a>
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">Change status</a>
						<a href="<?php echo site_url('users/usersProfile/'.$user['user_id']);?>">Profile</a>
					</td>
			</tr>
			<?php } ?>
		</table>
		
		<p><?php echo $links; ?></p><br>
	</body>
