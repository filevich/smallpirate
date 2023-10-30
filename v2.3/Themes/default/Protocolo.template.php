<?php

function template_manual_above(){}
function template_manual_below(){}
function template_manual_intro()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
	
echo'
<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>', $txt[Protocolo], '</center></div>
</div>

				<table align="center" class="windowbg" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr class="windowbg">
			<td style="padding: 3ex;">
			<center><font face="Arial" size="+2" color="#000000">', $txt[Introduccion], ':</font></center>
			<br><br>
            ', $txt[Mensaje_1], '
			<hr><br><center><font face="Arial" size="+2" color="#000000">', $txt[Protocolo], ':</font></center>	<br><br>
	<p><b>', $txt[Caracteristicas], ':</b></p>', $txt[Mensaje_Protocolo], '</td></tr></table>';}
?>