<div class="with-padding">
    <h2 class="thin float-left">Slider</h2>
    <div class="float-right"><button onclick="document.location.href = '/cms#/{$router->getUrl('cms','slider','add')}'" class="button"><span class="button-icon green-gradient"><span class="icon-star"></span></span>dodaj</button></div>
    <div class="table-header clear-both"></div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="one-column">Zdjęcie</th>
                <th scope="col">Nazwa</th>
                <th scope="col">Link</th>
                <th scope="col" class="one-column align-center">Utworzenie</th>
                <th scope="col" class="one-column">Kolejność</th>
                <th scope="col" class="one-column">Aktywność</th>
                <th scope="col" class="one-column align-center">Operacje</th>
            </tr>
        </thead>
        <tbody>
        {foreach item=tree name=tree from=$list}
            <tr>
                <td><img src="/files/slider/{$tree._file}" style="width: 100%;" /></td>
                <td><a href="/{$router->getUrl('cms','slider','edit',$tree.slider_id)}">{$tree._name}</a></td>
                <td><a href="{$tree._link}" target="_blank">{$tree._link}</a></td>
                <td nowrap="nowrap">{$tree._created}</td>
                <td nowrap="nowrap">
                    <button class="button compact green-gradient button-move-down" title="DOWN" value="{$tree.slider_id}"><span class="icon-down-fat"></span></button>
                    <button class="button compact green-gradient button-move-up" title="UP" value="{$tree.slider_id}"><span class="icon-up-fat"></span></button>
                </td>
                <td class="align-center"><button class="button compact {if $tree._active =='1'}icon-tick green-gradient{else}icon-cross red-gradient{/if} button-active" value="{$tree.slider_id}"></button></td>
                <td nowrap="nowrap">
                    <button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href = '/cms#/{$router->getUrl('cms','slider','edit',$tree.slider_id)}'"></button>
                    <button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$tree.slider_id}"></button>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    <div class="table-footer"></div>
</div>

{literal}
<script>
    $(function () {
        $(".button-delete").click(function () {

            var item_id = $(this).val();
            $.modal({
                title: 'Usuwanie wpisu',
                content: 'Czy jesteś pewny/a, że chcesz usunąć ten wpis? Operacja będzie nieodwracalna!',
                buttonsAlign: 'center',
                buttons: {
                    'usuń': {
                        classes: 'green-gradient glossy small icon-tick',
                        click: function (modal) {
                            $.ajax({
                                type: 'POST',
                                async: false,
                                url: '{/literal}/{$router->getUrl('cms','slider','delete')}{literal}',
                                data: ({'slider_id': item_id}),
                                success: function (data) {
                                    modal.closeModal();
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    'anuluj': {
                        classes: 'red-gradient glossy small icon-cross',
                        click: function (modal) {
                            modal.closeModal();
                        }
                    }
                }
            });
        });

        $(".button-active").click(function () {
            $.ajax({
                type: 'POST',
                async: false,
                url: '{/literal}/{$router->getUrl('cms','slider','active')}{literal}',
                data: ({'slider_id': $(this).val()}),
                success: function (data) {
                    window.location.reload();
                }
            });
        });
        
        $(".button-move-up").click(function(){
		
            $.ajax({
                type: 'POST',
                async: false,
                url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'move')}{literal}',
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
                url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'move')}{literal}',
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