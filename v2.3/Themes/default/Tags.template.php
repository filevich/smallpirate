<?php



function template_main()

{

	global $txt,$context,$scripturl, $boardurl;



	echo '<style>
.box_icono{
	float:left;
	width: 903px;
	clear:left;
	align: center;
	margin: 0px 5px 5px 0px;	}

	.box_tit{
	float:left;
	width: 903px;
	align: center;
	clear:left;
	color: #FFFFFF;
	margin: 0px 0px 0px 0px;	}
</style>

		

<div align="center"><div class="box_buscador"><div class="box_title" style="width: 921px;"><div class="box_txt box_buscadort"><center>',$txt['smftags_popular'],'</center></center></div><div class="box_rss"><img alt="" src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 14px;height:12px;" border="0" /></div></div><table width="921px" class="windowbg"><tr>

          <div class="box_icono" style="word-wrap: break-word;"><br><center><font face="Arial" size="2" color="#000000">',$txt['tags_popularity'],'</font></center><hr><p align="center">';

     	if(isset($context['poptags']))

  		echo $context['poptags'];

	echo '</p><br /><br /></td></tr></table></div></div>'; 



}

function template_results()

{

	global $scripturl, $txt, $context, $boardurl;
			

echo'<table width="757px" style="float: left; margin-right; 8px;"><tr><td>

<div class="box_757">
<div class="box_title" style="width: 757px;"><div class="box_txt box_757-34">',$txt['post_with_tag'],': ',$context['page_title'],'</div>
<div class="box_rss"><img alt="" src="',$boardurl,'/Themes/default/images/blank.gif" style="width:16px;height:16px;" border="0"></div></div></div>
<table width="757px" cellpadding="3" cellspacing="1" class="windowbg"><tr><td>';

		foreach ($context['tags_topics'] as $i => $topic)

		{

		echo '<table width="100%">

		<tr><td width="100%"><div style="float: left;">

		<div class="box_icono4"><img border="0" alt="' . $topic['name'] . '" title="' . $topic['name'] . '" src="',$boardurl,'/Themes/default/images/post/icono_' . $topic['ID_BOARD'] . '.gif"></div>

		<a title="' . $topic['subject'] . '" href="', $scripturl ,'?topic=' . $topic['ID_TOPIC'] . '">' . $topic['subject'] . '</a></div><div align="right"><span class="opc_fav">Creado: ', $topic['time'],' por: ', $topic['user'],' | ', $topic['puntos'],' pts. | <a title="Enviar a amigo" href="', $scripturl ,'?action=enviar-a-amigo;topic=', $topic['ID_TOPIC'],'"><img src="',$boardurl,'/Themes/default/images/icons/icono-enviar-mensaje.gif"></a></span></div>

		</td>

		</tr></table>';



		}



 echo'</form></div></td></tr></table></td></tr></table>';



//publicidad

echo'<table width="160px" style="float: left; margin-right; 8px;"><tr><td>

  <div style="float: left; margin-bottom:8px;" class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">',$txt['publicity'],'</div>
<div class="box_rss"><img src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" style="width: 150px; padding: 4px;"><center>
<!--***Publicidad aqui***//-->
</center><br></div></div></td></tr></table>';
}

function template_addtag()

{

		global $scripturl, $txt, $context, $boardurl;

	echo '<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>',$txt['add_new_tag'],'</center></div>
</div>

		<table align="center" class="windowbg" border="0" cellpadding="0" cellspacing="0" width="100%">

		<tr class="windowbg">

			<td style="padding: 3ex;"><center>

		<form method="POST" action="',$scripturl,'?action=tags;sa=addtag2">

Tags: <input type="text" name="tag" size="64" maxlength="100" /><br>

<div class="smalltext">',$txt['only_one_word'],'</div>

    <input type="hidden" name="topic" value="', $context['tags_topic'], '" /><br>

    <input class="login" type="submit" value="Agregar tags" name="submit" />

</form></center>

			</td>		</tr>

	</table>

	';



}

function template_admin_settings()

{

	global $scripturl, $txt, $modSettings, $boardurl;



	echo '

	<table border="0" width="80%" cellspacing="0" align="center" cellpadding="4" class="tborder">

		<tr class="titlebg">

			<td>' . $txt['smftags_settings']. '</td>

		</tr>

		<tr class="windowbg">

			<td>

			<b>' . $txt['smftags_settings']. '</b><br />

			<form method="post" action="' . $scripturl . '?action=tags;sa=admin2">

				<table border="0" width="100%" cellspacing="0" align="center" cellpadding="4">

				<tr><td width="30%">' . $txt['smftags_set_mintaglength'] . '</td><td><input type="text" name="smftags_set_mintaglength" value="' .  $modSettings['smftags_set_mintaglength'] . '" /></td></tr>

				<tr><td width="30%">' . $txt['smftags_set_maxtaglength'] . '</td><td><input type="text" name="smftags_set_maxtaglength" value="' .  $modSettings['smftags_set_maxtaglength'] . '" /></td></tr>

				<tr><td width="30%">' . $txt['smftags_set_maxtags'] . '</td><td><input type="text" name="smftags_set_maxtags" value="' .  $modSettings['smftags_set_maxtags'] . '" /></td></tr>

					</table>



				<input class="login" type="submit" name="savesettings" value="', $txt['smftags_savesettings'],  '" />

			</form>

			</td>

		</tr>

</table>';





}



function template_suggesttag()

{

	global $scripturl, $txt;



	echo '<div class="tborder" >

<form method="POST" action="', $scripturl, '?action=tags;sa=suggest2">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#FFFFFF" width="100%" height="129">
  <tr>
    <td width="50%" colspan="2" height="19" align="center" class="catbg">
    <b>', $txt['smftags_suggest'], '</b></td>
  </tr>
  <tr>
    <td width="28%" height="22" class="windowbg2" align="right"><span class="gen"><b>', $txt['smftags_tagtosuggest'], '</b></span></td>
    <td width="72%" height="22" class="windowbg2"><input type="text" name="tag" size="64" maxlength="100" /></td>
  </tr>
  <tr>
    <td width="28%" colspan="2" height="26" align="center" class="windowbg2">
    <input class="login" type="submit" value="', $txt['smftags_suggest'], '" name="submit" /></td>
  </tr>
</table>
</form>
</div>';
}
?>