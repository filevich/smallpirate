<?php

function template_main()
{
	global $context, $settings, $options, $scripturl, $txt;


	echo'<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Usuarios conectados</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table><div style="width: 100%; background-color: #FFFFFF;">
		<div align="center" style="align: center;" class="smalltext">En este momento hay ', $context['num_users_online'], ' usuarios conectados</div><br>', implode(' ', $context['list_users_online']),'</div>
	<br />
		<table width="222px" border="0" cellspacing="0" cellpadding="0" height="17px">
  <tr>
    <td style=" background: url(/Themes/default/images/buttons/pag_bg.gif) no-repeat; ">
	<font size="1" color="#FFFFFF">&nbsp; P&aacute;ginas:&nbsp;&nbsp;&nbsp;&nbsp; ', $context['page_index'], '</font></td>
    </tr>
  </table>';
	
	

}

?>