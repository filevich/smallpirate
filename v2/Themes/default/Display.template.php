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
global $db_prefix, $user_info, $scripturl, $modSettings, $board, $no_avatar;
global $query_this_board, $func;
$cantidad = 1;
$txt['comentarios'] = 'comentarios';
$txt['mensajes'] = 'post';

echo '
<script type="text/javascript">function errorrojo(comentario){
if(comentario == \'\'){
document.getElementById(\'error\').innerHTML=\'<br><font class="size10" style="color: red;">No has escrito ning&uacute;n comentario.</font>\'; return false;}}</script>
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
document.getElementById(\'errors\').innerHTML=\'<font class="size10" style="color: red;">Es necesaria la causa de la eliminaci&oacute;n.</font>\'; return false;}}</script>
<a name="inicio"></a>';

$request = db_query("
SELECT den.id_post
FROM cw_denuncias AS den
WHERE den.id_post = {$_GET['topic']}", __FILE__, __LINE__);
$context['contando'] = mysql_num_rows($request);

if($context['contando'] > 5 && empty($context['user']['is_admin']))
fatal_error('Post eliminado por acumulaci&oacute;n de denuncias, se encuentra en proceso de revisi&oacute;n.', false);

if($context['contando'] > 5 && $context['user']['is_admin'])
echo'<p align="center" style="color: #FF0000;">Verificar Post - Tiene '.$context['contando'].' denuncias</p>';

if ($context['user']['is_guest'] && $context['can_view_post'] == '1')
fatal_error('Este post es privado, para verlo debes autentificarte.', false);
		//POSTS
while ($message = $context['get_message']())
{
$firma = str_replace('if(this.width >720) {this.width=720}','if(this.width >376) {this.width=376}',$message['member']['signature']);
echo'<div>
<div class="box_140" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">Publicado por:</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="smalltext windowbg" border="0" style="width: 130px; padding: 4px;">
<center>';

if (!empty($settings['show_user_images']) && empty($options['show_no_avatars']) && !empty($message['member']['avatar']['image'])){
echo '<div class="sup">&nbsp;</div><div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="?action=profile;user=', $message['member']['username'], '" title="Ver Perfil">', $message['member']['avatar']['image'], '</a><br />', $message['member']['blurb'], '</div><div class="inf">&nbsp;</div><br />';
}
else

echo '<div class="sup">&nbsp;</div><div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="?action=profile;user=', $message['member']['username'], '" title="Ver Perfil"><img src="'.$no_avatar.'" border="0" alt="Sin Avatar" /></a><br />', $message['member']['blurb'], '</div><div class="inf">&nbsp;</div><br />';

	echo' <b><a href="?action=profile;user=', $message['member']['username'], '">', $message['member']['name'], '</a></b><br />';
				

			echo '', (!empty($message['member']['group']) ? $message['member']['group'] : $message['member']['post_group']), '<br />';
			
			echo '<span title="', (!empty($message['member']['group']) ? $message['member']['group'] : $message['member']['post_group']), '">', $message['member']['group_stars'], '</span>';
			
     		if (!empty($settings['show_gender']) && $message['member']['gender']['image'] != '')
			echo ' <span title="', $message['member']['gender']['name'], '">', $message['member']['gender']['image'], '</span>';
			if($message['member']['title'])
			{echo' <img title="'. pais($message['member']['title'])  . '" src="/Themes/default/images/icons/banderas/'.$message['member']['title'].'.gif">';}
			else
			echo' <img src="/Themes/default/images/icons/banderas/ot.gif">';
echo'<br> <br /><div class="sup">&nbsp;</div><div class="fondoavatar" style="overflow: auto; width: 130px;" align="center">';	

$iduser = $message['member']['id'];

// aca marca los comentarios de los usuarios
$request = db_query("
SELECT *
FROM cw_comentarios
WHERE id_user = $iduser
", __FILE__, __LINE__);
$context['comentuser'] = mysql_num_rows($request);

echo'		
			', $message['member']['topics'], ' ', $txt['mensajes'], '<br />
   			', $context['comentuser'], ' ', $txt['comentarios'], '<br />
			', $message['member']['money'], ' puntos</div><div class="inf">&nbsp;</div><br />';

if ($context['user']['is_guest'])					
								echo '<div class="smalltext"><i>Para ver el panel de usuario<br>debes estar</i> <a href="/?action=registrarse" rel="nofollow" target="_blank"><b><i>REGISTRADO!</i></b></a></div><br /><br>';

if ($settings['show_profile_buttons'])
			{

					if ($context['can_send_pm'])
					echo '
								<a href="/?action=pm;sa=send;u=', $message['member']['id'], '" title="', $message['member']['online']['label'], '">', $settings['use_image_buttons'] ? '<img src="' . $settings['images_url'] . '/im_' . ($message['member']['online']['is_online'] ? 'on' : 'off') . '.gif" alt="' . $message['member']['online']['label'] . '" border="0" />' : $message['member']['online']['label'], '</a>';
               
						
					if ($context['user']['is_logged'])					
								echo ' <a href="?action=imagenes&usuario=', $message['member']['name'], '" title="Galer&iacute;a de ', $message['member']['name'], '" alt="Galer&iacute;a de ', $message['member']['name'], '"><img title="Galer&iacute;a de ', $message['member']['name'], '" src="/Themes/default/images/icons/icono-foto.gif" alt="Galer&iacute;a de ', $message['member']['name'], '" border="0"></a>';
		
			if ($context['user']['is_logged'])					
								echo '
								<a href="/web/rss/rss-user.php?us=', $message['member']['name'], '"><img src="/Themes/default/images/rss.gif" alt="Ver Feed de ', $message['member']['name'], '" title="Ver Feed de ', $message['member']['name'], '" border="0" /></a>';
			}
			echo'</center></div></div>
			

<div class="box_780" style="float:left;">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>'; $topic--;  echo'<a class="icons anterior" href="'. $scripturl .'?topic='  .$topic.  '.0"> </a>', $context['subject'], ''; $topic++;			
$topic++; echo '<a class="icons siguiente" href="'. $scripturl .'?topic=' .$topic. '.0"> </a></center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;" id="post_' . $message['id'] . '">', $message['body'], '</div>

<!-- info del post -->
<div style="margin-top:8px;">
<form action="/?action=removetopic2;topic=', $context['current_topic'], ';sesc=', $context['session_id'], '" method="post" accept-charset="', $context['character_set'], '" name="causa" id="causa">
<div class="box_390" style="float:left; margin-right:8px;">
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">Opciones</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;"><span class="size11">'; 

if ($context['allow_admin']) echo'<input class="login" style="font-size: 11px;" value="Editar post" title="Editar post" onclick="location.href=\'/?action=post;msg=', $message['id'], ';topic=', $context['current_topic'], '.', $context['start'], ';sesc=', $context['session_id'], '\'" type="button"> <input class="login" style="font-size: 11px;" value="Eliminar post" title="Eliminar post" onclick="if (!confirm(\'\xbfEstas seguro que desea eliminar este post?\')) return false; return errorrojo2(this.form.causa.value); " type="submit"> <b>Causa:</b> <input type="text" id="causa" name="causa" maxlength="50" size="30"><center><label id="errors"></label></center><hr>
'; else{
if ($message['can_remove']){
echo'<input class="login" style="font-size: 11px;" value="Editar post" title="Editar post" onclick="location.href=\'/?action=post;msg=', $message['id'], ';topic=', $context['current_topic'], '.', $context['start'], ';sesc=', $context['session_id'], '\'" type="button"> <input class="login" style="font-size: 11px;" value="Eliminar post" title="Eliminar post" onclick="if (!confirm(\'\xbfEstas seguro que desea eliminar este post?\')) return false; location.href=\'/?action=removetopic2;topic=', $context['current_topic'], ';sesc=', $context['session_id'], '\'" type="button">
<hr>';}}

if($context['novato'] || $context['buenus'] || $context['allow_admin']){
echo'<b class="size11">Dar Puntos:</b> <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=1">1</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=2">2</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=3">3</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=4">4</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=5">5</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=6">6</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=7">7</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=8">8</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=9">9</a> - <a href="/?action=enviar-puntos;do=sendmoney2;topic=', $context['current_topic'], ';amount=10">10</a> Puntos
<hr>';}
else
echo'Usuarios no registrados y lecheer no puede calificar.<hr>';

if($context['user']['is_logged']){
echo'<a class="icons recomendar_post" href="?action=thankyou;topic=', $context['current_topic'], ';msg=', $message['id'], '" title="Agradecer post">Agradecer post</a> | <a class="icons agregar_favoritos" href="?action=favoritos;sa=add;topic=', $context['current_topic'], '" rel="nofollow" target="_blank" >Agregar a Favoritos</a> | <a  class="icons denunciar_post" title="Denunciar post" href="/?action=denunciar&id=' . $context['current_topic'] . '"/>Denunciar post</a><hr>';}

echo'<a title="Enviar a un amigo" href="/?action=enviar-a-amigo;topic='.$context['current_topic'].'"><img alt="Enviar a un amigo" border="0" src="/Themes/default/images/icons/icono-enviar-mensaje.gif" align="absmiddle" hspace="4">Enviar a un amigo</a> | <a title="Imprimir post" href="/?action=printpage;topic=' . $context['current_topic'] . '"><img alt="Imprimir post" border="0" src="/Themes/default/images/icons/icono-imprimir-mensaje.gif" align="absmiddle" hspace="4"> Imprimir post</a><hr> <b class="size11">M&aacute;s post para ver:</b><br>';
foreach ($context['posts10'] as $posts10){echo'
<div><img src="/Themes/default/images/post/icono_'.$posts10['idb'].'.gif" title="'.$posts10['bname'].'"> <a href="/?topic='.$posts10['id'].'" title="'.$posts10['subject'].'">'.$posts10['subject'].'</a></div>';}
			
echo'</span></div></form></div>

<div class="box_390" style="float:left;">
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">Informaci&oacute;n del Post</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;"><span class="size11"><span class="icons visitas">&nbsp;', $context['num_views'], '&nbsp;visitas</span><span class="icons comentaron">&nbsp;'. $context['numcom'] .'&nbsp;comentarios</span><span class="icons fav">'. $context['fav1'] .'&nbsp;favoritos</span><span class="icons puntos">&nbsp;'.$context['puntos-post'].'&nbsp;puntos</span><hr>
<b>Creado el:</b>&nbsp;', $message['time'], '<hr>
<b>Categor&iacute;a:</b> '.$message['board']['link'].'<hr>
<b>Tags:</b>&nbsp;';
if ($context['topic_tags'])
{
foreach ($context['topic_tags'] as $i => $tag)
{echo '<a href="/?action=tags;id=' . $tag['ID_TAG']  . '">' . $tag['tag'] . '</a>&nbsp;';}}
else echo'Este post no tiene tags';	if ($message['can_modify']){
global $topic;
echo '
&nbsp;<a href="?action=tags;sa=addtag;topic=',$topic, '"><img title="Agregar Tags" src="/Themes/default/images/icons/icono-agregar-etiqueta.gif" align="absmiddle" hspace="4"></a>';
}	
echo'<hr>';if (($message['thank_you_post']['isThankYouPost'])) {
echo '<b>Agradecimienos:</b>&nbsp;';
if(!empty($context['thank_you_post'][$message['id']]))
foreach($context['thank_you_post'][$message['id']]['fulllist'] as $thx){
echo'',$thx['link'],' '; if ($context['user']['is_admin']){
echo''. $thx['deletelink'] .'';}
echo'&nbsp;|&nbsp;&nbsp;';}
echo'<hr>';}
$link = ''. $scripturl .'?topic='. $context['current_topic']. '';
echo'<div style="float:left; margin-right:4px;"><b>Agregar a:</b></div>
<div class="icon_img" style="float: left; margin-right:8px;"><a href="http://technorati.com/faves/?add='.$link.'" rel="nofollow" target="_blank" title="Agregar a: Technorati"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -391px; display: inline;"></a></div>

<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://furl.net/storeIt.jsp?u='.$link.'" rel="nofollow" target="_blank" title="Agregar a: Furl"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -411px; display: inline;"></a></div>

<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://www.meneame.net/submit.php?url='.$link.'" rel="nofollow" target="_blank" title="Agregar a: Meneame"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -472px; display: inline;"></a></div>

<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://del.icio.us/post?url='.$link.'" rel="nofollow" target="_blank" title="Agregar a: Del.icio"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -432px; display: inline;"></a></div>

<div class="icon_img" style="float: left; margin-right:4px;"><a href="http://digg.com/submit?phase=2&url='.$link.'" rel="nofollow" target="_blank" title="Agregar a: Digg"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -453px; display: inline;"></a></div>

<div class="icon_img" style="margin-right:190px;"><a href="http://twitter.com/home?status=Les%20recomiendo%20este%20post:%20'.$link.'" rel="nofollow" target="_blank" title="Agregar a: Twitter"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -514px; display: inline;"></a></div>

</span></div></div></div>
<a name="fin"></a>
<div class="box_390" style="float:left; margin-top:8px;">
<div class="box_title" style="width: 386px;"><div class="box_txt box_390-34">Firma</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="windowbg" style="width: 376px; padding: 4px;">';
if (!empty($message['member']['signature']) && empty($options['show_no_signatures'])){
echo'<b class="size11">'.censorText($firma).'</b>';
}else{
echo'<span class="size11"><center><img src="', $settings['images_url'], '/no-firma.jpg" alt="Usuario sin firma" border="0" /></center></span>';}
echo'</div></div>
<!-- fin info del post -->
<!-- comentarios -->
<div>
<div class="box_780" style="float:left; margin-top:8px;"><form action="/?action=rz;m=eliminarc" method="post" accept-charset="', $context['character_set'], '" name="coments" id="coments">
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">Comentarios</div>
<div class="box_rss"><div class="icon_img"><a href="/?type=rss;action=.xml;sa=comentarios;id=', $context['current_topic'], '"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;">';
if($context['haycom'])
{foreach ($context['comentarios'] AS $coment){
echo'<div id="cmt_'.$coment['id'].'"><span class="size11"><p align="left">';
// eliminar cmt
if ($message['can_remove'])
echo'<input type="checkbox" name="campos['.$coment['id'].']">';

$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
$diames2 = date(j,$coment['fecha']); $mesano2 = date(n,$coment['fecha']) - 1 ; $ano2 = date(Y,$coment['fecha']);
$seg2=date(s,$coment['fecha']); $hora2=date(H,$coment['fecha']); $min2=date(i,$coment['fecha']);

echo' <a onclick="citar_comment('.$coment['id'].')" href="javascript:void(0)">#'.$cantidad++.'</a> 
<b id="autor_cmnt_'.$coment['id'].'" user_comment="'.$coment['nomuser'].'" text_comment="'.$coment['comentario2'].'"><a href="?action=profile;user='.$coment['nommem'].'">'.$coment['nomuser'].'</a></b> | 
<span class="size10">'.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2.'</span> <a class="icons emp" href="/?action=pm;sa=send;u='.$coment['user'].'" title="Enviar MP a: '.$coment['nomuser'].'"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a><a class="icons citar" onclick="citar_comment('.$coment['id'].')" href="javascript:void(0)" title="Citar Comentario"><img src="/Themes/default/images/espacio.gif" align="top" border="0"></a> dijo:<br>'. $coment['comentario'] .'</p></span></div><hr>';
}}else{
echo'<div id="no_comentarios"><span class="size11"><b>Este post no tiene comentarios.</b></span></div><hr>';}
if ($context['is_locked'])
echo'<div id="post_cerrado"><span class="size11"><b>Este post esta cerrado, por lo tanto no se permiten nuevos comentarios.</b></span></div><hr>';

echo'</div>';
if($context['haycom'])
{if ($message['can_remove'])
echo'<span class="size10">Comentarios Seleccionados:</span> <input class="login" style="font-size: 9px;" type="submit" value="Eliminar">';}else{echo'';}
echo'<input type="hidden" name="topic" value="', $context['current_topic'], '" />
<input type="hidden" name="userid" value="', $context['user']['id'], '" />
<input type="hidden" name="memberid" value="', $message['member']['id'], '" />
</form></div></div>
<!-- fin comentarios -->';
if ($context['can_reply'] && !empty($options['display_quick_reply'])){
echo'<!-- comentar -->
<div style="margin-bottom:8px;">
<div class="box_780" style="float:left; margin-top:8px; margin-bottom:8px;">
<a name="comentar"></a>
<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34">Agregar un nuevo comentario</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;">
<script language="JavaScript" type="text/javascript">
    var view_newest_first = ', $options['view_newest_first'], '
	smf_topic = ', $context['current_topic'], ';
	smf_start = ', $context['start'], ';
	var smf_template_body_normal = \'%body%\';
	var smf_template_subject_normal = \'<a href="?topic=', $context['current_topic'], '">%subject%</a>\';
if (window.XMLHttpRequest)
showModifyButtons();</script>
<span class="size11"><form action="/?action=rz;m=comentar" method="post" accept-charset="', $context['character_set'], '" name="postmodify" id="comentario"><center>';
theme_quickreply_box();
echo'<label id="error"></label><br><input class="login" type="submit" name="post" id="post" value="Enviar Comentario" onclick="return errorrojo(this.form.cuerpo_comment.value);" tabindex="2" />
<input type="hidden" name="ID_TOPIC" value="', $context['current_topic'], '" />
<input type="hidden" name="ID_BOARD" value="'.$message['board']['id'].'" />
<input type="hidden" name="ID_MEMBER" value="' . $context['user']['id'] . '" />
</center></form></span>
</div></div></div></div>
<!-- fin comentar -->';}

echo'</div></div>';}}
function template_quickreply_box(){
global $context, $settings, $options, $txt, $modSettings;
echo '<textarea style="height:90px;width:615px;" id="cuerpo_comment" name="cuerpo_comment" class="markItUpEditor" tabindex="1"></textarea><br>';					

if (!empty($context['smileys']['postform']))
{foreach ($context['smileys']['postform'] as $smiley_row){
foreach ($smiley_row['smileys'] as $smiley)
echo'<a href="javascript:void(0);" onclick="replaceText(\' ', $smiley['code'], '\', document.forms.postmodify.cuerpo_comment); return false;"><img src="', $settings['smileys_url'], '/', $smiley['filename'], '" align="bottom" alt="', $smiley['description'], '" title="', $smiley['description'], '" /></a> ';
if (empty($smiley_row['last']))
echo'<br />';}
if (!empty($context['smileys']['popup']))
echo'<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script><a href="javascript:openpopup()">[', $txt['more_smileys'], ']</a>';}
}
?>