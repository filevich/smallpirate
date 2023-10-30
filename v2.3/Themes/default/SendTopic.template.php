<?php

function template_main()
{
	global $context, $settings, $options, $txt, $scripturl, $mbname, $webmaster_email;

	echo '<style>.size11{
	font-size:11px; 
}
</style><script language="JavaScript" type="text/javascript">
function showr_email(r_email, comment)
	{	
			if(r_email == \'\')
			{
				alert(\'',$txt['send_no_friend'],'\');
				return false;
			}		
			if(comment == \'\')
			{
				alert(\'',$txt['send_no_mess'],'\');
				return false;
			}
			
			
			}
	</script>	
<div class="box_buscador">
<div class="box_title" style="width: 919px;"><div class="box_txt box_buscadort"><center>', $txt[send_post], '</center></div>
</div>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="center" class="windowbg"><form action="',$scripturl,'?action=enviar-a-amigo;topic=', $context['current_topic'], '.', $context['start'], '" method="post" accept-charset="', $context['character_set'], '">
					<br><font class="size11"><b>', $txt[email_amigo], ':</b></font><br>
					<input type="text" name="r_email" size="28" maxlength="60" /><br><br>
					<font class="size11"><b>', $txt[Asunto], ':</b></font><br>', $context['page_title'], '<br><br>
					<font class="size11"><b>', $txt[Mensaje], ':</b></font><br>
					<textarea cols="70" rows="8" wrap="hard" tabindex="6" name="comment">', $txt[Mensaje_mail], '

', $context['user']['name'], '</textarea>

<br /><br><input onclick="return showr_email(this.form.r_email.value, this.form.comment.value);" type="submit" class="login" name="send" value="', $txt[Value_recomendar], '" />
<br /><br>
		<input type="hidden" name="y_email" size="24" maxlength="50" value="',$webmaster_email,'" />
			<input type="hidden" name="r_name" size="24" maxlength="40" value="',$mbname,'" />
			<input type="hidden" name="y_name" size="24" maxlength="40" value="',$mbname,'" />
			<input type="hidden" name="sc" value="', $context['session_id'], '" />
		</form></td>
            
			</tr>
			</table>
	';
}

function template_report(){}

?>