<div class="with-padding">
    <form id="form-edit-user" name="form-edit-user" method="post" action="/{$router->getUrl('cms', 'configuration', 'edit')}">

        <h2 class="thin float-left">Edycja wpisu</h2>

        <div class="float-right">
            <button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
            <button type="button" onclick="document.location.href = '/{$router->getUrl('cms#','cms','configuration')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
        </div>

        <input type="hidden" id="id" name="id" value="{$item_details.id}" />

        <h3 class="thin underline clear-both">Dane podstawowe</h3>	
        <fieldset class="fieldset fields-list">
            <p class="inline-large-label button-height">
                <label class="label">Klucz (kod php)</label>
                <input type="text" id="_key" name="_key" value="{$item_details._key}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Nazwa</label>
                <input type="_name" id="_name" name="_name" value="{$item_details._name}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Wartość</label>
                <input type="text" id="_value" name="_value" value="{$item_details._value}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Treść</label>
                <textarea id="_description" name="_description" class="input eleven-columns ckeditor">{$item_details._description|escape}</textarea>
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