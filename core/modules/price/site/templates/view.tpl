<div class="content_field">
	
	<div id="price_header">
	    <h1>Sprawdź cenę swojego przyszłego mieszkania</h1>
	    
	    <p>Poniższa tabela zawiera wszelkie potrzebne informacje, aby porównać różne mieszkania w naszej ofercie.<br/>Skorzystaj z opcji filtrowania, aby szybciej znaleźć ofertę najbardziej dostosowaną do Twoich oczekiwań.</p>
    </div>
    
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
    				<select>
    					<option value="1">1 piętro</option>
    					<option value="2">2 piętro</option>
    					<option value="3">3 piętro</option>
    					<option value="4">4 piętro</option>
    					<option value="5">5 piętro</option>
    				</select>
    			</td>
    			<td>
    				<select>
    					<option value="1">1 pokój</option>
    					<option value="2">2 pokoje</option>
    					<option value="3">3 pokoje</option>
    					<option value="4">4 pokoje</option>
    				</select>
    			</td>
    			<td>
    				<select>
    					<option value="1">do 20</option>
    					<option value="2">do 30</option>
    					<option value="3">do 40</option>
    					<option value="4">do 50</option>
    					<option value="5">do 60</option>
    					<option value="6">do 70</option>
    				</select>
    			</td>
    		</tr>
    		<tr>
    			<td></td>
    			<td></td>
    			<td></td>
    			<td style="text-align: right;"><button type="button">FILTRUJ</button></td>
    		</tr>
    	</table>
    </div>
    
    <div id="price_table">
    	<table>
    		<tr>
    			<th>Nr lokalu</th>
    			<th>Piętro</th>
    			<th>Pokoje</th>
    			<th>Metraż</th>
    			<th>Antresola</th>
    			<th>Taras</th>
    			<th>Balkon</th>
    			<th>Ogród</th>
    			<th>Cena</th>
    			<th>Dostepne</th>
    			<th>Rzut</th>
    		</tr>
    		{foreach $locales_list as $item}
    		<tr {cycle values=',class="row"'}>
    			<td>{$item._local}</td>
    			<td>{$item._floor}</td>
    			<td>{$item._room}</td>
    			<td>{$item._area}m<sup>2</sup></td>
    			<td>{if $item._entresol == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td>
    			<td>{if $item._terrace == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td>
    			<td>{$item._balcony}m<sup>2</sup></td>
    			<td>{if $item._garden == '1'}<img src="/images/layout/price/icon-star.png" alt="tak" />{/if}</td>
    			<td>{if $item._available == '1'}<img src="/images/layout/price/icon-envelope.png" alt="zapytaj o cenę" /> <a href="javascript:;">Zapytaj</a>{else}niedostępny{/if}</td>
    			<td>{if $item._available == '1'}<img src="/images/layout/price/icon-yes.png" alt="mieszkanie dostępne" /> Tak{else}<img src="/images/layout/price/icon-no.png" alt="mieszkanie niedostępne" /> Nie{/if}</td>
    			<td>{if $item._file != '' && $item._available == '1'}<img src="/images/layout/price/icon-download.png" alt="pobierz rzut mieszkania" /> <a href="{$item._file}" target="_blank">Pobierz</a>{else}niedostępny{/if}</td>
    		</tr>
    		{/foreach}
    	</table>
    </div>	
</div>