<div class="with-padding">
<form id="form-add-page" name="form-add-page" method="post" action="">
		
	<h2 class="thin float-left">Edycja zawartości strony</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right save-content"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','editnode',$item_details.node_id,$item_details.lang_code)}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>	
		
	<input type="hidden" id="item_id" name="item_id" value="{$item_details.item_id}" />
	
	<fieldset class="fieldset fields-list clear-both">
		<p class="inline-large-label button-height">
			<label class="label">Galeria</label>
			<select id="gallery_id" name="gallery_id" class="select check-list">
				<option value="0">-- wybierz z listy --</option>
				{foreach from=$gallery_list item=gl}
				<option value="{$gl.gallery_id}"{if $item_details.object_id == $gl.gallery_id} selected{/if}>{$gl._name}</option>
				{/foreach}
			</select>
		</p>
		
	</fieldset>
</form>
</div>
{literal}
<script>
$(function() {
	$('.save-content').click(function(){
		$.ajax({
	  		type: 'POST',
	  		async: false,
	  		url: '{/literal}/{$router->getUrl('cms','index','editnodeitem')}{literal}', 
	  		data: {
	  			'item_id'	:   $('#item_id').val(),
	  			'module_id' :	'2',
	  			'gallery_id':	$('#gallery_id').val()
	  		},
	  		success: function(data)	{
	  			document.location.href = '{/literal}/cms#/{$router->getUrl('cms','index','editnode',$item_details.page_id,$item_details.lang_code)}{literal}';
	  		},
	  		error: function()	{
	  			displayError('Error while contacting server, please try again');
	  		}
	  	});
	  	return false;
	});
});	
</script>	
{/literal}
