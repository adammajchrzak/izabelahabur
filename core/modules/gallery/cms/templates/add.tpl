<div class="with-padding">
<form id="form-add-gallery" name="form-add-gallery" method="post" action="/{$router->getUrl('cms','gallery', 'edit')}">

	<h2 class="thin float-left">Dodaj galerię</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right button-add-gallery-save"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','gallery')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="gallery_id" name="gallery_id" value="0">
	<input type="hidden" id="lang_code" name="lang_code" value="{$gallery_details.lang_code}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>		
	<fieldset class="fieldset fields-list">	
		<p class="inline-large-label button-height">
			<label class="label">Nazwa galerii</label>
			<input type="text" id="_name" name="_name" value="" class="input full-width" />
		</p>
                <p class="inline-large-label button-height">
			<label class="label">Opis wstępny</label>
			<textarea id="_lead" name="_lead" class="input full-width"></textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis galerii</label>
			<textarea id="_description" name="_description" class="input full-width"></textarea>
		</p>
                <p class="inline-large-label button-height">
			<label class="label">Link (iStock)</label>
			<input type="text" id="_link" name="_link" value="" class="input full-width" />
		</p>
                <p class="inline-large-label button-height">
			<label class="label">Kategoria</label>
			<select id="category_id" name="category_id" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$category_list item=cl}
				<option value="{$cl.category_id}">{$cl._name}</option>
				{/foreach}
			</select>
		</p>
                <p class="inline-large-label button-height">
			<label class="label">Nowość</label>
			<input id="_latest" name="_latest" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Galeria aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
</form>
</div>
        
{literal}
<script>
    $(function () {
        CKEDITOR.replace('_lead', { height: '200px'});
        CKEDITOR.replace('_description', { height: '200px'});
    });
</script>	
{/literal}