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
            <a href="/">home page</a> > <a href="/news">blog</a>
        </div>
        <div id="content_area" class="content_field">
            <div class="text_area">
                <div class="subpage_news_details">
                    <time>{$news_details._publish}</time>
                    <h1>{$news_details._title}</h1>
                    <img src="{$news_details._picture}" alt="{$news_details._title}" class="img-responsive" style="float: left; margin-right: 50px;" />
                    <div class="subpage_news_content">    
                        {$news_details._content}
                    </div>    
                    <div class="news-back" style="clear: both;"><a href="javascript:history.back();">{$locale.site.core.nav.back}</a></div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
