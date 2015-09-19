<!DOCTYPE html>
<html lang="{$config->current_locale}">
<head>
    <meta charset="utf-8">
    <title>{$head->title}</title>
    <meta name="keywords" content="{$head->keywords}" />
    <meta name="description" content="{$head->description}" />
    {*	załadowanie plików styli  *}
    {foreach from=$head->getStyles() item=style }
            <link href="{$style.path}{$style.file}" media="{$style.media}" rel="stylesheet" type="text/css" />
    {/foreach}
	
    {*	załadowanie plików skryptów *}
    {foreach from=$head->getScripts() item=script }
        <script src="{$script.path}{$script.file}" type="text/javascript" ></script>
    {/foreach}
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    {if $head->metascripts}
            {$head->metascripts}
    {/if}
</head>
<body>
<div id="loader">
    <div class="small1">
      <div class="small ball smallball1"></div>
      <div class="small ball smallball2"></div>
      <div class="small ball smallball3"></div>
      <div class="small ball smallball4"></div>
    </div>
    <div class="small2">
      <div class="small ball smallball5"></div>
      <div class="small ball smallball6"></div>
      <div class="small ball smallball7"></div>
      <div class="small ball smallball8"></div>
    </div>
    <div class="bigcon">
      <div class="big ball"></div>
    </div>
  </div>    
    <div class="container-fluid">
            {include file="templates/site/page.main.menu.tpl"}