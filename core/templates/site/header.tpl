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
    <div class="container-fluid">
            {include file="templates/site/page.main.menu.tpl"}