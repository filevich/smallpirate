<?php

function template_main()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt, $db_prefix;

//Si no eres admin no lo ves
//if ($context['user']['is_admin'])
//{
$context['page_title'] = $txt['extras_title'];

isAllowedTo('admin_forum');

if (isset($_POST['anuncio1']))
{
$anuncio1=$_POST['anuncio1'];
$anuncio2=$_POST['anuncio2'];
$anuncio3=$_POST['anuncio3'];
$anuncio4=$_POST['anuncio4'];
$anuncio5=$_POST['anuncio5'];
$enlaces=$_POST['enlaces'];

$sql2="UPDATE `smf_settings`
SET `smf_settings`.`value` = 
if(variable='anuncio1','$anuncio1', 
if(variable='anuncio2','$anuncio2',
if(variable='anuncio3','$anuncio3',
if(variable='anuncio4','$anuncio4',
if(variable='anuncio5','$anuncio5',
if(variable='enlaces','$enlaces' ,
`smf_settings`.`value`))))))";

$resultat2=mysql_query($sql2) or die (mysql_error());
mysql_free_result($sql2);
if ($resultat2) {
echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=javascript:history.go(-2)">', $txt['announcement_added'],'';
} else {
echo '<META HTTP-EQUIV="REFRESH" CONTENT="3;URL=javascript:history.go(-2)">', $txt['announcement_mistake'],'';
}
}

echo'<style type="text/css">
<!--
.Estilo1 {
	font-size: 16px;
	font-weight: bold;
}
.Estilo3 {font-size: 12px}
.Estilo4 {font-size: 14px}
.Estilo5 {font-size: 16px}
-->
</style>
<form name="form1" method="post" action="',$scripturl,'?action=extras;sa=gestionar">
  <p align="center" class="Estilo1">', $txt['add_extra'],' </p>
  <p align="left"><span class="Estilo1"><span class="Estilo4">', $txt['add_ads'],'</span><br>
    </span><span class="Estilo3">', $txt['ads_explanation'],' </span><span class="Estilo1"><br>
    <br>';

// Sacamos lo que hay actualmente y lo mostramos
$obtenir=mysql_query("
                SELECT *
                FROM {$db_prefix}settings
                WHERE variable LIKE 'anuncio%'
                ORDER BY variable ASC");
while ($row = mysql_fetch_assoc($obtenir)){
$anunci=$row['value'];
$nombre=$row['variable'];

if($nombre==anuncio1)
{
echo'</span><span class="Estilo5">', $txt['ads1'],'
     <br><textarea name="anuncio1" rows="6" cols="52">'. $anunci .'</textarea><br><br>';
} elseif ($nombre==anuncio2){
echo '', $txt['ads2'],'<br>
    <label><textarea name="anuncio2" rows="6" cols="52">'. $anunci .'</textarea></label><br><br>';
} elseif ($nombre==anuncio3){
echo '', $txt['ads3'],'<br>
    <label><textarea name="anuncio3" rows="6" cols="52">'. $anunci .'</textarea></label><br><br>';
} elseif ($nombre==anuncio4){
echo '', $txt['ads4'],'<br>
    <label><textarea name="anuncio4" rows="6" cols="52">'. $anunci.'</textarea></label><br><br>';
} elseif ($nombre==anuncio5){
echo '', $txt['ads5'],'</span><span class="Estilo1"><br>
    <label><textarea name="anuncio5" rows="6" cols="52">'. $anunci .'</textarea></label></span></p>
  <p><strong>', $txt['sitelinks'],'</strong></p><p>';
}
}
mysql_free_result($obtenir);
// Sacamos lo que hay actualmente y lo mostramos
$obtenir1=mysql_query("
                    SELECT *
                    FROM {$db_prefix}settings
                    WHERE variable='enlaces'");
while ($row1 = mysql_fetch_assoc($obtenir1)){
$enlace=$row1['value'];
echo'<label>
    <textarea name="enlaces" rows="6" cols="52">'. $enlace .'</textarea></label><br>
    <br>
    <label>
    <input type="submit" name="Submit" value="', $txt['save_ads'],'"></label></p>
</form>';
}
mysql_free_result($obtenir1);
//} else {
//echo'', $txt['error_for_idiots_like_you'],'';
//}
}

?>