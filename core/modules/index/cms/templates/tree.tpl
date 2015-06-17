<div class="with-padding">
	<h2 class="thin float-left">Struktura serwisu</h2>
	<div class="table-header clear-both"></div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nazwa strony</th>
				<th scope="col" class="one-column">Kolejność</th>
				<th scope="col" class="one-column align-center">Operacje</th>
			</tr>
		</thead>
		<tbody>
		{foreach item=tree name=tree from=$structure_tree}
			<tr>
				<th>
					{section name=petla start=0 loop=$tree.page_level step=1}
						&nbsp;&nbsp;
					{/section}
					<a href="/{$router->getUrl('cms','index','edit',$tree.page_id)}" class="with-tooltip" title="page ID: {$tree.page_id}">{$tree.page_name|truncate}</a>
				</th>
				<td nowrap="nowrap">
					<button class="button compact green-gradient button-move-down" title="DOWN" value="{$tree.page_id}"><span class="icon-down-fat"></span></button>
					<button class="button compact green-gradient button-move-up" title="UP" value="{$tree.page_id}"><span class="icon-up-fat"></span></button>
				</td>
				<td nowrap="nowrap">
					<!-- <button class="button compact icon-link blue-gradient button-preview" onclick="this.target='_blank'; document.location.href='{$router->getUrl('index',$tree.content_code,$tree.page_id)}'"></button> -->
					<button class="button compact icon-list-add blue-gradient button-child-add" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','add',$tree.page_id)}'"></button>
					<button class="button compact {if $tree._active =='1'}icon-tick green-gradient{else}icon-cross red-gradient{/if} button-active" value="{$tree.page_id}"></button>
					<button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','edit',$tree.page_id)}'"></button>
					<button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$tree.page_id}"></button>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
	<div class="table-footer"></div>
</div>

{literal}
<script type="text/javascript">
$(function() {
	$(".button-move-up").click(function(){
		
		$.ajax({
			type: 'POST',
			async: false,
			url: '{/literal}/{$router->getUrl('cms','index','move')}{literal}',
			data: ( {'page_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
			success: function(data) {
		    	window.location.reload();
			}
		});
		return false;
	});
	
	$(".button-move-down").click(function(){
		
		$.ajax({
			type: 'POST',
			async: false,
			url: '{/literal}/{$router->getUrl('cms','index','move')}{literal}',
			data: ( {'page_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
			success: function(data) {
		    	window.location.reload();
			}
		});
		return false;
	});
	
	$(".button-active").click(function(){
		$.ajax({
			type: 'POST',
			async: false,
			url: '{/literal}/{$router->getUrl('cms','index','active')}{literal}',
			data: ( {'page_id' : $(this).val()} ),
			success: function(data) {
				window.location.reload(); 
			}
		});
	});
	
	$(".button-delete").click(function(){
		var item_id = $(this).val();
		$.modal({
			title: '{/literal}{$locale.cms.index.modal.delete.title}{literal}',
			content: '{/literal}{$locale.cms.index.modal.delete.content}{literal}',

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
