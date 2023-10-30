<?php
function template_init()
{	global $context, $settings, $options, $txt;
	$settings['use_default_images'] = 'never';
	 $settings['doctype'] = 'xhtml';
	$settings['theme_version'] = '3.0';
	$settings['use_tabs'] = true;
	$settings['use_buttons'] = true;
	$settings['seperate_sticky_lock'] = true;

}
function template_main_above()
{
global $context, $settings, $options, $scripturl, $txt, $modSettings, $db_prefix;
require_once("SSI.php");
//Verificar fecha
$request = db_query("SELECT value
			FROM {$db_prefix}settings
			WHERE variable='date_points'", __FILE__, __LINE__);
$row = mysql_fetch_assoc($request);

if ( $row['value'] < date("Ymd"))
{
	//Actualizar fecha
	db_query("UPDATE {$db_prefix}settings
			SET value ='".date("Ymd")."'
			WHERE variable='date_points'", __FILE__, __LINE__);
	//Actualizar puntos todos
	db_query("UPDATE {$db_prefix}points_per_day
			SET points = 10", __FILE__, __LINE__);
}
mysql_free_result($request);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
<head>
<meta name="verify-v1" content="HTXLHK/cBp/LYfs9+fLwj1UOxfq+/iFsv1DZjB6zWZU=" />
<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
<meta name="description" content="', $context['page_title'],'" />
<meta name="robots" content="all" />
<meta name="keywords" content="all" />
<link rel="search" type="application/opensearchdescription+xml" title="" href="/web/agregar.xml" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<title>'.$context['forum_name'].' - '.$context['page_title'].'</title>
<link rel="alternate" type="application/atom+xml" title="'.$txt['last_posts'].'" href="/web/rss/rss-ultimos-post.php" />
<link rel="alternate" type="application/atom+xml" title="'.$txt['last_comments'].'" href="/web/rss/rss-comment.php" />
<link rel="stylesheet" type="text/css" href="'.$settings['theme_url'].'/estilos-sp.css"/>
<script type="text/javascript" src="'.$settings['default_theme_url'].'/acciones-sp-1.1.js"></script>
</head>
<body>';
echo'

	<div id="maincontainer">
	<table id="widthControl" border="0" cellpadding="0" cellspacing="0">
	<td class="abajo-top" width="100%" valign="top" style="padding-bottom: 10px;">
	<div id="head">
		<div id="logo" style="padding-top:5px">
			<a href="'.$scripturl.'" title="'.$context['forum_name'].'" id="logo-img"><img src="'.$settings['images_url'].'/espacio.gif" alt="'.$context['forum_name'].' - '.$context['page_title'].'" title="'.$context['forum_name'].' - '.$context['page_title'].'" align="top" border="0"></a>
		</div>
<!-- <div style="width: 468px;height: 60px;float: right;padding: 0px;">
		<a href="#" target="_blank"><img src="'.$settings['images_url'].'/banner-468x60.gif"/></a>
	</div> -->

	</div>
<div class="header2" align="center" style="margin:0px; padding: 0px;"><div id="menu-top" style="margin: 0px; padding: 0px;">', menu(), '';

}

function template_main_below()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '</div></table>';

	echo'<div id="pie">
	<center><font size="1"><font color="#585858">&copy; '.date("Y", time()).' </font><a href="'.$scripturl.'">', $context['forum_name'], '</a>
 | <a href="'.$scripturl.'?action=protocolo"><b>',$txt['protocol'],'</b></a>
 | <a href="'.$scripturl.'?action=enlazanos">',$txt['link_us'],'</a>
 | <a href="'.$scripturl.'?action=widget">',$txt['widget'],'</a>
 | <a href="'.$scripturl.'?action=contactenos">',$txt['contact'],'</a>
 | <a href="'.$scripturl.'?action=sitemap">',$txt['sitemap'],'</a>
 | <a href="'.$scripturl.'?action=terminos-y-condiciones">',$txt['termns'],'</a>
  <br><font color="#585858" size="1" face="arial">'; theme_copyright(); echo'</font>
</center></div></td>
</div>
';

	echo '
			</body></html>
	';
}

function menu()
{
	global $context, $settings, $options, $scripturl, $txt, $chatid;

	if ($context['user']['is_guest'])
		echo '<span class="menu_izq" style="color:#FFFFFF"><a class="menuo" href="', $scripturl, '" title="',$txt['start'],'"><img src="', $settings['images_url'], '/icons/home.png"> ',$txt['start'],'</a> <font color="#FFFFFF"> </font> <a class="menuod" href="', $scripturl, '?action=protocolo"><b><font color="#FFFFFF">',$txt['protocol'],'</font></b></a> <font color="#999999"> </font> <a class="menuod" href="', $scripturl, '?action=search" title="',$txt['search'],'"><font color="#FFFFFF">',$txt['search'],'</font></a> <a class="menuod" href="', $scripturl, '?action=rz;m=',$chatid,'" title="',$txt['chat'],'"><font color="#FFFFFF">',$txt['chat'],'</font></a> <a class="menuod" href="', $scripturl, '?action=login" title="' , $txt[34] , '"><font color="#FFFFFF">' , $txt[34] , '</font></a> <font color="#999999">|</font> <a class="menuor" href="', $scripturl, '?action=registrarse" title="',$txt['register'],'"><b><font color="#FFFFFF">',$txt['register'],'</font></b></a></span></font>

<span class="menu_centro"><div id="iniciars" style="padding:0px 71px;margin-right:0px; float: left;">
<style>
.boxExt{ position:absolute;}
.boxInt{ position:absolute; top:20px; width:332px; height:171px; background: url(\'', $settings['images_url'], '/fondo-login.gif\') no-repeat; display:none;}
input.ilogin {width: 125px;}
</style>

<script>
function mostrar(que){
	$(que).fadeIn("fast");

}
function ocultar(que){
	 $(que).fadeOut("fast");
}
</script>
<form action="', $scripturl, '?action=login2" method="post" accept-charset="ISO-8859-1" name="frmLogin" id="frmLogin" onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');">
<div class="boxExt" style="z-index:999;"><div class="boxInt" style="z-index:999;">
<div style="padding-top:15px;" align="center">
<div style="float:left; width:102px; height:22px;text-align:right;">',$txt['user_name'],'</div>
<div style="float:left; width:170px; height:25px; padding-left:1px;">
<input size="30" maxlength="64" style="font-size:10px;" id="user" name="user" class="ilogin" type="text">
</div>
<div style="float:left; width:102px; height:22px;text-align:right;">',$txt['password'],'</div>
<div style="float:left; width:170px; height:25px; padding-left:1px;"> 
<input size="30" maxlength="64" style="font-size: 10px;" id="passwrd" name="passwrd" class="ilogin" type="password">
</div>
<input class="login_i" style="font-size: 10px;" size="50" value="',$txt['start_ses'],'" title="',$txt['start_ses'],'" type="submit">
</div><hr width=95%">
<div style="text-align:center;line-height:190%;>
<br>
<font color="#000000">',$txt['question_register'],'</font> <a href="', $scripturl, '?action=registrarse" style="font-weight:bold;color:#FF0000;">',$txt['register_now'],'</a><br> <a href="', $scripturl, '?action=reminder" style="font-weight:bold;">',$txt['reminder_pass'],'</a>
</div></div><a title="',$txt['start_ses'],'" onclick="mostrar(this.previousSibling); return false;" href="#" class="iniciar_sesion"><font color="#0B3861">',$txt['start_ses'],'</font></a></div></div></form></span>';

	if ($context['user']['is_guest'])		
{		echo '<span class="menu_der"><div id="categorias">';  ssi_categorias(); echo'</span></div></div>';}
	if ($context['user']['is_logged'])
		{echo '<span class="menu_izq"><a class="menuo" href="', $scripturl, '" title="',$txt['start'],'"><img src="', $settings['images_url'], '/icons/home.png"> ',$txt['start'],'</a> <font color="#999999"> </font> <a class="menuod" href="', $scripturl, '?action=protocolo"><b><font color="#FFFFFF">',$txt['protocol'],'</font></b></a> <a class="menuod" href="', $scripturl, '?action=search" title="',$txt['search'],'"><font color="#FFFFFF">',$txt['search'],'</font></a> <a class="menuod" href="', $scripturl, '?action=rz;m=',$chatid,'" title="',$txt['chat'],'"><font color="#FFFFFF">',$txt['chat'],'</font></a> <a class="menuod" href="', $scripturl, '?action=TOPs" title="',$txt['tops'],'"><font color="#FFFFFF">',$txt['tops'],'</font></a> <a class="menuor" href="', $scripturl, '?action=post;board=4" title="',$txt['publish'],'"><b><font color="#FFFFFF">',$txt['publish'],'</font></b></a></span>';
				
				if($context['user']['unread_messages']){
				echo'<span class="menu_centro"><a class="icons mp-nuevo" href="', $scripturl, '?action=pm" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
				 <a href="', $scripturl, '?action=pm" title="', $context['user']['unread_messages'] > 0 ? ''. $context['user']['unread_messages'] . '' : '' , ' MP Nuevo">', $context['user']['unread_messages'] > 0 ? '<font class="size12" color="#FFFFFF"><b>['. $context['user']['unread_messages'].']</b></font>' : '' , '</a>';}
				 else
				 
				  echo'<span class="menu_centro"><a class="icons mp" href="', $scripturl, '?action=pm" title="',$txt['pm'],'" alt="',$txt['pm'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>';echo'
					<font color="#999999">|</font> 
					
					<a class="icons monitor" href="', $scripturl, '?action=monitor" title="',$txt['monitor'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a> 
					<font color="#999999">|</font>
					
					<a class="icons fot" href="', $scripturl, '?action=imagenes&usuario=', $context['user']['name'] , '" title="',$txt['my_gallery'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a> 
					<font color="#999999">|</font>
					
					<a class="icons fav2" width="18px" href="', $scripturl, '?action=favoritos" title="',$txt['my_favourites'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a> 
					<font color="#999999">|</font> 
													
					<a class="icons cuenta" href="', $scripturl, '?action=profile;sa=cuenta" title="',$txt['my_account'],'" alt="',$txt['my_account'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
					<font color="#999999">|</font>';

		if ($context['allow_admin'])
echo'					<a class="icons admin" href="', $scripturl, '?action=admin"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a>
					<font color="#999999">|</font>	 ';
echo'	<a href="', $scripturl, '?action=profile" title="',$txt['my_profile'],'"><font color="#E6E6E6">', $context['user']['name'] , '</font></a> <font color="#999999">[<a href="', $scripturl, '?action=logout;sesc=', $context['session_id'], '"title="',$txt['exit'],'">x</a>]</font>	<a class="icons his-mod" href="', $scripturl, '?action=hist-mod" title="',$txt['hist_mod'],'"><img src="', $settings['images_url'], '/espacio.gif" align="top" border="0"></a></span>';
		}

if ($context['user']['is_logged']){
	echo '<span class="menu_der"><div id="categorias">';  ssi_categorias(); echo'</span></div></div>';}



	if ($context['user']['is_logged'])		
{		echo '';  echo'</span></div></div>';}
	echo '<div id="mensaje-top">
	<div id="smfFadeScroller">', $context['news_lines'][0], '</div>
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		// The fading delay (in ms.)
		var smfFadeDelay = ', empty($settings['newsfader_time']) ? 5000 : $settings['newsfader_time'], ';
		// Fade from... what text color? To which background color?
		var smfFadeFrom = {"r": 0, "g": 0, "b": 0}, smfFadeTo = {"r": 255, "g": 255, "b": 255};
		// Surround each item with... anything special?
		var smfFadeBefore = "", smfFadeAfter = "";

		var foreColor, backEl, backColor;

		if (typeof(document.getElementById(\'smfFadeScroller\').currentStyle) != "undefined")
		{
			foreColor = document.getElementById(\'smfFadeScroller\').currentStyle.color.match(/#([\da-f][\da-f])([\da-f][\da-f])([\da-f][\da-f])/);
			smfFadeFrom = {"r": parseInt(foreColor[1]), "g": parseInt(foreColor[2]), "b": parseInt(foreColor[3])};

			backEl = document.getElementById(\'smfFadeScroller\');
			while (backEl.currentStyle.backgroundColor == "transparent" && typeof(backEl.parentNode) != "undefined")
				backEl = backEl.parentNode;

			backColor = backEl.currentStyle.backgroundColor.match(/#([\da-f][\da-f])([\da-f][\da-f])([\da-f][\da-f])/);
			smfFadeTo = {"r": eval("0x" + backColor[1]), "g": eval("0x" + backColor[2]), "b": eval("0x" + backColor[3])};
		}
		else if (typeof(window.opera) == "undefined" && typeof(document.defaultView) != "undefined")
		{
			foreColor = document.defaultView.getComputedStyle(document.getElementById(\'smfFadeScroller\'), null).color.match(/rgb\((\d+), (\d+), (\d+)\)/);
			smfFadeFrom = {"r": parseInt(foreColor[1]), "g": parseInt(foreColor[2]), "b": parseInt(foreColor[3])};

			backEl = document.getElementById(\'smfFadeScroller\');
			while (document.defaultView.getComputedStyle(backEl, null).backgroundColor == "transparent" && typeof(backEl.parentNode) != "undefined" && typeof(backEl.parentNode.tagName) != "undefined")
				backEl = backEl.parentNode;

			backColor = document.defaultView.getComputedStyle(backEl, null).backgroundColor.match(/rgb\((\d+), (\d+), (\d+)\)/);
			smfFadeTo = {"r": parseInt(backColor[1]), "g": parseInt(backColor[2]), "b": parseInt(backColor[3])};
		}

		// List all the lines of the news for display.
		var smfFadeContent = new Array(
			"', implode('",
			"', $context['fader_news_lines']), '"
		);
	// ]]></script>
	<script language="JavaScript" type="text/javascript" src="', $settings['default_theme_url'], '/fader.js"></script>

</div><div id="bodyarea"><div align="left"><script type="text/javascript">
function postab(id){
document.getElementById(id).style.display = \'inline\';
document.getElementById(\'masinfo\'+id).style.display = \'none\';

document.getElementById(\'cerrarinfo\'+id).style.display = \'inline\';}
function cerrarpost(id){
document.getElementById(id).style.display=\'none\';
document.getElementById(\'cerrarinfo\'+id).style.display = \'none\';

document.getElementById(\'masinfo\'+id).style.display = \'inline\';}
function errorrojos(search){if(search == \'\'){document.getElementById(\'errorss\').innerHTML=\'<font class="size10" style="color: red;">',$txt['search_empty'],'</font>\'; return false;}}</script>

';

}

function template_button_strip(){}

function theme_linktree2(){}

function theme_linktree3(){}


function theme_newestlink(){}
function theme_linktree(){}
?>