
<img src="<?php echo site_url('statistics/graph/'.$incomes."/".$expenses); ?>" />
	<br>
	<br>
	Top 10 exspenses:
	<table>
		
		<tr>
			
			<td>Username</td>
			<td>Total exspenses</td>
	
		</tr>
		<tr>
			<?php foreach($top_expenses as $top_exp){ ?>
				<td> <?php echo $top_exp['username'];?> </td>
				<td> <?php echo $top_exp['total_exspenses'];?> </td>
		</tr>
		<?php } ?>

	</table>
	<br>
	<br>
	Top 10 incomes:
	<table>
		
		<tr>
			
			<td>Username</td>
			<td>Total incomes</td>
	
		</tr>
		<tr>
			<?php foreach( $top_incomes as $top_inc){ ?>
				<td> <?php echo $top_inc['username'];?> </td>
				<td> <?php echo $top_inc['top_incomes'];?> </td>
		</tr>
			<?php } ?>

	</table>
	<br>
	<br>
	Top 10 exspenses by shops:
	<table>
		
		<tr>
			
			<td>Shop name</td>
			<td>Total expenses</td>
	
		</tr>
		<tr>
			<?php foreach( $top_shops as $top_shop){ ?>
				<td> <?php echo $top_shop['shop_name'];?> </td>
				<td> <?php echo $top_shop['total_invoice'];?> </td>
		</tr>
		<?php } ?>

	</table>
	<br>
	<br>
	Top 10 exspenses by items:
	<table>
		
		<tr>
			
			<td>Item name</td>
			<td>Total expenses</td>
	
		</tr>
		<tr>
			<?php foreach( $top_items as $top_item){ ?>
				<td> <?php echo $top_item['type_name'];?> </td>
				<td> <?php echo $top_item['subtotal'];?> </td>
		</tr>
		<?php } ?>

	</table>
	<br>
	<br>
	Top 10 exspenses by category:
	<table>
		
		<tr>
			
			<td>Category name</td>
			<td>Total expenses</td>
	
		</tr>
		<tr>
			<?php foreach( $top_categories as $top_category){ ?>
				<td> <?php echo $top_category['category_name'];?> </td>
				<td> <?php echo $top_category['total_invoice'];?> </td>
		</tr>
		<?php } ?>
	</table>
	
	
	
	
