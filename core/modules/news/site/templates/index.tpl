<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>{$const->_page_header->_value}</h2>
            <div>{$const->_page_description->_description}</div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="row">
    <div class="container">
        <div id="breadcrumbs" class="content_field">
            <a href="/">home page</a> > blog
        </div>
        <div id="content_area" class="content_field">
            <div class="text_area">
                <div class="subpage_news_section">
                    {foreach item=tree name=tree from=$news_list}	
                        <div class="subpage_news">
                            <div class="subpage_news_image col-lg-3">
                                <img src="{$tree._picture}" alt="{$tree._title}" class="img-responsive" />
                            </div>
                            <div class="subpage_news_content col-lg-9">
                                <time>{$tree._publish}</time><br/>
                                <h3><a href="/{$router->getUrl('news',$tree._code,$tree.news_id)}" class="subpage_news_title">{$tree._title}</a></h3>
                                <div>{$tree._lead}</div>
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