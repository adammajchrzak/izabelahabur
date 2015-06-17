<div class="with-padding">
<form id="form-edit-news" name="form-edit-news" method="post" action="/{$router->getUrl('cms','price','cedit')}">
	
	<h2 class="thin float-left">Dodaj kategorię</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','price', 'category')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="item_id" name="item_id" value="{$category_details.item_id}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa kategorii</label>
			<input type="text" id="_name" name="_name" value="" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis kategorii</label>
			<textarea id="_description" name="_description" class="input full-width"></textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Kategoria aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Rzut marketingowy</label>
			<input id="_file" name="_file" type="text" value="{$category_details._file|escape}" class="input full-width"/>
		</p>
	</fieldset>
</form>
</div>

{literal}
<script>
$(function() {
	$('#_file').on('click', function(event){
		window.SetUrl=(function(id){
			return function(value){
				value=value.replace(/[a-z]*:\/\/[^\/]*/,'');
				$('#'+id).val(value);	
			}
		})(this.id);
		var kfm_url='/files4cms/js/kfm/';
		window.open(kfm_url,'_file','modal,width=800,height=500');
	});
});	
</script>	
{/literal}