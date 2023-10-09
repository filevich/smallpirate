<?php

function formatMoney($money)
{
	global $modSettings;
	$money = (float) $money;
	return $modSettings['shopCurrencyPrefix'] . $money;
}

function template_main()
{
global $context, $settings, $options, $txt, $scripturl;
$contar6=1;
$id_cat= $_GET['id'];
echo'<div style="float:left;">
<div class="ultimos_postsa">
<div class="box_title" style="width: 380px;"><div class="box_txt ultimos_posts">&Uacute;ltimos posts</div>
<div class="box_rss"><div class="icon_img"><a href="/web/rss/rss-ultimos-post.php"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div>
</div>
<!-- empiezan los post -->
<div id="contenido">';
if($context['user']['is_guest']){
include('pag1-guest.php');}
else
include('pag1.php');
echo'</div>';
echo'</div><div style="float:left;">
<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">Buscador</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
          	<div class="box_buscar">
<form style="margin: 0px; padding: 0px;" action="/?action=search2" method="post" accept-charset="', $context['character_set'], '"><center>
	<input type="text" name="search" size="30" class="ibuscador">&nbsp;<input onclick="this.form.submit()" src="/Themes/default/images/btn-buscar.gif" alt="Buscar" class="bbuscador" title="Buscar" type="image" vspace="2" align="top" hspace="10">
</center></form></div></div>
	<div>
<div class="act_comments">
<div class="box_title"  style="width: 363px;"><div class="box_txt ultimos_comments">TOPs Tags (<a href="?action=tags">Nube de Tags</a>)</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_buscar"><center>';


$arreglo=array($context['poptags']);
usort($arreglo,"strnatcasecmp");
for($x=0;$x<count($arreglo);$x++)
echo $arreglo[$x]."<br>";

echo'</b></a></center></div></div></div>';

echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">&Uacute;ltimos comentarios</div>
<div class="box_rss"><div class="icon_img"><img id="last_comments_reload" onclick="actualizar_comentarios(-1,0); return false;" src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -372px; display: inline;"></a></div></div></div>
<div class="box_icono" id="last_comments" style="width: 353px; padding: 4px 4px 4px 4px;">'; 
mensajes();
echo'</div></div>';
$request = db_query("
SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.puntos
FROM (smf_topics AS t, smf_messages AS m)
WHERE t.ID_TOPIC = m.ID_TOPIC
ORDER BY t.puntos DESC
LIMIT 10 ", __FILE__, __LINE__);
	$context['postporpuntos'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['postporpuntos'][] = array(
			'titulo' => $row['subject'],
			'puntos' => $row['puntos'],
			'id' => $row['ID_TOPIC'],
			);
	mysql_free_result($request);
//destacados... (publicidad)
echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">Posts con m&aacute;s puntos</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div   align="left" class="windowbg" style="width: 353px; padding:4px;margin-bottom:8px;font-size:11px;">';
foreach ($context['postporpuntos'] as $ppp){

$tamano = 50; // tamaño máximo en carácteres, los espacios también cuentan
$contador = 0;
 
$arrayTexto = split(' ',$ppp['titulo']);
$ppp['titulo'] = '';
 while($tamano >= strlen($ppp['titulo']) + strlen($arrayTexto[$contador])){
    $ppp['titulo'] .= ' '.$arrayTexto[$contador];
    $contador++;
}

echo '<b class="size11">'.$contar6++.'- </b><a title="', $ppp['titulo'], '" href="?topic=', $ppp['id'], '">', $ppp['titulo'], '</a> (', $ppp['puntos'], ' pts)<br>
';}
echo'</div></div>';


echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">Publicidad</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div></div>
<div class="box_icono" id="last_comments" style="width: 353px; padding: 4px 4px 4px 4px;">'; ssi_destacado(); echo'</div></div>';

echo'</div><div style="float:left;">

<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">Im&aacute;genes al azar</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_icono2"><br>';
foreach ($context['imgaletatoria'] as $imgalet){
echo '<div class="photo_small1"><a href="?action=imagenes;sa=ver;id=', $imgalet['id'], '"><img  border="0" style="width: 140px;" src="', $imgalet['filename'], '"></a></div><div align="center" class="smalltext">Comentarios (<a href="?action=imagenes;sa=ver;id=', $imgalet['id'], '#comentarios">', $imgalet['commenttotal'],'</a>)</div>';}
echo'<br></div></div>

<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">User con m&aacute;s puntos</div>
<div class="box_rss"><div class="icon_img"><a href="/?type=rss;action=.xml;sa=puntos"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div>
<div class="box_icono2">';
foreach ($context['shop_richest'] as $row)
echo '<center><font size="1"><a title="', $row['realName'], '" href="?action=profile;user=', $row['memberName'], '">', $row['realName'], '</a> (', formatMoney($row['money']), ')</font></center>';
echo'</div></div>
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">User de la semana</div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="box_icono2">';
foreach ($context['top_posters_week'] as $poster)
echo '<center><font size="1">', $poster['link'], ' (', $poster['num_posts'], ')</font></center>';
echo'</div></div>

<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">User con m&aacute;s post</div>
<div class="box_rss"><div class="icon_img"><a href="/?type=rss;action=.xml;sa=posteadores"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="box_icono2">';
foreach ($context['top_starters'] as $poster)
echo'<center><font size="1">', $poster['link'], ' (', $poster['num_topics'], ')</font></center>';

echo'</div></div>
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">Nuevos users</div>
<div class="box_rss"><div class="icon_img"><a href="/?type=rss;action=.xml;sa=usuarios"><img src="/Themes/default/images/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="box_icono2">';
foreach ($context['yeniuyeler'] as $poster)
{echo '<center><font size="1">',$poster['link'], '</font></center>';}
echo'</div></div>
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">Enlaces</div>
<div class="box_rss"><img src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="box_icono2">';
ssi_enlaces();
$request = db_query("
SELECT *
FROM cw_comentarios ", __FILE__, __LINE__);
$context['cantidadcoment'] = mysql_num_rows($request);
echo'</div></div>
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">Estad&iacute;sticas</div>
<div class="box_rss"><img src="/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="box_icono2">
<font size="1"><center>
', $context['num_guests'] + $context['num_users_online'], ' personas conectadas<br>
', $context['common_stats']['total_topics'], ' posts<br>
', $context['cantidadcoment'], ' comentarios<br>
', $context['common_stats']['total_topics']+$context['cantidadcoment'], ' mensajes<br>
', $context['common_stats']['total_members'], ' miembros<br>
', $context['common_stats']['latest_member']['link'], ' &uacute;ltimo usuario</center></font>
          </div>
        </div>
		</div>';


	
}

function mensajes()
{
	global $context, $settings, $scripturl, $txt, $db_prefix, $ID_MEMBER;
	global $user_info, $modSettings, $func;
	$rs = db_query("SELECT c.id_post, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName
FROM (cw_comentarios AS c, smf_messages AS m, smf_members AS mem)
WHERE id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER
ORDER BY c.id_coment DESC
LIMIT 25", __FILE__, __LINE__);
	$context['comentarios25'] = array();
	while ($row = mysql_fetch_assoc($rs))
	$context['comentarios25'][] = array(
			'id_coment' => $row['id_coment'],
			'titulo' => $row['subject'],
			'ID_TOPIC' => $row['ID_TOPIC'],
			'memberName' => $row['memberName'],
			'RealName' => $row['RealName'],
		);
	mysql_free_result($rs);
	foreach ($context['comentarios25'] as $coment25){
	echo '<font class="size11" title="'. $coment25['titulo'] .'"><b><a href="?action=profile;user='. $coment25['memberName'] .'">'. $coment25['RealName'] .'</a></b> - <a href="?topic='. $coment25['ID_TOPIC'] .'#cmt_'. $coment25['id_coment'] .'">'. $coment25['titulo'] .'</a></font><br>';
	}
}

?>