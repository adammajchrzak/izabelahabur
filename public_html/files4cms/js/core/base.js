$(function() {
	
	$("button").button();
	$("#page-top-menu li a").button({
		text: true,
		icons: {
			primary: "ui-icon-power"
		}
	});
	
	$("#page-menu li").button();
	
	$("input:checkbox, input:radio, select").uniform();
	//$("input:file, input:checkbox, input:radio, select").uniform();
	
	$(".move-set").buttonset();
	$(".edit-set").buttonset();
	
	$("#page-edit-tabs").tabs();
	$("#user-edit-tabs").tabs();
	
	$(".button-preview").button({
		text: false,
		icons: {
			primary: "ui-icon-link"
		}
	});
	
	$(".button-child-add").button({
		text: false,
		icons: {
			primary: "ui-icon-plus"
		}
	});
	
	$(".button-edit").button({
		text: false,
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$(".button-delete").button({
		text: false,
		icons: {
			primary: "ui-icon-close"
		}
	});
	
	$(".button-move-down").button({
		text: false,
		icons: {
			primary: "ui-icon-arrowthick-1-s"
		}
	});
	
	$(".button-move-up").button({
		text: false,
		icons: {
			primary: "ui-icon-arrowthick-1-n"
		}
	});
	
	$(".button-move-up").click(function(){
		
		$.ajax({
			type: 'POST',
			url: 'cms,index,move.html',
			data: ( {'page_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
			success: function(data) {
		    	document.location.href = 'cms,index.html';
			}
		});
		
		return false;
	});
	
	$(".button-move-down").click(function(){
		
		$.ajax({
			type: 'POST',
			url: 'cms,index,move.html',
			data: ( {'page_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
			success: function(data) {
		    	document.location.href = 'cms,index.html';
			}
		});
		
		return false;
	});
	
	$(".button-delete").click(function(){
		
		if(confirm('Czy jesteś pewny/a, że chcesz usunąć tę stronę? Operacja będzie nieodwracalna!') === true)	{
				
			$.ajax({
				method: 'POST',
				url: 'cms,index,delete.html',
				data: ( {'page_id' : $(this).val()} ),
				success: function(data) {
			    	document.location.href = 'cms,index.html';
				}
			});
		}
		return false;
	});
	
	$('#page_name').blur(function(){
		
		var value = $(this).val();
		var code = '';
		var source	= ['Ż', 'Ź', 'Ć', 'Ń', 'Ą', 'Ś', 'Ł', 'Ę', 'Ó', 'ż', 'ź', 'ć', 'ń', 'ą', 'ś', 'ł', 'ę', 'ó'];
		var dest	= ['z', 'z', 'c', 'n', 'a', 's', 'l', 'e', 'o', 'z', 'z', 'c', 'n', 'a', 's', 'l', 'e', 'o'];
		var l = source.length;
		for (var i = 0; i < l; i++) {
			value = value.replace(source[i], dest[i]);
		}
		var pattern = new RegExp(/[a-zA-Z0-9\-\_]/);
		var pl;
		for (var i = 0; i < value.length; i++) {
			if (value.charAt(i) == ' ') {
				code += '-';
			}
			if (pattern.test(value.charAt(i))) {
				code += value.charAt(i);
			}
		}
		$("#content_code").val(code.toLowerCase());
		return true;
	});

});