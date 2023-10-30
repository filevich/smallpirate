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
	global $context, $settings, $options, $txt, $scripturl, $modSettings, $mbname;
	
// me cargo el index.php de la ruta
$ruta = str_replace("index.php", "", $scripturl);
$titul=$mbname;
echo'<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>',$txt['enlazanos'],'</center></div>
</div>
    <table border="1px" bgcolor="#FFFFFF" align="center" width="100%">
 <td width="100" nowrap="nowrap"><a tile="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'web/enlazanos/16x16.gif" alt="'; echo $titul; echo'" width="16" border="0" height="16"></td>
	<td class="windowbg2" style="background:#FFF;border:1px dashed #424242" width="751">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'web/enlazanos/16x16.gif" alt="'; echo $titul; echo'" width="16" border="0" height="16" /&gt;<br>
					&lt;/a&gt;</td><tr>
					<td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'web/enlazanos/88x31.gif" alt="'; echo $titul; echo'" border="0"></td>
	<td class="windowbg2" width="751" style="background:#FFF;border:1px dashed #424242">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'web/enlazanos/88x31.gif" alt="'; echo $titul; echo'" width="88" border="0" height="31" /&gt;<br>
					&lt;/a&gt;</td></tr><tr><td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="web/enlazanos/100x20.gif" alt="'; echo $titul; echo'"border="0"></td>
	<td class="windowbg2" width="751" style="background:#FFF;border:1px dashed #424242">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'/web/enlazanos/100x20.gif" alt="'; echo $titul; echo'" width="100" border="0" height="20" /&gt;<br>
					&lt;/a&gt;</td></tr>
					<tr><td width="100" nowrap="nowrap"><a title="'; echo $titul; echo'" href="'.$ruta.'">
	<p align="center"><img src="'.$ruta.'web/enlazanos/125x125.gif" alt="'; echo $titul; echo'" width="125" border="0" height="125"></td>
	<td class="windowbg2" width="751" style="background:#FFF;border:1px dashed #424242">&lt;a title="'; echo $titul; echo'" href="'.$ruta.'"&gt;<br>
					&lt;img src="'.$ruta.'web/enlazanos/125x125.gif" alt="'; echo $titul; echo'" width="125" border="0" height="125" /&gt;<br>
					&lt;/a&gt;</td></tr></table>';}

?>