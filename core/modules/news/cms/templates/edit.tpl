<div class="with-padding">
<form id="form-edit-news" name="form-edit-news" method="post" action="/{$router->getUrl('cms','news','edit')}">
	
	<h2 class="thin float-left">Edytuj wpis</h2>
	
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
			<label class="label">Tytuł wpisu</label>
			<input type="text" id="_title" name="_title" value="{$news_details._title|escape}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Data publikacji wpisu</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_publish" name="_publish" value="{$news_details._publish|escape}" class="input-unstyled datepicker" />
			</span>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Kategoria wpisu</label>
			<select id="category_id" name="category_id" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$category_list item=cl}
				<option value="{$cl.category_id}"{if $news_details.category_id == $cl.category_id} selected{/if}>{$cl._name}</option>
				{/foreach}
			</select>
		</p>	
	</fieldset>
	
	<h3 class="thin underline">Treść wpisu</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Lead wpisu</label>
			<textarea id="_lead" name="_lead" class="input full-width">{$news_details._lead|escape}</textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Pełna treść</label>
			<textarea id="_content" name="_content" class="input eleven-columns ckeditor">{$news_details._content|escape}</textarea>
		</p>
	</fieldset>
		
	<h3 class="thin underline">Ustawienia zaawansowane</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Wpis aktywny</label>
			<input id="_active" name="_active" type="checkbox" value="1"{if $news_details._active == '1'} checked{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Przekierowanie</label>
			<input type="text" id="_redirect" name="_redirect" class="input full-width" value="{$news_details._redirect|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">{$locale.cms.news.add.field003.l3}</label>
			<input id="_picture" name="_picture" type="text" value="{$news_details._picture}" class="input full-width"/>
		</p>
	</fieldset>
	
	<h3 class="thin underline">SEO</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Tytuł strony (TITLE)</label>
			<input type="text" id="_metatitle" name="_metatitle" class="input full-width" value="{$news_details._metatitle|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Słowa kluczowe<br/>(KEYWORDS)</label>
			<input type="text" id="_metakeywords" name="_metakeywords" class="input full-width" value="{$news_details._metakeywords|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis (DESCRIPTION)</label>
			<textarea id="_metadescription" name="_metadescription" class="input full-width">{$news_details._metadescription|escape}</textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Google JS Scripts</label>
			<textarea id="_metascripts" name="_metascripts" class="input full-width">{$news_details._metascripts|escape}</textarea>
		</p>
	</fieldset>
</form>
</div>

{literal}
<script>
$(function() {
	$( ".datepicker" ).datepicker($.datepicker.regional[ "pl" ]);
	
	CKEDITOR.replace( '_content', {height : '200px'} );
	
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