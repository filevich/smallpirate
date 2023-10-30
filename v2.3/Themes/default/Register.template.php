<?php
// Version: 1.1.5; Register

function template_before()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings, $user_info, $no_avatar ;


echo '<style>.size11{
	font-size:11px; 
}
</style>

<script src="http://www.prototypejs.org/assets/2008/1/25/prototype-1.6.0.2.js" type="text/javascript"></script>


<script type="text/javascript"><!--
 //<![CDATA[
function comprobar_nick(nick) 
{
  var url = \'Sources/Ajax.php?ajax=comprobar_usuario\';
  var pars = ("username=" + nick);
  var myAjax = new Ajax.Updater(\'comprobar_mensaje\', url, { method: \'get\', parameters: pars});
}
// -->
</script>

<script type="text/javascript"><!--
 //<![CDATA[
function comprobar_email(email) 
{
  var url = \'Sources/Ajax.php?ajax=comprobar_email\';
  var pars = ("email=" + email);
  var myAjax = new Ajax.Updater(\'comprobar_email\', url, { method: \'get\', parameters: pars});
}
// -->
</script>


<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
	function showtags(user, passwrd1, passwrd2, email, f, location, bday2, bday1, bday3, visual_verification_code)
	{	
			if(user == \'\')
			{
				alert(\'',$txt['reg_alert1'],'\');
				return false;
			}
			if(passwrd1 == \'\')
			{
				alert(\'',$txt['reg_alert2'],'\');
				return false;
			}
			
			if(passwrd2 == \'\')
			{
				alert(\'',$txt['reg_alert3'],'\');
				return false;
			}
						
			if(email == \'\')
			{
				alert(\'',$txt['reg_alert4'],'\');
				return false;
			}
			if(f.usertitle.options.selectedIndex==-1 || f.usertitle.options[f.usertitle.options.selectedIndex].value==-1)
			{
				alert(\'',$txt['reg_alert5'],'\');
				return false;
			}
			if(location == \'\')
			{
				alert(\'',$txt['reg_alert6'],'\');
				return false;
			}
			if(bday2 == \'\')
			{
				alert(\'',$txt['reg_alert7'],'\');
				return false;
			}
			if(bday1 == \'\')
			{
				alert(\'',$txt['reg_alert8'],'\');
				return false;
			}
			if(bday3 == \'\')
			{
				alert(\'',$txt['reg_alert9'],'\');
				return false;
			}
			if(visual_verification_code == \'\')
			{
				alert(\'',$txt['reg_alert10'],'\');
				return false;
			}
			}
			
			function verifyAgree()
	{
		if (document.forms.creator.passwrd1.value != document.forms.creator.passwrd2.value)
		{
			alert("',$txt['reg_alert11'],'");
			return false;
		}';
		
if ($context['require_agreement'])
		echo '

		if (!document.forms.creator.regagree.checked)
		{
			alert("',$txt['reg_alert12'],'");
			return false;
		}';


	echo '

		return true;
	}';

	if ($context['require_agreement'])
		echo '
	function checkAgree()
	{
		document.forms.creator.regSubmit.disabled = isEmptyText(document.forms.creator.user) || isEmptyText(document.forms.creator.email) || isEmptyText(document.forms.creator.passwrd1) || !document.forms.creator.regagree.checked;
		setTimeout("checkAgree();", 1000);
	}
	setTimeout("checkAgree();", 1000);';

	if ($context['visual_verification'])
	{
		echo '
	function refreshImages()
	{
		var new_url = new String("', $context['verificiation_image_href'], '");
		new_url = new_url.substr(0, new_url.indexOf("rand=") + 5);

		// Quick and dirty way of converting decimal to hex
		var hexstr = "0123456789abcdef";
		for(var i=0; i < 32; i++)
			new_url = new_url + hexstr.substr(Math.floor(Math.random() * 16), 1);';

		if ($context['use_graphic_library'])
			echo '
		document.getElementById("verificiation_image").src = new_url;';
		else
			echo '
		document.getElementById("verificiation_image_1").src = new_url + ";letter=1";
		document.getElementById("verificiation_image_2").src = new_url + ";letter=2";
		document.getElementById("verificiation_image_3").src = new_url + ";letter=3";
		document.getElementById("verificiation_image_4").src = new_url + ";letter=4";
		document.getElementById("verificiation_image_5").src = new_url + ";letter=5";';
		echo '
	}';
	}

	echo '
// ]]></script>
<form action="',$scripturl,'?action=register2" method="post" accept-charset="', $context['character_set'], '" name="creator" id="creator" onsubmit="return verifyAgree();">

		<div style="width: 38%; float: left; padding: 0px 5px 0px 0px;">
		<div>
		
<div class="box_354">
<div class="box_title" style="width:354px;"><div class="box_txt box_354-34">', $txt[Aclaracion_registro], '</div>
</div></div>


	<table border="0" width="100%" cellpadding="3" cellspacing="0" class="windowbg">
<tr class="windowbg">
			<td width="100%"><ont class="size11">', $txt[Mensaje_aclaracion], '</td></tr></table>
			</div>
					<div style="padding: 5px 0px 5px 0px;">
		
<div class="box_354">
<div class="box_title" style="width:354px;"><div class="box_txt box_354-34">', $txt[Destacados], '</div>
</div></div>

	<table border="0" width="100%" cellpadding="3" cellspacing="0" class="windowbg">
<tr class="windowbg">
			<td width="100%"><ont class="size10"><font class="size11"><p align="center">'; ssi_destacado(); echo'
</p></font></td></tr></table>
			</div></div>
		
					<div style="width: 60%; float: left; padding: 0px 8px 8px 0px;">
<div class="box_560">
<div class="box_title" style="width: 558px;"><div class="box_txt box_560-34"><center>', $txt[Registro_en_foro], '</center></div>
<div class="box_rss"></div></div>
		
	<table border="0" width="100%" cellpadding="3" cellspacing="0" class="windowbg">
<tr class="windowbg">
			<td width="100%">
				<table align="center" cellpadding="3" cellspacing="0" border="0" width="100%">
					<tr>
						<td align="right" width="40%">
						<font class="size11">* <b>', $txt[Nick], '</b></font>
						</td>
						<td>
							<input type="text" name="user" size="18" onblur="comprobar_nick(this.value)" tabindex="', $context['tabindex']++, '" maxlength="20" /><span id="comprobar_mensaje"></span>

								</td>
					</tr><tr>
						<td align="right" width="40%">
						<font class="size11">* <b>', $txt[Password], '</b></font>
						</td>
						<td>
							<input maxlength="30" type="password" name="passwrd1" size="30" tabindex="', $context['tabindex']++, '" />
						</td>
					</tr><tr>
						<td align="right" width="40%">
						<font class="size11">* <b>', $txt[confirmar_Password], '</b></font>
						</td>
						<td>
							<input type="password" maxlength="30" name="passwrd2" size="30" tabindex="', $context['tabindex']++, '" />
						</td>
					</tr><tr>
						<td align="right" width="40%">
						<font class="size11">* <b>', $txt[Email], '</b></font>
							</td>
						<td>
							<input type="text" onblur="comprobar_email(this.value)" name="email" size="30" tabindex="', $context['tabindex']++, '" /> <span id="comprobar_email"></td></tr>';
							
echo '<tr>
								<td align="right" width="40%"><font class="size11">* <b>', $txt[pais], ' </b></font></td>
								<td><select tabindex="', $context['tabindex']++, '" name="usertitle" id="usertitle">
						<option value="-1">', $txt[Seleccionar_pais], '</option>
						<option value="ar">', $txt[Pais1], '</option>
						<option value="bo">', $txt[Pais2], '</option>
						<option value="br">', $txt[Pais3], '</option>
						<option value="cl">', $txt[Pais4], '</option>
						<option value="co">', $txt[Pais5], '</option>
						<option value="cr">', $txt[Pais6], '</option>
						<option value="cu">', $txt[Pais7], '</option>
						<option value="ec">', $txt[Pais8], '</option>
						<option value="es">', $txt[Pais9], '</option>
						<option value="gt">', $txt[Pais10], '</option>
						<option value="it">', $txt[Pais11], '</option>
						<option value="mx">', $txt[Pais12], '</option>
						<option value="py">', $txt[Pais13], '</option>
						<option value="pe">', $txt[Pais14], '</option>
						<option value="pt">', $txt[Pais15], '</option>
						<option value="pr">', $txt[Pais16], '</option>
						<option value="uy">', $txt[Pais17], '</option>
						<option value="ve">', $txt[Pais18], '</option>
						<option value="ot">', $txt[Pais19], '</option>						
						</select></td>
							</tr>
							
							<tr>
								<td align="right" width="40%"><font class="size11">* <b>', $txt[Ciudad], ' </b></font></td>
								<td><input tabindex="', $context['tabindex']++, '" type="text" name="location" size="30" value="', $context['member']['location'], '" /></td>
							</tr>
							<tr>
						<td align="right" width="40%"><font class="size11">* <b>', $txt[231], ': </b></font></td>
							    <td>
									<select name="gender" tabindex="', $context['tabindex']++, '" class="select" size="1">
										<option value="1"', ($context['member']['gender']['name'] == 'm' ? ' selected="selected"' : ''), '>', $txt[238], '</option>
										<option value="2"', ($context['member']['gender']['name'] == 'f' ? ' selected="selected"' : ''), '>', $txt[239], '</option>
									</select>
								</td>
							</tr><tr>
								<td colspan="2"></td>
							</tr>
								
						<tr>
								<td align="right" width="40%">
										<font class="size11">* <b>', $txt[Fecha_nacimiento], '</b></font>
									<div class="smalltext">', $txt[dia_mes_ano], '</div>
								</td>
								<td class="smalltext">
									<input tabindex="', $context['tabindex']++, '" type="text" name="bday2" size="2" maxlength="2" value="', $context['member']['birth_date']['day'], '" />
									<input tabindex="', $context['tabindex']++, '" type="text" name="bday1" size="2" maxlength="2" value="', $context['member']['birth_date']['month'], '" />
									<input tabindex="', $context['tabindex']++, '" type="text" name="bday3" size="4" maxlength="4" value="', $context['member']['birth_date']['year'], '" />
								</td>
							</tr>
							<tr>
								<td align="right" width="40%"><font class="size11"><b>', $txt[Sitio_Web], ' </b></font></td>
								<td><input tabindex="', $context['tabindex']++, '" type="text" name="websiteTitle" size="30" value="http://" /></td>
							</tr>
							
							<tr>

								<td align="right" width="40%"><font class="size11"><b>', $txt['referrals_who'], ':</b></font></td>

								<td><input tabindex="', $context['tabindex']++, '"name="referredby" id="referredby" type="text" size="30" value="', ( !empty($context['referrals']['referred_by_name']) ? $context['referrals']['referred_by_name'] : '' ) ,'" />

								<img src="', $settings['images_url'], '/icons/assist.gif" border="0" align="absmiddle" alt="', $txt['referrals_findreferrer'] ,'" /> <a href="', $scripturl, '?action=findmember;input=referredby;sesc=', $context['session_id'], '" onclick="document.getElementById(\'referredby\').value=\'\';document.getElementById(\'referredon\').innerHTML =\'&nbsp;\';return reqWin(this.href, 350, 400);"><font class="size11"> ', $txt['referrals_findreferrer'] ,'</font></a><span id="referredon" class="smalltext">', ( !empty($context['referrals']['referred_date']) ? $txt['referrals_on'].' '.$context['referrals']['referred_date'] : '' ) ,'</span></td>

				</tr>
														<tr>
								<td align="right" width="40%">	<font class="size11"><b>', $txt['Mensaje_personal'], ' </b></font></td>
								<td><input tabindex="', $context['tabindex']++, '" type="text" name="personalText" size="30" maxlength="21" value="" /></td>
							</tr>					<tr>
								<td align="right" width="40%">	<font class="size11"><b>', $txt['Avatar'], ': </b></font></td>
								<td><input tabindex="', $context['tabindex']++, '" type="text" name="avatar" size="30" value="'.$no_avatar.'" /></td>
							</tr>';
	echo '
						</td>
					</tr>';	
										
					if ($context['visual_verification'])
	{
		echo '
					<tr valign="top">
						<td width="40%" align="right" valign="top">
								<font class="size11">* <b>', $txt['Captcha'], ':</b></font>
							</td>
						<td>';
		if ($context['use_graphic_library'])
			echo '
							<img src="', $context['verificiation_image_href'], '" alt="', $txt['visual_verification_description'], '" id="verificiation_image" /><br />';
		else
			echo '
							<img src="', $context['verificiation_image_href'], ';letter=1" alt="', $txt['visual_verification_description'], '" id="verificiation_image_1" />
							<img src="', $context['verificiation_image_href'], ';letter=2" alt="', $txt['visual_verification_description'], '" id="verificiation_image_2" />
							<img src="', $context['verificiation_image_href'], ';letter=3" alt="', $txt['visual_verification_description'], '" id="verificiation_image_3" />
							<img src="', $context['verificiation_image_href'], ';letter=4" alt="', $txt['visual_verification_description'], '" id="verificiation_image_4" />
							<img src="', $context['verificiation_image_href'], ';letter=5" alt="', $txt['visual_verification_description'], '" id="verificiation_image_5" />';
		echo '
							<input type="text" name="visual_verification_code" maxlength="5" size="5" tabindex="', $context['tabindex']++, '" /> <a class="smalltext" href="', $scripturl ,'?action=registrarse" onclick="refreshImages(); return false;">', $txt['Refresh'], '</a>
					
						</td>
					</tr>';
	}




	if ($context['require_agreement'])

		echo '
<tr valign="top">
						<td align="right" width="40%" align="top">&nbsp;</td>
						<td>							<label for="regagree"><input tabindex="', $context['tabindex']++, '" type="checkbox" name="regagree" onclick="checkAgree();" id="regagree" class="check" /> <a href="', $scripturl ,'?action=terminos-y-condiciones" target="_blank">', $txt['Acepto_terminos'], '</a></label>
						</td>
		</tr>

	';
	echo '

				</table>
					<br />
	<div align="center"> 	<font class="size11" style="color: red;">* ', $txt['Campos_obligatorios'], '</font><br><br>
		<input onclick="return showtags(this.form.user.value, this.form.passwrd1.value, this.form.passwrd2.value, this.form.email.value, this.form, this.form.location.value, this.form.bday2.value, this.form.bday1.value, this.form.bday3.value, this.form.visual_verification_code.value);" class="login" type="submit" name="regSubmit" value="', $txt[97], '" />
	</div>
</form>
			</td>
		</tr>
	</table></div>';
	echo '
';
	if ($context['require_agreement'])
		echo '
<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
	document.forms.creator.regagree.checked = true;
// ]]></script>';
}


// Luego del registro, la activacion :P
function template_after()
{
	global $context, $settings, $options, $txt, $scripturl;

	// Aviso al usuario para que active su cuenta
	echo '
<div align="center">
<div class="box_errors">
<div class="box_title" style="width: 390px"><div class="box_txt box_error">', $txt['activar'], '</div>
<div class="box_rss"></div></div>
<div class="box-bg" style="width: 378px" align="center">
', $context['description'], '</div></div>';
}
function template_coppa(){}
function template_coppa_form(){}
function template_verification_sound()
{}
function template_admin_register()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;
	echo '
	<form action="', $scripturl, '?action=regcenter" method="post" accept-charset="', $context['character_set'], '" name="postForm" id="postForm">
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			function onCheckChange()
			{
				if (document.forms.postForm.emailActivate.checked)
				{
					document.forms.postForm.emailPassword.disabled = true;
					document.forms.postForm.emailPassword.checked = true;
				}
				else
					document.forms.postForm.emailPassword.disabled = false;
			}
		// ]]></script>
		<table border="0" cellspacing="0" cellpadding="4" align="center" width="70%" class="tborder">
			<tr class="titlebg">
				<td colspan="2" align="center">', $txt['admin_browse_register_new'], '</td>
			</tr>';
	if (!empty($context['registration_done']))
		echo '
			<tr class="windowbg2">
				<td colspan="2" align="center"><br />
					', $context['registration_done'], '
				</td>
			</tr><tr class="windowbg2">
				<td colspan="2" align="center"><hr /></td>
			</tr>';
	echo '
			<tr class="windowbg2">
				<th width="50%" align="right">
					<label for="user_input">', $txt['admin_register_username'], ':</label>
					<div class="smalltext" style="font-weight: normal;">', $txt['admin_register_username_desc'], '</div>
				</th>
				<td width="50%" align="left">
					<input type="text" name="user" id="user_input" size="30" maxlength="25" />
				</td>
			</tr><tr class="windowbg2">
				<th width="50%" align="right">
					<label for="email_input">', $txt['admin_register_email'], ':</label>
					<div class="smalltext" style="font-weight: normal;">', $txt['admin_register_email_desc'], '</div>
				</th>
				<td width="50%" align="left">
					<input type="text" name="email" id="email_input" size="30" />
				</td>
			</tr><tr class="windowbg2">
				<th width="50%" align="right">
					<label for="password_input">', $txt['admin_register_password'], ':</label>
					<div class="smalltext" style="font-weight: normal;">', $txt['admin_register_password_desc'], '</div>
				</th>
				<td width="50%" align="left">
					<input type="password" name="password" id="password_input" size="30" /><br />
				</td>
			</tr><tr class="windowbg2">
				<th width="50%" align="right">
					<label for="group_select">', $txt['admin_register_group'], ':</label>
					<div class="smalltext" style="font-weight: normal;">', $txt['admin_register_group_desc'], '</div>
				</th>
				<td width="50%" align="left">
					<select name="group" id="group_select">';

	foreach ($context['member_groups'] as $id => $name)
		echo '
						<option value="', $id, '">', $name, '</option>';
	echo '
					</select><br />
				</td>
			</tr><tr class="windowbg2">
				<th width="50%" align="right">
					<label for="emailPassword_check">', $txt['admin_register_email_detail'], ':</label>
					<div class="smalltext" style="font-weight: normal;">', $txt['admin_register_email_detail_desc'], '</div>
				</th>
				<td width="50%" align="left">
					<input type="checkbox" name="emailPassword" id="emailPassword_check" checked="checked"', !empty($modSettings['registration_method']) && $modSettings['registration_method'] == 1 ? ' disabled="disabled"' : '', ' class="check" /><br />
				</td>
			</tr><tr class="windowbg2">
				<th width="50%" align="right">
					<label for="emailActivate_check">', $txt['admin_register_email_activate'], ':</label>
				</th>
				<td width="50%" align="left">
					<input type="checkbox" name="emailActivate" id="emailActivate_check"', !empty($modSettings['registration_method']) && $modSettings['registration_method'] == 1 ? ' checked="checked"' : '', ' onclick="onCheckChange();" class="check" /><br />
				</td>
			</tr><tr class="windowbg2">
				<td width="100%" colspan="2" align="right">
					<input class="login" type="submit" name="regSubmit" value="', $txt[97], '" />
					<input type="hidden" name="sa" value="register" />
				</td>
			</tr>
		</table>
		<input type="hidden" name="sc" value="', $context['session_id'], '" />
	</form>';
}

function template_edit_agreement(){}

function template_edit_reserved_words()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
		<form action="', $scripturl, '?action=regcenter" method="post" accept-charset="', $context['character_set'], '">
			<table border="0" cellspacing="1" class="bordercolor" align="center" cellpadding="4" width="80%">
				<tr class="titlebg">
					<td align="center">
						', $txt[341], '
					</td>
				</tr><tr>
					<td class="windowbg2" align="center">
						<div style="width: 80%;">
							<div style="margin-bottom: 2ex;">', $txt[342], '</div>
							<textarea cols="30" rows="6" name="reserved" style="width: 98%;">', implode("\n", $context['reserved_words']), '</textarea><br />

							<div align="left" style="margin-top: 2ex;">
								<label for="matchword"><input type="checkbox" name="matchword" id="matchword" ', $context['reserved_word_options']['match_word'] ? 'checked="checked"' : '', ' class="check" /> ', $txt[726], '</label><br />
								<label for="matchcase"><input type="checkbox" name="matchcase" id="matchcase" ', $context['reserved_word_options']['match_case'] ? 'checked="checked"' : '', ' class="check" /> ', $txt[727], '</label><br />
								<label for="matchuser"><input type="checkbox" name="matchuser" id="matchuser" ', $context['reserved_word_options']['match_user'] ? 'checked="checked"' : '', ' class="check" /> ', $txt[728], '</label><br />
								<label for="matchname"><input type="checkbox" name="matchname" id="matchname" ', $context['reserved_word_options']['match_name'] ? 'checked="checked"' : '', ' class="check" /> ', $txt[729], '</label><br />
							</div>

							<input class="login" type="submit" value="', $txt[10], '" name="save_reserved_names" style="margin: 1ex;" />
						</div>
					</td>
				</tr>
			</table>
			<input type="hidden" name="sa" value="reservednames" />
			<input type="hidden" name="sc" value="', $context['session_id'], '" />
		</form>';
}

function template_admin_settings()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;
	if ($context['use_graphic_library'])
	{
	echo '
	<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		function refreshImages()
		{
			var imageType = document.getElementById(\'visual_verification_type_select\').value;
			document.getElementById(\'verificiation_image\').src = \'', $context['verificiation_image_href'], ';type=\' + imageType;
		}
	// ]]></script>';
	}

	echo '
	<form action="', $scripturl, '?action=regcenter" method="post" accept-charset="', $context['character_set'], '">
		<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%" class="tborder">
			<tr class="titlebg">
				<td align="center">', $txt['settings'], '</td>
			</tr>
			<tr class="windowbg2">
				<td align="center">';

	// Functions to do some nice box disabling dependant on age restrictions.
	echo '
					<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
						function checkCoppa()
						{
							var coppaDisabled = document.getElementById(\'coppaAge_input\').value == 0;
							document.getElementById(\'coppaType_select\').disabled = coppaDisabled;

							var disableContacts = coppaDisabled || document.getElementById(\'coppaType_select\').options[document.getElementById(\'coppaType_select\').selectedIndex].value != 1;
							document.getElementById(\'coppaPost_input\').disabled = disableContacts;
							document.getElementById(\'coppaFax_input\').disabled = disableContacts;
							document.getElementById(\'coppaPhone_input\').disabled = disableContacts;
						}
					// ]]></script>';
	echo '
					<table border="0" cellspacing="0" cellpadding="4" align="center" width="100%">
						<tr class="windowbg2">
							<th width="50%" align="right">
								<label for="registration_method_select">', $txt['admin_setting_registration_method'], '</label> <span style="font-weight: normal;"></span>:
							</th>
							<td width="50%" align="left">
								<select name="registration_method" id="registration_method_select">
									<option value="0"', empty($modSettings['registration_method']) ? ' selected="selected"' : '', '>', $txt['admin_setting_registration_standard'], '</option>
									<option value="1"', !empty($modSettings['registration_method']) && $modSettings['registration_method'] == 1 ? ' selected="selected"' : '', '>', $txt['admin_setting_registration_activate'], '</option>
									<option value="2"', !empty($modSettings['registration_method']) && $modSettings['registration_method'] == 2 ? ' selected="selected"' : '', '>', $txt['admin_setting_registration_approval'], '</option>
									<option value="3"', !empty($modSettings['registration_method']) && $modSettings['registration_method'] == 3 ? ' selected="selected"' : '', '>', $txt['admin_setting_registration_disabled'], '</option>
								</select>
							</td>
						</tr>
						<tr class="windowbg2">
							<th width="50%" align="right">
								<label for="notify_new_registration_check">', $txt['admin_setting_notify_new_registration'], '</label>:
							</th>
							<td width="50%" align="left">
								<input type="checkbox" name="notify_new_registration" id="notify_new_registration_check" ', !empty($modSettings['notify_new_registration']) ? 'checked="checked"' : '', ' class="check" />
							</td>
						</tr><tr class="windowbg2">
							<th width="50%" align="right">
								<label for="send_welcomeEmail_check">', $txt['admin_setting_send_welcomeEmail'], '</label> <span style="font-weight: normal;"></span>:
							</th>
							<td width="50%" align="left">
								<input type="checkbox" name="send_welcomeEmail" id="send_welcomeEmail_check"', !empty($modSettings['send_welcomeEmail']) ? ' checked="checked"' : '', ' class="check" />
							</td>
						</tr><tr class="windowbg2">
							<th width="50%" align="right">
								<label for="password_strength_select">', $txt['admin_setting_password_strength'], '</label> <span style="font-weight: normal;"></span>:
							</th>
							<td width="50%" align="left">
								<select name="password_strength" id="password_strength_select">
									<option value="0"', empty($modSettings['password_strength']) ? ' selected="selected"' : '', '>', $txt['admin_setting_password_strength_low'], '</option>
									<option value="1"', !empty($modSettings['password_strength']) && $modSettings['password_strength'] == 1 ? ' selected="selected"' : '', '>', $txt['admin_setting_password_strength_medium'], '</option>
									<option value="2"', !empty($modSettings['password_strength']) && $modSettings['password_strength'] == 2 ? ' selected="selected"' : '', '>', $txt['admin_setting_password_strength_high'], '</option>
								</select>
							</td>
						</tr><tr class="windowbg2" valign="top">
							<th width="50%" align="right">
								<label for="visual_verification_type_select">
									', $txt['admin_setting_image_verification_type'], ':<br />
									<span class="smalltext" style="font-weight: normal;">
										', $txt['admin_setting_image_verification_type_desc'], '
									</span>
								</label>
							</th>
							<td width="50%" align="left">
								<select name="visual_verification_type" id="visual_verification_type_select" ', $context['use_graphic_library'] ? 'onchange="refreshImages();"' : '', '>
									<option value="1" ', !empty($modSettings['disable_visual_verification']) && $modSettings['disable_visual_verification'] == 1 ? 'selected="selected"' : '', '>', $txt['admin_setting_image_verification_off'], '</option>
									<option value="2" ', !empty($modSettings['disable_visual_verification']) && $modSettings['disable_visual_verification'] == 2 ? 'selected="selected"' : '', '>', $txt['admin_setting_image_verification_vsimple'], '</option>
									<option value="3" ', !empty($modSettings['disable_visual_verification']) && $modSettings['disable_visual_verification'] == 3 ? 'selected="selected"' : '', '>', $txt['admin_setting_image_verification_simple'], '</option>
									<option value="0" ', empty($modSettings['disable_visual_verification']) ? 'selected="selected"' : '', '>', $txt['admin_setting_image_verification_medium'], '</option>
									<option value="4" ', !empty($modSettings['disable_visual_verification']) && $modSettings['disable_visual_verification'] == 4 ? 'selected="selected"' : '', '>', $txt['admin_setting_image_verification_high'], '</option>
								</select><br />';
	if ($context['use_graphic_library'])
		echo '
								<img src="', $context['verificiation_image_href'], ';type=', empty($modSettings['disable_visual_verification']) ? 0 : $modSettings['disable_visual_verification'], '" alt="', $txt['admin_setting_image_verification_sample'], '" id="verificiation_image" /><br />';
	else
	{
		echo '
								<span class="smalltext">', $txt['admin_setting_image_verification_nogd'], '</span>';
	}
	echo '
							</td>
						</tr>
		</table>
										<input type="submit" name="save" value="', $txt['attachment_manager_save'] ,'" />
								<input type="hidden" name="sa" value="settings" />
		<input type="hidden" name="sc" value="', $context['session_id'], '" />
	</form>';
}

?>