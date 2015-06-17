<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> > Aktualności
	</div>
	<div id="content_area" class="content_field">
		<div id="text_area">
			<div class="subpage_news_section">
			{foreach item=tree name=tree from=$news_list}	
				<div class="subpage_news">
					<div class="subpage_news_image">
						<img src="{$tree._picture}" alt="{$tree._title}" />
					</div>
					<div class="subpage_news_content">
						<time>{$tree._publish}</time><br/>
						<h3><a href="/{$router->getUrl('news',$tree._code,$tree.news_id)}" class="subpage_news_title">{$tree._title}</a></h3>
						<p>{$tree._lead}</p>
						<div style="text-align: right;"><a href="/{$router->getUrl('news',$tree._code,$tree.news_id)}" class="subpage_news_readmore">{$locale.site.core.nav.more}</a></div>
					</div>
				</div>
				<div style="clear: both; margin-bottom: 50px;"></div>
			{/foreach}
			</div>
			
			<div style="clear: both;"></div>
			{include file="templates/site/pagination.tpl"}
			<div style="clear: both;"></div>
		</div>
	</div>
</div>