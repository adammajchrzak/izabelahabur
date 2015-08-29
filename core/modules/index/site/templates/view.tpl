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
            <a href="/">home page</a> >
                {foreach $breadcrumb as $item}
                <a href="/{$router->getUrl('index',$router->getItemCode($item.page_id,$config->current_locale),$item.page_id)}">{$item.node_title}</a> {if !$item@last}>{/if} 
            {/foreach}
        </div>
        <div id="content_header">
            <h1>{$parent_page.node_title}</h1>
	</div>
        <div id="content-area">
            <div class="text-area">
                {$page_content}
            </div>
        </div>
    </div>
