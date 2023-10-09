<?php
function template_avatars()
{	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
<form action="/?action=manageattachments" method="post" accept-charset="', $context['character_set'], '">
	<table border="0" cellspacing="0" cellpadding="4" align="center" width="80%" class="tborder">';

	echo '
		<tr>
			<td colspan="2" class="titlebg" align="center">Administraci&oacute;n del avatar</td>
		</tr>';
	if ($context['can_change_permissions'])
	{
		echo '
		<tr class="windowbg2">
			<td width="50%" valign="top" align="right"><label for="external_url_groups">', $txt['avatar_external_url_groups'], '</label>:</td>
			<td>';

		theme_inline_permissions('profile_remote_avatar');

		echo '
			</td>
		</tr>';
	}
	echo '
		<tr class="windowbg2">
			<td width="50%" align="right"><label for="avatar_download_external">', $txt['avatar_download_external'], ' :</label></td>
			<td><input type="checkbox" name="avatar_download_external" id="avatar_download_external" value="1" class="check"', empty($modSettings['avatar_download_external']) ? '' : ' checked="checked"', ' onchange="updateStatus()" /></td>
		</tr><tr class="windowbg2">
			<td width="50%" align="right"><label for="avatar_max_width_external">', $txt['avatar_max_width_external'], '</label>:<div class="smalltext" style="font-weight: bold;">', $txt['avatar_dimension_note'], '</div></td>
			<td>
				<input type="text" name="avatar_max_width_external" id="avatar_max_width_external" value="', $modSettings['avatar_max_width_external'], '" size="6" />
			</td>
		</tr><tr class="windowbg2">
			<td width="50%" align="right"><label for="avatar_max_height_external">', $txt['avatar_max_height_external'], '</label>:<div class="smalltext" style="font-weight: bold;">', $txt['avatar_dimension_note'], '</div></td>
			<td>
				<input type="text" name="avatar_max_height_external" id="avatar_max_height_external" value="', $modSettings['avatar_max_height_external'], '" size="6" />
			</td>
		</tr><tr class="windowbg2">
			<td width="50%" align="right"><label for="avatar_action_too_large">', $txt['avatar_action_too_large'], '</label></td>
			<td>
				<select name="avatar_action_too_large" id="avatar_action_too_large">
					<option value="option_refuse"', $modSettings['avatar_action_too_large'] == 'option_refuse' ? ' selected="selected"' : '', '>', $txt['option_refuse'], '</option>
					<option value="option_html_resize"', $modSettings['avatar_action_too_large'] == 'option_html_resize' ? ' selected="selected"' : '', '>', $txt['option_html_resize'], '</option>
					<option value="option_js_resize"', $modSettings['avatar_action_too_large'] == 'option_js_resize' ? ' selected="selected"' : '', '>', $txt['option_js_resize'], '</option>
					<option value="option_download_and_resize"', $modSettings['avatar_action_too_large'] == 'option_download_and_resize' ? ' selected="selected"' : '', '>', $txt['option_download_and_resize'], '</option>
				</select>
			</td>
		</tr>';
echo'<tr class="windowbg2">
			<td colspan="2" align="center">
				<input class="login" type="submit" name="avatarSettings" value="', $txt['attachment_manager_save'], '" />
				<input type="hidden" name="sa" value="avatars" />
				<input type="hidden" name="sc" value="', $context['session_id'], '" />
			</td>
		</tr>
	</table>
</form>
<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
	function updateStatus()
	{
		document.getElementById("avatar_max_width_external").disabled = document.getElementById("avatar_download_external").checked;
		document.getElementById("avatar_max_height_external").disabled = document.getElementById("avatar_download_external").checked;
		document.getElementById("avatar_action_too_large").disabled = document.getElementById("avatar_download_external").checked;
		document.getElementById("custom_avatar_dir").disabled = document.getElementById("custom_avatar_enabled").value == 0;
		document.getElementById("custom_avatar_url").disabled = document.getElementById("custom_avatar_enabled").value == 0;

	}
	window.onload = updateStatus;
// ]]></script>
';
}
function template_manage_files_above(){}
function template_manage_files_below(){}
?>