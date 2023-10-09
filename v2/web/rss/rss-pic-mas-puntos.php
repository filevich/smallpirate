<?php

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;
	global $query_this_board, $func;
	
require('../../Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("$boarddir/SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");
 
$comment_pic2=mysql_query("
SELECT *
FROM {$db_prefix}gallery_pic
ORDER BY puntos DESC LIMIT 25");
$context['comment-img2'] = array();
while ($row = mysql_fetch_assoc($comment_pic2))
{
$context['comment-img2'][] = array(
'title' => $row['title'],
'puntos' => $row['puntos'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic2);

echo'<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92" xml:lang="spanish">
	<channel>
	 <image>
    <url>'; echo $url; echo '/web/imagenes/rss.png</url>
    <title>Imágenes con más puntos</title>
    <link>'; echo $url; echo '</link>

    <width>111</width>
    <height>32</height>
    <description>25 imágenes con más puntos</description>
  </image>
	    <title>Imágenes con más puntos</title>
    <link>'; echo $url; echo '</link>
    <description>25 imágenes con más puntos</description>';
foreach($context['comment-img2'] AS $comment_img2){
echo '<item>
			<title><![CDATA['. $comment_img2['title'] .' - ('. $comment_img2['puntos'] .')]]></title>
			<link>'; echo $url; echo '/?action=imagenes;sa=ver;id='. $comment_img2['id'] .'</link>
	
		</item>';

		}

echo'	</channel>
</rss>
';  ?> 