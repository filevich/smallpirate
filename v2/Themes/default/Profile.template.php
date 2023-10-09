<?php
function pais($valor)
{
					
$valor = str_replace("ar", "Argentina", $valor);
$valor = str_replace("bo", "Bolivia", $valor);
$valor = str_replace("br", "Brasil", $valor);
$valor = str_replace("cl", "Chile", $valor);
$valor = str_replace("co", "Colombia", $valor);
$valor = str_replace("cr", "Costa Rica", $valor);
$valor = str_replace("cu", "Cuba", $valor);
$valor = str_replace("ec", "Ecuador", $valor);
$valor = str_replace("es", "Espa&ntilde;a", $valor);
$valor = str_replace("gt", "Guatemala", $valor);
$valor = str_replace("it", "Italia", $valor);
$valor = str_replace("mx", "Mexico", $valor);
$valor = str_replace("py", "Paraguay", $valor);
$valor = str_replace("pe", "Peru", $valor);
$valor = str_replace("pt", "Portugal", $valor);
$valor = str_replace("pr", "Puerto Rico", $valor);
$valor = str_replace("uy", "Uruguay", $valor);
$valor = str_replace("ve", "Venezuela", $valor);
$valor = str_replace("ot", "", $valor);

return $valor;
}
function url($valor)
{					
$valor = str_replace("http://", "", $valor);
$valor = str_replace("taringa.net", "******", $valor);
$valor = str_replace("www.taringa.net", "******", $valor);
$valor = str_replace("taringa", "******", $valor);
$valor = str_replace("http://taringa.net", "******", $valor);
$valor = str_replace("http://www.taringa.net", "******", $valor);
$valor = str_replace("Taringa.net", "******", $valor);
$valor = str_replace("atp.com.ar", "******", $valor);
$valor = str_replace("www.atp.com.ar", "******", $valor);
$valor = str_replace("http://atp.com.ar", "******", $valor);
$valor = str_replace("http://www.atp.com.ar", "******", $valor);
$valor = str_replace("http://atp.com.ar/", "******", $valor);
return $valor;
}
function template_profile_above(){}
function template_profile_below(){}
function template_summary()
{
global $context, $settings, $options, $scripturl, $modSettings, $txt;
$noimg = $context['member']['name'] . ' no tiene im&aacute;genes en la galer&iacute;a';
$nopost = $context['member']['name'] . ' no tiene ning&uacute;n post hecho';

echo '
<table align="center" width="926px"><tr>
<td>
<div style="float:left;">
<div class="box3">		
          <div class="box_tit"><em><center>Datos de la cuenta</center></em></div><div class="box_icono">
          <b class="size11">&nbsp;Nick:</b> <span class="size11">', $context['member']['name'], '</span><br>
          <b class="size11">&nbsp;Es usuario desde: </b> <span class="size11">', $context['member']['registered'], '</span>';
          
//edad
if ($context['member']['age'])
echo'<br><b class="size11">&nbsp;', $txt[420], ':</b> <span class="size11">', $context['member']['age'] , '</span>';

//ubicacion
if ($context['member']['location'])
echo'<br><b class="size11">&nbsp;', $txt[227], ':</b> <span class="size11">', $context['member']['location'], '</span>';
    
    // sexo
	if ($context['member']['gender']['name'])
	echo '<br><b class="size11">&nbsp;Genero: </b> <span class="size11">', $context['member']['gender']['name'], '</span>';

//país
	if($context['member']['title'])
			{echo'<br><b class="size11">&nbsp;Pa&iacute;s:</b> <span class="size11">'. pais($context['member']['title'])  . ' <img title="'. pais($context['member']['title'])  . '" src="/Themes/default/images/icons/banderas/'.$context['member']['title'].'.gif"></span>';}
			else
			echo'<br><b class="size11">&nbsp;Pa&iacute;s:</b> <img src="/Themes/default/images/icons/banderas/ot.gif">';

//email	
   if ($context['member']['msn']['name'])
	echo '
<br><b class="size11">&nbsp;', $txt['MSN'], ': </b> <span class="size11">', $context['member']['msn']['name'], '</span>';

//web
	 if ($context['member']['website']['title'])
     echo'<br><b class="size11">&nbsp;', $txt[96], ': </b> <span class="size11"><a href="http://'. url($context['member']['website']['title'])  . '" target="_blank">http://'. url($context['member']['website']['title'])  . '</a></span>';
// grupo
echo'<br><b class="size11">&nbsp;Rango:</b> <span class="size11">', (!empty($context['member']['group']) ? $context['member']['group'] : $context['member']['post_group']), '</span>';
	  
	  
	  
  	if (!empty($context['activate_message']) || !empty($context['member']['bans']))
	{
		if (!empty($context['activate_message']))
			echo '<br><span style="color: red;">', $context['activate_message'], '</span>&nbsp;(<a href="' . $scripturl . '?action=profile2;sa=activateAccount;userID=' . $context['member']['id'] . ';sesc=' . $context['session_id'] . '" ', ($context['activate_type'] == 4 ? 'onclick="return confirm(\'' . $txt['profileConfirm'] . '\');"' : ''), '>', $context['activate_link_text'], '</a>)';

if (!empty($context['member']['bans'])){echo '<br><span style="color: red;"><center><img title="', $txt['user_is_banned'], '" alt="', $txt['user_is_banned'], '" border="0" src="/Themes/default/images/icons/show_sticky.gif"> ', $txt['user_is_banned'], '</center></span>';}}echo'</div></div>';

// ip del usuario
if ($context['user']['is_admin'])
	{echo '
   <div class="box3">
          <div class="box_tit"><em><center>Ip del usuario</center></em></div>
          <div class="box_icono">
			<b class="size11">&nbsp;', $txt[512], ':</b> <span class="size11"><a href="/?action=trackip;searchip=', $context['member']['ip'], '" target="_blank">', $context['member']['ip'], '</a></span><br>
			<b class="size11">&nbsp;', $txt['hostname'], ':</b> <span class="size11">', $context['member']['hostname'], '</span><br> <b class="size11">&nbsp;', $txt['lastLoggedIn'], ': </b> <span class="size11">', $context['member']['last_login'], '</span></div></div>';
	}
	
$iduser = $context['member']['id'];
$firma = str_replace('if(this.width >720) {this.width=720}','if(this.width >376) {this.width=376}', $context['member']['signature']);

// aca marca los comentarios de los usuarios
$request = db_query("
SELECT *
FROM cw_comentarios
WHERE id_user = $iduser
", __FILE__, __LINE__);
$context['comentuser'] = mysql_num_rows($request);
	
//estadisticas del usuario
	echo '<div class="box3">
          <div class="box_tit"><em><center>Estad&iacute;sticas del usuario</center></em></div>
          <div class="box_icono">
		  <b class="size11">&nbsp;', $txt[86], ':</b> <span class="size11">', $context['member']['topics']+$context['comentuser'], '</span><br>
          <a href="?action=profile;user=', $context['member']['name'], ';sa=post"><b class="size11">&nbsp;Post:</b> <span class="size11">', $context['member']['topics'], '</span></a><br>
          <a href="?action=profile;user=', $context['member']['name'], ';sa=comentarios"><b class="size11">&nbsp;Comentarios:</b> <span class="size11">',$context['comentuser'], '</span></a><br>
		  <b class="size11">&nbsp;Im&aacute;genes:</b> <span class="size11">', $context['count'] ,'</span><br>
		  <b class="size11">&nbsp;Puntos:</b> <span class="size11">', $context['member']['money'], '</span><br>
		  <br>&nbsp;<u><b class="size12">'.$txt['thankyoutitle'].'</b></u><br>
		  <b class="size11">&nbsp;- ', $txt['thankyoupostmade'], ':</b> <span class="size11">', $context['member']['thank_you_post']['made'], '</span><br>
		  <b class="size11">&nbsp;- ', $txt['thankyoupostbecame'], ':</b> <span class="size11">', $context['member']['thank_you_post']['became'], '</span><br>
		</div></div>';

//firma
echo'<div class="box_363" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34">Firma</div><div class="box_rss"><div class="icon_img"><img src="/Themes/default/images/blank.gif?v3.2.3"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;">';
if (!empty($context['member']['signature']) && empty($options['show_no_signatures']))
echo'<b class="size11">'.$firma.'</b>';
else
echo'<span class="size11"><center><img src="', $settings['images_url'], '/no-firma.jpg" alt="Usuario sin firma" border="0" /></center></span>';
echo'</div></div></div><div style="float:left; margin-right:8px;" align="left">';

//ultimos post del usuario
echo'<div style="float:left; margin-right: 5px;">   <div class="box"><div class="box_tit"><em><center>&Uacute;ltimos posts</center></em></div><div class="box_icono">';
if (!empty($context['posts']))
	{
				foreach ($context['posts'] as $post)
		{
			echo '	<table width="100%">
				<tr><td width="100%">
<div class="box_icono4"><img title="', $post['board']['name'], '" src="/Themes/default/images/post/icono_', $post['board']['id'], '.gif"></div>';
if ($context['user']['is_guest']){if ($post['can_view_post']){echo'';} 
else echo'<img title="Post privado" src="/Themes/default/images/icons/icono-post-privado.gif">';}
echo'<a href="?topic=', $post['topic'], '">', $post['subject'], '</a>
						</td>
				</tr></table>
';}

echo'</div><div class="box_icono"><center><a href="?action=profile;user=', $context['member']['name'], ';sa=post">ver m&aacute;s</a></center></div>';}
else echo'<br><center><img title="',$nopost,'" alt="',$nopost,'" border="0" src="/Themes/default/images/icons/show_sticky.gif"> ',$nopost,'</center><br>';   
echo'</div>';

// imagenes del usuario
echo'<div class="box"><div class="box_tit"><em><center>Im&aacute;genes</center></em></div><div class="box_icono">';
if ($context['img']){
foreach ($context['img'] as $img)
{echo'
<div class="photo_small1"><center><a href="/?action=imagenes;sa=ver;id=' . $img['id'] . '"><img style="width: 343px;" src="' . $img['filename'] . '" border="6" /></a></center></div><div class="smalltext"><center>Comentarios: (<a href="/?action=imagenes;sa=ver;id=' . $img['id'] . '#comentarios">' . $img['commenttotal'] . '</a>)</center></div>';

				}echo'</div><div class="box_icono"><center><a href="/?action=imagenes&u=', $context['member']['id'], '">Ir a galer&iacute;a</a></center>';}
				else echo'<br><center><img title="',$noimg,'"  alt="',$noimg,'" border="0" src="/Themes/default/images/icons/show_sticky.gif"> ',$noimg,'</center><br>';
				
				echo'</div></div></div>';
				
// avatar
echo'<div style="float:left;"><div class="box">
          <div class="box_tit_2"><em><center>Avatar '; if ($context['member']['blurb']) echo'- Mensaje personal'; echo'</center></em></div>
          <div class="box_icono2"><br><div align="center">';
if (!empty($settings['show_user_images']) && empty($options['show_no_avatars']) && !empty($context['member']['avatar']['image'])) echo '<div class="sup3">&nbsp;</div>	
						<div class="fondoavatar" style="overflow: auto; width: 132px;" ><center>', $context['member']['avatar']['image'], '</center><br />', $context['member']['blurb'], '</div><div class="inf3">&nbsp;</div><br />';

 else
				echo '<div class="sup3">&nbsp;</div><div class="fondoavatar" style="overflow: auto; width: 132px;"><center><img src="', $settings['images_url'], '/avatar.gif" border="0" alt="Sin Avatar" /></center><br />', $context['member']['blurb'], '</div><div class="inf3">&nbsp;</div><br />';
				echo'</div>
		  </div></div>
		  ';
  if (!$context['user']['is_owner'] && $context['can_send_pm'])
		 { echo'
		   <div class="box">
            <div class="box_tit_2" style="font-size: 11px;"><em><center>Opciones</center></em></div>
            <div class="box_icono2">'; 	
	echo '&nbsp;<a href="/?action=pm;sa=send;u=', $context['member']['id'], '" title="Enviar MP a ', $context['member']['name'], '"><img src="/Themes/default/images/im_on.gif" alt="Enviar MP a ', $context['member']['name'], '" border="0" /> Enviar MP</a><br>

&nbsp;<a href="/?action=imagenes&u=', $context['member']['id'], '" title="Galer&iacute;a de ', $context['member']['name'], '" alt="Galer&iacute;a de ', $context['member']['name'], '"><img title="Galer&iacute;a de ', $context['member']['name'], '" src="/Themes/default/images/icons/icono-foto.gif" alt="Galer&iacute;a de ', $context['member']['name'], '" border="0"> Ver Galer&iacute;a</a><br>';

if ($context['allow_admin']){
echo'
&nbsp;<a title="Banear usuario" href="/?action=ban;sa=add;u=', $context['member']['id'], '"><img src="/Themes/default/images/icons/show_sticky.gif" width="14" height="13" alt="Banear usuario" title="Banear usuario" border"0"/>&nbsp;Banear usuario</a><br>';}

if ($context['user']['is_admin'])
	{
echo'&nbsp;<a title="Rastrear Usuario" href="/?action=profile;u=', $context['member']['id'], ';sa=trackUser"><img src="/Themes/default/images/icons/show_sticky.gif" width="14" height="13" alt="Rastrear Usuario" title="Rastrear Usuario" border"0"/>&nbsp;Rastrear Usuario</a><br>

&nbsp;<a title="Rastrear IP" href="/?action=profile;u=', $context['member']['id'], ';sa=trackIP"><img src="/Themes/default/images/icons/show_sticky.gif" width="14" height="13" alt="Rastrear IP" title="Rastrear IP" border"0"/>&nbsp;Rastrear IP</a><br>

&nbsp;<a title="Borrar esta cuenta" href="/?action=profile;u=', $context['member']['id'], ';sa=deleteAccount"><img src="/Themes/default/images/icons/show_sticky.gif" width="14" height="13" alt="Borrar esta cuenta" title="Borrar esta cuenta" border"0"/>&nbsp;Borrar esta cuenta</a><br>

<a title="Editar esta cuenta" href="/?action=profile;u=', $context['member']['id'], ';sa=cuenta"><img alt="Editar esta cuenta" src="/Themes/default/images/icons/icono-editar-cuenta.gif" border="0" width="16" height="16"> Editar esta cuenta</a><br>

&nbsp;<a title="Editar este perfil" href="/?action=profile;u=', $context['member']['id'], ';sa=perfil"><img alt="Editar mi perfil" src="/Themes/default/images/icons/icono-editar-perfil.gif" border="0" width="16" height="16"> 
Editar mi perfil</a>';}

   echo'</div></div>';}
          
          if ($context['profile_areas']){
   echo'
<div class="box"><div class="box_tit_2" style="font-size: 11px;"><em><center>Mi cuenta</center></em></div><div class="box_icono2">&nbsp;<a title="Editar mi cuenta" href="?action=profile;sa=cuenta"><img alt="Editar mi cuenta" src="/Themes/default/images/icons/icono-editar-cuenta.gif" border="0" width="16" height="16"> Editar mi cuenta</a><br>
&nbsp;<a title="Editar mi perfil" href="?action=profile;sa=perfil"><img alt="Editar mi perfil" src="/Themes/default/images/icons/icono-editar-perfil.gif" border="0" width="16" height="16"> 
Editar mi perfil</a><br>
&nbsp;<a title="Agregar imagen" href="/?action=imagenes;sa=agregar"><img alt="Agregar imagen" src="/Themes/default/images/icons/icono-foto-agregar.gif" border="0" width="16" height="16"> 
Agregar imagen</a></div></div>';}
          
          
          echo'</div></td></tr></table>';
         
}



function template_comentarios()
{
global $context, $settings, $options, $scripturl, $modSettings, $txt;
echo'<table align="center" style="float: left;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>&Uacute;ltimos 50 comentarios de ', $context['member']['name'], '</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
          <div class="box_icono" style="width: 100%">';
		if (!empty($context['cposts'])){
foreach ($context['cposts'] as $cpost){
echo '<table width="100%"><tr><td valign="top" width="16px"><img title="" src="/Themes/default/images/post/icono_'.$cpost['ID_BOARD'].'.gif" ></td><td><b class="size11" title="' . $cpost['subject'] . '"><a href="'. $scripturl .'/?topic=', $cpost['ID_TOPIC'], '" >' . $cpost['subject'] . '</a></b><div class="size11">' . $cpost['posterTime'] . ': <a href="'. $scripturl .'?topic=', $cpost['ID_TOPIC'], '#cmt_', $cpost['id_coment'], '" >' . $cpost['body'] . '</a></div></td></tr></table>';}
echo'</div>';
if ($context['page_index'])
echo'<div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';}
else
echo '<br><br><center><b>', $context['member']['name'], '</b> no tiene comentarios...</center><br><br>';
   
   echo'</div><td></tr></table>   
   <table align="center" style="float: left;" width="204px"><tr>
<td>
         <div style="height:18px;">
         <table height="18px" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Publicidad</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
           <div class="box_icono" style="width: 100%;"><center>
		  '; // Publicidad AQUÍ
		  echo'
		  	 </center>
		   </div></div>        
</td></tr></table>';

}


function template_editBuddies(){}
function template_trackUser()
{
	global $context, $settings, $options, $scripturl, $txt;

    echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="left" width="100%">
				<tr class="titlebg">
					<td colspan="2">
						<b>', $txt['view_ips_by'], ' ', $context['member']['name'], '</b>
					</td>
				</tr>';

	echo '
				<tr>
					<td class="windowbg2" align="left" width="200">', $txt['most_recent_ip'], ':</td>
					<td class="windowbg2" align="left">
						<a href="', $scripturl, '?action=trackip;searchip=', $context['last_ip'], ';">', $context['last_ip'], '</a>
					</td>
				</tr>';

	// Lists of IP addresses used in messages / error messages.
	echo '
				<tr>
					<td class="windowbg2" align="left">', $txt['ips_in_messages'], ':</td>
					<td class="windowbg2" align="left">
						', (count($context['ips']) > 0 ? implode(', ', $context['ips']) : '(' . $txt['none'] . ')'), '
					</td>
				</tr><tr>
					<td class="windowbg2" align="left">', $txt['ips_in_errors'], ':</td>
					<td class="windowbg2" align="left">
						', (count($context['error_ips']) > 0 ? implode(', ', $context['error_ips']) : '(' . $txt['none'] . ')'), '
					</td>
				</tr>';

	// List any members that have used the same IP addresses as the current member.
	echo '
				<tr>
					<td class="windowbg2" align="left">', $txt['members_in_range'], ':</td>
					<td class="windowbg2" align="left">
						', (count($context['members_in_range']) > 0 ? implode(', ', $context['members_in_range']) : '(' . $txt['none'] . ')'), '
					</td>
				</tr>
			</table>
		</td></tr></table>
		<br />';

	// The second table lists all the error messages the user has caused/received.
	echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
				<tr class="titlebg">
					<td colspan="4">
						', $txt['errors_by'], ' ', $context['member']['name'], '
					</td>
				</tr><tr class="windowbg">
					<td class="smalltext" colspan="4" style="padding: 2ex;">
						', $txt['errors_desc'], '
					</td>
				</tr><tr class="titlebg">
					<td colspan="4">
						', $txt[139], ': ', $context['page_index'], '
					</td>
				</tr><tr class="catbg3">
					<td>', $txt['ip_address'], '</td>
					<td>', $txt[72], '</td>
					<td>', $txt[317], '</td>
				</tr>';

	if (empty($context['error_messages']))
		echo '
				<tr><td class="windowbg2" colspan="4"><i>', $txt['no_errors_from_user'], '</i></td></tr>';
	else
		foreach ($context['error_messages'] as $error)
			echo '
				<tr>
					<td class="windowbg2">
						<a href="', $scripturl, '?action=trackip;searchip=', $error['ip'], ';">', $error['ip'], '</a>
					</td>
					<td class="windowbg2">
						', $error['message'], '<br />
						<a href="', $error['url'], '">', $error['url'], '</a>
					</td>
					<td class="windowbg2">', $error['time'], '</td>
				</tr>';
	echo '
			</table>
		</td></tr></table>';
}

function template_trackIP()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
		<form action="', $scripturl, '?action=trackip" method="post" accept-charset="', $context['character_set'], '">';

	echo '
			<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
				<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
					<tr class="titlebg">
						<td>', $txt['trackIP'], '</td>
					</tr><tr>
						<td class="windowbg2">
							', $txt['enter_ip'], ':&nbsp;&nbsp;<input type="text" name="searchip" value="', $context['ip'], '" size="20" />&nbsp;&nbsp;<input class="login" type="submit" value="', $txt['trackIP'], '" />
						</td>
					</tr>
				</table>
			</td></tr></table>
		</form>
		<br />';

	if ($context['single_ip'])
	{
		echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
				<tr class="titlebg">
					<td colspan="2">
						', $txt['whois_title'], ' ', $context['ip'], '
					</td>
				</tr><tr>
					<td class="windowbg2">';
		foreach ($context['whois_servers'] as $server)
			echo '
						<a href="', $server['url'], '" target="_blank"', isset($context['auto_whois_server']) && $context['auto_whois_server']['name'] == $server['name'] ? ' style="font-weight: bold;"' : '', '>', $server['name'], '</a><br />';
		echo '
					</td>
				</tr>
			</table>
		</td></tr></table>
		<br />';
	}

	echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
				<tr class="titlebg">
					<td colspan="2">
						', $txt['members_from_ip'], ' ', $context['ip'], '
					</td>
				</tr><tr class="catbg3">
					<td>', $txt['ip_address'], '</td>
					<td>', $txt['display_name'], '</td>
				</tr>';
	if (empty($context['ips']))
		echo '
				<tr><td class="windowbg2" colspan="2"><i>', $txt['no_members_from_ip'], '</i></td></tr>';
	else
		foreach ($context['ips'] as $ip => $memberlist)
			echo '
				<tr>
					<td class="windowbg2"><a href="', $scripturl, '?action=trackip;searchip=', $ip, ';">', $ip, '</a></td>
					<td class="windowbg2">', implode(', ', $memberlist), '</td>
				</tr>';
	echo '
			</table>
		</td></tr></table>
		<br />';

	echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
				<tr class="titlebg">
					<td colspan="4">
						', $txt['messages_from_ip'], ' ', $context['ip'], '
					</td>
				</tr><tr class="windowbg">
					<td class="smalltext" colspan="4" style="padding: 2ex;">
						', $txt['messages_from_ip_desc'], '
					</td>
				</tr><tr class="titlebg">
					<td colspan="4">
						<b>', $txt[139], ':</b> ', $context['message_page_index'], '
					</td>
				</tr><tr class="catbg3">
					<td>', $txt['ip_address'], '</td>
					<td>', $txt['rtm8'], '</td>
					<td>', $txt[319], '</td>
					<td>', $txt[317], '</td>
				</tr>';

	if (empty($context['messages']))
		echo '
				<tr><td class="windowbg2" colspan="4"><i>', $txt['no_messages_from_ip'], '</i></td></tr>';
	else
		foreach ($context['messages'] as $message)
			echo '
				<tr>
					<td class="windowbg2">
						<a href="', $scripturl, '?action=trackip;searchip=', $message['ip'], '">', $message['ip'], '</a>
					</td>
					<td class="windowbg2">
						', $message['member']['link'], '
					</td>
					<td class="windowbg2">
						<a href="?topic=', $message['topic'], '">
							', $message['subject'], '
						</a>
					</td>
					<td class="windowbg2">', $message['time'], '</td>
				</tr>';
	echo '
			</table>
		</td></tr></table>
		<br />';

	echo '
		<table cellpadding="0" cellspacing="0" border="0" class="bordercolor" align="center" width="90%"><tr><td>
			<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%">
				<tr class="titlebg">
					<td colspan="4">
						', $txt['errors_from_ip'], ' ', $context['ip'], '
					</td>
				</tr><tr class="windowbg">
					<td class="smalltext" colspan="4" style="padding: 2ex;">
						', $txt['errors_from_ip_desc'], '
					</td>
				</tr><tr class="titlebg">
					<td colspan="4">
						', $txt[139], ': ', $context['error_page_index'], '
					</td>
				</tr><tr class="catbg3">
					<td>', $txt['ip_address'], '</td>
					<td>', $txt['display_name'], '</td>
					<td>', $txt[72], '</td>
					<td>', $txt[317], '</td>
				</tr>';
	if (empty($context['error_messages']))
		echo '
				<tr><td class="windowbg2" colspan="4"><i>', $txt['no_errors_from_ip'], '</i></td></tr>';
	else
		foreach ($context['error_messages'] as $error)
			echo '
				<tr>
					<td class="windowbg2">
						<a href="', $scripturl, '?action=trackip;searchip=', $error['ip'], '">', $error['ip'], '</a>
					</td>
					<td class="windowbg2">
						', $error['member']['link'], '
					</td>
					<td class="windowbg2">
						', $error['message'], '<br />
						<a href="', $error['url'], '">', $error['url'], '</a>
					</td>
					<td class="windowbg2">', $error['error_time'], '</td>
				</tr>';
	echo '
			</table>
		</td></tr></table>';
}

function template_showPermissions(){}
function template_statPanel(){}

function template_cuenta()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function checkProfileSubmit()
			{';
	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
				// Did you forget to type your password?
				if (document.forms.creator.oldpasswrd.value == "")
				{
					alert("Por razones de seguridad, debes especificar tu contrase\xf1a actual para hacer cualquier cambio a tu perfil.");
					return false;
				}';

	if ($context['allow_edit_membergroups'] && $context['user']['is_owner'] && $context['member']['group'] == 1)
		echo '
				if (typeof(document.forms.creator.ID_GROUP) != "undefined" && document.forms.creator.ID_GROUP.value != "1")
					return confirm("', $txt['deadmin_confirm'], '");';

	echo '
				return true;
			}
		// ]]></script>';

	echo '
		<form action="/?action=profile2" method="post" accept-charset="', $context['character_set'], '" name="creator" id="creator" onsubmit="return checkProfileSubmit();">

<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Editar mi cuenta</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table border="0" width="100%" cellspacing="1" cellpadding="4" align="center">
				<tr>
					<td class="windowbg2" style="padding-bottom: 2ex;">
						<table width="100%" cellpadding="3" cellspacing="0" border="0">';

	if ($context['allow_edit_account'])
	{
		if ($context['user']['is_admin'] && !empty($context['allow_edit_username']))
			echo '
							<tr>
								<td colspan="2" align="center" style="color: red">', $txt['username_warning'], '</td>
							</tr>
							<tr>
								<td width="40%">
									<b>', $txt[35], ': </b>
								</td>
								<td>
									<input type="text" name="memberName" size="30" value="', $context['member']['username'], '" />
								</td>
							</tr>';
		else
			echo '', $context['user']['is_admin'] ? '	<tr>
								<td width="40%">
									<b class="size11">Nombre de usuario:</b><div class="smalltext">(<a href="/?action=profile;u=' . $context['member']['id'] . ';sa=cuenta;changeusername" style="font-style: italic;">' . $txt['username_change'] . '</a>)</div>
								</td>
								<td>
									'. $context['member']['username']. '
								</td>
							</tr>' : '', '';

	}

	if ($context['allow_edit_membergroups'])
	{
		echo '<tr>
								<td valign="top">
									<b class="size11">', $txt['primary_membergroup'], ': </b>
									<div class="smalltext"></div>
								</td>
								<td>
									<select name="ID_GROUP">';
		foreach ($context['member_groups'] as $member_group)
			echo '
										<option value="', $member_group['id'], '"', $member_group['is_primary'] ? ' selected="selected"' : '', '>
											', $member_group['name'], '
										</option>';
		echo '
									</select>
								</td>
							</tr><tr>
								<td valign="top"><b class="size11">', $txt['additional_membergroups'], ':</b></td>
								<td>
									<div id="additionalGroupsList">
										<input type="hidden" name="additionalGroups[]" value="0" />';
	
		foreach ($context['member_groups'] as $member_group)
			if ($member_group['can_be_additional'])
				echo '
										<label for="additionalGroups-', $member_group['id'], '"><input type="checkbox" name="additionalGroups[]" value="', $member_group['id'], '" id="additionalGroups-', $member_group['id'], '"', $member_group['is_additional'] ? ' checked="checked"' : '', ' class="check" /> ', $member_group['name'], '</label><br />';
		echo '
									</div>
									<a href="javascript:void(0);" onclick="document.getElementById(\'additionalGroupsList\').style.display = \'block\'; document.getElementById(\'additionalGroupsLink\').style.display = \'none\'; return false;" id="additionalGroupsLink" style="display: none;">', $txt['additional_membergroups_show'], '</a>
									<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
										document.getElementById("additionalGroupsList").style.display = "none";
										document.getElementById("additionalGroupsLink").style.display = "";
									// ]]></script>
								</td>
							</tr>';
	}

	if ($context['allow_edit_account'])
	{
	
		echo '
		<tr>
								<td width="40%"><b class="size11" ', (isset($context['modify_error']['bad_email']) || isset($context['modify_error']['no_email']) || isset($context['modify_error']['email_taken']) ? ' style="color: red;"' : ''), '>', $txt[69], ': </b><div class="smalltext">', $txt[679], '</div></td>
								<td><input type="text" name="emailAddress" size="30" value="', $context['member']['email'], '" /></td>
							</tr>';


		echo '
						<td width="40%"><b class="size11"', (isset($context['modify_error']['bad_new_password']) ? ' style="color: red;"' : ''), '>', $txt[81], ': </b><div class="smalltext">', $txt[596], '</div></td>
								<td><input type="password" name="passwrd1" size="20" /></td>
							</tr><tr>
								<td width="40%"><b class="size11">', $txt[82], ': </b></td>
								<td><input type="password" name="passwrd2" size="20" /></td>
							</tr>';

		echo '<tr>
								<td width="40%"><b class="size11">', $txt['pswd1'], ':</b><div class="smalltext">', $txt['secret_desc'], '</div></td>
								<td><input type="text" name="secretQuestion" size="50" value="', $context['member']['secret_question'], '" /></td>
							</tr><tr>
								<td width="40%"><b class="size11">', $txt['pswd2'], ':</b><div class="smalltext">', $txt['secret_desc2'], '</div></td>
								<td><input type="text" name="secretAnswer" size="20" /><span class="smalltext" style="margin-left: 4ex;"></span></td>
							</tr>';
	}

	template_profile_save();

	echo '
						</table>
					</td>
				</tr>
			</table>
		</form>';
}


function template_perfil()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<form action="/?action=profile2" method="post" accept-charset="', $context['character_set'], '" name="creator" id="creator" enctype="multipart/form-data">
		<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Editar mi cuenta</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table border="0" width="100%" cellspacing="1" cellpadding="4" align="center" class="bordercolor">
		<tr>
					<td class="windowbg2" style="padding-bottom: 2ex;">
						<table border="0" width="100%" cellpadding="5" cellspacing="0">';
	
	
	
		// enlace de avatar
		if (!empty($context['member']['avatar']['allow_external']))
		{
			echo '<tr>			<td width="20%"><b class="size11"><label for="avatar_choice_external">', $txt[475], ':</label></b><div class="smalltext">(enlace externo)</div></td>
								<td>
									<input type="text" name="userpicpersonal" size="50" value="', $context['member']['avatar']['external'], '" onfocus="selectRadioByName(document.forms.creator.avatar_choice, \'external\');" onchange="if (typeof(previewExternalAvatar) != \'undefined\') previewExternalAvatar(this.value);" />	<input type="hidden" name="avatar_choice" id="avatar_choice_external" value="external"/>
								</td>
							</tr>';
		}
	
	// texto personal
	echo '		<tr>
								<td width="40%">
									<b class="size11">', $txt[563], ':</b>
									<div class="smalltext">&#40;', $txt[565], '&#47;', $txt[564], '&#47;', $txt[566], '&#41;</div>
								</td>
								<td class="smalltext">
									<input type="text" name="bday2" size="2" maxlength="2" value="', $context['member']['birth_date']['day'], '" />
									<input type="text" name="bday1" size="2" maxlength="2" value="', $context['member']['birth_date']['month'], '" />
									<input type="text" name="bday3" size="4" maxlength="4" value="', $context['member']['birth_date']['year'], '" />
								</td>
							</tr>
							<tr>
								<td width="40%"><b class="size11">Pa&iacute;s: </b></td>
								<td><select name="usertitle" id="usertitle">
						<option value="' . $context['member']['title'] . '">Paises</option>
						<option value="ar">Argentina</option>
						<option value="bo">Bolivia</option>
						<option value="br">Brasil</option>
						<option value="cl">Chile</option>
						<option value="co">Colombia</option>
						<option value="cr">Costa Rica</option>
						<option value="cu">Cuba</option>
						<option value="ec">Ecuador</option>
						<option value="es">Espa&ntilde;a</option>
						<option value="gt">Guatemala</option>
						<option value="it">Italia</option>
						<option value="mx">Mexico</option>
						<option value="py">Paraguay</option>
						<option value="pe">Peru</option>
						<option value="pt">Portugal</option>
						<option value="pr">Puerto Rico</option>
						<option value="uy">Uruguay</option>
						<option value="ve">Venezuela</option>
						<option value="ot">Otro</option>						
						</select></td>
							</tr>
							<tr>
								<td width="40%"><b class="size11">', $txt[227], ': </b></td>
								<td><input type="text" name="location" size="50" value="', $context['member']['location'], '" /></td>
							</tr>
							<tr>
								<td width="40%"><b class="size11">', $txt[231], ': </b></td>
								<td>
									<select name="gender" size="1">
													<option value="1"', ($context['member']['gender']['name'] == 'm' ? ' selected="selected"' : ''), '>', $txt[238], '</option>
										<option value="2"', ($context['member']['gender']['name'] == 'f' ? ' selected="selected"' : ''), '>', $txt[239], '</option>
									</select>
								</td>
							</tr>

							<tr>
								<td width="20%"><b class="size11">', $txt[228], ':</b><div class="smalltext">(aparecera debajo del avatar)</div></td>
								<td><input type="text" name="personalText" size="50" maxlength="21" value="', $context['member']['blurb'], '" /></td>
							</tr>';


//firma
	if ($context['signature_enabled'])
	{
	echo '<tr><td width="20%"><b class="size11">', $txt[85], ':</b><div class="smalltext">(aparecera debajo tu post)</div></td><td>
									<textarea class="editor" onkeyup="calcCharLeft();" name="signature" rows="5" cols="50">', $context['member']['signature'], '</textarea><br />';

	if (!empty($context['max_signature_length']))
		echo '
									<span class="smalltext">', $txt[664], ' <span id="signatureLeft">', $context['max_signature_length'], '</span></span>';

	echo '
									<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
										function tick()
										{
											if (typeof(document.forms.creator) != "undefined")
											{
												calcCharLeft();
												setTimeout("tick()", 1000);
											}
											else
												setTimeout("tick()", 800);
										}

										function calcCharLeft()
										{
											var maxLength = ', $context['signature_limits']['max_length'], ';
											var oldSignature = "", currentSignature = document.forms.creator.signature.value;

											if (!document.getElementById("signatureLeft"))
												return;

											if (oldSignature != currentSignature)
											{
												oldSignature = currentSignature;

												if (currentSignature.replace(/\r/, "").length > maxLength)
													document.forms.creator.signature.value = currentSignature.replace(/\r/, "").substring(0, maxLength);
												currentSignature = document.forms.creator.signature.value.replace(/\r/, "");
											}

											setInnerHTML(document.getElementById("signatureLeft"), maxLength - currentSignature.length);
										}

										setTimeout("tick()", 800);
									// ]]></script>
								</td>
							</tr>';
							}
	echo '
<tr>
								<td width="20%"><b class="size11">', $txt['MSN'], ': </b><div class="smalltext">', $txt['smf237'], '</div></td>
								<td><input type="text" name="MSN" value="', $context['member']['msn']['name'], '" size="50"/></td>
							</tr>
									
						<tr>
								<td width="20%"><b class="size11">', $txt[84], ': </b><div class="smalltext">', $txt[599], '</div></td>
								<td><input type="text" name="websiteTitle" size="50" value="', $context['member']['website']['title'], '" /></td>
							</tr>';
								template_profile_save();

	echo '
						</table>
					</td>
				</tr>
			</table>';

	if (!empty($context['member']['avatar']['allow_server_stored']))
		echo '
			<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
				var files = ["' . implode('", "', $context['avatar_list']) . '"];
				var avatar = document.getElementById("avatar");
				var cat = document.getElementById("cat");
				var selavatar = "' . $context['avatar_selected'] . '";
				var avatardir = "' . $modSettings['avatar_url'] . '/";
				var size = avatar.alt.substr(3, 2) + " " + avatar.alt.substr(0, 2) + String.fromCharCode(117, 98, 116);
				var file = document.getElementById("file");

				if (avatar.src.indexOf("blank.gif") > -1)
					changeSel(selavatar);
				else
					previewExternalAvatar(avatar.src)

				function changeSel(selected)
				{
					if (cat.selectedIndex == -1)
						return;

					if (cat.options[cat.selectedIndex].value.indexOf("/") > 0)
					{
						var i;
						var count = 0;

						file.style.display = "inline";
						file.disabled = false;

						for (i = file.length; i >= 0; i = i - 1)
							file.options[i] = null;

						for (i = 0; i < files.length; i++)
							if (files[i].indexOf(cat.options[cat.selectedIndex].value) == 0)
							{
								var filename = files[i].substr(files[i].indexOf("/") + 1);
								var showFilename = filename.substr(0, filename.lastIndexOf("."));
								showFilename = showFilename.replace(/[_]/g, " ");

								file.options[count] = new Option(showFilename, files[i]);

								if (filename == selected)
								{
									if (file.options.defaultSelected)
										file.options[count].defaultSelected = true;
									else
										file.options[count].selected = true;
								}

								count++;
							}

						if (file.selectedIndex == -1 && file.options[0])
							file.options[0].selected = true;

						showAvatar();
					}
					else
					{
						file.style.display = "none";
						file.disabled = true;
						document.getElementById("avatar").src = avatardir + cat.options[cat.selectedIndex].value;
						document.getElementById("avatar").style.width = "";
						document.getElementById("avatar").style.height = "";
					}
				}

				function showAvatar()
				{
					if (file.selectedIndex == -1)
						return;

					document.getElementById("avatar").src = avatardir + file.options[file.selectedIndex].value;
					document.getElementById("avatar").alt = file.options[file.selectedIndex].text;
					document.getElementById("avatar").alt += file.options[file.selectedIndex].text == size ? "!" : "";
					document.getElementById("avatar").style.width = "";
					document.getElementById("avatar").style.height = "";
				}

				function previewExternalAvatar(src)
				{
					if (!document.getElementById("avatar"))
						return;

					var maxHeight = ', !empty($modSettings['avatar_max_height_external']) ? $modSettings['avatar_max_height_external'] : 0, ';
					var maxWidth = ', !empty($modSettings['avatar_max_width_external']) ? $modSettings['avatar_max_width_external'] : 0, ';
					var tempImage = new Image();

					tempImage.src = src;
					if (maxWidth != 0 && tempImage.width > maxWidth)
					{
						document.getElementById("avatar").style.height = parseInt((maxWidth * tempImage.height) / tempImage.width) + "px";
						document.getElementById("avatar").style.width = maxWidth + "px";
					}
					else if (maxHeight != 0 && tempImage.height > maxHeight)
					{
						document.getElementById("avatar").style.width = parseInt((maxHeight * tempImage.width) / tempImage.height) + "px";
						document.getElementById("avatar").style.height = maxHeight + "px";
					}
					document.getElementById("avatar").src = src;
				}
			// ]]></script>';
	echo '
		</form>';
}

function template_theme(){}
function template_notification(){}
function template_pmprefs(){}
function template_deleteAccount()
{
	global $context, $settings, $options, $scripturl, $txt, $scripturl;

	echo '
		<form action="', $scripturl, '?action=profile2" method="post" accept-charset="', $context['character_set'], '" name="creator" id="creator">
			<table border="0" width="85%" cellspacing="1" cellpadding="4" align="center" class="bordercolor">
				<tr class="titlebg">
					<td height="26">
						&nbsp;<img src="', $settings['images_url'], '/icons/profile_sm.gif" alt="" align="top" />&nbsp;
						', $txt['deleteAccount'], '
					</td>
				</tr>';
	if (!$context['user']['is_owner'])
	echo '
					<tr class="windowbg">
						<td class="smalltext" colspan="2" style="padding-top: 2ex; padding-bottom: 2ex;">
							', $txt['deleteAccount_desc'], '
						</td>
					</tr>';
	echo '
				<tr>
					<td class="windowbg2">
						<table width="100%" cellspacing="0" cellpadding="3"><tr>
							<td align="center" colspan="2">';
	if ($context['needs_approval'])
		echo '
								<div style="color: red; border: 2px dashed red; padding: 4px;">', $txt['deleteAccount_approval'], '</div><br />
							</td>
						</tr><tr>
							<td align="center" colspan="2">';

	// If the user is deleting their own account warn them first - and require a password!
	if ($context['user']['is_owner'])
	{
		echo '
								<span style="color: red;">', $txt['own_profile_confirm'], '</span><br /><br />
							</td>
						</tr><tr>
							<td class="windowbg2" align="', !$context['right_to_left'] ? 'right' : 'left', '">
								<b', (isset($context['modify_error']['bad_password']) || isset($context['modify_error']['no_password']) ? ' style="color: red;"' : ''), '>', $txt['smf241'], ': </b>
							</td>
							<td class="windowbg2" align="', !$context['right_to_left'] ? 'left' : 'right', '">
								<input type="password" name="oldpasswrd" size="20" />&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="login" type="submit" value="', $txt[163], '" />
								<input type="hidden" name="sc" value="', $context['session_id'], '" />
								<input type="hidden" name="userID" value="', $context['member']['id'], '" />
								<input type="hidden" name="sa" value="', $context['menu_item_selected'], '" />
							</td>';
	}

	else
	{
		echo '
								<div style="color: red; margin-bottom: 2ex;">', $txt['deleteAccount_warning'], '</div>
							</td>
						</tr>';

		if ($context['can_delete_posts'])
			echo '
						<tr>
							<td colspan="2" align="center">
								', $txt['deleteAccount_posts'], ': <select name="remove_type">
									<option value="none">', $txt['deleteAccount_none'], '</option>
									<option value="posts">', $txt['deleteAccount_all_posts'], '</option>
									<option value="topics">', $txt['deleteAccount_topics'], '</option>
								</select>
							</td>
						</tr>';

		echo '
						<tr>
							<td colspan="2" align="center">
								<label for="deleteAccount"><input type="checkbox" name="deleteAccount" id="deleteAccount" value="1" class="check" onclick="if (this.checked) return confirm(\'', $txt['deleteAccount_confirm'], '\');" /> ', $txt['deleteAccount_member'], '.</label>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="windowbg2" align="center" style="padding-top: 2ex;">
								<input class="login" type="submit" value="', $txt['smf138'], '" />
								<input type="hidden" name="sc" value="', $context['session_id'], '" />
								<input type="hidden" name="userID" value="', $context['member']['id'], '" />
								<input type="hidden" name="sa" value="', $context['menu_item_selected'], '" />
							</td>';
	}
	echo '
						</tr></table>
					</td>
				</tr>
			</table>
		</form>';
}
function template_profile_save()
{
	global $context, $settings, $options, $txt;

	echo '<tr>';

	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
								<td width="40%">
									<b class="size11"', isset($context['modify_error']['bad_password']) || isset($context['modify_error']['no_password']) ? ' style="color: red;"' : '', '>Contrase&ntilde;a actual: </b>
									<div class="smalltext">', $txt['smf244'], '</div>
								</td>
								<td><input type="password" name="oldpasswrd" size="20" style="margin-right: 4ex;" />';
	else
		echo '
											
								<td align="center" colspan="2">';

	echo '												<b class="size11" style="color: red;">Contrase&ntilde;a actual: </b>
									<input type="password" name="oldpasswrd" size="20" style="margin-left: 4ex;" />
									<div class="smalltext">', $txt['smf244'], '</div>
								</td>
								<td>
	<br><br><input class="login" type="submit" value="Guardar Cambios" />
	                              <input type="hidden" name="sc" value="', $context['session_id'], '" />
									<input type="hidden" name="userID" value="', $context['member']['id'], '" />
									<input type="hidden" name="sa" value="', $context['menu_item_selected'], '" />
								</td>
							</tr>
						
		';
}
function template_post()
{
global $context, $settings, $options, $scripturl, $modSettings, $txt;
echo'<table align="center" style="float: left;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Posts de ', $context['member']['name'], '</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
          <div class="box_icono" style="width: 100%">';
	if (!empty($context['posts'])){
foreach ($context['posts'] as $post){
echo '<table width="100%"><tr><td width="100%"><div style="float: left;"><div class="box_icono4"><img title="'.$post['board']['name'].'" src="/Themes/default/images/post/icono_'.$post['board']['id'].'.gif" ></div>&nbsp;<span title="', $post['subject'], '"><a href="/post/', $post['topic'], '" >', $post['subject'], '</a></span></div><div align="right" class="opc_fav">Creado: ', $post['time'],' | ', $post['puntos'],' pts. |<a title="Enviar a amigo" href="/index.php?action=enviar-a-amigo;topic=', $post['id'],'"><img src="/Themes/default/images/icons/icono-enviar-mensaje.gif"></a></div></td></tr></table>';}
echo'</div>';
if ($context['page_index'])
echo'<div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';}
else
echo '<br><br><center><b>', $context['member']['name'], '</b> no tiene posts...</center><br><br>';
   
   echo'</div><td></tr></table>   
   <table align="center" style="float: left;" width="204px"><tr>
<td>
         <div style="height:18px;">
         <table height="18px" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Publicidad</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
           <div class="box_icono" style="width: 100%;"><center>
		   '; //Publicidad AQUÍ 
		   echo'
		   </center>
		   </div></div>        
</td></tr></table>';
}

function template_error_message()
{
	global $context, $txt;

	echo '
		<div class="windowbg" style="margin: 1ex; padding: 1ex 2ex; border: 1px dashed red; color: red;">
			<span style="text-decoration: underline;">', $txt['profile_errors_occurred'], ':</span>
			<ul>';

		foreach ($context['post_errors'] as $error)
					echo '
				<li>', $txt['profile_error_' . $error], '.</li>';

		echo '
			</ul>
		</div>';
}
?>