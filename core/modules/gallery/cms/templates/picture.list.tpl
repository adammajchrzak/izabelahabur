{literal}
<script type="text/javascript">	
$(function() {		
	$(".button-edit").button({
		text: false,
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$(".button-delete").button({
		text: false,
		icons: {
			primary: "ui-icon-close"
		}
	});
	
	$(".edit-set").buttonset();
	
	$(".button-delete").click(function(){
		
		$.ajax({
			url: "/cms/gallery/picture_delete/" + $(this).val() + "/{/literal}{$gallery_id}{literal}.html",
			async : false
		});
		
		$.ajax({
	  		url: "/cms/gallery/picture_list/{/literal}{$gallery_id}{literal}.html",
	  		success: function(response){
	    		$('#ui-tabs-1').html(response);
	  		}
		});
		return false;
	});
	
	$(".button-edit").click(function(){
		document.location.href = $(this).attr('title');
		return false;
	});
	
	$("a[rel='colorbox']").colorbox();
	
});
</script>
{/literal}
<p style="font-weight: bold;">Lista zdjęć w galerii</p>
<div>
	<table style="width: 100%">
		<tr>
			<th style="width: 120px; text-align: center;">Plik</th>
			<th style="width: 140px; text-align: left;">Nazwa pliku</th>
			<th style="width: 150px; text-align: left;">Opis pliku</th>
			<th style="width: 150px; text-align: center;">Data dodania</th>
			<th></th>
		</tr>
		{foreach item=tree name=tree from=$picture_list}
		<tr>
			<td style="text-align: center;"><a href="{$tree.file_dir}/large/{$tree.file_name}" rel="colorbox" title="{$tree.picture_description}"><img src="{$tree.file_dir}/small/{$tree.file_name}" /></a></td>
			<td style="text-align: left;">{$tree.picture_name|truncate:25}</td>
			<td style="text-align: left;">{$tree.picture_description}</td>
			<td style="text-align: center;">{$tree._created}</td>
			<td>
				<span class="edit-set">
					<button class="button-edit" title="/{$router->getUrl('cms','gallery','picture_edit',$tree.picture_id)}">edytuj</button>
					<button class="button-delete" title="delete" value="{$tree.picture_id}">usuń</button>
				</span>
			</td>
		</tr>
		{/foreach}
		
	</table>
</div>