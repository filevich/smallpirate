<?php
require('../../Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("$boarddir/SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

$id = $_GET['id'];
 
$comentpost=mysql_query("
SELECT m.ID_TOPIC, m.ID_MEMBER, m.subject, m.hiddenOption, c.id_user, c.id_post, c.id_coment, c.comentario
FROM (smf_messages AS m, cw_comentarios AS c)
WHERE c.id_post 	=$id
ORDER BY c.id_coment DESC");
$context['rssuser'] = array();
while ($row = mysql_fetch_assoc($comentpost))
{
censorText($row['comentario']);
censorText($row['subject']);	
$row['comentario'] = parse_bbc($row['comentario'], 1, $row['ID_MSG']); 
$row['comentario'] = strtr($func['substr'](str_replace('<br />', "\n", $row['comentario']), 0, 400 - 3), array("\n" => '<br />')) . '...';	
$context['rssuser'][] = array(
'id' => $row['id_coment'],
'body' => $row['comentario'],

'postprivado' => $row['hiddenOption'],

);
$titulo = $row['subject'];
}
mysql_free_result($comentpost);



echo'<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92" xml:lang="spanish">
	<channel>
	 <image>
    <url>'; echo $url; echo '/web/imagenes/rss.png</url>
    <title>Comentarios para el post: '.$titulo. '</title>
    <link>'; echo $url; echo '</link>

    <width>111</width>
    <height>32</height>
    <description>Comentarios para el post '.$titulo. '</description>
  </image>
	    <title>Comentarios para el post: '.$titulo. '</title>
    <link>'; echo $url; echo '</link>
    <description>Comentarios para el post '.$titulo. '</description>';
foreach($context['rssuser'] AS $rssuser){

echo '<item>
			<title><![CDATA[Comentario de ]]></title>
			<link>'; echo $url; echo '/post/'. $rssuser['id'] .'</link>
			<description><![CDATA[';
if($context['user']['is_guest']){
if($rssuser['postprivado']=='1')
echo'<center><i>Este es un post privado, para verlo debes autentificarte.</i></center><br>';
if($rssuser['postprivado']=='0')
echo''. $rssuser['body'] .'';}

if($context['user']['is_logged']){
echo''. $rssuser['body'] .'';}
 
 echo']]>
			</description>
			<comments>'; echo $url; echo '/post/'. $rssuser['id'] .'#quickreply</comments>
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