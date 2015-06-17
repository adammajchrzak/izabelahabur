<ul class="gallery">
{foreach item=tree name=tree from=$picture_list}
	<li>
		<img src="{$tree.file_dir}/small/{$tree.file_name}" class="framed" />
	</li>
{/foreach}
</ul>