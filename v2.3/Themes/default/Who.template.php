<?php

function template_main()
{
	global $context, $settings, $options, $scripturl, $txt;


	echo'<div class="box_buscador">
<div class="box_title" style="width: 931px;"><div class="box_txt box_buscadort"><center>', $context['num_users_online'], ' ',$txt['who_user'],'</center></div>
</div>


<div style="width: 100%; background-color: #FFFFFF;border:1px solid #CCC;">
', implode(' ', $context['list_users_online']),'</div>
	<br />
		<table width="222px" border="0" cellspacing="0" cellpadding="0" height="17px">
  <tr>
    <td style=" background: url(',$settings['images_url'],'/buttons/pag_bg.gif) no-repeat; ">
	<font size="1" color="#FFFFFF">&nbsp; ',$txt['who_pages'],'&nbsp;&nbsp;&nbsp;&nbsp; ', $context['page_index'], '</font></td>
    </tr>
  </table>';
	
	

}

?>