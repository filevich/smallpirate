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
global $topic, $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board, $no_avatar, $boardurl;
global $query_this_board, $func;
$cantidad = 1;

echo '<script type="text/javascript">
function errorrojo(comentario,ID_TOPIC,ID_BOARD,ID_MEMBER)
{
	if(comentario == \'\')
	{
		document.getElementById(\'error\').innerHTML=\'<br><font class="size10" style="color: red;">'.$txt['no_coment'].'</font>\'; 
		return false;
	}else{
		add_comment(ID_TOPIC,ID_BOARD,ID_MEMBER);
		return false;
	}
}</script>
<script type="text/javascript">
function showtags(comentario)
{	
if(comentario == \'\')
{
alert(\'\');
return false;
}
}



function errorrojo2(causa){
if(causa == \'\'){
document.getElementById(\'errors\').innerHTML=\'<font class="size10" style="color: red;">'.$txt['reason_elimination'].'</font>\'; return false;}}</script>



<a name="arriba"></a>';

$request = db_query("
SELECT den.id_post
FROM {$db_prefix}denuncias AS den
WHERE den.id_post = {$_GET['topic']}", __FILE__, __LINE__);
$context['contando'] = mysql_num_rows($request);

if($context['contando'] > 5 && empty($context['user']['is_admin']))
fatal_error($txt['post_denounced'], false);

if($context['contando'] > 5 && $context['user']['is_admin'])
echo'<p align="center" style="color: #FF0000;">',$txt['disp_verif1'],' '.$context['contando'].' ',$txt['disp_verif2'],'</p>';

if ($context['user']['is_guest'] && $context['can_view_post'] == '1')
fatal_error($txt['post_private'], false);
//POSTS
while ($message = $context['get_message']())
{
$firma = str_replace('if(this.width >720) {this.width=720}','if(this.width >376) {this.width=376}',$message['member']['signature']);
echo'<div style="margin-bottom:8px;"><div class="box_140" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">Posteado por:</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="smalltext windowbg" border="0" style="width: 130px; padding: 4px;">
<center>';

if (!empty($settings['show_user_images']) && empty($options['show_no_avatars']) && !empty($message['member']['avatar']['image'])){
echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="',$scripturl,'?action=profile;u=', $message['member']['id'], '" title="Ver Perfil">', $message['member']['avatar']['image'], '</a><br />', $message['member']['blurb'], '</div>';
}
else

echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="',$scripturl,'?action=profile;u=', $message['member']['id'], '" title="Ver Perfil"><img src="'.$no_avatar.'" border="0" alt="Sin Avatar" /></a><br />', $message['member']['blurb'], '</div>';

	echo'<div align="left"><b><a href="',$scripturl,'?action=profile;u=', $message['member']['id'], '"><span class="size12"><font face="verdana">', $message['member']['name'], '</a></font></span></b><br />';
				

			echo '<span class="size11">', (!empty($message['member']['group']) ? $message['member']['group'] : $message['member']['post_group']), '</span><br />';
			
			echo '<span title="', (!empty($message['member']['group']) ? $message['member']['group'] : $message['member']['post_group']), '">', $message['member']['group_stars'], '</span>';
			
     		if (!empty($settings['show_gender']) && $message['member']['gender']['image'] != '')
			echo ' <span title="', $message['member']['gender']['name'], '">', $message['member']['gender']['image'], '</span>';
			if (empty($message['member']['options']['bear_tab'])) {
			    $message['member']['options']['bear_tab']='bar';
			}
			echo '
			   <img style="width: 16px;height:16px;" alt="" title="', $message['member']['options']['bear_tab'], '" src="', $settings['default_images_url'], '/estado/', $message['member']['options']['bear_tab'], '.gif" />';
			if($message['member']['title'])
			{echo' <img alt="" title="'. pais($message['member']['title'])  . '" src="',$settings['images_url'],'/icons/banderas/'.$message['member']['title'].'.gif" />';}
			else
			echo' <img alt="" title="" src="',$settings['images_url'],'/icons/banderas/ot.gif" />';
echo' <br /><div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"></div><hr>';	

$iduser = $message['member']['id'];

// aca marca los comentarios de los usuarios
$request = db_query("
SELECT *
FROM {$db_prefix}comentarios
WHERE id_user = $iduser
", __FILE__, __LINE__);
$context['comentuser'] = mysql_num_rows($request);

echo'<b style="color:#585858;font-size:11px;">		
			', $message['member']['topics'], ' ', $txt['disp_posts'], '<br />
   			', $context['comentuser'], ' ',$txt['disp_comments'], '<br />
			', $message['member']['money'], ' ',$txt['disp_points'],'<br />
			', $message['member']['referrals_no'], ' ',$txt['disp_refers'],'<br /></b>
			</div><hr>';if ($context['user']['is_guest'])					
								echo '<div class="smalltext"><a href="', $scripturl,'?action=registrarse" rel="nofollow" target="_blank">',$txt['disp_register1'],'</a>',$txt['disp_register2'],'</div><br />';

if ($settings['show_profile_buttons'])
{
	if ($context['can_send_pm'])
            echo '<div align="left" style="margin-bottom:4px;"><span class="icons emp2"><a href="', $scripturl,'?action=pm;sa=send;u=', $message['member']['id'], '" title="',$txt['send_message'],'"><span class="size11">',$txt['send_message'],'</span></a></span></div>';
	if ($context['user']['is_logged'])					
            echo '<div align="left" style="margin-bottom:4px;"><span class="icons fot2"><a href="', $scripturl,'?action=imagenes;usuario=', $message['member']['name'], '" title="',$txt['disp_images'],'"><span class="size11">',$txt['disp_images'],'</span></a></span></div>';

}
			echo'</center></div></div><div class="box_780" style="float:left;">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center><a class="icons anterior" href="', $scripturl ,'?topic='  ,$topic-1,  '.0"> </a>&nbsp;', $context['subject'], '
&nbsp;<a class="icons siguiente" href="', $scripturl ,'?topic=' ,$topic+1, '.0"> </a></center></div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl,'?action=printpage;topic='.$context['current_topic'].'"><img alt="Imprimir post" border="0" src="', $settings['images_url'] ,'/icons/icono-imprimir-mensaje.gif" ></a></div></div></div><div class="windowbg" style="word-wrap: break-word;width: 770px; padding: 4px;" id="post_' . $message['id'] . '">';

//Publicidad
if ($context['user']['is_guest'])					
{echo'<div align="center" style="display:block;margin:5px;padding:2px"><a href="', $scripturl,'?action=registrarse" style="color:orange;margin-bottom:3px;"><b>',$txt['disp_reg_msg'],'</b></a></div><hr />';
}

echo $message['body'];

//Publicidad
if ($context['user']['is_guest'])					
{echo'<div align="center" style="display:block;margin:5px;padding:2px"><hr /><a href="', $scripturl,'?action=registrarse" style="color:orange;margin-bottom:3px;"><b>',$txt['disp_reg_msg'],'</b></a></div>';
}
echo'</div><!-- info del post -->
<div style="margin-bottom:8px;">
<div style="margin-top:8px;">
<form action="', $scripturl,'?action=removetopic2;topic=', $context['current_topic'], ';sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '" name="causa" id="causa">
<div class="box_390" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">',$txt['disp_options'],'</div>
<div class="box_rss"><span id="gif_cargando_fav" style="display: none;"><img alt="" src="',$settings['images_url'],'/loading.gif" style="width: 16px; height: 16px;" border="0"></span></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;"><span class="size11">'; 

if ($context['allow_admin'])
echo '<input class="login" style="font-size: 11px;" value="',$txt['post_edit'],'" title="',$txt['post_edit'],'" onclick="location.href=\'', $scripturl,'?action=post;msg=', $message['id'], ';topic=', $context['current_topic'], '.', $context['start'], ';sesc=', $context['session_id'], '\'" type="button"> <input class="login" style="font-size: 11px;" value="',$txt['delete_post'],'" title="',$txt['delete_post'],'" onclick="if (!confirm(\'\xbf',$txt['confirm_delete_post'],'\')) return false; return errorrojo2(this.form.causa.value); " type="submit"> <b>',$txt['disp_cause'],':</b> <input type="text" id="causa" name="causa" maxlength="50" size="16"><center><label id="errors"></label></center><hr>';
else{
if ($message['can_remove'])
{
echo'<input class="login" style="font-size: 11px;" value="',$txt['post_edit'],'" title="',$txt['post_edit'],'" onclick="location.href=\'', $scripturl,'?action=post;msg=', $message['id'], ';topic=', $context['current_topic'], '.', $context['start'], ';sesc=', $context['session_id'], '\'" type="button"> <input class="login" style="font-size: 11px;" value="',$txt['delete_post'],'" title="',$txt['delete_post'],'" onclick="if (!confirm(\'\xbf',$txt['confirm_delete_post'],'\')) return false; location.href=\'', $scripturl,'?action=removetopic2;topic=', $context['current_topic'], ';sesc=', $context['session_id'], '\'" type="button">
<hr>';}}

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
		echo'<div id="contenedor"><b class="size11">',$txt['disp_give_points'],'</b> ';
		for ($puntos = 1; $puntos <= $row1['points']; $puntos++) 
		{
			if ($puntos==1)
				echo '<a href="#" onclick="addPuntos(\''.$context['current_topic'].'\',\''.$puntos.'\');return false">', $puntos, '</a>';
			else
				echo ' - <a href="#" onclick="addPuntos(\''.$context['current_topic'].'\',\''.$puntos.'\');return false">', $puntos, '</a>';
		}
		echo ' ',$txt['disp_points'],'</div><hr>';}
	else
		echo'<b>',$txt['no_point'],'</b><hr>';
	}
else
echo'',$txt['no_qualify'],'<hr>';

if($context['user']['is_logged']){
echo'<span id="favs"><a class="iconso agregar_favoritos" href="#" style=" cursor: pointer; display: inline;" onclick="add_Favoritos('.$context['current_topic'].'); return false;">',$txt['add_favorite'],'</a> | <a  class="iconso denunciar_post" title="',$txt['disp_report_post'],'" href="', $scripturl,'?action=denunciar;id=' . $context['current_topic'] . '"/>',$txt['disp_report_post'],'</a> | ';}

echo'<a class="iconso recomendar_post" href="', $scripturl,'?action=enviar-a-amigo;topic='.$context['current_topic'].'">&nbsp;&nbsp;&nbsp;&nbsp;',$txt['disp_send_friend'],'</a></span><hr /><b class="size11">',$txt['disp_related_post'],'</b><br />';

if(!empty($context['posts10']))
{
    foreach ($context['posts10'] as $posts10)
    {
        echo'<div class="hov_post"><img align="absmiddle" src="',$settings['images_url'],'/post/icono_'.$posts10['idb'].'.gif" title="'.$posts10['bname'].'"> <a href="', $scripturl ,'?topic='.$posts10['id'].'" title="'.$posts10['subject'].'">'.$posts10['subject'].'</a></div>';
    }
} else echo '<br><i>No existen posts relacionados</i>';
		
echo'</span></div></div></form>

<div style="float:left;margin:bottom:8px;">
<div class="box_390" >
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">',$txt['post_info'],'</div>
<div class="box_rss"><img alt="" src="',$settings['images_url'],'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;">

<span class="size11" style="margin-left:65px;font-weight:bold;"><span class="icons visitas">&nbsp;', $context['num_views'], '&nbsp;',$txt['disp_visits'],'</span><span class="icons fav"><span id="cant_favs_post">'. $context['fav1'] .'</span>&nbsp;',$txt['disp_favs'],'</span><span class="icons puntos"> <span id="cant_pts_post">'.$context['puntos-post'].'</span>&nbsp;',$txt['disp_points'],'</span></span><hr />
<span class="size11">
<b>',$txt['disp_created'],':</b>&nbsp;', $message['time'], '<hr />

<b>',$txt['disp_category'],':</b> '.$message['board']['link'].'<hr /><b>',$txt['disp_tags'],':</b>';
if ($context['topic_tags'])
{
foreach ($context['topic_tags'] as $i => $tag)
{echo ' <a href="', $scripturl,'?action=tags;id=' . $tag['ID_TAG']  . '">' . $tag['tag'] . '</a>&nbsp;';}}
else echo' ',$txt['no_tags'],'';
if ($message['can_modify']){
    echo '&nbsp;<a href="', $scripturl,'?action=tags;sa=addtag;topic=',$topic, '"><img title="',$txt['add_tags'],'" src="',$settings['images_url'],'/icons/icono-agregar-etiqueta.gif" align="absmiddle" hspace="4"></a>';
}
echo' <hr />';
$link = ''. $scripturl .'?topic='. $context['current_topic']. '';

echo'<div style="float:left; margin-right:4px;"><b>',$txt['add_to'],'</b></div>
<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://www.facebook.com/share.php?u='.$link.'" rel="nofollow" target="_blank" title="',$txt['add_facebook'],'"><img src="',$settings['images_url'],'/icons/facebook.png"></a></div>
<div class="icon_img" style="float: left; margin-right:8px;"><a href="http://technorati.com/faves/?add='.$link.'" rel="nofollow" target="_blank" title="',$txt['add_technorati'],'"><img src="',$settings['images_url'],'/icons/technorati.png" style="cursor: pointer;display: inline;"></a></div>
<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://del.icio.us/post?url='.$link.'" rel="nofollow" target="_blank" title="',$txt['add_delicio'],'"><img src="',$settings['images_url'],'/icons/delicious.png" style="cursor: pointer;display: inline;"></a></div>
<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://digg.com/submit?phase=2&url='.$link.'" rel="nofollow" target="_blank" title="',$txt['add_digg'],'"><img src="',$settings['images_url'],'/icons/digg.png" style="cursor: pointer;display: inline;"></a></div>
<div class="icon_img" style="margin-right:4px;"><a href="http://twitter.com/home?status=Les%20recomiendo%20este%20post:%20'.$link.'" rel="nofollow" target="_blank" title="',$txt['add_twitter'],'"><img src="',$settings['images_url'],'/icons/twitter.png"></a></div>
</span></div></div>';
        
if (!empty($message['member']['signature']) && empty($options['show_no_signatures'])){
echo'<div class="box_390" style="float:left; margin-top:8px;">
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">Firma</div>
<div class="box_rss"><img alt="" src="',$settings['images_url'],'/blank.gif" style="width:16px;height:16px;" border="0" /></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;"><b class="size11">'.censorText($firma).'</b></div></div></div>';
}else{
echo'';}
echo'</div><a name="fin"></a><!-- fin info del post --><!-- comentarios --><div style="margin-bottom:8px;">
<div class="box_780" style="float:left;margin-bottom:8px;margin-top:8px;"><form action="', $scripturl,'?action=rz;m=eliminarc" method="post" accept-charset="', $context['character_set'], '" name="coments" id="coments">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">'. $context['numcom'] .' ',$txt['disp_comments'],'</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=comentarios;id=', $context['current_topic'], '"><img alt="" src="',$settings['images_url'],'/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;" /></a></div></div></div><div class="windowbg" style="word-wrap: break-word; width: 770px; padding: 4px;">';
if($context['haycom'])
{foreach ($context['comentarios'] AS $coment){
echo'<div id="cmt_'.$coment['id'].'"><span class="size12">';
// eliminar cmt
if ($message['can_remove'])
echo'<input type="checkbox" name="campos['.$coment['id'].']" />';

$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
$diames2 = date(j,$coment['fecha']); $mesano2 = date(n,$coment['fecha']) - 1 ; $ano2 = date(Y,$coment['fecha']);
$seg2=date(s,$coment['fecha']); $hora2=date(H,$coment['fecha']); $min2=date(i,$coment['fecha']);

echo' #'.$cantidad++.'</a> 
<b id="autor_cmnt_'.$coment['id'].'" user_comment="'.$coment['nomuser'].'" text_comment="'.$coment['comentario2'].'"><a href="', $scripturl,'?action=profile;u='.$coment['user'].'">'.$coment['nomuser'].'</a></b> |
<span class="size10">'.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2;
echo '</span> <a class="iconso emp" href="', $scripturl,'?action=pm;sa=send;u='.$coment['user'].'" title="',$txt['disp_send_mp_to'],': '.$coment['nomuser'].'"><img src="',$settings['images_url'],'/espacio.gif" align="top" border="0"></a><a class="iconso citar" onclick="citar_comment('.$coment['id'].')" href="javascript:void(0)" title="',$txt['quote_coment'],'"><img src="',$settings['images_url'],'/espacio.gif" align="top" border="0"></a> dijo:<br>'. $coment['comentario'] .'</p></span></div><hr>';
}}else{
echo'<div id="no_comentarios"><span class="size11"><b>',$txt['post_no_comments'],'</b></span></div><hr>';}
if ($context['is_locked'])
echo'<div id="post_cerrado"><span class="size11"><b>',$txt['closed_comments'],'</b></span></div><hr>';

echo'<span id="previacomentario" style="display:none;margin-top:0px;padding-top:-5px;"></span>';

echo'</div>';
if($context['haycom'])
{if ($message['can_remove'])
echo'<div id="commentselect"><span class="size10">',$txt['selected_commentaries'],'</span> <input class="login" style="font-size: 9px;" type="submit" value="',$txt['disp_delete'],'"></div>';}else{echo'';}
echo'<input type="hidden" name="topic" value="', $context['current_topic'], '" />
<input type="hidden" name="userid" value="', $context['user']['id'], '" />
<input type="hidden" name="memberid" value="', $message['member']['id'], '" />
</form></div></div>
<!-- fin comentarios -->';
if ($context['can_reply'] && !empty($options['display_quick_reply'])){
echo'<!-- comentar --><a name="comentar"></a>
<div style="margin-bottom:8px;">
<div class="box_780" style="float:left;margin-bottom:8px;">
<div id="cajacomment"><div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">',$txt['new_comment'],'</div>
<div class="box_rss"><span id="gif_cargando_add_comment" style="display: none;"><img alt="" src="',$settings['images_url'],'/loading.gif" style="width: 16px; height: 16px;" border="0"></span></div></div>
<div class="windowbg" style="width: 770px; padding: 4px;">
<form action="', $scripturl,'?action=rz;m=comentar" method="post" accept-charset="UTF-8" name="postmodify"><center><span class="size11">';
theme_quickreply_box();
echo'<center><label id="error" class="size10" style="color: red;"></label></center>

<input class="login" type="submit" name="post" id="post" value="',$txt['disp_send_comm'] ,'" onclick="return errorrojo(this.form.cuerpo_comment.value,', $context['current_topic'], ','.$message['board']['id'].',' . $context['user']['id'] . ');" tabindex="2" /></div>
</span></center></form></div></div></div>
<!-- fin comentar -->';}}
echo'</div></div></div>';}

function template_quickreply_box()
{
global $context, $settings, $options, $txt, $modSettings, $boardurl;
echo '<textarea style="height:90px;width:615px;-moz-border-radius:5px;" id="cuerpo_comment" name="cuerpo_comment" class="markItUpEditor" tabindex="1"></textarea>';					

if (!empty($context['smileys']['postform']))
{foreach ($context['smileys']['postform'] as $smiley_row){
foreach ($smiley_row['smileys'] as $smiley)
echo'<a style="padding-right:4px;" href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.postmodify.cuerpo_comment); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a> ';
if (empty($smiley_row['last']))
echo'';}
if (!empty($context['smileys']['popup']))
echo'<script type="text/javascript">function openpopup(){var winpops=window.open("',$boardurl,'/emoticones.php","","width=255px,height=500px,scrollbars");}</script><a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a>';}
}
?>