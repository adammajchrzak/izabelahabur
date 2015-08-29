<div class="with-padding">
<form id="form-edit-page" name="form-edit-page" method="post" action="/{$router->getUrl('cms','index','editnode')}">
	
	<h2 class="thin float-left">Edytuj stronę</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','edit',$page_details.page_id)}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>
	
	<input type="hidden" id="page_id" name="page_id" value="{$page_details.page_id}">
	<input type="hidden" id="node_id" name="node_id" value="{$page_details.node_id}">
	<input type="hidden" id="_code" name="_code" value="{$page_details.node_code}">
	<input type="hidden" id="lang_code" name="lang_code" value="{$page_details.lang_code}">
	
	<h3 class="thin underline clear-both">Dane podstawowe</h3>	
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Nazwa strony
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Nazwa strony w wersji językowej.</span>
				</span>	
			</label>
			<input type="text" id="node_title" name="node_title" value="{$page_details.node_title|escape}" class="input full-width" />
		</p>
		
		<p class="inline-large-label button-height">
			<label class="label">Strona aktywna</label>
			<input id="_active" name="_active" type="checkbox" value="1"{if $page_details._active == '1'} checked{/if} class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
	</fieldset>
		
	<h3 class="thin underline">Zawartość strony</h3>	
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Dodaj zawartość</label>
			<select id="module_id" name="module_id" class="select check-list four-columns">
				<option value="0">-- wybierz z listy --</option>
				<option value="1">text</option>
				<option value="2">gallery</option>
			</select>
			<a href="javascript:;" class="button margin-left add-node-item page-child-add"><span class="button-icon blue-gradient"><span class="icon-star"></span></span>dodaj</a>
		</p>	
		
		{foreach $node_items as $item}
		<p id="item_{$item@iteration}" class="inline-large-label button-height">
			<label class="label">{$item._name}{*: [{$item.item_id}] *}</label>
			{*<span>{$item._title}</span>*}
			<a href="javascript:;" class="button view-item margin-right" title="{$item.item_id}"><span class="button-icon blue-gradient"><span class="icon-eye"></span></span>zobacz</a>
			<a href="/cms/index/editnodeitem/{$item.item_id}" class="button edit-item margin-right" title="{$item.item_id}"><span class="button-icon green-gradient"><span class="icon-pencil"></span></span>edytuj</a>
			<a href="javascript:;" type="button" class="button delete-item" title="{$item.item_id}"><span class="button-icon red-gradient"><span class="icon-trash"></span></span>usuń</a>
		</p>
		{/foreach}
	</fieldset>		
	
	<h3 class="thin underline">Ustawienia zaawansowane</h3>
	<fieldset class="fieldset fields-list">
			
		<p class="inline-large-label button-height">
			<label class="label">Przekierowanie
				<span class="info-spot">
					<span class="icon-info-round"></span>
					<span class="info-bubble">Adres URL na jaki ma zostać przekierowana strona w wersji językowej.</span>
				</span>
			</label>
			<input type="text" id="_redirect" name="_redirect" class="input full-width" value="{$page_details._redirect|escape}" />
		</p>
	</fieldset>	
			
	<h3 class="thin underline">SEO</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Tytuł strony</label>
			<input type="text" id="_metatitle" name="_metatitle" class="input full-width" value="{$page_details._metatitle|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Słowa kluczowe</label>
			<input type="text" id="_metakeywords" name="_metakeywords" class="input full-width" value="{$page_details._metakeywords|escape}" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Opis</label>
			<textarea id="_metadescription" name="_metadescription" class="input full-width">{$page_details._metadescription|escape}</textarea>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Google JS Scripts</label>
			<textarea id="_metascripts" name="_metascripts" class="input full-width">{$page_details._metascripts|escape}</textarea>
		</p>
	</fieldset>
</form>
</div>

{literal}
<script>
$(function() {
	
	$('#node_title').blur(function(){
		
		var value = $(this).val();
		var code = '';
		var source	= ['Ż', 'Ź', 'Ć', 'Ń', 'Ą', 'Ś', 'Ł', 'Ę', 'Ó', 'ż', 'ź', 'ć', 'ń', 'ą', 'ś', 'ł', 'ę', 'ó'];
		var dest	= ['z', 'z', 'c', 'n', 'a', 's', 'l', 'e', 'o', 'z', 'z', 'c', 'n', 'a', 's', 'l', 'e', 'o'];
		var l = source.length;
		for (var i = 0; i < l; i++) {
			value = value.replace(source[i], dest[i]);
		}
		var pattern = new RegExp(/[a-zA-Z0-9\-\_]/);
		var pl;
		for (var i = 0; i < value.length; i++) {
			if (value.charAt(i) == ' ') {
				code += '-';
			}
			if (pattern.test(value.charAt(i))) {
				code += value.charAt(i);
			}
		}
		$("#_code").val(code.toLowerCase());
		return true;
	});
	
	$('.add-node-item').click(function(){
		
		if($('#module_id').val() == '0') {
			//alert('ok');
			$.modal.alert('Wybierz typ dodawanej zawartości?', {
				 buttons:{
					'zamknij': {
						classes: 'blue-gradient glossy small',
	        			click: function(modal) { modal.closeModal(); }
					}
				}
			});
			return false;
		}
		
		$.ajax({
			type: 'POST',
			async: false,
			url: '{/literal}/{$router->getUrl('cms','index','editnodeitem')}{literal}',
			data: ( {'item_id' : '0', 'module_id' : $('#module_id').val(), 'node_id' : $('#node_id').val()} ),
			success: function(data) {
				window.location.reload(); 
			}
		});
	});
	
	
	$('.view-item').click(function(){
		$.modal({
			title: 'Podgląd zawartości',
			url: '/cms/index/viewnodeitem/'+$(this).attr('title'),
			height: 600,
			width: 800,
			buttons:{
				'zamknij': {
					classes: 'blue-gradient glossy small full-width',
        			click: function(modal) { modal.closeModal(); }
				}
			}
		});
	});
	
	$('.delete-item').click(function(){
		var item_id = $(this).attr('title');
		$.modal({
			title: 'Usuwanie zawartości',
			content: 'Czy jesteś pewny/a, że chcesz usunąć tę zawartość strony?',

			buttonsAlign: 'center',
			buttons:{
				'usuń': {
					classes: 'green-gradient glossy small icon-tick',
        			click: function(modal) {
        				$.ajax({
							type: 'POST',
							async: false,
							url: '{/literal}/{$router->getUrl('cms','index','deletenodeitem')}{literal}',
							data: ( {'item_id' : item_id} ),
							success: function(data) {
						    	modal.closeModal();
        						window.location.reload(); 
							}
						}); 
        			}
				},
				'anuluj': {
					classes: 'red-gradient glossy small icon-cross',
        			click: function(modal) { modal.closeModal(); }
				}
			}
		});
	});
});	
</script>	
{/literal}