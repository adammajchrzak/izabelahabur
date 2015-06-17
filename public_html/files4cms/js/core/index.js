$(function() {
	
	$('.button-add-page-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj nazwę tworzonej strony!');
			return false;
		}
		return true;
	});
	
	$('.button-edit-page-save').click(function(){
		if($('#content_title').val() == '')	{
			alert('Podaj nazwę tworzonej strony!');
			return false;
		}
		return true;
	});
	
	$( ".sortable" ).sortable({
		placeholder: "ui-state-highlight",
		update : function () {
			var order = $('.sortable').sortable('serialize');
			$.ajax({
				url: "/cms,index,sort.html",
				data: order,
				async: false,
				success: function(data) {
			    	$('#showmsg').html(data);
				}
			});
		}
	});

	$('.sortable').disableSelection();
	
	$('.accordion').accordion({
						active: false, 
						collapsible: true, 
						autoHeight: false,
						header: "> div > h3"
					})
					.sortable({
							axis: "y",
							handle: "h3",
							placeholder: "ui-state-highlight",
							update : function () {
								var order = $('.accordion').sortable('serialize');
								$.ajax({
									url: "/cms,index,sort.html",
									data: order,
									async: false,
									success: function(data) {
								    	$('#showmsg').html(data);
									}
								});
							},
							stop: function( event, ui ) {
								// IE doesn't register the blur when sorting
								// so trigger focusout handlers to remove .ui-state-focus
								ui.item.children( "h3" ).triggerHandler( "focusout" );
								$('.accordion').accordion({active: false})
							}
					});
			
	$('.add-node').click(function(){
		var listItem = $('.accordion > div').size() + 1;
		$('.accordion')
			.append($('<div></div>')
				.attr('id', 'item_' + listItem)
				.append('<h3><a href="javascript:;">Treść: ' + listItem + '</a></h3>')
				.append(
					$('<div></div>')
						.append(
							$('<input/>')
								.attr('id', 'module_id_' + listItem)
								.attr('name', 'module_id_' + listItem)
								.attr('type', 'text')
								.attr('value','1')
							)
						.append(
							$('<input/>')
								.attr('id', 'object_id_' + listItem)
								.attr('name', 'object_id_' + listItem)
								.attr('type', 'text')
							)
						.append(
							$('<input/>')
								.attr('id', 'content_title_' + listItem)
								.attr('name', 'content_title_' + listItem)
								.attr('type', 'text')
							)
						.append(
							$('<textarea></textarea>')
								.attr('id', 'content_text_' + listItem)
								.attr('name', 'content_text_' + listItem)
								.attr('class', 'ckeditor')
							)
				)
				.append(
					$('<input/>')
						.attr('id', 'list_id[]')
						.attr('name', 'list_id[]')
						.attr('type', 'hidden')
						.val(listItem)
				)
		 	)
		 	.accordion("destroy")
		 	.accordion("resize")
		 	.accordion({
		 	 	active: false, 
				collapsible: true, 
				autoHeight: false,
				header: "> div > h3"
		 	 });
		 	 
		 $('.ckeditor').ckeditor({
		 	path: '/scripts/cms/ckeditor/',
		 	height: 350,
		 	width: '100%'
		 });
	});
	
	
});