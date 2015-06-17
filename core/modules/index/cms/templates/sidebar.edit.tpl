<div class="ui-widget ui-widget-content ui-corner-all sidebar-box">
	<div class="header-module">Dane podstawowe</div>
</div>
<div class="ui-widget ui-widget-content ui-corner-all sidebar-box">
	<div class="header-module">Wersja językowa</div>
	{if $config->multi_locale == '1'}
	<ul>
		{foreach from=$locale_list item=ll}
		<li><a href="/{$router->getUrl('cms','index','editnode',$page_details.page_id,{$ll.lang_code})}">{$ll.lang_name}</a></li>
		{/foreach}
	</ul>
	{/if}
</div>
<div class="ui-widget ui-widget-content ui-corner-all sidebar-box">
	<div class="header-module">Struktura serwisu</div>
	{if $config->multi_locale == '1'}
	<ul>
		{foreach from=$locale_list item=ll}
		<li>{$ll.lang_name}</li>
		{/foreach}
	</ul>
	{/if}
</div>