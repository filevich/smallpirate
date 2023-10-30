<?php
include_once('includes/urls_amigables.php');

function formatMoney($money)
{
	global $modSettings;
	$money = (float) $money;
	return $modSettings['shopCurrencyPrefix'] . $money;
}
function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings, $db_prefix;
$contar=1;
$contar2=1;
$contar3=1;
$contar4=1;
$contar5=1;
$contar6=1;
$contar7=1;
$contar9=1;
$contar8=1;
$request = db_query("
SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.ID_BOARD, t.puntos, b.name AS bname
FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)
WHERE t.ID_TOPIC = m.ID_TOPIC
AND t.ID_BOARD = b.ID_BOARD
ORDER BY t.puntos DESC
LIMIT 10 ", __FILE__, __LINE__);
$context['postporpuntos'] = array();
while ($row = mysql_fetch_assoc($request))
$context['postporpuntos'][] = array(
'titulo' => $row['subject'],
'puntos' => $row['puntos'],
'id' => $row['ID_TOPIC'],
'bname' => $row['bname'],);
mysql_free_result($request);	
$requestq = db_query("
SELECT t.ID_TOPIC,COUNT(c.id_post) as Cuenta,t.subject, t.ID_BOARD, b.name AS bname
From ({$db_prefix}comentarios as c, {$db_prefix}messages as t, {$db_prefix}boards AS b)
WHERE t.ID_TOPIC = c.id_post 
AND t.ID_BOARD = b.ID_BOARD
GROUP BY c.id_post 
ORDER BY Cuenta DESC 
LIMIT 10", __FILE__, __LINE__);
$context['tcomentados'] = array();
while ($row = mysql_fetch_assoc($requestq))
$context['tcomentados'][] = array(
'subject' => $row['subject'],
'cuenta' => $row['Cuenta'],
'id' => $row['ID_TOPIC'],
'bname' => $row['bname'],);
mysql_free_result($requestq);	
$comentarios=mysql_query("
SELECT *
FROM {$db_prefix}comentarios");
$context['ccomentarios'] = mysql_num_rows($comentarios);
$comment_pic2=mysql_query("
SELECT *
FROM {$db_prefix}gallery_pic
ORDER BY commenttotal DESC LIMIT 10");
$context['comment-img2'] = array();
while ($row = mysql_fetch_assoc($comment_pic2))
{$context['comment-img2'][] = array(
'title' => $row['title'],
'commenttotal' => $row['commenttotal'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic2);					
$comment_pic3=mysql_query("
SELECT *
FROM {$db_prefix}gallery_pic
ORDER BY puntos DESC LIMIT 10");
$context['comment-img3'] = array();
while ($row = mysql_fetch_assoc($comment_pic3))
{$context['comment-img3'][] = array(
'title' => $row['title'],
'puntos' => $row['puntos'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic3);		


echo'<table align="center"><tr align="center"><td align="center">';
echo'<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_posted_images'], '</div>
<div class="box_rss"><div class="icon_img"><a href="web/rss/rss-pic-mas-comment.php"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['comment-img2'] as $poster)
echo'<span class="size11"><b>'.$contar++.' - </b><a title="', censorText($poster['title']), '" href="', $scripturl ,'?action=imagenes;sa=ver;id=', $poster['id'], '">', achicar($poster['title']), '</a> (', $poster['commenttotal'], ' ', $txt['post_prefix'], ')</span><br>';
echo'</div></div>

<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_rated_images'], '</div>
<div class="box_rss"><div class="icon_img"><a href="web/rss/rss-pic-mas-puntos.php"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['comment-img3'] as $topic)
echo'<span class="size11"><b>'.$contar2++.' - </b><a title="', censorText($topic['title']), '" href="', $scripturl ,'?action=imagenes;sa=ver;id=', $topic['id'], '">', achicar($topic['title']), '</a> (',$topic['puntos'],' ', $txt['points_prefix'], ')</span><br>';
echo'</div></div>

<div class="box_300" align="left" style="float:left;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_visited_images'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=imagenes-vistas"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['imgv'] as $imgv){
echo'<span class="size11"><b>'.$contar7++.' - </b><a title="', censorText($imgv['titulo']), '" href="', $scripturl ,'?action=imagenes;sa=ver;id=', $imgv['id'], '">', achicar($imgv['titulo']), '</a> (', $imgv['v'], ' ', $txt['visited_prefix'], ')</span><br>';}
echo'</div></div>';
echo'</td></tr></table>';

echo'<table align="center"><tr align="center"><td align="center">';
echo'<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_rated_topics'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=ppuntos"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['postporpuntos'] as $ppp){echo'<span class="size11"><b>'.$contar6++.' - </b><a title="', censorText($ppp['titulo']), '" href="', $scripturl ,'?topic=', $ppp['id'], '">', achicar($ppp['titulo']), '</a> (', $ppp['puntos'], ' ', $txt['points_prefix'], ')</span><br>';}
echo'</div></div>

<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_visited_topics'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=postsvist"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['top_topics_views'] as $topic)
echo'<span class="size11"><b>'.$contar3++.' - </b><a title="', censorText($topic['subject']), '" href="', $scripturl ,'?topic='.$topic['id'].'">', achicar($topic['subject']), '</a> (', $topic['num_views'], ' ', $txt['visited_prefix'], ')</span><br>';
echo'</div></div>';
echo'<div class="box_300" align="left" style="float:left;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_posted_topics'], '</div>
<div class="box_rss"><div class="icon_img"><a href="web/rss/rss-post-comentados.php"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach($context['tcomentados'] as $total)
echo'<span class="size11"><b>'.$contar9++.' - </b> <a title="', achicar($total['subject']), '" href="', $scripturl ,'?topic=', $total['id'], '">', achicar($total['subject']), '</a> (',$total['cuenta'], ' ', $txt['post_prefix'], ')</span><br>';
echo'</div></div>';
echo'</td></tr></table>';

echo'<table align="center"><tr align="center"><td align="center">';
echo'<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_important_posters'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=posteadores"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['top_starters'] as $poster)
echo'<span class="size11"><b>'.$contar4++.' - </b><a title="', censorText($poster['name']), '" href="', $scripturl ,'?action=profile;u='.$poster['id'].'">', censorText($poster['name']), '</a> (', $poster['num_topics'], ' ', $txt['posts'], ')</span><br>';
echo'</div></div>

<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_richest_users'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=puntos"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['shop_richest'] as $row)
echo'<span class="size11"><b>'.$contar5++.' - </b> <a title="', censorText($row['realName']), '" href="', $scripturl ,'?action=profile;u=', $row['ID_MEMBER'], '">', censorText($row['realName']), '</a> (', formatMoney($row['money']), ' ', $txt['points_prefix'], ')</span><br>';
echo'</div></div>';
echo'<div class="box_300" align="left" style="float:left;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['most_posted_categories'], '</div>
<div class="box_rss"><div class="icon_img"><a href="', $scripturl ,'?type=rss;action=.xml;sa=categorias"><img src="',$boardurl,'/Themes/default/images/icons/cwbig-v1-iconos.gif" style="cursor: pointer; margin-top: -352px; display: inline;"></a></div></div></div><div class="windowbg" style="width: 290px; padding: 4px;">';
foreach ($context['top_boards'] as $board)
echo'<span class="size11"><b>'.$contar8++.' - </b><a title="', censorText($board['name']), '" href="', $scripturl ,'?id='.$board['id'].'">', achicar($board['name']), '</a> (', $board['num_posts'], ' ', $txt['posts'], ')</span><br>';
echo'</div></div>';

echo'</td></tr></table>';


if ($context['user']['is_admin']){
echo'<hr><div align="center" style="float:center"><font color="#1C1C1C"><b>Informacion privada visible solo admins</b></font></span><hr>';
echo'<table align="center"><tr align="center"><td align="center">';
echo'<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['general'], ' </div>
<div class="box_rss"><img src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;"></div></div><div class="windowbg" style="width: 290px; padding: 4px;"><span class="size11">', $txt[488], ': ', $context['show_member_list'] ? '<a href="' . $scripturl . '?action=mlist">' . $context['num_members'] . '</a>' : $context['num_members'], '<br>', $txt['posts_total'], ': ', $context['ccomentarios'], '<br>', $txt[490], ': ', $context['num_topics'], '<br>', $txt['users_online'], ': ', $context['users_online'], '</span></div></div>

<div class="box_300" align="left" style="float:left; margin-right: 8px;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['general'], '</div>
<div class="box_rss"><img src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;"></div></div><div class="windowbg" style="width: 290px; padding: 4px;"><span class="size11">';
echo'', $txt['average_members'], ': ', $context['average_members'], '<br>', $txt['average_posts'], ': ', $context['average_posts'], '<br>', $txt['average_topics'], ': ', $context['average_topics'], '<br>', $txt[665], ': ', $context['num_boards'], '<br>', $txt[656], ': ', $context['common_stats']['latest_member']['link'], '</span></div></div>

<div class="box_300" align="left" style="float:left;">
<div class="box_title" style="width: 300px;"><div class="box_txt box_300-34">', $txt['general'], '</div>
<div class="box_rss"><img src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;"></div></div><div class="windowbg" style="width: 290px; padding: 4px;"><span class="size11">';
echo'', $txt['num_hits'], ': ', $context['num_hits'], '</span></div></div>';
echo'</td></tr></table>';}
echo'<table align="center" width="100%"><tr align="center"><td align="center">';
if (!empty($context['monthly']) & ($context['user']['is_admin']))
	{
		echo '<hr><div  class="box_buscador">
</div>
<div style="width: 919px;" class="windowbg" border="0">
<table border="0" width="100%" cellspacing="1" cellpadding="4" style="margin-bottom: 1ex;" id="stats">
						<tr class="titlebg" valign="middle" align="center">
							<td width="25%">', $txt['month'], '</td>
							<td width="15%">', $txt['newest_post'], '</td>
							<td width="15%">', $txt['newest_users'], '</td>';
		if (!empty($modSettings['hitStats']))
			echo '
							<td>', $txt['visited_pages'], '</td>';
		echo '
						</tr>';

		foreach ($context['monthly'] as $month)
		{
			echo '
						<tr class="windowbg2" valign="middle" id="tr_', $month['id'], '">
							<th align="left" width="25%">
								<b name="', $month['id'], '" id="link_', $month['id'], '"> ', $month['month'], ' ', $month['year'], '</b>
							</th>
							<th align="center" width="15%">', $month['new_topics'], '</th>
							<th align="center" width="15%">', $month['new_members'], '</th>
						
						';
			if (!empty($modSettings['hitStats']))
				echo '
							<th align="center">', $month['hits'], '</th>';
			echo '
						</tr>';

			if ($month['expanded'])
			{
				foreach ($month['days'] as $day)
				{
					echo '
						<tr class="windowbg2" valign="middle" align="left">
							<td align="left" style="padding-left: 3ex;">', $day['year'], '-', $day['month'], '-', $day['day'], '</td>
							<td align="center">', $day['new_topics'], '</td>
						    <td align="center">', $day['new_members'], '</td>';
					if (!empty($modSettings['hitStats']))
						echo '
							<td align="center">', $day['hits'], '</td>';
					echo '
						</tr>';
				}
			}
		}
		echo '</table></div></div>';
	}
	echo'</td></tr></table>';
}

function achicar($tipo){
censorText($tipo);
if (strlen($tipo) > 33){
$tipo = substr($tipo,0,30)."...";}
return $tipo;}

?>