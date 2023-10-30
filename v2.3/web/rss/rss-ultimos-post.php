<?php
require('../../Settings.php');

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
require("$boarddir/SSI.php");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

$id = $_GET['id'];
 
$existe=mysql_query("
SELECT m.ID_TOPIC, m.ID_MEMBER, m.subject, m.body, m.hiddenOption
FROM (smf_messages AS m)
ORDER BY m.ID_TOPIC DESC LIMIT 25");
$context['rssuser'] = array();
while ($row = mysql_fetch_assoc($existe))
{$row['body'] = parse_bbc($row['body'], 1, $row['ID_MSG']); 
$row['body'] = strtr($func['substr'](str_replace('<br />', "\n", $row['body']), 0, 400 - 3), array("\n" => '<br />')) . '...';	
censorText($row['body']);
censorText($row['subject']);
$context['rssuser'][] = array(
'id' => $row['ID_TOPIC'],
'titulo' => $row['subject'],
'body' => $row['body'],
'postprivado' => $row['hiddenOption'],);}
mysql_free_result($existe);
	

echo'<?xml version="1.0" encoding="UTF-8"?>
<rss version="0.92" xml:lang="spanish">
	<channel>
	 <image>
    <url>'; echo $url; echo '/web/imagenes/rss.png</url>
    <title> Ultimos Post</title>
    <link>'; echo $url; echo '</link>

    <width>111</width>
    <height>32</height>
    <description>Ultimos 25 post</description>
  </image>
	    <title>Ultimos Posts</title>
    <link>'; echo $url; echo '</link>
    <description>Ultimos 25 posts</description>';
foreach($context['rssuser'] AS $rssuser){

echo '<item>
			<title><![CDATA['. $rssuser['titulo'] .']]></title>
			<link>'; echo $url; echo '/?topic='. $rssuser['id'] .'</link>
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
';  ?> 