<?php

/////// Spirate V.2.3 ////////
/////// www.spirate.net ///////
header("Content-Type: text/html;charset=utf-8");
function template_manual_above(){}
function template_manual_below(){}
function template_intro(){}

function template_enviari()
{
global $context, $settings, $options, $txt, $modSettings, $db_prefix, $user_info, $modSettings, $board;
global $query_this_board, $func;

//Limpio el texto de codigo maligno
$filename = mysql_real_escape_string($_POST['filename']);
$description = mysql_real_escape_string($_POST['description']);
$cat = (int) $_POST['cat'];
$title = mysql_real_escape_string($_POST['title']);
$ID_MEMBER = (int) $context['user']['id'];
$date = mysql_real_escape_string($_POST['date']);
$user = mysql_real_escape_string($context['user']['name']);
$points=$modSettings['gallery_shop_picadd'];
$allowcomments = $_POST['allowcomments'];
			mysql_query("INSERT INTO {$db_prefix}gallery_pic
			(ID_CAT,filename,title,description,ID_MEMBER,date,allowcomments)
			VALUES ($cat, '$filename', '$title', '$description', '$ID_MEMBER', '$date', '$allowcomments')");
			Header("Location: $scripturl?action=imagenes&usuario=$user");
	
			if (isset($modSettings['shopVersion']))
 				db_query("UPDATE {$dbprefix}members
				 	SET money = money + {$points}
				 	WHERE ID_MEMBER = {$ID_MEMBER}
				 	LIMIT 1", __FILE__, __LINE__);

}

function template_editari()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $modSettings, $board;

$filename = mysql_real_escape_string($_POST['filename']);
$description = mysql_real_escape_string($_POST['description']);
$cat = (int) $_POST['cat'];
$title = mysql_real_escape_string($_POST['title']);
$ID_MEMBER = (int) $_POST['ID_MEMBER'];
$user = mysql_real_escape_string($context['user']['name']);
$date = mysql_real_escape_string($_POST['date']);
$id = (int) $_POST['id'];
$allowcomments = mysql_real_escape_string($_POST['allowcomments']);


mysql_query("
	UPDATE {$db_prefix}gallery_pic
	SET ID_CAT='$cat', filename='$filename', date='$date', title='$title', description='$description' 
	WHERE ID_PICTURE=$id");
					
Header("Location: $scripturl?action=imagenes&usuario=$user");}

function template_postagregado()
{
    global $txt, $db_prefix, $scripturl;
    
$idpost = (int) $_GET['idpost'];
	
 $request = db_query("
                    SELECT ID_TOPIC, subject
                    FROM {$db_prefix}messages
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
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">',$txt['acc_congrats'],'</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 388px; font-size: 12px;">
<br>',$txt['acc_your_post'],' "<b>'; foreach ($context['post1'] AS $npost)echo''.$npost['subject'].'';
  echo'</b>" ',$txt['added_post'],'<br>
		<br>
	     <input class="login" style="font-size: 11px;" type="submit" title="',$txt['acc_go_home'],'" value="',$txt['principal_page'],'" onclick="location.href=\'',$scripturl,'\'" /><br><br></div></div></div>';

}

function template_posteditado()
{
        global $txt, $db_prefix, $scripturl;
        
$idpost = (int) $_GET['idpost'];
	
 $request = db_query("
                    SELECT ID_TOPIC, subject
                    FROM {$db_prefix}messages
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
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">',$txt['acc_congrats'],'</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 388px; font-size: 12px;">
<br>',$txt['acc_your_post'],' "<b>'; foreach ($context['post1'] AS $npost)echo''.$npost['subject'].'';
  echo'</b>" ',$txt['edited_post'],'<br>
             <br>
	     <input class="login" style="font-size: 11px;" type="submit" title="',$txt['acc_go_home'],'" value="',$txt['acc_go_home'],'" onclick="location.href=\'',$scripturl,'\'" /><br><br></div></div></div>';

}

function template_comentar()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $modSettings, $board, $query_this_board, $func;


$ID_TOPIC = (int) $_POST['ID_TOPIC'];
$ID_BOARD = (int) $_POST['ID_BOARD'];
$ID_MEMBER = (int) $context['user']['id'];
$comentarios = mysql_real_escape_string(utf8_decode($_POST['cuerpo_comment']));
$fecha = time();
mysql_query("SET NAMES 'utf8'");
mysql_query("INSERT INTO {$db_prefix}comentarios
			(id_post,id_cat,id_user,comentario,fecha)
			VALUES ($ID_TOPIC, '$ID_BOARD', '$ID_MEMBER','$comentario','$fecha')");
Header("Location: $scripturl?topic=$ID_TOPIC");
}

function template_eliminarc()
{
    global $context, $settings, $options, $txt, $scripturl, $modSettings;
    global $db_prefix, $user_info, $modSettings, $board;
    global $query_this_board, $func;

$topic = $_POST['topic'];
$userid = $_POST['userid'];
$memberid = $_POST['memberid'];
Header("Location: $scripturl?topic=$topic");
if ($userid = $memberid){
if(!empty($_POST['campos'])) {
$aLista=array_keys($_POST['campos']);
mysql_query("DELETE FROM {$db_prefix}comentarios WHERE id_coment IN (".implode(',',$aLista).")");}}}

function template_vr2965(){
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
        global $db_prefix, $user_info, $modSettings, $board;
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
		<font face="Arial">',$txt['acc_reg_vibe'],'</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table width="100%" cellpadding="3" cellspacing="0" border="0"><tr>
		<td width="100%" class="windowbg"><form action="',$scripturl,'?action=rz;m=vr2965;editando=1" method="post" name="enviar" onsubmit="submitonce(this);" style="margin: 0;">';
echo '<textarea name="texto" cols="125" rows="25" tabindex="2">'.$texto2.'</textarea><br>';

$existe=mysql_query("
                SELECT *
                FROM {$db_prefix}smileys
                WHERE hidden=0
                ORDER BY ID_SMILEY ASC");

while ($row = mysql_fetch_assoc($existe))
{
echo'<a href="javascript:void(0);" onclick="replaceText(\' ', $row['code'], '\', document.forms.enviar.texto); return false;"><img src="/Smileys/default/'.$row['filename'].'" align="bottom" alt="', $smiley['description'], '" title="', $row['description'], '" /></a> ';
}
mysql_free_result($existe);
echo '<script type="text/javascript">function openpopup(){var winpops=window.open("/emoticones.php","","width=255px,height=500px,scrollbars");}</script> <a href="javascript:openpopup()">[m&aacute;s]</a>';

		
echo'<center><input type="submit" value="Editar" class="login"></center></form></td>
		</tr></table></body><html>';}}
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
Header("Location: $scripturl");}
}

function template_endenuncias()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $modSettings, $board;
global $query_this_board, $func;

$ID_TOPIC2 =  $_POST['ID_TOPIC'];
$ID_MEMBER2 = $_POST['ID_MEMBER'];
$comentario = htmlspecialchars($_POST['comentario']);
$razon = htmlspecialchars($_POST['razon']);

	$errorr = db_query("
			SELECT *
			FROM {$db_prefix}denuncias
			WHERE id_user = $ID_MEMBER2 AND	id_post = $ID_TOPIC2
			LIMIT 1", __FILE__, __LINE__);
    
	$yadio = mysql_num_rows($errorr) != 0 ? true : false;
	mysql_free_result($errorr);
if ($yadio)
    	fatal_error($txt['already_denounced'], false);


mysql_query("INSERT INTO {$db_prefix}denuncias
			(id_post,id_user,razon,comentario)
			VALUES ('$ID_TOPIC2','$ID_MEMBER2','$razon','$comentario')");
Header("Location: $scripturl?action=denunciar&page=enviada");
}

function template_eldenuncias()
{
        global $context, $settings, $options, $txt, $scripturl, $modSettings;
        global $db_prefix, $user_info, $modSettings, $board;
        global $query_this_board, $func;

if(!empty($_POST['campos'])|| $context['allow_admin']) {
$aLista=array_keys($_POST['campos']);
mysql_query("DELETE FROM {$db_prefix}denuncias WHERE id_denuncia IN (".implode(',',$aLista).")");}
Header("Location: $scripturl?action=rz;m=denuncias");
}

function template_denuncias()
{
global $context, $settings, $options, $txt, $scripturl, $modSettings;
global $db_prefix, $user_info, $board;
global $query_this_board, $func;

function razon($valor)
{
			
$valor = str_replace("0", $txt['acc_val0'], $valor);
$valor = str_replace("1", $txt['acc_val1'], $valor);
$valor = str_replace("2", $txt['acc_val2'], $valor);
$valor = str_replace("3", $txt['acc_val3'], $valor);
$valor = str_replace("4", $txt['acc_val4'], $valor);
$valor = str_replace("5", $txt['acc_val5'], $valor);
$valor = str_replace("6", $txt['acc_val6'], $valor);
$valor = str_replace("7", $txt['acc_val7'], $valor);
$valor = str_replace("8", $txt['acc_val8'], $valor);
$valor = str_replace("9", $txt['acc_val9'], $valor);
$valor = str_replace("10", $txt['acc_val10'], $valor);
$valor = str_replace("11", $txt['acc_val11'], $valor);
$valor = str_replace("12", $txt['acc_val12'], $valor);

return $valor;
}

$request = mysql_query("
SELECT *
FROM {$db_prefix}denuncias");
$context['denunciasss'] = mysql_num_rows($request);	
	if ($context['allow_admin']) {
	$cantidad=1;
	echo'<div class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>',$txt['acc_denuncia'],'</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

		<table width="100%" cellpadding="3" cellspacing="0" class="windowbg" border="0">	
		<tr>
		<td>
<form action="'.$scripturl.'?action=rz;m=eldenuncias" method="post" accept-charset="', $context['character_set'], '" name="eldenuncias" id="eldenuncias">

	';
echo'<p align="right"><span class="size10">',$txt['acc_denuncia_sel'],'</span> <input class="login" style="font-size: 9px;" type="submit" value="',$txt['acc_elim'],'"></p>';
	
if($context['denunciasss']){
$request = mysql_query("
                    SELECT *
                    FROM ({$db_prefix}denuncias AS den, {$db_prefix}members AS m)
                    WHERE den.id_user = m.ID_MEMBER
                    ORDER BY den.id_denuncia DESC");

while ($den1 = mysql_fetch_assoc($request)){
$comentario = htmlspecialchars($den1['comentario']);
$comentario = censorText($den1['comentario']);

echo'<br>'.$cantidad++.'<br><b>',$txt['user_police'],'</b> <a href="',$scripturl,'?action=profile;u='.$den1['ID_MEMBER'].'" title="'.$den1['realName'].'">'.$den1['realName'].'</a><br>
<b>Post Denunciado:</b> <a href="?topic='.$den1['id_post'].'" title="'.$den1['id_post'].'">'.$den1['id_post'].'</a><br>
<b>Raz&oacute;n:</b> '.razon($den1['razon']).'<br>
<b>Comentario:</b> '.str_replace("\n", "<br>",$den1['comentario']).'<br>
<b>Seleccionar:</b> <input type="checkbox" name="campos['.$den1['id_denuncia'].']"><br><br><hr>';
				}
	mysql_free_result($request);

}else echo'<p align="center">',$txt['no_denounced'],'</p>';
echo'	</form></td>
		</tr></table>';}
		else echo''.Header("Location: $scripturl").'';
}

function template_4674868()
{
global $chatid, $txt;

echo'<div><div class="box_alert1a" style="float:left;">
<div class="box_title" style="width:490px;"><div class="box_txt alert1">Chat</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width:488px;"><center><embed src="http://www.xatech.com/web_gear/chat/chat.swf" quality="high" width="485" height="400" name="chat" FlashVars="id='. $chatid .'&rl=SpanishArgentina" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://xat.com/update_flash.shtml" /></center></div></div>
<div style="float:left;">
<div class="box_alert1b" style="float:left;">
<div class="box_title" style="width:419px;"><div class="box_txt alert">Aclaraci&oacute;n</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width:417px;">
<font class="size12">
<b>1)</b> ',$txt['prohibited_nick'],'
<br>
<br>
<b>2)</b> ',$txt['prohibited_respect_is_absent'],'
<br>
<br>
<b>3)</b> ',$txt['prohibited_insult'],'
<br>
<br>
<b>4)</b> ',$txt['prohibited_spam'],'
<br>
<br>
<b>5)</b> ',$txt['prohibited_flood'],'
<br>
<br>
<b>6)</b> ',$txt['prohibited_shout'],'
<br>
<br>
<b>7)</b> ',$txt['prohibited_spread'],'
<br>
<br>
</font>
</div></div></div></div>


<br><br><br>';
}
?>