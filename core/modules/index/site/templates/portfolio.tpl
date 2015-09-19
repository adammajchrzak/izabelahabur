<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>{$category._title|upper}</h2>
            <div>{$category._description|upper}</div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="row">
    <div class="container">
        <section id="portfolio-images">
            <img src="/img/portfolio/thumb-01.png" alt="CHECK OUR LATEST PRODUCTION >>" data-url="/index/portfolio/latest" class="box" id="portfolio-box1" />
            <img src="/img/portfolio/thumb-02.png" alt="FEATURED >>"  data-url="/index/portfolio/featured" class="box" id="portfolio-box2" />
        {foreach $list as $item}
            <div class="tooltips"><a href="/index/portfolio/{$item.category_code}/{$item._code}" title="{$item._name|upper}"><img src="{$item.file_dir}/medium/{$item.file_name}" alt="{$item._name|upper} >>" data-url="/index/portfolio/{$item.category_code}/{$item._code}" class="gray" style="visibility: hidden;"/></a><div class="portfolio-tooltip"><a href="/index/portfolio/{$item.category_code}/{$item._code}" title="{$item._name|upper}"><h4>{$item._name|upper} >></h4></a></div></div>
        {/foreach}
        </section>
    </div>
    <div id="portfolio-box1-tooltip" class="portfolio-box"></div>
    <div id="portfolio-box2-tooltip" class="portfolio-box"></div>
    <div class="clearfix" style="margin-bottom: 80px;"></div>
    