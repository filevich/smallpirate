<?php

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;
	global $query_this_board, $func;
	
require('../../Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("$boarddir/SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

$id = $_GET['id'];

$comment_pic=mysql_query("
SELECT *
FROM ({$db_prefix}gallery_comment AS c, {$db_prefix}gallery_pic AS img, {$db_prefix}members AS mem)
WHERE c.ID_PICTURE=$id AND c.ID_PICTURE=img.ID_PICTURE AND c.ID_MEMBER=mem.ID_MEMBER
ORDER BY c.ID_COMMENT ASC LIMIT 25");
$context['comment-img'] = array();
while ($row = mysql_fetch_assoc($comment_pic))
{

$row['comment'] = parse_bbc($row['comment'], 1, $row['ID_MSG']); 
censorText($row['comment']);
$row['comment'] = strtr($func['substr'](str_replace('<br />', "\n", $row['comment']), 0, 400 - 3), array("\n" => '<br />')) . '...';
$titulo=$row['title'];
$context['comment-img'][] = array(
'comentario' => $row['comment'],
'nom-user' => $row['realName'],
'id_comment' => $row['ID_COMMENT'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic);

$contando=1;
echo'<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92" xml:lang="spanish">
	<channel>
	 <image>
    <url>'; echo $url; echo '/web/imagenes/rss.png</url>
    <title>Comentarios para la imagen: '.$titulo. '</title>
    <link>'; echo $url; echo '</link>

    <width>111</width>
    <height>32</height>
    <description>Comentarios para la imagen '.$titulo. '</description>
  </image>
	    <title>Comentarios para la imagen: '.$titulo. '</title>
    <link>'; echo $url; echo '</link>
    <description>Comentarios para la imagen '.$titulo. '</description>';
foreach($context['comment-img'] AS $comment_img){

echo '<item>
			<title><![CDATA[#'.$contando++.' Comentario de '. $comment_img['nom-user'] .']]></title>
			<link>'; echo $url; echo '/?action=imagenes;sa=ver;id='. $comment_img['id'] .'#cmt_'. $comment_img['id_comment'] .'</link>
			<description><![CDATA['. $comment_img['comentario'] .']]>
			</description>
			<comments>'; echo $url; echo '/?action=imagenes;sa=ver;id='. $comment_img['id'] .'#comentar</comments>
		</item>';

		}

echo'	</channel>
</rss>
'; 

//// Con esta funcion limpiamos caracteres especiales de las variables....

function clear_chars($var){
		if(!is_array($var)){
			return htmlspecialchars($var);
				}
		else{
			$new_var = array();
			foreach ($var as $k => $v){
				$new_var[htmlspecialchars($k)]=clear_chars($v);
				return $new_var;
			}
		}
	}
	if($_POST) $_POST=clear_chars($_POST);
	if($_GET) $_GET=clear_chars($_GET);
	if($_REQUEST) $_REQUEST=clear_chars($_REQUEST);
	if($_SERVER) $_SERVER=clear_chars($_SERVER);
	if($_COOKIE) $_COOKIE=clear_chars($_COOKIE);
	
//// Fin de funcion	clear...

 ?> 