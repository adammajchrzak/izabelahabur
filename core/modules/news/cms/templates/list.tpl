<div class="with-padding">
	<h2 class="thin float-left">Lista wpisów</h2>
	<div class="float-right"><button onclick="document.location.href='/cms#/{$router->getUrl('cms','news','add')}'" class="button button-add-text"><span class="button-icon green-gradient"><span class="icon-star"></span></span>dodaj</button></div>
	<div class="table-header clear-both"></div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Tytuł aktualności</th>
				<th scope="col" class="one-column align-center">Kategoria</th>
				<th scope="col" class="one-column">Publikacja</th>
				<th scope="col" class="one-column">Aktywność</th>
				<th scope="col" class="one-column align-center">Operacje</th>
			</tr>
		</thead>
		<tbody>

		{foreach item=tree name=tree from=$news_list}
			<tr>
				<th><a href="/{$router->getUrl('cms','news','edit',$tree.news_id)}" title="{$tree._title}">{$tree._title|truncate:45}</a></th>
				<td class="align-center" nowrap="nowrap">{$tree._category}</td>
				<td class="align-center">{$tree._publish}</td>
				<td class="align-center"><button class="button compact {if $tree._active =='1'}icon-tick green-gradient{else}icon-cross red-gradient{/if} button-active" value="{$tree.news_id}"></button></td>
				<td nowrap="nowrap">
					<button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href='/cms#/{$router->getUrl('cms','news','edit',$tree.news_id)}'"></button>
					<button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$tree.news_id}"></button>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
	<div class="table-footer"></div>
</div>

{literal}
<script>
$(function() {
	$(".button-delete").click(function(){
		var item_id = $(this).val();
		$.modal({
			title: 'Usuwanie zawartości',
			content: 'Czy jesteś pewny/a, że chcesz usunąć ten wpis? Operacja będzie nieodwracalna!',

			buttonsAlign: 'center',
			buttons:{
				'usuń': {
					classes: 'green-gradient glossy small icon-tick',
        			click: function(modal) {
        				$.ajax({
							type: 'POST',
							async: false,
							url: '{/literal}/{$router->getUrl('cms','news','delete')}{literal}',
							data: ( {'news_id' : item_id} ),
							success: function(data) {
						    	modal.closeModal();
        						window.location.reload(); 
							}
						}); 
        			}
				},
				'anuluj': {
					classes: 'red-gradient glossy small icon-cross',
        			click: function(modal) { modal.closeModal(); }
				}
			}
		});
	});
	
	$(".button-active").click(function(){
		$.ajax({
			type: 'POST',
			async: false,
			url: '{/literal}/{$router->getUrl('cms','news','active')}{literal}',
			data: ( {'news_id' : $(this).val()} ),
			success: function(data) {
				window.location.reload(); 
			}
		});
	});
});	
</script>	
{/literal}