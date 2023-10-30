<?php
function template_shop_above(){}
function template_shop_below(){}
function template_main()
{
global $txt, $context, $modSettings, $scripturl, $settings, $txt;
Header("Location: $scriptpurl");
echo '<a href="#" onclick="$(\'#amount\').val(15)"></a>';
}

function template_message()
{
global $context, $txt, $scripturl;
echo '
	<div>
		<table align="center" width="392px" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		
		<td width="100%" class="box_title"><center>', $txt['points'], '</center></td>
		
		</tr></table>
		<table align="center" class="windowbg" width="392px">
		<tr class="windowbg">
		<td align="center">
		<br>
       ', $context['shop_buy_message'], '
		<br>
		<br>
	    <input class="login" style="font-size: 11px;" type="submit" title="', $txt['go_back_to_topic'], '" value="', $txt['go_back_to_topic'], '" onclick="location.href=\'',$scripturl,'?topic='.$_GET['topic'].'\'" /> <input class="login" style="font-size: 11px;" type="submit" title="', $txt['go_to_index'], '" value="', $txt['go_to_index'], '" onclick="location.href=\'',$scripturl,'\'" />
        <br>
        <br>
		</td>
		</tr>
    	</table>
    </div>';
}
?>