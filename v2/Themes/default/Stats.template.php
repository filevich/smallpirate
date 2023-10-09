<?php
function formatMoney($money)
{
	global $modSettings;
	$money = (float) $money;
	return $modSettings['shopCurrencyPrefix'] . $money;
}
function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
$contar=1;
$contar2=1;
$contar3=1;
$contar4=1;
$contar5=1;
$contar6=1;
$contar7=1;
$contar8=1;

$comentarios=mysql_query("
SELECT *
FROM cw_comentarios");
$context['ccomentarios'] = mysql_num_rows($comentarios);



	echo '
		<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">', $context['page_title'], '</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
		<table border="0" width="100%" cellspacing="1" cellpadding="4">';
			if ($context['user']['is_admin'])
			echo' <tr>
				<td class="top10_2" colspan="4"><center><i><font face="Arial" color="#FFFFFF">General</font></i></center></td>
			</tr><tr>
				<td class="windowbg" width="20" valign="middle" align="center"></td>
				<td class="windowbg2" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">
						<tr>
							<td nowrap="nowrap">', $txt[488], ':</td>
							<td align="right">', $context['show_member_list'] ? '<a href="' . $scripturl . '?action=mlist">' . $context['num_members'] . '</a>' : $context['num_members'], '</td>
						</tr><tr>
							<td nowrap="nowrap">Total de Comentarios:</td>
							<td align="right">', $context['ccomentarios'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt[490], ':</td>
							<td align="right">', $context['num_topics'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt[658], ':</td>
							<td align="right">', $context['num_categories'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['users_online'], ':</td>
							<td align="right">', $context['users_online'], '</td>
						</tr><tr>
							<td nowrap="nowrap" valign="top">', $txt[888], ':</td>
							<td align="right">', $context['most_members_online']['number'], ' - ', $context['most_members_online']['date'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['users_online_today'], ':</td>
							<td align="right">', $context['online_today'], '</td>';
	if (!empty($modSettings['hitStats']) & ($context['user']['is_admin']))
		echo '
						</tr><tr>
							<td nowrap="nowrap">', $txt['num_hits'], ':</td>
							<td align="right">', $context['num_hits'], '</td>';
							if ($context['user']['is_admin'])
	echo '
						</tr>
					</table>
				</td>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="', $settings['images_url'], '/stats_info.gif" alt="" /></td>
				<td class="windowbg2" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">
						<tr>
							<td nowrap="nowrap">', $txt['average_members'], ':</td>
							<td align="right">', $context['average_members'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['average_posts'], ':</td>
							<td align="right">', $context['average_posts'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['average_topics'], ':</td>
							<td align="right">', $context['average_topics'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt[665], ':</td>
							<td align="right">', $context['num_boards'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt[656], ':</td>
							<td align="right">', $context['common_stats']['latest_member']['link'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['average_online'], ':</td>
							<td align="right">', $context['average_online'], '</td>
						</tr><tr>
							<td nowrap="nowrap">', $txt['gender_ratio'], ':</td>
							<td align="right">', $context['gender']['ratio'], '</td>';
	if (!empty($modSettings['hitStats']) & ($context['user']['is_admin']))
		echo '
						</tr><tr>
							<td nowrap="nowrap">', $txt['average_hits'], ':</td>
							<td align="right">', $context['average_hits'], '</td></tr>
				</table>
				</td>
			</tr>	';
	echo '
						<tr>
				<td class="top10" colspan="2" width="500px"><center><i><font face="Arial" color="#FFFFFF">10 Im&aacute;genes m&aacute;s comentadas</font></i> <a href="/web/rss/rss-pic-mas-comment.php"><img src="/Themes/default/images/rss.gif"></a></center></td>
				<td class="top10_1" colspan="2" width="434px"><center><i><font face="Arial" color="#FFFFFF">', $txt['smf_stats_4'], '</font></i> <a href="/?type=rss;action=.xml;sa=categorias"><img src="/Themes/default/images/rss.gif"></a></center></td>
			</tr><tr>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="/Themes/default/images/icons/icono-foto.gif" alt="" /></td>
				<td class="windowbg2" width="500px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
$comment_pic2=mysql_query("
SELECT *
FROM smf_gallery_pic
ORDER BY commenttotal DESC LIMIT 10");
$context['comment-img2'] = array();
while ($row = mysql_fetch_assoc($comment_pic2))
{
$context['comment-img2'][] = array(
'title' => $row['title'],
'commenttotal' => $row['commenttotal'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic2);					
					
	foreach ($context['comment-img2'] as $poster)
		echo '
						<tr>
							<td width="60%" valign="top"><b class="size11">'.$contar++.' - </b><a href="/?action=imagenes;sa=ver;id=', $poster['id'], '">', $poster['title'], '</a></td>
							<td width="20%" align="left" valign="top"></td>
							<td width="20%" align="right" valign="top">', $poster['commenttotal'], '</td>
						</tr>';
	echo '
					</table>
				</td>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="', $settings['images_url'], '/stats_board.gif" alt="" /></td>
				<td class="windowbg2" width="434px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
	foreach ($context['top_boards'] as $board)
		echo '
						<tr>
							<td width="60%" valign="top"><b class="size11">'.$contar8++.' - </b>', $board['link'], '</td>
							<td width="20%" align="left" valign="top"></td>
							<td width="20%" align="right" valign="top">', $board['num_posts'], '</td>
						</tr>';
	echo '
					</table>
				</td>
			</tr><tr>
				<td class="top10" colspan="2" width="500px"><center><i><font face="Arial" color="#FFFFFF">10 Im&aacute;genes con m&aacute;s puntos</font></i> <a href="/web/rss/rss-pic-mas-puntos.php"><img src="/Themes/default/images/rss.gif"></a></center></td>
				<td class="top10_1" colspan="2" width="434px"><center><i><font face="Arial" color="#FFFFFF">', $txt['smf_stats_12'], '</font></i> <a href="/?type=rss;action=.xml;sa=postsvist"><img src="/Themes/default/images/rss.gif"></a></center></td>
			</tr><tr>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="/Themes/default/images/icons/icono-foto.gif" alt="" /></td>
				<td class="windowbg2" width="500px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
					
$comment_pic3=mysql_query("
SELECT *
FROM smf_gallery_pic
ORDER BY puntos DESC LIMIT 10");
$context['comment-img3'] = array();
while ($row = mysql_fetch_assoc($comment_pic3))
{
$context['comment-img3'][] = array(
'title' => $row['title'],
'puntos' => $row['puntos'],
'id' => $row['ID_PICTURE'],);}
mysql_free_result($comment_pic3);					
	foreach ($context['comment-img3'] as $topic)
		echo '
						<tr>
							<td width="60%" valign="top"><b class="size11">'.$contar2++.' - </b><a href="/?action=imagenes;sa=ver;id=', $topic['id'], '">', $topic['title'], '</a></td>
							<td width="20%" align="left" valign="top"></td>
							<td width="20%" align="right" valign="top">', $topic['puntos'], '</td>
						</tr>';
	echo '
					</table>
				</td>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="', $settings['images_url'], '/stats_views.gif" alt="" /></td>
				<td class="windowbg2" width="434px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
	foreach ($context['top_topics_views'] as $topic)
		echo '
						<tr>
							<td width="75%" valign="top"><b class="size11">'.$contar3++.' - </b>', $topic['link'], '</td>
							<td width="5%" align="left" valign="top"></td>
							<td width="20%" align="right" valign="top">', $topic['num_views'], '</td>
						</tr>';
	echo '
					</table>
				</td>
			</tr><tr>
				<td class="top10_4" colspan="2" width="500px"><center><i><font face="Arial" color="#FFFFFF">', $txt['smf_stats_15'], '</font></i> <a href="/?type=rss;action=.xml;sa=posteadores"><img src="/Themes/default/images/rss.gif"></a></center></td>
				<td class="top10_3" colspan="2" width="434px"><center><i><font face="Arial" color="#FFFFFF">', $txt['smf_stats_16'], '</font></i> <a href="/?type=rss;action=.xml;sa=puntos"><img src="/Themes/default/images/rss.gif"></a></center></td>
			</tr><tr>
				<td class="windowbg" width="20" valign="middle" align="center"><img src="', $settings['images_url'], '/stats_replies.gif" alt="" /></td>
				<td class="windowbg2" width="500px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
	foreach ($context['top_starters'] as $poster)
		echo '
						<tr>
							<td width="60%" valign="top"><b class="size11">'.$contar4++.' - </b>', $poster['link'], '</td>
							<td width="20%" align="left" valign="top">', $poster['num_topics'] > 0 ? '' : '&nbsp;', '</td>
							<td width="20%" align="right" valign="top">', $poster['num_topics'], '</td>
						</tr>';
	echo '
					</table>
				</td>
				<td class="windowbg" width="20" valign="middle" align="center" nowrap="nowrap"><img src="', $settings['images_url'], '/stats_views.gif" alt="" /></td>
				<td class="windowbg2" width="434px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
		foreach ($context['shop_richest'] as $row)
		echo '<tr>
		      <td width="60%" valign="top"><b class="size11">'.$contar5++.' - </b><a title="', $row['realName'], '" href="?action=profile;user=' . $row['realName'], '">', $row['realName'], '</a></td>
			  <td width="20%" align="left" valign="top">', $poster['time_online'] > 0 ? '' : '&nbsp;', '</td>
			  <td width="20%" align="right" valign="top" nowrap="nowrap">', formatMoney($row['money']), '</td>
			  </tr>';
						
				echo'</table></td></tr>';
				
				
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
echo'<tr>
				<td class="top10_4" colspan="2" width="500px"><center><i><font face="Arial" color="#FFFFFF">10 Post con m&aacute;s puntos</font></i> <a href="/?type=rss;action=.xml;sa=ppuntos"><img src="/Themes/default/images/rss.gif"></a></center></td>
				<td class="top10_3" colspan="2" width="434px"><center><i><font face="Arial" color="#FFFFFF">10 Im&aacute;genes m&aacute;s visitadas</font></i> <a href="/?type=rss;action=.xml;sa=imagenes-vistas"><img src="/Themes/default/images/rss.gif"></a></center></td>
			</tr><tr>';
			
			echo'<td class="windowbg" width="20" valign="middle" align="center" nowrap="nowrap"><img src="/Themes/default/images/stats_views.gif" alt="" /></td>
				<td class="windowbg2" width="434px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
					
		foreach ($context['postporpuntos'] as $ppp){
		echo '<tr>
		      <td width="60%" valign="top"><b class="size11">'.$contar6++.' - </b><a title="', $ppp['titulo'], '" href="?topic=', $ppp['id'], '">', $ppp['titulo'], '</a></td>
			  <td width="20%" align="right" valign="top" nowrap="nowrap">', $ppp['puntos'], '</td>
			  </tr>';}
			echo'</tr>';

echo '</table></td>';

echo'
<td class="windowbg" width="20" valign="middle" align="center" nowrap="nowrap"><img src="/Themes/default/images/icons/icono-foto.gif" alt="" /></td>
				<td class="windowbg2" width="434px" valign="top">
					<table border="0" cellpadding="1" cellspacing="0" width="100%">';
		foreach ($context['imgv'] as $imgv){
		echo '<tr>
		      <td width="60%" valign="top"><b class="size11">'.$contar7++.' - </b><a title="', $imgv['titulo'], '" href="/?action=imagenes;sa=ver;id=', $imgv['id'], '">', $imgv['titulo'], '</a></td>
			  <td width="20%" align="right" valign="top" nowrap="nowrap">', $imgv['v'], '</td>
			  </tr>';}
			echo'</tr>';

echo '</table></td>';

echo'</tr>
				</td>
			</tr>
		</table>';

// por mes
if (!empty($context['monthly']) & ($context['user']['is_admin']))
	{
		echo '<div  class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>Historia del Foro (usando diferencia horaria del foro)</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div style="width: 919px;" class="windowbg" border="0">
<table border="0" width="100%" cellspacing="1" cellpadding="4" style="margin-bottom: 1ex;" id="stats">
						<tr class="titlebg" valign="middle" align="center">
							<td width="25%">', $txt['smf_stats_13'], '</td>
							<td width="15%">', $txt['smf_stats_7'], '</td>
							<td width="15%">', $txt['smf_stats_9'], '</td>';
		if (!empty($modSettings['hitStats']))
			echo '
							<td>P&aacute;gina vistas</td>';
		echo '
						</tr>';

		foreach ($context['monthly'] as $month)
		{
			echo '
						<tr class="windowbg2" valign="middle" id="tr_', $month['id'], '">
							<th align="left" width="25%">
								<a name="', $month['id'], '" id="link_', $month['id'], '" href="', $month['href'], '" onclick="return doingExpandCollapse || expand_collapse(\'', $month['id'], '\', ', $month['num_days'], ');"> ', $month['month'], ' ', $month['year'], '</a>
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

	echo '		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			var doingExpandCollapse = false;

			function expand_collapse(curId, numDays)
			{
				if (window.XMLHttpRequest)
				{
					if (document.getElementById("img_" + curId).src.indexOf("expand") > 0)
					{
						if (typeof window.ajax_indicator == "function")
							ajax_indicator(true);
						getXMLDocument(smf_scripturl + "?action=TOPs;expand=" + curId + ";xml", onDocReceived);
						doingExpandCollapse = true;
					}
					else
					{
						var myTable = document.getElementById("stats"), i;
						var start = document.getElementById("tr_" + curId).rowIndex + 1;
						for (i = 0; i < numDays; i++)
							myTable.deleteRow(start);
						// Adjust the image and link.
						document.getElementById("img_" + curId).src = smf_images_url + "/expand.gif";
						document.getElementById("link_" + curId).href = smf_scripturl + "?action=TOPs;expand=" + curId + "#" + curId;
						// Modify the session variables.
						getXMLDocument(smf_scripturl + "?action=TOPs;collapse=" + curId + ";xml");
					}
					return false;
				}
				else
					return true;
			}
			function onDocReceived(XMLDoc)
			{
				var numMonths = XMLDoc.getElementsByTagName("month").length, i, j, k, numDays, curDay, start;
				var myTable = document.getElementById("stats"), curId, myRow, myCell, myData;
				var dataCells = [
					"date",
					"new_topics",
					"new_posts",
					"new_members",
					"most_members_online"
				];

				if (numMonths > 0 && XMLDoc.getElementsByTagName("month")[0].getElementsByTagName("day").length > 0 && XMLDoc.getElementsByTagName("month")[0].getElementsByTagName("day")[0].getAttribute("hits") != null)
					dataCells[5] = "hits";

				for (i = 0; i < numMonths; i++)
				{
					numDays = XMLDoc.getElementsByTagName("month")[i].getElementsByTagName("day").length;
					curId = XMLDoc.getElementsByTagName("month")[i].getAttribute("id");
					start = document.getElementById("tr_" + curId).rowIndex + 1;
					for (j = 0; j < numDays; j++)
					{
						curDay = XMLDoc.getElementsByTagName("month")[i].getElementsByTagName("day")[j];
						myRow = myTable.insertRow(start + j);
						myRow.className = "windowbg2";

						for (k in dataCells)
						{
							myCell = myRow.insertCell(-1);
							if (dataCells[k] == "date")
								myCell.style.paddingLeft = "3ex";
							else
								myCell.style.textAlign = "center";
							myData = document.createTextNode(curDay.getAttribute(dataCells[k]));
							myCell.appendChild(myData);
						}
					}
					// Adjust the arrow to point downwards.
					document.getElementById("img_" + curId).src = smf_images_url + "/collapse.gif";
					// Adjust the link to collapse instead of expand
					document.getElementById("link_" + curId).href = smf_scripturl + "?action=TOPs;collapse=" + curId + "#" + curId;
				}

				doingExpandCollapse = false;
				if (typeof window.ajax_indicator == "function")
					ajax_indicator(false);
			}
		// ]]></script>';
}

?>