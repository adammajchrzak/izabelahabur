<div id="page-header-row" class="row">
    <div id="page-header" class="container">
        <div id="page-slogan">
            <h2>{$const->_page_header->_value}</h2>
            <div>{$const->_page_description->_description}</div>
        </div>
    </div>
</div>
<div id="page-picture-row" class="container-fluid">
    <div id="page-picture" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
        {foreach $slider as $item}
            <div class="item{if $item@first} active{/if}">
                <a href="{$item._link}"><img src="/files/slider/{$item._file}" alt="{$item._name} :: {$item._description|strip_tags}" style="padding: 0; margin: 0px;"/></a>
                <div class="carousel-caption">
                    <h3>{$const->_page_header->_value}</h3>
                    <p>{$const->_page_description->_description}</p>
                </div>
            </div>    
        {/foreach}    
        </div>
    </div>
</div>