
		<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>
			
		<div class= "container_list">
			<div class = "row" style="background:#337ab7;">
				<div class= "visible-md col-md-2">Company Name</div>
				<div class= "visible-md col-md-2">Client first name</div>
				<div class= "visible-md col-md-2">Client last name</div>
				<div class= "visible-md col-md-2">Client phone</div>
				<div class= "visible-md col-md-2">Client email</div>
				<div class= "visible-md col-md-2">Action</div>
			</div>
		
		 
		
			<div class = "row">	
				<?php foreach($clients as $client){ ?>
				
					<div class= "col-xs-5 col-sm-5 hidden-md">Company Name:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $client['company_name'];?></div>
					<div class= "visible-md col-md-2"><?php echo $client['company_name'];?></div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Client first name:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $client['first_name'];?></div>
					<div class= "visible-md col-md-2"><?php echo $client['first_name'];?></div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Client last name:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $client['last_name'];?></div>
					<div class= "visible-md col-md-2"><?php echo $client['last_name'];?></div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Client phone:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $client['phone'];?></div>
					<div class= "visible-md col-md-2"><?php echo $client['phone'];?></div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Client email:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $client['email'];?></div> 
					<div class= "visible-md col-md-2"><?php echo $client['email'];?></div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Action:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md">
						<a href="<?php echo site_url('clients/editClients/'.$client['id']);?>">EDIT</a>
						<a href="<?php echo site_url('clients/deleteClient/'.$client['id']);?>">DELETE</a>
						<a href="<?php echo site_url('clients/clientInfo/'.$client['id']);?>">INFO</a>
					</div>	 
					<div class= "visible-md col-md-2">
						<a href="<?php echo site_url('clients/editClients/'.$client['id']);?>">EDIT</a>
						<a href="<?php echo site_url('clients/deleteClient/'.$client['id']);?>">DELETE</a>
						<a href="<?php echo site_url('clients/clientInfo/'.$client['id']);?>">INFO</a>
					</div>
				<?php } ?>
			</div>
		</div>
	<br>
	<p><?php echo $links; ?></p><br>
	
	<br> <a href="<?php echo site_url('clients/newClients');?> ">Add new client!</a>
	
