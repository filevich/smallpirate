<?php


function template_manual_above()
{
	global $context, $settings, $options, $txt, $scripturl;

	echo '';
}

function template_manual_below()
{
	global $context, $settings, $options, $txt, $scripturl;

	echo '';
}

function template_manual_intro()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
	
// me cargo el index.php de la ruta
$ruta = str_replace("index.php", "", $scripturl);
$titul='Yelid Mod';
echo'<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Enlazanos</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
    <table border="0px" bgcolor="#FFFFFF" align="center" width="100%">
 <td width="100" nowrap="nowrap"><a tile="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'/web/enlazanos/16x16.gif" alt="'; echo $titul; echo'" width="16" border="0" height="16"></td>
	<td class="windowbg2" width="751">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'/web/enlazanos/16x16.gif" alt="'; echo $titul; echo'" width="16" border="0" height="16" /&gt;<br>
					&lt;/a&gt;</td><tr>
					<td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'/web/enlazanos/88x31.gif" alt="'; echo $titul; echo'" width="88" border="0" height="31"></td>
	<td class="windowbg2" width="751">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'/web/enlazanos/88x31.gif" alt="'; echo $titul; echo'" width="88" border="0" height="31" /&gt;<br>
					&lt;/a&gt;</td></tr><tr><td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="/web/enlazanos/100x20.gif" alt="'; echo $titul; echo'" width="100" border="0" height="20"></td>
	<td class="windowbg2" width="751">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'/web/enlazanos/100x20.gif" alt="'; echo $titul; echo'" width="100" border="0" height="20" /&gt;<br>
					&lt;/a&gt;</td></tr>
					<tr><td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'/web/enlazanos/125x125.gif" alt="'; echo $titul; echo'" width="125" border="0" height="125"></td>
	<td class="windowbg2" width="751">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'/web/enlazanos/125x125.gif" alt="'; echo $titul; echo'" width="125" border="0" height="125" /&gt;<br>
					&lt;/a&gt;</td></tr></table>
	'; 
}

?>