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
function template_main()
{

    global $db_prefix, $scripturl, $txt, $context, $ID_MEMBER, $modSettings, $boarddir,$boardurl, $settings;
    global $context, $ID_MEMBER, $db_prefix, $modSettings, $boardurl, $scripturl, $txt;

	$g_add = allowedTo('smfgallery_add');
	$g_manage = allowedTo('smfgallery_manage');
	$g_edit_own = allowedTo('smfgallery_edit');
	$g_delete_own = allowedTo('smfgallery_delete');



	$GD_Installed = function_exists('imagecreate');

	if($g_add && !($context['user']['is_guest']))

	$maxrowlevel = 4;

	

	echo '<style>.photo_small{

	margin:6px;

	padding:2px;

	text-align:left;

	float:left;

	background:#FFFFFF none repeat scroll 0%;

	border:1px solid #000000;

}

</style>

<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>' . $context['gallery_usergallery_name'] . '</center></div>
</div>

<table cellspacing="0" cellpadding="10" border="0" align="center" width="100%" class="windowbg">';

	$rowlevel = 0;

	$userid = $context['gallery_userid'];

    

	if($ID_MEMBER = $userid)
        {
         	$dbresult = db_query("SELECT *
                                      FROM {$db_prefix}gallery_pic as p, {$db_prefix}members AS m
                                      WHERE p.ID_MEMBER = $userid AND p.ID_MEMBER = m.ID_MEMBER", __FILE__, __LINE__);}

	while($row = mysql_fetch_assoc($dbresult))
	{
            $context['galeria'][] = array(
            'idusuario' => $row['ID_MEMBER']);
        }

	mysql_free_result($dbresult);

	if($ID_MEMBER = $userid)
        {

    	$rs = db_query("SELECT p.ID_PICTURE, p.commenttotal, p.views, p.ID_MEMBER, m.realName, p.date, p.filename
                        FROM {$db_prefix}gallery_pic as p, {$db_prefix}members AS m
                        WHERE p.ID_MEMBER = $userid AND p.ID_MEMBER = m.ID_MEMBER", __FILE__, __LINE__);
        }

	$context['img'] =  mysql_num_rows($rs);	

	if($ID_MEMBER = $userid)
        {
            $dbresult = db_query("SELECT p.ID_PICTURE, p.commenttotal, p.views, p.ID_MEMBER, m.realName, p.date, p.filename
                                  FROM {$db_prefix}gallery_pic as p, {$db_prefix}members AS m
                                  WHERE p.ID_MEMBER = $userid AND p.ID_MEMBER = m.ID_MEMBER", __FILE__, __LINE__);
       }

        while($row = mysql_fetch_assoc($dbresult))
	{
            if ($rowlevel == 1)
			echo '<trclass>';

				echo '<td width="100px"><center><a href="',$scripturl,'?action=imagenes;sa=ver;id=' . $row['ID_PICTURE'] . '"><img src="' .  linkchecker($row['filename']) . '" style="width: 90px;" border="0"/></a><br>';
echo '<span class="smalltext">';
echo $txt['gallery_text_comments'] . ' (<a href="',$scripturl,'?action=imagenes;sa=ver;id=' . $row['ID_PICTURE'] . '#comentarios">' . $row['commenttotal'] . '</a>)<br />';
if($g_manage || $g_edit_own && $row['ID_MEMBER'] == $ID_MEMBER)
echo '&nbsp;<a href="' . $scripturl . '?action=imagenes;sa=editar;id=' . $row['ID_PICTURE'] . '">' . $txt['gallery_text_edit'] . '</a>';
if($g_manage || $g_delete_own && $row['ID_MEMBER'] == $ID_MEMBER)
echo '&nbsp;<a href="',$scripturl,'?action=imagenes;sa=eliminar;id=' . $row['ID_PICTURE'] . '">' . $txt['gallery_text_delete'] . '</a>';
echo '</span></center></td>';

if($rowlevel < ($maxrowlevel-1))
$rowlevel++;
else
{
    echo '</tr>';
    $rowlevel = 0;
}
}

if($rowlevel !=0)
{
    echo '</tr>';
}

mysql_free_result($dbresult);



echo'</table>';

	

// aviso de no hay imagen en galeria 

if($context['img']){echo'';}else echo'<table cellspacing="0" cellpadding="10" border="0" align="center" width="100%" class="windowbg"><tr><td><br><center>' . $context['gallery_usergallery_name'] . ' ' . $txt['gallery_no_images_gallery'] . '</center><br></td></tr></table>';



if($g_add)
{
echo '<br /><table align="center" width="859px" height="34px"><tr><td align="center"><b><font face="Arial"><a title="Agregar imagen" href="', $scripturl ,'?action=imagenes;sa=agregar"><font color="#000000"><span style="text-decoration: none"><img src="', $settings['images_url'] ,'/icons/icono-foto-agregar.gif" border="0" alt="' . $txt['gallery_text_addimage'] . '" title="' . $txt['gallery_text_addimage'] . '"> ' . $txt['gallery_text_addimage'] . '</span></font></a><font color="#FFFFFF"></font></font></b><br /></td></tr></table>';
}
echo '<br /></div>';

	

}

function template_add_picture()
{

	global $scripturl, $modSettings, $db_prefix, $txt, $context, $settings;

	@$cat = (int) $_REQUEST['cat'];



	echo '

		<script language="JavaScript" type="text/javascript">

		function requerido(title, filename)

	{	

			if(title == \'\')

			{

				alert(\'' . $txt['gallery_error_no_title_write'] . '\');

				return false;

			}

			if(filename == \'\')

			{

				alert(\'' . $txt['gallery_error_no_picture'] . '.\');

				return false;

			}

			if(filename.indexOf(\'imageshack.us\')>0)

			{

				alert(\'' . $txt['gallery_error_imageshack_notsupported'] . '.\');

				return false;

			}

			}</script>

	<form method="POST" enctype="multipart/form-data" name="forma" id="forma" action="',$scripturl,'?action=rz;m=enviari">

			<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>' . $txt['gallery_text_addimage'] . '</center></div>
</div>

		<table style="border:1px solid #CCC" class="windowbg2" width="100%" style="padding: 4px 4px 4px 4px;" align="center" cellpadding="0" cellspacing="0" border="0">



   <tr >

   	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_title'] . '</b>&nbsp;<br><input style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="1" size="60" maxlength="54" type="text" name="title" id="title" value="" /></td>

  </tr>



  	  <tr >

  	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_description'] . '</b>&nbsp;<br><textarea name="description" id="description" style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="2" rows="5" cols="45"></textarea>	</td>

  </tr>

  

  <tr>

  	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_urlimage'] . '</b>&nbsp;<br><input type="text" style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="3" size="60" name="filename" value="" /><br><br>

    </td>

  </tr>';

  



echo '</table>



<table class="windowbg2" width="100%" style="padding: 8px 8px 8px 8px;" align="center" cellpadding="0" cellspacing="0" border="0">

  <tr>

    <td width="100%"align="center">

	<input type="submit" class="button" onclick="return requerido(this.form.title.value, this.form.filename.value);" value="' . $txt['gallery_text_addimage'] . '" name="submit" /><br />



    </td>

  </tr>

</table>';

echo '

<input type="hidden" name="cat" value="1">

<input type="hidden" value="'.$context['current_time'].'" name="date" />

<input type="hidden" value="'. $context['user']['id'].'" name="ID_MEMBER" />

<input type="hidden" name="id" value="' . $context['gallery_pic']['ID_PICTURE'] . '" />

		</form>

</div>';



}

function template_edit_picture()
{
	global $scripturl, $modSettings, $db_prefix, $txt, $context, $settings, $boardurl;

        echo '<script language="JavaScript" type="text/javascript">

		function requerido(title, filename)

	{	

			if(title == \'\')

			{

				alert(\'' . $txt['gallery_error_no_title_write'] .'\');

				return false;

			}

			if(filename == \'\')

			{

				alert(\'' . $txt['gallery_error_no_picture'] .'\');

				return false;

			}

			if(filename.indexOf(\'imageshack.us\')>0)

			{

				alert(\'' . $txt['gallery_error_imageshack_notsupported'] . '\');

				return false;

			}

			}</script><form method="POST" enctype="multipart/form-data" name="forma2" id="forma2" action="',$scripturl,'?action=rz;m=editari">

			<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>' . $txt['gallery_form_editpicture'] . '</center></div>
</div>

		<table style="border:1px solid #CCC" class="windowbg2" width="100%" style="padding: 4px 4px 4px 4px;" align="center" cellpadding="0" cellspacing="0" border="0">

   <tr >

   	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_title'] . '</b>&nbsp;<br><input style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="1" size="60" maxlength="54" type="text" name="title" value="' . $context['gallery_pic']['title'] . '" /></td>

  </tr>



  	  <tr >

  	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_description'] . '</b>&nbsp;<br><textarea name="description" style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="2" rows="5" cols="45">' . $context['gallery_pic']['description'] . '</textarea>	</td>

  </tr>

  

  <tr>

  	<td width="100%" align="center"><br><b class="size11">' . $txt['gallery_form_urlimage'] . '</b>&nbsp;<br><input type="text" style="border: 1px solid rgb(211, 211, 211); background-color: rgb(255, 255, 255);" tabindex="3" size="60" name="filename" value="'.$context['gallery_pic']['filename'].'" /><br><br>

    </td>

  </tr>';





echo '</table>



<table class="windowbg2" width="100%" style="padding: 8px 8px 8px 8px;" align="center" cellpadding="0" cellspacing="0" border="0">

  <tr>

    <td width="100%"align="center">

	<input type="submit" class="button" style="font-size: 15px;"  onclick="return requerido(this.form.title.value, this.form.filename.value);" value="' . $txt['gallery_form_editpicture'] . '" name="submit" /><br />



    </td>

  </tr>

</table>';

echo '

<input type="hidden" name="cat" value="1">

<input type="hidden" value="'. $context['user']['id'].'" name="ID_MEMBER" />

<input type="hidden" name="id" value="' . $context['gallery_pic']['ID_PICTURE'] . '" />

		</form>

</div>';

}



function template_view_picture()
{

global $scripturl, $context, $txt, $db_prefix, $ID_MEMBER, $modSettings, $boardurl, $memberContext, $themeUser, $settings;


$iduser = $context['gallery_pic']['ID_MEMBER'];

	$g_manage = allowedTo('smfgallery_manage');

	$g_edit_own = allowedTo('smfgallery_edit');

	$g_delete_own = allowedTo('smfgallery_delete');

	$g_add = allowedTo('smfgallery_add');

 	$bbc_check = function_exists('parse_bbc');

$requests = mysql_query("SELECT *
                        FROM {$db_prefix}gallery_pic
                        WHERE ID_PICTURE=".$context['gallery_pic']['ID_PICTURE']."");

while ($grups = mysql_fetch_assoc($requests))
{	
$fecha = $grups['date'];
$elcomentario =  $grups['description'];
}

mysql_free_result($requests);

$request = mysql_query("SELECT *
                        FROM {$db_prefix}gallery_pic
                        WHERE ID_PICTURE=".$context['gallery_pic']['ID_PICTURE']."");

while ($grup = mysql_fetch_assoc($request))
{	
$context['numcom'] = $grup['commenttotal'];
$context['puntos'] = $grup['puntos'];
$context['num_views'] = $grup['views'];
}	

mysql_free_result($request);

$al_azar=mysql_query("SELECT *
                      FROM ({$db_prefix}gallery_pic AS img)
                      ORDER BY RAND()
                      LIMIT 10");

$context['al-azar'] = array();

while ($row = mysql_fetch_assoc($al_azar))
{
$context['al-azar'][] = array(
'titulo' => $row['title'],
'puntos' => $row['puntos'],
'id' => $row['ID_PICTURE'],
);
}

mysql_free_result($al_azar);


$request = mysql_query("SELECT *
                        FROM {$db_prefix}members AS m
                        WHERE ".$context['user']['id']." = m.ID_MEMBER");

while ($grup = mysql_fetch_assoc($request))

{	

$context['idgrup'] = $grup['ID_POST_GROUP'];

$context['leecher'] = $grup['ID_POST_GROUP'] == '4';

$context['novato'] = $grup['ID_POST_GROUP'] == '5';

$context['buenus'] = $grup['ID_POST_GROUP'] == '6';

}	mysql_free_result($request);



echo '

<script type="text/javascript">function errorrojo(cuerpo_comment){

if(cuerpo_comment == \'\'){

document.getElementById(\'error\').innerHTML=\'<br><font class="size10" style="color: red;">' . $txt['gallery_error_no_comment'] . '</font>\'; return false;}}</script>

<script type="text/javascript">

function showtags(cuerpo_comment)

{   

if(cuerpo_comment == \'\')

{

alert(\'\');

return false;

}

}

</script>

<a name="inicio"></a>';





echo'<div>

<div class="box_140" style="float:left; margin-right:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">' . $txt['gallery_text_by'] . '</div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/icons/imageaz.png" style="width: 16px; height: 16px;" border="0"></div></div><div class="smalltext windowbg" border="0" style="width: 130px; padding: 4px;">

<center>';

$userse = db_query("SELECT *
                    FROM {$db_prefix}members as mem
                    WHERE mem.ID_MEMBER=$iduser", __FILE__, __LINE__);

while($row = mysql_fetch_assoc($userse))
{
	$context['memberName']=$row['memberName'];
	$context['avatar']=$row['avatar'];
	$context['personalText']=$row['personalText'];	
	$context['ID_POST_GROUP']=$row['ID_POST_GROUP'];
	$context['ID_GROUP']=$row['ID_GROUP'];
	$context['realName']=$row['realName'];
	$context['usertitle']=$row['usertitle'];
	$context['gender']=$row['gender'];
	$context['topics']=$row['topics'];
	$context['firma']=$row['signature'];
	$context['money']=$row['money'];
        $context['moneyBank']=$row['moneyBank'];
	$context['ID_MEMBER']=$row['ID_MEMBER'];
}
mysql_fetch_assoc($row);

$idgrup=$context['ID_POST_GROUP'];
$idgrup2=$context['ID_GROUP'];

$userse2 = db_query("SELECT *
                    FROM {$db_prefix}membergroups as g
                    WHERE g.ID_GROUP=$idgrup", __FILE__, __LINE__);

while($row2 = mysql_fetch_assoc($userse2))

{$membergropu=$row2['groupName'];}

$userse3 = db_query("SELECT *
                    FROM {$db_prefix}membergroups as g
                    WHERE g.ID_GROUP=$idgrup2", __FILE__, __LINE__);

while($row2 = mysql_fetch_assoc($userse3))

{$membergropu2=$row2['groupName'];}

$medalla = db_query("SELECT *
                    FROM {$db_prefix}membergroups as g
                    WHERE g.ID_GROUP=".(!empty($idgrup2) ? $idgrup2 : $idgrup)."", __FILE__, __LINE__);

while($row7 = mysql_fetch_assoc($medalla))

{$medalla=$row7['stars'];}



			if ($modSettings['avatar_action_too_large'] == 'option_html_resize' || $modSettings['avatar_action_too_large'] == 'option_js_resize')

			{

				if (!empty($modSettings['avatar_max_width_external']))

					$context['user']['avatar']['width'] = $modSettings['avatar_max_width_external'];

				if (!empty($modSettings['avatar_max_height_external']))

		 			$context['user']['avatar']['height'] = $modSettings['avatar_max_height_external'];

			}



		if (!empty($context['avatar']))

		$context['user']['avatar']['image'] = '<img src="'.$context['avatar'].'"' . (isset($context['user']['avatar']['width']) ? ' width="' . $context['user']['avatar']['width'] . '"' : '') . (isset($context['user']['avatar']['height']) ? ' height="' . $context['user']['avatar']['height'] . '"' : '') . ' alt="" class="avatar" border="0" />';





if ($context['avatar']){

echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="', $scripturl ,'?action=profile;u=', $context['ID_MEMBER'], '" title="' . $txt['gallery_text_profile'] . '">'.$context['user']['avatar']['image'].'</a><br />', $context['personalText'], '</div>';

}

else

echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="', $scripturl ,'?action=profile;u=', $context['ID_MEMBER'], '" title="' . $txt['gallery_text_profile'] . '"><img src="', $settings['images_url'] ,'/avatar.gif" border="0" alt="' . $txt['gallery_app_noavatar'] . '" /></a><br />', $context['personalText'], '</div>';



		echo' <b><a href="', $scripturl ,'?action=profile;u=', $context['ID_MEMBER'], '"><span class="size12"><font face="verdana"><b>', $context['realName'], '</b></font></span></a></b>';

				



if ($context['user']['is_logged'])					

echo ' <hr><a href="', $scripturl ,'?action=imagenes;usuario=', $context['realName'], '" title="' . $txt['gallery_misc_galleryof'] . ' ', $context['realName'], '">Mis Im&aacute;genes</a>';


        echo '</center></div></div>



<div class="box_780" style="float:left;">

<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>' . $context['gallery_pic']['title'] . '</center></div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" align="center" border="0" style="width: 770px; padding: 4px;" id="img_'. $context['gallery_pic']['ID_PICTURE'].'"><img onload="if(this.width > 750) {this.width=750}" alt="' . $context['gallery_pic']['title'].'" title="' . $context['gallery_pic']['title'] . '"  src="'.linkchecker($context['gallery_pic']['filename']).'" /><br>'. $elcomentario .'</div>



<!-- info del post -->

<div style="margin-top:8px;">



<div class="box_390" style="float:left; margin-right:8px;">

<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">Opciones</div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>

<div class="windowbg" style="width: 376px; padding: 4px;"><span class="size11">'; 

if ( $iduser==$ID_MEMBER || $context['allow_admin']){

echo'<input class="login" style="font-size: 11px;" value="' . $txt['gallery_form_editpicture'] . '" title="' . $txt['gallery_form_editpicture'] . '" onclick="location.href=\'',$scripturl,'?action=imagenes;sa=editar;id=', $context['gallery_pic']['ID_PICTURE'], '\'" type="button"> <input class="login" style="font-size: 11px;" value="' . $txt['gallery_form_delpicture'] . '" title="' . $txt['gallery_form_delpicture'] . '" onclick="if (!confirm(\'' . $txt['gallery_warn_deletepicture'] . '\')) return false; location.href=\'',$scripturl,'?action=imagenes;sa=eliminar;id=', $context['gallery_pic']['ID_PICTURE'], '\'" type="button"><hr>';}



if($context['novato'] || $context['buenus'] || $context['allow_admin']){

$request1 = db_query("SELECT points
                      FROM smf_points_per_day
                      WHERE ID_MEMBER=".$context['user']['id']."
                      LIMIT 1", __FILE__, __LINE__);
$row1 = mysql_fetch_assoc($request1);
mysql_free_result($request1);
	//Tengo puntos disponibles?
	if ($row1['points']>0)
	{
		echo'<b class="size11">',$txt['gallery_give_points'],'</b> ';
		for ($puntos = 1; $puntos <= $row1['points']; $puntos++) 
		{
			if ($puntos==1)
				echo '<a href="', $scripturl ,'?action=imagenes;sa=dpuntos;id=', $context['gallery_pic']['ID_PICTURE'], ';user=', $iduser, ';cantidad=', $puntos, '">', $puntos, '</a>';
			else
				echo ' - <a href="', $scripturl ,'?action=imagenes;sa=dpuntos;id=', $context['gallery_pic']['ID_PICTURE'], ';user=', $iduser, ';cantidad=', $puntos, '">', $puntos, '</a>';
		}
		echo ' ',$txt['gallery_text_points'],'<hr>';}
	else
		echo'<b>',$txt['gallery_not_enough_points'],'</b><hr>';
	}

else

echo'' . $txt['guest_leecher'] . '<hr>';

if($context['user']['is_logged']){

echo'<a  class="iconso denunciar_post" title="' . $txt['gallery_form_reportpicture'] . '" href="', $scripturl , '?action=imagenes;sa=reportar;id=' . $context['gallery_pic']['ID_PICTURE'] . '"/>' . $txt['gallery_form_reportpicture'] . '</a><hr>';}

echo'<b class="size11">' . $txt['gallery_form_moreimgview'] . '</b><br>';

foreach($context['al-azar'] AS $alzar){

echo'<div class="hov_posti"><img src="', $settings['images_url'] ,'/icons/icono-foto.gif" title="' . $txt['gallery_text_mimages'] . '"> <a href="', $scripturl ,'?action=imagenes;sa=ver;id='.$alzar['id'].'" title="'.$alzar['titulo'].'">'.$alzar['titulo'].'</a></div>';}

$firma1 = parse_bbc($context['firma']);

$firma = str_replace('if(this.width >720) {this.width=720}','if(this.width >376) {this.width=376}',$firma1);

		

echo'</span></div></div>



<div class="box_390" style="float:left;">

<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">' . $txt['gallery_text_infopic'] . '</div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>

<b><div class="windowbg" style="width: 376px; padding: 4px;"><span class="size11"><span class="icons visitas">&nbsp;', $context['num_views'], '&nbsp;' . $txt[301] . '</span><span class="icons puntos">&nbsp;'.$context['puntos'].'&nbsp;',$txt['gallery_text_points'],'</span></b><hr>

'; if ($modSettings['gallery_set_showcode_bbc_image']  || $modSettings['gallery_set_showcode_directlink'] || $modSettings['gallery_set_showcode_htmllink'])

				{

				if ($modSettings['gallery_set_showcode_directlink'])

				{

					echo '<b>' . $txt['gallery_text_urlinfo'] . '</b>&nbsp;&nbsp;&nbsp;&nbsp;<input id="enlace" name="enlace" type="text" value="'.$context['gallery_pic']['filename'].'" onclick="selectycopy(getElementById(\'enlace\')); APITrack(\'copy_details_url\');" size="50"><br>';}

				if ($modSettings['gallery_set_showcode_htmllink'])

				{	

echo'<b>Embed:</b>&nbsp;&nbsp;&nbsp;<input id="embed" name="embed" type="text" value="&lt;a title=&quot;'.$context['gallery_pic']['title'].' - &quot; href=&quot;'. $scripturl .'?action=imagenes;sa=ver;id='. $context['gallery_pic']['ID_PICTURE'].'&quot; target=&quot;_blank&quot;&gt;'.$context['gallery_pic']['title'].' - &lt;/a&gt;" onclick="selectycopy(getElementById(\'embed\')); APITrack(\'copy_details_url\');" size="50"><br>';}

				if ($modSettings['gallery_set_showcode_bbc_image'])

				{

echo'<b>BBCode:</b>&nbsp;<input id="bbcode" name="bbcode" type="text" value="[IMG]'.$context['gallery_pic']['filename'].'[/IMG]" onclick="selectycopy(getElementById(\'bbcode\')); APITrack(\'copy_details_url\');" size="50">';}} echo'



</span></div></div></div>

<div class="box_390" style="float:left; margin-top:8px;">

<div><div class="box_txt box_390-34"></div>

<div class="box_rss"></div></div>

<div class="windowbg" style="width: 376px; padding: 4px;">';

if (!empty($context['firma']) && empty($options['show_no_signatures']))

echo'<b class="size11"></b>';

else

echo'<span class="size11"><center></center></span>';

echo'</div></div>

<a name="fin"></a>

<!-- fin info del post -->

<!-- comentarios -->

<a name="comentarios"></a>

<div>

<div class="box_780" style="float:left; margin-top:8px;"><form action="',$scripturl,'?action=imagenes;sa=eliminar-comment" method="post" accept-charset="', $context['character_set'], '" id="eliminar-comments">

<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">'. $context['numcom'] .' Comentarios</div>

<div class="box_rss"><div class="icon_img"><a href="web/rss/rss-pic-comment.php?id='. $context['gallery_pic']['ID_PICTURE'].'"><img src="', $settings['images_url'] ,'/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;">';

$sincoment = db_query("SELECT c.ID_PICTURE,  c.ID_COMMENT, c.date, c.comment, c.ID_MEMBER, m.posts, m.memberName,m.realName FROM {$db_prefix}gallery_comment as c, {$db_prefix}members AS m WHERE   c.ID_PICTURE = " . $context['gallery_pic']['ID_PICTURE'] . " AND c.ID_MEMBER = m.ID_MEMBER ORDER BY c.ID_COMMENT ASC", __FILE__, __LINE__);

$context['sin_coment'] =  mysql_num_rows($sincoment);

$dbresult = db_query("SELECT c.ID_PICTURE,  c.ID_COMMENT, c.date, c.comment, c.ID_MEMBER, m.posts, m.memberName,m.realName FROM {$db_prefix}gallery_comment as c, {$db_prefix}members AS m WHERE   c.ID_PICTURE = " . $context['gallery_pic']['ID_PICTURE'] . " AND c.ID_MEMBER = m.ID_MEMBER ORDER BY c.ID_COMMENT ASC", __FILE__, __LINE__);

$comment_count = db_affected_rows();

$context['pic_comment'] = array();

while ($row = mysql_fetch_assoc($dbresult))

	{

		censorText($row['comment']);

		$context['pic_comment'][] = array(
			'id-comment' => $row['ID_COMMENT'],
			'name-user' => $row['memberName'],
			'name-user-logged' => $row['realName'],
			'id-user' => $row['ID_MEMBER'],
			'comentario-pic' => $row['comment'],
			'fecha' => $row['date'],

			);

		$context['id_img']=$row['ID_PICTURE'];

			}

mysql_free_result($dbresult);

$cantidad = 1;

$memCommID = $pic_comment['id-user'];

loadMemberData($memCommID);

loadMemberContext($memCommID);

if($context['sin_coment'])

{foreach($context['pic_comment'] AS $pic_comment){

echo'<div id="cmt_'.$pic_comment['id-comment'].'"><span class="size12">';

// eliminar cmt

if($context['allow_admin'] || $iduser == $context['user']['id'])

echo'<input type="checkbox" name="campos['.$pic_comment['id-comment'].']">';



$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;

$diames2 = date(j,$pic_comment['fecha']); $mesano2 = date(n,$pic_comment['fecha']) - 1 ; $ano2 = date(Y,$pic_comment['fecha']);

$seg2=date(s,$pic_comment['fecha']); $hora2=date(H,$pic_comment['fecha']); $min2=date(i,$pic_comment['fecha']);



echo' <a onclick="citar_comment('.$pic_comment['id-comment'].')" href="javascript:void(0)">#'.$cantidad++.'</a> 

<b id="autor_cmnt_'.$pic_comment['id-comment'].'" user_comment="'.$pic_comment['name-user'].'" text_comment="'.$pic_comment['comentario-pic'].'"><a href="', $scripturl ,'?action=profile;u='.$pic_comment['id-user'].'">'.$pic_comment['name-user'].'</a></b> |

<span class="size10">'.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2.'</span> <a class="iconso emp" href="',$scripturl,'?action=pm;sa=send;u='.$pic_comment['id-user'].'" title="' . $txt['gallery_misc_sendpm'] . ' '.$pic_comment['name-user'].'"><img src="', $settings['images_url'] ,'/espacio.gif" align="top" border="0"></a><a class="iconso citar" onclick="citar_comment('.$pic_comment['id-comment'].')" href="javascript:void(0)" title="' . $txt['smf240'] . '' . $txt['smf_news_1'] . '"><img src="', $settings['images_url'] ,'/espacio.gif" align="top" border="0"></a> dijo:<br>'.parse_bbc($pic_comment['comentario-pic']).'</span></div><hr>';

}}else{

echo'<div id="no_comentarios"><span class="size11"><b>' . $txt['gallery_error_not_comments'] . '</b></span></div><hr>';}



echo'</div>';

if($context['sin_coment']){if($context['allow_admin'] || $iduser == $context['user']['id'])

echo'<span class="size10">' . $txt['gallery_misc_comment_selected'] . '</span> <input class="login" style="font-size: 9px;" type="submit" value="' . $txt[31] . '">';}

else{echo'';}

echo'<input value="'.$context['id_img'].'" name="idimg" id="idimg" type="hidden">

</form></div></div>

<!-- fin comentarios -->';

echo'<!-- comentar -->

<div style="margin-bottom:8px;">

<div class="box_780" style="float:left; margin-top:8px; margin-bottom:8px;">

<a name="comentar"></a>

<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">' . $txt['gallery_misc_addcom'] . '</div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;">

<span class="size11"><form method="POST" name="postmodify" id="postmodify" action="',$scripturl,'?action=imagenes;sa=comment2"><center><textarea class="editor" style="width: 95%; height: 100px;" rows="6" id="cuerpo_comment" name="cuerpo_comment" cols="54"></textarea><br>';

galeria_loadSmileys();

galeria_printSmileys();

template_add_comment();

echo'<label id="error"></label><br><input class="login" type="submit" name="post" id="post" value="' . $txt['gallery_misc_sendcom'] . '" onclick="return errorrojo(this.form.cuerpo_comment.value);" tabindex="2" />

<input type="hidden" name="id" value="' . $context['gallery_pic_id'] . '" />

</center></form></span>

</div></div></div></div>

<!-- fin comentar -->';

echo'</div></div>';}



function galeria_loadSmileys() {



  global $context, $settings, $user_info, $txt, $modSettings, $db_prefix, $scripturl;



	$context['smileys'] = array(

		'postform' => array(),

		'popup' => array(),

	);

	if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')

		$context['smileys']['postform'][] = array(

			'smileys' => array(),

			'last' => true,

		);

	elseif ($user_info['smiley_set'] != 'none')

	{

		if (($temp = cache_get_data('posting_smileys', 480)) == null)

		{

			$request = db_query("SELECT code, filename, description, smileyRow, hidden
                                            FROM {$db_prefix}smileys
                                            WHERE hidden IN (0, 2)
                                            ORDER BY smileyRow, smileyOrder", __FILE__, __LINE__);

			while ($row = mysql_fetch_assoc($request))
			{
				$row['code'] = htmlspecialchars($row['code']);
				$row['filename'] = htmlspecialchars($row['filename']);
				$row['description'] = htmlspecialchars($row['description']);
                                $context['smileys'][empty($row['hidden']) ? 'postform' : 'popup'][$row['smileyRow']]['smileys'][] = $row;
                       }

		mysql_free_result($request);

		cache_put_data('posting_smileys', $context['smileys'], 480);
	}
		else
			$context['smileys'] = $temp;
	}

	foreach (array_keys($context['smileys']) as $location)
	{
		foreach ($context['smileys'][$location] as $j => $row)
		{
			$n = count($context['smileys'][$location][$j]['smileys']);
			for ($i = 0; $i < $n; $i++)
			{
				$context['smileys'][$location][$j]['smileys'][$i]['code'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['code']);
				$context['smileys'][$location][$j]['smileys'][$i]['js_description'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['description']);
			}
			$context['smileys'][$location][$j]['smileys'][$n - 1]['last'] = true;
		}

		if (!empty($context['smileys'][$location]))

			$context['smileys'][$location][count($context['smileys'][$location]) - 1]['last'] = true;
	}
	$settings['smileys_url'] = $modSettings['smileys_url'] . '/' . $user_info['smiley_set'];
}



function galeria_printSmileys() {

  global $context, $txt, $settings, $scripturl;

  loadLanguage('Post');

	if (!empty($context['smileys']['postform']))
	{
		foreach ($context['smileys']['postform'] as $smiley_row)
		{
			foreach ($smiley_row['smileys'] as $smiley)

				echo '

					<a href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.postmodify.cuerpo_comment); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a>';

			if (empty($smiley_row['last']))
				echo '<br />';
		}
		if (!empty($context['smileys']['popup']))

			echo '<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script>

		<a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a>';

	}
	if (!empty($context['smileys']['popup']))
	{
		echo '

			<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[

				var smileys = [';

		foreach ($context['smileys']['popup'] as $smiley_row)
		{
			echo '

					[';
			foreach ($smiley_row['smileys'] as $smiley)
			{
				echo '

					["', $smiley['code'], '","', $smiley['filename'], '","', $smiley['js_description'], '"]';



				if (empty($smiley['last']))

				echo ','; }echo ']'; if (empty($smiley_row['last'])) echo ',';}

		echo '];

				var smileyPopupWindow;

				function sbox_moreSmileys()

				{

					var row, i;

					if (smileyPopupWindow)

						smileyPopupWindow.close();

					smileyPopupWindow = window.open("", "add_smileys", "toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,width=480,height=220,resizable=yes");

					smileyPopupWindow.document.write(\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n<html>\');

					smileyPopupWindow.document.write(\'\n\t<head>\n\t\t<title>', $txt['more_smileys_title'], '</title>\n\t\t<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/style.css" />\n\t</head>\');

					smileyPopupWindow.document.write(\'\n\t<body style="margin: 1ex;">\n\t\t<table width="100%" cellpadding="5" cellspacing="0" border="0" class="tborder">\n\t\t\t<tr class="titlebg"><td align="left">', $txt['more_smileys_pick'], '</td></tr>\n\t\t\t<tr class="windowbg"><td align="left">\');

					for (row = 0; row < smileys.length; row++)

					{

						for (i = 0; i < smileys[row].length; i++)

						{

						smileys[row][i][2] = smileys[row][i][2].replace(/"/g, \'&quot;\');

						smileyPopupWindow.document.write(\'<a href="javascript:void(0);" onclick="window.opener.replaceText(&quot; \' + smileys[row][i][0] + \'&quot;, window.opener.document.forms.postmodify.cuerpo_comment); window.focus(); return false;"><img src="', $settings['smileys_url'], '/\' + smileys[row][i][1] + \'" alt="\' + smileys[row][i][2] + \'" title="\' + smileys[row][i][2] + \'" style="padding: 4px;" border="0" /></a> \');

						}

						smileyPopupWindow.document.write("<br />");

					}

					smileyPopupWindow.document.write(\'</td></tr>\n\t\t\t<tr><td class="windowbg"><a href="javascript:window.close();\\">', $txt['more_smileys_close_window'], '</a></td></tr>\n\t\t</table>\n\t</body>\n</html>\');

					smileyPopupWindow.document.close();

				}

			// ]]></script>';}}

function template_dpuntos(){}	

function template_dpuntos2(){

	global $scripturl, $context, $txt, $db_prefix, $ID_MEMBER, $modSettings, $boardurl, $memberContext, $themeUser;

	$id = (int) $_REQUEST['id'];
	$cant = (int) $_GET['cant'];
	if($id == '')
            fatal_error($txt['gallery_error_no_pic_selected']);

	if($cant == '')
            fatal_error($txt['gallery_quantity_validated']);

		$request = mysql_query("SELECT *
                                        FROM {$db_prefix}gallery_pic
                                        WHERE ID_PICTURE = $id
                                        LIMIT 1");

while ($grup = mysql_fetch_assoc($request))
{	
$context['titulo'] = $grup['title'];
}	

mysql_free_result($request);

echo'<div align="center">

<div class="box_errors">

<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">' . $txt['gallery_congrats']. '</div>

<div class="box_rss"><img  src="', $settings['images_url'] ,'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

<div class="windowbg" style="width: 388px; font-size: 12px;">

		<br>'.$txt['gallery_has_given'].' '.$cant.' ' .$txt['gallery_to_post']. ' <b>'.$context['titulo'].'</b>

  <br>

		<br>

	     <input class="login" style="font-size: 11px;" type="submit" title="'. $txt['gallery_text_backimg'] . '" value="' . $txt['gallery_text_backimg'] . '" onclick="location.href=\'',$scripturl,'?action=imagenes;sa=ver;id='.$id.'/\'" /> <input class="login" style="font-size: 11px;" type="submit" title="' . $txt['gallery_misc_gohome'] . '" value="' . $txt['gallery_misc_gohome'] . '" onclick="location.href=\'/\'" /><br><br></div></div></div>';





}								

function template_delete_picture(){}
function template_add_comment(){}
function template_manage_cats(){}

function template_settings(){

	global $scripturl, $modSettings, $boarddir, $boardurl, $txt, $context;


echo '	<table border="0" width="80%" cellspacing="0" align="center" cellpadding="4" class="tborder">

		<tr class="titlebg">

			<td>' . $txt['gallery_text_settings'] . '</td>

		</tr>



		<tr class="windowbg">

			<td>

			<b>' . $txt['gallery_text_settings'] . '</b> - <span class="smalltext">' . $txt['gallery_set_description'] . '</span><br />

			<form method="POST" action="' . $scripturl . '?action=imagenes;sa=adminset2" accept-charset="', $context['character_set'], '">';



				echo '

				<br />' . $txt['gallery_shop_settings'] . '<br />

				' . $txt['gallery_shop_picadd'] . '<input type="text" name="gallery_shop_picadd" value="' .  $modSettings['gallery_shop_picadd'] . '" /><br />

				

				<br /><b>' . $txt['gallery_txt_image_linking'] . '</b><br />

				<input type="checkbox" name="gallery_set_showcode_bbc_image" ' . ($modSettings['gallery_set_showcode_bbc_image'] ? ' checked="checked" ' : '') . ' />' . $txt['gallery_set_showcode_bbc_image'] . '<br />

				<input type="checkbox" name="gallery_set_showcode_directlink" ' . ($modSettings['gallery_set_showcode_directlink'] ? ' checked="checked" ' : '') . ' />' . $txt['gallery_set_showcode_directlink'] . '<br />

				<input type="checkbox" name="gallery_set_showcode_htmllink" ' . ($modSettings['gallery_set_showcode_htmllink'] ? ' checked="checked" ' : '') . ' />' . $txt['gallery_set_showcode_htmllink'] . '<br />

				

				<br />

				

				<input type="submit" name="savesettings" value="',$txt['gallery_save_settings'],'" />

			</form>





			</td>

		</tr>

</table>';}

function template_approvelist(){}

function template_reportlist()
{

	global $scripturl, $db_prefix, $txt;

echo '



	<table border="0" width="80%" cellspacing="0" align="center" cellpadding="4" class="tborder">

		<tr class="titlebg">

			<td>' . $txt['gallery_form_reportimages'] . '</td>

		</tr>



		<tr class="windowbg">

			<td>

			<table cellspacing="0" cellpadding="10" border="0" align="center" width="90%" class="tborder">

				<tr class="catbg">

				<td>' . $txt['gallery_rep_piclink'] . '</td>

				<td>' . $txt['gallery_rep_comment']  . '</td>

				<td>' . $txt['gallery_app_date'] . '</td>

				<td>' . $txt['gallery_rep_reportby'] . '</td>

				<td>' . $txt['gallery_text_options'] . '</td>

				</tr>';



			// Show Reported Images

		  	$dbresult = db_query("SELECT r.ID, r.ID_PICTURE, r.ID_MEMBER, m.memberName, m.realName, r.date,r.comment 
                                              FROM {$db_prefix}gallery_report as r
                                              LEFT JOIN {$db_prefix}members AS m on (r.ID_MEMBER = m.ID_MEMBER) ORDER BY r.ID_PICTURE DESC", __FILE__, __LINE__);

			while($row = mysql_fetch_assoc($dbresult))
			{
				echo '<tr class="windowbg2">';
				echo '<td><a href="' . $scripturl . '?action=imagenes;sa=ver;id=' . $row['ID_PICTURE'] . '">' . $txt['gallery_rep_viewpic'] .'</a></td>';
				echo '<td>' . $row['comment'] . '</td>';
				echo '<td>' . timeformat($row['date']) . '</td>';

				if ($row['realName'] != '')
					echo '<td><a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">'  . $row['realName'] . '</a></td>';
				else 
					echo '<td>' .  $txt['gallery_guest'] . '</td>';

				echo '<td><a href="' . $scripturl . '?action=imagenes;sa=eliminar;id=' . $row['ID_PICTURE'] . '">' . $txt['gallery_rep_deletepic']  . '</a>';
				echo '<br /><a href="' . $scripturl . '?action=imagenes;sa=deletereport;id=' . $row['ID'] . '">' . $txt['gallery_rep_delete'] . '</a></td>';
				echo '</tr>';
			}
			mysql_free_result($dbresult);
echo '

			</table>

			</td>
</div>
		</table></tr></div>';



}

function template_myimages(){}
function template_add_category(){}
function template_edit_category(){}
function template_delete_category(){}

function template_report_picture()
{
	global $context, $settings, $scripturl, $txt, $url, $return;

	echo '
<form method="POST" name="cprofile" id="cprofile" action="' . $scripturl . '?action=imagenes;sa=report2" accept-charset="', $context['character_set'], '">
<center><div class="box_757">
<div class="box_title" style="width: 757px;"><div class="box_txt box_757-34"><center>' . $txt['gallery_form_reportpicture'] . '</center></div>
<div class="box_rss"><img alt="" src="', $settings['images_url'] ,'/blank.gif" style="width:16px;height:16px;" border="0"></div></div></div>
<table width="757px" cellpadding="3" cellspacing="1" class="windowbg"><tr><td><center><b class="size11">' . $txt['gallery_form_comment'] . '</center></b>
    <td width="72%" class="windowbg2"><textarea rows="6" name="comment" cols="54"></textarea></td>
  <tr>
    <td width="28%" colspan="2"  align="center" class="windowbg2">
    <input type="hidden" name="id" value="' . $context['gallery_pic_id'] . '" />
    <input type="submit" value="' . $txt['gallery_form_reportpicture'] . '" name="submit" /></td>

  </table>
</form></div></td></tr></div>';

}

function linkchecker($url)
{
    global $boardurl;

$default= $boardurl."/Themes/default/images/broken_link.jpg";

if(!strstr($url, "http://")) { $url = "http://".$url; }

$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HEADER, false);
curl_setopt($handle, CURLOPT_FAILONERROR, true);
curl_setopt($handle, CURLOPT_NOBODY, true);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
	
$valor=curl_exec($handle);
curl_close($handle);
if ($valor==true)    {return $url;}
else	{return $default;}
}
?>