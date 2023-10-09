<?php
function template_manual_above(){}
function template_manual_below(){}
function template_intro(){Header("Location: ");}
function template_enviari()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;

$filename = $_POST['filename'];
$description = $_POST['description'];
$cat = $_POST['cat'];
$title = $_POST['title'];
$ID_MEMBER = $context['user']['id'];
$date = $_POST['date'];
$user=$context['user']['name'];
$allowcomments = $_POST['allowcomments'];
			mysql_query("INSERT INTO smf_gallery_pic
			(ID_CAT,filename,title,description,ID_MEMBER,date,allowcomments)
			VALUES ($cat, '$filename', '$title', '$description', '$ID_MEMBER', '$date', '$allowcomments')");
			Header("Location: ?action=imagenes&usuario=$user");
	

			if (isset($modSettings['shopVersion']))
 				db_query("UPDATE smf_members
				 	SET money = money + 5
				 	WHERE ID_MEMBER = {$ID_MEMBER}
				 	LIMIT 1", __FILE__, __LINE__);

}

function template_editari()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;
$filename = $_POST['filename'];
$description = $_POST['description'];
$cat = $_POST['cat'];
$title = $_POST['title'];
$ID_MEMBER = $_POST['ID_MEMBER'];
$user=$context['user']['name'];
$date = $_POST['date'];
$id = $_POST['id'];
$allowcomments = $_POST['allowcomments'];


			mysql_query("
			UPDATE smf_gallery_pic	
			SET ID_CAT='$cat', filename='$filename', date='$date', title='$title', description='$description' 
			WHERE ID_PICTURE=$id
			");
					
Header("Location: ?action=imagenes&usuario=$user");}
function template_postagregado()
{

$idpost = $_GET['idpost'];	
	
 $request = db_query("
SELECT ID_TOPIC, subject
FROM smf_messages
WHERE ID_TOPIC = $idpost
ORDER BY subject ASC
LIMIT 1", __FILE__, __LINE__);
	$context['post1'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['post1'][] = array(
			'subject' => $row['subject'],
			);
	mysql_free_result($request);

echo'<div align="center">
<div class="box_errors">
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">Felicitaciones</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 388px; font-size: 12px;">
		<br>
    Tu post "<b>'; foreach ($context['post1'] AS $npost)echo''.$npost['subject'].'';
  echo'</b>" ha sido agregado correctamente.
  <br>
		<br>
	     <input class="login" style="font-size: 11px;" type="submit" title="Ir al post" value="Ir al post" onclick="location.href=\'?topic='.$idpost.'/\'" /> <input class="login" style="font-size: 11px;" type="submit" title="Ir a la P&aacute;gina principal" value="Ir a la P&aacute;gina principal" onclick="location.href=\'/\'" /><br><br></div></div></div>';

}

function template_posteditado()
{

$idpost = $_GET['idpost'];	
	
 $request = db_query("
SELECT ID_TOPIC, subject
FROM smf_messages
WHERE ID_TOPIC = $idpost
ORDER BY subject ASC
LIMIT 1", __FILE__, __LINE__);
	$context['post1'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['post1'][] = array(
			'subject' => $row['subject'],
			);
	mysql_free_result($request);

echo'<div align="center">
<div class="box_errors">
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">Felicitaciones</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 388px; font-size: 12px;">
		<br>
    Tu post "<b>'; foreach ($context['post1'] AS $npost)echo''.$npost['subject'].'';
  echo'</b>" ha sido editado correctamente.
  <br>
		<br>
	     <input class="login" style="font-size: 11px;" type="submit" title="Ir al post" value="Ir al post" onclick="location.href=\'?topic='.$idpost.'/\'" /> <input class="login" style="font-size: 11px;" type="submit" title="Ir a la P&aacute;gina principal" value="Ir a la P&aacute;gina principal" onclick="location.href=\'/\'" /><br><br></div></div></div>';

}
function template_comentar()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;


$ID_TOPIC = $_POST['ID_TOPIC'];	
$ID_BOARD = $_POST['ID_BOARD'];
$ID_MEMBER = $context['user']['id'];
$comlimpio = $_POST['cuerpo_comment'];
$comentu3=str_replace("casitaweb",'¡Voy a matar a Moe, Wiii!',$comlimpio);
$comentario = strip_tags($comentu3);

$fecha = time();

Header("Location: ?topic=$ID_TOPIC");
mysql_query("INSERT INTO cw_comentarios
			(id_post,id_cat,id_user,comentario,fecha)
			VALUES ($ID_TOPIC, '$ID_BOARD', '$ID_MEMBER','$comentario','$fecha')");
Header("Location: ?topic=$ID_TOPIC");
}

function template_eliminarc()
{global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;
$topic = $_POST['topic'];
$userid = $_POST['userid'];
$memberid = $_POST['memberid'];
Header("Location: ?topic=$topic");
if ($userid = $memberid){
if(!empty($_POST['campos'])) {
$aLista=array_keys($_POST['campos']);
mysql_query("DELETE FROM cw_comentarios WHERE id_coment IN (".implode(',',$aLista).")");}}}

function template_vr2965(){
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;
$request = db_query("
SELECT *
FROM vr_contenido", __FILE__, __LINE__);
while ($row = mysql_fetch_assoc($request))
{
		$texto2=$row['texto'];		
}
mysql_free_result($request);
if($_REQUEST['editar']){
if($context['user']['id']==248 ||$context['user']['id']==1)
{echo'<html><head></head><body>
<table width="100%" cellpadding="3" cellspacing="0" border="0"><tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial">Vibraci&oacute;n Reggae</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table width="100%" cellpadding="3" cellspacing="0" border="0"><tr>
		<td width="100%" class="windowbg"><form action="/?action=rz;m=vr2965;editando=1" method="post" name="enviar" onsubmit="submitonce(this);" style="margin: 0;">';
echo '<textarea name="texto" cols="125" rows="25" tabindex="2">'.$texto2.'</textarea><br>';
$existe=mysql_query("
SELECT *
FROM (smf_smileys)
WHERE hidden=0
ORDER BY ID_SMILEY ASC");
while ($row = mysql_fetch_assoc($existe))
{
echo'<a href="javascript:void(0);" onclick="replaceText(\' ', $row['code'], '\', document.forms.enviar.texto); return false;"><img src="/Smileys/default/'.$row['filename'].'" align="bottom" alt="', $smiley['description'], '" title="', $row['description'], '" /></a> ';
}
mysql_free_result($existe);
echo '<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script> <a href="javascript:openpopup()">[m&aacute;s]</a>';

		
echo'<center><input type="submit" value="Editar" class="login"></center></form></td>
		</tr></table></body><html>';}else echo''.Header("Location: /vibracion-reggae").'';}
else{
$request = db_query("
SELECT *
FROM vr_contenido", __FILE__, __LINE__);
while ($row = mysql_fetch_assoc($request))
{
		$row['texto'] = parse_bbc($row['texto']); 
        censorText($row['texto']);
		$texto=$row['texto'];		
}
mysql_free_result($request);

echo'<html><head></head><body>
<table width="100%" cellpadding="3" cellspacing="0" border="0"><tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial">Vibraci&oacute;n Reggae</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table width="100%" cellpadding="3" cellspacing="0" border="0"><tr>
		<td width="100%" class="windowbg"><span class="size12">'.$texto.'</span></td>
		</tr></table></body><html>'; if($context['user']['id']==248 ||$context['user']['id']==1){ echo'<p align="right"><input class="login" style="font-size: 11px;" type="submit" title="Editar" value="Editar" onclick="location.href=\'/editar-vibracion-reggae\'" /></p>';	 }}
		
if($_GET['editando']){
if($context['user']['id']==248 ||$context['user']['id']==1){	
$texto = $_POST['texto'];
mysql_query("
UPDATE vr_contenido	
SET texto='$texto' 
WHERE id_contenido=1");}
Header("Location: /vibracion-reggae");}
}

function template_endenuncias()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;


$ID_TOPIC2 = $_POST['ID_TOPIC'];	
$ID_MEMBER2 = $_POST['ID_MEMBER'];
$comlimpito = $_POST['comentario'];
$comentario = strip_tags($comlimpito);
$razon = $_POST['razon'];

	$errorr = db_query("
				SELECT *
				FROM cw_denuncias
				WHERE
					id_user = $ID_MEMBER2 AND
					id_post = $ID_TOPIC2
				LIMIT 1", __FILE__, __LINE__);
	$yadio = mysql_num_rows($errorr) != 0 ? true : false;
	mysql_free_result($errorr);
if ($yadio)
    	fatal_error('Ya has denunciado este post.', false);


Header("Location: /?action=denunciar&page=enviada");
mysql_query("INSERT INTO cw_denuncias
			(id_post,id_user,razon,comentario)
			VALUES ('$ID_TOPIC2','$ID_MEMBER2','$razon','$comentario')");
Header("Location: /?action=denunciar&page=enviada");
}

function template_eldenuncias()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;
if(!empty($_POST['campos'])|| $context['allow_admin']) {
$aLista=array_keys($_POST['campos']);
mysql_query("DELETE FROM cw_denuncias WHERE id_denuncia IN (".implode(',',$aLista).")");}
Header("Location: /?action=rz;m=denuncias");
}

function template_denuncias()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $scripturl, $modSettings, $board;
global $query_this_board, $func;
function razon($valor)
{
			
$valor = str_replace("0", "Re-post", $valor);
$valor = str_replace("1", "Se hace Spam", $valor);
$valor = str_replace("2", "Tiene enlaces muertos", $valor);
$valor = str_replace("3", "Es Racista o irrespetuoso", $valor);
$valor = str_replace("4", "Contiene informaci&oacute;n personal", $valor);
$valor = str_replace("5", "El Titulo esta en may&uacute;scula", $valor);
$valor = str_replace("6", "Contiene Pornografia", $valor);
$valor = str_replace("7", "Es Gore o asqueroso", $valor);
$valor = str_replace("8", "Est&aacute; mal la fuente", $valor);
$valor = str_replace("9", "Post demasiado pobre", $valor);
$valor = str_replace("10", "No se encuentra el Pass", $valor);
$valor = str_replace("11", "No cumple con el protocolo", $valor);
$valor = str_replace("12", "Otra raz&oacute;n", $valor);

return $valor;
}

$request = mysql_query("
SELECT *
FROM cw_denuncias");
$context['denunciasss'] = mysql_num_rows($request);	
	if ($context['allow_admin']) {
	$cantidad=1;
	echo'	<table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" color="#FFFFFF">Posts Denunciados</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table width="100%" cellpadding="3" cellspacing="0" class="windowbg" border="0">	
		<tr>
		<td>
<form action="/?action=rz;m=eldenuncias" method="post" accept-charset="', $context['character_set'], '" name="eldenuncias" id="eldenuncias">

	';
echo'<p align="right"><span class="size10">Denuncia/s Seleccionada/s:</span> <input class="login" style="font-size: 9px;" type="submit" value="Eliminar"></p>';
	
if($context['denunciasss']){
$request = mysql_query("
SELECT *
FROM (cw_denuncias AS den, smf_members AS m)
WHERE den.id_user = m.ID_MEMBER
ORDER BY den.id_denuncia DESC");
while ($den1 = mysql_fetch_assoc($request)){
$comentario = htmlspecialchars($den1['comentario']);
$comentario = censorText($den1['comentario']);

echo'<br>'.$cantidad++.'<br><b>Usuario que denunci&oacute;:</b> <a href="?action=profile;user='.$den1['realName'].'" title="'.$den1['realName'].'">'.$den1['realName'].'</a><br>
<b>Post Denunciado:</b> <a href="?topic='.$den1['id_post'].'" title="'.$den1['id_post'].'">'.$den1['id_post'].'</a><br>
<b>Raz&oacute;n:</b> '.razon($den1['razon']).'<br>
<b>Comentario:</b> '.str_replace("\n", "<br>",$den1['comentario']).'<br>
<b>Seleccionar:</b> <input type="checkbox" name="campos['.$den1['id_denuncia'].']"><br><br><hr>';
				}
	mysql_free_result($request);

}else echo'<p align="center">No hay ninguna denuncia hecha.</p>';
echo'	</form></td>
		</tr></table>';}
		else echo''.Header("Location: /").'';
}

function template_4674868(){
global $chatid;
echo'<div><div class="box_alert1a" style="float:left;">
<div class="box_title" style="width:490px;"><div class="box_txt alert1">Chat</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width:488px;"><center><embed src="http://www.xatech.com/web_gear/chat/chat.swf" quality="high" width="485" height="400" name="chat" FlashVars="id='. $chatid .'&rl=SpanishArgentina" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://xat.com/update_flash.shtml" /></center></div></div>
<div style="float:left;">
<div class="box_alert1b" style="float:left;">
<div class="box_title" style="width:419px;"><div class="box_txt alert">Aclaraci&oacute;n</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width:417px;">
<font class="size12">
<b>1)</b> No se permite el uso de Nicks que contengan t&eacute;rminos insultantes, sexuales, publicidad,
link de sitios web, apolog&iacute;as a la violencia y drogas o alg&uacute;n pedido de car&aacute;cter de sexo, compa&ntilde;ia, parejas y/o a fines.
<br>
<br>
<b>2)</b> Est&aacute; prohibido faltar el respeto, insultar, provocar, difamar, acosar, amenazar o hacer cualquier otra cosa no deseada,
tanto directa como indirecta a otras personas.
<br>
<br>
<b>3)</b> No est&aacute; permitido utilizar lenguaje vulgar, obsceno, discriminatorio y/u ofensivo.
<br>
<br>
<b>4)</b> No est&aacute; permitido el SPAM, publicidad o propaganda de p&aacute;ginas personales,
chats, foros, mensajes comerciales destinados a vender productos o servicios, etc.
<br>
<br>
<b>5)</b> No repetir o enviar varias lineas de texto en un cierto tiempo, NO FLOOD.
<br>
<br>
<b>6)</b> Recomendamos no abusar de las MAY&Uacute;SCULAS y utilizarlas s&oacute;lo en comienzos de oraci&oacute;n,
 nombres propios o siglas, ya que el uso de &eacute;sta significa GRITAR.
<br>
<br>
<b>7)</b> Est&aacute; prohibido difundir, exponer o publicar contenido difamatorio, calumnioso, contrario a la moral y las buenas costumbres, discriminatorio, injurioso, violatorio de la intimidad o privacidad o cualquier otro que infrinja las leyes.
<br>
<br>
</font>
</div></div></div></div>


<br><br><br>';
}
?>