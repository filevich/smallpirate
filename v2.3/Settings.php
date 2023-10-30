<?php
$maintenance = '0';
$mtitle = 'Mantenimiento';
$mmessage = 'Pagina en mantenimiento, aguarde un momento';
$limit_posts = '20'; //Cantidad de posts mostrados por pagina
$mbname = '';
$language = 'spanish';
$boardurl = '';
$url = '';
$chatid = '00000000';
$widget = '';
$slogan = '';
$no_avatar = '';
$webmaster_email = 'SPV3@spirate.net';
$cookiename = 'SPCookies';
$db_server = 'localhost';
$db_name = '';
$db_user = '';
$db_passwd = '';
$db_prefix = 'smf_'; //Don't changeeee!!!!!
$db_persist = '0';
$db_error_send = 1;
$boarddir = '';
$sourcedir = '';
$db_last_error = 0;
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
   $sourcedir = $boarddir . '/Sources';
$db_character_set = 'utf8';
?>