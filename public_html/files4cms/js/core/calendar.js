$(function() {
	
	$(".tree-edit-set").buttonset();
	$("#calendar-edit-tabs").tabs();
	
	$(".calendar-edit").button({
		text: false,
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$(".calendar-delete").button({
		text: false,
		icons: {
			primary: "ui-icon-close"
		}
	});
	
	
	$('.button-add-event-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj tytuł tworzonego wydarzenia!');
			return false;
		}
		return true;
	});
	
	$('.button-edit-event-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj tytuł tworzonego wydarzenia!');
			return false;
		}
		return true;
	});
	
	$(".calendar-delete").click(function(){
		
		if(confirm('Czy jesteś pewny/a, że chcesz usunąć to wydarzenie? Operacja będzie nieodwracalna!') === true)	{
				
			$.ajax({
				method: 'POST',
				url: 'cms,calendar,delete.html',
				data: ( {'event_id' : $(this).val()} ),
				success: function(data) {
			    	document.location.href = 'cms,calendar.html';
				}
			});
		}
		return false;
	});
	
	$( "#event_start" ).datepicker($.datepicker.regional[ "pl" ]);
	$( "#event_end" ).datepicker($.datepicker.regional[ "pl" ]);
});