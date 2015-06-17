<div class="with-padding">
<form id="form-edit-news" name="form-edit-news" method="post" action="/{$router->getUrl('cms','gallery','cedit')}">
	
	<h2 class="thin float-left">Dodaj kategorię</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','gallery', 'category')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="category_id" name="category_id" value="{$category_details.category_id}">
	<input type="hidden" id="_code" name="_code" value="{$category_details._code}">
	<input type="hidden" id="lang_code" name="lang_code" value="{$category_details.lang_code}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa kategorii</label>
			<input type="text" id="_name" name="_name" value="" class="input full-width" />
		</p>
                <p class="inline-large-label button-height">
			<label class="label">Tytuł</label>
			<input type="text" id="_title" name="_title" value="" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis kategorii</label>
			<textarea id="_description" name="_description" class="input full-width"></textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Kategoria aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
	</fieldset>
</form>
</div>
        
{literal}
<script>
    $(function () {
        CKEDITOR.replace('_description', { height: '200px'});
    });
</script>	
{/literal}