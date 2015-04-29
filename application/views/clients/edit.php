<body>

		<h2>Edit client/company # <?php echo $client_info['id'];?>!</h2>
		<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>

		<form action = "<?php echo site_url('clients/editClients'."/".$client_id);?>" method = "post">
			<label for = "company_name" style = "display: inline-block; width:200px;">Company name:</label>
			<input id = "text_input" type = "text" name = "company_name" value="<?php echo set_value('company_name',$client_info['company_name']); ?>">
			<?php echo form_error('company_name');?>
			<br>
		
			<label for = "client_first_name" style = "display: inline-block; width:200px;">Client first name:</label>
			<input id = "text_input" type = "text" name = "client_first_name" value="<?php echo set_value('client_first_name',$client_info['first_name']); ?>">
			<?php echo form_error('client_first_name');?>
			<br>

			<label for = "client_last_name" style = "display: inline-block; width:200px;">Client last name:</label>
			<input id = "text_input" type = "text" name = "client_last_name" value="<?php echo set_value('client_last_name',$client_info['last_name']); ?>">
			<?php echo form_error('client_last_name');?>
			<br>
			
			<label for = "client_phone" style = "display: inline-block; width:200px;">Client phone:</label>
			<input id = "text_input" type = "text" name = "client_phone" value="<?php echo set_value('client_phone',$client_info['phone']); ?>">
			<?php echo form_error('client_phone');?>
			<br>
			
			<label for = "client_email" style = "display: inline-block; width:200px;">Client email:</label>
			<input id = "text_input" type = "text" name = "client_email" value="<?php echo set_value('client_email',$client_info['email']); ?>">
			<?php echo form_error('client_email');?>
			<br>
			
			<input type = "submit" name = "save" value ="save"><br>
			
		</form>	
		
		
	</body>

