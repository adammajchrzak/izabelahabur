<div class="with-padding">
	<h2 class="thin float-left">{$locale.cms.forms.list.header}</h2>
	<div class="table-header clear-both"></div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">{$locale.cms.forms.list.th.email}</th>
				<th scope="col" class="one-column align-center">{$locale.cms.forms.list.th.name}</th>
				<th scope="col" class="one-column">{$locale.cms.forms.list.th.phone}</th>
				<th scope="col" class="two-column">{$locale.cms.forms.list.th.message}</th>
				<th scope="col" class="one-column align-center">{$locale.cms.forms.list.th.created}</th>
				<th scope="col" class="one-column align-center">{$locale.cms.forms.list.th.operation}</th>
			</tr>
		</thead>
		<tbody>

		{foreach $forms as $item}
			<tr>
				<th><a href="mailto:{$item._email}" title="{$item._email}">{$item._email}</a></th>
				<td class="align-center" nowrap="nowrap">{$item._name}</td>
				<td class="align-center">{$item._phone}</td>
				<td>{$item._message}</td>
				<td class="align-center" nowrap="nowrap">{$item._created}</td>
				<td class="align-center" nowrap="nowrap"><button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$item.item_id}"></button></td>
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
			title: '{/literal}{$locale.cms.forms.modal.delete.title}{literal}',
			content: '{/literal}{$locale.cms.forms.modal.delete.content}{literal}',

			buttonsAlign: 'center',
			buttons:{
				'usuń': {
					classes: 'green-gradient glossy small icon-tick',
        			click: function(modal) {
        				$.ajax({
							type: 'POST',
							async: false,
							url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'delete')}{literal}',
							data: ( {'item_id' : item_id} ),
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