<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> > Cennik
	</div>
	<div id="content_area" class="content_field">
		<div id="text_area">
			<div class="content_field">
	
				<div id="price_header">
				    <h1>Sprawdź cenę swojego przyszłego mieszkania</h1>
				    
				    <p>Poniższa tabela zawiera wszelkie potrzebne informacje, aby porównać różne mieszkania w naszej ofercie.<br/>Skorzystaj z opcji filtrowania, aby szybciej znaleźć ofertę najbardziej dostosowaną do Twoich oczekiwań.</p>
			    </div>
			    <form action="" method="post">
			    <div id="price_search">
			    	<table>
			    		<tr>
			    			<th></th>
			    			<th>Numer piętra</th>
			    			<th>Liczba pokoi</th>
			    			<th>Metraż (m<sup>2</sup>)</th>
			    		</tr>
			    		<tr>
			    			<td><h3>FILTRUJ WYNIKI TABELI</h3></td>
			    			<td>
			    				<select id="floorId" name="floorId">
			    					<option value="0"{if $search['floorId'] == '0'} selected{/if}>pokaż wszystko</option>
			    					<option value="1"{if $search['floorId'] == '1'} selected{/if}>1 piętro</option>
			    					<option value="2"{if $search['floorId'] == '2'} selected{/if}>2 piętro</option>
			    					<option value="3"{if $search['floorId'] == '3'} selected{/if}>3 piętro</option>
			    					<option value="4"{if $search['floorId'] == '4'} selected{/if}>4 piętro</option>
			    					<option value="5"{if $search['floorId'] == '5'} selected{/if}>5 piętro</option>
			    				</select>
			    			</td>
			    			<td>
			    				<select id="roomId" name="roomId">
			    					<option value="0"{if $search['roomId'] == '0'} selected{/if}>pokaż wszystko</option>
			    					<option value="1"{if $search['roomId'] == '1'} selected{/if}>1 pokój</option>
			    					<option value="2"{if $search['roomId'] == '2'} selected{/if}>2 pokoje</option>
			    					<option value="3"{if $search['roomId'] == '3'} selected{/if}>3 pokoje</option>
			    					<option value="4"{if $search['roomId'] == '4'} selected{/if}>4 pokoje</option>
			    				</select>
			    			</td>
			    			<td>
			    				<select id="areaId" name="areaId">
			    					<option value="0"{if $search['areaId'] == '0'} selected{/if}>pokaż wszystko</option>
			    					<option value="1"{if $search['areaId'] == '20'} selected{/if}>do 20</option>
			    					<option value="2"{if $search['areaId'] == '30'} selected{/if}>do 30</option>
			    					<option value="3"{if $search['areaId'] == '40'} selected{/if}>do 40</option>
			    					<option value="4"{if $search['areaId'] == '50'} selected{/if}>do 50</option>
			    					<option value="5"{if $search['areaId'] == '60'} selected{/if}>do 60</option>
			    					<option value="6"{if $search['areaId'] == '70'} selected{/if}>do 70</option>
			    				</select>
			    			</td>
			    		</tr>
			    		<tr>
			    			<td></td>
			    			<td></td>
			    			<td></td>
			    			<td style="text-align: right;"><button type="submit">FILTRUJ</button></td>
			    		</tr>
			    	</table>
			    </div>
			    </form>
			    
			    <div id="price_table">
			    	<table>
			    		<tr>
			    			<th>Nr lokalu</th>
			    			<th>Piętro</th>
			    			<th>Pokoje</th>
			    			<th>Metraż</th>
			    			{*<th>Antresola</th>
			    			<th>Taras</th>
                            <th>Ogród</th>*}
			    			<th>Balkon</th>
			    			<th>Cena</th>
			    			<th>Dostepne</th>
			    			<th>Rzut</th>
                            <th>Miesięczna<br/>rata kredytu</th>
			    		</tr>
			    		{foreach $locales_list as $item}
			    		<tr {cycle values=',class="row"'}>
			    			<td><a href="/price/local/{$item._index}">{$item._local}</a></td>
			    			<td><a href="/price/floor/{$item._floor}">{$item._floor}</a></td>
			    			<td>{$item._room}</td>
			    			<td>{$item._area}m<sup>2</sup></td>
			    			{*<td>{if $item._entresol == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td>
			    			<td>{if $item._terrace == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td>
                            <td>{if $item._garden == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td> *}
			    			<td>{$item._balcony}m<sup>2</sup></td>
			    			<td>{if $item._available == '1'}<img src="/images/layout/price/icon-envelope.png" alt="zapytaj o cenę" /> <a href="#zapytaj" class="askPrice" data-room="{$item._local}">Zapytaj</a>{else}niedostępny{/if}</td>
			    			<td>{if $item._available == '1'}<img src="/images/layout/price/icon-yes.png" alt="mieszkanie dostępne" /> Tak{else}<img src="/images/layout/price/icon-no.png" alt="mieszkanie niedostępne" /> Nie{/if}</td>
			    			<td>{if $item._file != '' && $item._available == '1'}<img src="/images/layout/price/icon-download.png" alt="pobierz rzut mieszkania" /> <a href="{$item._file}" target="_blank">Pobierz</a>{else}niedostępny{/if}</td>
                            <td>{number_format($item._credit, 2, '.', ' ')} zł</td>
			    		</tr>
			    		{/foreach}
			    	</table>
			    </div>
                            <div id="subpage_location_afp_form" class="pricesForm">
                                <form novalidate id="contactForm" action="/forms/price" method="post">
                                    <fieldset>
                                        <h4 class="font_hel_lt">Zapytaj o cenę</h4>
                                        <input name="fullname" data-rule-required="true" placeholder="Wpisz jak się nazywasz" type="text">
                                        <input name="phone" data-rule-required="true" data-rule-digits="true" placeholder="Na przykład 785888148" type="text">
                                        <input name="formEmail" data-rule-email="true" data-rule-required="true" placeholder="Wpisz swój adres e-mail" type="text"><br>
                                        <input name="room" type="hidden" value="{$item._local}" />
                                        <div id="formAgreements">
                                            <input name="commercial" value="Nie" type="hidden"><input data-rule-required="true" name="commercial" value="Tak" type="checkbox">
                                        </div>
                                        <p>Wyrażam zgodę na otrzymanie informacji handlowych<br>
                                            oraz przetwarzania moich danych osobowych w celach<br>
                                            marketingowych, na zasadach określonych w regulaminie.</p>
                                        <button type="submit">WYŚLIJ</button>
                                    </fieldset>
                                </form>
                                <div id="formThankyouHP">Dziękujemy za wypełnienie<br>formularza kontaktowego!</div>
                            </div>
			</div>
		</div>
	</div>
</div>
                                        
{literal}
    <script type="text/javascript">
            var validator = $("#contactForm").validate({
                errorPlacement: function(error, element) {
                    error.insertBefore(element);
                },
                submitHandler: function() {
                    $.post('/forms/price', $('#contactForm').serialize(), function(data) {
                        /* _gaq.push(['_trackPageview', '/wyslanyFormularz.html']); */
                        $("#contactForm").fadeOut(500);
                        setTimeout(function() {
                            $('#formThankyouHP').fadeIn(500);
                        }, 500);
                    }, "html")
                            .fail(function() {
                    })
                            .always(function() {
                    });
                }
            });
            
            $(".askPrice").click(function(){
                $("#subpage_location_afp_form.pricesForm form input[name=room]").val($(this).data("room"));
                $("#subpage_location_afp_form.pricesForm").css({
                    "top" : $(window).scrollTop()
                }).fadeIn(500);
                return false;
            });

            $.fn.isChildOf = function(arg){
                return(this.parents(arg).length > 0);
            };

            $("body").click(function(e){
                if(!$(e.target).attr("id")==="subpage_location_afp_form" || !$(e.target).isChildOf("#subpage_location_afp_form.pricesForm")){
                    $("#subpage_location_afp_form.pricesForm").fadeOut(500).find("input[type=text]").val("");
                    $("#subpage_location_afp_form.pricesForm").find("input[type=checkbox]").removeAttr("checked");
                    validator.resetForm();
                }
            });
    </script>
{/literal}