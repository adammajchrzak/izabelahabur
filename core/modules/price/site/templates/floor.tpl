<div id="content_wrapper">
	<div id="breadcrumbs" class="content_field">
		<a href="/"><img src="/images/layout/icon-homepage.png" alt="strona główna" /></a> > Cennik > Lokal {$item._local}
	</div>

<div class="content_field panoram">

<h1 class="font_hel_bd">Poznaj lepiej swoje przyszłe mieszkanie</h1>
	<div class="flat">
	<div class="bottom">
       <a href="/{$router->getUrl('index',$router->getItemCode('3',$config->current_locale),'3')}" class="back">Powrot do panoramy 3D</a>
       <div class="nav">
           <a href="/price/floor/{$prev_floor}" class="prev">Poprzednie</a>
           <a href="/price/floor/{$next_floor}" class="next">Nastepne</a>
       </div>
    </div>
    <div style="clear: both; margin-bottom: 100px;"></div> 
  </div>  
  <div class="col left">
  <h2>Lista mieszkań</h2>
    <ul id="flat_list">
        {foreach $locales_list as $item}
        <li>
            <a href="/price/local/{$item._index}" class="lHover" title="{$item._index}" data-target="loc{$item._index}">
                <span class="left">{$item._local}</span>
                <span class="right">{$item._area}m<sup>2</sup></span>
            </a>
        </li>

        {/foreach}
    </ul>
  </div>
  <div class="col right">
  	<img src="/files/strony/cennik/kondygnacje/k{$floor}.png" alt="kondygnacja {$floor}" usemap="#Map{$floor}" class="map"/>
  </div>
  <div style="clear: both; margin-bottom: 100px;"></div>
{if $floor == '1'}
    <map name="Map1">
      <area shape="poly" coords="40,25,155,24,156,172,135,171,134,140,37,140" href="/price/local/111" id="loc111">
      <area shape="poly" coords="38,145,130,145,130,248,39,247" href="/price/local/112" id="loc112">
      <area shape="poly" coords="38,253,130,254,130,354,40,355" href="/price/local/113" id="loc113">
      <area shape="poly" coords="38,361,135,362,136,330,155,331,154,476,39,476" href="/price/local/114" id="loc114">
      <area shape="poly" coords="162,25,226,25,227,146,299,146,298,195,228,194,227,232,163,232" href="/price/local/110" id="loc110">
      <area shape="poly" coords="161,267,256,268,255,356,227,356,226,475,160,475" href="/price/local/115" id="loc115">
      <area shape="poly" coords="304,145,347,146,347,119,421,120,420,231,347,233,347,195,305,195" href="/price/local/109" id="loc109">
      <area shape="poly" coords="314,268,420,268,420,382,346,382,345,355,313,356" href="/price/local/101" id="loc101">
      <area shape="poly" coords="425,119,467,119,468,145,517,145,516,232,425,232" href="/price/local/108" id="loc108">
      <area shape="poly" coords="426,269,515,268,517,357,468,356,469,383,426,381" href="/price/local/102" id="loc102">
      <area shape="rect" coords="522,25,589,235" href="/price/local/107" id="loc107">
      <area shape="poly" coords="592,50,618,50,618,25,661,26,661,175,612,176,613,226,593,225" href="/price/local/106" id="loc106">
      <area shape="poly" coords="667,26,729,25,724,74,749,74,743,140,716,140,710,198,737,198,731,248,619,248,618,185,667,184" href="/price/local/105" id="loc105">
      <area shape="poly" coords="522,268,586,268,586,361,636,361,636,476,522,476" href="/price/local/103" id="loc103">
      <area shape="poly" coords="595,269,625,269,625,254,730,255,726,304,700,305,693,360,718,361,712,428,685,427,682,476,641,476,643,355,594,356" href="/price/local/104" id="loc104">
    </map>
{elseif $floor == '2'}
    <map name="Map2">
      <area shape="poly" coords="56,25,168,25,169,137,26,136,27,49,56,49" href="/price/local/211" id="loc211">
      <area shape="rect" coords="26,142,145,192" href="/price/local/212" id="loc212">
      <area shape="rect" coords="26,195,145,244" href="/price/local/213" id="loc213">
      <area shape="rect" coords="25,247,144,296" href="/price/local/214" id="loc214">
      <area shape="rect" coords="25,300,145,349" href="/price/local/215" id="loc215">
      <area shape="poly" coords="26,353,169,353,169,466,55,466,55,440,26,441" href="/price/local/216" id="loc216">
      <area shape="poly" coords="175,263,267,263,267,348,239,348,239,466,174,466" href="/price/local/217" id="loc217">
      <area shape="poly" coords="175,24,239,25,238,143,309,142,309,191,239,191,239,227,175,227" href="/price/local/210" id="loc210">
      <area shape="poly" coords="323,261,429,261,428,374,354,374,355,348,323,348" href="/price/local/201" id="loc201">
      <area shape="poly" coords="432,261,522,261,522,348,475,348,475,374,432,374" href="/price/local/202" id="loc202">
      <area shape="poly" coords="527,261,592,261,592,354,639,353,639,466,527,466" href="/price/local/203" id="loc203">
      <area shape="poly" coords="596,261,627,261,627,247,706,247,700,302,726,302,713,419,687,418,683,466,644,466,644,348,597,348" href="/price/local/204" id="loc204">
      <area shape="poly" coords="668,24,730,24,725,72,751,71,738,188,713,187,707,243,621,243,622,179,668,179" href="/price/local/205" id="loc205">
      <area shape="poly" coords="596,221,616,221,616,172,664,172,664,24,621,24,621,49,596,49" href="/price/local/206" id="loc206">
      <area shape="rect" coords="526,24,592,232" href="/price/local/207" id="loc207">
      <area shape="poly" coords="314,142,350,142,350,116,428,116,428,229,350,229,350,191,314,191" href="/price/local/209" id="loc209">
      <area shape="poly" coords="432,116,476,116,475,143,522,142,523,229,432,228" href="/price/local/208" id="loc208">
    </map>
{elseif $floor == '3'}
  <map name="Map3">
      <area shape="poly" coords="56,25,168,25,169,137,26,136,27,49,56,49" href="/price/local/311" id="loc311">
      <area shape="rect" coords="26,142,145,192" href="/price/local/312" id="loc312">
      <area shape="rect" coords="26,195,145,244" href="/price/local/313" id="loc313">
      <area shape="rect" coords="25,247,144,296" href="/price/local/314" id="loc314">
      <area shape="rect" coords="25,300,145,349" href="/price/local/315" id="loc315">
      <area shape="poly" coords="26,353,169,353,169,466,55,466,55,440,26,441" href="/price/local/316" id="loc316">
      <area shape="poly" coords="175,263,267,263,267,348,239,348,239,466,174,466" href="/price/local/317" id="loc317">
      <area shape="poly" coords="175,24,239,25,238,143,309,142,309,191,239,191,239,227,175,227" href="/price/local/310" id="loc310">
      <area shape="poly" coords="323,261,429,261,428,374,354,374,355,348,323,348" href="/price/local/301" id="loc301">
      <area shape="poly" coords="432,261,522,261,522,348,475,348,475,374,432,374" href="/price/local/302" id="loc302">
      <area shape="poly" coords="527,261,592,261,592,354,639,353,639,466,527,466" href="/price/local/303" id="loc303">
      <area shape="poly" coords="596,221,616,221,616,172,664,172,664,24,621,24,621,49,596,49" href="/price/local/306" id="loc306">
      <area shape="rect" coords="526,24,592,232" href="/price/local/307" id="loc307">
      <area shape="poly" coords="314,142,350,142,350,116,428,116,428,229,350,229,350,191,314,191" href="/price/local/309" id="loc309">
      <area shape="poly" coords="432,116,476,116,475,143,522,142,523,229,432,228" href="/price/local/308" id="loc308">
      <area shape="poly" coords="668,24,730,24,725,72,750,71,744,137,718,137,712,193,737,192,732,243,621,243,621,179,668,179" href="/price/local/305" id="loc305">
      <area shape="poly" coords="597,262,628,262,627,248,731,247,726,298,700,298,695,353,719,353,714,419,688,419,683,466,644,466,644,348,597,347" href="/price/local/304" id="loc304">
  </map>
 {elseif $floor == '4'} 
  <map name="Map4">
      <area shape="poly" coords="102,9,168,8,169,120,26,119,27,32,103,32" href="/price/local/411" id="loc411">
      <area shape="rect" coords="25,124,144,174" href="/price/local/412" id="loc412">
      <area shape="rect" coords="26,178,145,227" href="/price/local/413" id="loc413">
      <area shape="rect" coords="26,230,145,279" href="/price/local/414" id="loc414">
      <area shape="rect" coords="25,281,145,330" href="/price/local/415" id="loc415">
      <area shape="poly" coords="26,336,169,336,169,449,103,448,103,424,26,424" href="/price/local/416" id="loc416">
      <area shape="poly" coords="174,246,266,246,266,331,221,331,221,423,173,423" href="/price/local/417" id="loc417">
      <area shape="poly" coords="175,33,222,33,221,126,310,126,308,173,240,174,239,211,175,211" href="/price/local/410" id="loc410">
      <area shape="poly" coords="322,246,428,246,427,359,353,359,354,333,322,333" href="/price/local/401" id="loc401">
      <area shape="poly" coords="431,244,521,244,520,310,475,309,474,357,431,357" href="/price/local/402" id="loc402">
      <area shape="poly" coords="526,245,591,245,591,338,638,337,638,423,526,423" href="/price/local/403" id="loc403">
      <area shape="rect" coords="526,32,592,214" href="/price/local/407" id="loc407">
      <area shape="poly" coords="315,126,351,126,351,100,429,100,429,213,351,213,351,175,315,175" href="/price/local/409" id="loc409">
      <area shape="poly" coords="433,100,477,100,475,145,522,145,524,213,433,212" href="/price/local/408" id="loc408">
      <area shape="poly" coords="597,34,664,32,665,155,616,155,616,204,595,204" href="/price/local/406" id="loc406">
      <area shape="poly" coords="621,226,622,163,669,162,669,33,728,32,718,125,743,125,733,226" href="/price/local/405" id="loc405">
      <area shape="poly" coords="598,245,628,245,628,230,732,230,721,331,696,331,685,423,644,424,644,331,598,331" href="/price/local/404" id="loc404">
  </map>
{elseif $floor == '5'}  
    <map name="Map5">
      <area shape="poly" coords="84,63,192,64,192,122,170,123,170,128,232,127,232,212,177,212,177,174,170,175,170,185,149,185,149,153,142,154,143,175,24,175,24,128,149,128,149,121,84,122" href="/price/local/507" id="loc507">
      <area shape="rect" coords="24,181,145,231" href="/price/local/508" id="loc508">
      <area shape="rect" coords="24,234,145,284" href="/price/local/509" id="loc509">
      <area shape="rect" coords="174,250,270,337" href="/price/local/511" id="loc511">
      <area shape="poly" coords="23,289,143,290,143,311,149,310,149,278,170,278,169,341,192,341,192,400,84,400,84,341,150,342,149,336,23,336" href="/price/local/510" id="loc510">
      <area shape="poly" coords="316,128,358,128,358,102,479,102,479,214,358,214,358,177,316,177" href="/price/local/506" id="loc506">
      <area shape="poly" coords="531,127,562,127,562,64,597,64,597,215,531,215" href="/price/local/505" id="loc505">
      <area shape="poly" coords="602,215,602,64,701,64,694,127,725,127,714,230,627,230,627,215" href="/price/local/504" id="loc504">
      <area shape="poly" coords="602,248,627,248,627,234,713,234,703,336,672,336,665,400,602,400" href="/price/local/503" id="loc503">
      <area shape="poly" coords="531,248,597,248,597,400,562,400,562,337,531,337" href="/price/local/502" id="loc502">
      <area shape="poly" coords="324,248,479,248,479,362,357,362,357,336,324,336" href="/price/local/501" id="loc501">
    </map>
{/if}
    
</div>
    <div id="tooltip">
        <div>
            <span class="arrow"></span>
            <ul class="content_text"></ul>
        </div>
    </div>
</div>

{literal}
<script>
$('.map').maphilight();

$('.lHover').mouseover(function(e) {
	$('#loc'+$(this).attr('title')).mouseover();
}).mouseout(function(e) {
	$('#loc'+$(this).attr('title')).mouseout();
});
		
</script>
{/literal}