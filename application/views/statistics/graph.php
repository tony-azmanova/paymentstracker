
<img src="<?php echo site_url('statistics/graph/'.$incomes."/".$expenses); ?>" />
	<br>
	<br>
	
	<div class= "container_statistics">
		<div class = "container_top">
			<div class="row">
				<div class= "visible-md col-md-3">Top 10 exspenses:</div>
			</div>
		</div>
		
		<div class = "row" style="background:#337ab7;">
			<div class= "visible-md col-md-5">Username</div>
			<div class= "visible-md col-md-5">Total exspenses</div>
		</div>
			
		<div class = "row">
			<?php if(!empty($top_expenses)){ ?>
				
				<?php foreach($top_expenses as $top_exp){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Username:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $top_exp['username'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_exp['username'];?> </div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Total exspenses:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $top_exp['total_exspenses'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_exp['total_exspenses'];?> </div>
				<?php } ?>
			<?php }else{?>
				<?php echo "There is no data for this period!";?>
			<?php } ?>	
		</div>
	</div>

	<br>
	<div class= "container_statistics">
		<div class = "container_top">
			<div class="row">
				<div class= "visible-md col-md-3">Top 10 incomes:</div>
			</div>
		</div>
		
		<div class = "row" style="background:#337ab7;">
			<div class= "visible-md col-md-5">Username</div>
			<div class= "visible-md col-md-5">Total incomes</div>
		</div>
			
		<div class = "row">
			<?php if(!empty($top_incomes)){ ?>
				<?php foreach( $top_incomes as $top_inc){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Username:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $top_inc['username'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_inc['username'];?> </div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Total incomes:</div>
					<div class= "col-xs-7 col-sm-7 hidden-md"><?php echo $top_inc['top_incomes'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_inc['top_incomes'];?> </div>
				<?php } ?>
			<?php }else{?>
				<?php echo "There is no data for this period!";?>
			<?php } ?>		
		</div>
	</div>
	<br>
	<br>
	
	<div class= "container_statistics">
		<div class = "container_top">
			<div class="row">
				<div class= "visible-md col-md-7">Top 10 exspenses by shops:</div>
			</div>
		</div>
		
		<div class = "row" style="background:#337ab7;">
			<div class= "col-xs-5 col-sm-5 hidden-md">Shop name</div>
			<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
		</div>
		
		<div class = "row">
			<?php if(!empty($top_shops)){ ?>
				<?php foreach( $top_shops as $top_shop){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Shop name</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_shop['shop_name'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_shop['shop_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_shop['total_invoice'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_shop['total_invoice'];?> </div>
				<?php } ?>
			<?php }else{?>
				<?php echo "There is no data for this period!";?>
			<?php } ?>	
		</div>
	</div>
	<br>
	<br>
	
	<div class= "container_statistics">
		<div class = "container_top">
			<div class="row">
				<div class= "visible-md col-md-7">Top 10 exspenses by items:</div>
			</div>
		</div>
		
		<div class = "row" style="background:#337ab7;">
			<div class= "col-xs-5 col-sm-5 hidden-md">Item name</div>
			<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
		</div>
		
		<div class = "row">
			<?php if(!empty($top_items)){ ?>
				<?php foreach($top_items as $top_item){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Item name</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_item['type_name'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_item['type_name'];?> </div>
						
					<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_item['subtotal'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_item['subtotal'];?> </div>
				<?php } ?>
			<?php }else{?>
				<?php echo "There is no data for this period!";?>
			<?php } ?>	
		</div>
	</div>
	<br>
	<br>
	
	<div class= "container_statistics">
		<div class = "container_top">
			<div class="row" style="border-bottom: 2px solid #708090;">
				<div class= "visible-md col-md-7">Top 10 exspenses by category:</div>
			</div>
		</div>
		
		<div class = "row" style="background:#337ab7;">
			<div class= "col-xs-5 col-sm-5 hidden-md">Category name</div>
			<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
		</div>
		
		<div class="row">
			<?php if(!empty($top_cotegories)){ ?>
				<?php foreach( $top_categories as $top_category){ ?>
					<div class= "col-xs-5 col-sm-5 hidden-md">Category name</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_category['category_name'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_category['category_name'];?> </div>
					
					<div class= "col-xs-5 col-sm-5 hidden-md">Total expenses</div>
					<div class= "col-xs-5 col-sm-5 hidden-md"><?php echo $top_category['total_invoice'];?> </div>
					<div class= "visible-md col-md-5"><?php echo $top_category['total_invoice'];?> </div>
				<?php } ?>
			<?php }else{?>
				<?php echo "There is no data for this period!";?>
			<?php } ?>	
		</div>
	</div>
