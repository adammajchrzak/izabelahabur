<div class="with-padding"> 
    <form id="form-editlinks-gallery" name="form-editlinks-gallery" method="post" action="/{$router->getUrl('cms','gallery','editlinks')}">
        <h2 class="thin float-left">Zarządzanie linkami zdjęć</h2>
        <div class="float-right">
            <button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
            <button type="button" onclick="document.location.href = '/cms#/{$router->getUrl('cms','gallery')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
        </div>
        <div class="clear-both"></div>
        <fieldset class="fieldset">
            <input type="hidden" id="gallery_id" name="gallery_id" value="{$gallery_details.gallery_id}">
            <input type="hidden" id="lang_code" name="lang_code" value="{$gallery_details.lang_code}">    
            <table class="table">
                <tr>
                    <th class="one-column">Zdjęcie</th>
                    <th class="one-column">Kolejność</th>
                    <th>iStock Link</th>
                    <th class="one-column">Portfolio</th>
                    <th class="one-column">Kategoria</th>
                    <th class="one-column">Latest</th>
                    <th class="one-column">Featured</th>
                </tr>
                {foreach item=tree name=tree from=$picture_list}
                    <tr>
                        <td><img src="{$tree.file_dir}/small/{$tree.file_name}" class="framed" /></td>
                        <td nowrap="nowrap">
                            <button class="button compact green-gradient button-move-down" title="DOWN" value="{$tree.picture_id}"><span class="icon-down-fat"></span></button>
                            <button class="button compact green-gradient button-move-up" title="UP" value="{$tree.picture_id}"><span class="icon-up-fat"></span></button>
                        </td>
                        <td><input type="text" id="image{$tree.picture_id}" name="image{$tree.picture_id}" value="{$tree.istock_link}" class="input full-width" /></td>
                        <td><input id="level1{$tree.picture_id}" name="level1{$tree.picture_id}" type="checkbox" value="1"{if $tree._level1 == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" /></td>
                        <td><input id="level2{$tree.picture_id}" name="level2{$tree.picture_id}" type="checkbox" value="1"{if $tree._level2 == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" /></td>
                        <td><input id="latest{$tree.picture_id}" name="latest{$tree.picture_id}" type="checkbox" value="1"{if $tree._latest == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" /></td>
                        <td><input id="featured{$tree.picture_id}" name="featured{$tree.picture_id}" type="checkbox" value="1"{if $tree._featured == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" /></td>
                    </tr>
                {/foreach}
            </table>
        </fieldset>        
    </form>
</div>

{literal}
    <script>
        $(function () {
            $(".button-move-up").click(function () {
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'pmove')}{literal}',
                    data: ({'item_id': $(this).val(), 'direction': $(this).attr('title'), 'gallery_id' : $('#gallery_id').val()}),
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
                    url: '{/literal}/{$router->getUrl($config->module_type,$config->module,'pmove')}{literal}',
                    data: ({'item_id': $(this).val(), 'direction': $(this).attr('title'), 'gallery_id' : $('#gallery_id').val()}),
                    success: function (data) {
                        window.location.reload();
                    }
                });
                return false;
            });
        });
    </script>	
{/literal}