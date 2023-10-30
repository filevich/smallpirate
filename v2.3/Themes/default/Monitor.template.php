<?php
function template_main()
{
	global $context, $settings, $memberContext, $txt, $modSettings, $user_info, $user_profile, $sourcedir, $db_prefix, $scripturl;
        
if ($context['user']['is_logged']){

//ultimos comentarios
echo'<div style="float:left;width:708px;margin-left:6px;">';
echo'<div class="box_r_buscador" style="margin-right:8px;margin-botton:8px;">
<div class="box_title" style="width:700px;"><div class="box_txt box_r_buscadort">',$txt['last_comments_added'],'</div>
<div class="box_rss"><img alt="" src="',$settings['images_url'],'/blank.gif" style="width:14px;height:12px;" border="0" /></div></div>
<div class="windowbg" style="width:690px;padding:4px;text-align:left">';

if (!empty($context['monitorcom']))
{
$lastcom='';
echo '<table>';
foreach ($context['monitorcom'] as $monitorcom)
{
    if ($lastcom != $monitorcom['id'])
    {
        echo'<tr><td width="90%"><img align="absmiddle" title="'.$monitorcom['bname'].'" src="',$settings['images_url'],'/post/icono_'.$monitorcom['ID_BOARD'].'.gif"><b class="size11"><a title="'.censorText($monitorcom['titulo']).'" href="', $scripturl ,'?topic='.$monitorcom['id'].'">'.$monitorcom['titulo'].'</a> ('.$monitorcom['puntos'].' Puntos)</b><br></td></tr>';
        $lastcom = $monitorcom['id'];
    }
    $mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
    $diames2 = date(j,$monitorcom['fecha']); $mesano2 = date(n,$monitorcom['fecha']) - 1 ; $ano2 = date(Y,$monitorcom['fecha']);
    $seg2=date(s,$monitorcom['fecha']); $hora2=date(H,$monitorcom['fecha']); $min2=date(i,$monitorcom['fecha']);
    echo '<tr><td><div class="size11">['.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2.'] <a href="', $scripturl ,'?action=profile;user='.$monitorcom['user'].'">'.$monitorcom['user'].'</a>: '.$monitorcom['comentario'].'</div></td></tr>';
}
echo '</table>';
} 
else echo'<b class="size11">',$txt['no_comments_go_home'],'</b><hr />';
echo'</div></div>';

//ultimos comentarios imagenes
echo'<div class="box_r_buscador" style="margin-right:8px;">
<div class="box_title" style="width: 700px;"><div class="box_txt box_r_buscadort">',$txt['last_comments_added_gallery'],'</div>
<div class="box_rss"><img alt="" src="',$settings['images_url'],'/blank.gif" style="width:14px;height:12px;" border="0" /></div></div>
<div class="windowbg" style="width:690px;padding:4px;text-align:left;">';
if (!empty($context['monitorimg']))
{
$lastimg='';
echo '<table>';
foreach ($context['monitorimg'] as $monitorimg)
{
    if ($lastimg != $monitorimg['id'])
    {
        echo'<tr><td valign="left" width="90%"><hr /><img title="Imágenes" src="',$settings['images_url'],'/icons/icono-foto.gif"></td><td><b class="size11"><a title="'.$monitorimg['title'].'" href="', $scripturl ,'?action=imagenes;sa=ver;id='.$monitorimg['ID_PICTURE'].'">'.$monitorimg['title'].' ('.$monitorimg['puntos'].' ',$txt['monitor_points'],')</a></b><br></td></tr>';
        $lastimg = $monitorimg['id'];
    }
    $mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
    $diames2 = date(j,$monitorimg['fecha']); $mesano2 = date(n,$monitorimg['fecha']) - 1 ; $ano2 = date(Y,$monitorimg['fecha']);
    $seg2=date(s,$monitorimg['fecha']); $hora2=date(H,$monitorimg['fecha']); $min2=date(i,$monitorimg['fecha']);
    echo '<tr><td><div class="size11">'.$diames2.'.'.$mesesano2[$mesano2].'.'.$ano2.' '.$hora2.':'.$min2.':'.$seg2.' : <a href="', $scripturl ,'?action=imagenes;sa=ver;id='.$monitorimg['ID_PICTURE'].'#cmt_'.$monitorimg['ID_COMMENT'].'">'.$monitorimg['comment'].'</a></div></td></tr>';
}
echo '</table>';
}
else echo'<b class="size11">',$txt['no_comments_go_home'],'</b><hr />';
echo'</div></div>';
echo'</div>';

//ultimos puntos
echo'<div style="float:left;width: 212px;margin-bottom:8px;"><div class="publicidad" style="margin-bottom:8px;">
<div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r">',$txt['last_points_recieved'],'</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 202px;padding:4px;text-align:left;">';

if (!empty($context['monitorpun']))
{
foreach ($context['monitorpun'] as $monitorpun)
{
echo'<img align="absmiddle" title="'.$monitorpun['bname'].'" src="',$settings['images_url'],'/post/icono_'.$monitorpun['ID_BOARD'].'.gif"> <b class="size11"><a href="', $scripturl ,'?topic='.$monitorpun['ID_TOPIC'].'" title="'.censorText($monitorpun['titulo']).'">'.$monitorpun['titulo'].'</a></b>
<br /><p align="right" class="size11" style="margin:0px;padding:0px;"><span>+'.$monitorpun['amount'].'</span> - <a href="', $scripturl ,'?action=profile;user='.$monitorpun['realName'].'" title="'.$monitorpun['realName'].'">'.$monitorpun['realName'].'</a></p><hr />';
}
}
else echo'<b class="size11">',$txt['no_comments_go_home'],'</b><hr />';
echo'</div></div>';

//Mis posts en favorito (últimos)
echo'<div class="publicidad" style="margin-bottom:8px;"><div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r">',$txt['last_favourites_added'],'</div>
<div class="box_rss"><img  src="',$settings['images_url'],'/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 202px;padding:4px;text-align:left">';

if (!empty($context['monitorfav']))
{
$lastfav='';
foreach ($context['monitorfav'] as $monitorfav)
{
    if ($lastfav != $monitorfav['ID_TOPIC'])
    {
        echo'<hr /><img align="absmiddle" title="'.$monitorfav['bname'].'" src="',$settings['images_url'],'/post/icono_'.$monitorfav['ID_BOARD'].'.gif"> <b class="size11"><a title="'.censorText($monitorfav['titulo']).'" href="', $scripturl ,'?topic='.$monitorfav['ID_TOPIC'].'">'.$monitorfav['titulo'].'</a></b>';
        $lastfav = $monitorfav['ID_TOPIC'];
    }
    echo '<p align="right" class="size11" style="margin:0px;padding:0px;">',$txt['monitor_added_by'],': <a href="/?action=profile;user='.$monitorfav['realName'].'" title="'.$monitorfav['realName'].'"><b>'.$monitorfav['realName'].'</b></a></p>';
}
}
else echo'<b class="size11">',$txt['no_comments_go_home'],'</b><hr />';
echo'</div></div>';
echo'</div>';
}
else
echo'<center><div class="box_errors">
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="left">',$txt['monitor_error_1'],'</div>
<div class="box_rss"><img alt="" src="',$settings['images_url'],'/blank.gif" style="width:14px;height: 12px;" border="0" /></div></div>
<div class="windowbg" style="width:380px;padding:4px;">
		<br />
       ',$txt['private_function'],'
		<br />
		<br />
	   <input class="login" style="font-size: 11px;" type="submit" title="',$txt['monitor_go_home'],'" value="',$txt['monitor_go_home'],'" onclick="location.href=\'/\'" />
        <br />
        <br />
        </div></div></center>'; 
}
?>