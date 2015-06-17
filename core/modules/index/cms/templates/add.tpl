<div class="with-padding">
<form id="form-add-page" name="form-add-page" method="post" action="/{$router->getUrl('cms','index', 'edit')}">

	<h2 class="thin float-left">Dodaj stronę</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','tree')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="page_id" name="page_id" value="{$page_details.page_id}">
	<input type="hidden" id="parent_id" name="parent_id" value="{$page_details.parent_id}">
	<input type="hidden" id="content_code" name="content_code" value="">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>
	
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa strony
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Nazwa administracyjna strony w ramach struktury serwisu. </span>
				</span>	
			</label>
			<input type="text" id="page_name" name="page_name" value="" class="input full-width" />
		</p>
		
		<p class="inline-large-label button-height">
			<label class="label">Strona aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1" checked="checked" class="switch" data-text-on="TAK" data-text-off="NIE" />
			
		</p>
		
		{if $config->multi_locale == '1'}
		<p class="inline-large-label button-height">
			<label class="label">Wersje&nbsp;językowe</label>
			<span class="button-group">
				{foreach from=$locale_list item=ll}
				<label class="button green-active"><input type="checkbox" id="lang_code[]" name="lang_code[]" value="{$ll.lang_code}" checked="checked" /> {$ll.lang_name}</label>
				{/foreach}
			</span>
		</p>
		{/if}
	</fieldset>
	
	<h3 class="thin underline">Ustawienia zaawansowane</h3>
	<fieldset class="fieldset fields-list">
		
		<p class="inline-large-label button-height">
			<label class="label">Przekierowanie
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Adres URL na jaki ma zostać przekierowana strona.</span>
				</span>	
			</label>
			<input type="text" id="_redirect" name="_redirect" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Rozpoczęcie publikacji</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_start" name="_start" class="input-unstyled datepicker" value="">
			</span>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Zakończenie publikacji</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_stop" name="_stop" class="input-unstyled datepicker" value="" />
			</span>	
		</p>	

		<p class="inline-large-label button-height">
			<label class="label">Szablon strony</label>

			<select id="_template" name="_template" class="select check-list">
				<option>-- [select from list] -- </option>
				{foreach from=$template_list item=tl}
				<option value="{$tl.template_file}">{$tl.template_name}</option>
				{/foreach}
			</select>
		</p>
	</fieldset>
	
	<h3 class="thin underline">SEO</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Tytuł strony</label>
			<input type="text" id="_metatitle" name="_metatitle" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Słowa kluczowe</label>
			<input type="text" id="_metakeywords" name="content_metakeywords" class="input full-width" value="" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis</label>
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
});	
</script>	
{/literal}
