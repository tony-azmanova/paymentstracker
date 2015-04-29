<html>

	<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>	
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	
	.loading {
	
		background-color:#000000;
		
	}	
	</style>
	
	
	<? if (isset($js_header)) { ?>
		<? foreach ($js_header as $js_file) { ?>
			<script type="text/javascript" src="<?php echo site_url(); ?>assets/js/<?php echo $js_file;?>"></script>	
		<? } ?>	
	<? } ?>
	
			
	<style type="text/css">
			
		
		.main_menu{
			margin: 20px;
		}

		.side_menu{
			
			margin: 20px;
		}
	
		.content{
			text-align: center;
		}
		
		
		.statistics_menu{
			
			margin: 20px;
		}
		
	</style>
			
		
		
	</head>
	
	<body>
	<script>
	$(document).on({
		ajaxStart: function() { $('body').addClass("loading");    },
		ajaxStop: function() { $('body').removeClass("loading"); }    
	});
	
	</script>	
		
		
		
		<h1>Payments</h1>
		<?php if(isset($succsesfully)) { ?>
			<div style="background:#00FF00;">You have been successfily registered!</div>
		<?php } ?>
		
		<?php if(!$user){?>
		<p> If you do not have a acount plese <a href="<?php echo site_url('users/registerUser');?>">register!</a></p>
		<form action = "<?php echo site_url('users/log_in');?>" method = "post">
		<label for = "text_input" style = "display: inline-block; width:100px;">Username:</label>
		<input id = "text_input" type = "text" name = "username" ><br>
		
		<label for = "pass_input" style = "display: inline-block; width:100px;">Password:</label>
		<input id = "pass_input" type = "password" name = "password" ><br>
		
		<input type = "submit" name = "login" value ="login"><br>
		</form>
		<?php } else { ?>

		<div class="main_menu">
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url('users/usersProfile/'.$user['user_id']);?>"> MY Profile</a></li>
			
				<li><a href="<?php echo site_url('invoices/index');?>">Invoices</a></li>
				<li><a href="<?php echo site_url('statistics/index');?>">Statistic</a></li>
				<li><a href="<?php echo site_url('users/index');?>">Users</a></li>
				<li><a href="<?php echo site_url('shops/index');?>">Shops</a></li>
				<li><a href="<?php echo site_url('incomes/index');?>">Incomes</a></li>
				<li><a href="<?php echo site_url('items/index');?>">Items</a></li>
				<li><a href="<?php echo site_url('clients/index');?>">Clients/company</a></li>
				<li>Welcome, <?php echo $user['username']; ?>
					<a href="<?php echo site_url('users/logOut');?>">log out</a></li>
		<?php } ?>
			</ul>
		</div>
		
		
