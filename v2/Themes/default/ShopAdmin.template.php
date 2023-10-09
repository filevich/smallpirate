<?php

function template_main()
{
	global $modSettings, $scripturl, $context, $txt, $sourcedir;

	echo '
				<form action="', $scripturl, '?action=shop_general;save" method="post">

<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Opciones</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
<table width="100%" cellpadding="5" cellspacing="1" border="0" class="windowbg" id="supportVersionsTable">
								<tr>
										<td class="windowbg2" valign="top" style="height: 18ex;">
											<label for="prefix">Prefijo:</label> <input type="text" name="prefix" id="prefix" value="', $modSettings['shopCurrencyPrefix'], '" size="5" /><br />
											<label for="suffix">Subfijo:</label> <input type="text" name="suffix" id="suffix" value="', $modSettings['shopCurrencySuffix'], '" size="5" /><br />
											<table>
												<tr>
													<td align="right"><label for="pertopic">Por cada post creado:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="pertopic" id="pertopic" value="', $modSettings['shopPointsPerTopic'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr><tr>
													<td align="right"><label for="perpost">Por cada comentarios creado:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="perpost" id="perpost" value="', $modSettings['shopPointsPerPost'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr><tr>
													<td align="right"><label for="regamount">Por el registro:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="regamount" id="regamount" value="', $modSettings['shopRegAmount'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr>
											</table>
											
											<input class="login" type="submit" value="Guardar Cambios" /><br />
											', ($context['shop_saved'] == true ? '<b>Cambios Guardados.</b>' : ''), '
										</td>
									</tr>
								</table>
					<br><br>
					<table align="center" width="100%" cellpadding="3" cellspacing="0" border="0">	
		<tr>
		<td width="100%" class="titulo_a">&nbsp;</td>
		<td width="100%" class="titulo_b"><center>Bonus</center></td>
		<td width="100%" class="titulo_c">&nbsp;</td>
		</tr></table>
								<table width="100%" cellpadding="5" cellspacing="1" border="0" class="windowbg">
					<tr>
										<td class="windowbg2" valign="top" style="height: 18ex;">	
											<table>
												<tr>
													<td align="right"><label for="perword">Por palabra:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="perword" id="perword" value="', $modSettings['shopPointsPerWord'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr><tr>
													<td align="right"><label for="perchar">Por letra:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="perchar" id="perchar" value="', $modSettings['shopPointsPerChar'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr><tr>
													<td align="right"><label for="limit">Limite por post:</label></td>
													<td>', $modSettings['shopCurrencyPrefix'], '<input type="text" name="limit" id="limit" value="', $modSettings['shopPointsLimit'], '" size="5" />', $modSettings['shopCurrencySuffix'], '</td>
												</tr>				</table>										
											<input class="login" type="submit" value="Guardar Cambios" /><br />
											', ($context['shop_saved'] == true ? '<b>Cambios Guardados.</b>' : ''), '
										</td>
									</tr>
								</table>
				</form>
				';

	if ($shopVersion['develVersion'] == false)
		echo '
				';
	else
		echo '
				<script language="JavaScript" type="text/javascript">
					var currShopVerStr = document.getElementById(\'currShopVersion\');
					setInnerHTML(currShopVerStr, \'Version de prueba!\');
				</script>';
}

// Member's Inventory
function template_inventory()
{
	global $modSettings, $scripturl, $context, $txt, $settings;

echo '
				<table width="100%" cellpadding="5" cellspacing="0" border="0" class="tborder" style="margin-top: 1.5ex;">
					<tr class="titlebg"><td align="center">', $txt['shop_edit_inventory'], '</td></tr>
					<tr valign="top" class="windowbg2">
						<td style="padding-bottom: 2ex;" width="100%">';

	// The 'Please Type a Members Name' page
	if (empty($_GET['do']) || $_GET['do'] == '')
		echo '
							', $txt['shop_edit_member_inventory'], '<br />
							<form action="', $scripturl, '?action=shop_inventory;do=viewmember" method="post">
								<input name="searchfor" type="text" size="70" />
								<a href="', $scripturl, '?action=findmember;input=searchfor;quote=1;sesc=', $context['session_id'], '" onclick="return reqWin(this.href, 350, 400);"><img src="', $settings['images_url'], '/icons/assist.gif" border="0" alt="', $txt['find_members'], '" /> Find Members</a><br />
								<input class="login" type="submit" value="', $txt['shop_next'], '" />
							</form>';

	// The Inventory list
	else
	{
		// If we need to show a message
		if (isset($context['shop_message']))
			echo '
							<div style="color: red; font-weight: bold;">', $context['shop_message'], '</div>'; 

		echo '
							<i>', sprintf($txt['shop_edit_member'], $context['shop_inv']['member'], $context['shop_inv']['realName']), '</i><br /><br />', '
							';
		foreach ($context['shop_inv']['list'] as $row)
			echo '
							', $txt['shop_inventory'], ' #', $row['id'], ' - ', $row['name'], ' - ', sprintf($txt['shop_bought_for'], $row['amtpaid']), ' - <a href="', $scripturl, '?action=shop_inventory;do=delete;id=', $row['id'], ';userid=', $context['shop_inv']['member'], '">', $txt['shop_delete'], '</a><br />';
		
		echo '
							<br />
							<form action="', $scripturl, '?action=shop_inventory;do=editmoney" method="post">
								<input type="hidden" name="userid" value="', $context['shop_inv']['member'], '" />
								<table>
									<tr>
										<td align="right"><label for="money_pocket">', $txt['shop_money_in_pocket'], ':</label></td>
										<td><input type="text" value="', $context['shop_inv']['money_pocket'], '" name="money_pocket" id="money_pocket" /></td>
									</tr><tr>
										<td align="right"><label for="money_bank">', $txt['shop_money_in_bank'], ':</label></td>
										<td><input type="text" value="', $context['shop_inv']['money_bank'], '" name="money_bank" id="money_bank" /></td>
									</tr>
								</table>
								<input class="login" type="submit" value="', $txt['shop_save_changes'], '" />
							</form>
		';
	}
	// Close the table
	echo '
						</td>
					</tr>
				</table>';
}

function template_items_add(){}
function template_restock(){}
function template_usergroup()
{
	global $txt, $scripturl, $db_prefix, $context, $modSettings;
	
	// First bit of the page
	echo '
				<table width="100%" cellpadding="5" cellspacing="0" border="0" class="tborder" style="margin-top: 1.5ex;">
					<tr class="titlebg"><td align="center">', $txt['shop_admin_usergroup'], '</td></tr>
					<tr valign="top" class="windowbg2">
						<td style="padding-bottom: 2ex;" width="100%">';

	// Step 1: Ask the user what to do
	if (!isset($_GET['step']) || $_GET['step'] == 1)
	{
		echo '
							<form action="', $scripturl, '?action=shop_usergroup;step=2" method="post">
								', $txt['shop_membergroup_desc'], '<br /><br />
								<table>
									<tr>
										<td align="right"><label for="usergroup">', $txt['shop_membergroup'], ':</label></td>
										<td>
											<select name="usergroup" id="usergroup">';
		// Loop through all available membergroups
		foreach	($context['shop_usergroups'] as $row)
			echo '
												<option value="', $row['id'], '">', $row['groupName'], '</option>';
		echo '
											</select>
										</td>
									</tr><tr>
										<td>', $txt['shop_action'], ':</td>
										<td><label><input type="radio" name="m_action" value="add" checked="checked" />', $txt['shop_add'], '</label> <label><input type="radio" name="m_action" value="sub" />', $txt['shop_subtract'], '</label></td>
									</tr><tr>
										<td><label for="value">', $txt['shop_amount'], ':</label></td>
										<td>'.$modSettings['shopCurrencyPrefix'], '<input type="text" name="value" id="value" value="0" size="10" />'.$modSettings['shopCurrencySuffix'], '</td>
									</tr>
								</table>
								<input class="login" type="submit" value="', $txt['shop_next'], '">
							</form>';
	}

	elseif ($_GET['step'] == 2)
		echo 'Cambios Guardados!';

	echo '				</td>
					</tr>
				</table>';
}
function template_categories(){}
?>
