<?php
/**********************************************************************************
* ModSettings.php                                                                 *
***********************************************************************************
* SMF: Simple Machines Forum                                                      *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                    *
* =============================================================================== *
* Software Version:           SMF 1.1                                             *
* Software by:                Simple Machines (http://www.simplemachines.org)     *
* Copyright 2006 by:          Simple Machines LLC (http://www.simplemachines.org) *
*           2001-2006 by:     Lewis Media (http://www.lewismedia.com)             *
* Support, News, Updates at:  http://www.simplemachines.org                       *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Simple Machines LLC.          *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Simple Machines license.          *
* The latest version can always be found at http://www.simplemachines.org.        *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

/*	This file is here to make it easier for installed mods to have settings
	and options.  It uses the following functions:

	void ModifyFeatureSettings()
		// !!!

	void ModifyFeatureSettings2()
		// !!!

	void ModifyBasicSettings()
		// !!!

	void ModifyLayoutSettings()
		// !!!

	void ModifyKarmaSettings()
		// !!!

	Adding new settings to the $modSettings array:
	---------------------------------------------------------------------------
// !!!
*/

/*	Adding options to one of the setting screens isn't hard.  The basic format for a checkbox is:
		array('check', 'nameInModSettingsAndSQL'),

	   And for a text box:
		array('text', 'nameInModSettingsAndSQL')
	   (NOTE: You have to add an entry for this at the bottom!)

	   In these cases, it will look for $txt['nameInModSettingsAndSQL'] as the description,
	   and $helptxt['nameInModSettingsAndSQL'] as the help popup description.

	Here's a quick explanation of how to add a new item:

	 * A text input box.  For textual values.
	ie.	array('text', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A text input box.  For numerical values.
	ie.	array('int', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A text input box.  For floating point values.
	ie.	array('float', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),
			
         * A large text input box. Used for textual values spanning multiple lines.
	ie.	array('large_text', 'nameInModSettingsAndSQL', 'OptionalNumberOfRows',
			&$txt['OptionalDescriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	 * A check box.  Either one or zero. (boolean)
	ie.	array('check', 'nameInModSettingsAndSQL', null, &$txt['descriptionOfTheOption'],
			'OptionalReferenceToHelpAdmin'),

	 * A selection box.  Used for the selection of something from a list.
	ie.	array('select', 'nameInModSettingsAndSQL', array('valueForSQL' => &$txt['displayedValue']),
			&$txt['descriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),
	Note that just saying array('first', 'second') will put 0 in the SQL for 'first'.

	 * A password input box. Used for passwords, no less!
	ie.	array('password', 'nameInModSettingsAndSQL', 'OptionalInputBoxWidth',
			&$txt['descriptionOfTheOption'], 'OptionalReferenceToHelpAdmin'),

	For each option:
		type (see above), variable name, size/possible values, description, helptext.
	OR	make type 'rule' for an empty string for a horizontal rule.
	OR	make type 'heading' with a string for a titled section. */

// This function passes control through to the relevant tab.
function ModifyFeatureSettings()
{
	global $context, $txt, $scripturl, $modSettings, $sourcedir;

	// You need to be an admin to edit settings!
	isAllowedTo('admin_forum');

	// All the admin bar, to make it right.
	adminIndex('edit_mods_settings');
	loadLanguage('Help');
	loadLanguage('HidePost');
	loadLanguage('ModSettings');

	// Will need the utility functions from here.
	require_once($sourcedir . '/ManageServer.php');

	$context['page_title'] = $txt['modSettings_title'];
	$context['sub_template'] = 'show_settings';

	$subActions = array(
		'basic' => 'ModifyBasicSettings',
		'layout' => 'ModifyLayoutSettings',
		'thankyoupost' => 'ModifyThankYouPostSettings',
		'karma' => 'ModifyKarmaSettings',
		'sbox' => 'ModifySboxSettings',

		'sig' => 'ModifySignatureSettings',
	);

	// By default do the basic settings.
	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'basic';
	$context['sub_action'] = $_REQUEST['sa'];

	// Load up all the tabs...
	$context['admin_tabs'] = array(
		'title' => &$txt['modSettings_title'],
		'help' => 'modsettings',
		'description' => $txt['smf3'],
		'tabs' => array(
			'basic' => array(
				'title' => $txt['mods_cat_features'],
				'href' => $scripturl . '?action=featuresettings;sa=basic;sesc=' . $context['session_id'],
			),
			'layout' => array(
				'title' => $txt['mods_cat_layout'],
				'href' => $scripturl . '?action=featuresettings;sa=layout;sesc=' . $context['session_id'],
			),

			'sbox' => array(
				'title' => $txt['sbox_ModTitle'],
				'href' => $scripturl . '?action=featuresettings;sa=sbox;sesc=' . $context['session_id'],
			),
			'thankyoupost' => array(
				'title' => $txt['thankyouposttitle'],
				'href' => $scripturl . '?action=featuresettings;sa=thankyoupost;sesc=' . $context['session_id'],
			),

			'sbox' => array(
				'title' => $txt['sbox_ModTitle'],
				'href' => $scripturl . '?action=featuresettings;sa=sbox;sesc=' . $context['session_id'],
			),
			'karma' => array(
				'title' => $txt['smf293'],
				'href' => $scripturl . '?action=featuresettings;sa=karma;sesc=' . $context['session_id'],
			),
			'sig' => array(
				'title' => $txt['signature_settings'],
				'description' => $txt['signature_settings_desc'],
				'href' => $scripturl . '?action=featuresettings;sa=sig;sesc=' . $context['session_id'],
				'is_last' => true,
			),
		),
	);

	// Select the right tab based on the sub action.
	if (isset($context['admin_tabs']['tabs'][$context['sub_action']]))
		$context['admin_tabs']['tabs'][$context['sub_action']]['is_selected'] = true;

	// Call the right function for this sub-acton.
	$subActions[$_REQUEST['sa']]();
}

// This function basically just redirects to the right save function.
function ModifyFeatureSettings2()
{
	global $context, $txt, $scripturl, $modSettings, $sourcedir;

	isAllowedTo('admin_forum');
	loadLanguage('ModSettings');

	// Quick session check...
	checkSession();

	require_once($sourcedir . '/ManageServer.php');

	$subActions = array(
		'basic' => 'ModifyBasicSettings',
		'layout' => 'ModifyLayoutSettings',
		'thankyoupost' => 'ModifyThankYouPostSettings',
		'karma' => 'ModifyKarmaSettings',
		'sbox' => 'ModifySboxSettings',

		'sig' => 'ModifySignatureSettings',
	);

	// Default to core (I assume)
	$_REQUEST['sa'] = isset($_REQUEST['sa']) && isset($subActions[$_REQUEST['sa']]) ? $_REQUEST['sa'] : 'basic';

	// Actually call the saving function.
	$subActions[$_REQUEST['sa']]();
}

function ModifyBasicSettings()
{
	global $txt, $scripturl, $context, $settings, $sc, $modSettings;

	$config_vars = array(
			'',
			array('text', 'time_format'),
			array('select', 'number_format', array('1234.00' => '1234.00', '1,234.00' => '1,234.00', '1.234,00' => '1.234,00', '1 234,00' => '1 234,00', '1234,00' => '1234,00')),
			array('float', 'time_offset'),
			array('int', 'failed_login_threshold'),
			array('int', 'lastActive'),
			array('check', 'trackStats'),
			array('check', 'hitStats'),
			array('check', 'enableErrorLogging'),
			array('check', 'securityDisable'),
		'',
			// Reactive on email, and approve on delete
			array('check', 'send_validation_onChange'),
			array('check', 'approveAccountDeletion'),
		'',
			// Option-ish things... miscellaneous sorta.
			array('check', 'allow_disableAnnounce'),
			array('check', 'disallow_sendBody'),
			array('check', 'modlog_enabled'),
			array('check', 'queryless_urls'),
		'',
			array('check', 'sitemap_xml'),
			array('int', 'sitemap_topic_count'),
			array('check', 'sitemap_collapsible'),
		'',
			// Width/Height image reduction.
			array('int', 'max_image_width'),
			array('int', 'max_image_height'),
		'',
     		array('check', 'enableSinglePM'),
			array('check', 'enableReportPM'),
		'',

			array('select', 'er_who', array('admin' => 'Administradores', 'admin+mod' => 'Administradores y moderadores', 'anyone' => 'Todos',), '&#191;Qui&eacute;n puede especificar la raz&oacute;n de la edici&oacute;n?'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		// Fix PM settings.
		$_POST['pm_spam_settings'] = (int) $_POST['max_pm_recipients'] . ',' . (int) $_POST['pm_posts_verification'] . ',' . (int) $_POST['pm_posts_per_hour'];
		$save_vars = $config_vars;
		$save_vars[] = array('text', 'pm_spam_settings');

		saveDBSettings($save_vars);

		writeLog();
		redirectexit('action=featuresettings;sa=basic');
	}

	// Hack for PM spam settings.
	list ($modSettings['max_pm_recipients'], $modSettings['pm_posts_verification'], $modSettings['pm_posts_per_hour']) = explode(',', $modSettings['pm_spam_settings']);
	$config_vars[] = array('int', 'max_pm_recipients');
	$config_vars[] = array('int', 'pm_posts_verification');
	$config_vars[] = array('int', 'pm_posts_per_hour');

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=basic';
	$context['settings_title'] = 'Guardar Cambios';

	prepareDBSettingContext($config_vars);
}

function ModifyLayoutSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array(
			// Compact pages?
			array('check', 'compactTopicPagesEnable'),
			array('int', 'compactTopicPagesContiguous', null, $txt['smf235'] . '<div class="smalltext">' . str_replace(' ', '&nbsp;', '"3" ' . $txt['smf236'] . ': <b>1 ... 4 [5] 6 ... 9</b>') . '<br />' . str_replace(' ', '&nbsp;', '"5" ' . $txt['smf236'] . ': <b>1 ... 3 4 [5] 6 7 ... 9</b>') . '</div>'),
		'',
			// Stuff that just is everywhere - today, search, online, etc.
			array('select', 'todayMod', array(&$txt['smf290'], &$txt['smf291'], &$txt['smf292'])),
			array('check', 'topbottomEnable'),
			array('check', 'onlineEnable'),
			array('check', 'enableVBStyleLogin'),
		'',
			// Pagination stuff.
			array('int', 'defaultMaxMembers'),
		'',
			// This is like debugging sorta.
			array('check', 'timeLoadPageEnable'),
			array('check', 'disableHostnameLookup'),
		'',
			// Who's online.
			array('check', 'who_enabled'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=layout');

		loadUserSettings();
		writeLog();
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=layout';
	$context['settings_title'] = $txt['mods_cat_layout'];

	prepareDBSettingContext($config_vars);
}

function ModifyKarmaSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array(
			// Karma - On or off?
			array('select', 'karmaMode', explode('|', $txt['smf64'])),
		'',
			// Who can do it.... and who is restricted by time limits?
			array('int', 'karmaMinPosts'),
			array('float', 'karmaWaitTime'),
			array('check', 'karmaTimeRestrictAdmins'),
		'',
			// What does it look like?  [smite]?
			array('text', 'karmaLabel'),
			array('text', 'karmaApplaudLabel'),
			array('text', 'karmaSmiteLabel'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=karma');
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=karma';
	$context['settings_title'] = $txt['smf293'];

	prepareDBSettingContext($config_vars);
}

// You'll never guess what this function does...
function ModifySignatureSettings()
{
	global $context, $txt, $modSettings, $db_prefix, $sig_start;

	// Applying to ALL signatures?!!
	if (isset($_GET['apply']))
	{
		$sig_start = time();
		// This is horrid - but I suppose some people will want the option to do it.
		$_GET['step'] = isset($_GET['step']) ? (int) $_GET['step'] : 0;
		list ($sig_limits, $sig_bbc) = explode(':', $modSettings['signature_settings']);
		$sig_limits = explode(',', $sig_limits);
		$disabledTags = !empty($sig_bbc) ? explode(',', $sig_bbc) : array();
		$done = false;

		$request = db_query("
			SELECT MAX(ID_MEMBER)
			FROM {$db_prefix}members", __FILE__, __LINE__);
		list ($context['max_member']) = mysql_fetch_row($request);
		mysql_free_result($request);

		while (!$done)
		{
			$changes = array();

			$request = db_query("
				SELECT ID_MEMBER, signature
				FROM {$db_prefix}members
				WHERE ID_MEMBER BETWEEN $_GET[step] AND $_GET[step] + 49", __FILE__, __LINE__);
			while ($row = mysql_fetch_assoc($request))
			{
				// Apply all the rules we can realistically do.
				$sig = strtr($row['signature'], array('<br />' => "\n"));

				// Max characters...
				if (!empty($sig_limits[1]))
					$sig = substr($sig, 0, $sig_limits[1]);
				// Max lines...
				if (!empty($sig_limits[2]))
				{
					$count = 0;
					for ($i = 0; $i < strlen($sig); $i++)
					{
						if ($sig{$i} == "\n")
						{
							$count++;
							if ($count > $sig_limits[2])
								$sig = substr($sig, 0, $i) . strtr(substr($sig, $i), array("\n" => ' '));
						}
					}
				}
				// Max font size...
				if (!empty($sig_limits[7]) && preg_match_all('~\[size=(\d+)~i', $sig, $matches) !== false && isset($matches[1]))
				{
					foreach ($matches[1] as $key => $size)
						if ($size > $sig_limits[7])
						{
							$sig = str_replace($matches[0][$key], '[size=' . $sig_limits[7], $sig);
						}
				}

				// Stupid images - this is stupidly, stupidly challenging.
				if ((!empty($sig_limits[3]) || !empty($sig_limits[5]) || !empty($sig_limits[6])))
				{
					$replaces = array();
					$img_count = 0;
					// Try to find all the images!
					if (preg_match_all('~\[img(\s+width=([\d]+))?(\s+height=([\d]+))?(\s+width=([\d]+))?\s*\](?:<br />)*([^<">]+?)(?:<br />)*\[/img\]~i', $sig, $matches) !== false)
					{
						foreach ($matches[0] as $key => $image)
						{
							$width = -1; $height = -1;
							$img_count++;
							// Too many images?
							if (!empty($sig_limits[3]) && $img_count > $sig_limits[3])
							{
								$replaces[$image] = '';
								break;
							}

							// Does it have predefined restraints? Width first.
							if ($matches[6][$key])
								$matches[2][$key] = $matches[6][$key];
							if ($matches[2][$key] && $sig_limits[5] && $matches[2][$key] > $sig_limits[5])
							{
								$width = $sig_limits[5];
								$matches[4][$key] = $matches[4][$key] * ($width / $matches[2][$key]);
							}
							elseif ($matches[2][$key])
								$width = $matches[2][$key];
							// ... and height.
							if ($matches[4][$key] && $sig_limits[6] && $matches[4][$key] > $sig_limits[6])
							{
								$height = $sig_limits[6];
								if ($width != -1)
									$width = $width * ($height / $matches[4][$key]);
							}
							elseif ($matches[4][$key])
								$height = $matches[4][$key];
		
							// If the dimensions are still not fixed - we need to check the actual image.
							if (($width == -1 && $sig_limits[5]) || ($height == -1 && $sig_limits[6]))
							{
								$sizes = url_image_size($matches[7][$key]);
								if (is_array($sizes))
								{
									// Too wide?
									if ($sizes[0] > $sig_limits[5] && $sig_limits[5])
									{
										$width = $sig_limits[5];
										$sizes[1] = $sizes[1] * ($width / $sizes[0]);
									}
									// Too high?
									if ($sizes[1] > $sig_limits[6] && $sig_limits[6])
									{
										$height = $sig_limits[6];
										if ($width == -1)
											$width = $sizes[0];
										$width = $width * ($height / $sizes[1]);
									}
									elseif ($width != -1)
										$height = $sizes[1];
								}
							}

							// Did we come up with some changes? If so remake the string.
							if ($width != -1 || $height != -1)
								$replaces[$image] = '[img' . ($width != -1 ? ' width=' . round($width) : '') . ($height != -1 ? ' height=' . round($height) : '') . ']' . $matches[7][$key] . '[/img]';
						}
						if (!empty($replaces))
							$sig = str_replace(array_keys($replaces), array_values($replaces), $sig);
					}
				}
				// Try to fix disabled tags.
				if (!empty($disabledTags))
				{
					$sig = preg_replace('~\[(' . implode('|', $disabledTags) . ').+?\]~i', '', $sig);
					$sig = preg_replace('~\[/(' . implode('|', $disabledTags) . ')\]~i', '', $sig);
				}

				$sig = strtr($sig, array("\n" => '<br />'));
				if ($sig != $row['signature'])
					$changes[$row['ID_MEMBER']] = addslashes($sig);
			}
			if (mysql_num_rows($request) == 0)
				$done = true;
			mysql_free_result($request);

			// Do we need to delete what we have?
			if (!empty($changes))
			{
				foreach ($changes as $id => $sig)
					db_query("
						UPDATE {$db_prefix}members
						SET signature = '$sig'
						WHERE ID_MEMBER = $id
						LIMIT 1", __FILE__, __LINE__);
			}

			$_GET['step'] += 50;
			if (!$done)
				pauseSignatureApplySettings();
		}
	}

	// Setup the template.
	$context['sub_template'] = 'edit_signature_settings';
	$context['page_title'] = $txt['signature_settings'];

	// Load all the signature settings.
	list ($sig_limits, $sig_bbc) = explode(':', $modSettings['signature_settings']);
	$sig_limits = explode(',', $sig_limits);
	$disabledTags = !empty($sig_bbc) ? explode(',', $sig_bbc) : array();

	$context['signature_settings'] = array(
		'enabled' => isset($sig_limits[0]) ? $sig_limits[0] : 0,
		'max_length' => isset($sig_limits[1]) ? $sig_limits[1] : 0,
		'max_lines' => isset($sig_limits[2]) ? $sig_limits[2] : 0,
		'max_images' => isset($sig_limits[3]) ? $sig_limits[3] : 0,
		'max_smileys' => isset($sig_limits[4]) ? $sig_limits[4] : 0,
		'max_image_width' => isset($sig_limits[5]) ? $sig_limits[5] : 0,
		'max_image_height' => isset($sig_limits[6]) ? $sig_limits[6] : 0,
		'max_font_size' => isset($sig_limits[7]) ? $sig_limits[7] : 0,
	);

	// Ask parse_bbc() for its bbc code list.
	$temp = parse_bbc(false);
	$bbcTags = array();
	foreach ($temp as $tag)
		$bbcTags[] = $tag['tag'];

	$bbcTags = array_unique($bbcTags);
	$totalTags = count($bbcTags);

	// The number of columns we want to show the BBC tags in.
	$numColumns = 3;

	// In case we're saving.
	if (isset($_POST['save_settings']))
	{
		checkSession();

		if ( !isset($_POST['enabledTags']) )
			$_POST['enabledTags'] = array();
		elseif ( !is_array($_POST['enabledTags']) )
			$_POST['enabledTags'] = array($_POST['enabledTags']);

		$sig_limits = array();
		foreach ($context['signature_settings'] as $key => $value)
			$sig_limits[] = !empty($_POST[$key]) ? max(1, (int) $_POST[$key]) : 0;

		$sig_settings = implode(',', $sig_limits) . ':' . implode(',', array_diff($bbcTags, $_POST['enabledTags']));

		// Update the actual setting.
		updateSettings(array(
			'signature_settings' => $sig_settings,
		));

		redirectexit('action=featuresettings;sa=sig');
	}

	$context['bbc_columns'] = array();
	$tagsPerColumn = ceil($totalTags / $numColumns);

	$col = 0;
	$i = 0;
	foreach ($bbcTags as $tag)
	{
		if ($i % $tagsPerColumn == 0 && $i != 0)
			$col++;

		$context['bbc_columns'][$col][] = array(
			'tag' => $tag,
			'is_enabled' => !in_array($tag, $disabledTags),
			// !!! 'tag_' . ?
			'show_help' => isset($helptxt[$tag]),
		);

		$i++;
	}

	$context['bbc_all_selected'] = empty($disabledTags);
}

// Just pause the signature applying thing.
function pauseSignatureApplySettings()
{
	global $context, $txt, $sig_start;

	// Try get more time...
	@set_time_limit(600);
	if (function_exists('apache_reset_timeout'))
		apache_reset_timeout();

	// Have we exhausted all the time we allowed?
	if (time() - array_sum(explode(' ', $sig_start)) < 3)
		return;

	$context['continue_get_data'] = '?action=featuresettings;sa=sig;apply;step=' . $_GET['step'];
	$context['page_title'] = $txt['not_done_title'];
	$context['continue_post_data'] = '';
	$context['continue_countdown'] = '2';
	$context['sub_template'] = 'not_done';

	// Specific stuff to not break this template!
	$context['admin_tabs']['tabs']['sig']['is_selected'] = true;

	// Get the right percent.
	$context['continue_percent'] = round(($_GET['step'] / $context['max_member']) * 100);

	// Never more than 100%!
	$context['continue_percent'] = min($context['continue_percent'], 100);

	obExit();
}

function ModifyThankYouPostSettings()
{
	global $txt, $scripturl, $context, $settings, $sc;

	$config_vars = array(
			// Thank You Post, some Stanadard settings :)
			array('check', 'thankYouPostOnePerPost'),
			array('check', 'thankYouPostColors'),
			array('check', 'thankYouPostDisplayPage'),
		'',
			// Okay only the preview settings :)
			array('check', 'thankYouPostPreview'),
			array('int', 'thankYouPostPreviewHM'),
			array('select', 'thankYouPostPreviewOrder', explode('|', $txt['thankYouPostPreviewOrderSelect'])),
		'',
			// Okay only the Full List settings :)
			array('select', 'thankYouPostFullOrder', explode('|', $txt['thankYouPostFullOrderSelect'])),
		'',
			//Hmm it'S compatible to my Hide Mod... and have two options xD
			array('check', 'thankYouPostUnhidePost'),
			array('check', 'thankYouPostThxUnhideAll'),
			array('check', 'thankYouPostDisableUnhide'),
	);

	// Saving?
	if (isset($_GET['save']))
	{
		saveDBSettings($config_vars);
		redirectexit('action=featuresettings;sa=thankyoupost');
	}

	$context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=thankyoupost';
	$context['settings_title'] = $txt['thankyouposttitle'];

	prepareDBSettingContext($config_vars);
}

loadLanguage('sbox');

function ModifySboxSettings() {
  global $txt, $scripturl, $context, $settings, $sc;

  $config_vars = array(
    // Generic stuff
    array('check', 'sbox_Visible'),
    array('check', 'sbox_ModsRule'),
    array('check', 'sbox_DoHistory'),
    '',
    // Guest stuff
    array('check', 'sbox_GuestVisible'),
    array('check', 'sbox_GuestAllowed'),
    array('check', 'sbox_GuestBBC'),
    '',
    // Visual
    array('check', 'sbox_SmiliesVisible'),
    array('check', 'sbox_UserLinksVisible'),
    array('check', 'sbox_AllowBBC'),
    array('check', 'sbox_NewShoutsBar'),
    array('int', 'sbox_MaxLines'),
    array('int', 'sbox_Height'),
    '',
    // Miscellaneous
    array('int', 'sbox_RefreshTime'),
    array('check', 'sbox_BlockRefresh'),
    array('check', 'sbox_EnableSounds'),
    '',
    // Font stuff
    array('select', 'sbox_FontFamily', array(
        'Garamond, serif' => 'Garamond, serif',
        'Times, serif' => 'Times, serif',
        'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
        'Tahoma, Helvetica, sans-sarif' => 'Tahoma, Helvetica, sans-sarif',
        'Verdana, sans-serif' => 'Verdana, sans-serif',
        'cursive' => 'cursive',
        'Palatino, fantasy' => 'Palatino, fantasy',
        'Courier, monospace' => 'Courier, monospace'
      ),
    ),
    array('select', 'sbox_TextSize', array(
        '6pt' => '6pt',
        '7pt' => '7pt',
        '8pt' => '8pt',
        '9pt' => '9pt',
        '10pt' => '10pt',
        '11pt' => '11pt',
        '12pt' => '12pt',
        '13pt' => '13pt',
        '14pt' => '14pt',
        '15pt' => '15pt',
        '16pt' => '16pt',
        'xx-small' => 'xx-small',
        'x-small' => 'x-small',
        'small' => 'small',
        'medium' => 'medium',
        'large' => 'large',
        'x-large' => 'x-large',
        'xx-large' => 'xx-large'
      ),
    ),
    array('text', 'sbox_TextColor1'),
    array('text', 'sbox_DarkThemes'),
    array('text', 'sbox_TextColor2'),
  );

  // Saving?
  if (isset($_GET['save'])) {
    saveDBSettings($config_vars);
    redirectexit('action=featuresettings;sa=sbox');
  }

  $context['post_url'] = $scripturl . '?action=featuresettings2;save;sa=sbox';
  $context['settings_title'] = $txt['sbox_ModTitle'];

  prepareDBSettingContext($config_vars);
}


?>