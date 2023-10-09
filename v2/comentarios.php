<?php
require('Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

if($context['user']['id']==''){
echo'<span style="color: red;" class="size11"><b>Solo Usuarios REGISTRADOS pueden actualizar los comentarios.<CENTER><a style="color: red;" href="'. $scripturl .'/?action=registrarse">REGISTRATE</a> - <a style="color: red;" href="'. $scripturl .'/?action=login">CONECTATE</a></CENTER></b></span>';
}else{
$rs = mysql_query("SELECT c.id_post, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName
FROM (cw_comentarios AS c, smf_messages AS m, smf_members AS mem)
WHERE id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER
ORDER BY c.id_coment DESC
LIMIT 25");
	$context['comentarios25'] = array();
	while ($row = mysql_fetch_assoc($rs)){
	censorText($row['subject']);
	$context['comentarios25'][] = array(
			'id_coment' => $row['id_coment'],
			'titulo' => $row['subject'],
			'ID_TOPIC' => $row['ID_TOPIC'],
			'memberName' => $row['memberName'],
			'RealName' => $row['RealName'],
		);
	}mysql_free_result($rs);
	foreach ($context['comentarios25'] as $coment25){
	echo '<font class="size11" title="'. $coment25['titulo'] .'" ><b><a href="'; echo $url; echo '?action=profile;user='. $coment25['memberName'] .'">'. $coment25['RealName'] .'</a></b> - <a href="'. $scripturl .'?topic='. $coment25['ID_TOPIC'] .'#cmt_'. $coment25['id_coment'] .'">'. $coment25['titulo'] .'</a><br>';



}	}
 
 ?> 