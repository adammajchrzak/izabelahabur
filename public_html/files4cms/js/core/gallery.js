$(function() {
	
	$(".gallery-edit").button({
		text: false,
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$(".gallery-delete").button({
		text: false,
		icons: {
			primary: "ui-icon-close"
		}
	});
	
	
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-message" ).dialog({
		modal: true,
		autoOpen: false,
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$('.button-add-gallery-save').click(function(){
		
		$('#form-add-gallery :input').removeClass('ui-state-error');
		$('#dialog-message').html('');
		
		if($('#gallery_name').val() == '')	{
			$('#dialog-message').html('<p>Podaj nazwę galerii!</p>');
			$( "#dialog-message" ).dialog('open');
			$('#gallery_name').addClass('ui-state-error');
			return false;
		}
		
		return true;
	});
	
	$(".gallery-delete").click(function(){
		
		if(confirm('Czy jesteś pewny/a, że chcesz usunąć tę aktualność? Operacja będzie nieodwracalna!') === true)	{
				
			$.ajax({
				method: 'POST',
				url: 'cms,gallery,delete.html',
				data: ( {'gallery_id' : $(this).val()} ),
				success: function(data) {
			    	document.location.href = 'cms,gallery.html';
				}
			});
		}
		return false;
	});
});