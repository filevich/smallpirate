<?php
// Contact System creado por Phobos91
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

echo'<table width="100%" cellpadding="3" cellspacing="0" border="0">
<div class="box_title" style="width: 933px;"><div class="box_txt box_buscadort"><center>Formulario de contacto</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 26px; height: 16px;" border="0"></div>
</table>

<table align="center" class="windowbg" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr class="windowbg">
<td style="padding: 0ex;"><br>

<center><iframe allowtransparency="allowtransparency" width="807" height="385" frameborder="0" scrolling="no" src="/web/contacto/contact.php">
</iframe></center></td></tr></table>'; 
}

?>