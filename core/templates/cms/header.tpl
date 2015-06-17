<!DOCTYPE html>

<!--[if IEMobile 7]><html class="no-js iem7 oldie linen"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie linen" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie linen" lang="en"><![endif]-->
<!--[if (IE 9)&!(IEMobile)]><html class="no-js ie9 linen" lang="en"><![endif]-->
<!--[if (gt IE 9)|(gt IEMobile 7)]><!--><html class="no-js" lang="en"><!--<![endif]-->

<head>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CMS - Content Managment System</title>
	
	<meta name="description" content="CMS CORE">
	<meta name="author" content="Adam Majchrzak">

	<!-- http://davidbcalhoun.com/2010/viewport-metatag -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- For all browsers -->
	<link rel="stylesheet" href="/files4cms/css/reset.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/style.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/colors.css?v=1">
	<link rel="stylesheet" media="print" href="/files4cms/css/print.css?v=1">
	<!-- For progressively larger displays -->
	<link rel="stylesheet" media="only all and (min-width: 480px)" href="/files4cms/css/480.css?v=1">
	<link rel="stylesheet" media="only all and (min-width: 768px)" href="/files4cms/css/768.css?v=1">
	<link rel="stylesheet" media="only all and (min-width: 992px)" href="/files4cms/css/992.css?v=1">
	<link rel="stylesheet" media="only all and (min-width: 1200px)" href="/files4cms/css/1200.css?v=1">
	<!-- For Retina displays -->
	<link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="/files4cms/css/2x.css?v=1">

	<!-- Webfonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<!-- Additional styles -->
	<link rel="stylesheet" href="/files4cms/css/styles/agenda.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/dashboard.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/files.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/form.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/modal.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/progress-slider.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/switches.css?v=1">
	<link rel="stylesheet" href="/files4cms/css/styles/table.css?v=1">

	<!-- Google code prettifier -->
	<link rel="stylesheet" href="/files4cms/js/libs/google-code-prettify/sunburst.css?v=1">

	<!-- DataTables -->
	<link rel="stylesheet" href="/files4cms/js/libs/DataTables/jquery.dataTables.css">

	<!-- JavaScript at bottom except for Modernizr -->
	<script src="/files4cms/js/libs/modernizr.custom.js"></script>

	<!-- For Modern Browsers -->
	<link rel="shortcut icon" href="/files4cms/img/favicons/favicon.png">
	<!-- For everything else -->
	<link rel="shortcut icon" href="/files4cms/img/favicons/favicon.ico">
	<!-- For retina screens -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/files4cms/img/favicons/apple-touch-icon-retina.png">
	<!-- For iPad 1-->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/files4cms/img/favicons/apple-touch-icon-ipad.png">
	<!-- For iPhone 3G, iPod Touch and Android -->
	<link rel="apple-touch-icon-precomposed" href="/files4cms/img/favicons/apple-touch-icon.png">

	<!-- iOS web-app metas -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!-- Microsoft clear type rendering -->
	<meta http-equiv="cleartype" content="on">	
	
	
	
	{*	załadowanie plików styli  *}
	{foreach from=$head->getStyles() item=style }
	<link href="{$style.path}{$style.file}" media="{$style.media}" rel="stylesheet" type="text/css" />
	{/foreach}
	{foreach from=$head->getStylesToImport() item=style }
	{import_css module=$style.module mode=$style.mode file=$style.file}
	{/foreach}
	
	{*	załadowanie plików scryptów *}
	{foreach from=$head->getScripts() item=script }
	<script src="{$script.path}{$script.file}" type="text/javascript" ></script>
	{/foreach}

</head>
<body class="clearfix with-menu reversed">
	
	<header role="banner" id="title-bar">
		<h2>CMS ADMIN PANEL</h2>
	</header>
	
	{include file="templates/cms/sidebar.tpl"}