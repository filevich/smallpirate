<?php
function template_manual_above(){}
function template_manual_below(){}

function template_manual_intro()
{

global $context, $settings, $options, $txt, $scripturl, $modSettings, $url;

echo'<script language="JavaScript" type="text/javascript">
function showrequerido(comentario, email)
	{	
			if(comentario == \'\')
			{
				alert(\'',$txt['comment_denunciation'],'\');
				return false;
			}				if(email == \'\')
			{
				alert(\'',$txt['select_post'],'\');
				return false;
			}		
					
			}
	</script>';
	
$context['ID_DEL_POST'] = $_GET['id'];

if ($context['user']['is_guest'])
echo'	<div>
<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>',$txt['denounce_post'],'</center></div>
</div>
		<table align="center" class="windowbg" width="392px">
		<tr class="windowbg">
		<td align="center">
		<br>
   ',$txt['denounce_login'],'
		<br>
		<br>
	    <input class="login" style="font-size: 11px;" type="submit" title="',$txt['principal_page'],'" value="',$txt['principal_page'],'" onclick="location.href=\'',$scripturl,'\'" />
        <br>
        <br>
		</td>
		</tr>
    	</table>
        </div>
        <br><br>'; 

$request = db_query("
                SELECT *
                FROM (smf_messages AS m, smf_members AS user)
                WHERE m.ID_TOPIC = {$context['ID_DEL_POST']}
                AND m.ID_MEMBER = user.ID_MEMBER", __FILE__, __LINE__);
	while ($row = mysql_fetch_assoc($request)){
			$titulo = $row['subject'];
			$id = $row['ID_TOPIC'];
			$usuario = $row['memberName'];		
			}
	mysql_free_result($request);

if ($context['user']['is_logged'])
echo'	<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>',$txt['denounce_post'],'</center></div>
</div>
	<table border="0px" class="windowbg" align="center" width="100%">
	<tr class="windowbg" align="center" ><td class="windowbg" align="center" >
    <form action="',$scripturl,'?action=rz;m=endenuncias" method="post">
			<p align="center" class="size11"><b>',$txt['denounce_to_post'],'</b> <br>
', $id , ' / ', $titulo, '
			<p align="center" class="size11"><b>',$txt['created_by'],'</b> <br>
', $usuario, '
<br><br><font class="size11"><b>',$txt['denounce_reason'],'</b></font><br>
			<select name="razon" style="color: black; background-color: rgb(250, 250, 250); font-size: 12px;">
			<option value="0">',$txt['denounce_repost'],'</option>
			<option value="1">',$txt['denounce_spam'],'</option>
			<option value="2">',$txt['denounce_links'],'</option>
			<option value="3">',$txt['denounce_disrespectful'],'</option>
			<option value="4">',$txt['denounce_personal_information'],'</option>
			<option value="5">',$txt['denounce_mayus'],'</option>
			<option value="6">',$txt['denounce_porn'],'</option>
			<option value="7">',$txt['denounce_gore'],'</option>
			<option value="8">',$txt['denounce_fount'],'</option>
			<option value="9">',$txt['denounce_poor'],'</option>
			<option value="10">',$txt['denounce_pass'],'</option>
			<option value="11">',$txt['denounce_protocol'],'</option>
			<option value="12">',$txt['denounce_other'],'</option>
			</select><br><br>
			<font class="size11"><b>',$txt['denounce_explanation'],'</b></font><br>
			<textarea name="comentario" cols="40" rows="5" wrap="hard" tabindex="6"></textarea><br><font size="1">',$txt['repost_link'],'</font>
<br><br><input onclick="return showrequerido(this.form.comentario.value, this.form.email.value);" class="login" type=submit value="Denunciar Post"><br><input value="', $context['user']['id'] , '" type="hidden" name="ID_MEMBER"><input type="hidden" name="ID_TOPIC" size="25" value="', $id , '">
	</form>
	</td></tr></table>'; 
}
function template_manual_login()
{
        global $scripturl, $txt;


echo'
<div>
<div align="center">
<div class="box_errors">
<div class="box_title" style="width: 390px"><div class="box_txt box_error" align="center">',$txt['denounce_envoy'],'</div>
</div>
	
		<table align="center" class="windowbg" width="392px">
		<tr class="windowbg">
		<td align="center">
		<br>
   ',$txt['denounce_envoy2'],'
		<br>
		<br>
	    <input class="login" style="font-size: 11px;" type="submit" title="',$txt['principal_page'],'" value="',$txt['principal_page'],'" onclick="location.href=\'',$scripturl,'\'" />
        <br>
        <br>
		</td>
		</tr>
    	</table>
        </div></div>';}
?>