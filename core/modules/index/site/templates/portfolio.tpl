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
        <section id="portfolio-images">
            <img src="/img/portfolio/thumb-01.png" alt="CHECK OUR LATEST PRODUCTION >>" data-url="http://www.onet.pl" class="box" id="portfolio-box1" />
            <img src="/img/portfolio/thumb-02.png" alt="FEATURED >>"  data-url="http://www.onet2.pl" class="box" id="portfolio-box2" />
        {foreach $list as $item}
            <img src="{$item.file_dir}/large/{$item.file_name}" alt="SHOW GALLERY >>" data-url="/index/portfolio/{$item.category_code}/{$item._code}" class="gray"/>
        {/foreach}
        </section>
    </div>
    <div id="portfolio-tooltip"></div>
    <div id="portfolio-box1-tooltip" class="portfolio-box"></div>
    <div id="portfolio-box2-tooltip" class="portfolio-box"></div>
    