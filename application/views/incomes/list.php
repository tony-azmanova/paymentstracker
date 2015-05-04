	
		<?php if(isset($success)) { ?>
			<div style="background:#00FF00;">Success!</div>
		<?php } ?>

		
		<div class= "container_list">
			<div class = "row" style="background:#337ab7;">
				<div class= "visible-md col-md-1">Reason</div>
				<div class= "visible-md col-md-2">Date</div>
				<div class= "visible-md col-md-1">Category</div>
				<div class= "visible-md col-md-1">To user</div>
				<div class= "visible-md col-md-2">From company</div>
				<div class= "visible-md col-md-1">Client first name</div>
				<div class= "visible-md col-md-2">Client last name</div>
				<div class= "visible-md col-md-2">Action</div>
			</div>
			
			<div class = "row">
			<?php foreach($income_list as $income){ ?>
				<div class= "col-xs-5 col-sm-5 hidden-md">Reason:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['income_name'];?></div>
				<div class= "visible-md col-md-1"><?php echo $income['income_name'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">Date:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['date_incomes'];?></div>
				<div class= "visible-md col-md-2"><?php echo $income['date_incomes'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">Category:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['category_name'];?></div>
				<div class= "visible-md col-md-1"><?php echo $income['category_name'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">To user:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['username'];?></div>
				<div class= "visible-md col-md-1"><?php echo $income['username'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">From company:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['company'];?></div>
				<div class= "visible-md col-md-2"><?php echo $income['company'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">Client first name:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['client_first_name'];?></div>
				<div class= "visible-md col-md-1"><?php echo $income['client_first_name'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">Client last name:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $income['client_last_name'];?></div>
				<div class= "visible-md col-md-2"><?php echo $income['client_last_name'];?></div>
				
				<div class= "col-xs-5 col-sm-5 hidden-md">Action:</div>
				<div class= "col-xs-7 col-sm-7 hidden-md">
					<a href="<?php echo site_url('incomes/editIncome/'.$income['id']);?>">EDIT</a>
					<a href="<?php echo site_url('incomes/deleteIncome/'.$income['id']);?>">DELETE</a>
					<a href="<?php echo site_url('incomes/incomeInfo/'.$income['id']);?>">INFO</a>
				</div>
				<div class= "visible-md col-md-2">
					<a href="<?php echo site_url('incomes/editIncome/'.$income['id']);?>">EDIT</a>
					<a href="<?php echo site_url('incomes/deleteIncome/'.$income['id']);?>">DELETE</a>
					<a href="<?php echo site_url('incomes/incomeInfo/'.$income['id']);?>">INFO</a>
				</div>
			</div>
			<?php } ?>
		</div>
	<p><?php echo $links; ?></p><br>
	
		<br> 
			<a href="<?php echo site_url('incomes/newIncome');?> ">Add new income!</a>
		<br> 
			<a href="<?php echo site_url('clients/index');?> ">Add new client!</a>
			
