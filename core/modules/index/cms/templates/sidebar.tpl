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