<div id="page-top-row" class="row">
    <div id="page-top" class="container">
        <div id="page-logo" class="col-lg-4">
            <a href="/" title="Izabela Habur Photographer :: portfolio"><img src="/img/page-logo.png" alt="Izabela Habur Photographer :: portfolio"/> <h3>HABUR IMAGES</h3></a>
        </div>
        <div id="page-menu" class="col-lg-7 text-right">
            <ul class="list-inline">
                <li>
                    <a href="javascript:;" title="">PORTFOLIO</a>
                    <ul class="submenu list-inline">
                    {foreach $submenu as $item}
                        <li><a href="/index/portfolio/{$item._code}" title="">{$item._name|upper}</a></li>
                    {/foreach}
                    </ul>
                </li>
                <li><a href="javascript:;" title="">BLOG</a></li>
                <li><a href="/{$router->getUrl('index',$router->getItemCode('1',$config->current_locale),'1')}" title="">ABOUT US</a></li>
                <li><a href="/{$router->getUrl('index',$router->getItemCode('2',$config->current_locale),'2')}" title="">CONTACT</a></li>
            </ul>
        </div>
        <div id="page-social" class="col-lg-1">
            <ul class="list-inline">
                <li><a href="javascript:;" title="Instagram Izabela Habur"><img src="/img/social/icon.instagram.png" alt="Instagram Izabela Habur" /></a></li>
                <li><a href="javascript:;" title="Twitter Izabela Habur"><img src="/img/social/icon.twitter.png" alt="Twitter Izabela Habur" /></a></li>
                <li><a href="javascript:;" title="Facebook Izabela Habur"><img src="/img/social/icon.facebook.png" alt="Facebook Izabela Habur" /></a></li>
                <li><a href="javascript:;" title="Google+ Izabela Habur"><img src="/img/social/icon.google.png" alt="Google+ Izabela Habur" /></a></li>
                <li><a href="javascript:;" title="Pinterest Izabela Habur"><img src="/img/social/icon.pinterest.png" alt="Pinterest Izabela Habur" /></a></li>
                <li><a href="javascript:;" title="Vimeo Izabela Habur"><img src="/img/social/icon.vimeo.png" alt="Vimeo Izabela Habur" /></a></li>
            </ul>
        </div>
    </div>
</div>