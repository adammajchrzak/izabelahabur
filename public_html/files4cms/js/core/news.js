$(function() {
	
	$(".tree-edit-set").buttonset();
	$("#news-edit-tabs").tabs();
	
	$(".news-edit").button({
		text: false,
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$(".news-delete").button({
		text: false,
		icons: {
			primary: "ui-icon-close"
		}
	});
	
	
	$('.button-add-news-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj tytuł tworzonej aktualności!');
			return false;
		}
		return true;
	});
	
	$('.button-edit-news-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj tytuł tworzonej aktualności!');
			return false;
		}
		return true;
	});
	
	$(".news-delete").click(function(){
		
		if(confirm('Czy jesteś pewny/a, że chcesz usunąć tę aktualność? Operacja będzie nieodwracalna!') === true)	{
				
			$.ajax({
				method: 'POST',
				url: 'cms,news,delete.html',
				data: ( {'news_id' : $(this).val()} ),
				success: function(data) {
			    	document.location.href = 'cms,news.html';
				}
			});
		}
		return false;
	});
	
	$( "#news_publish" ).datepicker($.datepicker.regional[ "pl" ]);
});