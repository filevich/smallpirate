<?php
require('Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("Error al procesar lo solicitado");
require("SSI.php");
mysql_select_db($db_name, $conexion) OR die("Error al procesar lo solicitado");

if($context['user']['id']=='')
{
	echo'<span style="color: red;" class="size11"><b>Solo usuarios registrados pueden comentar</b></span>';
}
else
{
	$ID_TOPIC = (int) $_POST['ID_TOPIC'];
	$ID_BOARD = (int) $_POST['ID_BOARD'];
	$ID_MEMBER = $context['user']['id'];
	$comlimpio = $_POST['cuerpo_comment'];
	$comentario = mysql_real_escape_string(htmlspecialchars($comlimpio));
	$comentarios = parse_bbc($comentario);
	
	
	$fecha = time();
	
	$cantidad=1;
	mysql_query("SET NAMES 'utf8'");
	mysql_query("INSERT INTO {$db_prefix}comentarios
				(id_post,id_cat,id_user,comentario,fecha)
				VALUES ($ID_TOPIC, '$ID_BOARD', '$ID_MEMBER','$comentario','$fecha')");
				
	
	
	$query = mysql_query('SELECT id_coment FROM smf_comentarios ORDER BY id_coment DESC');
	$obj = mysql_fetch_object($query);
	$ultimo_id_coment = $obj->id_coment;
	/***********************************************************************/
	
	$query = mysql_query("SELECT id_coment FROM {$db_prefix}comentarios WHERE id_post = ".$ID_TOPIC);
	$cantidad = mysql_num_rows($query);
	
	echo '<div id="cmt_'.$ultimo_id_coment.'"><span class="size12"><p align="left">';
	// eliminar cmt
	if ($message['can_remove'])
	echo '<input type="checkbox" name="campos['.$ultimo_id_coment.']">';
	
	$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
	$diames2 = date(j,$fecha); $mesano2 = date(n,$fecha) - 1 ; $ano2 = date(Y,$fecha);
	$seg2=date(s,$fecha); $hora2=date(H,$fecha); $min2=date(i,$fecha);
	
	echo ' <a onclick="citar_comment('.$ultimo_id_coment.')" href="javascript:void(0)">#'.$cantidad++.'</a> ';
	echo '<b id="autor_cmnt_'.$ultimo_id_coment.'" user_comment="'.$context['user']['name'].'" text_comment="'.$comentario.'"><a href="',$boardurl,'/index.php?action=profile;u='.$context['user']['id'].'">'.$context['user']['name'].'</a></b> | ';
	echo '<span class="size10">'.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2.'</span> <a class="iconso emp" href="',$boardurl,'/index.php?action=pm;sa=send;u='.$coment['user'].'" title="Enviar MP a: '.$context['user']['name'].'"><img src="',$boardurl,'/Themes/default/images/espacio.gif" align="top" border="0"></a><a class="iconso citar" onclick="citar_comment('.$ultimo_id_coment.')" href="javascript:void(0)" title="Citar Comentario"><img src="',$boardurl,'/Themes/default/images/espacio.gif" align="top" border="0"></a> dijo:<br>'. $comentarios .'</p></span></div><hr>';
}
?> 