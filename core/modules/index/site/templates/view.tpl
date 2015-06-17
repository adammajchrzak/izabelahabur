<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> >
		{foreach $breadcrumb as $item}
			<a href="/{$router->getUrl('index',$router->getItemCode($item.page_id,$config->current_locale),$item.page_id)}">{$item.node_title}</a> {if !$item@last}>{/if} 
		{/foreach}
	</div>
	<div id="content_area">
    	<div id="header_area">
        	{$page_header}
        </div>
		<div id="text_area">
			{$page_content}
		</div>
	</div>
</div>

{$page_google_map}
{$page_content_footer}
