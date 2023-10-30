<?php
require('Settings.php');

function pais($valor)
{
			
$valor = str_replace("ar", "Argentina", $valor);
$valor = str_replace("bo", "Bolivia", $valor);
$valor = str_replace("br", "Brasil", $valor);
$valor = str_replace("cl", "Chile", $valor);
$valor = str_replace("co", "Colombia", $valor);
$valor = str_replace("cr", "Costa Rica", $valor);
$valor = str_replace("cu", "Cuba", $valor);
$valor = str_replace("ec", "Ecuador", $valor);
$valor = str_replace("es", "Espa&ntilde;a", $valor);
$valor = str_replace("gt", "Guatemala", $valor);
$valor = str_replace("it", "Italia", $valor);
$valor = str_replace("mx", "Mexico", $valor);
$valor = str_replace("py", "Paraguay", $valor);
$valor = str_replace("pe", "Peru", $valor);
$valor = str_replace("pt", "Portugal", $valor);
$valor = str_replace("pr", "Puerto Rico", $valor);
$valor = str_replace("uy", "Uruguay", $valor);
$valor = str_replace("ve", "Venezuela", $valor);
$valor = str_replace("ot", "", $valor);

return $valor;
}
function sexo1($valor)
{					
$valor = str_replace("1", "Masculino", $valor);
$valor = str_replace("2", "Femenino", $valor);
return $valor;
}
function sexo2($valor)
{
global	$url;		
$valor = str_replace("1", "Male", $valor);
$valor = str_replace("2", "Female", $valor);
return $valor;

}

    global $db_prefix, $scripturl, $txt, $context, $ID_MEMBER, $modSettings, $boarddir,$boardurl, $url;



$conexion = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");

mysql_select_db($db_name, $conexion) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

require("SSI.php");

$contenido=htmlentities($_POST['message'],ENT_QUOTES,"UTF-8");

$prueba=$_GET['prueba'];

$contenido = parse_bbc($contenido); 

$iduser = $context['user']['id'];

echo'<table style="width: 100%;"><tr style="width: 100%;"><td style="width: 100%;">';

echo'<div>

<div class="box_140" style="float:left; margin-right:8px;">

<div class="box_title" style="width: 140px;"><div class="box_txt box_140-34">Publicado por:</div>

<div class="box_rss"><img  src="'. $url .'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="smalltext windowbg" border="0" style="width: 130px; padding: 4px;">

<center>';



$userse = mysql_query("

SELECT *

FROM {$db_prefix}members as mem

WHERE mem.ID_MEMBER=$iduser");

while($row = mysql_fetch_assoc($userse))

{

	$context['memberName']=$row['memberName'];

	$context['avatar']=$row['avatar'];

	$context['personalText']=$row['personalText'];	

	$context['ID_POST_GROUP']=$row['ID_POST_GROUP'];

	$context['ID_GROUP']=$row['ID_GROUP'];

	$context['realName']=$row['realName'];

	$context['usertitle']=$row['usertitle'];

	$context['gender']=$row['gender'];

	$context['topics']=$row['topics'];

	$context['money']=$row['money'];

	$context['ID_MEMBER']=$row['ID_MEMBER'];

	}

$idgrup=$context['ID_POST_GROUP'];

$idgrup2=$context['ID_GROUP'];

$userse2 = mysql_query("

SELECT *

FROM {$db_prefix}membergroups as g

WHERE g.ID_GROUP=$idgrup");

while($row2 = mysql_fetch_assoc($userse2))

{$membergropu=$row2['groupName'];}

$userse3 = mysql_query("

SELECT *

FROM {$db_prefix}membergroups as g

WHERE g.ID_GROUP=$idgrup2");

while($row2 = mysql_fetch_assoc($userse3))

{$membergropu2=$row2['groupName'];}



$medallasa = mysql_query("

SELECT *

FROM {$db_prefix}membergroups as g

WHERE g.ID_GROUP=".(!empty($idgrup2) ? $idgrup2 : $idgrup)."");

while($rows = mysql_fetch_assoc($medallasa))

{$medalla=$rows['stars'];}

			if ($modSettings['avatar_action_too_large'] == 'option_html_resize' || $modSettings['avatar_action_too_large'] == 'option_js_resize')

			{

				if (!empty($modSettings['avatar_max_width_external']))

					$context['user']['avatar']['width'] = $modSettings['avatar_max_width_external'];

				if (!empty($modSettings['avatar_max_height_external']))

		 			$context['user']['avatar']['height'] = $modSettings['avatar_max_height_external'];

			}

	

		if (!empty($context['avatar']))

		$context['user']['avatar']['image'] = '<img src="'.$context['avatar'].'"' . (isset($context['user']['avatar']['width']) ? ' width="' . $context['user']['avatar']['width'] . '"' : '') . (isset($context['user']['avatar']['height']) ? ' height="' . $context['user']['avatar']['height'] . '"' : '') . ' alt="" class="avatar" border="0" />';





if ($context['avatar']){

echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="'. $scripturl .'?action=profile;u=', $context['ID_MEMBER'], '" title="Ver Perfil">'.$context['user']['avatar']['image'].'</a>';

}

else

echo '<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center"><a href="'. $scripturl .'?action=profile;u=', $context['ID_MEMBER'], '" title="Ver Perfil"><img src="'. $url .'/Themes/default/images/avatar.gif" border="0" alt="Sin Avatar" /></a>';



	echo' <b><a href="'. $scripturl .'?action=profile;u=', $context['ID_MEMBER'], '"><font face="verdana" size="2">', $context['realName'], '</font></a></b><br />';

				



		

			

     	

		
			
            echo'<div class="fondoavatar" style="overflow: auto; width: 130px;" align="center">';	










				

	echo '</div></div></div></div>

	

<div class="box_780" style="float:left;">

<div class="box_title" style="width: 780px;"><div class="box_txt box_780-34"><center>Vista Previa</center></div>

<div class="box_rss"><img  src="'. $url .'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" border="0" style="width: 770px; padding: 4px;word-wrap: break-word;" id="vista_previa">'.censorText($contenido).''.$prueba.'</div><div align="right"><br><input onclick="cerrar_vprevia()" class="button" value="Cerrar la previsualizaci&oacute;n" title="Cerrar la previsualizaci&oacute;n" type="button"> <input onclick="return oblig(this.form.subject.value, this.form.message.value, this.form.tags.value, this.form);" class="button" value="Postear" title="Postear" type="submit"></div></div></div>



</td></tr></table>';



?>