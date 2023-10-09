<?php

function template_print_above()
{
	global $context, $settings, $options, $txt;

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
	<head>
<meta name="description" content="', $context['topic_subject'], '" />
<meta name="robots" content="all" />
<meta name="keywords" content="xtreme, zone, linksharing, enlaces, juegos, musica, links, noticias, imagenes, videos, animaciones, arte, deportes, linux, apuntes, monografias, autos, motos, celulares, comics, tutoriales, ebooks, humor, mac, recetas, peliculas, series, chile, comunidad" />
<link rel="search" type="application/opensearchdescription+xml" title="Buscar" href="/web/casita.xml" />
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos posts" href="/rss/ultimos-post" />
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos comentarios" href="/rss/ultimos-comment" />
<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
<title>', $txt[668], ' - ', $context['topic_subject'], '</title>
<style type="text/css">
		body
			{
				color: black;
				background-color: white;
				align: center;
			}
			body, td, .normaltext
			{
				font-family: Verdana, arial, helvetica, serif;
				font-size: xx-small;
			}
			*, a:link, a:visited, a:hover, a:active
			{
				color: black !important;
			}
			table
			{
				empty-cells: show;
			}
			.code
			{
				font-size: xxx-small;
				font-family: monospace;
				border: 1px solid black;
				margin: 1px;
				padding: 1px;
			}
			.quote
			{
				font-size: xxx-small;
				border: 1px solid black;
				margin: 1px;
				padding: 1px;
			}
			.smalltext, .quoteheader, .codeheader
			{
				font-size: xxx-small;
			}
			hr
			{
				height: 1px;
				border: 0;
				color: black;
				background-color: black;
			}
		</style>';

	echo '
	</head>
	<body onload="javascript:window.print();">
	<center>	<h1 class="largetext">', $context['forum_name'], ' - ', $context['topic_subject'], '</h1>
/posts/'.$_GET['topic'].'</h2></center>
		<table width="80%" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>';
}

function template_main()
{
	global $context, $settings, $options, $txt;

	foreach ($context['posts'] as $post)
		echo '
					<br />
					<hr size="2" width="100%" />
					', $txt[196], ': <b>', $post['subject'], '</b><br />
					', $txt[197], ': <b>', $post['member'], '</b> ', $txt[176], ' <b>', $post['time'], '</b>
					<hr />
					<div style="margin: 0 5ex;">', $post['body'], '</div></center><br /><br />';
}
function template_print_below()
{

echo'<hr /><center><font size="1">&copy; 2008</font></center></td></tr></table></body></html>
';}
?>