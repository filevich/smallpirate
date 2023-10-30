<?php
include ('Settings.php');

$con = mysql_connect($db_server, $db_user, $db_passwd);
mysql_select_db($db_name, $con);


$ancho = (int) $_GET['an'] - 17;
$cat = (int) $_GET['cat'];
$cant = (int) $_GET['cant'];
$color = $_GET['color'];
$imagen = $_GET['color'];


if($color == 'rojo')
$color = '#FF7777';
elseif($color == 'rosa')
$color = '#DD999A';
elseif($color == 'gris')
$color = '#BBBBBB';
elseif($color == 'amarillo')
$color = '#FEFE78';
elseif($color == 'turquesa')
$color = '#78F9FF';
elseif($color == 'verde')
$color = '#78FF75';
elseif($color == 'violeta')
$color = '#8C78FE';
elseif($color == 'negro')
$color = '#3B3B23';
else
$color = '#FF7777';

	if($cant > 50)
	$cant = 50;
	elseif($cant < 5)
	$cant = 5;
	else
	$cant = 20;

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1;" />
<title>',$widget,'</title>
<style type="text/css">
body
{
    font-family: Arial,Helvetica,sans-serif;
    font-size:12px;
    margin: 0px;
    padding:0px;
    background: ',$color,' url(',$boardurl,'/Themes/default/images/widget/bg_widget-'.$imagen.'.gif) repeat-x;
}
a{color: #000; text-decoration:none}
a:hover{color:#000000;}
*:focus{outline:0px;}
.nsfw{color: #FFbbBB}
.item
{
    width:'.$ancho.'px;
    overflow:hidden;
    height:16px;
    margin: 2px 0px 0px 0px;
    padding:0px;
    border-bottom: 1px solid #F4F4F4;
}
.exterior{width:'.$ancho.'px;}
</style>
</head>
<body>
<div class="exterior">';
	
$request = mysql_query("
            SELECT m.subject, m.ID_MSG, t.ID_TOPIC, t.ID_BOARD, b.name AS bname, m.ID_MEMBER
            FROM ({$db_prefix}messages AS m, {$db_prefix}boards AS b, {$db_prefix}topics AS t)
            WHERE b.ID_BOARD = " . (empty($cat) ? 't.ID_BOARD' : "$cat
            AND t.ID_BOARD = $cat") . "
            AND m.ID_MSG = t.ID_FIRST_MSG
            ORDER BY t.ID_FIRST_MSG DESC
            LIMIT $cant");
		
while($row = mysql_fetch_array($request))
{
    echo '<div class="item"><div class="icon_img" style="float:left;margin:0px 5px 0px 0px;width:17px;height:17px">
    <img alt="" title="'.$row['bname'].'" src="', $boardurl, '/Themes/default/images/post/icono_'.$row['ID_BOARD'].'.gif" style="margin-top:-0px;" /></div>
    <a target="_blank" title="'.$row['subject'].'" href="'.$boardurl.'/?topic='.$row['ID_TOPIC'].'">'.$row['subject'].'</a></div>'.'';
}
		
echo '<center>
<a href="'.$boardurl.'" target="_parent">[ Ver m&aacute;s posts ]</a>
</center>
</body>
</html>';

mysql_free_result($request);
?>