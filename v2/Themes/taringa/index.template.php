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
global $context, $settings, $options, $scripturl, $txt, $modSettings;
require("SSI.php");
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" ><head>
<!--Taringa Theme v0.3 by Phobos91-->
<meta name="verify-v1" content="HTXLHK/cBp/LYfs9+fLwj1UOxfq+/iFsv1DZjB6zWZU=" />
<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
<meta name="description" content="', $context['page_title'], '" />
<meta name="robots" content="all" />
<meta name="keywords" content="linksharing, enlaces, juegos, musica, links, noticias, imagenes, videos, animaciones, arte, deportes, linux, apuntes, monografias, autos, motos, celulares, comics, tutoriales, ebooks, humor, mac, phobos91, recetas, peliculas, series, argentina, comunidad, celular, java, symbian" />
<link rel="search" type="application/opensearchdescription+xml" title="" href="/web/agregar.xml" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title>', $context['forum_name'], ' - ', $context['page_title'], '</title>
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos posts" href="/web/rss/rss-ultimos-post.php" />
<link rel="alternate" type="application/atom+xml" title="&Uacute;ltimos comentarios" href="/web/rss/rss-comment.php" />
<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/estilos.css" />
<script type="text/javascript" src="', $settings['default_theme_url'], '/acciones-ez-1.0.js"></script>
<script type="text/javascript" src="', $settings['default_theme_url'], '/script.js"></script>
</head><body>';
echo '<b class="rtop"><b class="rtop1"><b></b></b><b class="rtop2"><b></b></b><b class="rtop3"></b><b class="rtop4"></b><b class="rtop5"></b></b>
<div id="maincontainer">
	<table id="widthControl" style="background-color: #FFFFFF;" border="0" cellpadding="0" cellspacing="0">
	<td width="100%" valign="top" style="padding:0;">
	<div id="head">
	<div id="logo"><a href="', $scripturl, '" title="', $context['forum_name'] . ' " id="logoi"><img src="', $settings['images_url'], '/espacio.gif" alt="', $context['forum_name'] . ' - ', $context['page_title'], '" title="', $context['forum_name'] . ' - ', $context['page_title'], '" align="top" border="0"></a></div>
</div><div class="header2" align="center" style="margin:0px; padding: 0px;"><div id="menu-top" style="margin: 0px; padding: 0px;">', template_menu(), '';

}

function template_main_below()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '</div></table>';

	echo'<div id="pie">
	<center><font size="1"><font color="#FFFFFF">&copy; 2009 </font> <a href="', $scripturl, '">
<span style="text-decoration: none"><font color="#FFFFFF">', $context['forum_name'], '</font></span></a>
<font color="#FFFFFF"> - </font><a href="', $scripturl, '?action=protocolo"><span style="text-decoration: none"><font color="#FFFFFF">Protocolo</font></span></a>
<font color="#FFFFFF"> - </font><a href="', $scripturl, '?action=enlazanos"><span style="text-decoration: none"><font color="#FFFFFF">Enlazanos</font></span></a>
<font color="#FFFFFF"> - </font><a href="', $scripturl, '?action=mapadelsitio"><span style="text-decoration: none"><font color="#FFFFFF">Mapa del sitio</font></span></a>
<font color="#FFFFFF"> - </font><a href="', $scripturl, '?action=widget"><span style="text-decoration: none"><font color="#FFFFFF">Widget</font></span></a>
<font color="#FFFFFF"> - </font><a href="', $scripturl, '?action=about"><span style="text-decoration: none"><font color="#FFFFFF">About</font></span></a>
<!-- No modificar ni eliminar este aviso -->
<br>
<font color="#FFFFFF">Powered by </font>
<a href="http://www.simplemachines.org"><span style="text-decoration: none"><font color="#FFFFFF">SMF</font></span></a>
<font color="#FFFFFF">& </font>
<a href="http://spirate.net"><span style="text-decoration: none"><font color="#FFFFFF">Spirate</font></span></a>
<font color="#FFFFFF"> - </font><font color="#FFFFFF">Theme by </font>
<a href="mailto:phobos91s@gmail.com"><span style="text-decoration: none"><font color="#FFFFFF">Phobos91</font></span></a>
<!-- Fin del del aviso -->
</center></div></td>
</div>
<b class="rbott"><b class="rbott5"></b><b class="rbott4"></b><b class="rbott3"></b><b class="rbott2"><b></b></b><b class="rbott1"><b></b></b></b>';

	echo '
	<div id="ajax_in_progress" style="display: none;', $context['browser']['is_ie'] && !$context['browser']['is_ie7'] ? 'position: absolute;' : '', '">', $txt['ajax_in_progress'], '</div></body></html>';
}

function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '';
	if ($context['user']['is_guest'])
		echo '<span class="menu_izq"><a href="', $scripturl, '" title="Inicio">Inicio</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=search" title="Buscador">Buscador</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=rz;m=4674868" title="Chat">Chat</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=login" title="' , $txt[34] , '">' , $txt[34] , '</a>  <font color="#999999">-</font> <a href="', $scripturl, '?action=registrarse" title="Registrate!"><b>Registrate!</b></a></span>

<span class="menu_centro"><div id="iniciars" style="margin-right:0px; float: left;">
<style>
.boxExt{ position:relative;}
.boxInt{ position:absolute; top:20px; width:332px; height:171px; background: url(\'', $settings['images_url'], '/fondo-login.gif\') no-repeat; display:none;}
input.ilogin {width: 125px;}
</style>
<script>
function mostrar(que){
   $(que).fadeIn("slow");
}
function ocultar(que){
    $(que).fadeOut("slow");
}
</script>
<form action="', $scripturl, '?action=login2" method="post" accept-charset="ISO-8859-1" name="frmLogin" id="frmLogin" onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');">
<div class="boxExt"><div class="boxInt"><div align="right" style="padding-top:2px;margin-right:3px;" onclick="ocultar(this.parentNode)"><img src="', $settings['images_url'], '/eliminar.gif"></div>
<div style="padding-top:5px;" align="center">
<div style="float:left; width:115px; height:22px;text-align:right;"">Nombre de usuario:</div>
<div style="float:left; width:170px; height:25px; padding-left:1px;">
<input size="30" maxlength="64" style="font-size:10px;" id="user" name="user" class="ilogin" type="text">
</div>
<div style="float:left; width:115px; height:22px; text-align:right;"><b>Contrase&ntilde;a:</b></div>
<div style="float:left; width:170px; height:25px; padding-left:1px;"> 
<input size="30" maxlength="64" style="font-size: 10px;" id="passwrd" name="passwrd" class="ilogin" type="password">
</div>
<input class="login" style="font-size: 10px;" size="50" value="Iniciar sesi&oacute;n" title="Iniciar sesi&oacute;n" type="submit">
</div><hr width=95%">
<div style="text-align:center;line-height:190%;>
<a href="', $scripturl, '?action=reminder" style="font-weight:bold; color: #000;"><b>&iquest;Olvidaste tu contrase&ntilde;a?</b></a>
<br>
<font color="#000000">&iquest;Todavia no estas registrado?</font> <a href="', $scripturl, '?action=registrarse" style="font-weight:bold;color:#FF0000;">Registrate Ahora!</a>
</div></div><a class="iniciar_sesion" title="Iniciar Sesi&oacute;n" onclick="mostrar(this.previousSibling)" href="#"><b>Iniciar Sesi&oacute;n</b></a></div></div></form></span>';

	if ($context['user']['is_guest'])		
{		echo '<span class="menu_der"><div id="categorias" style="float:left;margin-bottom:5px;">';  ssi_categorias(); echo'</span></div></div>';}

	if ($context['user']['is_logged'])
		{echo '<span class="menu_izq"><a href="', $scripturl, '" title="Inicio">Inicio</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=search" title="Buscador">Buscador</a>  <font color="#999999">-</font> <a href="', $scripturl, '?action=rz;m=4674868" title="Chat">Chat</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=TOPs" title="TOPs">TOPs</a> <font color="#999999">-</font> <a href="', $scripturl, '?action=post" title="Publicar"><b>Publicar</b></a></span>'; 
				
				if($context['user']['unread_messages']){
				echo'<span class="menu_centro"><a class="icons mp-nuevo" href="', $scripturl, '?action=pm" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
				 <a href="/mensajes/" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo">', $context['user']['unread_messages'] > 0 ? '<font class="size9" color="#FFFFFF"><b>('. $context['user']['unread_messages'].')</b></font>' : '' , '</a>';}
				 else
				  echo'<span class="menu_centro"><a class="icons mp" href="', $scripturl, '?action=pm" title="Mensajes Privados" alt="Mensajes Privados"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>';echo'
					<font color="#999999">|</font> 
					<a class="icons fot" href="', $scripturl, '?action=imagenes&usuario=', $context['user']['name'] , '" title="Mi galer&iacute;a"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a> 
					<font color="#999999">|</font>
					
					<a class="icons fav2" width="18px" href="', $scripturl, '?action=favoritos" title="Mis Favoritos"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a> 
					<font color="#999999">|</font>  
					<a class="icons cuenta" href="', $scripturl, '?action=profile" title="Mi cuenta" alt="Mi cuenta"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
					<font color="#999999">|</font> 	';
		if ($context['allow_admin'])
echo'					<a class="icons admin" href="', $scripturl, '?action=admin"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
					<font color="#999999">|</font> 	';
echo'	<a href="', $scripturl, '?action=profile" title="Mi Perfil">', $context['user']['name'] , '</a> <font color="#999999">[<a href="', $scripturl, '?action=logout;sesc=', $context['session_id'], '">x</a>]</font>   <a class="icons his-mod" href="', $scripturl, '?action=hist-mod" title="Historial de moderaci&oacute;n"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a></span>';
		}

	if ($context['user']['is_logged'])		
{		echo '<span class="menu_der"><div id="categorias" style="float:left;margin-bottom:5px;">';  ssi_categorias(); echo'</span></div></div>';}
	echo '<div id="bg-cuerpo">&nbsp</div><div id="bodyarea"><div align="left"><script type="text/javascript">
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