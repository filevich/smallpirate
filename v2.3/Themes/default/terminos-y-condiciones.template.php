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

	echo '<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>',$txt['terminos_condiciones_title'],'</center></div>
</div>


				<table align="center" class="windowbg" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr class="windowbg">
			<td style="padding: 3ex;"><br />',$txt['terminos_condiciones_message'],'</td></tr></table>';}
?>