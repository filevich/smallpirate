<?php

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;
	global $query_this_board, $func;
	
require('../../Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("$boarddir/SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

$comment=mysql_query("
SELECT *
FROM ({$db_prefix}comentarios AS c, {$db_prefix}members AS mem, smf_messages AS m)
WHERE c.id_user=mem.ID_MEMBER AND m.ID_TOPIC = c.id_post
ORDER BY c.id_coment DESC LIMIT 25");
$context['comment'] = array();
while ($row = mysql_fetch_assoc($comment))
{
$row['comentario'] = parse_bbc($row['comentario'], 1, $row['ID_MSG']); 
censorText($row['comentario']);
censorText($row['subject']);
$row['comentario'] = strtr($func['substr'](str_replace('<br />', "\n", $row['comentario']), 0, 400 - 3), array("\n" => '<br />')) . '...';
$context['comment'][] = array(
'comentario' => $row['comentario'],
'titulo' => $row['subject'],
'nom-user' => $row['realName'],
'id_comment' => $row['id_coment'],
'id' => $row['id_post'],);}
mysql_free_result($comment);

$contando=1;
echo'<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92" xml:lang="spanish">
	<channel>
	 <image>
    <url>'; echo $url; echo '/web/imagenes/rss.png</url>
    <title>Comentarios de los post</title>
    <link>'; echo $url; echo '</link>

    <width>111</width>
    <height>32</height>
    <description>Ultimos 25 comentarios de los post</description>
  </image>
	    <title>Comentarios de los post</title>
    <link>'; echo $url; echo '</link>
    <description>Ultimos 25 comentarios de los post</description>';
foreach($context['comment'] AS $comment){

echo '<item>
			<title><![CDATA['. $comment['nom-user'] .' - '. $comment['titulo'] .']]></title>
			<link>'; echo $url; echo '/post/'. $comment['id'] .'#cmt_'. $comment['id_comment'] .'</link>
			<description><![CDATA['. $comment['comentario'] .']]>
			</description>
			<comments>'; echo $url; echo '/post/'. $comment_img['id'] .'#comentar</comments>
		</item>';

		}

echo'	</channel>
</rss>
';  ?> 