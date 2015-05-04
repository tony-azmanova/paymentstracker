		<?php if(isset($succses)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?> 

		<div class= "container_list">
			<div class = "row" style="background:#337ab7;">
				<div class= "visible-md col-md-2">Username</div>
				<div class= "visible-md col-md-1">First name</div>
				<div class= "visible-md col-md-2">Last name</div>
				<div class= "visible-md col-md-1">Total incomes</div>
				<div class= "visible-md col-md-1">Total expenses</div>
				<div class= "visible-md col-md-2">Email</div>
				<div class= "visible-md col-md-1">Status</div>
				<div class= "visible-md col-md-2">Action</div>
			
			</div>
			<div class = "row">
				
				<?php foreach($all_users as $user){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Username:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['username'];?> </div>
					<div class= "visible-md col-md-2"><?php echo $user['username'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">First name:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['first_name'];?> </div>
					<div class= "visible-md col-md-1"><?php echo $user['first_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Last name:</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $user['last_name'];?> </div>
					<div class= "visible-md col-md-2"><?php echo $user['last_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Total incomes:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['total_income'];?> </div>
					<div class= "visible-md col-md-1"><?php echo $user['total_income'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['total_exspenses'];?></div>
					<div class= "visible-md col-md-1"><?php echo $user['total_exspenses'];?></div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Email:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['email'];?> </div>
					<div class= "visible-md col-md-2"><?php echo $user['email'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Status:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $user['status'];?> </div>
					<div class= "visible-md col-md-1"><?php echo $user['status'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Action:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md">
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">EDIT</a>
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">Change status</a>
						<a href="<?php echo site_url('users/usersProfile/'.$user['user_id']);?>">Profile</a>
					</div>
					<div class= "visible-md col-md-2">
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">EDIT</a>
						<a href="<?php echo site_url('users/changeProfile/'.$user['user_id']);?>">Change status</a>
						<a href="<?php echo site_url('users/usersProfile/'.$user['user_id']);?>">Profile</a>
					</div>
			<?php } ?>
			</div>
		</div>
		<br>
		<p><?php echo $links; ?></p><br>
	</body>
