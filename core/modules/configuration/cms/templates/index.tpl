<div class="with-padding">
    <h2 class="thin float-left">Konfiguracja systemu</h2>
    <div class="float-right"><button onclick="document.location.href = '/{$router->getUrl('cms#','cms','configuration','add')}'" class="button button-add-text"><span class="button-icon green-gradient"><span class="icon-star"></span></span>dodaj</button></div>
    <div class="table-header clear-both"></div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Klucz</th>
                <th scope="col">Nazwa</th>
                <th scope="col">Wartość</th>
                <th scope="col">Opis</th>
                <th scope="col" class="one-column align-center">Operacje</th>
            </tr>
        </thead>
        <tbody>
            {foreach item = list name = list from=$item_list}
                <tr>
                    <th><a href="/{$router->getUrl('cms','configuration','edit',$list.id)}">{$list._key}</a></th>
                    <td>{$list._name}</td>
                    <td>{$list._value}</td>
                    <td>{$list._description}</td>
                    <td nowrap="nowrap">
                        <button class="button compact icon-pencil blue-gradient button-edit" onclick="document.location.href = '/{$router->getUrl('cms#','cms','configuration','edit',$list.id)}'"></button>
                        <button class="button compact icon-trash red-gradient button-delete" title="delete" value="{$list.id}"></button>
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
                            url: '{/literal}/{$router->getUrl('cms','configuration','delete')}{literal}',
                            data: ({'id': item_id}),
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
});
</script>	
{/literal}