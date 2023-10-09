<?php
if (!defined('SMF'))
	die('Hacking attempt...');
	
function template_main()
{
	global $context, $settings, $scripturl, $txt, $url, $return;
echo'

<table align="center" style="float: left;" width="723px"><tr>
<td>      
        <div style="height:18px; #height:10px; _height:10px;">
        <table width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Mis post favoritos</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table></div><div class="box_icono" style="width: 100%">';
	
		if (!empty($return))
	{
		echo '<br><center><i>', $return, '</i></center>';
	}
	echo'<form action="/?action=favoritos;sa=delete" method="post">';	
	if (!empty($context['favoritos']))
	{
		
		foreach ($context['favoritos'] as $topic)
		{
		echo '<table width="100%">
		<tr><td width="100%"><div style="float: left;">
		<div class="box_icono4"><img title="', $topic['board']['name'],'" src="/Themes/default/images/post/icono_', $topic['board']['id'],'.gif"></div><a href="'.$url.'/?topic='.$topic['id'].'">'.$topic['subject'].'</a>';
		echo '</div><div align="right"><span class="opc_fav">Creado: ', $topic['time'],' por: ', $topic['poster']['name'],' | ', $topic['puntos'],' pts. |<a title="Enviar a amigo" href="/?action=enviar-a-amigo;topic=', $topic['id'],'"><img src="/Themes/default/images/icons/icono-enviar-mensaje.gif"></a>|</span><input type="checkbox" name="remove_favoritos[]" value="', $topic['id'], '" class="check" /></div>
		</td>
		</tr></table>';
		}
		}
	else{echo'<br><center>No tienes ning&uacute;n post favorito</center>';	}
	echo'</div>';
	if ($context['page_index']) echo'<div class="box_icono" style="width: 100%"><center>', $context['page_index'], '</center></div>';
	if (!empty($context['favoritos'])){
	echo '<p align="right"><span class="size10">Favorito/s Seleccionado/s:</span> <input class="login" name="send" style="font-size: 9px;" value="Eliminar" type="submit"></p></form>';}

	
   echo'<td></tr></table>   
   <table align="center" style="float: left;" width="204px"><tr>
<td>
         <div style="height:18px;">
         <table height="18px" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_b_a">&nbsp;</td>
		<td width="100%" class="titulo_b_b"><em><center>Publicidad</center></em></td>
		<td width="100%" class="titulo_b_c">&nbsp;</td>
		</tr></table>
          </div>
           </div>        
</td></tr></table>
';

}

?>