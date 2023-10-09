<?php

function template_main()
{
	global $txt,$context,$scripturl;

	echo '<style>
.box_icono{
	float:left;
	width: 927px;
	clear:left;
		align: center;
	background-color: #FFFFFF;
	border:#E0E0B3 solid 1px;
	margin: 0px 5px 5px 0px;	}
	
	.box_tit{
	float:left;
	width: 929px;
	align: center;
	clear:left;
	color: #FFFFFF;
	margin: 0px 0px 0px 0px;
	background:url("/Themes/default/images/title_100porciento.gif") no-repeat;
					}
</style>
		
<table align="center" width="926px"><tr>
<td>
	
	<div class="box">
          <div class="box_tit"><em><center>Nube de Tags</center></em></div>
          <div class="box_icono"><br><center><font face="Arial" size="2" color="#000000">En esta nube se reflejan los 100 tags m&aacute;s populares. Cuanto m&aacute;s grande es la palabra, mayor cantidad de veces fue utilizada.</font></center><hr><p align="center">';
     	if(isset($context['poptags']))
  		echo $context['poptags'];
	echo '</p></div>

        </div></td></tr>
    </table>';

}
function template_results()
{
	global $scripturl, $txt, $context;
	
$id = $_GET['id'];
	
	
		while ($row = mysql_fetch_assoc($db))
		{
		$context['count'] = $row['count'];
		$context['nombre'] = $row['tag'];
		}
		mysql_free_result($db);
			
echo'
<table align="center" style="float: left;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>'.$context['count'].' Posts con el tag: '.$context['nombre'].'</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table></div><div class="box_icono" style="width: 100%">';
		foreach ($context['tags_topics'] as $i => $topic)
		{
		echo '<table width="100%">
		<tr><td width="100%"><div style="float: left;">
		<div class="box_icono4"><img border="0" alt="' . $topic['name'] . '" title="' . $topic['name'] . '" src="/Themes/default/images/post/icono_' . $topic['ID_BOARD'] . '.gif"></div>
		<a title="' . $topic['subject'] . '" href="?topic=' . $topic['ID_TOPIC'] . '">' . $topic['subject'] . '</a></div><div align="right"><span class="opc_fav">Creado: ', $topic['time'],' por: ', $topic['user'],' | ', $topic['puntos'],' pts. |<a title="Enviar a amigo" href="/?action=enviar-a-amigo;topic=', $topic['ID_TOPIC'],'"><img src="/Themes/default/images/icons/icono-enviar-mensaje.gif"></a></span></div>
		</td>
		</tr></table>';

		}

echo'</div><td></tr></table>';

//publicidad
echo'<table align="center" style="float: left;" width="204px"><tr>
<td>
         <div style="height:18px;">
         <table height="18px" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Publicidad</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
           <div class="box_icono" style="width: 100%;"><center></center>
		   </div></div>        
</td></tr></table>';

}
function template_addtag()
{
		global $scripturl, $txt, $context;
	echo '<table align="center" width="190%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial" size="+1" color="#FFFFFF">Agregar tags</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>	
		<table align="center" class="windowbg" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr class="windowbg">
			<td style="padding: 3ex;"><center>
		<form method="POST" action="/?action=tags;sa=addtag2">
Tags: <input type="text" name="tag" size="64" maxlength="100" /><br>
<div class="smalltext">Solamente escribir una palabra.</div>
    <input type="hidden" name="topic" value="', $context['tags_topic'], '" /><br>
    <input class="login" type="submit" value="Agregar tags" name="submit" />
</form></center>
			</td>		</tr>
	</table>
	';

}
function template_admin_settings()
{
	global $scripturl, $txt, $modSettings;

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