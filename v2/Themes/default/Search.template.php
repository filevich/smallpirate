<?php
function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
	
if (!empty($context['search_errors']))
{echo '', implode('<br />', $context['search_errors']['messages']), '<br>';}

echo'
<div class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>Buscador</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

<div style="width: 919px;" class="windowbg" border="0">
<form name="buscador" method="GET"><center>
<b class="size11">Buscar:</b>&nbsp;<input type="text" name="action&#61;search2&amp;search"', !empty($context['search_params']['search']) ? ' value="' . $context['search_params']['search'] . '"' : '', ' size="25" />&nbsp;<b class="size11">Usuario:</b>&nbsp;<input type="text" name="autor" value="', $context['search_params']['userspec'].'" size="25" />&nbsp;<b class="size11">Orden:</b>&nbsp;<select name="sort">
									<option value="0qdesc">Por revelancia</option>
									<option value="1qdesc">M&aacute;s reciente</option>
									<option value="1qasc">M&aacute;s antiguo</option>
								</select>&nbsp;<b class="size11">Categor&iacute;as:</b>&nbsp;<select name="categoria"><option value="0" selected="selected">Todas</option>';
	foreach ($context['boards'] as $board){
	echo '<option value="', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['name'], '</option>';}
	echo'</select><br><br><input class="login" style="font-size: 15px; width: 200px;" value="', $txt[182], '" title="Buscar" type="submit"></center></form></div></div>';


}

function template_results()
{
	global $context, $settings, $options, $txt, $scripturl;
	if ($context['compact'])
	{
echo'
<div>
<div class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>Buscador</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

<div style="width: 919px;" class="windowbg" border="0">
<form name="buscador" method="GET"><center>
<b class="size11">Buscar:</b>&nbsp;<input type="text" name="action&#61;search2&amp;search"', !empty($context['search_params']['search']) ? ' value="' . $context['search_params']['search'] . '"' : '', ' size="25" />&nbsp;<b class="size11">Usuario:</b>&nbsp;<input type="text" name="autor" value="', $context['search_params']['userspec'].'" size="25" />&nbsp;<b class="size11">Orden:</b>&nbsp;<select name="sort">
									<option value="0qdesc">Por revelancia</option>
									<option value="1qdesc">M&aacute;s reciente</option>
									<option value="1qasc">M&aacute;s antiguo</option>
								</select>&nbsp;<b class="size11">Categor&iacute;as:</b>&nbsp;<select name="categoria"><option value="0" selected="selected">Todas</option>';
	foreach ($context['boards'] as $board){
	echo '<option value="', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['name'], '</option>';}
	echo'</select><br><br><input class="login" style="font-size: 15px; width: 200px;" value="', $txt[182], '" title="Buscar" type="submit"></center></form></div></div></div>
<br>

<div class="box_r_buscador" style="float: left; margin-right:8px;">
<div class="box_title" style="width: 700px;"><div class="box_txt box_r_buscadort"><center>Resultado de su b&uacute;squeda</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>          
<div class="windowbg" style="width: 698px;">';
		while ($topic = $context['get_topics']())
		{
		echo '<table width="100%"><tr><td width="100%"><div><div style="float: left;"><div class="box_icono4"><img title="', 	$topic['board']['name'], '" src="/Themes/default/images/post/icono_', $topic['board']['id'], '.gif"></div> <span title="' , $topic['first_post']['subject'] , '">' , $topic['first_post']['link'] , '</div><div align="right" class="opc_fav">Creado: ' , $topic['first_post']['fecha'] , ' por: ' , $topic['first_post']['name'] , ' | ' , $topic['first_post']['puntos'] , ' pts.</div></div></td></tr></table>';}}
if (!empty($context['topics'])){}	else
echo '<center><br><img src="/Themes/default/images/icons/show_sticky.gif" border="0" alt="', $txt['search_no_results'], '" title="', $txt['search_no_results'], '"> ', $txt['search_no_results'], '<br><br></center>';
echo'</div>'; 
if ($context['page_index'])
echo'<div class="windowbg" width="100%"><center>', $context['page_index'], '</center></div>';
echo'</div><div>

<div class="publicidad" style="float: left;">
<div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r"><center>Publicidad</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 210px;"><center></center></div></div></div>
<br><br>
';

}

?>