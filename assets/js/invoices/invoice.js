$(document).ready(function(){
	var counter = 0;
	$('#addMore').bind('click', function(e){
		e.preventDefault();
		var new_fields = $('#item_container').clone();
		$(new_fields).show().removeAttr("id").appendTo("#all_items");
	
	});
	$("#all_items").on('click','div a.remove',function(e){
		e.preventDefault();
		$(this).parent('div').remove();
	});
	
});
