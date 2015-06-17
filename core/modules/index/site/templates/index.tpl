<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>WELCOME TO MY PORTFOLIO</h2>
            <div><p>MY NAME IS IZA HABUR I AM STOCK PHOTOGRAPHER WORKING EXCLUSIVE FOR ISTOCKPHOTOS.COM<br/>AND GETTY IMAGES.  CHECK OUR PORTFOLIO TO SEE OUR WORK</p></div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="container-fluid">
    <div id="page-picture" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
        {foreach $slider as $item}
            <div class="item{if $item@first} active{/if}">
                <img src="/files/slider/{$item._file}" alt="{$item._name} :: {$item._description|strip_tags}" style="padding: 0; margin: 0px;"/>
            </div>    
        {/foreach}    
        </div>
    </div>
</div>