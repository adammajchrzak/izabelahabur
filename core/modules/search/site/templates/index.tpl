<div class="page-text" style="padding-bottom: 0px;">
	<h1>Wyniki wyszukiwania</h1>
	<div style="padding: 15px 15px 15px 0px;">Poszukiwania fraza: <strong>{$word}</strong></div>
</div>

<div style="padding: 0px 15px 0px 15px;">
	{if $search_list}
	<ul class="news-list">
	{foreach item=tree name=tree from=$search_list}	
		<li>
			<div class="news-list-title"><a href="{$router->getUrl($tree.module,$tree.content_code,$tree.object_id)}">{$tree.content_title}</a></div>
			<div class="news-list-lead">{$tree.content_lead}</div>
			<div class="news-list-more"><a href="{$router->getUrl($tree.module,$tree.content_code,$tree.object_id)}">więcej &raquo;</a></div>
		</li>
	{/foreach}
	</ul>
	{include file="templates/common/pagination.tpl"}
	{else}
		<div>Brak wyników wyszukiwania dla podanej frazy.<br/>Spróbuj wprowadzi inną frazę.</div>
	{/if}
</div>