<div class="with-padding">
    <form id="form-add-gallery" name="form-add-gallery" method="post" enctype="multipart/form-data" action="/{$router->getUrl('cms','slider', 'edit')}">

        <h2 class="thin float-left">Dodaj element</h2>

        <div class="float-right">
            <button type="submit" class="button glossy mid-margin-right button-add-gallery-save"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
            <button type="button" onclick="document.location.href = '/cms#/{$router->getUrl('cms','slider')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
        </div>

        <input type="hidden" id="slider_id" name="slider_id" value="0">
        <input type="hidden" id="lang_code" name="lang_code" value="{$item.lang_code}">

        <h3 class="thin underline clear-both">Dane podstawowe</h3>		
        <fieldset class="fieldset fields-list">	
            <p class="inline-large-label button-height">
                <label class="label">Nazwa elementu</label>
                <input type="text" id="_name" name="_name" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Opis elementu</label>
                <textarea id="_description" name="_description" class="input full-width"></textarea>
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Plik</label>
                <input type="file" id="_file" name="_file" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Link</label>
                <input type="text" id="_link" name="_link" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Element aktywna</label>
                <input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
            </p>
        </fieldset>    
    </form>
</div>
        
{literal}
<script>
    $(function () {
        CKEDITOR.replace('_description');
    });
</script>	
{/literal}