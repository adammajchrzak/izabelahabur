<div class="with-padding">
<form id="form-edit-news" name="form-edit-news" method="post" action="/{$router->getUrl('cms','price','edit')}">
	
	<h2 class="thin float-left">Edytuj lokal</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','price')}';" class="button glossy button-cancel-text"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>

	<input type="hidden" id="item_id" name="item_id" value="{$item.item_id}">
	
	<h3 class="thin underline clear-both">Dane lokalu</h3>
	<fieldset class="fieldset fields-list">
		<p class="inline-large-label button-height">
			<label class="label">Numer lokalu</label>
			<input type="text" id="_local" name="_local" value="{$item._local|escape}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Piętro</label>
			<select id="_floor" name="_floor" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$category_list item=cl}
				<option value="{$cl.item_id}"{if $item._floor == $cl.item_id} selected{/if}>{$cl._name}</option>
				{/foreach}
			</select>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Ilość pokoi</label>
			<select id="_room" name="_room" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				<option value="1"{if $item._room == '1'} selected{/if}>1 pokój</option>
				<option value="2"{if $item._room == '2'} selected{/if}>2 pokoje</option>
				<option value="3"{if $item._room == '3'} selected{/if}>3 pokoje</option>
				<option value="4"{if $item._room == '4'} selected{/if}>4 pokoje</option>
			</select>
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Metraż m<sup>2</sup></label>
			<input type="text" id="_area" name="_area" value="{$item._area|escape}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Balkon m<sup>2</sup></label>
			<input type="text" id="_balcony" name="_balcony" value="{$item._balcony|escape}" class="input full-width" />
		</p>
        <p class="inline-large-label button-height">
			<label class="label">Rata kredytu</label>
			<input type="text" id="_credit" name="_credit" value="{$item._credit|escape}" class="input full-width" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Lokal dostępny</label>
			<input id="_available" name="_available" type="checkbox" value="1" checked class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Antresola</label>
			<input id="_entresol" name="_entresol" type="checkbox" value="1" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Taras</label>
			<input id="_terrace" name="_terrace" type="checkbox" value="1" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Ogród</label>
			<input id="_garden" name="_garden" type="checkbox" value="1" class="switch" data-text-on="TAK" data-text-off="NIE" />
		</p>
		<p class="inline-large-label button-height">
			<label class="label">Rzut marketingowy</label>
			<input id="_file" name="_file" type="text" value="{$item._file|escape}" class="input full-width"/>
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