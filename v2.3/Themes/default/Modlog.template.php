<?php

function traduccion($valor)
{
			
$valor = str_replace("topic", "Post", $valor);
$valor = str_replace("message", "ID", $valor);
$valor = str_replace("subject", "Titulo", $valor);
$valor = str_replace("member", "Miembro", $valor);
$valor = str_replace("causa", "<b style='color: #FF0000;'>Causa</b>", $valor);
$valor = str_replace("board_from", "Estaba en", $valor);
$valor = str_replace("board_to", "Movido a", $valor);

return $valor;
}

function template_main()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
		<form action="',$scripturl,'?action=hist-mod" method="post" accept-charset="', $context['character_set'], '">
			<input type="hidden" name="order" value="', $context['order'], '" />
			<input type="hidden" name="dir" value="', $context['dir'], '" />
			<input type="hidden" name="start" value="', $context['start'], '" />
<div class="box_buscador">
<div class="box_title" style="width: 931px;"><div class="box_txt box_buscadort"><center>', $txt['mod_log'],'</center></div>
<div class="box_rss"><img  src="/Themes/default/images/blank.gif" style="width: 14px; height: 12px;" border="0"></div></div>
<div style="width: 919px;padding:5px;" class="windowbg" border="0">				';


	foreach ($context['entries'] as $entry)
	{
		foreach ($entry['extra'] as $key => $value)
		echo '<font class="size12"><b>'. traduccion($key) . '</b>: '. $value .' ';
		echo '<br>'. $entry['action'] .' <b>Por:</b> '. $entry['moderator']['link'] .'</font><br><hr>';
	}

echo'</div>';
if ($context['user']['is_admin'])
echo '<p align="right"><input class="login" type="submit" name="removeall" value="', $txt['maintenance'],'" /></p>';
echo'</div><input type="hidden" name="sc" value="', $context['session_id'], '" /></form>';
}

?>