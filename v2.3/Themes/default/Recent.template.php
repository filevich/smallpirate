<?php
// Version: 1.1.9 Recent

function formatMoney($money)
{
	global $modSettings;
	$money = (float) $money;
	return $modSettings['shopCurrencyPrefix'] . $money;
}

function template_main()
{
    global $context, $settings, $options, $txt, $scripturl, $limit_posts, $db_prefix;
    global $PagAnt, $PagAct, $PagSig, $PagUlt, $id;

$contar6= 1;
$id_cat= $_GET['id'];
echo'<div style="float:left; padding-left:6px;">
<div class="ultimos_postsa">
<div class="box_title" style="width: 380px;"><div class="box_txt ultimos_posts">', $txt['lasts_topics'], ' <img src="',$settings['images_url'],'/icons/new.png"></div>
<div class="box_rss"><div class="icon_img"><a href="web/rss/rss-ultimos-post.php"><img src="',$settings['images_url'],'/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div>
</div>
<!-- inicio posts -->
<div id="contenido">';


//listado de Posts
echo '<div class="box_posts">';

//Muestro los stickies
foreach($context['sticky'] as $st)
{
    echo'<table width="100%"><tr><td width="100%" bgcolor="#FDFFC4" style="border-bottom:0px solid #FDF2AB;"><div class="entry_item_sticky">';
    echo'<div class="icon"><img title="'.$st['category'].'" src="'. $settings['images_url'] .'/post/icono_'.$st['id_category'].'.gif"></div>';
    echo'<div class="text_container"><div class="title">';
	echo'<div class="icon_img" style="float: left; margin-left:0px; margin-right:3px;"><img title="Sticky" src="'. $settings['images_url'] .'/icons/sticky.png" style="margin-top:0px; display: inline;"></div>';
    if($st['private'] == '1' && $context['user']['is_guest'])
        echo'<div class="icon_img" style="float: left; margin-left:0px; margin-right:3px;"><img title="Post privado" src="', $settings['images_url'] ,'/icons/hidden.gif" style="margin-top: -578px; display: inline;"></div>';

    echo'<span title="', censorText($st['title']), '"><a href="', $scripturl ,'?topic=', $st['id'],'">',censorText($st['title']), '</a></span></div>';

    echo'<script type="text/javascript">more_',$st['id'], '=false</script><div style="margin: 0pt; float: left;" class="icon_img"><img id="info_icon_',$st['id'], '" src="', $settings['images_url'] ,'/icons/exp.gif" style="width: 16px; margin-top: -0px; cursor: pointer;" alt="" onclick="if (!more_',$st['id'], '){more_',$st['id'], '=true;this.style.marginTop=\'-16px\';$(\'#data_',$st['id'], '\').show();}else{more_',$st['id'], '=false;this.style.marginTop=\'-0px\';$(\'#data_',$st['id'], '\').hide();} "></div>';
    echo'<div class="data" id="data_',$st['id'], '"><a href="', $scripturl ,'?action=profile;u=' . $st['ID_MEMBER'], '" title="',$txt['rec_access_prof'],' ' . $st['user'], '" style="color: rgb(113, 113, 113);">' . $st['user'], '</a> | ',$txt['rec_com'],': '.$st['comments'].' | ',$txt['points_abrevation'],': ',$st['points'], ' | '.howlong($st['date']).'</div></div></div></td></tr></table>';
}

//Muestro los posts normales
foreach ($context['normal_posts'] as $np)
{
    echo'<table width="100%"><tr><td width="100%" style="border-bottom:0px solid #DFD9D3;"><div class="entry_item"><div class="icon"><img title="'.$np['category'].'" src="'. $settings['images_url'] .'/post/icono_'.$np['id_category'].'.gif"></div>';
    echo'<div class="text_container"><div class="title">';
    if($np['private'] == '1' && $context['user']['is_guest'])
        echo'<div class="icon_img" style="float: left; margin-left:0px; margin-right:3px;"><img title="Post privado" src="', $settings['images_url'] ,'/icons/hidden.gif" style="margin-top: -578px; display: inline;"></div>';

    echo'<span title="', censorText($np['title']), '"><a href="', $scripturl ,'?topic=', $np['id'],'">',censorText($np['title']), '</a></span></div>';

    echo'<script type="text/javascript">more_',$np['id'], '=false</script><div style="margin: 0pt; float: left;" class="icon_img"><img id="info_icon_',$np['id'], '" src="', $settings['images_url'] ,'/icons/exp.gif" style="width: 16px; margin-top: -0px; cursor: pointer;" alt="" onclick="if (!more_',$np['id'], '){more_',$np['id'], '=true;this.style.marginTop=\'-16px\';$(\'#data_',$np['id'], '\').show();}else{more_',$np['id'], '=false;this.style.marginTop=\'-0px\';$(\'#data_',$np['id'], '\').hide();} "></div>';
    echo'<div class="data" id="data_',$np['id'], '"><a href="', $scripturl ,'?action=profile;user=' . $np['user'], '" title="',$txt['rec_access_prof'],' ' . $np['user'], '" style="color: rgb(113, 113, 113);">' . $np['user'], '</a> | ',$txt['rec_com'],': '.$np['comments'].' | ',$txt['points_abrevation'],': ',$np['points'], ' &raquo; '.howlong($np['date']).'</div></div></div></td></tr></table>';
}

echo'</div><div class="box_posts"><center><font size="2">';

//Determino las paginas
if($id == ''){
    if($PagAct>1) echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."?pag=$PagAnt'><b>&laquo;&laquo; ",$txt['rec_prev'],"</b></a>";
    if($PagAct>1 && $PagAct<$PagUlt) echo ' || ';
    if($PagAct<$PagUlt)  echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."?pag=$PagSig'><b>",$txt['rec_next']," &raquo;&raquo;</b></a>";
}else{
    if($PagAct>1) echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."?pag=$PagAnt&id=$id'><b>&laquo;&laquo; Anterior</b></a>";
    if($PagAct>1 && $PagAct<$PagUlt) echo ' || ';
    if($PagAct<$PagUlt)  echo "<a style='cursor: pointer; cursor: hand;' href='". $scripturl ."?pag=$PagSig&id=$id'><b>Siguiente &raquo;&raquo;</b></a>";
}
echo'</font></center></div>';
//F ** Listado de Posts

echo'</div></div>
<!-- fin posts -->
</div>
<div style="float:left;">
<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['look_up'], '</div>
<div class="box_rss"><img src="',$settings['images_url'],'/icons/searchpeq.png" style="width: 16px; height: 16px;" border="0"></div></div>

<div class="box_buscar">
<table align="center" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td>
        <form name="buscador" method="GET">
	<img class="leftIbuscador" src="', $settings['images_url'], '/InputSleft.gif"/>
	<input type="text" size="25" class="pbuscador" id="ibuscadorq" name="action&#61;search2&amp;search"><input title="', $txt['search'], '" class="bbuscador" type="submit" value="" vspace="2" align="top" hspace="10">
        </form>
</td></tr></tbody></table>

</div></div>
<!-- estadisticas -->';

$request = db_query("SELECT coms.id_post ,mess.ID_TOPIC
                     FROM {$db_prefix}comentarios AS coms, {$db_prefix}messages AS mess
                     WHERE coms.id_post = mess.ID_TOPIC", __FILE__, __LINE__);

$context['cantidadcoment'] = mysql_num_rows($request);

echo'
<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['statics'], '</div>
<div class="box_rss"><img  src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_buscar">
<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
<tr>
<td><div class="size11"><a href="', $scripturl, '?action=who"><font color="#005CA5"><b>', $context['num_guests'] + $context['num_users_online'], ' ', $txt['total_users_online'], '</b></font></a></div></td>
<td><div class="size11">', $context['common_stats']['total_members'], ' ', $txt['total_members'], '</div></td>
</tr>
<tr>
<td><div class="size11">', $context['common_stats']['total_topics'], ' ', $txt['total_topics'], '</div></td>
<td><div class="size11">', $context['cantidadcoment'], ' ', $txt['total_comments'], '</div></td>
</tr>
<tr>
<td><div class="size11">', $txt['last_user'], '', $context['common_stats']['latest_member']['link'], '</div></td>
<td><div class="size11">&nbsp</div></td>
</tr>
</tbody></table></div></div>
<!-- fin de estadisticas -->';

echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['lasts_comments'], '</div>
<div class="box_rss"><div class="icon_img"><img id="last_comments_reload" onclick="actualizar_comentarios(); return false;" src="',$settings['images_url'],'/icons/reload.jpg" style="cursor: pointer;display: inline;"></a></div></div></div>
<div class="box_buscar">
<span id="last_comments">';
ultimos_comments();
echo'</span>';
echo'</div></div>';

    $request = db_query("SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.puntos
                        FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m)
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

//TOP Post semanal
echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['top_post_weekly'], '</div>
<div class="box_rss"><img  src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div align="left" class="box_buscar">'; 
	$contador = 0;
	foreach ($context['top_posts_week'] as $tpw)
	{
		$tamano = 48; // cantidad caracteres
		$contador++;

	if (strlen($tpw['titulo'])>$tamano)	{$tpw['titulo']=substr($tpw['titulo'],0,$tamano-1)."...";}
	echo '<b class="size11">'.$contador.'- </b><a class="size11" title="', $tpw['titulo'], '" href="', $scripturl ,'?topic=', $tpw['id'], '">', $tpw['titulo'], '</a> <font class="size11">(', $tpw['puntos'], ' ', $txt['points_abrevation'], ')</font><br>';
	}
echo'</div></div>';

//TAGs
echo'
<div class="act_comments">
<div class="box_title"  style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['tops_tags'], '<a href="', $scripturl, '?action=tags"><font size="1">(', $txt['tags_cloud'], ')</font></a></div>
<div class="box_rss"><img  src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_buscar" style="width:343px;overflow:hidden;word-wrap: break-word; "><center>';

$arreglo=array($context['poptags']);
usort($arreglo,"strnatcasecmp");
for($x=0;$x<count($arreglo);$x++)
echo $arreglo[$x]."<br>";

echo'</b></a></center></div></div>';
//Fin de TAGS

//Destacados... (publicidad)
echo'<div class="act_comments">
<div class="box_title" style="width: 363px;"><div class="box_txt ultimos_comments">', $txt['advertising'], '</div>
<div class="box_rss"><img  src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div align="center" class="box_buscar">'; ssi_destacado(); echo'</div></div>';

echo'</div><div align="left" style="float:left;">
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['random_images'], '</div>
<div class="box_rss"><img src="',$settings['images_url'],'/icons/imageaz.png" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_icono2">';
foreach ($context['imgaletatoria'] as $imgalet){
echo '<div class="photo_small1"><a href="', $scripturl, '?action=imagenes;sa=ver;id=', $imgalet['id'], '"><img  border="0" style="width: 140px;" src="', $imgalet['filename'], '"></a></div><div align="center" class="smalltext">', $txt['images_comments'], ' (<a href="', $scripturl, '?action=imagenes;sa=ver;id=', $imgalet['id'], '#comentarios">', $imgalet['commenttotal'],'</a>)</div>';}
echo'<hr><center><a class="size11" href="', $scripturl, '?action=imagenes;sa=agregar"><b>', $txt['add_image'], '</b></a></center></div></div>

<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['user_with_more_points'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl, '?type=rss;action=.xml;sa=puntos"><img src="', $settings['images_url'], '/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div>
<div class="box_icono2">';
foreach ($context['shop_richest'] as $row)
echo '<img src="', $settings['images_url'], '/point.png"> <font size="1"><a title="', $row['realName'], '" href="', $scripturl, '?action=profile;u=', $row['ID_MEMBER'], '">', $row['realName'], '</a> (', formatMoney($row['money']), ')</font><br>';
echo'</div></div>';

echo'
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['user_of_the_week'], '</div>
<div class="box_rss"><img  src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_icono2">';
foreach ($context['top_posters_week'] as $poster)
echo '<img src="', $settings['images_url'], '/point.png"> <font size="1">', $poster['link'], ' (', $poster['num_posts'], ')</font><br>';
echo'</div></div>';

echo'
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['top_poster_user'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl, '?type=rss;action=.xml;sa=posteadores"><img src="', $settings['images_url'], '/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div>
<div class="box_icono2">';
foreach ($context['top_starters'] as $poster)
echo'<img src="', $settings['images_url'], '/point.png"> <font size="1">', $poster['link'], ' (', $poster['num_topics'], ')</font><br>';

echo'</div></div>';

echo'
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['newest_users'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl, '?type=rss;action=.xml;sa=usuarios"><img src="', $settings['images_url'], '/icons/cwbig-v1-iconos.gif?v3.2.3" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div>
<div class="box_icono2">';
foreach ($context['yeniuyeler'] as $poster)
{echo '<img src="', $settings['images_url'], '/point.png"> <font size="1">',$poster['link'], '</font><br>';}
echo'</div></div>';

echo'
<div class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['links'], '</div>
<div class="box_rss"><img src="', $settings['images_url'], '/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div>
<div class="box_icono2">';
ssi_enlaces();
echo'</div></div>';
}



function ultimos_comments()
{
	global $context, $settings, $scripturl, $txt, $db_prefix, $ID_MEMBER;
	global $user_info, $modSettings, $func;
	$rs = db_query("SELECT c.id_post, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName
                        FROM ({$db_prefix}comentarios AS c, {$db_prefix}messages AS m, {$db_prefix}members AS mem)
                        WHERE id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER
                        ORDER BY c.id_coment DESC
                        LIMIT 15", __FILE__, __LINE__);
	$context['ult_comms'] = array();
	while ($row = mysql_fetch_assoc($rs))
	$context['ult_comms'][] = array(
			'id_comment' => $row['id_coment'],
			'titulo' => $row['subject'],
			'ID_TOPIC' => $row['ID_TOPIC'],
			'memberName' => $row['memberName'],
			'RealName' => $row['RealName'],
		);
	mysql_free_result($rs);
	foreach ($context['ult_comms'] as $comments){
	echo '<font class="size11" title="'. $comments['titulo'] .'"><b>'.$comments['RealName'].'</b> - <a href="'.$scripturl.'?topic='.$comments['ID_TOPIC'].'#cmt_'.$comments['id_comment'] .'">'.$comments['titulo'].'</a></font><br />';
	}
}

function howlong($fecha)
{
    global $txt;

    $fecha = $fecha;
    $ahora = time();
    $tiempo = $ahora-$fecha;

     if(round($tiempo / 31536000) <= 0){
        if(round($tiempo / 2678400) <= 0){
             if(round($tiempo / 86400) <= 0){
                 if(round($tiempo / 3600) <= 0){
                    if(round($tiempo / 60) <= 0){

                if($tiempo <= 60){$hace = $txt['rec_since']." ".$tiempo. " ".$txt['rec_seconds'];}
                } else
                {
                    $can = round($tiempo / 60);
                    if($can <= 1) {$word = $txt['rec_minute'];} else {$word = $txt['rec_minutes'];}
                    $hace = $txt['rec_since']." ".$can. " ".$word;
                }
                } else
                {
                    $can = round($tiempo / 3600);
                    if($can <= 1) {$word = $txt['rec_hour'];} else {$word = $txt['rec_hours'];}
                    $hace = $txt['rec_since']." ".$can. " ".$word;
                }
                } else
                {
                    $can = round($tiempo / 86400);
                    if($can <= 1) {$word = $txt['rec_day'];} else {$word = $txt['rec_days'];}
                    $hace = $txt['rec_since']." ".$can. " ".$word;
                }
                } else
                {
                    $can = round($tiempo / 2678400);
                    if($can <= 1) {$word = $txt['rec_month'];} else {$word = $txt['rec_months'];}
                    $hace = $txt['rec_since']." " .$can. " ".$word;
                }
                } else
                {
                    $can = round($tiempo / 31536000);
                    if($can <= 1) {$word = $txt['rec_year'];} else {$word = $txt['rec_years'];}
                    $hace = $txt['rec_since']." ".$can. " ".$word;
                }    
    return $hace;
}

?>