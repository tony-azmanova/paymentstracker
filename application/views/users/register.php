<html>	
	<head>
	
	
	
	</head>
	<body>
		<h2>Registration!</h2>

			<form action = "<?php echo site_url('users/registerUser');?>" method = "post">
			
				<label for = "text_input" style = "display: inline-block; width:200px;">Username:</label>
				<input type="text" name="username" value="<?php echo set_value('username'); ?>"/>
				<?php echo form_error('username'); ?>
				<br>
				
				<label for = "pass_input" style = "display: inline-block; width:200px;">Password:</label>
				<input type="password" name="password" value="<?php echo set_value('password'); ?>"/>
				<?php echo form_error('password'); ?>
				<br>
				
				<label for="re_pass_input" style ="display: inline-block; width:200px;">Repeat Password:</label>
				<input type="password" name="re_pass_input" value="<?php echo set_value('re_pass_input'); ?>"/>
				<?php echo form_error('re_pass_input'); ?>
				<br>
				
				<label for="email" style ="display: inline-block; width:200px;">Email:</label>
				<input type="text" name="email" value="<?php echo set_value('email'); ?>"/>
				<?php echo form_error('email'); ?>
				<br>
				
				<label for="first_name" style ="display: inline-block; width:200px;">First name:</label>
				<input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" />
				<?php echo form_error('first_name'); ?>
				<br>
				
				<label for="last_name" style ="display: inline-block; width:200px;">Last name:</label>
				<input type="text" name="last_name" value="<?php echo set_value('last_name'); ?>" />
				<?php echo form_error('last_name'); ?>
				<br>
				
				<input type="submit" value="register" >

			</form>
			
		</body>
</html>
