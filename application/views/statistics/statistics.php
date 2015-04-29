
	<script>
		$(document).ready(function(){
			
			$.get("<?php echo site_url("statistics/stats"."/".$start_date_this."/".$end_date_this); ?>", function(data, status){
					$("#chart_container").html(data);
				});
			
			$("#this_month").bind('click',function(e){
				e.preventDefault();
				$.get("<?php echo site_url("statistics/stats"."/".$start_date_this."/".$end_date_this); ?>", function(data, status){
					$("#chart_container").html(data);
				});
			});
			$("#previous_month").bind('click',function(e){
					e.preventDefault();
					$.get("<?php echo site_url("statistics/stats"."/".$start_date_privios."/".$end_date_privios); ?>", function(data, status){
						$("#chart_container").html(data);
					});
			});
				
			$("#two_months_ago").bind('click',function(e){
				e.preventDefault();
				$.get("<?php echo site_url("statistics/stats"."/".$start_date_more_previos."/".$end_date_more_previos); ?>", function(data, status){
					$("#chart_container").html(data);
				});
			});	
			
			$("#show_stats").bind('click',function(e){
				e.preventDefault();
				var start=$("#start_date").val();
				var end=$("#end_date").val();
				
				$.get("<?php echo site_url('statistics/stats'); ?>" +'/' + start + '/'+ end , function(data, status){
					$("#chart_container").html(data);
				});
			});	
			
			$(function() {
				$( ".datepicker" ).datepicker({
					dateFormat:"yy-mm-dd"
				});
			});
		});
		
		</script>
		
	<body>
		<label for="start_date" style="display:inline-block;width:100px;">Start date</label>
		<input type="text" id="start_date" name="start_date" class="datepicker" value ="<?php echo $start_date_this; ?>">
		
		<label for="end_date" style="display:inline-block;width:100px;">End date</label>
		<input type="text" id="end_date" name="end_date" class="datepicker" value="<?php echo $end_date_this; ?>">
		
		<a href="#" id="show_stats">Show statistics</a>
			
		<div id="chart_container">
			
		</div>
			
		<a href="#" id="this_month">This month</a>
		<a href="#" id="previous_month">Previous month</a>
		<a href="#" id="two_months_ago">2 months ago</a>
	
	</body>
