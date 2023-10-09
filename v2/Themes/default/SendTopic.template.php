<?php

function template_main()
{
	global $context, $settings, $options, $txt, $scripturl;

	echo '<style>.size11{
	font-size:11px; 
}
</style><script language="JavaScript" type="text/javascript">
function showr_email(r_email, comment)
	{	
			if(r_email == \'\')
			{
				alert(\'No has ingresado el e-mail de tu amigo.\');
				return false;
			}		
			if(comment == \'\')
			{
				alert(\'No has ecrito ningun mensaje.\');
				return false;
			}
			
			
			}
	</script>	
<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>
		<font face="Arial">Enviar Post</font></center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="center" class="windowbg"><form action="/?action=enviar-a-amigo;topic=', $context['current_topic'], '.', $context['start'], '" method="post" accept-charset="', $context['character_set'], '">
					<br><font class="size11"><b>E-mail de tu amigo:</b></font><br>
					<input type="text" name="r_email" size="28" maxlength="60" /><br><br>
					<font class="size11"><b>Asunto:</b></font><br>', $context['page_title'], '<br><br>
					<font class="size11"><b>Mensaje:</b></font><br>
					<textarea cols="70" rows="8" wrap="hard" tabindex="6" name="comment">Hola! Te recomiendo que veas este post! 

Saludos!

', $context['user']['name'], '</textarea>

<br /><br><input onclick="return showr_email(this.form.r_email.value, this.form.comment.value);" type="submit" class="login" name="send" value="Recomendar post" />
<br /><br>
		<input type="hidden" name="y_email" size="24" maxlength="50" value="admin@ganamoney.es" />
			<input type="hidden" name="r_name" size="24" maxlength="40" value="eXtreme Zone" />
			<input type="hidden" name="y_name" size="24" maxlength="40" value="eXtreme Zone" />
			<input type="hidden" name="sc" value="', $context['session_id'], '" />
		</form></td>
            
			</tr>
			</table>
	';
}

function template_report(){}

?>