<?php
require('Settings.php');

global $db_prefix, $boardurl;

$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");
 
echo'<html><head><title>Emoticones</title></head><body onload="javascript:resizeTo(225,500)"><span class="size12"><table width="190"><tbody><tr align="center">
	    <td width="40"><strong>Emotic&oacute;n:</strong></td>
	    <td width="80"><strong>C&oacute;digo:</strong></td>
	  </tr>
	  
';
$existe=mysql_query("
                SELECT *
                FROM {$db_prefix}smileys
                WHERE hidden=2
                ORDER BY ID_SMILEY ASC");

while ($row = mysql_fetch_assoc($existe))
{

	echo'<tr align="center">
	    <td><img style="border: medium none;" src="'. $boardurl .'/Smileys/default/'.$row['filename'].'"></td>
	    <td>'.$row['code'].'</td>
	  </tr>';
}
mysql_free_result($existe);

echo'</tbody></table></span></body></html>';
 ?> 