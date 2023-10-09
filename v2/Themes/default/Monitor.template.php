<?
// Spirate Sección Monitoreo - Hay que hacer:
//////////////////////////////////////////////
// Sección Últimos comentarios de tus posts
///////////////////////////////////////////////////////////
//-Que pille las ids y titulos de los topics que haya creado el usuario en smf_topics (revisar por fecha si hace menos x tiempo)
//-Que apartir de las ids pille los comentarios en cw_comentarios
//-Usar las variables de abajo para mostrar la fecha (falta la variable $coment['fecha'] ya que falta el query)
//
///////////////////////////////////////////
// Sección Últimos Puntos obtenidos
///////////////////////////////////////////////////////////
//-Que apartir de las ids de los últimos topics pille el id del user que le ha dado los puntos y cuantos en cw_puntos
//
// Hay que reemplazar los distintos datos indicados abajo por sus variables
// Hay que arreglar la parte de abajo
function template_main()
{
	global $context, $settings, $options, $scripturl, $modSettings;

//$mesesano2 = array("1","2","3","4","5","6","7","8","9","10","11","12") ;
//$diames2 = date(j,$coment['fecha']); $mesano2 = date(n,$coment['fecha']) - 1 ; $ano2 = date(Y,$coment['fecha']);
//$seg2=date(s,$coment['fecha']); $hora2=date(H,$coment['fecha']); $min2=date(i,$coment['fecha']);

	echo'<div style="float:left;width:708px;"><div class="box_r_buscador" style="margin-right:8px;margin-botton:8px;">

<div class="box_title" style="width: 700px;"><div class="box_txt box_r_buscadort">&Uacute;ltimos comentarios de tus posts</div><div class="box_rss"><img alt="" src="/Themes/default/images/blank.gif" style="width:14px;height:12px;" border="0" /></div></div><div class="windowbg" style="width:690px;padding:4px;text-align:left"><table><tr><td valign="top" width="16"><img alt="" src="/Themes/default/images/post/icono_25.gif" title="Descargas"></td><td><b class="size11"><a title="TITULO" href="URLPOST">TÍTULO</a></b><div class="size11">FECHA Y HORA : <a href="URLCOMENTARIO">TEXTO</a></div></td></tr></table></div></div><div class="box_r_buscador" style="margin-right:8px;">

<div class="box_title" style="width: 700px;"><div class="box_txt box_r_buscadort">&Uacute;ltimos comentarios de tus im&aacute;genes</div>
<div class="box_rss"><img alt="" src="/Themes/default/images/blank.gif" style="width:14px;height:12px;" border="0" /></div></div><div class="windowbg" style="width:690px;padding:4px;text-align:left;"><table><b class="size11">No se han encontrado resultados...</b><hr /></table></div></div></div><div style="float:left;width: 212px;margin-bottom:8px;"><div class="publicidad" style="margin-bottom:8px;"><div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r">&Uacute;ltimos puntos obtenidos</div><div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div><div class="windowbg" style="width: 202px;padding:4px;text-align:left;"><img alt="Descargas" title="Descargas" src="/Themes/default/images/post/icono_25.gif" /> <b><a href="URLPOST" title="TITULO">TÍTULO</a></b><br /><p align="right" class="size11" style="margin:0px;padding:0px;"><b><span style="color:green;">+PUNTOS</span> - <a href="URLPERFIL" title="NOMBREAUTOR"><span style="color:orange;">AUTOR</span></a></b></p><hr /></div></div><div class="publicidad" style="margin-bottom:8px;"><div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r">Mis posts en favorito (&uacute;ltimos)</div><div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div><div class="windowbg" style="width: 202px;padding:4px;text-align:left"><img alt="Descargas" title="Descargas" src="/Themes/default/images/post/icono_25.gif" /> <b><a href="URLPOST" title="TITULOPOST">TITULOPOST</a></b><br /><p align="right" class="size11" style="margin:0px;padding:0px;"><b>Lo agreg&oacute;: <a href="URLPERFIL" title="NOMBREUSUARIO"><span style="color:orange;">USUARIO</span></a></b></p><hr /></div></div><div class="publicidad" style="margin-bottom:8px;"><div class="box_title" style="width: 212px;"><div class="box_txt publicidad_r">Yo en amigos (&uacute;ltimos)</div><div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div><div class="windowbg" style="width: 202px;padding:4px;text-align:left"><b class="size11">No se han encontrado resultados...</b><hr /></div></div></div>
</td>
</tr>
</table>
</div>
<b></b></b></b>';
}
?>