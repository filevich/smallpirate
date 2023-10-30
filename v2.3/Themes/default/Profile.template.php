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
    global $context, $settings, $options, $scripturl, $modSettings, $txt, $db_prefix;
    
$noimg = $context['member']['name'] . $txt['no_image_gallery'];
$nopost = $context['member']['name'] . $txt['no_post'];
$iduser = $context['member']['id'];
$firma = str_replace('if(this.width >720) {this.width=720}','if(this.width >353) {this.width=353}', $context['member']['signature']);

echo'</div></div>';

// aca marca los comentarios de los usuarios
$request = db_query("
SELECT *
FROM {$db_prefix}comentarios
WHERE id_user = $iduser
", __FILE__, __LINE__);
$context['comentuser'] = mysql_num_rows($request);
	  		
echo'</div><div style="float:left;" align="left">
		  

<div class="act_comments"  style="margin-left:15px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>', $context['member']['name'], '</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;"> <div class="perfil_avatar" >', $context['member']['avatar']['image'], '</div><div class="statsinfo"><b class="size11">',$txt['range'],'</b> <span class="size11">', (!empty($context['member']['group']) ? $context['member']['group'] : $context['member']['post_group']), '</span>';

//Verifica que no seas tu
if(!$context['user']['is_owner']){
echo'<br><b class="size11">',$txt[friend],'</b> <span class="size11">';
echo'<a href="', $scripturl, '?action=buddies;sa=add;u=', $context['member']['id'], ';sesc=', $context['session_id'], '">[', $txt['buddy_add'], ']</a></span>';
}
echo'<br><b class="size11">',$txt[see_friend],' ', $context['member']['name'], ':</b> <span class="size11">';


echo'<a href="', $scripturl ,'?action=profile;u=', $context['member']['id'], ';sa=buddies">[Amigos]</a></span>';

// sexo
	if ($context['member']['gender']['name'])
	echo '<br><b class="size11">',$txt[sex],' </b> <span class="size11">', $context['member']['gender']['name'], '</span>';
// Only show the email address if it's not hidden.
	if ($context['member']['email_public'])
		echo '<br>
						<b class="size11">',$txt[email],' </b> <span class="size11">', $context['member']['email'], '</span>';
	// ... Or if the one looking at the profile is an admin they can see it anyway.
	elseif (!$context['member']['hide_email'])
		echo '<br>
						<b class="size11">',$txt[email],' </b> <span class="size11">', $context['member']['email'], '</span>';
	else
		echo '<br>
						<b class="size11">',$txt[email],' </b> <span class="size11"><i>', $txt[722], '</i></span>';

//pa�s
	if($context['member']['title'])
			{echo'<br><b class="size11">',$txt[country],'</b> <span class="size11">'. pais($context['member']['title'])  . ' <img title="'. pais($context['member']['title'])  . '" src="', $settings['images_url']  ,'/icons/banderas/'.$context['member']['title'].'.gif"></span>';}
			else
			echo'<br><b class="size11">',$txt[country],'</b> <img src="', $settings['images_url']  ,'/icons/banderas/ot.gif">';
//ubicacion
if ($context['member']['location'])
echo'<br><b class="size11">&nbsp;', $txt[227], ':</b> <span class="size11">', $context['member']['location'], '</span>';
       		          	  
//web
	if ($context['member']['website']['title'])
    echo'<br><b class="size11">',$txt[sitew],' </b> <span class="size11"><a href="http://'. url($context['member']['website']['title'])  . '" target="_blank">http://'. url($context['member']['website']['title'])  . '</a></span>';
	
//mensajero
   if ($context['member']['msn']['name'])
	echo '<br>
	<b class="size11">&nbsp;', $txt['MSN'], ': </b> <span class="size11">', $context['member']['msn']['name'], '</span>';

	echo'<br>
	<b class"size11">',$txt[message],' </b> <span class="size11">', $context['member']['blurb'], ' </span>';

//edad
if ($context['member']['age'])
echo'<br><b class="size11">&nbsp;', $txt[420], ':</b> <span class="size11">', $context['member']['age'] , '</span>

<br><b class="size11">',$txt[user_time],' </b> <span class="size11">', $context['member']['registered'], '</span>
<br><b class="size11">',$txt['accumulated_points'],' </b>  <span class="size11">', $context['member']['money'], '</span>';
	echo'<br>
          <a style="text-decoration:none" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=post"><b class="size11">',$txt['posts'],'</b></a> <span class="size11">', $context['member']['topics'], '</span>';
	echo'<br>
          <a style="text-decoration:none" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=comentarios"><b class="size11">',$txt['comments'],'</b></a> <span class"size11">',$context['comentuser'], '</span>';
	echo'<br>
		  <a style="text-decoration:none" href="', $scripturl, '?action=imagenes&usuario=', $context['member']['name'], '"><b class="size11">',$txt['imagesx'],'</b></a> <span class="size11">', $context['count'] ,'</span>';
echo' <br><br>

		<font class="size11" style="float:center"><img src="', $settings['images_url'] ,'/icons/enviarmp.gif" alt="',$txt['to_send_mp'],' ', $context['member']['name'], '" border="0" align="absmiddle"> <a href="' . $scripturl . '?action=pm;sa=send;u=' . $context['member']['id'] . '" title="',$txt['to_send_mp'],' ', $context['member']['name'], '"><b>',$txt['to_send_message'],'</b></a></font>';
			
	  
  	if (!empty($context['activate_message']) || !empty($context['member']['bans']))
	{
		if (!empty($context['activate_message']))
			echo '<br><span style="color: red;">', $context['activate_message'], '</span>&nbsp;(<a href="' . $scripturl . '?action=profile2;sa=activateAccount;userID=' . $context['member']['id'] . ';sesc=' . $context['session_id'] . '" ', ($context['activate_type'] == 4 ? 'onclick="return confirm(\'' . $txt['profileConfirm'] . '\');"' : ''), '>', $context['activate_link_text'], '</a>)';

if (!empty($context['member']['bans'])){echo '<br><span style="color: red;"><center><img title="', $txt['user_is_banned'], '" alt="', $txt['user_is_banned'], '" border="0" src="', $settings['images_url']  ,'/icons/show_sticky.gif"> ', $txt['user_is_banned'], '</center></span>';}}echo'</div></div><br>';

echo '<div style="float:left;"><div class="box_363" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['appearance'],'</center></div><div class="box_rss"><div class="icon_img"><img src="Themes/default/images/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;">
<b class="size14">',$txt['appearance'],':</b>
<div align="left">
<br><b class="size11">',$txt['stature'],':</b><span class="size11"> ', $context['member']['options']['altura'] ,' ',$txt['cm'],'</span><br>
<b class="size11">',$txt['weight'],':</b><span class="size11"> ', $context['member']['options']['peso'] ,' ',$txt['kg'],'</span><br>
<b class="size11">',$txt['physical'],':</b><span class="size11"> ', $context['member']['options']['fisico'] ,'</span><br>
<b class="size11">',$txt['hair'],':</b><span class="size11"> ', @$context['member']['options']['cabello'] ,'</span><br>
<b class="size11">',$txt['eyes'],':</b><span class="size11"> ', @$context['member']['options']['ojos'] ,'</span><br>
<b class="size11">',$txt['color_skin'],':</b><span class="size11"> ', @$context['member']['options']['colorpiel'] ,'</span><br>

<br><center><hr></center><br>

<b class="size14">',$txt['interests'],':</b><br>
<br><b class="size11">',$txt['i_like'],':</b><span class="size11"> ', @$context['member']['options']['gustar'] ,'</span><br>
<b class="size11">',$txt['favorite_band'],':</b><span class="size11"> ', @$context['member']['options']['banda'] ,'</span><br>
<b class="size11">',$txt['hobbie'],':</b><span class="size11"> ', @$context['member']['options']['hobbie'] ,'</span><br>
<b class="size11">',$txt['sport'],':</b><span class="size11"> ', @$context['member']['options']['deporte'] ,'</span><br>
<b class="size11">',$txt['eq'],':</b><span class="size11"> ', @$context['member']['options']['equipo'] ,'</span><br>
<b class="size11">',$txt['favorite_food'],':</b><span class="size11"> ', @$context['member']['options']['comida'] ,'</span><br>
<b class="size11">',$txt['book'],':</b><span class="size11"> ', @$context['member']['options']['libro'] ,'</span><br>
<b class="size11">',$txt['favorite_place'],':</b><span class="size11"> ', @$context['member']['options']['lugar'] ,'</span><br>
<b class="size11">',$txt['favorite_movie'],':</b><span class="size11"> ', @$context['member']['options']['pelicula'] ,'</span><br>
</div></div>';

		

// ip del usuario
if ($context['user']['is_admin'])
	{echo'<br><div class="act_comments" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['ip_user'],'</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;">
			<b class="size11">&nbsp;', $txt[512], ':</b> <span class="size11"><a href="', $scripturl, '?action=trackip;searchip=', $context['member']['ip'], '" target="_blank">', $context['member']['ip'], '</a></span><br>
			<b class="size11">&nbsp;', $txt['hostname'], ':</b> <span class="size11">', $context['member']['hostname'], '</span><br> <b class="size11">&nbsp;', $txt['lastLoggedIn'], ': </b> <span class="size11">', $context['member']['last_login'], '</span></div>';
	}
	
$iduser = $context['member']['id'];		
	
//firma

echo'</div></div></div></div><div style="float:left;">';
echo'</div></div></div><div style="float:left; margin-right:8px;">';

		
		
//Destacados
		echo '<div class="box_363" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['stand_out'],'</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;"><center>'; ssi_destacado(); echo'</center></div><div style="float:left; margin-right:8px;" align="left">';

//ultimos post del usuario
echo'<br><div style="float:left; margin-right: 5px;"><div class="act_comments" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['last_post'],'</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;word-wrap: break-word;overflow:hidden;">';
if (!empty($context['posts']))
	{
				foreach ($context['posts'] as $post)
		{
			echo '	<table width="100%">
				<tr><td width="100%">
<div class="box_icono4"><img title="', $post['board']['name'], '" src="', $settings['images_url']  ,'/post/icono_', $post['board']['id'], '.gif"></div>';
if ($context['user']['is_guest']){if ($post['can_view_post']){echo'';} 
else echo'<img title="',$txt['private_post'],'" src="', $settings['images_url']  ,'/icons/icono-post-privado.gif">';}
echo'<div class="hov_post"><a href="', $scripturl, '?topic=', $post['topic'], '">', $post['subject'], '</a></div>
						</td>
				</tr></table>
';}

echo'</div><div class="box_icono"><center><a href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=post">',$txt['to_see_more'],'</a></center></div>';}
else echo'<br><center><img title="',$nopost,'" alt="',$nopost,'" border="0" src="', $settings['images_url']  ,'/icons/show_sticky.gif"> ',$nopost,'</center><br></div>';   
echo'</div><br>';

// imagenes del usuario
echo'<div class="act_comments" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['images'],'</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;">';
if ($context['img']){
foreach ($context['img'] as $img)
{echo'
<a href="', $scripturl, '?action=imagenes;sa=ver;id=' . $img['id'] . '" class="tooltip" title="' . $img['commenttotal'] . ' ',$txt['commentsx'],'"><img src="' . $img['filename'] . '" width="115" height="100"/></img></a>';

				}echo'</div><div class="box_icono"><center><a href="', $scripturl, '?action=imagenes&usuario=', $context['member']['name'], '">',$txt['go_to_gallery'],'</a></center>';}
				else echo'<br><center><img title="',$noimg,'"  alt="',$noimg,'" border="0" src="', $settings['images_url']  ,'/icons/show_sticky.gif"> ',$noimg,'</center><br></div>';
echo'</div><br>';				


// sistema de referidos
echo'<div class="act_comments" style="margin-bottom:8px;">
<div class="box_title" style="width: 363px;"><div class="box_txt box_363-34"><center>',$txt['ref'],'</center></div><div class="box_rss"><div class="icon_img"><img src="', $settings['images_url']  ,'/blank.gif"></div></div></div>
<div class="windowbg" style="width: 353px; padding: 4px;">';

// Adds the referral/referred user information to the profile summary
	echo '
				<div>
					
				
					&nbsp;<b>', $txt['referrals_referrals'], '</b>
					', $context['member']['referrals_no'];

	// Show in dropdown of those referred
	if (!empty($context['member']['referred_members'])){
		echo '  <select onchange="location=options[selectedIndex].value;">
							<option>', $txt['referrals_membersreferred'], '</option>';

		foreach($context['member']['referred_members'] as $referred)
			echo '
							', $referred;

		echo '
						</select>';
	}

		echo '
					
				&nbsp;<b><br>&nbsp;', $txt['referrals_referrals_hits'], '</b>
					', $context['member']['referrals_hits'], '
				';

		if (!empty($context['member']['referred_by']))
			echo'
				
					<br>&nbsp;<b>', $txt['referrals_referred_by'], '</b>
					', $context['member']['referred_by_link'], ' ', $txt['referrals_on'], ' ', date("jS M Y",$context['member']['referred_on']), '
				';

		echo '
				<br>&nbsp;<b>', $txt['referrals_link'], '</b>
				
				
					
						<input type="text" id="referral_link" value="', $scripturl, '?referredby=', $context['member']['id'], '" readonly="true" style="width:170px;" />
					
				</div></div>';
		
				echo'</div></div></div></div></div></div></div></div>';

// estadoo
	echo '<div style="float:left;">
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat"><center>',$txt['State'],'</center></div>
<div class="box_rss"><img src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="box_icono2">
<center><option', @$context['member']['options']['bear_tab'] == 'bar' ? ' selected="selected"' : '', '>
				
				', !empty($context['member']['options']['bear_tab']) ? '
				<img style="width: 16px;height:16px" alt="" title="' . $context['member']['options']['bear_tab'] . '" src="' . $settings['default_images_url'] . '/estado/' . $context['member']['options']['bear_tab'] . '.gif"/>' : '', '
</center><hr><center>', $settings['use_image_buttons'] ? '<img src="' . $context['member']['online']['image_href'] . '" alt="' . $context['member']['online']['text'] . '" align="middle" /></a>' : '', $settings['use_image_buttons'] ? '<span class="smalltext"> ' . $context['member']['online']['text'] . '</span>' : '', '</center>
'; 
echo '</div></div>';

			
	   if (!$context['user']['is_owner'] && $context['can_send_pm'])
		 { echo'
		   <div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat"><center>Opciones<center></div>
<div class="box_rss"><img src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0" ></div></div><div class="box_icono2">'; 	
	echo '<b class="size12"><img src="', $settings['images_url']  ,'/im_on.gif" alt="',$txt['to_send_mp'],' ', $context['member']['name'], '" border="0" align="absmiddle" /> <a href="', $scripturl, '?action=pm;sa=send;u=', $context['member']['id'], '" title="',$txt['to_send_mp'],' ', $context['member']['name'], '">',$txt['to_send_message'],'</a><br>

<img title="',$txt['gd'],' ', $context['member']['name'], '" src="', $settings['images_url']  ,'/icons/icono-foto.gif" alt="',$txt['gd'],' ', $context['member']['name'], '" border="0" align="absmiddle"> <a href="', $scripturl, '?action=imagenes&usuario=', $context['member']['name'], '" title="',$txt['gd'],' ', $context['member']['name'], '" alt="',$txt['gd'],' ', $context['member']['name'], '">',$txt['to_see_ga'],'</a><br>';

if ($context['allow_admin']){
echo'
<img src="', $settings['images_url']  ,'/icons/show_sticky.gif" align="absmiddle" alt="',$txt['ban_user'],'" title="',$txt['ban_user'],'" border"0"/> <a title="',$txt['ban_user'],'" href="', $scripturl, '?action=ban;sa=add;u=', $context['member']['id'], '"><font color="#610B0B">',$txt['ban_user'],'</font></a><br>';}

if ($context['user']['is_admin'])
	{
echo'<img src="', $settings['images_url']  ,'/icons/show_sticky.gif"  align="absmiddle"  alt="',$txt['user_rake'],'" title="',$txt['user_rake'],'" border"0"/> <a title="',$txt['user_rake'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=trackUser"><font color="#610B0B">',$txt['user_rake'],'</font></a><br>

<img src="', $settings['images_url']  ,'/icons/show_sticky.gif" align="absmiddle" alt="',$txt['ip_rake'],'" title="',$txt['ip_rake'],'" border"0"/> <a title="',$txt['ip_rake'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=trackIP"><font color="#610B0B">',$txt['ip_rake'],'</font></a><br>

<img src="', $settings['images_url']  ,'/icons/show_sticky.gif" align="absmiddle" alt="',$txt['del_account'],'" title="',$txt['del_account'],'" border"0"/> <a title="',$txt['del_account'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=deleteAccount"><font color="#610B0B">',$txt['del_account'],'</font></a><br>

<img alt="',$txt['edit_account'],'" src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle" border="0" width="16" height="16"> <a title="',$txt['edit_account'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=cuenta">',$txt['edit_account'],'</a><br>

<img alt="',$txt['edit_profile'],'" src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"  border="0" width="16" height="16">  <a title="',$txt['edit_profile'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=perfil">
Editar este perfil</a>
<br>

<img alt="',$txt['edit_avatar'],'" src="', $settings['images_url']  ,'/icons/icon-avatar.png" border="0" width="16" height="16" align="absmiddle"> <a title="',$txt['edit_avatar'],'" href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=avatar">
',$txt['edit_avatar'],'</a></b>';}

   echo'</div></div><br>';}
          
		  
		  
          if ($context['profile_areas']){
   echo'<br>
<div class="img_aletat">
<b class="size12">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat"><center>',$txt['my_account'],'</center></div>
<div class="box_rss"><img src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="box_icono2">&nbsp;<img alt="',$txt['edit_profile'],'" src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle" border="0" width="16" height="16"> <a title="',$txt['edit_profile'],'" href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_profile'],'</a><br>
&nbsp;<img alt="',$txt['edit_profile'],'" src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle" border="0" width="16" height="16">  <a title="',$txt['edit_profile'],'" href="', $scripturl, '?action=profile;sa=perfil">
',$txt['edit_profile'],'</a><br>
&nbsp;<img alt="',$txt['add_image'],'" src="', $settings['images_url']  ,'/icons/icono-foto-agregar.gif" align="absmiddle" border="0" width="16" height="16"> <a title="',$txt['add_image'],'" href="', $scripturl, '?action=imagenes;sa=agregar">
',$txt['add_image'],'</a><br>
&nbsp;<img alt="',$txt['modify_avatar'],'" src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle" border="0" width="16" height="16"> <a title="',$txt['modify_avatar'],'" href="', $scripturl, '?action=profile;sa=avatar">
',$txt['modify_avatar'],'</a><br>
&nbsp;<img alt="',$txt['change_state'],'" src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle" border="0" width="16" height="16"> <a title="',$txt['change_state'],'" href="', $scripturl, '?action=profile;sa=estado">
',$txt['change_state'],'</a></div></div></div></b>';}
	        
}



function template_comentarios()
{
global $context, $settings, $options, $scripturl, $modSettings, $txt;
echo'<table width="757px" style="float: left; margin-right; 8px;"><tr><td>

<div class="box_757">
<div class="box_title" style="width: 757px;"><div class="box_txt box_757-34"><center>',$txt['last_50_comments'],' ', $context['member']['name'], '</center></center></div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0"></div></div></div>
<table width="757px" cellpadding="3" cellspacing="1" class="windowbg"><tr><td>';
		if (!empty($context['cposts'])){
foreach ($context['cposts'] as $cpost){
echo '<table width="100%"><tr><td valign="top" width="16px"><img title="" src="', $settings['images_url']  ,'/post/icono_'.$cpost['ID_BOARD'].'.gif" ></td><td><b class="size11" title="' . $cpost['subject'] . '"><a href="?topic=', $cpost['ID_TOPIC'], '" >' . $cpost['subject'] . '</a></b><div class="size11">' . $cpost['posterTime'] . ': <a href="?topic=', $cpost['ID_TOPIC'], '#cmt_', $cpost['id_coment'], '" >' . $cpost['body'] . '</a></div></td></tr></table>';}
echo'</div>';
if ($context['page_index'])
echo'<div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';}
else
echo '<br><br><center><b>', $context['member']['name'], '</b> ',$txt['no_comments'],'</center><br><br>';
   
   echo'</form></div></td></tr></table></td></tr></table>
    <table width="160px" style="float: left; margin-right; 8px;"><tr><td>

  <div style="float: left; margin-bottom:8px;" class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">',$txt['advertising'],'</div>
<div class="box_rss"><img src="', $settings['images_url']  ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" style="width: 150px; padding: 4px;"><center><script type="text/javascript"><!--
google_ad_client = "pub-7516357570798900";
/* 120x600, creado 26/07/09 */
google_ad_slot = "7444757519";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br></div></div></td></tr></table>';

}

function template_editBuddies()


{


	global $context, $settings, $options, $scripturl, $modSettings, $txt;





	echo '


		<table border="0" width="85%" cellspacing="1" cellpadding="4" class="bordercolor" align="center">


			<tr class="titlebg">


				<td colspan="8" height="26">


					&nbsp;<img src="', $settings['images_url'], '/icons/profile_sm.gif" alt="" align="top" />&nbsp;', $txt['editBuddies'], '


				</td>


			</tr>


			<tr class="catbg3">


				<td width="20%">', $txt[68], '</td>


				<td>', $txt['online8'], '</td>


				<td>', $txt[69], '</td>


				<td align="center">', $txt[513], '</td>


				<td align="center">', $txt[603], '</td>


				<td align="center">', $txt[604], '</td>


				<td align="center">', $txt['MSN'], '</td>


				<td></td>


			</tr>';





	// If they don't have any buddies don't list them!


	if (empty($context['buddies']))


		echo '


			<tr class="windowbg">


				<td colspan="8" align="center"><b>', $txt['no_buddies'], '</b></td>


			</tr>';





	// Now loop through each buddy showing info on each.


	$alternate = false;


	foreach ($context['buddies'] as $buddy)


	{


		echo '


			<tr class="', $alternate ? 'windowbg' : 'windowbg2', '">


				<td>', $buddy['link'], '</td>


				<td align="center"><a href="', $buddy['online']['href'], '"><img src="', $buddy['online']['image_href'], '" alt="', $buddy['online']['label'], '" title="', $buddy['online']['label'], '" /></a></td>


				<td align="center">', ($buddy['hide_email'] ? '' : '<a href="mailto:' . $buddy['email'] . '"><img src="' . $settings['images_url'] . '/email_sm.gif" alt="' . $txt[69] . '" title="' . $txt[69] . ' ' . $buddy['name'] . '" /></a>'), '</td>


				<td align="center">', $buddy['icq']['link'], '</td>


				<td align="center">', $buddy['aim']['link'], '</td>


				<td align="center">', $buddy['yim']['link'], '</td>


				<td align="center">', $buddy['msn']['link'], '</td>


				<td align="center"><a href="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=editBuddies;remove=', $buddy['id'], '"><img src="', $settings['images_url'], '/icons/delete.gif" alt="', $txt['buddy_remove'], '" title="', $txt['buddy_remove'], '" /></a></td>


			</tr>';





		$alternate = !$alternate;


	}





	echo '


		</table>';





	// Add a new buddy?


	echo '


	<br />


	<form action="', $scripturl, '?action=profile;u=', $context['member']['id'], ';sa=editBuddies" method="post" accept-charset="', $context['character_set'], '">


		<table width="65%" cellpadding="4" cellspacing="0" class="tborder" align="center">


			<tr class="titlebg">


				<td colspan="2">', $txt['buddy_add'], '</td>


			</tr>


			<tr class="windowbg">


				<td width="45%">


					<b>', $txt['who_member'], ':</b>


				</td>


				<td width="55%">


					<input type="text" name="new_buddy" id="new_buddy" size="25" />


					<a href="', $scripturl, '?action=findmember;input=new_buddy;quote=1;sesc=', $context['session_id'], '" onclick="return reqWin(this.href, 350, 400);"><img src="', $settings['images_url'], '/icons/assist.gif" alt="', $txt['find_members'], '" align="top" /></a>


				</td>


			</tr>


			<tr class="windowbg">


				<td colspan="2" align="right">


					<input type="submit" value="', $txt['buddy_add_button'], '" />


				</td>


			</tr>


		</table>


	</form>';


}


// This template shows an admin information on a users IP addresses used and errors attributed to them.
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
						<a href="', $scripturl, '?topic=', $message['topic'], '">
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
					alert();
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
	
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">Mis opciones</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="smalltext windowbg" style="width:130px;padding:4px;">
<b class="size12">
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url'] ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icono-foto.gif" align="absmiddle"> <a href="', $scripturl, '?action=imagenes;sa=agregar">',$txt['add_image'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">

<div class="box_780" style="float:left;">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['edit_my_account'],' &raquo;&raquo;<font color="#DF0101" size="1"> <a style="color:#DF0101;" href="', $scripturl, '?action=reminder">',$txt['change_pass'],'</a></font></center></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" ><tr><td width="20%"></b>';

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
									<b class="size11">'.$txt['user_name'].':</b><div class="smalltext">(<a href="'.$scripturl.'?action=profile;u=' . $context['member']['id'] . ';sa=cuenta;changeusername" style="font-style: italic;">' . $txt['username_change'] . '</a>)</div>
								</td>
								<td>
									<b>'. $context['member']['username']. '</b>
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
												
		// If the user is allowed to hide their email address from the public give them the option to here.
		if ($context['allow_hide_email'])
		{
			echo '
							<tr>
								<td width="40%"><b>', $txt[721], '</b><div class="smalltext">',$txt['no_email_public'],'</div></td>
								<td><input type="hidden" name="hideEmail" value="0" /><input type="checkbox" name="hideEmail"', $context['member']['hide_email'] ? ' checked="checked"' : '', ' value="1" class="check" /></td>
							</tr>';
	}


	

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

function template_apariencia()
{global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function checkProfileSubmit()
			{';
	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
				// Did you forget to type your password?
				if (document.forms.creator.oldpasswrd.value == "")
				{
					alert();
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
	
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">Mis opciones</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="windowbg" style="width:130px;padding:4px;font-size:13px;">

<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_my_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
<b class="size12">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icono-foto.gif" align="absmiddle"> <a href="', $scripturl, '?action=imagenes;sa=agregar">',$txt['add_image'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">
</b>
<div class="box_780" style="float:left;">

			<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['appearancex'],'</center></div><div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" >

<tr><td colspan="2"></td></tr>
  <td width="40%"><b>',$txt['staturex'],': </b><div class="smalltext">',$txt['insert_stature'],'</div></td>
								<td><input type="text" name="default_options[altura]" size="5" value="', @$context['member']['options']['altura'] ,'" />',$txt['cm'],'</td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['weight'],': </b><div class="smalltext">',$txt['insert_weight'],'</div></td>
								<td><input type="text" name="default_options[peso]" size="5" value="', @$context['member']['options']['peso'] ,'" />',$txt['kg'],'</td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['physical'],': </b><div class="smalltext">',$txt['state_physical'],'</div></td>
								<td><input type="text" name="default_options[fisico]" size="40" value="', @$context['member']['options']['fisico'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['hair'],': </b><div class="smalltext">',$txt['color_h'],'</div></td>
								<td><input type="text" name="default_options[cabello]" size="40" value="', @$context['member']['options']['cabello'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['eyes'],': </b><div class="smalltext">',$txt['color_e'],'</div></td>
								<td><input type="text" name="default_options[ojos]" size="40" value="', @$context['member']['options']['ojos'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['color_skin'],': </b><div class="smalltext">',$txt['color_s'],'</div></td>
								<td><input type="text" name="default_options[colorpiel]" size="40" value="', @$context['member']['options']['colorpiel'] ,'" /></td>
								<tr><td colspan="2"></td></tr>
								<td colspan="2"></td></tr>
 								
								
								';
								template_profile_save();

	echo '											


						
					</td>
				</tr></div>
			</table></table>
		</form>';
}
function template_interes()
{global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function checkProfileSubmit()
			{';
	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
				// Did you forget to type your password?
				if (document.forms.creator.oldpasswrd.value == "")
				{
					alert();
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
	
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">',$txt['my_options'],'</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="smalltext windowbg" style="width:130px;padding:4px;">
<b class="size12">
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_my_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
<b class="size12">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icono-foto.gif" align="absmiddle"> <a href="', $scripturl, '?action=imagenes;sa=agregar">',$txt['add_image'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">
</b>
<div class="box_780" style="float:left;">

			<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['interests'],'</center></div><div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" >


  <td width="40%"><b>',$txt['i_like'],': </b><div class="smalltext">',$txt['i_like_insert'],'</div></td>
								<td><input type="text" name="default_options[gustar]" size="50" value="', @$context['member']['options']['gustar'] ,'" /></td></td></tr>

  
  <td width="40%"><b>',$txt['favorite_band'],': </b><div class="smalltext">',$txt['favorite_band_insert'],'</div></td>
								<td><input type="text" name="default_options[banda]" size="50" value="', @$context['member']['options']['banda'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['hobbie'],': </b><div class="smalltext">',$txt['hobbie_insert'],'</div></td>
								<td><input type="text" name="default_options[hobbie]" size="50" value="', @$context['member']['options']['hobbie'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['sport'],': </b><div class="smalltext">',$txt['sport_insert'],'</div></td>
								<td><input type="text" name="default_options[deporte]" size="50" value="', @$context['member']['options']['deporte'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['eq'],': </b><div class="smalltext">',$txt['eq_insert'],'</div></td>
								<td><input type="text" name="default_options[equipo]" size="50" value="', @$context['member']['options']['equipo'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['favorite_food'],': </b><div class="smalltext">',$txt['favorite_food_insert'],'</div></td>
								<td><input type="text" name="default_options[comida]" size="50" value="', @$context['member']['options']['comida'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['book'],': </b><div class="smalltext">',$txt['book_insert'],'</div></td>
								<td><input type="text" name="default_options[libro]" size="50" value="', @$context['member']['options']['libro'] ,'" /></td><tr><td colspan="2"></td></tr>
 
  <td width="40%"><b>',$txt['favorite_place'],': </b><div class="smalltext">',$txt['favorite_place_insert'],'</div></td>
								<td><input type="text" name="default_options[lugar]" size="50" value="', @$context['member']['options']['lugar'] ,'" /></td><tr><td colspan="2"></td></tr>

  <td width="40%"><b>',$txt['favorite_movie'],': </b><div class="smalltext">',$txt['favorite_movie_insert'],'</div></td>
								<td><input type="text" name="default_options[pelicula]" size="50" value="', @$context['member']['options']['pelicula'] ,'" /></td><tr><td colspan="2"></td></tr></div></div>
  
								';
								template_profile_save();

	echo '											


						
					</td>
				</tr></div>
			</table></table>
		</form>';
}
function template_perfil()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	echo '
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">',$txt['my_options'],'</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="smalltext windowbg" style="width:130px;padding:4px;">
<b class="size12">
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_my_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
<b class="size12">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icono-foto.gif" align="absmiddle"> <a href="', $scripturl, '?action=imagenes;sa=agregar">',$txt['add_image'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">

<div class="box_780" style="float:left;">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['edit_my_profile'],'</center></div><div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" ><tr><td width="20%">',$txt['edit_my_profile'],'</b>';
	
	
	
			
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
								<td width="40%"><b class="size11">',$txt['country'],': </b></td>
								<td><select name="usertitle" id="usertitle">
						<option value="' . $context['member']['title'] . '">',$txt['country'],'</option>
						<option value="ar">',$txt['ar'],'</option>
						<option value="bo">',$txt['bo'],'</option>
						<option value="br">',$txt['br'],'</option>
						<option value="cl">',$txt['cl'],'</option>
						<option value="co">',$txt['co'],'</option>
						<option value="cr">',$txt['cr'],'</option>
						<option value="cu">',$txt['cu'],'</option>
						<option value="ec">',$txt['ec'],'</option>
						<option value="es">',$txt['es'],'</option>
						<option value="gt">',$txt['gt'],'</option>
						<option value="it">',$txt['it'],'</option>
						<option value="mx">',$txt['mx'],'</option>
						<option value="py">',$txt['py'],'</option>
						<option value="pe">',$txt['pe'],'</option>
						<option value="pt">',$txt['pt'],'</option>
						<option value="pr">',$txt['pr'],'</option>
						<option value="uy">',$txt['uy'],'</option>
						<option value="ve">',$txt['ve'],'</option>
						<option value="ot">',$txt['ot'],'</option>
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
								<td width="20%"><b class="size11">', $txt[228], ':</b><div class="smalltext">',$txt['under_avatar'],'</div></td>
								<td><input type="text" name="personalText" size="50" maxlength="70" value="', $context['member']['blurb'], '" /></td>
								
							</tr>
							
							
							';

	echo '
<tr>
								<td width="20%"><b class="size11">', $txt['MSN'], ': </b><div class="smalltext">', $txt['smf237'], '</div></td>
								<td><input type="text" name="MSN" value="', $context['member']['msn']['name'], '" size="50"/></td>
							</tr>
									
						
							


							';
								template_profile_save();

	echo '</div></div></div></div></div></div></div></div>
	</table></table>

				
			
			';

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
function template_avatar()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;
	echo'
<script>
function load_new_avatar()
{
	var f=document.forms.per;

	if(f.avatar.value.substring(0, 7)!="http://")
	{
		f.avatar.focus();
		alert("',$txt['alert_http'],'");
		return;
	}

	window.newAvatar = new Image();
	window.newAvatar.src = f.avatar.value;
	newAvatar.loadBeginTime = (new Date()).getTime();
	newAvatar.onerror = show_error;
	newAvatar.onload = show_new_avatar;
	avatar_check_timeout();
}

function avatar_check_timeout()
{
	if(((new Date()).getTime()-newAvatar.loadBeginTime)>15)
	{
		alert("',$txt['alert_avatar'],'");
		document.forms.per.avatar.focus();
	}
}

function show_error()
{
	alert("',$txt['alert_dir_image'],'");
	document.forms.per.avatar.focus();
}

function show_new_avatar()
{
	document.getElementById("miAvatar").src = newAvatar.src;
}
</script>';

	echo '
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">',$txt['my_options'],'</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="smalltext windowbg" style="width:130px;padding:4px;">
<b class="size12">
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_my_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
<b class="size12">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icono-foto.gif" align="absmiddle"> <a href="', $scripturl, '?action=imagenes;sa=agregar">',$txt['add_image'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">

<div class="box_780" style="float:left;">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['modify_avatar'],'</center></div><div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" ><tr></b>';
	
	
	// This is the avatar selection table that is only displayed if avatars are enabled!
	if (!empty($context['member']['avatar']['allow_server_stored']) || !empty($context['member']['avatar']['allow_upload']) || !empty($context['member']['avatar']['allow_external']))
	{
		// If users are allowed to choose avatars stored on the server show selection boxes to choice them from.
		if (!empty($context['member']['avatar']['allow_server_stored']))
		{
			echo '
							<tr>
								<td width="40%" valign="top" style="padding: 0 2px;">
									<table width="100%" cellpadding="5" cellspacing="0" border="0" style="height: 25ex;"><tr>
										<td valign="top" width="20" class="windowbg"><input type="radio" name="avatar_choice" id="avatar_choice_server_stored" value="server_stored"', ($context['member']['avatar']['choice'] == 'server_stored' ? ' checked="checked"' : ''), ' class="check" /></td>
										<td valign="top" style="padding-left: 1ex;">
											<b', (isset($context['modify_error']['bad_avatar']) ? ' style="color: red;"' : ''), '><label for="avatar_choice_server_stored">', $txt[229], ':</label></b>
											<div style="margin: 2ex;"><img name="avatar" id="avatar" src="', !empty($context['member']['avatar']['allow_external']) && $context['member']['avatar']['choice'] == 'external' ? $context['member']['avatar']['external'] : $modSettings['avatar_url'] . '/blank.gif', '" alt="Do Nothing" /></div>
										</td>
									</tr></table>
								</td>
								<td>
									<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
										<td style="width: 20ex;">
											<select name="cat" id="cat" size="10" onchange="changeSel(\'\');" onfocus="selectRadioByName(document.forms.creator.avatar_choice, \'server_stored\');">';
			// This lists all the file catergories.
			foreach ($context['avatars'] as $avatar)
				echo '
												<option value="', $avatar['filename'] . ($avatar['is_dir'] ? '/' : ''), '"', ($avatar['checked'] ? ' selected="selected"' : ''), '>', $avatar['name'], '</option>';
			echo '
											</select>
										</td>
										<td>
											<select name="file" id="file" size="10" style="display: none;" onchange="showAvatar()" onfocus="selectRadioByName(document.forms.creator.avatar_choice, \'server_stored\');" disabled="disabled"><option></option></select>
										</td>
									</tr></table>
								</td>
							</tr>';
		}

		// If the user can link to an off server avatar, show them a box to input the address.
		if (!empty($context['member']['avatar']['allow_external']))
		{
			echo '
							<tr>
								<td valign="top" style="padding: 0 2px;">
									<table width="100%" cellpadding="5" cellspacing="0" border="0"><tr>
										<td valign="top" width="20" class="windowbg"><input type="radio" name="avatar_choice" id="avatar_choice_external" value="external"', ($context['member']['avatar']['choice'] == 'external' ? ' checked="checked"' : ''), ' class="check" /></td>
										<td valign="top" style="padding-left: 1ex;"><b><label for="avatar_choice_external">', $txt[475], ':</label></b><div class="smalltext">', $txt[474], '</div></td>
									</tr></table>
								</td>
								<td valign="top">
									<input type="text" name="userpicpersonal" size="45" value="', $context['member']['avatar']['external'], '" onfocus="selectRadioByName(document.forms.creator.avatar_choice, \'external\');" onchange="if (typeof(previewExternalAvatar) != \'undefined\') previewExternalAvatar(this.value);" />
								</td>
							</tr>';
		}

		
	}							
										
									template_profile_save();

	echo '</div></div>
			</table></table>

				
			
			';
			/* If the user is allowed to choose avatars stored on the server, the below javascript is used to update the
		file listing of avatars as the user changes catergory. It also updates the preview image as they choose
		different files on the select box. */
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


function template_buddies()

{

	global $context, $settings, $txt, $scripturl;

	echo '

	<table border="0" width="85%" cellspacing="1" cellpadding="4" align="center" class="bordercolor">
		<tr class="titlebg">
			<td height="26">
				&nbsp;<img src="', $settings['images_url'], '/icons/profile_sm.gif" alt="" align="top" />&nbsp;
				<a href="', $scripturl ,'?action=profile;u=', $context['member']['id'] ,'">', $context['member']['name'] ,'</a> - ',$txt['friends'],'</td>
		</tr>
		<tr>
			<td class="windowbg2" style="padding-bottom: 2ex;">
				<table width="100%">';

	if (isset ($context['member']['buddies_data'])) {

		$i = 1;

		foreach ($context['member']['buddies_data'] as $buddy_id => $data) {

			if ($i == 1)

				echo '

					<tr>';

			echo '

						<td align="center">
							', $data['avatar_image'],'<br />
							<a href="', $scripturl , '?action=profile;u=', $data['ID_MEMBER'] , '">' , $data['realName'] , '</a><br />

							<i>', $settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/buddy_' . ($data['is_online'] ? 'useron' : 'useroff') . '.gif' . '" alt="' . $txt[$data['is_online'] ? 'online2' : 'online3'] . '" align="middle" />' : $txt[$data['is_online'] ? 'online2' : 'online3'], $settings['use_image_buttons'] ? '<span class="smalltext"> ' . $txt[$data['is_online'] ? 'online2' : 'online3'] . '</span>' : '', '</i>
						</td>';
			if ($i == 3)
				echo '
					</tr>';
			
			$i++;
			if ($i == 4) $i = 1;
		}
	} else
		echo '			<tr><td>',$txt['no_friends'],'</td></tr>';
	echo '
				</table>
			</td>
		</tr>
	</table>';
}

function template_estado()
{
        global $context, $settings, $options, $scripturl, $modSettings, $txt, $message;

	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function checkProfileSubmit()
			{';
	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
				// Did you forget to type your password?
				if (document.forms.creator.oldpasswrd.value == "")
				{
					alert();
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
	
		<div class="box_140" style="float:left;margin-right:8px;margin-bottom:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">',$txt['my_options'],'</div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div><div class="smalltext windowbg" style="width:130px;padding:4px;">
<b class="size12">
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/edit.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=perfil">',$txt['edit_my_profile'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><span style="margin-bottom:5px;"><img src="', $settings['images_url']  ,'/icons/icono-editar-cuenta.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=cuenta">',$txt['edit_my_account'],'</a></span></div><hr /><span class="size10" style="font-family:arial;"><img src="', $settings['images_url']  ,'/user.png" alt="" /> <b>',$txt['edit_appearance'],':</b><br/>
<div align="left">
 <ul style="margin:0px;padding-left:15px;">
<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=apariencia">',$txt['appearance'],'</a></li>

<li style="margin:0px;padding-left:0px;"><a href="', $scripturl, '?action=profile;sa=interes">',$txt['interests_and_preferences'],'</a></li></ul></span><hr/>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/icons/icon-avatar.png" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=avatar">',$txt['modify_avatar'],'</a></span></div>
<div align="left" style="margin-bottom:4px;"><img src="', $settings['images_url']  ,'/mcontento.gif" align="absmiddle"> <a href="', $scripturl, '?action=profile;sa=estado">',$txt['change_state'],'</a></span></div></div></div></div>
<form action="', $scripturl, '?action=profile2" method="post" accept-charset="UTF-8" name="creator" id="creator" enctype="multipart/form-data">
</b>
<div class="box_780" style="float:left;">

			<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>',$txt['change_state'],'</center></div><div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" border="0" style="width: 770px; padding: 4px;"">
<table><tr><td align="left"><table width="100%" style="padding: 4px;"  cellspacing="1" cellpadding="4" >
<tr><td width="20%">
	<tr>
							</tr><tr>
							<td><b>',$txt['select_state'],': </b></td>
							<td><select name="default_options[bear_tab]" size="8">
							<option value="bar">',$txt['no_state'],'</option>
							<option value="mcontento">',$txt['very_happy_state'],'</option>
							<option value="contento">',$txt['happy_state'],'</option>
							<option value="sueno"> ',$txt['dream_state'],'</option>
							<option value="descansar">',$txt['resting_state'],'</option>
							<option value="triste">',$txt['sad_state'],'</option>
							<option value="enferm"> ',$txt['enf_state'],'</option>
							<option value="emusic"> ',$txt['music_state'],'</option>
							</select></td>
<td><b> ',$txt['state_'],':</b><option', @$context['member']['options']['bear_tab'] == 'bar' ? ' selected="selected"' : '', '>
				
				', !empty($context['member']['options']['bear_tab']) ? '
				<img alt="" title="' . $context['member']['options']['bear_tab'] . '" src="' . $settings['default_images_url'] . '/estado/' . $context['member']['options']['bear_tab'] . '.gif"/>' : '', '</td>


</tr>
								';
								template_profile_save();

	echo '											


						
					</td>
				</tr></div>
			</table></table>
		</form>';
}

function template_theme(){}
function template_notification(){}
function template_pmprefs(){}
function template_deleteAccount()
{
	global $context, $settings, $options, $scripturl, $txt;

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
									<b class="size11"', isset($context['modify_error']['bad_password']) || isset($context['modify_error']['no_password']) ? ' style="color: red;"' : '', '></b>
									<div class="smalltext">', $txt['smf244'], '</div>
								</td>
								<td><input type="password" name="oldpasswrd" size="20" style="margin-right: 4ex;" />';
	else
		echo '
											
								<td align="center" colspan="2">';

	echo '												
									<div class="smalltext">', $txt['smf244'], '</div>
								</td>
								<td>
	<br><br><input class="login" type="submit" value="',$txt['save_changes'],'" />
	                              <input type="hidden" name="sc" value="', $context['session_id'], '" />
									<input type="hidden" name="userID" value="', $context['member']['id'], '" />
									<input type="hidden" name="sa" value="', $context['menu_item_selected'], '" />
								</td>
							</tr>
						
		';
}
function template_profile_save2()
{
	global $context, $settings, $options, $txt;

	

	if ($context['user']['is_owner'] && $context['require_password'])
		echo '
							
									<b class="size11"', isset($context['modify_error']['bad_password']) || isset($context['modify_error']['no_password']) ? ' style="color: red;"' : '', '>',$txt['pw_'],': </b>
									<div class="smalltext">', $txt['smf244'], '</div>
								<input type="password" name="oldpasswrd" size="20" style="margin-right: 4ex;" />';
	else
		
	echo '						<br><br><input class="login" type="submit" value="Amigo" />
	<input type="hidden" name="default_options[Amigo]" size="20" value="', @$context['member']['name'] ,'" /> 
	<input type="hidden" name="default_options[Amigoid]" size="5" value="', $context['member']['id'] ,'" />
	                              <input type="hidden" name="sc" value="', $context['session_id'], '" />
									<input type="hidden" name="userID" value="', $context['member']['id'], '" />
															
						
		';
}
function template_post()
{
global $context, $settings, $options, $scripturl, $modSettings, $txt;
echo'<table width="757px" style="float: left; margin-right; 8px;"><tr><td>

<div class="box_757">
<div class="box_title" style="width: 757px;"><div class="box_txt box_757-34"><center>',$txt['post_of'],' ', $context['member']['name'], '</center></center></div>
<div class="box_rss"><img alt="" src="', $settings['images_url']  ,'/blank.gif" style="width:16px;height:16px;" border="0"></div></div></div>
<table width="757px" cellpadding="3" cellspacing="1" class="windowbg"><tr><td>';
	if (!empty($context['posts'])){
foreach ($context['posts'] as $post){
echo '<table width="100%"><tr><td width="100%"><div style="float: left;"><div class="box_icono4"><img title="'.$post['board']['name'].'" src="', $settings['images_url']  ,'/post/icono_'.$post['board']['id'].'.gif" ></div>&nbsp;<span title="', $post['subject'], '"><a href="?topic=', $post['topic'], '" >', $post['subject'], '</a></span></div><div align="right" class="opc_fav">',$txt['created'],': ', $post['time'],' | ', $post['puntos'],' pts. |<a title="',$txt['send_friend'],'" href="/index.php?action=enviar-a-amigo;topic=', $post['id'],'"><img src="', $settings['images_url']  ,'/icons/icono-enviar-mensaje.gif"></a></div></td></tr></table>';}
echo'</div>';
if ($context['page_index'])
echo'<div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';}
else
echo '<br><br><center><b>', $context['member']['name'], '</b> ',$txt['no_postx'],'</center><br><br>';
   
   
   
   echo'</form></div></td></tr></table></td></tr></table>
    <table width="160px" style="float: left; margin-right; 8px;"><tr><td>

  <div style="float: left; margin-bottom:8px;" class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">',$txt['advertising'],'</div>
<div class="box_rss"><img src="', $settings['images_url']  ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" style="width: 150px; padding: 4px;"><center><script type="text/javascript"><!--
google_ad_client = "pub-7516357570798900";
/* 120x600, creado 26/07/09 */
google_ad_slot = "7444757519";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br></div></div></td></tr></table>';
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