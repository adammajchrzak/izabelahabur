<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>{$gallery._name|upper}</h2>
            <div>{$gallery._lead|upper}</div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="row">
    <div class="container">
        <div id="sidebar-left" class="col-lg-3">
            <h4>OTHER PROJECTS  IN LIFESTYLE COLLECTION:</h4>
            <ul>
            {foreach $galleries as $item}
                <li><a href="/index/portfolio/{$category._code}/{$item._code}">{$item._name|upper}</a></li>
            {/foreach}
            </ul>
            <div class="sidebar-header-field">
                <h3><a href="/index/portfolio/latest">CHECK OUR LATEST PRODUCTION >></a></h3>
            </div>
        </div>
        <div class="col-lg-6">
            <section id="session-images">
            {foreach $list as $item}
                <a href="{$item.istock_link}sssss"><img src="{$item.file_dir}/xsmall/{$item.file_name}" alt="BUY THIS PHOTO >>>" data-url="{$item.istock_link}" class="gray"/></a>
            {/foreach}
            </section>
            <div class="clearfix"></div>
            <div id="content-area" style="margin-bottom: 80px;">
                <div class="text-area session-description">{$gallery._description|upper}</div>
            </div> 
            <div class="clearfix"></div>
        </div>
        <div id="sidebar-right" class="col-lg-3">
            <div class="sidebar-header-field">
                <h3><a href="{$gallery._link}" target="_blank">SEE ALL PHOTOS FROM THIS PHOTOSHOOT >></a></h3>
            </div>
            {if $keywords}
            <h4>RELATED KEYWORDS:</h4>
            <ul>
                {foreach $keywords as $item}
                    <li><a href="/index/portfolio/tags/{$item._keyword|lower}">{$item._name|upper}</a></li>
                {/foreach}
            </ul>
            {/if}
        </div>
    </div>
    <div id="session-tooltip"></div>