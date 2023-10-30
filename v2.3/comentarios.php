<?php
require('Settings.php');

global $db_prefix;

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");

require("SSI.php");
mysql_query("SET NAMES 'utf8'");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

$rs = mysql_query("
            SELECT c.id_post, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName
            FROM ({$db_prefix}comentarios AS c, {$db_prefix}messages AS m, {$db_prefix}members AS mem)
            WHERE id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER
            ORDER BY c.id_coment DESC
            LIMIT 15");

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
	{
		$tamano = 45; // tama�o m�ximo en car�cteres, los espacios tambi�n cuentan
		
	if (strlen($coment25['titulo'])>$tamano)	{$coment25['titulo']=substr($coment25['titulo'],0,$tamano-1)."...";}
	echo '<font class="size11" title="'. $coment25['titulo'] .'" ><b>'. $coment25['RealName'] .'</b> - <a href="'. $scripturl .'?topic='. $coment25['ID_TOPIC'] .'#cmt_'. $coment25['id_coment'] .'">'. $coment25['titulo'] .'</a><br>';

	
}}	

 
?> 