<a href="#" id="open-menu"><span>Menu</span></a>


<!-- Sidebar/drop-down menu -->
<section id="menu" role="complementary">

    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">

        <header>
            MENU
        </header>

        <a href="./cms" id="profile">
            <span class="name"><b>CMS</b> Admin</span>
        </a>
        <ul id="access" class="children-tooltip">
            <li></li>
            <li></li>
            <li><a href="http://www.4people.pl" title="4people.pl - agencja interaktywna"><span class="icon-user"></span></a></li>
            <li><a href="http://www.pcg.pl/{$router->getUrl('cms','auth','logout')}" title="wyloguj"><span class="icon-extract"></span></a></li>
        </ul>
        <section class="navigable" id="doc-menu">
            <ul class="big-menu">
                <li class="title-menu">Struktura serwisu</li>
                <li><a href="/{$router->getUrl('cms','index','add')}" title="Dodaj stronę">Dodaj stronę</a></li>
                <li><a href="/{$router->getUrl('cms','index','tree')}" title="Lista stron">Lista stron</a></li>
                <li class="title-menu">Moduły</li>
                <li class="with-right-arrow">
                    <span>Blog</span>
                    <ul class="big-menu">
                        <li class="title-menu">Lista wpisów</li>
                            {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','news',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                        <li class="title-menu">Kategorie</li>  
                            {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','news','category',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                    </ul>
                </li>
                <li class="with-right-arrow">
                    <span>Portfolio</span>
                    <ul class="big-menu">
                        <li class="title-menu">Lista galerii</li>
                        {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','gallery',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                        <li class="title-menu">Kategorie</li>  
                            {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','gallery','category',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                    </ul>
                </li>
                <li class="with-right-arrow">
                    <span>Slider</span>
                    <ul class="big-menu">
                        <li class="title-menu">Lista zdjęć</li>
                        {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','slider',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                    </ul>
                </li>
                <li class="with-right-arrow">
                    <span>Formularze</span>
                    <ul class="big-menu">
                        {foreach from=$locale_list item=ll}
                            <li><a href="/{$router->getUrl('cms','forms',$ll.lang_code)}">{$ll.lang_name}</a></li>
                            {/foreach}
                    </ul>
                </li>
                <li class="title-menu">Administracja</li>
                <li><a href="/{$router->getUrl('cms', 'user')}" title="Użytkownicy">Użytkownicy</a></li>
                <li><a href="/{$router->getUrl('cms', 'configuration')}" title="Konfiguracja">Konfiguracja</a></li>
            </ul>
        </section>

    </div>

</section>
<!-- End sidebar/drop-down menu -->