<?php
/**********************************************************************************
* Modlog.php                                                                      *
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

/*	The moderation log is this file's only job.  It views it, and that's about
	all it does.

	void ViewModlog()
		- prepares the information from the moderation log for viewing.
		- disallows the deletion of events within twenty-four hours of now.
		- requires the admin_forum permission.
		- uses the Modlog template, main sub template.
		- is accessed via ?action=modlog.
*/

// Show the moderation log
function ViewModlog()
{
	global $db_prefix, $txt, $modSettings, $context, $scripturl;
	
	loadTemplate('Modlog');

	$context['page_title'] = 'Historial de moderaci&oacute;n';
	// The number of entries to show per page of log file.
	$displaypage = 30;
	// Amount of hours that must pass before allowed to delete file.
	$hoursdisable = 24;

	// Handle deletion...
	if (isset($_POST['removeall']))
		db_query("
			DELETE FROM {$db_prefix}log_actions
			WHERE logtime < " . (time() - $hoursdisable * 3600), __FILE__, __LINE__);
	elseif (!empty($_POST['remove']) && isset($_POST['delete']))
		db_query("
			DELETE FROM {$db_prefix}log_actions
			WHERE ID_ACTION IN ('" . implode("', '", array_unique($_POST['delete'])) . "')
				AND logTime < " . (time() - $hoursdisable * 3600), __FILE__, __LINE__);

	// Pass order and direction variables to template so they can be used after a remove command.
	$context['dir'] = isset($_REQUEST['d']) ? ';d' : '';
	$context['sort_direction'] = !isset($_REQUEST['d']) ? 'down' : 'up';

	// Do the column stuff!
	$context['columns'] = array(
		'action' => array('sql' => 'lm.action', 'label' => 'aaaa'),
		'time' => array('sql' => 'lm.logTime', 'label' => $txt['modlog_date']),
		'member' => array('sql' => 'mem.realName', 'label' => $txt['modlog_member']),
		'group' => array('sql' => 'mg.groupName', 'label' => $txt['modlog_position']),
		'ip' => array('sql' => 'lm.ip', 'label' => $txt['modlog_ip'])
	);

	// Setup the direction stuff...
	$context['order'] = isset($_REQUEST['order']) && isset($context['columns'][$_REQUEST['order']]) ? $_REQUEST['order'] : 'time';
	$orderType = $context['columns'][$context['order']]['sql'];

	// If we're coming from a search, get the variables.
	if (isset($_REQUEST['params']))
	{
		$search_params = base64_decode(strtr($_REQUEST['params'], array(' ' => '+')));
		$search_params = @unserialize($search_params);

		// To be sure, let's slash all the elements.
		foreach ($search_params as $key => $value)
			$search_params[$key] = addslashes($value);
	}

	// If we have no search, a broken search, or a new search - then create a new array.
	if (!isset($search_params['string']) || (!empty($_REQUEST['search']) && $search_params['string'] != $_REQUEST['search']))
	{
		// This array houses all the valid search types.
		$searchTypes = array(
			'action' => array('sql' => 'lm.action', 'label' => $txt['modlog_action']),
			'member' => array('sql' => 'mem.realName', 'label' => $txt['modlog_member']),
			'group' => array('sql' => 'mg.groupName', 'label' => $txt['modlog_position']),
			'ip' => array('sql' => 'lm.ip', 'label' => $txt['modlog_ip'])
		);

		$search_params = array(
			'string' => empty($_REQUEST['search']) ? '' : $_REQUEST['search'],
			'type' => isset($_REQUEST['search_type']) && isset($searchTypes[$_REQUEST['search_type']]) ? $_REQUEST['search_type'] : isset($searchTypes[$context['order']]) ? $context['order'] : 'member',
			'type_sql' => isset($_REQUEST['search_type']) && isset($searchTypes[$_REQUEST['search_type']]) ? $searchTypes[$_REQUEST['search_type']]['sql'] : isset($searchTypes[$context['order']]) ? $context['columns'][$context['order']]['sql'] : 'mem.realName',
			'type_label' => isset($_REQUEST['search_type']) && isset($searchTypes[$_REQUEST['search_type']]) ? $searchTypes[$_REQUEST['search_type']]['label'] : isset($searchTypes[$context['order']]) ? $context['columns'][$context['order']]['label'] : $txt['modlog_member'],
		);
	}

	// Setup the search context.
	$context['search_params'] = empty($search_params['string']) ? '' : base64_encode(serialize($search_params));
	$context['search'] = array(
		'string' => stripslashes($search_params['string']),
		'type' => $search_params['type'],
		'label' => $search_params['type_label']
	);

	// This text array holds all the formatting for the supported reporting type.
	$descriptions = array(
		'lock' => 'Cerrado',
		'sticky' => 'Sticky',
		'modify' => '<font style="color: #00BA00;">Editado</font>',
		'merge' => $txt['modlog_ac_merged'],
		'split' => $txt['modlog_ac_split'],
		'move' => 'Movido',
		'remove' => '<font style="color: #FF0000;">Eliminado</font>',
		'delete' => '<font style="color: #FF9114;">Coment Eliminado</font>',
		'delete_member' => '<font style="color: #FF0000;">Miembro eliminado</font>',
		'ban' => 'Baneado',
		'causa' => '<b style="color: #FF0000;">Causa</b>',
		'news' => 'Nuevo',
		'profile' => 'Perfil',
		'pruned' => $txt['modlog_ac_pruned'],
	);

	// If they are searching by action, then we must do some manual intervention to search in their language!
	if ($search_params['type'] == 'action' && !empty($search_params['string']))
	{
		// For the moment they can only search for ONE action!
		foreach ($descriptions as $key => $text)
		{
			if (strpos($text, $search_params['string']) !== false)
			{
				$search_params['string'] = $key;
				break;
			}
		}
	}

	// Count the amount of entries in total for pagination.
	$result = db_query("
		SELECT COUNT(*)
		FROM {$db_prefix}log_actions AS lm
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lm.ID_MEMBER)
			LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))" . (!empty($search_params['string']) ? "
		WHERE INSTR($search_params[type_sql], '$search_params[string]')" : ''), __FILE__, __LINE__);
	list ($context['entry_count']) = mysql_fetch_row($result);
	mysql_free_result($result);

	// Create the page index.
	$context['page_index'] = constructPageIndex($scripturl . '?action=hist-mod;order=' . $context['order'] . $context['dir'] . (!empty($context['search_params']) ? ';params=' . $context['search_params'] : ''), $_REQUEST['start'], $context['entry_count'], $displaypage);
	$context['start'] = $_REQUEST['start'];

	// Here we have the query getting the log details.
	$result = db_query("
		SELECT
			lm.ID_ACTION, lm.ID_MEMBER, lm.ip, lm.logTime, lm.action, lm.extra,
			mem.realName, mg.groupName
		FROM {$db_prefix}log_actions AS lm
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lm.ID_MEMBER)
			LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))" . (!empty($search_params['string']) ? "
		WHERE INSTR($search_params[type_sql], '$search_params[string]')" : '') . "
		ORDER BY $orderType" . (isset($_REQUEST['d']) ? '' : ' DESC') . "
		LIMIT $context[start], $displaypage", __FILE__, __LINE__);

	// Arrays for decoding objects into.
	$topics = array();
	$boards = array();
	$members = array();
	$context['entries'] = array();
	while ($row = mysql_fetch_assoc($result))
	{
		$row['extra'] = unserialize($row['extra']);

		// Corrupt?
		$row['extra'] = is_array($row['extra']) ? $row['extra'] : array();

		// Is this associated with a topic?
		if (isset($row['extra']['topic']))
			$topics[(int) $row['extra']['topic']][] = $row['ID_ACTION'];
		if (isset($row['extra']['new_topic']))
			$topics[(int) $row['extra']['new_topic']][] = $row['ID_ACTION'];

		// How about a member?
		if (isset($row['extra']['member']))
			$members[(int) $row['extra']['member']][] = $row['ID_ACTION'];

		// Associated with a board?
		if (isset($row['extra']['board_to']))
			$boards[(int) $row['extra']['board_to']][] = $row['ID_ACTION'];
		if (isset($row['extra']['board_from']))
			$boards[(int) $row['extra']['board_from']][] = $row['ID_ACTION'];

		// IP Info?
		if (isset($row['extra']['ip_range']))
			$row['extra']['ip_range'] = '<a href="' . $scripturl . '?action=trackip;searchip=' . $row['extra']['ip_range'] . '">' . $row['extra']['ip_range'] . '</a>';

		// Email?
		if (isset($row['extra']['email']))
			$row['extra']['email'] = '<a href="mailto:' . $row['extra']['email'] . '">' . $row['extra']['email'] . '</a>';

		// The array to go to the template. Note here that action is set to a "default" value of the action doesn't match anything in the descriptions. Allows easy adding of logging events with basic details.
		$context['entries'][$row['ID_ACTION']] = array(
			'id' => $row['ID_ACTION'],
			'ip' => $row['ip'],
			'position' => $row['groupName'],
			'moderator' => array(
				'id' => $row['ID_MEMBER'],
				'name' => $row['realName'],
				'href' => $scripturl. '?action=profile;user=' . $row['realName'],
				'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row['realName'] . '">' . $row['realName'] . '</a>'
			),
			'time' => timeformat($row['logTime']),
			'timestamp' => forum_time(true, $row['logTime']),
			'editable' => time() > $row['logTime'] + $hoursdisable * 3600,
			'extra' => $row['extra'],
			'action' => isset($descriptions[$row['action']]) ? $descriptions[$row['action']] : $row['action'],
		);
	}
	mysql_free_result($result);

	if (!empty($boards))
	{
		$request = db_query("
			SELECT ID_BOARD, name
			FROM {$db_prefix}boards
			WHERE ID_BOARD IN (" . implode(', ', array_keys($boards)) . ")
			LIMIT " . count(array_keys($boards)), __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
		{
			foreach ($boards[$row['ID_BOARD']] as $action)
			{
				// Make the board number into a link - dealing with moving too.
				if ($context['entries'][$action]['extra']['board_to'] == $row['ID_BOARD'])
					$context['entries'][$action]['extra']['board_to'] = '<a href="'. $scripturl .'?id=' . $row['ID_BOARD'] . '">' . $row['name'] . '</a>';
				elseif ($context['entries'][$action]['extra']['board_from'] == $row['ID_BOARD'])
					$context['entries'][$action]['extra']['board_from'] = '<a href="'. $scripturl .'?id=' . $row['ID_BOARD'] . '">' . $row['name'] . '</a>';
			}
		}
		mysql_free_result($request);
	}

	if (!empty($topics))
	{
		$request = db_query("
			SELECT ms.subject, t.ID_TOPIC
			FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS ms)
			WHERE t.ID_TOPIC IN (" . implode(', ', array_keys($topics)) . ")
				AND ms.ID_MSG = t.ID_FIRST_MSG
			LIMIT " . count(array_keys($topics)), __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
		{
			foreach ($topics[$row['ID_TOPIC']] as $action)
			{
				$this_action = &$context['entries'][$action];

				// This isn't used in the current theme.
				$this_action['topic'] = array(
					'id' => $row['ID_TOPIC'],
					'subject' => $row['subject'],
					'href' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '',
					'link' => '<a href="'. $scripturl .'?topic=' . $row['ID_TOPIC'] . '">' . $row['subject'] . '</a>'
				);

				// Make the topic number into a link - dealing with splitting too.
				if ($this_action['extra']['topic'] == $row['ID_TOPIC'])
					$this_action['extra']['topic'] = '<a href="'. $scripturl .'?topic=' . $row['ID_TOPIC'] . '">' . $row['subject'] . '</a>';
				elseif ($this_action['extra']['new_topic'] == $row['ID_TOPIC'])
					$this_action['extra']['new_topic'] = '<a href="'. $scripturl .'?topic=' . $row['ID_TOPIC'] . '">' . $row['subject'] . '</a>';
			}
		}
		mysql_free_result($request);
	}

	if (!empty($members))
	{
		$request = db_query("
			SELECT realName, ID_MEMBER
			FROM {$db_prefix}members
			WHERE ID_MEMBER IN (" . implode(', ', array_keys($members)) . ")
			LIMIT " . count(array_keys($members)), __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
		{
			foreach ($members[$row['ID_MEMBER']] as $action)
			{
				// Not used currently.
				$context['entries'][$action]['member'] = array(
					'id' => $row['ID_MEMBER'],
					'name' => $row['realName'],
					'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
					'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row['realName'] . '">' . $row['realName'] . '</a>'
				);
				// Make the member number into a name.
				$context['entries'][$action]['extra']['member'] = '<a href="'. $scripturl .'?action=profile;user=' . $row['realName'] . '">' . $row['realName'] . '</a>';
			}
		}
		mysql_free_result($request);
	}
}

?>