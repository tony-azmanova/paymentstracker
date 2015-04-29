
<html>
	<head>
		
		<script>
		$(document).ready(function(){
			$("#this_month").bind('click',function(e){
				e.preventDefault();
				$.get("<?php echo site_url("invoices/getCharts"."/".$start_date_this."/".$end_date_this); ?>", function(data, status){
					$("#chart_container").html(data);
				});
			});
			$("#previous_month").bind('click',function(e){
					e.preventDefault();
					$.get("<?php echo site_url("invoices/getCharts"."/".$start_date_privios."/".$end_date_privios); ?>", function(data, status){
						$("#chart_container").html(data);
					});
			});
				
			$("#two_months_ago").bind('click',function(e){
				e.preventDefault();
				$.get("<?php echo site_url("invoices/getCharts"."/".$start_date_more_previos."/".$end_date_more_previos); ?>", function(data, status){
					$("#chart_container").html(data);
				});
			});	
		});
		
		
		</script>
		
	</head>

	<body>
		
		<?php if(isset($succses)) { ?>
					<div style="background:#00FF00;">Success!</div>
		<?php } ?> 
		
		<div class = "row">
			<div class="col-sm-2" style="background-color:lavenderblush;">Shops</div>
			<div class="col-sm-2" style="background-color:lavender;">Date</div>
			<div class="col-sm-1" style="background-color:lavenderblush;">Type</div>	
			<div class="col-sm-2" style="background-color:lavender;">Total price</div>
			<div class="col-sm-1" style="background-color:lavenderblush;">Category</div>	
			<div class="col-sm-1" style="background-color:lavender;">Made by</div>	
			<div class="col-sm-1" style="background-color:lavenderblush;">Status</div>
			<div class="col-sm-2" style="background-color:lavender;">Action</div>	
		</div>	
				
			
			<div class = "row">	
			<?php foreach($invoce_list as $list){ ?>
				<div class="col-sm-1" style="background-color:lavenderblush;">Shops</div>
				<div class="col-sm-2" style="background-color:lavenderblush;"><?php echo $list['shop_name'];?> </div>
				<div class="col-sm-2" style="background-color:lavender;">Date</div>
				<div class="col-sm-2" style="background-color:lavender;"><?php echo $list['date_invoices'];?> </div>
				<div class="col-sm-1" style="background-color:lavenderblush;">Type</div>	
				<div class="col-sm-1" style="background-color:lavenderblush;"><?php echo $list['transaction_name'];?> </div>
				<div class="col-sm-2" style="background-color:lavender;">Total price</div>
				<div class="col-sm-2" style="background-color:lavender;"><?php echo $list['total_invoice'];?> </div>
				<div class="col-sm-1" style="background-color:lavenderblush;">Category</div>
				<div class="col-sm-1" style="background-color:lavenderblush;"><?php echo $list['category_name'];?> </div>
				<div class="col-sm-1" style="background-color:lavender;">Made by</div>	
				<div class="col-sm-1" style="background-color:lavender;"><?php echo $list['username'];?> </div>
				<div class="col-sm-1" style="background-color:lavenderblush;">Status</div>
				<div class="col-sm-1" style="background-color:lavenderblush;"><?php echo $list['status_name'];?> </div>
				<div class="col-sm-2" style="background-color:lavender;">Action</div>
			
				<div class="col-sm-2" style="background-color:lavender;"><a href="<?php echo site_url('invoices/editInvoice/'.$list['id']);?>">EDIT</a>
					<a href="<?php echo site_url('invoices/deleteInvoice/'.$list['id']);?>">DELETE</a>
					<a href="<?php echo site_url('invoices/invoiceInfo/'.$list['id']);?>">INFO</a>
				</div>
			
			<?php } ?>
		</div>
		<p><?php echo $links; ?></p><br>
	<a href="<?php echo site_url('invoices/newInvoice');?>">Add new invoice!</a><br>
	<div id="chart_container">
		Total invoices :<?php echo $invoice['this_month'];?>
			
		and total incomes: <?php echo $incomes['income_total'];?>
	
	</div>
	<a href="#" id="this_month">This month</a>
	<a href="#" id="previous_month">Previous month</a>
	<a href="#" id="two_months_ago">2 months ago</a>
	
	
	</body>	
	
</html>
