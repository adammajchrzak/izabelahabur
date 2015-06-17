<div class="frame" id="news">
    <h2>{$locale.site.index.main.news_header}</h2>
    <ul>
    	{foreach $news_list as $items}
        <li>
            <a class="header" href="/{$router->getUrl('news',$items._code,$items.news_id)}"><h3>{$items._title}</h3></a>
            <p class="content">{$items._lead}</p>
            <a class="link" href="/{$router->getUrl('news',$items._code,$items.news_id)}">{$locale.site.index.main.news_read}</a>
        </li>
        {/foreach}
    </ul>
</div>