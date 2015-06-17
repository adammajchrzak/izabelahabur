<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> > <a href="/news">Aktualności</a>
	</div>
	<div id="content_area" class="content_field">
		<div id="text_area">
			<div class="subpage_news_details">
				<time>{$news_details._publish}</time>
				<h1>{$news_details._title}<span></span></h1>
				<img src="{$news_details._picture}" alt="{$news_details._title}" style="width: 680px; height: 383px; display: block; margin-bottom: 50px;" />

				{$news_details._content}
				
				{if $news_details.gallery_details}
				<div class="page-gallery">
					<ul class="gallery_images">
					{foreach from=$news_details.picture_list item=pl name=pl}
						<li><div style="background-image: url({$pl.file_dir}/small/{$pl.file_name});"><a href="{$pl.file_dir}/big/{$pl.file_name}" rel="colorbox" title="{$pl.picture_description}">zdjęcie: {$pl.picture_description}</a></div></li>
					{/foreach}
					</ul>
				</div>
				{/if}
				
				<div class="news-back" style="clear: both;"><a href="javascript:history.back();">Powrót do listy aktualności</a></div>
			</div>
			<div class="sidebar_news_list">
				<h2>Pozostałe aktualności</h2>
				
				<ul>
			    	{foreach $news_list as $items}
			        <li>
			        	<time>{$items._publish}</time>
			            <a class="header" href="/{$router->getUrl('news',$items._code,$items.news_id)}"><h3>{$items._title}</h3></a>
			            <p class="content">{$items._lead}</p>
			            <p class="link"><a href="/{$router->getUrl('news',$items._code,$items.news_id)}">Czytaj więcej &gt;</a></p>
			        </li>
			        {/foreach}
			    </ul>
				
			</div>
		</div>
	</div>
	
	<div style="clear: both; border-top: 1px solid #dfdfdf;"></div>
	{$page_content}
	
	<div style="clear: both;"></div>
</div>
