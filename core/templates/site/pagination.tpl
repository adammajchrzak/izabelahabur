{if $pages && ($pages->pageCount > 1)}
	<div class="pagination-list">
		<ul>
		<!-- Previous page link --> 
		{if (isset($pages->previous))}
		 	<li class="prev"><a href="/{$router->getUrl($paginationUrl, $pages->previous)}{if $paginationGet}?{$paginationGet.name}={$paginationGet.value|escape}{/if}" class="{if $class}{$class}{else}pageLink{/if} prev">&lt;</a></li>
		{else} 
			<li class="prev"><a href="{$router->getFullUrl()}" class="{if $class}{$class}{else}pageLink{/if} prev">&lt;</a></li>
		{/if}
			
		<!-- First page link -->
		{if (isset($pages->previous))}
		  	<li><a href="/{$router->getUrl($paginationUrl, $pages->first)}{if $paginationGet}?{$paginationGet.name}={$paginationGet.value|escape}{/if}" class="left {if $class}{$class}{else}pageLink{/if} prevFirst">&lt;&lt;</a></li>
		{else}
			<li><a href="{$router->getFullUrl()}" class="left {if $class}{$class}{else}pageLink{/if} prevFirst">&lt;&lt;</a></li>
		{/if} 

		<!-- Numbered page links -->
		{foreach from=$pages->pagesInRange item=page}
		 	{if ($page != $pages->current)}
		    	<li><a href="/{$router->getUrl($paginationUrl, $page)}{if $paginationGet}?{$paginationGet.name}={$paginationGet.value|escape}{/if}" class="{if $class}{$class}{else}pageLink{/if}">{$page}</a></li> 
		  	{else}
		   		<li class="checked"><a href="{$router->getFullUrl()}" class="{if $class}{$class}{else}pageLink{/if}">{$page}</a></li>
		  	{/if}
		{/foreach}

		<!-- Last page link -->
		{if (isset($pages->next))}
		 	<li><a href="/{$router->getUrl($paginationUrl, $pages->last)}{if $paginationGet}?{$paginationGet.name}={$paginationGet.value|escape}{/if}" class="right {if $class}{$class}{else}pageLink{/if} nextLast">&gt;&gt;</a></li>
		{else}
			<li><a href="{$router->getFullUrl()}" class="right {if $class}{$class}{else}pageLink{/if} nextLast">&gt;&gt;</a></li>
		{/if} 
			
		<!-- Next page link --> 
		{if (isset($pages->next))}
		  	<li class="next"><a href="/{$router->getUrl($paginationUrl, $pages->next)}{if $paginationGet}?{$paginationGet.name}={$paginationGet.value|escape}{/if}" class="{if $class}{$class}{else}pageLink{/if} next">&gt;</a></li>
		{else} 
			<li class="next"><a href="{$router->getFullUrl()}" class="{if $class}{$class}{else}pageLink{/if} next">&gt;</a></li>
		{/if}
		
	</ul>
</div>
{/if}