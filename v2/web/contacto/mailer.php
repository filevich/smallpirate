<?php
// Contact System Creado por Phobos91
require('../../Settings.php');
// obtener las variables
$asunto = $_REQUEST["asunto"];
$mensaje = $_REQUEST["mensaje"];
$from = $_REQUEST["from"];
$verif_box = $_REQUEST["verif_box"];

$mensaje = stripslashes($mensaje); 
$asunto = stripslashes($asunto); 
$from = stripslashes($from); 

// Comprobar si el código de verificación era o no correcto
if(md5($verif_box).'a4xn' == $_COOKIE['tntcon']){
	mail("". $webmaster_email ."", 'Asunto: '.$asunto, $_SERVER['REMOTE_ADDR']."\n\n".$mensaje, "From: $from");
	setcookie('tntcon','');
} else {
	// mostrar error en caso de error
	header("Location:".$_SERVER['HTTP_REFERER']."?asunto=$asunto&from=$from&mensaje=$mensaje&wrong_code=true");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>E-Mail Enviado</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body><center>
Email enviado. Gracias.<br />
<br />
¿Volver al <a href="/">índice</a>? 
</center></body>
</html>
