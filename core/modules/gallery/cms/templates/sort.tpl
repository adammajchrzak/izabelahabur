<div class="with-padding"> 
    <h2 class="thin float-left">Zarządzanie kolejnością zdjęć</h2>
    <div class="clear-both"></div>
    <fieldset class="fieldset">
        <input type="hidden" id="galleryType" name="galleryType" value="{$gallery_type}" />
        <table class="table">
            <tr>
                <th class="one-column">Zdjęcie</th>
                <th>Kolejność</th>
            </tr>
            {foreach item=tree name=tree from=$picture_list}
                <tr>
                    <td><img src="{$tree.file_dir}/small/{$tree.file_name}" class="framed" /></td>
                    <td nowrap="nowrap">
                        <button class="button compact green-gradient button-move-down" title="DOWN" value="{$tree.picture_id}"><span class="icon-down-fat"></span></button>
                        <button class="button compact green-gradient button-move-up" title="UP" value="{$tree.picture_id}"><span class="icon-up-fat"></span></button>
                    </td>
                </tr>
            {/foreach}
        </table>
    </fieldset>        
</div>

{literal}
    <script>
        $(function () {
            $(".button-move-up").click(function () {
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'ggmove')}{literal}',
                    data: ({'item_id': $(this).val(), 'direction': $(this).attr('title'), 'type' : $('#galleryType').val()}),
                    success: function (data) {
                        window.location.reload();
                    }
                });
                return false;
            });

            $(".button-move-down").click(function () {
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'ggmove')}{literal}',
                    data: ({'item_id': $(this).val(), 'direction': $(this).attr('title'), 'type' : $('#galleryType').val()}),
                    success: function (data) {
                        window.location.reload();
                    }
                });
                return false;
            });
        });
    </script>	
{/literal}