<div class="with-padding">
    <form id="form-edit-gallery" name="form-edit-gallery" method="post" action="/{$router->getUrl('cms','gallery', 'edit')}">

        <h2 class="thin float-left">Edytuj galerię</h2>

        <div class="float-right">
            <button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
            <button type="button" onclick="document.location.href = '/cms#/{$router->getUrl('cms','gallery')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
        </div>

        <input type="hidden" id="gallery_id" name="gallery_id" value="{$gallery_details.gallery_id}">
        <input type="hidden" id="lang_code" name="lang_code" value="{$gallery_details.lang_code}">

        <h3 class="thin underline clear-both">Dane podstawowe</h3>	
        <fieldset class="fieldset fields-list">
            <p class="inline-large-label button-height">
                <label class="label">Nazwa galerii</label>
                <input type="text" id="_name" name="_name" value="{$gallery_details._name}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                    <label class="label">Opis wstępny</label>
                    <textarea id="_lead" name="_lead" class="input full-width">{$gallery_details._lead}</textarea>
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Opis galerii</label>
                <textarea id="_description" name="_description" class="input full-width">{$gallery_details._description}</textarea>
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Link (iStock)</label>
                <input type="text" id="_link" name="_link" value="{$gallery_details._link}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Kategoria</label>
                <select id="category_id" name="category_id" class="select check-list">
                    <option value="0">-- wybierz z listy --</option>
                    {foreach from=$category_list item=cl}
                        <option value="{$cl.category_id}"{if $gallery_details.category_id == $cl.category_id} selected{/if}>{$cl._name}</option>
                    {/foreach}
                </select>
            </p>

            <p class="inline-large-label button-height">
                <label class="label">Słowa kluczowe</label>
                {foreach from=$keywords item=kw}
                    <input type="checkbox" id="keywords[]" name="keywords[]" value="{$kw.keyword_id}"{if in_array($kw.keyword_id, $gallery_keywords)} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE"> {$kw._name}
                {/foreach}
                <input type="text" id="keyword_list" name="keyword_list" value="" class="input full-width" placeholder="wpisz nowe słowa oddzielone przecinkiem" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Nowość</label>
                <input id="_latest" name="_latest" type="checkbox" value="1"{if $gallery_details._latest == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Galeria aktywna</label>
                <input id="_active" name="_active" type="checkbox" value="1"{if $gallery_details._active == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
            </p>
        </fieldset>

        <h3 class="thin underline">Zarządzanie zdjęciami</h3>
        <fieldset class="fieldset fields-list">
            <p class="inline-large-label button-height">
                <label class="label">Dodaj</label>
                <input id="file_upload" name="file_upload" type="file" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Zdjęcia</label>
                <div style="margin-left: 230px;">
                    <ul class="gallery">
                        {foreach item=tree name=tree from=$picture_list}
                            <li>
                                <img src="{$tree.file_dir}/small/{$tree.file_name}" class="framed" />
                                <div class="controls">
                                    <span class="button-group compact children-tooltip">
                                        <a href="/{$router->getUrl('cms','gallery', 'picture_edit', $tree.picture_id)}" class="button icon-gear button-edit" title="edytuj właściwości">edytuj</a>
                                        <a href="/{$router->getUrl('cms','gallery', 'picture_delete', $tree.picture_id)}" title="usuń zdjęcie" class="button icon-trash button-delete" title="{$tree.picture_id}"></a>
                                    </span>
                                </div>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </p>
        </fieldset>
    </form> 
                
    <div class="clear-both" style="margin-top: 50px;"></div>
    
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
                <th>iStock Link</th>
                <th class="one-column">Portfolio</th>
                <th class="one-column">Kategoria</th>
                <th class="one-column">Latest</th>
                <th class="one-column">Featured</th>
            </tr>
        {foreach item=tree name=tree from=$picture_list}
            <tr>
                <td><img src="{$tree.file_dir}/small/{$tree.file_name}" class="framed" /></td>
                <td>
                    <input type="text" id="image{$tree.picture_id}" name="image{$tree.picture_id}" value="{$tree.istock_link}" class="input full-width" />
                </td>
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

{foreach from=$head->getStyles() item=style}
    <link href="{$style.path}{$style.file}" media="{$style.media}" rel="stylesheet" type="text/css" />
{/foreach}

{foreach from=$head->getScripts() item=script}
    <script src="{$script.path}{$script.file}" type="text/javascript" ></script>
{/foreach}

{literal}
<script type="text/javascript">
    $(function () {

        CKEDITOR.replace('_lead', { height: '100px'});    
        CKEDITOR.replace('_description', { height: '200px'});

        $('#file_upload').uploadify({
            'swf': '/files4cms/js/uploadify/uploadify.swf',
            'uploader': '/cms/gallery/upload/111/{/literal}{$gallery_details.gallery_id}{literal}',
            'cancelImg': '/files4cms/js/uploadify/cancel.png',
            'folder': '/upload',
            'auto': true,
            'multi': true,
            'displayData': 'speed',
            'sizeLimit': 10240000,
            'buttonText': 'WYBIERZ PLIKI',
            'fileObjName': 'filedata',
            'fileTypeExts': '*.jpg;*.jpeg;*.gif;',
            'onComplete': function (event, ID, fileObj, response, data) {
            },
            'onQueueComplete': function (queueData) {
                window.location.reload();
            }
        });

        $(".button-delete").click(function () {
            $.ajax({
                url: $(this).attr('href'),
                async: false,
                success: function (data) {
                    window.location.reload();
                }
            });
            return false;
        });
    });
</script>
{/literal}