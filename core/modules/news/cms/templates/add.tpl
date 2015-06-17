<div class="with-padding">
<form id="form-add-news" name="form-add-news" method="post" action="/{$router->getUrl('cms','news','edit')}">
	
	<h2 class="thin float-left">Dodaj aktualność</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','news')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="news_id" name="news_id" value="{$news_details.news_id}">
	<input type="hidden" id="content_code" name="content_code" value="{$news_details.content_code}">
	<input type="hidden" id="lang_code" name="lang_code" value="{$news_details.lang_code}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Tytuł aktualności</label>
			<input type="text" id="_title" name="_title" value="" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Data publikacji aktualności</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_publish" name="_publish" value="" class="input-unstyled datepicker" />
			</span>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Kategoria wydarzenia</label>
			<select id="category_id" name="category_id" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$category_list item=cl}
				<option value="{$cl.category_id}">{$cl._name}</option>
				{/foreach}
			</select>
		</p>
	</fieldset>
	
	<h3 class="thin underline">Treść aktualności</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Lead aktualności</label>
			<textarea id="_lead" name="_lead" class="input full-width"></textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Pełna treść</label>
			<textarea id="_content" name="_content" class="input eleven-columns ckeditor"></textarea>
		</p>
	</fieldset>
	
	<h3 class="thin underline">Ustawienia zaawansowane</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Aktualność aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Przekierowanie</label>
			<input type="text" id="_redirect" name="_redirect" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">{$locale.cms.news.add.field003.l3}</label>
			<input id="_picture" name="_picture" type="text" value="{$element._picture}" class="input full-width"/>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Galeria</label>
			<select id="gallery_id" name="gallery_id" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$gallery_list item=gl}
				<option value="{$gl.gallery_id}">{$gl._name}</option>
				{/foreach}
			</select>
		</p>
	</fieldset>
	
	<h3 class="thin underline">SEO</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Tytuł strony (TITLE)</label>
			<input type="text" id="_metatitle" name="_metatitle" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Słowa kluczowe<br/>(KEYWORDS)</label>
			<input type="text" id="_metakeywords" name="_metakeywords" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis (DESCRIPTION)</label>
			<textarea id="_metadescription" name="_metadescription" class="input full-width"></textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Google JS Scripts</label>
			<textarea id="_metascripts" name="_metascripts" class="input full-width"></textarea>
		</p>
	</fieldset>
</form>
</div>

{literal}
<script>
$(function() {
	$( ".datepicker" ).datepicker($.datepicker.regional[ "pl" ]);
	
	CKEDITOR.replace( '_content' );
	
	$('#_picture').on('click', function(event){
		window.SetUrl=(function(id){
			return function(value){
				value=value.replace(/[a-z]*:\/\/[^\/]*/,'');
				$('#'+id).val(value);	
			}
		})(this.id);
		var kfm_url='/files4cms/js/kfm/';
		window.open(kfm_url,'_picture','modal,width=800,height=500');
	});
});	
</script>	
{/literal}