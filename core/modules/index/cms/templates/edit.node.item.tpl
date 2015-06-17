{*
<input type="hidden" id="list_id[]" name="list_id[]" value="{$item@iteration}" />
<input type="hidden" id="item_id_{$item@iteration}" name="item_id_{$item@iteration}" value="{$item.item_id}" />
<input type="hidden" id="module_id_{$item@iteration}" name="module_id_{$item@iteration}" value="{$item.module_id}" />
<input type="hidden" id="object_id_{$item@iteration}" name="object_id_{$item@iteration}" value="{$item.object_id}" />
*}

<div class="with-padding">
<form id="form-add-page" name="form-add-page" method="post" action="">
		
	<h2 class="thin float-left">Edycja zawartości strony</h2>
	
	<div class="float-right">
		<button type="submit" class="button glossy mid-margin-right save-content"><span class="button-icon"><span class="icon-tick"></span></span>zapisz zmiany</button>
		<button type="button" onclick="document.location.href='/cms#/{$router->getUrl('cms','index','editnode',$item_details.node_id,$item_details.lang_code)}';" class="button glossy"><span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>anuluj</button>
	</div>	
		
	<input type="hidden" id="item_id" name="item_id" value="{$item_details.item_id}" />
	<input type="hidden" id="content_id" name="content_id" value="{$item_content.content_id}" />
	
	<fieldset class="fieldset clear-both">
		<p class="block-label button-height">
			<label class="label">Tytuł treści</label>
			<input type="text" id="_title" name="_title" class="input full-width" value="{$item_content._title|escape}" />
		</p>
		
		<p class="block-label button-height">
			<label class="label">Treść</label>
			<textarea id="_content" name="_content" class="input eleven-columns ckeditor">{$item_content._text|escape}</textarea>
		</p>
		
	</fieldset>
</form>
</div>
{literal}
<script>
$(function() {
	CKEDITOR.replace( '_content' );
	$('.save-content').click(function(){
		$.ajax({
	  		type: 'POST',
	  		async: false,
	  		url: '{/literal}/{$router->getUrl('cms','index','editnodeitem')}{literal}', 
	  		data: {
	  			'item_id'	:   $('#item_id').val(),
	  			'module_id' :	'1',
	  			'content_id':   $('#content_id').val(),
	  			'_title'	:	$('#_title').val(),
	  			'_text'		:	CKEDITOR.instances._content.getData()
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
