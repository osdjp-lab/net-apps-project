<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
	<meta charset="utf-8"/>
	<title>Plant lists database interface</title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css"
		integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	<link rel="stylesheet" href="{$conf->app_url}/css/style.css">
</head>

<body style="margin: 20px;">

<div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_root}personList" class="pure-menu-heading pure-menu-link">Users</a>
	<a href="{$conf->action_root}treeList" class="pure-menu-heading pure-menu-link">Trees</a>
	<a href="{$conf->action_root}herbList" class="pure-menu-heading pure-menu-link">Herbs</a>
{if count($conf->roles)>0}
	<a href="{$conf->action_root}logout" class="pure-menu-heading pure-menu-link">Logout</a>
{else}	
	<a href="{$conf->action_root}loginShow" class="pure-menu-heading pure-menu-link">Login</a>
{/if}
</div>

{block name=top} {/block}

{block name=messages}

{if $msgs->isError()}
<div class="messages error bottom-margin">
	<ul>
	{foreach $msgs->getErrors() as $msg}
	{strip}
		<li>{$msg}</li>
	{/strip}
	{/foreach}
	</ul>
</div>
{/if}

{if $msgs->isInfo()}
<div class="messages info bottom-margin">
	<ul>
	{foreach $msgs->getInfos() as $msg}
	{strip}
		<li>{$msg}</li>
	{/strip}
	{/foreach}
	</ul>
</div>
{/if}

{/block}

{block name=bottom} {/block}

</body>

</html>
