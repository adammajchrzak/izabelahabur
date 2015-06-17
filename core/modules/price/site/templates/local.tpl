<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> > Cennik > Lokal {$item._local}
	</div>
	<div id="content_area" class="content_field">
		<div id="text_area">
			<div class="content_field panoram">
                 <h1 class="font_hel_bd">Mieszkanie {$item._local}</h1>
                 <div class="flat">
                    <div class="bottom">
                       <a href="/price/floor/{$item._floor}" class="back">Powrot do panoramy 3D</a>
                       <div class="nav">
                           <a href="/price/local/{$pn_local.prev}" class="prev">Poprzednie</a>
                           <a href="/price/local/{$pn_local.next}" class="next">Nastepne</a>
                       </div>
                    </div>
                    
                    <h2>{$item._floor} piętro, {$item._room} pokoje</h2>
                    <div class="col left">
                        <img src="/files/strony/cennik/mieszkania/k{$item._floor}/{$item._local}/rzut.png" alt="" />
                    </div>
                    <div class="col right">
                        <p class="meters">Powierzchnia <span>{$item._area}m<sup>2</sup></span></p>
                        <ul>
                        {foreach $rooms as $room}
                             <li><p>{$room._name}:  <span>{$room._value} m<sup>2</sup></span></p></li>
                        {/foreach}
                      </ul>
                        <div class="plan">
                            <a href="/price/floor/{$item._floor}"><img src="/files/strony/cennik/mieszkania/k{$item._floor}/{$item._local}/lokalizacja.png" alt="" /></a>
                        </div>
                    </div>
                    <div class="bottom">
                        <a href="{$item._file}" class="button">
                            Pobierz kartę katalogową
                        </a>
                        <div id="subpage_location_afp_form" class="wideForm">
                            <form novalidate id="contactForm" action="/forms/price" method="post">
                                <fieldset>
                                    <h4 class="font_hel_lt">Zapytaj o cenę</h4>
                                    <div class="formsk"><input name="fullname" data-rule-required="true" placeholder="Wpisz jak się nazywasz" type="text"></div>
                                    <div class="formsk"> <input name="phone" data-rule-required="true" data-rule-digits="true" placeholder="Na przykład 785888148" type="text"></div>
                                    <div class="formsk"><input name="formEmail" data-rule-email="true" data-rule-required="true" placeholder="Wpisz swój adres e-mail" type="text"></div><br>
                                    <input name="room" type="hidden" value="{$item._local}" />
                                    <div id="formAgreements">
                                        <input name="commercial" value="Nie" type="hidden"><input data-rule-required="true" name="commercial" value="Tak" type="checkbox">
                                    </div>
                                    <p>Wyrażam zgodę na otrzymanie informacji handlowych
                                        oraz przetwarzania moich danych osobowych w celach
                                        marketingowych, na zasadach określonych w regulaminie.</p>
                                    <button type="submit">WYŚLIJ</button>
                                </fieldset>
                            </form>
                            <div id="formThankyouHP" style="width: 100%;height: auto;top: 10px;padding-top: 80px;padding-bottom: 80px;">Dziękujemy za wypełnienie<br>formularza kontaktowego!</div>
                        </div>
                    </div>
                </div>
                 
                 
                 
             </div>
        </div>
     </div>
</div>