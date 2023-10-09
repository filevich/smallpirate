<?php
$maintenance = 0; // TODO ESTO LO HACE EL INSTALADOR, USALO PARA QUE ESTE CORRECTO
$mtitle = 'Mantenimiento';
$mmessage = 'Pagina en mantenimiento,  INTENTAR LUEGO';
$mbname = 'Yelid MoD';
$language = 'english'; // Como lo toques te capo
$boardurl = 'http://localhost';
$url = 'http://localhost'; // PON LA DIRECCIÓN DE TU WEB SIN / FINAL
$chatid = '43220954'; // ID de tu chat de xat.com
$widget = ''; // Lo que saldrá en el título del widget
$slogan = ''; // lo que saldrá en el título de tu web, no pongas el nombre
$no_avatar = 'http://localhost/avatar.gif';
$webmaster_email = '';
$cookiename = 'nose';
$db_server = 'localhost';
$db_name = '';
$db_user = '';
$db_passwd = '';
$db_prefix = 'smf_'; // Tampoco te recomiendo tocarlo
$db_persist = 0;
$db_error_send = 0;
$boarddir = '/'; // si no sabes la tuya usa el archivo del generar.rar
$sourcedir = '/Sources/'; // Simplemente añade /Sources/ 
$db_last_error = 1227763486;
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
   $sourcedir = $boarddir . '/Sources';
$db_character_set = 'utf8';
?>