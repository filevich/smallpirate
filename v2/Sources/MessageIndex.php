<?php
/**********************************************************************************
* MessageIndex.php                                                                *
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

/*	This file is what shows the listing of topics in a board.  It's just one
	function, but don't under estimate it ;).

	void MessageIndex()
		// !!!
*/

// Show the list of topics in this board, along with any child boards.
function MessageIndex()
{
	global $txt, $scripturl, $board, $db_prefix;
	global $modSettings, $ID_MEMBER;
	global $context, $options, $settings, $board_info, $user_info, $func;


  $request = db_query("
		SELECT m.ID_MEMBER, i.ID_MEMBER, i.ID_PICTURE, i.filename, i.title, m.memberName, i.commenttotal, m.realName
FROM ({$db_prefix}gallery_pic AS i, {$db_prefix}members AS m)
WHERE i.ID_MEMBER = m.ID_MEMBER
ORDER BY RAND()
LIMIT 0 , 1", __FILE__, __LINE__);
	$context['imgaletatoria'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['imgaletatoria'][] = array(
			'id' => $row['ID_PICTURE'],
			'filename' => $row['filename'],
			'title' => $row['title'],
			'commenttotal' => $row['commenttotal'],
		);
	mysql_free_result($request);

	$query = "	SELECT ta.tag, t.ID_TAG, COUNT(*) as quantity
		FROM smf_tags_log AS t
		LEFT JOIN smf_tags AS ta ON (ta.ID_TAG = t.ID_TAG)
		WHERE t.ID_TAG != 0
		GROUP BY ta.ID_TAG
		ORDER BY quantity DESC
		LIMIT 30";
		
		$result = db_query($query, __FILE__, __LINE__);
		$tags = array();
		$tags2 = array();
		$max_num_posts = 1;
		while ($row = mysql_fetch_array($result)) 
		{
		    $tags[$row['tag']] = $row['quantity'];
		    $tags2[$row['tag']] = $row['ID_TAG'];
		    
		if ($max_num_posts < $tags[$row['tag']])
			$max_num_posts = $tags[$row['tag']];
	
		}
		if(count($tags2) > 0)
		{
    		$max_size = 120;
			$min_size = 100; 
			$max_qty = max(array_values($tags));
			$min_qty = min(array_values($tags));
			$spread = $max_qty - $min_qty;
			if (0 == $spread)
	        { 
			    $spread = 1;
			}
			$step = ($max_size - $min_size)/($spread);
			$context['poptags'] = '';
			$row_count = 0;
			foreach ($tags as $key => $value) 
			{
                $cantidad2 = $key;
    			$row_count++;
			    $size = $min_size + (($value - $min_qty) * $step);
			    $context['poptags'] .= '<a href="'. $scripturl .'/?action=tags;id=' . $tags2[$key] . '" style="font-size: '.$size.'%; padding: 0px 3px 0px 3px;"';
			    $context['poptags'] .= ' title="'.$value.' tags con la palabra '.$key.'"';
			   $context['poptags'] .= '>'.$cantidad2++.'</a>';
			   if ($row_count > 5)
			   {
               $context['poptags'] .= '<br><br>';
			   $row_count =0;
			   }
		   }
		}

		$dbresult = db_query("
		SELECT DISTINCT l.ID_TOPIC, t.numReplies,t.numViews,m.ID_MEMBER,m.posterName,m.subject,m.ID_TOPIC,m.posterTime, t.ID_BOARD 
		 FROM {$db_prefix}tags_log as l,{$db_prefix}boards AS b, {$db_prefix}topics as t, {$db_prefix}messages as m 
		 WHERE b.ID_BOARD = t.ID_BOARD AND l.ID_TOPIC = t.ID_TOPIC AND t.ID_FIRST_MSG = m.ID_MSG AND " . $user_info['query_see_board'] . " ORDER BY l.ID DESC LIMIT 10", __FILE__, __LINE__);
		
		$context['tags_topics'] = array();
		while ($row = mysql_fetch_assoc($dbresult))
		{
				$context['tags_topics'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'posterName' => $row['posterName'],
				'subject' => $row['subject'],
				'ID_TOPIC' => $row['ID_TOPIC'],
				'posterTime' => $row['posterTime'],
				'numViews' => $row['numViews'],
				'numReplies' => $row['numReplies'],
				
				);
		}
		mysql_free_result($dbresult);

	list($year, $month, $day) = explode('-', date('Y-m-d'));
    $starttime = mktime(0, 0, 0, $month, $day, $year);
	$starttime = forum_time(false, $starttime);
	$request = db_query("
		SELECT me.ID_MEMBER, me.memberName, me.realName, COUNT(*) as count_posts
		FROM {$db_prefix}messages AS m
			LEFT JOIN {$db_prefix}members AS me ON (me.ID_MEMBER = m.ID_MEMBER)
		WHERE m.posterTime > " . $starttime . "
			AND m.ID_MEMBER != 0
		GROUP BY me.ID_MEMBER
		ORDER BY count_posts DESC
		LIMIT 10", __FILE__, __LINE__);
	$context['top_posters_day'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($request))
	{
		$context['top_posters_day'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['count_posts'],
			'href' => $scripturl . '?action=profile;user=' . $row_members['memberName'],
			'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row_members['memberName'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_posts < $row_members['count_posts'])
			$max_num_posts = $row_members['count_posts'];
	}
	mysql_free_result($request);

	foreach ($context['top_posters_day'] as $i => $j)
		$context['top_posters_day'][$i]['post_percent'] = round(($j['num_posts'] * 100) / $max_num_posts);
	unset($max_num_posts, $row_members, $j, $i);
	$starttime = mktime(0, 0, 0, date("n"), date("j"), date("Y")) - (date("N")*3600*24);
	$starttime = forum_time(false, $starttime);
	
	$request = db_query("
		SELECT me.ID_MEMBER, me.memberName, me.realName, COUNT(*) as count_posts
		FROM {$db_prefix}messages AS m
			LEFT JOIN {$db_prefix}members AS me ON (me.ID_MEMBER = m.ID_MEMBER)
		WHERE m.posterTime > " . $starttime . "
			AND m.ID_MEMBER != 0
		GROUP BY me.ID_MEMBER
		ORDER BY count_posts DESC
		LIMIT 10", __FILE__, __LINE__);
			
	$context['top_posters_week'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($request))
	{
		$context['top_posters_week'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['count_posts'],
			'href' => $scripturl . '?action=profile;user=' . $row_members['memberName'],
			'link' => '<a href="'. $scripturl .'/?action=profile;user=' . $row_members['memberName'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_posts < $row_members['count_posts'])
			$max_num_posts = $row_members['count_posts'];
	}
	mysql_free_result($request);

	foreach ($context['top_posters_week'] as $i => $j)
		$context['top_posters_week'][$i]['post_percent'] = round(($j['num_posts'] * 100) / $max_num_posts);
	unset($max_num_posts, $row_members, $j, $i);

	$request = db_query("
		SELECT b.ID_BOARD, b.name, b.childLevel, c.name AS catName
		FROM {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}categories AS c ON (c.ID_CAT = b.ID_CAT)
		WHERE b.ID_BOARD != $board
			AND $user_info[query_see_board]", __FILE__, __LINE__);
	$context['boards'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['boards'][] = array(
			'id' => $row['ID_BOARD'],
			'name' => $row['name'],
			'category' => $row['catName'],
			'child_level' => $row['childLevel'],
		);
	mysql_free_result($request);

	$result = db_query("
		SELECT
			lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
			mg.onlineColor, mg.ID_GROUP, mg.groupName
		FROM {$db_prefix}log_online AS lo
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
			LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))", __FILE__, __LINE__);

	$context['users_online'] = array();
	$context['list_users_online'] = array();
	$context['online_groups'] = array();
	$context['num_guests'] = 0;
	$context['num_buddies'] = 0;
	$context['num_users_hidden'] = 0;

	$context['show_buddies'] = !empty($user_info['buddies']);

	while ($row = mysql_fetch_assoc($result))
	{
		if (empty($row['realName']))
		{
			$context['num_guests']++;
			continue;
		}
		elseif (empty($row['showOnline']) && !allowedTo('moderate_forum'))
		{
			$context['num_users_hidden']++;
			continue;
		}

			
			$link = '';
	
		$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
		if ($is_buddy)
		{
			$context['num_buddies']++;
			$link = '' . $link . '';
		}

		$context['users_online'][$row['logTime'] . $row['memberName']] = array(
			'id' => $row['ID_MEMBER'],
			'username' => $row['memberName'],
			'name' => $row['realName'],
			'group' => $row['ID_GROUP'],
			'href' => $scripturl . '?action=profile;user=' . $row['memberName'],
			'link' => $link,
			'is_buddy' => $is_buddy,
			'hidden' => empty($row['showOnline']),
		);

		$context['list_users_online'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;

		if (!isset($context['online_groups'][$row['ID_GROUP']]))
			$context['online_groups'][$row['ID_GROUP']] = array(
				'id' => $row['ID_GROUP'],
				'name' => $row['groupName'],
				'color' => $row['onlineColor']
			);
	}
	mysql_free_result($result);

	krsort($context['users_online']);
	krsort($context['list_users_online']);
	ksort($context['online_groups']);
	
	$context['num_users_online_today'] = count($context['users_online_today']);
	if (!$user_info['is_admin'])
	{
		$context['num_users_online_today'] = $context['num_users_online_today'] + $context['num_hidden_users_online_today'];
	}

	$context['num_users_online'] = count($context['users_online']) + $context['num_users_hidden'];
	while ($row = mysql_fetch_assoc($request))
	{
		$actions = @unserialize($row['url']);
		if ($actions === false)
			continue;

		$context['members'][$row['session']] = array(
			'id' => $row['ID_MEMBER'],
			'ip' => allowedTo('moderate_forum') ? $row['ip'] : '',
			'time' => strtr(timeformat($row['logTime']), array($txt['smf10'] => '', $txt['smf10b'] => '')),
			'timestamp' => forum_time(true, $row['logTime']),
			'query' => $actions,
			'color' => empty($row['onlineColor']) ? '' : $row['onlineColor']
		);

		$url_data[$row['session']] = array($row['url'], $row['ID_MEMBER']);
		$member_ids[] = $row['ID_MEMBER'];
	}
	mysql_free_result($request);
	
$members_result = db_query("
		SELECT ID_MEMBER, realName, memberName, posts
		FROM {$db_prefix}members
		WHERE posts > 0
		ORDER BY posts DESC
		LIMIT 10", __FILE__, __LINE__);
	$context['top_posters'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		$context['top_posters'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['posts'],
			'href' => $scripturl . '?action=profile;user=' . $row_members['memberName'],
			'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row_members['memberName'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_posts < $row_members['posts'])
			$max_num_posts = $row_members['posts'];
	}
	mysql_free_result($members_result);
	
	$members_result = db_query("
		SELECT ID_MEMBER, realName,memberName, topics
		FROM {$db_prefix}members
		WHERE topics > 0
		ORDER BY topics DESC
		LIMIT 10", __FILE__, __LINE__);
	$context['top_starters'] = array();
	$max_num_topics = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		$context['top_starters'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_topics' => $row_members['topics'],
			'href' => $scripturl . '?action=profile;user=' . $row_members['memberName'],
			'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row_members['memberName'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_topics < $row_members['topics'])
			$max_num_topics = $row_members['topics'];
	}
	mysql_free_result($members_result);

			$context['shop_richest'] = array();
		$result = db_query("
			SELECT ID_MEMBER, realName, money
			FROM {$db_prefix}members
			ORDER BY money DESC, realName
			LIMIT 10", __FILE__, __LINE__);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			$context['shop_richest'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'realName' => $row['realName'],
				'money' => $row['money']
			);
			
			$members_result = db_query("
SELECT ID_MEMBER, realName, memberName, posts
FROM {$db_prefix}members
ORDER BY ID_MEMBER DESC
LIMIT 10", __FILE__, __LINE__);
	$context['yeniuyeler'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		
		$context['yeniuyeler'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['posts'],
			'href' => $scripturl . '?action=profile;user=' . $row_members['memberName'],
			'link' => '<a href="'. $scripturl .'?action=profile;user=' . $row_members['memberName'] . '">' . $row_members['realName'] . '</a>'
		);

		
if (!empty($modSettings['MemberColorStats']))
			$MemberColor_ID_MEMBER[$row_members['ID_MEMBER']] = $row_members['ID_MEMBER'];


if ($max_num_posts < $row_members['posts'])
			$max_num_posts = $row_members['posts'];
	}
	mysql_free_result($members_result);

	if (WIRELESS)
		$context['sub_template'] = WIRELESS_PROTOCOL . '_messageindex';
	else
		loadTemplate('MessageIndex');

	$context['name'] = $board_info['name'];
	$context['description'] = $board_info['description'];

	// View all the topics, or just a few?
	$maxindex = isset($_REQUEST['all']) && !empty($modSettings['enableAllMessages']) ? $board_info['num_topics'] : $modSettings['defaultMaxTopics'];

	// Make sure the starting place makes sense and construct the page index.
	if (isset($_REQUEST['sort']))
		$context['page_index'] = constructPageIndex($scripturl . '?board=' . $board . '.%d;sort=' . $_REQUEST['sort'] . (isset($_REQUEST['desc']) ? ';desc' : ''), $_REQUEST['start'], $board_info['num_topics'], $maxindex, true);
	else
		$context['page_index'] = constructPageIndex($scripturl . '?board=' . $board . '.%d', $_REQUEST['start'], $board_info['num_topics'], $maxindex, true);
	$context['start'] = &$_REQUEST['start'];

	$context['links'] = array(
		'first' => $_REQUEST['start'] >= $modSettings['defaultMaxTopics'] ? $scripturl . '?board=' . $board . '.0' : '',
		'prev' => $_REQUEST['start'] >= $modSettings['defaultMaxTopics'] ? $scripturl . '?board=' . $board . '.' . ($_REQUEST['start'] - $modSettings['defaultMaxTopics']) : '',
		'next' => $_REQUEST['start'] + $modSettings['defaultMaxTopics'] < $board_info['num_topics'] ? $scripturl . '?board=' . $board . '.' . ($_REQUEST['start'] + $modSettings['defaultMaxTopics']) : '',
		'last' => $_REQUEST['start'] + $modSettings['defaultMaxTopics'] < $board_info['num_topics'] ? $scripturl . '?board=' . $board . '.' . (floor(($board_info['num_topics'] - 1) / $modSettings['defaultMaxTopics']) * $modSettings['defaultMaxTopics']) : '',
		'up' => $board_info['parent'] == 0 ? $scripturl . '?' : $scripturl . '?board=' . $board_info['parent'] . '.0'
	);

	$context['page_info'] = array(
		'current_page' => $_REQUEST['start'] / $modSettings['defaultMaxTopics'] + 1,
		'num_pages' => floor(($board_info['num_topics'] - 1) / $modSettings['defaultMaxTopics']) + 1
	);

	if (isset($_REQUEST['all']) && !empty($modSettings['enableAllMessages']) && $maxindex > $modSettings['enableAllMessages'])
	{
		$maxindex = $modSettings['enableAllMessages'];
		$_REQUEST['start'] = 0;
	}

	// Build a list of the board's moderators.
	$context['moderators'] = &$board_info['moderators'];
	$context['link_moderators'] = array();
	if (!empty($board_info['moderators']))
	{
		foreach ($board_info['moderators'] as $mod)
			$context['link_moderators'][] ='<a href="'. $scripturl .'?action=profile;user=' . $mod['name'] . '" title="' . $txt[62] . '">' . $mod['name'] . '</a>';

		$context['linktree'][count($context['linktree']) - 1]['extra_after'] = ' (' . (count($context['link_moderators']) == 1 ? $txt[298] : $txt[299]) . ': ' . implode(', ', $context['link_moderators']) . ')';
	}

	// Mark current and parent boards as seen.
	if (!$user_info['is_guest'])
	{
		// We can't know they read it if we allow prefetches.
		if (isset($_SERVER['HTTP_X_MOZ']) && $_SERVER['HTTP_X_MOZ'] == 'prefetch')
		{
			ob_end_clean();
			header('HTTP/1.1 403 Prefetch Forbidden');
			die;
		}

		db_query("
			REPLACE INTO {$db_prefix}log_boards
				(ID_MSG, ID_MEMBER, ID_BOARD)
			VALUES ($modSettings[maxMsgID], $ID_MEMBER, $board)", __FILE__, __LINE__);
		if (!empty($board_info['parent_boards']))
		{
			db_query("
				UPDATE {$db_prefix}log_boards
				SET ID_MSG = $modSettings[maxMsgID]
				WHERE ID_MEMBER = $ID_MEMBER
					AND ID_BOARD IN (" . implode(',', array_keys($board_info['parent_boards'])) . ")
				LIMIT " . count($board_info['parent_boards']), __FILE__, __LINE__);

			// We've seen all these boards now!
			foreach ($board_info['parent_boards'] as $k => $dummy)
				if (isset($_SESSION['topicseen_cache'][$k]))
					unset($_SESSION['topicseen_cache'][$k]);
		}

		if (isset($_SESSION['topicseen_cache'][$board]))
			unset($_SESSION['topicseen_cache'][$board]);

		$request = db_query("
			SELECT sent
			FROM {$db_prefix}log_notify
			WHERE ID_BOARD = $board
				AND ID_MEMBER = $ID_MEMBER
			LIMIT 1", __FILE__, __LINE__);
		$context['is_marked_notify'] = mysql_num_rows($request) != 0;
		if ($context['is_marked_notify'])
		{
			list ($sent) = mysql_fetch_row($request);
			if (!empty($sent))
			{
				db_query("
					UPDATE {$db_prefix}log_notify
					SET sent = 0
					WHERE ID_BOARD = $board
						AND ID_MEMBER = $ID_MEMBER
					LIMIT 1", __FILE__, __LINE__);
			}
		}
		mysql_free_result($request);
	}
	else
		$context['is_marked_notify'] = false;

	// 'Print' the header and board info.
	$context['page_title'] = strip_tags($board_info['name']);

	// Set the variables up for the template.
	$context['can_mark_notify'] = allowedTo('mark_notify') && !$user_info['is_guest'];
	$context['can_post_new'] = allowedTo('post_new');
	$context['can_post_poll'] = $modSettings['pollMode'] == '1' && allowedTo('poll_post');
	$context['can_moderate_forum'] = allowedTo('moderate_forum');


//stick
$request = db_query("
SELECT t.ID_TOPIC, m.subject, t.isSticky, m.ID_BOARD, b.name
FROM ({$db_prefix}topics AS t, {$db_prefix}boards AS b)
INNER JOIN {$db_prefix}messages AS m
ON t.ID_TOPIC = m.ID_TOPIC
WHERE t.isSticky = 1 AND m.ID_BOARD = $board AND t.ID_BOARD = b.ID_BOARD
ORDER BY m.ID_TOPIC DESC", __FILE__, __LINE__);

	$context['Stick2'] = array();
	while ($row = mysql_fetch_assoc($request))
	{		$context['Stick2'][$row['ID_TOPIC']] = array(
			'id' => $row['ID_TOPIC'],
			'subject' => $row['subject'],
			'idcat' => $row['ID_BOARD'],
			'cat' => $row['name'],);
	}
	mysql_free_result($request);

//mensajes:
	$result = db_query("
		SELECT
			b.ID_BOARD, b.name, b.description, b.numTopics, b.numPosts,
			m.posterName, m.posterTime, m.subject, m.ID_MSG, m.ID_TOPIC,
			IFNULL(mem.realName, m.posterName) AS realName, " . (!$user_info['is_guest'] ? "
			(IFNULL(lb.ID_MSG, 0) >= b.ID_MSG_UPDATED) AS isRead," : "1 AS isRead,") . "
			IFNULL(mem.ID_MEMBER, 0) AS ID_MEMBER, IFNULL(mem2.ID_MEMBER, 0) AS ID_MODERATOR,
			mem2.realName AS modRealName
		FROM {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}messages AS m ON (m.ID_MSG = b.ID_LAST_MSG)
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)" . (!$user_info['is_guest'] ? "
			LEFT JOIN {$db_prefix}log_boards AS lb ON (lb.ID_BOARD = b.ID_BOARD AND lb.ID_MEMBER = $ID_MEMBER)" : '') . "
			LEFT JOIN {$db_prefix}moderators AS mods ON (mods.ID_BOARD = b.ID_BOARD)
			LEFT JOIN {$db_prefix}members AS mem2 ON (mem2.ID_MEMBER = mods.ID_MEMBER)
		WHERE b.ID_PARENT = $board
			AND $user_info[query_see_board]", __FILE__, __LINE__);
	if (mysql_num_rows($result) != 0)
	{
		$theboards = array();
		while ($row_board = mysql_fetch_assoc($result))
		{
			if (!isset($context['boards'][$row_board['ID_BOARD']]))
			{
				$theboards[] = $row_board['ID_BOARD'];

				// Make sure the subject isn't too long.
				censorText($row_board['subject']);
				$short_subject = shorten_subject($row_board['subject'], 24);

				$context['boards'][$row_board['ID_BOARD']] = array(
					'id' => $row_board['ID_BOARD'],
					'last_post' => array(
						'id' => $row_board['ID_MSG'],
						'time' => $row_board['posterTime'] > 0 ? timeformat($row_board['posterTime']) : $txt[470],
						'timestamp' => forum_time(true, $row_board['posterTime']),
						'subject' => $short_subject,
						'member' => array(
							'id' => $row_board['ID_MEMBER'],
							'username' => $row_board['posterName'] != '' ? $row_board['posterName'] : $txt[470],
							'name' => $row_board['realName'],
							'href' => !empty($row_board['ID_MEMBER']) ? ''. $scripturl .'?action=profile;user=' . $row_board['posterName'] : '',
							'link' => $row_board['posterName'] != '' ? (!empty($row_board['posterName']) ? '<a href="'. $scripturl .'?action=profile;user=' . $row_board['posterName'] . '">' . $row_board['realName'] . '</a>' : $row_board['realName']) : $txt[470],
						),
						'start' => 'new',
						'topic' => $row_board['ID_TOPIC'],
						'href' => $row_board['subject'] != '' ? ''. $scripturl .'?topic=' . $row_board['ID_TOPIC'] . '.new' . (empty($row_board['isRead']) ? ';boardseen' : '') . '#new' : '',
						'link' => $row_board['subject'] != '' ? '<a href="'. $scripturl .'?topic=' . $row_board['ID_TOPIC'] . '/' . str_replace(' ','-',$row_board['subject']) . '" title="' . $row_board['subject'] . '">' . $short_subject . '</a>' : $txt[470]
					),
					'new' => empty($row_board['isRead']) && $row_board['posterName'] != '',
					'name' => $row_board['name'],
					'description' => $row_board['description'],
					'moderators' => array(),
					'link_moderators' => array(),
					'children' => array(),
					'link_children' => array(),
					'children_new' => false,
					'topics' => $row_board['numTopics'],
					'posts' => $row_board['numPosts'],
					'href' => $scripturl . '?id=' . $row_board['ID_BOARD'] . '',
					'link' => '<a href="'. $scripturl .'?id=' . $row_board['ID_BOARD'] . '">' . $row_board['name'] . '</a>'
				);
			}
			if (!empty($row_board['ID_MODERATOR']))
			{
				$context['boards'][$row_board['ID_BOARD']]['moderators'][$row_board['ID_MODERATOR']] = array(
					'id' => $row_board['ID_MODERATOR'],
					'name' => $row_board['modRealName'],
					'href' => $scripturl . '?action=profile;user=' . $row_board['modRealName'],
					'link' => '<a href="' . $scripturl .'?action=profile;user=' . $row_board['modRealName'] . '" title="' . $txt[62] . '">' . $row_board['modRealName'] . '</a>'
				);
				$context['boards'][$row_board['ID_BOARD']]['link_moderators'][] = '<a href="' . $scripturl .'?action=profile;user=' . $row_board['modRealName'] . '" title="' . $txt[62] . '">' . $row_board['modRealName'] . '</a>';
			}
		}
		mysql_free_result($result);

		// Load up the child boards.
		$result = db_query("
			SELECT
				b.ID_BOARD, b.ID_PARENT, b.name, b.description, b.numTopics, b.numPosts,
				m.posterName, IFNULL(m.posterTime, 0) AS posterTime, m.subject, m.ID_MSG, m.ID_TOPIC,
				IFNULL(mem.realName, m.posterName) AS realName, ID_PARENT, 
				" . ($user_info['is_guest'] ? '1' : '(IFNULL(lb.ID_MSG, 0) >= b.ID_MSG_UPDATED)') . " AS isRead,
				IFNULL(mem.ID_MEMBER, 0) AS ID_MEMBER
			FROM {$db_prefix}boards AS b
				LEFT JOIN {$db_prefix}messages AS m ON (m.ID_MSG = b.ID_LAST_MSG)
				LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)" . (!$user_info['is_guest'] ? "
				LEFT JOIN {$db_prefix}log_boards AS lb ON (lb.ID_BOARD = b.ID_BOARD AND lb.ID_MEMBER = $ID_MEMBER)" : '') . "
			WHERE " . (empty($modSettings['countChildPosts']) ? "b.ID_PARENT IN (" . implode(',', $theboards) . ")" : "childLevel > 0") . "
				AND $user_info[query_see_board]", __FILE__, __LINE__);
		$parent_map = array();
		while ($row = mysql_fetch_assoc($result))
		{
			// We've got a child of a child, then... possibly.
			if (!in_array($row['ID_PARENT'], $theboards))
			{
				if (!isset($parent_map[$row['ID_PARENT']]))
					continue;

				$parent_map[$row['ID_PARENT']][0]['posts'] += $row['numPosts'];
				$parent_map[$row['ID_PARENT']][0]['topics'] += $row['numTopics'];
				$parent_map[$row['ID_PARENT']][1]['posts'] += $row['numPosts'];
				$parent_map[$row['ID_PARENT']][1]['topics'] += $row['numTopics'];
				$parent_map[$row['ID_BOARD']] = $parent_map[$row['ID_PARENT']];

				continue;
			}

			if ($context['boards'][$row['ID_PARENT']]['last_post']['timestamp'] < forum_time(true, $row['posterTime']))
			{
				// Make sure the subject isn't too long.
				censorText($row['subject']);
				$short_subject = shorten_subject($row['subject'], 24);

				$context['boards'][$row['ID_PARENT']]['last_post'] = array(
					'id' => $row['ID_MSG'],
					'time' => $row['posterTime'] > 0 ? timeformat($row['posterTime']) : $txt[470],
					'timestamp' => forum_time(true, $row['posterTime']),
					'subject' => $short_subject,
					'member' => array(
						'username' => $row['posterName'] != '' ? $row['posterName'] : $txt[470],
						'name' => $row['realName'],
						'id' => $row['ID_MEMBER'],
						'href' => !empty($row['ID_MEMBER']) ? '' . $scripturl .'?action=profile;user=' . $row['posterName'] : '',
						'link' => $row['posterName'] != '' ? (!empty($row['ID_MEMBER']) ? '<a href="' . $scripturl .'?action=profile;user=' . $row['posterName'] . '">' . $row['realName'] . '</a>' : $row['realName']) : $txt[470],
					),
					'start' => 'new',
					'topic' => $row['ID_TOPIC'],
					'href' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '' 
				);
				$context['boards'][$row['ID_PARENT']]['last_post']['link'] = $row['subject'] != '' ? '<a href="' . $context['boards'][$row['ID_PARENT']]['last_post']['href'] . '" title="' . $row['subject'] . '">' . $short_subject . '</a>' : $txt[470];
			}
			$context['boards'][$row['ID_PARENT']]['children'][$row['ID_BOARD']] = array(
				'id' => $row['ID_BOARD'],
				'name' => $row['name'],
				'description' => $row['description'],
				'new' => empty($row['isRead']) && $row['posterName'] != '',
				'topics' => $row['numTopics'],
				'posts' => $row['numPosts'],
				'href' => $scripturl . '?id=' . $row['ID_BOARD'] . '',
				'link' => '<a href="'. $scripturl .'?id=' . $row['ID_BOARD'] . '">' . $row['name'] . '</a>'
			);
			$context['boards'][$row['ID_PARENT']]['link_children'][] = '<a href="'. $scripturl .'?board=' . $row['ID_BOARD'] . '">' . $row['name'] . '</a>';
			$context['boards'][$row['ID_PARENT']]['children_new'] |= empty($row['isRead']) && $row['posterName'] != '';

			if (!empty($modSettings['countChildPosts']))
			{
				$context['boards'][$row['ID_PARENT']]['posts'] += $row['numPosts'];
				$context['boards'][$row['ID_PARENT']]['topics'] += $row['numTopics'];

				$parent_map[$row['ID_BOARD']] = array(&$context['boards'][$row['ID_PARENT']], &$context['boards'][$row['ID_PARENT']]['children'][$row['ID_BOARD']]);
			}
		}
	}
	mysql_free_result($result);

	if (!empty($settings['display_who_viewing']))
	{
		$context['view_members'] = array();
		$context['view_members_list'] = array();
		$context['view_num_hidden'] = 0;

		$request = db_query("
			SELECT
				lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
				mg.onlineColor, mg.ID_GROUP, mg.groupName
			FROM {$db_prefix}log_online AS lo
				LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
				LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
			WHERE INSTR(lo.url, 's:5:\"board\";i:$board;') OR lo.session = '" . ($user_info['is_guest'] ? 'ip' . $user_info['ip'] : session_id()) . "'", __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
		{
			if (empty($row['ID_MEMBER']))
				continue;

			if (!empty($row['onlineColor']))
				$link = '<a href="'. $scripturl .'?action=profile;user=' . $row['posterName'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
			else
				$link = '<a href="'. $scripturl .'?action=profile;user=' . $row['posterName'] . '">' . $row['realName'] . '</a>';

			$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
			if ($is_buddy)
				$link = '<b>' . $link . '</b>';

			if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
				$context['view_members_list'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;
			$context['view_members'][$row['logTime'] . $row['memberName']] = array(
				'id' => $row['ID_MEMBER'],
				'username' => $row['memberName'],
				'name' => $row['realName'],
				'group' => $row['ID_GROUP'],
				'href' => $scripturl . '?action=profile;user=' . $row['memberName'],
				'link' => $link,
				'is_buddy' => $is_buddy,
				'hidden' => empty($row['showOnline']),
			);

			if (empty($row['showOnline']))
				$context['view_num_hidden']++;
		}
		$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
		mysql_free_result($request);

		// Put them in "last clicked" order.
		krsort($context['view_members_list']);
		krsort($context['view_members']);
	}

	// Default sort methods.
	$sort_methods = array(
		'subject' => 'mf.subject',
		'starter' => 'IFNULL(memf.realName, mf.posterName)',
		'last_poster' => 'IFNULL(meml.realName, ml.posterName)',
		'replies' => 't.numReplies',
		'views' => 't.numViews',
		'first_post' => 't.ID_TOPIC',
		'last_post' => 't.ID_LAST_MSG'
	);

	// They didn't pick one, default to by last post descending.
	if (!isset($_REQUEST['sort']) || !isset($sort_methods[$_REQUEST['sort']]))
	{
		$context['sort_by'] = 'last_post';
		$_REQUEST['sort'] = 'ID_LAST_MSG';
		$ascending = isset($_REQUEST['asc']);
	}
	// Otherwise default to ascending.
	else
	{
		$context['sort_by'] = $_REQUEST['sort'];
		$_REQUEST['sort'] = $sort_methods[$_REQUEST['sort']];
		$ascending = !isset($_REQUEST['desc']);
	}

	$context['sort_direction'] = $ascending ? 'up' : 'down';

	// Calculate the fastest way to get the topics.
	$start = $_REQUEST['start'];
	if ($start > ($board_info['num_topics']  - 1) / 2)
	{
		$ascending = !$ascending;
		$fake_ascending = true;
		$maxindex = $board_info['num_topics'] < $start + $maxindex + 1 ? $board_info['num_topics'] - $start : $maxindex;
		$start = $board_info['num_topics'] < $start + $maxindex + 1 ? 0 : $board_info['num_topics'] - $start - $maxindex;
	}
	else
		$fake_ascending = false;

	// Setup the default topic icons...
	$stable_icons = array('xx', 'thumbup', 'thumbdown', 'exclamation', 'question', 'lamp', 'smiley', 'angry', 'cheesy', 'grin', 'sad', 'wink', 'moved', 'recycled', 'wireless');
	$context['icon_sources'] = array();
	foreach ($stable_icons as $icon)
		$context['icon_sources'][$icon] = 'images_url';

	$topic_ids = array();
	$context['topics'] = array();

	// Sequential pages are often not optimized, so we add an additional query.
	$pre_query = $start > 0;
	if ($pre_query)
	{
		$request = db_query("
			SELECT t.ID_TOPIC
			FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m)
			WHERE t.ID_BOARD = $board
			AND m.ID_MSG = t.ID_FIRST_MSG
			ORDER BY t.ID_FIRST_MSG DESC
			LIMIT $_REQUEST[start], 50", __FILE__, __LINE__);
		$topic_ids = array();
		while ($row = mysql_fetch_assoc($request))
			$topic_ids[] = $row['ID_TOPIC'];
	}

	// Grab the appropriate topic information...
	if (!$pre_query || !empty($topic_ids))
	{
		$result = db_query("
			SELECT
			t.ID_TOPIC, t.numReplies, t.locked, t.numViews, t.isSticky,	t.ID_LAST_MSG, m.subject, m.hiddenOption, m.hiddenValue, b.name
			FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)
			WHERE " . ($pre_query ? 't.ID_TOPIC IN (' . implode(', ', $topic_ids) . ')' : "t.ID_BOARD = $board") . "
			AND b.ID_BOARD = t.ID_BOARD
			AND m.ID_MSG = t.ID_FIRST_MSG
			ORDER BY t.ID_FIRST_MSG DESC
			LIMIT $_REQUEST[start], 50", __FILE__, __LINE__);

		// Begin 'printing' the message index for current board.
		while ($row = mysql_fetch_assoc($result))
		{  $row['can_view_post'] = 1;
		if (!empty($modSettings['allow_hiddenPost']) && $row['hiddenOption'] > 0)
		{
			global $sourcedir;
			require_once($sourcedir . '/HidePost.php');
			$context['current_message'] = $row;
			$row['can_view_post'] = $context['can_view_post'];
		}
			if (!$pre_query)
				$topic_ids[] = $row['ID_TOPIC'];
			// Censor the subject and message preview.
			censorText($row['subject']);
       
			if ($topic_length > $modSettings['defaultMaxMessages'])
			{
				if (!empty($modSettings['enableAllMessages']) && $topic_length < $modSettings['enableAllMessages'])
					$pages .= ' &nbsp;<a href="'. $scripturl .'?topic=' . $row['ID_TOPIC'] . '">' . $txt[190] . '</a>';
				$pages .= ' &#187;';
			}
			else
				$pages = '';
				
			$context['topics'][$row['ID_TOPIC']] = array(
				'id' => $row['ID_TOPIC'],
			    	'can_view_post' => $row['can_view_post'],
				'is_sticky' => !empty($modSettings['enableStickyTopics']) && !empty($row['isSticky']),
				'is_locked' => !empty($row['locked']),
				'subject' => $row['subject'],
				'pages' => $pages,
				'cat' => $row['name'],
				'idcat' => $board,
				'nresp' => $row['numReplies'],
				'visitas' => $row['numViews']
			);

			determineTopicClass($context['topics'][$row['ID_TOPIC']]);
		}
		mysql_free_result($result);
		
		// Fix the sequence of topics if they were retrieved in the wrong order. (for speed reasons...)
		if ($fake_ascending)
			$context['topics'] = array_reverse($context['topics'], true);

		}

	loadJumpTo();

	// Is Quick Moderation active?
	if (!empty($options['display_quick_mod']))
	{
		$context['can_lock'] = allowedTo('lock_any');
		$context['can_sticky'] = allowedTo('make_sticky') && !empty($modSettings['enableStickyTopics']);
		$context['can_move'] = allowedTo('move_any');
		$context['can_remove'] = allowedTo('remove_any');
		$context['can_merge'] = allowedTo('merge_any');

		// Set permissions for all the topics.
		foreach ($context['topics'] as $t => $topic)
		{
			$started = $topic['first_post']['member']['id'] == $ID_MEMBER;
			$context['topics'][$t]['quick_mod'] = array(
				'lock' => allowedTo('lock_any') || ($started && allowedTo('lock_own')),
				'sticky' => allowedTo('make_sticky') && !empty($modSettings['enableStickyTopics']),
				'move' => allowedTo('move_any') || ($started && allowedTo('move_own')),
				'modify' => allowedTo('modify_any') || ($started && allowedTo('modify_own')),
				'remove' => allowedTo('remove_any') || ($started && allowedTo('remove_own'))
			);
			$context['can_lock'] |= ($started && allowedTo('lock_own'));
			$context['can_move'] |= ($started && allowedTo('move_own'));
			$context['can_remove'] |= ($started && allowedTo('remove_own'));
		}

		$board_count = 0;
		foreach ($context['jump_to'] as $id => $cat)
		{
			if (!empty($_SESSION['move_to_topic']) && isset($context['jump_to'][$id]['boards'][$_SESSION['move_to_topic']]))
				$context['jump_to'][$id]['boards'][$_SESSION['move_to_topic']]['selected'] = true;

			$board_count += count($context['jump_to'][$id]['boards']);
		}

		// You can only see just this one board?
		if ($board_count <= 1)
			$context['can_move'] = false;
	}

	// If there are children, but no topics and no ability to post topics...
	$context['no_topic_listing'] = !empty($context['boards']) && empty($context['topics']) && !$context['can_post_new'];
}

?>