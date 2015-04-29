
<h2>Editing user profile # <?php echo $user_id;?></h2>

	<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>
		<?php echo validation_errors(); ?>
	<form action = "<?php echo site_url('users/changeProfile/'.$user_id);?>" method = "post">
	
		<label for = "text_input" style = "display: inline-block; width:200px;">Username:</label>
		<input type="text" name="username" value="<?php echo set_value('username',$users_info['username']); ?>"/>
		
		<br>
		
		<label for = "text_input" style = "display: inline-block; width:200px;">First name:</label>
		<input type="text" name="first_name" value="<?php echo set_value('first_name',$users_info['first_name']); ?>"/>
		
		<br>
		
		<label for = "text_input" style = "display: inline-block; width:200px;">Last name:</label>
		<input type="text" name="last_name" value="<?php echo set_value('last_name',$users_info['last_name']); ?>"/>
		
		<br>
		
		<label for = "text_input" style = "display: inline-block; width:200px;">Email:</label>
		<input type="text" name="email" value="<?php echo set_value('email',$users_info['email']); ?>"/>
		
		
		<br>

		<label for="status" style= "display: inline-block; width:100px;">Status:</label>
		<?php $d_stat = array(''=>"Select");
			foreach($status as $stat){
				$d_stat[$stat['status_id']] = $stat['status_name'];	
			}	
			echo form_dropdown('status', $d_stat, set_value('status',$users_info['status_id']));
			?>
		<?php echo form_error('status'); ?><br>
		<label for="level" style= "display: inline-block; width:100px;">Level:</label>
		<?php $d_level = array(''=>"Select");
			foreach($levels as $level){
				$d_level[$level['level_id']] = $level['level_name'];	
			}	
			echo form_dropdown('level', $d_level, set_value('level',$users_info['level_id']));
			?>
		<br>
		
		
					
		<input type="submit" value="save" >

	</form>		
