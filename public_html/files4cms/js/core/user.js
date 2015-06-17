$(function() {
	
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
	
	$('.button-add-user-save').click(function(){
		
		$('#form-add-user :input').removeClass('ui-state-error');
		
		if($('#user_passwd').val() == '')	{
			alert('Podaj hasło użytkownika!');
			$('#user_login').addClass('ui-state-error');
			return false;
		}
		
		if($('#user_firstname').val() == '')	{
			alert('Podaj imię użytkownika!');
			$('#user_firstname').addClass('ui-state-error');
			return false;
		}
		
		if($('#user_lastname').val() == '')	{
			alert('Podaj nazwisko użytkownika!');
			$('#user_lastname').addClass('ui-state-error');
			return false;
		}
		
		if(
			($('#user_email').val() == '') ||
			($('#user_email').val().trim().search(/^([a-z]+)([a-z0-9\-\_\.]{1,100})([a-z0-9]+)\@([a-z0-9]+)([a-z0-9\-\.]*)([a-z0-9]+)\.([a-z]{2,6})$/) == -1) 
		)	{
			alert('Podaj prawidłowy adres e-mail użytkownika!');
			$('#user_email').addClass('ui-state-error');
			return false;
		}
		
		return true;
	});
	
	$('.button-edit-user-save').click(function(){
		
		$('#form-edit-user :input').removeClass('ui-state-error');
		$('#dialog-message').html('');
		
		if($('#user_login').val() == '')	{
			$('#dialog-message').html('<p>Podaj login użytkownika!</p>');
			$( "#dialog-message" ).dialog('open');
			$('#user_login').addClass('ui-state-error');
			return false;
		}
		
		if($('#user_firstname').val() == '')	{
			$('#dialog-message').html('<p>Podaj imię użytkownika!</p>');
			$( "#dialog-message" ).dialog('open');
			$('#user_firstname').addClass('ui-state-error');
			return false;
		}
		
		if($('#user_lastname').val() == '')	{
			$('#dialog-message').html('<p>Podaj nazwisko użytkownika!</p>');
			$( "#dialog-message" ).dialog('open');
			$('#user_lastname').addClass('ui-state-error');
			return false;
		}
		
		if(
			($('#user_email').val() == '') ||
			($('#user_email').val().trim().search(/^([a-z]+)([a-z0-9\-\_\.]{1,100})([a-z0-9]+)\@([a-z0-9]+)([a-z0-9\-\.]*)([a-z0-9]+)\.([a-z]{2,6})$/) == -1) 
		)	{
			$('#dialog-message').html('<p>Podaj prawidłowy adres e-mail użytkownika!</p>');
			$( "#dialog-message" ).dialog('open');
			$('#user_email').addClass('ui-state-error');
			return false;
		}
		
		return true;
	});
});