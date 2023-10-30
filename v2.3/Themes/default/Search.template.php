<?php
function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $modSettings;
	
if (!empty($context['search_errors']))
{echo '', implode('<br />', $context['search_errors']['messages']), '<br>';}

echo'
<div class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>' , $txt['183'], '</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

<div style="width: 919px;" class="windowbg" border="0">
<br><form name="buscador" method="GET"><center>
<b class="size11">' , $txt['mods_cat_search'], ':</b>&nbsp;<input type="text" name="action&#61;search2&amp;search"', !empty($context['search_params']['search']) ? ' value="' . $context['search_params']['search'] . '"' : '', ' size="25" />&nbsp;<b class="size11">' , $txt['usuario'] , ':</b>&nbsp;<input type="text" name="autor" value="', $context['search_params']['userspec'].'" size="25" />&nbsp;<b class="size11">' , $txt['orden'] , ':</b>&nbsp;<select name="sort">
									<option value="0qdesc">' , $txt['relevancia'] , '</option>
									<option value="1qdesc">' , $txt['reciente'] , '</option>
									<option value="1qasc">' , $txt['antiguo'] , '</option>
								</select>&nbsp;<b class="size11">' , $txt['categoria'] , ':</b>&nbsp;<select name="categoria"><option value="0" selected="selected">' , $txt['todas'] , '</option>';
	foreach ($context['boards'] as $board){
	echo '<option value="', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['name'], '</option>';}
	echo'</select><br><br><input class="login" style="font-size: 15px; width: 200px;" value="' , $txt['182'], '" title="' , $txt['mods_cat_search'] , '" type="submit"></center></form><br></div></div>';


}

function template_results()
{
	global $context, $settings, $options, $txt, $scripturl;
	if ($context['compact'])
	{
echo'
<div>
<div class="box_buscador">
<div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>' , $txt['183'] ,'</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>

<div style="width: 919px;" class="windowbg" border="0">
<br><form name="buscador" method="GET"><center>
<b class="size11">' , $txt['mods_cat_search'] , ':</b>&nbsp;<input type="text" name="action&#61;search2&amp;search"', !empty($context['search_params']['search']) ? ' value="' . $context['search_params']['search'] . '"' : '', ' size="25" />&nbsp;<b class="size11">' , $txt['usuario'] , ':</b>&nbsp;<input type="text" name="autor" value="', $context['search_params']['userspec'].'" size="20" />&nbsp;<b class="size11">' , $txt['orden'] , ':</b>&nbsp;<select name="sort">
									<option value="0qdesc">' , $txt['relevancia'] , '</option>
									<option value="1qdesc">' , $txt['reciente'] , '</option>
									<option value="1qasc">' , $txt['antiguo'] , '</option>
								</select>&nbsp;<b class="size11">' , $txt['categoria'] , ':</b>&nbsp;<select name="categoria"><option value="0" selected="selected">' , $txt['todas'] , '</option>';
	foreach ($context['boards'] as $board){
	echo '<option value="', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['name'], '</option>';}
	echo'</select><br><br><input class="login" style="font-size: 15px; width: 200px;" value="' , $txt['182'], '" title="' , $txt['mods_cat_search'] , '" type="submit"></center></form><br></div></div></div>
<br>

<div class="box_r_buscador" style="float: left; margin-right:8px;">
<div class="box_title" style="width: 700px;"><div class="box_txt box_r_buscadort"><center>' , $txt['resultado'] , '</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>          
<div class="windowbg" style="width: 698px;">';
		while ($topic = $context['get_topics']())
		{
		echo '<table width="100%"><tr><td width="100%"><div><div class="hov_post"><div style="float: left;"><div class="box_icono4"><img title="', 	$topic['board']['name'], '" src="', $settings['images_url'] ,'/post/icono_', $topic['board']['id'], '.gif"></div> <span title="' , $topic['first_post']['subject'] , '">' , $topic['first_post']['link'] , '</div><div align="right"><font color="#848484">' , $txt['creado'] , ': ' , $topic['first_post']['fecha'] , ' ' , $txt['por'] , ': <b>' , $topic['first_post']['name'] , '</b> | ' , $topic['first_post']['puntos'] , ' ' , $txt['puntos'] , '.</font></div></div></div></td></tr></table>';}}
if (!empty($context['topics'])){}	else
echo '<br><b>' , $txt['search_no_results'], '</b><br><br>
<i>', $txt['search_for_dummies'],'</i><br/>
', $txt['use_the_right_words'],'<br/>
', $txt['use_another_words'],'<br/>
', $txt['use_common_words'],'<br/>
', $txt['use_less_words'],'</span><hr /><br>';
echo'</div>'; 
if ($context['page_index'])
echo'<div class="windowbg" width="100%" style="padding:5px;"><center><b><font size="2">', $context['page_index'], '</font></b></center></div>';
echo'</div><div>

<div class="publicidad" style="float: left;">
<div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r"><center>', $txt['search_ads'],'</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div class="windowbg" style="width: 210px;"><center><script type="text/javascript"><!--
google_ad_client = "pub-7516357570798900";
/* 120x600, creado 26/07/09 */
google_ad_slot = "7444757519";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br></div><br><br></div></div>
<br><br>
';

}

?>