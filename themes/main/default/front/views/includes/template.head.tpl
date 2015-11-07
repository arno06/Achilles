<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset={$configuration.global_encoding}" >
        <base href="{$configuration.server_url}"/>
		<title>{$head.title}</title>
        {if isset($content.canonical) && !empty($content.canonical)}
            <link rel="canonical" href="{$content.canonical}">
        {/if}
		<meta name="description" content="{$head.description}"/>
		<link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>
		<link type="text/css" rel="stylesheet" href="{$path_to_theme}/css/style.css">
{foreach from=$styles item=style}
		<link type="text/css" rel="stylesheet" href="{$style}">
{/foreach}
{foreach from="$scripts" item=script}
        <script type="text/javascript" src="{$script}"></script>
{/foreach}
	</head>
	<body>
	<div id="global">
		<header>
			<menu id="category">
				<li>
					<span>Categories</span>
					<ul>
						{foreach from=$content.categories item="cat"}
							<li><a href="?cat={$cat.permalink_category}">{$cat.name_category}</a></li>
						{/foreach}
					</ul>
				</li>
			</menu>
			<div id="logo">
				<a href="./">Achilles</a>
			</div>
			<menu id="auth">
			{if $user_is.USER}
				<li>
					<span class="whois"><span><img src="profil/{$content.user_data.pseudo_user}/avatar"></span>{$content.user_data.pseudo_user}</span>
					<ul>
						<li><a href="profil/{$content.user_data.pseudo_user}">Public profil</a></li>
						<li><a href="profil/{$content.user_data.pseudo_user}/edit">Edit my profil</a></li>
						<li><a href="sign-out">Sign Out</a></li>
					</ul>
				</li>
				<li><a href="submit">Submit</a></li>
				{if $user_is.ADMIN}
				<li><a href="admin">Dashboard</a></li>
				{/if}
			{else}
				<li><a href="register">Register</a></li>
				<li><a href="sign-in">Sign In</a></li>
			{/if}
			</menu>
		</header>
		<div id="content">