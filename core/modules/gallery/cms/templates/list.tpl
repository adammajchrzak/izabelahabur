<div class="with-padding">
	<h2 class="thin float-left">Galerie</h2>
	<div class="float-right"><button onclick="document.location.href='/cms#/{$router->getUrl('cms','gallery','add')}'" class="button"><span class="button-icon green-gradient"><span class="icon-star"></span></span>dodaj</button></div>
	<div class="table-header clear-both"></div>
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Nazwa galerii</th>
                                <th scope="col">Kategoria</th>
				<th scope="col" class="one-column align-center">Utworzenie</th>
                                <th scope="col" class="one-column">Kolejność</th>
                                <th scope="col" class="one-column">Nowość</th>
				<th scope="col" class="one-column">Aktywność</th>
				<th scope="col" class="one-column align-center">Operacje</th>
			</tr>
		</thead>
		<tbody>

		{foreach item=tree name=tree from=$gallery_list}
                <tr>
                    <th><a href="/{$router->getUrl('cms','gallery','edit',$tree.gallery_id)}">{$tree._name}</a></th>
                    <th>{$tree.category_name}</th>
                    <td nowrap="nowrap">{$tree._created}</td>
                    <td nowrap="nowrap">
                        <button class="button compact green-gradient button-move-down" title="DOWN" value="{$tree.gallery_id}"><span class="icon-down-fat"></span></button>
                        <button class="button compact green-gradient button-move-up" title="UP" value="{$tree.gallery_id}"><span class="icon-up-fat"></span></button>
                    </td>
                    <td class="align-center"><button class="button compact {if $tree._latest =='1'}icon-tick green-gradient{else}icon-cross red-gradient{/if} button-latest" value="{$tree.gallery_id}"></button></td>
                    <td class="align-center"><button class="button compact {if $tree._active =='1'}icon-tick green-gradient{else}icon-cross red-gradient{/if} button-active" value="{$tree.gallery_id}"></button></td>
                    <td nowrap="nowrap">
                            <button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href='/cms#/{$router->getUrl('cms','gallery','edit',$tree.gallery_id)}'"></button>
                            <button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$tree.gallery_id}"></button>
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
                title: 'Usuwanie galerii',
                content: 'Czy jesteś pewny/a, że chcesz usunąć tę galerię? Operacja będzie nieodwracalna!',

                buttonsAlign: 'center',
                buttons:{
                    'usuń': {
                        classes: 'green-gradient glossy small icon-tick',
                        click: function(modal) {
                            $.ajax({
                                type: 'POST',
                                async: false,
                                url: '{/literal}/{$router->getUrl('cms','gallery','delete')}{literal}',
                                data: ( {'gallery_id' : item_id} ),
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
	
        $(".button-latest").click(function(){
            $.ajax({
                type: 'POST',
                async: false,
                url: '{/literal}/{$router->getUrl('cms','gallery','latest')}{literal}',
                data: ( {'gallery_id' : $(this).val()} ),
                success: function(data) {
                    window.location.reload(); 
                }
            });
	});
        
	$(".button-active").click(function(){
            $.ajax({
                type: 'POST',
                async: false,
                url: '{/literal}/{$router->getUrl('cms','gallery','active')}{literal}',
                data: ( {'gallery_id' : $(this).val()} ),
                success: function(data) {
                    window.location.reload(); 
                }
            });
	});
        
        $(".button-move-up").click(function(){
            $.ajax({
                type: 'POST',
                async: false,
                url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'gmove')}{literal}',
                data: ( {'item_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
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
                url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'gmove')}{literal}',
                data: ( {'item_id' : $(this).val(), 'direction' : $(this).attr('title')} ),
                success: function(data) {
                    window.location.reload();
                }
            });
            return false;
        });
});	
</script>	
{/literal}