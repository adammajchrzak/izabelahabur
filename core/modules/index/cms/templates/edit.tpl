<div class="with-padding">
<form id="form-edit-page" name="form-edit-page" method="post" action="/{$router->getUrl('cms','index','edit')}">

	<h2 class="thin float-left">Edytuj stronę</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','tree')}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="page_id" name="page_id" value="{$page_details.page_id}">
	
	<h3 class="thin underline clear-both">Wersje językowe</h3>
	<fieldset class="fieldset">
		{foreach from=$locale_list item=ll}
		<label class="label margin-right">{$ll.lang_name}</label> <a href="/{$router->getUrl('cms','index','editnode',$page_details.page_id,{$ll.lang_code})}" class="button edit-item margin-right" title="{$item.item_id}"><span class="button-icon green-gradient"><span class="icon-pencil"></span></span>edytuj</a>
		{/foreach}
	</fieldset>
	
	<h3 class="thin underline">Dane podstawowe</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa strony
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Nazwa administracyjna strony w ramach struktury serwisu. </span>
				</span>
			</label>
			<input type="text" id="page_name" name="page_name" value="{$page_details.page_name|escape}" class="input full-width" />
		</p>
		
		<p class="inline-large-label button-height">
			<label class="label">Strona aktywna</label>
			<input id="page_active" name="page_active" type="checkbox" value="1"{if $page_details._active == '1'} checked{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
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
			<input type="text" id="content_redirect" name="content_redirect" class="input full-width" value="{$page_details.content_redirect|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Rozpoczęcie publikacji</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_start" name="_start" class="input-unstyled datepicker" value="{$page_details._start}">
			</span>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Zakończenie publikacji</label>
			<span class="input">
				<span class="icon-calendar"></span>
				<input type="text" id="_stop" name="_stop" class="input-unstyled datepicker" value="{$page_details._stop}" />
			</span>	
		</p>	

		<p class="inline-large-label button-height">
			<label class="label">Szablon strony</label>

			<select id="_template" name="_template" class="select check-list">
				<option>-- [select from list] -- </option>
				{foreach from=$template_list item=tl}
				<option value="{$tl.template_file}"{if $page_details._template == $tl.template_file} selected{/if}>{$tl.template_name}</option>
				{/foreach}
			</select>
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