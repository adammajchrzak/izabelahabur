<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>WELCOME TO MY PORTFOLIO</h2>
            <div><p>MY NAME IS IZA HABUR I AM STOCK PHOTOGRAPHER WORKING EXCLUSIVE FOR ISTOCKPHOTOS.COM AND GETTY IMAGES.  CHECK OUR PORTFOLIO TO SEE OUR WORK</p></div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="row">
    <div class="container">
        <div id="breadcrumbs" class="content_field">
            <a href="/">strona główna</a> >
                {foreach $breadcrumb as $item}
                <a href="/{$router->getUrl('index',$router->getItemCode($item.page_id,$config->current_locale),$item.page_id)}">{$item.node_title}</a> {if !$item@last}>{/if} 
            {/foreach}
        </div>
        <div id="content-area">
            <div class="text-area">
                {$page_content}
            </div>
        </div>
    </div>
