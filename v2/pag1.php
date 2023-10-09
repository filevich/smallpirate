<?php
require('Settings.php');


$con = mysql_connect($db_server, $db_user, $db_passwd) OR die("No se puedo conectar a la BDD ".mysql_error()."...!!!");
mysql_select_db($db_name, $con) OR die("No se pudo seleccionar la BDD ".mysql_error()."...!!!");

 $RegistrosAMostrar=20;
 if(isset($_GET['pag'])){
  $RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
  $PagAct=$_GET['pag'];
 }else{
  $RegistrosAEmpezar=0;
  $PagAct=1;
 }
$id=$_GET['id'];
$db_prefix = 'smf_';

echo'<div class="box_posts">';

if(!$id == ''){

$whe="where `smf_messages`.`ID_BOARD`=".$id;
}
$request = mysql_query("
SELECT `smf_messages`.`ID_TOPIC`,`smf_messages`.`ID_BOARD`,`smf_messages`.`hiddenOption`,`smf_messages`.`subject`,`smf_boards`.`name`,`smf_topics`.`isSticky` as sitiy FROM smf_messages 
left join 
(`smf_boards`,`smf_topics`) 
on 
`smf_messages`.`ID_TOPIC`=`smf_topics`.`ID_TOPIC` and
`smf_boards`.`ID_BOARD`=`smf_messages`.`ID_BOARD`
 $whe 
group by `smf_messages`.`ID_TOPIC`
ORDER by `smf_topics`.`isSticky` desc , `smf_messages`.`ID_MSG` desc
LIMIT $RegistrosAEmpezar, $RegistrosAMostrar",$con);

//aqui pregunto si esta activo url amigable en la base de datos
$verifica = mysql_query("
SELECT value 
FROM smf_settings
WHERE variable= 'queryless_urls' ",$con);
$row_Recordset = mysql_fetch_assoc($verifica);
$urlamigable = mysql_num_rows($verifica);

if ($row_Recordset['value'] == 1){
include('includes/urls_amigables.php');
while($Stick1=mysql_fetch_array($request)){
echo '<table width="100%"><tr><td width="100%"><div class="box_icono4"><img title="'.$Stick1['name'].'" src="'; echo $url; echo '/Themes/default/images/post/icono_'.$Stick1['ID_BOARD'].'.gif" ></div>';
if ($context['user']['is_guest']){if ($Stick1['hiddenOption']){echo'<img title="Post privado" src="'; echo $url; echo '/Themes/default/images/icons/icono-post-privado.gif">';} 
else echo'';}
IF($Stick1['sitiy']){
echo'<img title="Sticky" src="'; echo $url; echo '/Themes/default/images/icons/show_sticky.gif" width="10" height="10">';
}
ECHO '&nbsp;<span title="' .$Stick1['subject'] . '"><a href="'; echo $url; echo '/post/',urls_amigables($Stick1['name']),'/',$Stick1['ID_TOPIC'],'/',urls_amigables($Stick1['subject']) ,'.html" >' . $Stick1['subject'] . '</a></span></td></tr></table>';
}}
else { //aqui sin url amigable
while($Stick1=mysql_fetch_array($request)){
echo '<table width="100%"><tr><td width="100%"><div class="box_icono4"><img title="'.$Stick1['name'].'" src="'; echo $url; echo '/Themes/default/images/post/icono_'.$Stick1['ID_BOARD'].'.gif" ></div>';
if ($context['user']['is_guest']){if ($Stick1['hiddenOption']){echo'<img title="Post privado" src="'; echo $url; echo '/Themes/default/images/icons/icono-post-privado.gif">';} 
else echo'';}
IF($Stick1['sitiy']){
echo'<img title="Sticky" src="'; echo $url; echo '/Themes/default/images/icons/show_sticky.gif" width="10" height="10">';
}
ECHO '&nbsp;<span title="' .$Stick1['subject'] . '"><a href="'; echo $url; echo '?topic=',$Stick1['ID_TOPIC'], '" >' . $Stick1['subject'] . '</a></span></td></tr></table>'; }
}


//******--------determinar las páginas---------******//
 if($id == ''){
 $NroRegistros=mysql_num_rows(mysql_query("SELECT * FROM smf_messages",$con));}
 else
 {$NroRegistros=mysql_num_rows(mysql_query("SELECT * FROM smf_messages WHERE ID_BOARD = $id",$con));}


 $PagAnt=$PagAct-1;
 $PagSig=$PagAct+1;
 $PagUlt=$NroRegistros/$RegistrosAMostrar;
 $Res=$NroRegistros%$RegistrosAMostrar;
 // si hay residuo usamos funcion floor para que me
 // devuelva la parte entera, SIN REDONDEAR, y le sumamos
 // una unidad para obtener la ultima pagina
 if($Res>0) $PagUlt=floor($PagUlt)+1;
echo'</div><div class="box_posts"><center><font color="grey" size="2">';
if($id == ''){
 if($PagAct>1) echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."/?pag=$PagAnt'>< anterior</a>";
 if($PagAct>1) echo " || ";
 if($PagAct<$PagUlt)  echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."/?pag=$PagSig'>siguiente ></a>";
}else
{
 if($PagAct>1) echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."/?pag=$PagAnt&id=$id)'>< anterior</a>";
 if($PagAct>1) echo " || ";
 if($PagAct<$PagUlt)  echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."/?pag=$PagSig&id=$id)'>siguiente ></a>";
}
echo'</font></center></div>';
?>