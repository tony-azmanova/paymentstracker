
	<body>
	
	<h2>Add new income</h2>
	
	<?php if(isset($success)) { ?>
		<div style="background:#00FF00;">Success!</div>
	<?php } ?>
		<form action = "<?php echo site_url('incomes/newIncome');?>" method = "post">
			<label for="income_date" style="display: inline-block; width:200px;">Income Date:</label>
			<input type="date" name="income_date" value="<?php echo set_value('income_date',$set_date); ?>" >
			<?php echo form_error('income_date');?>
			<br>
			
			<label for = "income_name" style = "display: inline-block; width:200px;">Income name:</label>
			<input id = "text_input" type = "text" name = "income_name" value="<?php echo set_value('income_name'); ?>" >
			<?php echo form_error('income_name');?>
			<br>
			
			<label for="income_category" style= "display: inline-block; width:200px;">Income category  :</label>
			<?php 
			$d_category= array(''=>"Select");
				foreach($categories as $category) {
					$d_category[$category['id']] = $category['category_name'];
				}
				echo form_dropdown('income_category', $d_category, set_value('income_category'));
				echo form_error('income_category');
			?>	<br>
			<label for = "income_user" style = "display: inline-block; width:200px;">For user:</label>
			<?php 
				$d_users = array(''=>"Select");
				foreach($all_users as $user){
					$d_users[$user['users_id']]= $user['username'];
				}
				echo form_dropdown('income_user',$d_users,set_value('income_user',$set_user));
				echo form_error('income_user');
				
			?>	<br>
			
			From:<br>
			
			
			<label for="company" style= "display: inline-block; width:200px;">Company/client  :</label>
			<?php 
			$d_clients= array(''=>"Select");
				foreach($clients as $client) {
					$d_clients[$client['id']] = $client['client'];
					
				}
				echo form_dropdown('clients', $d_clients, set_value('clients'));
				echo form_error('clients');
			?>	<br>
			
			<label for = "total_income" style = "display: inline-block; width:200px;">Total income:</label>
			<input id = "text_input" type = "text" name = "total_income" value="<?php echo set_value('total_income'); ?>">
			<?php echo form_error('total_income');?>
			<br>
			
				
			<input type = "submit" name = "save" value ="save"><br>
			
		</form>	
			
	</body>
