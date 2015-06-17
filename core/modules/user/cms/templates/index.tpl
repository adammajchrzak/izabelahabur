<div class="with-padding">
	<h2 class="thin float-left">Użytkownicy systemu</h2>
	<div class="float-right"><button onclick="document.location.href='/{$router->getUrl('cms#','cms','user','add')}'" class="button button-add-text"><span class="button-icon green-gradient"><span class="icon-star"></span></span>dodaj</button></div>
	<div class="table-header clear-both"></div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Login</th>
				<th scope="col">Imię i nazwisko</th>
				<th scope="col">Adres e-mail</th>
				<th scope="col" class="one-column align-center">Uprawnienie</th>
				<th scope="col" class="one-column align-center">Operacje</th>
			</tr>
		</thead>
		<tbody>
		{foreach item=list name=list from=$users_list}
			<tr>
				<th><a href="/{$router->getUrl('cms','user','edit',$list.user_id)}">{$list.user_login}</a></th>
				<td>{$list.user_firstname} {$list.user_lastname}</td>
				<td><a href="mailto:{$list.user_email}">{$list.user_email}</a></td>
				<td nowrap="nowrap">Uprawnienie: {$list.role_name}</td>
				<td nowrap="nowrap">
					<button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href='/{$router->getUrl('cms#','cms','user','edit',$list.user_id)}'"></button>
					<button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$list.user_id}"></button>
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
			title: 'Usuwanie użytkownika',
			content: 'Czy jesteś pewny/a, że chcesz usunąć tego uzytkownika? Operacja będzie nieodwracalna!',

			buttonsAlign: 'center',
			buttons:{
				'usuń': {
					classes: 'green-gradient glossy small icon-tick',
        			click: function(modal) {
        				$.ajax({
							type: 'POST',
							async: false,
							url: '{/literal}/{$router->getUrl('cms','user','delete')}{literal}',
							data: ( {'user_id' : item_id} ),
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
});	
</script>	
{/literal}