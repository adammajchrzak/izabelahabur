<div class="with-padding">
    <form id="form-add-user" name="form-add-user" method="post" action="/{$router->getUrl('cms','configuration', 'edit')}">

        <h2 class="thin float-left">Dodaj wpis</h2>

        <div class="float-right">
            <button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
            <button type="button" onclick="document.location.href = '/{$router->getUrl('cms#','cms','configuration')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
        </div>

        <input type="hidden" id="id" name="id" value="0" />

        <h3 class="thin underline clear-both">Dane</h3>
        <fieldset class="fieldset fields-list">
            <p class="inline-large-label button-height">
                <label class="label">Klucz (kod php)</label>
                <input type="text" id="_key" name="_key" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Nazwa</label>
                <input type="_name" id="_name" name="_name" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Wartość</label>
                <input type="text" id="_value" name="_value" value="" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Treść</label>
                <textarea id="_description" name="_description" class="input eleven-columns ckeditor"></textarea>
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