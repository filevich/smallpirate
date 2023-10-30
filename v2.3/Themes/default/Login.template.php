<?php

function template_login()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;
echo'<table align="center"><tr align="center"><td align="center">
<script language="JavaScript" type="text/javascript" src="', $settings['default_theme_url'], '/sha1.js"></script>
<form action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" name="frmLogin" id="frmLogin" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
<div class="ultimos_postsa" style="margin:8px;">
<div class="box_title" style="width: 380px;"><div class="box_txt ultimos_posts" align="left">', $txt[34], '</div>
<div class="box_rss"><img src="/Themes/default/images/blank.gif" width="16px"></div></div><div class="windowbg"  style="width: 370px; padding:4px;"><center>';

echo'<b class="size11">', $txt[35], ':</b><br>
<input type="text" name="user" size="20" value="', $context['default_username'], '" />
<br>
<b class="size11">', $txt[36], ':</b><br>
<input type="password" name="passwrd" value="', $context['default_password'], '" size="20" />
<br>';
if (isset($context['login_show_undelete']))
echo'
<b class="size11" style="color: red;">', $txt['undelete_account'], ':</b>
<br>
<input type="checkbox" name="undelete" class="check" /><br>';
if (isset($context['login_error']))
echo'<span class="size11" style="color: red;">', $context['login_error'], '</span><br>';
echo '<input class="login" type="submit" value="', $txt[34], '"/><br><span class="smalltext"><a href="', $scripturl, '?action=reminder">', $txt[315], '</a><br /><br />
<input type="hidden" name="hash_passwrd" value="" />';

echo'</center></div></div></form>
<script language="JavaScript" type="text/javascript">
document.forms.frmLogin.', isset($context['default_username']) && $context['default_username'] != '' ? 'passwrd' : 'user', '.focus();
</script></td></tr></table>';
}

// Tell a guest to get lost or login!
function template_kick_guest()
{
	global $context, $settings, $options, $scripturl, $modSettings, $txt;

	// This isn't that much... just like normal login but with a message at the top.
	echo '
		<script language="JavaScript" type="text/javascript" src="', $settings['default_theme_url'], '/sha1.js"></script>

		<form action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" name="frmLogin" id="frmLogin"', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
			<table width="400" border="0" cellspacing="0" cellpadding="3" class="tborder" align="center">
';
	echo '<tr class="titlebg">
					<td><img src="', $settings['images_url'], '/icons/login_sm.gif" alt="" align="top" /> ', $txt[34], '</td>
				</tr><tr>
					<td class="windowbg">
						<table border="0" cellpadding="3" cellspacing="0" align="center">
							<tr>
								<td align="right"><b>', $txt[35], ':</b></td>
								<td><input class="barradelogear2" id="barradelogear1" type="text" name="user" size="20" /></td>
							</tr><tr>
								<td align="right"><b>', $txt[36], ':</b></td>
								<td><input class="barradepass2" id="barradepass1" type="password" name="passwrd" size="20" /></td>
							</tr><tr>
								<td align="right"><b>', $txt[508], ':</b></td>
								<td><input type="checkbox" name="cookieneverexp" class="check" onclick="this.form.cookielength.disabled = this.checked;" /></td>
							</tr><tr>
								<td align="center" colspan="2"><input class="login" type="submit" value="', $txt[34], '" style="margin-top: 2ex;" /></td>
							</tr><tr>
								<td align="center" colspan="2" class="smalltext"><a href="', $scripturl, '?action=reminder">', $txt[315], '</a><br /><br /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<input type="hidden" name="hash_passwrd" value="" />
		</form>';

	// Do the focus thing...
	echo '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
			document.forms.frmLogin.user.focus();
		// ]]></script>';
}

// This is for maintenance mode.
function template_maintenance()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Display the administrator's message at the top.
	echo '
<form action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '">
	<table border="0" width="86%" cellspacing="0" cellpadding="3" class="tborder" align="center">
		<tr class="titlebg">
			<td colspan="2">', $context['title'], '</td>
		</tr><tr>
			<td class="windowbg" width="44" align="center" style="padding: 1ex;">
				<img src="', $settings['images_url'], '/construction.gif" width="40" height="40" alt="', $txt['maintenance3'], '" />
			</td>
			<td class="windowbg">', $context['description'], '</td>
		</tr><tr class="titlebg">
			<td colspan="2">', $txt[114], '</td>
		</tr><tr>';

	// And now all the same basic login stuff from before.
	echo '
			<td colspan="2" class="windowbg">
				<table border="0" width="90%" align="center">
					<tr>
						<td><b>', $txt[35], ':</b></td>
						<td><input class="barradelogear2" id="barradelogear1" type="text" name="user" size="15" /></td>
						<td><b>', $txt[36], ':</b></td>
						<td><input class="barradepass2" id="barradepass1" type="password" name="passwrd" size="10" /> &nbsp;</td>
					</tr><tr>
						<td><b>', $txt[508], ':</b></td>
						<td><input type="checkbox" name="cookieneverexp" class="check" /></td>
					</tr><tr>
						<td align="center" colspan="4"><input class="login" type="submit" value="', $txt[34], '" style="margin-top: 1ex; margin-bottom: 1ex;" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>';
}

// This is for the security stuff - makes administrators login every so often.
function template_admin_login()
{
	global $context, $settings, $options, $scripturl, $txt;

	// Since this should redirect to whatever they were doing, send all the get data.
	echo '
<script language="JavaScript" type="text/javascript" src="', $settings['default_theme_url'], '/sha1.js"></script>

<form action="', $scripturl, $context['get_data'], '" method="post" accept-charset="', $context['character_set'], '" name="frmLogin" id="frmLogin" onsubmit="hashAdminPassword(this, \'', $context['user']['username'], '\', \'', $context['session_id'], '\');">
	<table border="0" width="400" cellspacing="0" cellpadding="3" class="tborder" align="center">
		<tr class="titlebg">
			<td align="left">
				<img src="', $settings['images_url'], '/icons/login_sm.gif" alt="" align="top" /> ', $txt[34], '
			</td>
		</tr>';

	// We just need the password.
	echo '
		<tr class="windowbg">
			<td align="center" style="padding: 1ex 0;">
				<b>', $txt[36], ':</b> <input class="barradepass2" id="barradepass1" type="password" name="admin_pass" size="24" /><br />
				<input class="login" type="submit" value="', $txt[34], '" style="margin-top: 2ex;" />
			</td>
		</tr>
	</table>';

	// Make sure to output all the old post data.
	echo $context['post_data'], '

	<input type="hidden" name="admin_hash_pass" value="" />
</form>';

	// Focus on the password box.
	echo '
<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
	document.forms.frmLogin.admin_pass.focus();
// ]]></script>';
}

// Activate your account manually?
function template_retry_activate()
{
	global $context, $settings, $options, $txt, $scripturl;

	// Just ask them for their code so they can try it again...
	echo '
		<br />
		<form action="', $scripturl, '?action=activate;u=', $context['member_id'], '" method="post" accept-charset="', $context['character_set'], '">
			<table border="0" width="600" cellpadding="4" cellspacing="0" class="tborder" align="center">
				<tr class="titlebg">
					<td colspan="2">', $context['page_title'], '</td>';

	// You didn't even have an ID?
	if (empty($context['member_id']))
		echo '
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_username'], ':</td>
					<td><input type="text" name="user" size="30" /></td>';

	echo '
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_retry'], ':</td>
					<td><input type="text" name="code" size="30" /></td>
				</tr><tr class="windowbg">
					<td colspan="2" align="center" style="padding: 1ex;"><input class="login" type="submit" value="', $txt['invalid_activation_submit'], '" /></td>
				</tr>
			</table>
		</form>';
}

// Activate your account manually?
function template_resend()
{
	global $context, $settings, $options, $txt, $scripturl;

	// Just ask them for their code so they can try it again...
	echo '
		<br />
		<form action="', $scripturl, '?action=activate;sa=resend" method="post" accept-charset="', $context['character_set'], '">
			<table border="0" width="600" cellpadding="4" cellspacing="0" class="tborder" align="center">
				<tr class="titlebg">
					<td colspan="2">', $context['page_title'], '</td>
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_username'], ':</td>
					<td><input class="barradelogear2" id="barradelogear1" type="text" name="user" size="40" value="', $context['default_username'], '" /></td>
				</tr><tr class="windowbg">
					<td colspan="2" style="padding-top: 3ex; padding-left: 3ex;">', $txt['invalid_activation_new'], '</td>
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_new_email'], ':</td>
					<td><input type="text" name="new_email" size="40" /></td>
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_password'], ':</td>
					<td><input class="barradepass2" id="barradepass1" type="password" name="passwd" size="30" /></td>
				</tr><tr class="windowbg">';

	if ($context['can_activate'])
		echo '
					<td colspan="2" style="padding-top: 3ex; padding-left: 3ex;">', $txt['invalid_activation_known'], '</td>
				</tr><tr class="windowbg">
					<td align="right" width="40%">', $txt['invalid_activation_retry'], ':</td>
					<td><input type="text" name="code" size="30" /></td>
				</tr><tr class="windowbg">';

	echo '
					<td colspan="2" align="center" style="padding: 1ex;"><input class="login" type="submit" value="', $txt['invalid_activation_resend'], '" /></td>
				</tr>
			</table>
		</form>';
}

?>