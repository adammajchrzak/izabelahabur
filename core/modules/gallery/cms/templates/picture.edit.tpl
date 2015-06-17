<div class="with-padding">
<form id="form-edit-gallery" name="form-edit-gallery" method="post" action="/{$router->getUrl('cms','gallery', 'picture_edit')}">
	
    <h2 class="thin float-left">Edytuj zdjęcie</h2>

    <div class="float-right">
        <button type="submit" class="button glossy mid-margin-right button-add-gallery-save"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
        <button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','gallery','edit',$picture_details.gallery_id)}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
    </div>

    <input type="hidden" id="gallery_id" name="gallery_id" value="{$picture_details.gallery_id}" />
    <input type="hidden" id="picture_id" name="picture_id" value="{$picture_details.picture_id}" />

    <fieldset class="fieldset fields-list clear-both">
            <p class="inline-large-label button-height">
                <label class="label">Nazwa zdjęcia</label>
                <input type="text" id="picture_name" name="picture_name" value="{$picture_details.picture_name}" class="input full-width" />
            </p>
            <p class="inline-large-label button-height">
                <label class="label">Opis zdjęcia</label>
                <textarea id="picture_description" name="picture_description" class="input full-width">{$picture_details.picture_description}</textarea>
            </p>
            <p class="inline-large-label button-height">
                <label class="label">iStock link</label>
                <input type="text" id="istock_link" name="istock_link" value="{$picture_details.istock_link}" class="input full-width" />
            </p>
    </fieldset>
</form>
</div>