<div class="with-padding">
<form id="form-edit-news" name="form-edit-news" method="post" action="/{$router->getUrl('cms','news','cedit')}">
	
	<h2 class="thin float-left">Edytuj kategorię</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','news', 'category')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="category_id" name="category_id" value="{$category_details.category_id}">
	<input type="hidden" id="_code" name="_code" value="{$category_details._code}">
	<input type="hidden" id="lang_code" name="lang_code" value="{$category_details.lang_code}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa kategorii</label>
			<input type="text" id="_name" name="_name" value="{$category_details._name|escape}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis kategorii</label>
			<textarea id="_description" name="_description" class="input full-width">{$category_details._description|escape}</textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Kategoria aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1"{if $category_details._active == '1'} checked="checked"{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
	</fieldset>
</form>
</div>