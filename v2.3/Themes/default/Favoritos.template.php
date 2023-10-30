<?php
if (!defined('SMF'))
	die('Hacking attempt...');

	
function template_main()
{
	global $context, $settings, $scripturl, $txt, $url, $return, $boardurl;
echo'<table width="757px" style="float: left; margin-right; 8px;"><tr><td>

<div class="box_757">
<div class="box_title" style="width: 757px;"><div class="box_txt box_757-34"><center>', $txt['my_favorites'],'</center></div>
<div class="box_rss"><img alt="" src="',$boardurl,'/Themes/default/images/blank.gif" style="width:16px;height:16px;" border="0"></div></div></div>
<table width="757px" cellpadding="3" cellspacing="1" class="windowbg"><tr><td>';
	
		if (!empty($return))
	{
		echo '<b class="size11">', $return, '</b><hr />';
	}
	echo'<form action="', $scripturl ,'?action=favoritos;sa=delete" method="post">';	
	if (!empty($context['favoritos']))
	{
		
		foreach ($context['favoritos'] as $topic)
		{
		echo '<table width="100%">

		<tr><td width="100%"><div style="float: left;">

		<div class="box_icono4"><img title="', $topic['board']['name'],'" src="', $settings['images_url'] ,'/post/icono_', $topic['board']['id'],'.gif"></div><a href="', $scripturl ,'?topic='.$topic['id'].'">'.substr($topic['subject'],0,40).'</a>';

		echo '</div><div align="right"><span class="opc_fav">Creado: ', $topic['time'],' por: ', $topic['poster']['name'],' | ', $topic['puntos'],' pts. |<a title="Enviar a amigo" href="/?action=enviar-a-amigo;topic=', $topic['id'],'"><img src="',$boardurl,'/Themes/default/images/icons/icono-enviar-mensaje.gif"></a>|</span><input type="checkbox" name="remove_favoritos[]" value="', $topic['id'], '" class="check" /></div></td></tr></table>';
		}
		}
	else{echo'', $txt['no_favorites'],'<hr>';	}

 	if (!empty($context['favoritos'])){
	echo '<hr /><p align="right"><span class="size10">', $txt['selected_favorites'],'</span> <input class="login" name="send" style="font-size: 9px;" value="Eliminar" type="submit" /></p>';}

	
   echo'</form></div></td></tr></table></td></tr></table>
    <table width="160px" style="float: left; margin-right; 8px;"><tr><td>

  <div style="float: left; margin-bottom:8px;" class="img_aletat">
<div class="box_title" style="width: 160px;"><div class="box_txt img_aletat">', $txt['favorites_ads'],'</div>
<div class="box_rss"><img src="',$boardurl,'/Themes/default/images/blank.gif" style="width: 16px; height: 16px;" border="0"></div></div><div class="windowbg" style="width: 150px; padding: 4px;"><center>

</center><br></div></div></td></tr></table>';

}

?>