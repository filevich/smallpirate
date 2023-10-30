<?php


switch($_REQUEST['ajax'])
{
    case 'comprobar_usuario': 
        comprobar_usuario();
        break;
    case 'comprobar_email':
        comprobar_email();
        break;
}


function comprobar_usuario()
{
	include("../Settings.php");

    global $boardurl;

    $conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("Mmm..algo no anda bien.");
    mysql_select_db($db_name, $conexion) OR die("Mmm..no puedo seleccionar lo que pedis.");

    $username = $_REQUEST['username'];

if(!empty($username))
{
$result = mysql_query("
                    SELECT memberName
                    FROM {$db_prefix}members
                    WHERE memberName = '" . $_REQUEST['username'] . "'");
$total = mysql_num_rows($result);
if($total>0)
{
echo '<span style="font-size: 8pt; font-family:arial; color:#000000; background: #F7ABA1;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Nick en uso &raquo;</font></span>';
}
else
{
echo '<span style="font-size: 8pt; height:19px; font-family:arial; color:#000000; background: #B2DBA8;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Nick disponible &raquo;</font></span>';
}
}
else
{
echo '<span style="font-size: 8pt; font-family:arial; color:#000000; background: #F7ABA1;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Debes ingresar el nick &raquo;</font></span>';
}
}




function comprobar_email()
{
    include("../Settings.php");

    global $boardurl;

    $email = $_REQUEST['email'];
    $valid = false;

    // Tests for a valid email address and optionally tests for valid MX records, too.
    if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email))
    {
        list($username, $domain) = explode("@", $email);
        $valid = getmxrr($domain, $mxrecords);
    }
	
if(empty($email))
{
        echo '<span style="font-size: 8pt; font-family:arial; color:#000000; background: #F7ABA1;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Agrega el email &raquo;</font></span>';
}

   else if ($valid == false)
    {
        // Email incorrecto
        echo '<span style="font-size: 8pt; font-family:arial; color:#000000; background: #F7ABA1;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Email incorrecto &raquo;</font></span>';
    }
    else
    {
        // Email correcto
        echo '<span style="font-size: 8pt; height:19px; font-family:arial; color:#000000; background: #B2DBA8;padding-top:6px;padding-bottom:3px;padding-right:20px;padding-left:5px;margin-left:4px;">Email correcto &raquo;</font></span>';
    }
}

?>