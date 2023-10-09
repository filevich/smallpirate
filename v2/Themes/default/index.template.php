<?php
function template_init()
{	global $context, $settings, $options, $txt;
	$settings['use_default_images'] = 'never';
    $settings['doctype'] = 'xhtml';
	$settings['theme_version'] = '1.2';
	$settings['use_tabs'] = true;
	$settings['use_buttons'] = true;
	$settings['seperate_sticky_lock'] = true;
}
function template_main_above()
{
global $context, $settings, $options, $scripturl, $txt, $modSettings, $slogan;
require("SSI.php");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
<head><meta name="verify-v1" content="HTXLHK/cBp/LYfs9+fLwj1UOxfq+/iFsv1DZjB6zWZU=" />
<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
<meta name="description" content="', $slogan, '" />
<meta name="robots" content="all" />
<meta name="keywords" content="spirate, linksharing, enlaces, juegos, musica, links, noticias, imagenes, videos, animaciones, arte, deportes, linux, apuntes, monografias, autos, motos, celulares, comics, tutoriales, ebooks, humor, mac, recetas, peliculas, series, chile, comunidad" />
<link rel="search" type="application/opensearchdescription+xml" title="" href="/web/agregar.xml" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title>', $context['forum_name'], ' - ', $slogan, '</title>
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos posts" href="/rss/ultimos-post" />
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos comentarios" href="/rss/ultimos-comment" />
<link rel="stylesheet" type="text/css" href="/Themes/default/estilo-ez-1.0.css" />
<script type="text/javascript" src="/Themes/default/acciones-ez-1.0.js"></script>
</head><body>';
echo '<b class="rtop"><b class="rtop1"><b></b></b><b class="rtop2"><b></b></b><b class="rtop3"></b><b class="rtop4"></b><b class="rtop5"></b></b><div id="maincontainer">
	<table id="widthControl" style="background-color: #F4F4F4;" border="0" cellpadding="0" cellspacing="0">
	<td width="100%" valign="top" style="padding:0;">
	<div id="head">
	<div id="logo"><a href="/" title="', $context['forum_name'] . ' " id="logoi"><img src="/Themes/default/images/espacio.gif" alt="', $context['forum_name'] . ' - '. $slogan .'" title="', $context['forum_name'] . ' - Reduciendo tu productividad" align="top" border="0"></a></div>
</div><div class="header2"><br></div><div align="center" style="margin:0px; padding: 0px;"><style>.boxExt{ position:relative;}.boxInt{ position:absolute; top:20px; width:332px; height:171px; background: url(\'/Themes/default/images/fondo-login.gif\') no-repeat; display:none;}
input.ilogin {width: 125px;}</style><script>function mostrar(que){$(que).fadeIn("slow");}function ocultar(que){$(que).fadeOut("slow");}</script><form action="/?action=login2" method="post" accept-charset="ISO-8859-1" name="frmLogin" id="frmLogin" onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"><div id="menu-top" class="curvas" style="margin-bottom:8px;"></form><div style="margin-right:130px;float:left;padding-left:5px;">', template_menu(), '';

}

function template_main_below()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '</div>';

	echo'<div id="pie"><center><font size="1"><font color="#FFFFFF">&copy; 2009 </font> <a href="/">
<span style="text-decoration: none"><font color="#FFFFFF">P&aacute;gina Principal</font></span></a><font color="#FFFFFF"> | 
</font><a href="/?action=protocolo">
<span style="text-decoration: none"><font color="#FFFFFF">Protocolo</font></span></a><font color="#FFFFFF"> | 
</font><a href="/?action=widget">
<span style="text-decoration: none"><font color="#FFFFFF">Widget</font></span></a><font color="#FFFFFF"> | 
</font><a href="/?action=enlazanos">
<span style="text-decoration: none"><font color="#FFFFFF">Enl&aacute;zanos</font></span></a><font color="#FFFFFF"> | 
</font><a href="/?action=contactenos">
<span style="text-decoration: none"><font color="#FFFFFF">Contactar</font></span></a><font color="#FFFFFF"> | 
</font><a href="/?action=mapadelsitio">
<span style="text-decoration: none"><font color="#FFFFFF">Mapa del sitio</font></span></a><font color="#FFFFFF"> | 
</font><a href="http://www.spirate.net/">
<span style="text-decoration: none"><font color="#FFFFFF">Basado en Spirate</font></font></span></a></center></div>
</td></table></div><b class="rbott"><b class="rbott5"></b><b class="rbott4"></b><b class="rbott3"></b><b class="rbott2"><b></b></b><b class="rbott1"><b></b></b></b>';

	echo '
	<div id="ajax_in_progress" style="display: none;', $context['browser']['is_ie'] && !$context['browser']['is_ie7'] ? 'position: absolute;' : '', '">', $txt['ajax_in_progress'], '</div></body></html>';
}

function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '';
	if ($context['user']['is_guest'])
		echo '<a href="/" title="Inicio">Inicio</a> <font color="#FFFFFF">-</font> <a href="/?action=search" title="Buscador">Buscador</a> <font color="#FFFFFF">-</font> <a href="index.php?action=rz;m=4674868" title="Chat">Chat</a> <font color="#FFFFFF">-</font> <a href="/?action=login" title="' , $txt[34] , '">' , $txt[34] , '</a>  <font color="#FFFFFF">-</font> <a href="/?action=registrarse" title="Registrate!"><b>Registrate!</b></a></span></div>
<div id="iniciars" style="margin-right:200px; float: left;">
<div class="boxExt"><div class="boxInt"><div align="right" style="padding-top:10px;margin-right:3px;" onclick="ocultar(this.parentNode)"><img src="/Themes/default/images/eliminar.gif"></div>
<div style="float:left; width:115px; height:22px;text-align:right;"">Nombre de usuario:</div>
<div style="float:left; width:170px; height:25px; padding-left:1px;"> 
<input size="30" maxlength="64" style="font-size:10px;" id="user" name="user" class="ilogin" type="text">
</div>
<div style="float:left; width:115px; height:22px; text-align:right;">Contrase&ntilde;a:</div>
<div style="float:left; width:170px; height:25px; padding-left:1px;"> 
<input size="30" maxlength="64" style="font-size: 10px;" id="passwrd" name="passwrd" class="ilogin" type="password">
</div>
<div style="padding-top:5px;" align="center"> 
<input class="login" style="font-size: 10px;" size="50" value="Iniciar sesi&oacute;n" title="Iniciar sesi&oacute;n" type="submit">
</div>
<hr width=95%">
<div style="padding-top:5px;" align="center"> 
<a href="/index.php?action=reminder" style="font-weight:bold; color: #000;">&iquest;Olvidaste tu contrase&ntilde;a?</a>
</div>
<div style="padding-top:5px;" align="center">
	&iquest;Todavia no estas registrado? <a href="/?action=registrarse" style="font-weight:bold;color:#FF0000;">Registrate Ahora!</a>
</div> </div><a href="#" onclick="mostrar(this.previousSibling)">Iniciar Sesi&oacute;n</a></div></div>';

	if ($context['user']['is_guest'])		
{		echo '<div id="categorias" style="float:left;margin-bottom:5px;">';  ssi_categorias(); echo'</div></form></div></div>';}

	if ($context['user']['is_logged'])
		{echo '<a href="/" title="Inicio">Inicio</a> <font color="#FFFFFF">-</font> <a href="/?action=search" title="Buscador">Buscador</a>  <font color="#FFFFFF">-</font> <a href="/?action=rz;m=4674868" title="Chat">Chat</a> <font color="#FFFFFF">-</font> <a href="?action=TOPs" title="TOPs">TOPs</a> <font color="#FFFFFF">-</font> <a href="?action=post;board=4" title="Publicar"><b>Publicar</b></a></div><div id="menu-user" style="margin-right:130px; float: left; #padding-top:5px;">'; 
				
				if($context['user']['unread_messages']){
				echo'<a class="icons mp-nuevo" href="?action=pm" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a>
				 <a href="?action=pm" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo">', $context['user']['unread_messages'] > 0 ? '<font class="size9" color="#FFFFFF"><b>('. $context['user']['unread_messages'].')</b></font>' : '' , '</a>';}
				 else
				  echo'<a class="icons mp" href="?action=pm" title="Mensajes Privados" alt="Mensajes Privados"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a>';echo'
					<font color="#FFFFFF">|</font> 
					<a class="icons fot" href="/?action=imagenes&usuario=', $context['user']['name'] , '" title="Mi galer&iacute;a"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a> 
					<font color="#FFFFFF">|</font>
					
					<a class="icons fav2" width="18px" href="/?action=favoritos" title="Mis Favoritos"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a> 
					<font color="#FFFFFF">|</font>  
					<a class="icons cuenta" href="?action=profile" title="Mi cuenta" alt="Mi cuenta"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a>
					<font color="#FFFFFF">|</font> 	';
		if ($context['allow_admin'])
echo'					<a class="icons admin" href="/?action=admin"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a>
					<font color="#FFFFFF">|</font> 	';
echo'	<a href="/?action=profile" title="Mi Perfil">', $context['user']['name'] , '</a> <font color="#FFFFFF">[<a href="/?action=logout;sesc=', $context['session_id'], '">X</a>]</font>   <a class="icons his-mod" href="/?action=hist-mod" title="Historial de moderaci&oacute;n"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a></div>';
		}

	if ($context['user']['is_logged'])		
{		echo '<div id="categorias" style="float:left;margin-bottom:5px;">';  ssi_categorias(); echo'</div></form></div></div>';}
	echo '<div id="bodyarea"><div align="center"><script type="text/javascript">
function postab(id){
document.getElementById(id).style.display = \'inline\';
document.getElementById(\'masinfo\'+id).style.display = \'none\';
document.getElementById(\'cerrarinfo\'+id).style.display = \'inline\';}
function cerrarpost(id){
document.getElementById(id).style.display=\'none\';
document.getElementById(\'cerrarinfo\'+id).style.display = \'none\';
document.getElementById(\'masinfo\'+id).style.display = \'inline\';}
function errorrojos(search){if(search == \'\'){document.getElementById(\'errorss\').innerHTML=\'<font class="size10" style="color: red;">Es necesario escribir una palabra para buscar.</font>\'; return false;}}</script>

';

}


function template_button_strip(){}
function theme_linktree2(){}
function theme_linktree3(){}
function theme_newestlink(){}
function theme_linktree(){}
?>