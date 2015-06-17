<div class="ui-widget ui-widget-content ui-corner-all"  style="margin: 10px; padding: 15px;">
	<div class="header-module">Lista błędów systemu</div>
	{foreach item=list name=list from=$alerts_list}
		<div class="list-row">
			<div style="width: 200px;">{$list.log_date}</div>
			<div style="width: 200px;">{$list.log_ip}</div>
			<div style="width: 150px;">{$list.log}</div>
		</div>
	{/foreach}
</div>