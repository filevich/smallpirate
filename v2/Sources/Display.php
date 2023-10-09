<?php

//Pagina echa por rigo. V 1.0 themes 1.0.

if (!defined('SMF'))
	die('Error');	
function Display()
{
	global $scripturl, $txt, $db_prefix, $modSettings, $context, $settings;
	global $options, $sourcedir, $user_info, $ID_MEMBER, $board_info, $topic;
	global $board, $attachments, $messages_request, $language;
$topicids = $_GET['topic'];

	if (empty($topic))
		fatal_lang_error('smf232', false);

if (isset($_REQUEST['msg']) && (is_array($_REQUEST['msg']) || !is_numeric($_REQUEST['msg']) ))
		unset($_REQUEST['msg']);
	elseif(isset($_REQUEST['msg'])) {
		$context['single-post'] = (int) $_REQUEST['msg'];
		$_REQUEST['start'] = 'msg' . $context['single-post'];
		if(isset($_REQUEST['xml']))
			$context['sub_template'] = 'ajax_reply';
	}
	
	$context['require_verification'] = !$user_info['is_mod'] && !$user_info['is_admin'] && !empty($modSettings['posts_require_captcha']) && ($user_info['posts'] < $modSettings['posts_require_captcha'] || ($user_info['is_guest'] && $modSettings['posts_require_captcha'] == -1));
	

	if (WIRELESS)
		$context['sub_template'] = WIRELESS_PROTOCOL . '_display';
	else
		loadTemplate('Display');

	if (isset($_SERVER['HTTP_X_MOZ']) && $_SERVER['HTTP_X_MOZ'] == 'prefetch')
	{
		ob_end_clean();
		header('HTTP/1.1 403 Prefetch Forbidden');
		die;
	}

	$context['user_post_avaible'] = 0; 
	if (!$user_info['is_guest']) {
		$check_for_hide = true;
		
		//Groupcheck ;D	
		if($check_for_hide && !empty($modSettings['hide_autounhidegroups'])) {
			$modSettings['hide_autounhidegroups'] = explode(',', $modSettings['hide_autounhidegroups']);
			foreach($user_info['groups'] as $group_id) 
				if(in_array($group_id, $modSettings['hide_autounhidegroups'])) {
					$check_for_hide = false;
					$context['user_post_avaible'] = 1;
					break; //One is enouph ;D
				}
		}

		$karmaOk = false;
		$postOk = false;

		//Okay know let's look for the post minimum ;D
		if($check_for_hide && (!empty($modSettings['hide_minpostunhide']) || !empty($modSettings['hide_minpostautounhide']))) {
			//Load the posts data ;D
			global $user_settings;
			
			//Need a minimum post to unhide?
			if(!empty($modSettings['hide_minpostunhide']) && $modSettings['hide_minpostunhide'] > 0 && $user_settings['posts'] < $modSettings['hide_minpostunhide']) {
				$postOk = true;
				$check_for_hide = false;
			}
			
			//Auto Unhide????
			if(!empty($modSettings['hide_minpostautounhide']) && $modSettings['hide_minpostautounhide'] > 0 && $user_settings['posts'] > $modSettings['hide_minpostautounhide']) {
					$check_for_hide = false;
					$context['user_post_avaible'] = 1;
			}
			
		}
		else
			$postOk = true;

		//Okay Check Karma Things :)
		if(!empty($modSettings['karmaMode']) && $check_for_hide && !empty($modSettings['hide_karmaenable'])) {
			//Karma Check :D for this i need to load the user infos :x
			loadMemberData($ID_MEMBER);
			loadMemberContext($ID_MEMBER);
			global $memberContext;
			
			if(!empty($modSettings['hide_onlykarmagood']))
				$karmaValue = $memberContext[$ID_MEMBER]['karma']['good'];
			else
				$karmaValue = $memberContext[$ID_MEMBER]['karma']['good'] - $memberContext[$ID_MEMBER]['karma']['bad'];

			//Need a minimum karma to unhide?
			if(!empty($modSettings['hide_minkarmaunhide']) && $karmaValue < $modSettings['hide_minkarmaunhide']) {
				$check_for_hide = false;
				$karmaOk = true;
			}

			//Auto Unhide for Karma?
			if(!empty($modSettings['hide_minkarmaautounhide']) && $karmaValue > $modSettings['hide_minkarmaautounhide']) {
					$check_for_hide = false;
					$context['user_post_avaible'] = 1;
			}

		}
		else
			$karmaOk = true;
		


		if(empty($context['user_post_avaible']) && $check_for_hide) {
			$request = db_query("
				SELECT ID_MSG, ID_MEMBER
				FROM {$db_prefix}messages
				WHERE ID_TOPIC = $topic AND ID_MEMBER = $ID_MEMBER
				LIMIT 1", __FILE__, __LINE__);

			if (mysql_num_rows($request)) $context['user_post_avaible'] = 1;
			else $context['user_post_avaible'] = 0;
			mysql_free_result($request);
		}
	}
	
	if (empty($_SESSION['last_read_topic']) || $_SESSION['last_read_topic'] != $topic)
	{
		db_query("
			UPDATE {$db_prefix}topics
			SET numViews = numViews + 1
			WHERE ID_TOPIC = $topic
			LIMIT 1", __FILE__, __LINE__);

		$_SESSION['last_read_topic'] = $topic;
	}
	$dbresult= db_query("SELECT t.tag,l.ID,t.ID_TAG FROM {$db_prefix}tags_log as l, {$db_prefix}tags as t WHERE t.ID_TAG = l.ID_TAG && l.ID_TOPIC = $topic", __FILE__, __LINE__);
		$context['topic_tags'] = array();
		 while($row = mysql_fetch_assoc($dbresult))
			{
				$context['topic_tags'][] = array(
				'ID' => $row['ID'],
				'ID_TAG' => $row['ID_TAG'],
				'tag' => $row['tag'],
				);
		}
	mysql_free_result($dbresult);

	$request = db_query("
		SELECT
			t.numReplies, t.numViews, t.locked,	ms.hiddenOption, ms.hiddenValue, ms.subject, t.isSticky, t.ID_POLL,
			t.thank_you_post_locked,
			t.ID_MEMBER_STARTED,
			" . ($user_info['is_guest'] ? '0' : 'IFNULL(lt.ID_MSG, -1) + 1') . " AS new_from
		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS ms)" . ($user_info['is_guest'] ? '' : "
			LEFT JOIN {$db_prefix}log_topics AS lt ON (lt.ID_TOPIC = $topic AND lt.ID_MEMBER = $ID_MEMBER)") ."
		WHERE t.ID_TOPIC = $topic
			AND ms.ID_TOPIC = $topicids
		LIMIT 1", __FILE__, __LINE__);
	if (mysql_num_rows($request) == 0)
		fatal_lang_error(472, false);
	$topicinfo = mysql_fetch_assoc($request);
	mysql_free_result($request);

	// The start isn't a number; it's information about what to do, where to go.
	if (!is_numeric($_REQUEST['start']))
	{
		// Redirect to the page and post with new messages, originally by Omar Bazavilvazo.
		if ($_REQUEST['start'] == 'new')
		{
			// Guests automatically go to the last topic.
			if ($user_info['is_guest'])
			{
				$context['start_from'] = $topicinfo['numReplies'];
				$_REQUEST['start'] = empty($options['view_newest_first']) ? $context['start_from'] : 0;
			}
			else
			{
				// Find the earliest unread message in the topic. (the use of topics here is just for both tables.)
				$request = db_query("
					SELECT IFNULL(lt.ID_MSG, IFNULL(lmr.ID_MSG, -1)) + 1 AS new_from
					FROM {$db_prefix}topics AS t
						LEFT JOIN {$db_prefix}log_topics AS lt ON (lt.ID_TOPIC = $topic AND lt.ID_MEMBER = $ID_MEMBER)
						LEFT JOIN {$db_prefix}log_mark_read AS lmr ON (lmr.ID_BOARD = $board AND lmr.ID_MEMBER = $ID_MEMBER)
					WHERE t.ID_TOPIC = $topic
					LIMIT 1", __FILE__, __LINE__);
				list ($new_from) = mysql_fetch_row($request);
				mysql_free_result($request);

				// Fall through to the next if statement.
				$_REQUEST['start'] = 'msg' . $new_from;
			}
		}

		// Start from a certain time index, not a message.
		if (substr($_REQUEST['start'], 0, 4) == 'from')
		{
			$timestamp = (int) substr($_REQUEST['start'], 4);
			if ($timestamp === 0)
				$_REQUEST['start'] = 0;
			else
			{
				// Find the number of messages posted before said time...
				$request = db_query("
					SELECT COUNT(*)
					FROM {$db_prefix}messages
					WHERE posterTime < $timestamp
						AND ID_TOPIC = $topic", __FILE__, __LINE__);
				list ($context['start_from']) = mysql_fetch_row($request);
				mysql_free_result($request);

				// Handle view_newest_first options, and get the correct start value.
				$_REQUEST['start'] = empty($options['view_newest_first']) ? $context['start_from'] : $topicinfo['numReplies'] - $context['start_from'];
			}
		}
			
		// Link to a message...
		elseif (substr($_REQUEST['start'], 0, 3) == 'msg')
		{
			$virtual_msg = (int) substr($_REQUEST['start'], 3);
			if ($virtual_msg >= $topicinfo['ID_LAST_MSG'])
				$context['start_from'] = $topicinfo['numReplies'];
			elseif ($virtual_msg <= $topicinfo['ID_FIRST_MSG'])
				$context['start_from'] = 0;
			else
			{
				// Find the start value for that message......
				$request = db_query("
					SELECT COUNT(*)
					FROM {$db_prefix}messages
					WHERE ID_MSG < $virtual_msg
						AND ID_TOPIC = $topic", __FILE__, __LINE__);
				list ($context['start_from']) = mysql_fetch_row($request);
				mysql_free_result($request);
			}
			
			// We need to reverse the start as well in this case.
			$_REQUEST['start'] = empty($options['view_newest_first']) ? $context['start_from'] : $topicinfo['numReplies'] - $context['start_from'];

			$context['robot_no_index'] = true;
		}
	}
	$context['previous_next'] = $modSettings['enablePreviousNext'] ? '<a href="' . $scripturl . '?topic=' . $topic . '.0;prev_next=prev#new">' . $txt['previous_next_back'] . '</a> <a href="' . $scripturl . '?topic=' . $topic . '.0;prev_next=next#new">' . $txt['previous_next_forward'] . '</a>' : '';

	$context['show_spellchecking'] = !empty($modSettings['enableSpellChecking']) && function_exists('pspell_new');
	$context['signature_enabled'] = substr($modSettings['signature_settings'], 0, 1) == 1;
	censorText($topicinfo['subject']);
	$context['page_title'] = $topicinfo['subject'];
	$context['num_replies'] = $topicinfo['numReplies'];
	$context['topic_first_message'] = $topicinfo['ID_FIRST_MSG'];
	$topicinfo['isSticky'] = empty($modSettings['enableStickyTopics']) ? '0' : $topicinfo['isSticky'];

if (!$user_info['is_guest'])
	{
		if (empty($flag))
			db_query("
				REPLACE INTO {$db_prefix}log_topics
					(ID_MSG, ID_MEMBER, ID_TOPIC)
				VALUES ($modSettings[maxMsgID], $ID_MEMBER, $topic)", __FILE__, __LINE__);

		// Have we recently cached the number of new topics in this board, and it's still a lot?
		if (isset($_REQUEST['topicseen']) && isset($_SESSION['topicseen_cache'][$board]) && $_SESSION['topicseen_cache'][$board] > 5)
			$_SESSION['topicseen_cache'][$board]--;
		// Mark board as seen if this is the only new topic.
		elseif (isset($_REQUEST['topicseen']))
		{
			// Use the mark read tables... and the last visit to figure out if this should be read or not.
			$request = db_query("
				SELECT COUNT(*)
				FROM {$db_prefix}topics AS t
					LEFT JOIN {$db_prefix}log_boards AS lb ON (lb.ID_BOARD = $board AND lb.ID_MEMBER = $ID_MEMBER)
					LEFT JOIN {$db_prefix}log_topics AS lt ON (lt.ID_TOPIC = t.ID_TOPIC AND lt.ID_MEMBER = $ID_MEMBER)
				WHERE t.ID_BOARD = $board
					AND t.ID_LAST_MSG > IFNULL(lb.ID_MSG, 0)
					AND t.ID_LAST_MSG > IFNULL(lt.ID_MSG, 0)" . (empty($_SESSION['ID_MSG_LAST_VISIT']) ? '' : "
					AND t.ID_LAST_MSG > $_SESSION[ID_MSG_LAST_VISIT]"), __FILE__, __LINE__);
			list ($numNewTopics) = mysql_fetch_row($request);
			mysql_free_result($request);

			// If there're no real new topics in this board, mark the board as seen.
			if (empty($numNewTopics))
				$_REQUEST['boardseen'] = true;
			else
				$_SESSION['topicseen_cache'][$board] = $numNewTopics;
		}
		// Probably one less topic - maybe not, but even if we decrease this too fast it will only make us look more often.
		elseif (isset($_SESSION['topicseen_cache'][$board]))
			$_SESSION['topicseen_cache'][$board]--;

		// Mark board as seen if we came using last post link from BoardIndex. (or other places...)
		if (isset($_REQUEST['boardseen']))
		{
			db_query("
				REPLACE INTO {$db_prefix}log_boards
					(ID_MSG, ID_MEMBER, ID_BOARD)
				VALUES ($modSettings[maxMsgID], $ID_MEMBER, $board)", __FILE__, __LINE__);
		}
	}

	// Let's get nosey, who is viewing this topic?
	if (!empty($settings['display_who_viewing']))
	{
		// Start out with no one at all viewing it.
		$context['view_members'] = array();
		$context['view_members_list'] = array();
		$context['view_num_hidden'] = 0;

		// Search for members who have this topic set in their GET data.
		$request = db_query("
			SELECT
				lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
				mg.onlineColor, mg.ID_GROUP, mg.groupName
			FROM {$db_prefix}log_online AS lo
				LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
				LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
			WHERE INSTR(lo.url, 's:5:\"topic\";i:$topic;') OR lo.session = '" . ($user_info['is_guest'] ? 'ip' . $user_info['ip'] : session_id()) . "'", __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
		{
			if (empty($row['ID_MEMBER']))
				continue;

			if (!empty($row['onlineColor']))
				$link = '<a href="'. $scripturl .'?action=profile;user=' . $row['memberName'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
			else
				$link = '<a href="'. $scripturl .'?action=profile;user=' . $row['memberName'] . '">' . $row['realName'] . '</a>';

			$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
			if ($is_buddy)
				$link = '<b>' . $link . '</b>';

			// Add them both to the list and to the more detailed list.
			if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
				$context['view_members_list'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;
			$context['view_members'][$row['logTime'] . $row['memberName']] = array(
				'id' => $row['ID_MEMBER'],
				'username' => $row['memberName'],
				'name' => $row['realName'],
				'group' => $row['ID_GROUP'],
				'href' => ''. $scripturl .'?action=profile;user=' . $row['memberName'],
				'link' => $link,
				'is_buddy' => $is_buddy,
				'hidden' => empty($row['showOnline']),
			);

			if (empty($row['showOnline']))
				$context['view_num_hidden']++;
		}

		// The number of guests is equal to the rows minus the ones we actually used ;).
		$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
		mysql_free_result($request);

		// Sort the list.
		krsort($context['view_members']);
		krsort($context['view_members_list']);
	}

	// If all is set, but not allowed... just unset it.
	if (isset($_REQUEST['all']) && empty($modSettings['enableAllMessages']))
		unset($_REQUEST['all']);
	// Otherwise, it must be allowed... so pretend start was -1.
	elseif (isset($_REQUEST['all']))
		$_REQUEST['start'] = -1;

	// Construct the page index, allowing for the .START method...
	$context['page_index'] = constructPageIndex($scripturl . '?topic=' . $topic . '.%d', $_REQUEST['start'], $topicinfo['numReplies'] + 1, $modSettings['defaultMaxMessages'], true);
	$context['start'] = $_REQUEST['start'];

	// This is information about which page is current, and which page we're on - in case you don't like the constructed page index. (again, wireles..)
	$context['page_info'] = array(
		'current_page' => $_REQUEST['start'] / $modSettings['defaultMaxMessages'] + 1,
		'num_pages' => floor($topicinfo['numReplies'] / $modSettings['defaultMaxMessages']) + 1
	);

	$context['links'] = array(
		'first' => $_REQUEST['start'] >= $modSettings['defaultMaxMessages'] ? $scripturl . '?topic=' . $topic . '.0' : '',
		'prev' => $_REQUEST['start'] >= $modSettings['defaultMaxMessages'] ? $scripturl . '?topic=' . $topic . '.' . ($_REQUEST['start'] - $modSettings['defaultMaxMessages']) : '',
		'next' => $_REQUEST['start'] + $modSettings['defaultMaxMessages'] < $topicinfo['numReplies'] + 1 ? $scripturl . '?topic=' . $topic. '.' . ($_REQUEST['start'] + $modSettings['defaultMaxMessages']) : '',
		'last' => $_REQUEST['start'] + $modSettings['defaultMaxMessages'] < $topicinfo['numReplies'] + 1 ? $scripturl . '?topic=' . $topic. '.' . (floor($topicinfo['numReplies'] / $modSettings['defaultMaxMessages']) * $modSettings['defaultMaxMessages']) : '',
		'up' => $scripturl+'/?board=' . $board . '.0'
	);

	// If they are viewing all the posts, show all the posts, otherwise limit the number.
	if (!empty($modSettings['enableAllMessages']) && $topicinfo['numReplies'] + 1 > $modSettings['defaultMaxMessages'] && $topicinfo['numReplies'] + 1 < $modSettings['enableAllMessages'])
	{
		if (isset($_REQUEST['all']))
		{
			// No limit! (actually, there is a limit, but...)
			$modSettings['defaultMaxMessages'] = -1;
			$context['page_index'] .= empty($modSettings['compactTopicPagesEnable']) ? '<b>' . $txt[190] . '</b> ' : '[<b>' . $txt[190] . '</b>] ';

			// Set start back to 0...
			$_REQUEST['start'] = 0;
		}
		// They aren't using it, but the *option* is there, at least.
		else
			$context['page_index'] .= '&nbsp;<a href="' . $scripturl . '?topic=' . $topic . '">' . $txt[190] . '</a> ';
	}
	$context['moderators'] = &$board_info['moderators'];
	$context['link_moderators'] = array();
    $context['is_locked'] = $topicinfo['locked'];
    $context['board']     = $topicinfo['board'];
    $message['board']     = $topicinfo['board'];
	$context['is_sticky'] = $topicinfo['isSticky'];
	$context['is_very_hot'] = $topicinfo['numReplies'] >= $modSettings['hotTopicVeryPosts'];
	$context['is_hot'] = $topicinfo['numReplies'] >= $modSettings['hotTopicPosts'];
	
	//Some Thanky You things ;)
	$context['is_thank_you_post_locked'] = $topicinfo['thank_you_post_locked'];
	$context['thank_you_lock_allowed'] = !empty($board_info['thank_you_post_enable']) && !$user_info['is_guest'] && (allowedTo('thank_you_post_lock_all_any') || (allowedTo('thank_you_post_lock_all_own') && $ID_MEMBER == $topicinfo['ID_MEMBER_STARTED']));
	$context['thank_you_post_enable'] = $board_info['thank_you_post_enable'];
	$context['thank_you_post_unlock_all'] = false;

	// We don't want to show the poll icon in the topic class here, so pretend it's not one.
	$context['is_poll'] = false;
	determineTopicClass($context);

	$context['is_poll'] = $topicinfo['ID_POLL'] > 0 && $modSettings['pollMode'] == '1' && allowedTo('poll_view');
	$context['user']['started'] = $ID_MEMBER == $topicinfo['ID_MEMBER_STARTED'] && !$user_info['is_guest'];
	$context['topic_starter_id'] = $topicinfo['ID_MEMBER_STARTED'];
	$context['subject'] = $topicinfo['subject'];
	$context['can_view_post'] = $topicinfo['hiddenOption'];
	$context['num_views'] = $topicinfo['numViews'];
	$context['numReplies'] = $topicinfo['numReplies'];
	$context['mark_unread_time'] = $topicinfo['new_from'];
	if (!isset($context['response_prefix']) && !($context['response_prefix'] = cache_get_data('response_prefix')))
	{
		if ($language === $user_info['language'])
			$context['response_prefix'] = $txt['response_prefix'];
		else
		{
			loadLanguage('index', $language, false);
			$context['response_prefix'] = $txt['response_prefix'];
			loadLanguage('index');
		}
		cache_put_data('response_prefix', $context['response_prefix'], 600);
	}

	$ascending = empty($options['view_newest_first']);
	$start = $_REQUEST['start'];
	$limit = $modSettings['defaultMaxMessages'];
	$firstIndex = 0;
	if ($start > $topicinfo['numReplies'] / 2 && $modSettings['defaultMaxMessages'] != -1)
	{
		$ascending = !$ascending;
		$limit = $topicinfo['numReplies'] < $start + $limit ? $topicinfo['numReplies'] - $start + 1 : $limit;
		$start = $topicinfo['numReplies'] < $start + $limit ? 0 : $topicinfo['numReplies'] - $start - $limit + 1;
		$firstIndex = $limit - 1;
	}

	$request = db_query("
		SELECT ID_MSG, ID_MEMBER
		".($board_info['thank_you_post_enable'] ? ", thank_you_post" : "")."
		FROM {$db_prefix}messages
		WHERE ID_TOPIC = $topic
		ORDER BY ID_TOPIC" . ($ascending ? '' : 'DESC') . ($modSettings['defaultMaxMessages'] == -1 ? '' : "
		LIMIT $start, $limit"), __FILE__, __LINE__);

	$messages = array();
	$posters = array();
	$thank_you_posts = array();
	while ($row = mysql_fetch_assoc($request))
	{
		if (!empty($row['ID_MEMBER']))
			$posters[] = $row['ID_MEMBER'];
		$messages[] = $row['ID_MSG'];
		if (!empty($row['thank_you_post']))
			$thank_you_posts[] = $row['ID_MSG'];
	}
	mysql_free_result($request);
	$posters = array_unique($posters);
	
    if(isset($context['single-post']) && in_array($context['single-post'], $messages))
	$messages = array ($context['single-post']);
	$attachments = array();

	if (!empty($messages))
	{
		$context['thank_you_post']['postet_thanks'] = array();
		$context['thank_you_post']['topic'] = null;
		if($board_info['thank_you_post_enable'] && (allowedTo('thank_you_post_show') || allowedTo('thank_you_post_post'))) {
			if(!empty($modSettings['thankYouPostDisableUnhide']) && empty($modSettings['thankYouPostThxUnhideAll']) && empty($modSettings['thankYouPostUnhidePost']))
				$modSettings['thankYouPostDisableUnhide'] = 0;

			if(!empty($modSettings['thankYouPostPreview']) && !empty($thank_you_posts) && allowedTo('thank_you_post_show')) {
				//Should i gernerate a list? Need a extra query :)
				include($sourcedir.'/ThankYouPost.php');
				ThankYouPostList($thank_you_posts, true);
			}
			//Okay no preview so in need to load the data extra for this :)
			if(!empty($thank_you_posts) && !empty($ID_MEMBER) && allowedTo('thank_you_post_post')) {
				//Search for one made or the made one in the thread ;)
				$thx = db_query("
					SELECT ID_THX_POST, ID_MSG
					FROM {$db_prefix}thank_you_post
					WHERE ID_TOPIC = $topic 
						".(!empty($modSettings['thankYouPostOnePerPost']) ? "AND ID_MSG IN (".implode(', ', $thank_you_posts).")" : "")."
						AND ID_MEMBER = $ID_MEMBER
						".(empty($modSettings['thankYouPostOnePerPost']) ? "LIMIT 1" : ""), __FILE__, __LINE__);
					
				while($row = mysql_fetch_assoc($thx)) {
					$context['thank_you_post']['postet_thanks'][$row['ID_MSG']] = $row['ID_THX_POST'];
				}
				mysql_free_result($thx);

				$context['thank_you_post']['topic'] = $topic;
				
				//Okay Hide Tag Special Handling in Thank You Mod
				if(!empty($modSettings['thankYouPostDisableUnhide']))
					$context['user_post_avaible'] = 0;
				//Unhide all after one post?
				if(!empty($modSettings['thankYouPostThxUnhideAll']) && !empty($context['thank_you_post']['postet_thanks']))
					$context['user_post_avaible'] = 1;
			}
			elseif(!empty($modSettings['thankYouPostDisableUnhide'])) 
				$context['user_post_avaible'] = 0;
		}

		// What?  It's not like it *couldn't* be only guests in this topic...
		if (!empty($posters))
			loadMemberData($posters);
	
	
		$request = db_query("
		SELECT
		m.ID_MSG, m.subject, t.ID_TOPIC, t.ID_BOARD, m.hiddenOption, m.hiddenValue,
		b.name AS bname, t.numReplies, m.ID_MEMBER, IFNULL(mem.realName, m.posterName) AS posterName,
			mem.hideEmail, IFNULL(mem.emailAddress, m.posterEmail) AS posterEmail, m.modifiedTime
		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)
		WHERE m.ID_MSG = t.ID_FIRST_MSG
		AND t.ID_BOARD = b.ID_BOARD
       ORDER BY RAND()
		LIMIT 0, 10", __FILE__, __LINE__);
			$context['post10'] = array();
			while ($row = mysql_fetch_assoc($request))
	{
		
		$row['can_view_post'] = 1;
		if (!empty($modSettings['allow_hiddenPost']) && $row['hiddenOption'] > 0)
		{
			global $sourcedir;
			require_once($sourcedir . '/HidePost.php');
			$context['current_message'] = $row;
			$row['body'] = getHiddenMessage();
			$row['can_view_post'] = $context['can_view_post'];
		}
		
				$context['posts10'][$row['ID_MSG']] = array(
				'can_view_post' => $row['can_view_post'],
				'id' => $row['ID_TOPIC'],
				'subject' => $row['subject'],
				'bname' => $row['bname'],
				'idb' => $row['ID_BOARD']
				);
	}

$topic = $_GET['topic'];		

	$request = db_query("
	SELECT t.ID_TOPIC, t.puntos
            FROM ({$db_prefix}topics AS t)
	        WHERE t.ID_TOPIC=".$topic."", __FILE__, __LINE__);
	while ($row = mysql_fetch_assoc($request))
	{
	$context['puntos-post'] = $row['puntos'];
	}	
	mysql_free_result($request);
	

// aca marca si hay comentarios
$request = db_query("
SELECT *
FROM (cw_comentarios) 
WHERE id_post = $topic
", __FILE__, __LINE__);
$context['haycom'] = mysql_fetch_assoc($request);

// aca marca cuantos comentarios hay
$request = db_query("
SELECT *
FROM (cw_comentarios) 
WHERE id_post = $topic
", __FILE__, __LINE__);
$context['numcom'] =  mysql_num_rows($request);

// aca marca los comentarios
$request = db_query("
SELECT c.comentario, c.comentario AS comentario2, c.id_post, c.id_user, mem.ID_MEMBER, mem.memberName, mem.realName, c.id_coment, c.fecha
FROM (cw_comentarios AS c, smf_members AS mem) 
WHERE c.id_post = $topic AND c.id_user = mem.ID_MEMBER
ORDER BY c.id_coment ASC
", __FILE__, __LINE__);
$context['comentarios'] = array();
while ($row = mysql_fetch_assoc($request))
	{
		$row['comentario'] = parse_bbc($row['comentario'], '1', $row['ID_MSG']);
		$row['comentario0'] = parse_bbc($row['comentario0'], '0', $row['ID_MSG']);
		censorText($row['comentario']);
		censorText($row['comentario2']);
		
		$context['comentarios'][] = array(
		    'comentario2' => $row['comentario2'],
			'comentario' => $row['comentario'],
			'citar' => $row['comentario0'],
			'user' => $row['id_user'],
			'nomuser' => $row['realName'],
			'nommem' => $row['memberName'],
			'id' => $row['id_coment'],
			'fecha' => $row['fecha'],
		);
	}
	mysql_free_result($request);

$request = mysql_query("
SELECT m.ID_MEMBER, m.ID_POST_GROUP
FROM smf_members AS m
WHERE ".$context['user']['id']." = m.ID_MEMBER");
while ($grup = mysql_fetch_assoc($request))
{	
$context['idgrup'] = $grup['ID_POST_GROUP'];
$context['leecher'] = $grup['ID_POST_GROUP'] == '4';
$context['novato'] = $grup['ID_POST_GROUP'] == '5';
$context['buenus'] = $grup['ID_POST_GROUP'] == '6';
}	
	mysql_free_result($request);
	
$rs = db_query("
SELECT o.ID_TOPIC
FROM ({$db_prefix}bookmarks AS o)
WHERE o.ID_TOPIC=".$topic."", __FILE__, __LINE__);
$context['fav1'] = mysql_num_rows($rs);

$messages_request = db_query("
			SELECT
				m.ID_MSG, m.icon, m.subject, m.posterTime, m.posterIP, m.ID_MEMBER, m.modifiedTime, m.modifiedName, m.body, m.hiddenOption, m.hiddenValue, m.ID_BOARD, m.edit_reason, b.name AS bname, m.smileysEnabled, m.posterName, m.posterEmail
			FROM ({$db_prefix}messages AS m, {$db_prefix}boards AS b)
			WHERE m.ID_TOPIC = $topicids
			AND b.ID_BOARD = m.ID_BOARD
			ORDER BY m.ID_TOPIC ", __FILE__, __LINE__);
         	if (isset($context['start_from']) && $context['start_from'] >= $topicinfo['numReplies'])
			$context['start_from'] = $topicinfo['numReplies'];

		$context['first_message'] = isset($messages[$firstIndex]) ? $messages[$firstIndex] : $messages[0];
		$context['comentario'] = isset($messages[1]) ? $messages[1] : $messages[$message['counter']];
		$context['last_message'] = isset($messages[$lastIndex]) ? $messages[$lastIndex] : $messages[$message['counter']];
		if (empty($options['view_newest_first']))
			$context['first_new_message'] = isset($context['start_from']) && $_REQUEST['start'] == $context['start_from'];
		else
			$context['first_new_message'] = isset($context['start_from']) && $_REQUEST['start'] == $topicinfo['numReplies'] - $context['start_from'];
	}
	else
	{
		$messages_request = false;
		$context['first_message'] = 0;
		$context['comentario'] = 2;
		$context['last_message'] = 1;
		$context['first_new_message'] = false;
	}

	// Load the "Jump to" list...
	loadJumpTo();

	// Set the callback.  (do you REALIZE how much memory all the messages would take?!?)
	$context['get_message'] = 'prepareDisplayContext';

	// Basic settings.... may be converted over at some point.
	$context['allow_hide_email'] = !empty($modSettings['allow_hideEmail']) || ($user_info['is_guest'] && !empty($modSettings['guest_hideContacts']));

	// Now set all the wonderful, wonderful permissions... like moderation ones...
	$common_permissions = array(
		'can_sticky' => 'make_sticky',
		'can_merge' => 'merge_any',
		'can_split' => 'split_any',
		'calendar_post' => 'calendar_post',
		'can_mark_notify' => 'mark_any_notify',
		'can_send_topic' => 'send_topic',
		'can_send_pm' => 'pm_send',
		'can_report_moderator' => 'report_any',
		'can_moderate_forum' => 'moderate_forum'
	);
	foreach ($common_permissions as $contextual => $perm)
		$context[$contextual] = allowedTo($perm);

	// Permissions with _any/_own versions.  $context[YYY] => ZZZ_any/_own.
	$anyown_permissions = array(
		'can_move' => 'move',
		'can_lock' => 'lock',
		'can_delete' => 'remove',
		'can_add_poll' => 'poll_add',
		'can_remove_poll' => 'poll_remove',
		'can_reply' => 'post_reply',
	);
	foreach ($anyown_permissions as $contextual => $perm)
		$context[$contextual] = allowedTo($perm . '_any') || ($context['user']['started'] && allowedTo($perm . '_own'));

	// Cleanup all the permissions with extra stuff...
	$context['can_mark_notify'] &= !$context['user']['is_guest'];
	$context['can_sticky'] &= !empty($modSettings['enableStickyTopics']);
	$context['calendar_post'] &= !empty($modSettings['cal_enabled']);
	$context['can_add_poll'] &= $modSettings['pollMode'] == '1' && $topicinfo['ID_POLL'] <= 0;
	$context['can_remove_poll'] &= $modSettings['pollMode'] == '1' && $topicinfo['ID_POLL'] > 0;
	$context['can_reply'] &= empty($topicinfo['locked']) || allowedTo('moderate_board');

	$board_count = 0;
	foreach ($context['jump_to'] as $id => $cat)
		$board_count += count($context['jump_to'][$id]['boards']);
	$context['can_move'] &= $board_count > 1;

	// Start this off for quick moderation - it will be or'd for each post.
	$context['can_remove_post'] = allowedTo('delete_any') || (allowedTo('delete_replies') && $context['user']['started']);

	// Load up the "double post" sequencing magic.
	if (!empty($options['display_quick_reply']))
		checkSubmitOnce('register');
}

// Callback for the message display.
function prepareDisplayContext($reset = false)
{
	global $settings, $txt, $modSettings, $scripturl, $options, $user_info;
	global $memberContext, $context, $messages_request, $topic, $ID_MEMBER, $attachments;

	static $counter = null;
	if ($messages_request == false)
		return false;
	if ($counter === null || $reset)
		$counter = empty($options['view_newest_first']) ? $context['start'] : $context['num_replies'] - $context['start'];
	if ($reset)
		return @mysql_data_seek($messages_request, 0);
	$message = mysql_fetch_assoc($messages_request);
	if (!$message)
		return false;

	$message['subject'] = $message['subject'] != '' ? $message['subject'] : $txt[24];
	$context['can_remove_post'] |= allowedTo('delete_own') && (empty($modSettings['edit_disable_time']) || $message['posterTime'] + $modSettings['edit_disable_time'] * 60 >= time()) && $message['ID_MEMBER'] == $ID_MEMBER;
	if (!loadMemberContext($message['ID_MEMBER']))
	{		$memberContext[$message['ID_MEMBER']]['name'] = $message['posterName'];
		$memberContext[$message['ID_MEMBER']]['id'] = 0;
		$memberContext[$message['ID_MEMBER']]['group'] = $txt[28];
		$memberContext[$message['ID_MEMBER']]['link'] = $message['posterName'];
		$memberContext[$message['ID_MEMBER']]['email'] = $message['posterEmail'];
		$memberContext[$message['ID_MEMBER']]['hide_email'] = $message['posterEmail'] == '' || (!empty($modSettings['guest_hideContacts']) && $user_info['is_guest']);
		$memberContext[$message['ID_MEMBER']]['is_guest'] = true;
	}
	else
	{
		$memberContext[$message['ID_MEMBER']]['can_view_profile'] = allowedTo('profile_view_any') || ($message['ID_MEMBER'] == $ID_MEMBER && allowedTo('profile_view_own'));
		$memberContext[$message['ID_MEMBER']]['is_topic_starter'] = $message['ID_MEMBER'] == $context['topic_starter_id'];
	}
	$memberContext[$message['ID_MEMBER']]['ip'] = $message['posterIP'];
	censorText($message['body']);
	censorText($message['subject']);
	$disable_unhideafter = false;
	if((!empty($modSettings['thankYouPostUnhidePost']) && empty($context['user_post_avaible']) && isset($context['thank_you_post']['postet_thanks'][$message['ID_MSG']]) && empty($modSettings['thankYouPostThxUnhideAll'])) || (!empty($modSettings['thankYouPostDisableUnhide']) && $ID_MEMBER == $message['ID_MEMBER'])) {
		$disable_unhideafter = true;
		$context['user_post_avaible'] = 1;
	}

$message['can_view_post'] = 1;
		if (!empty($modSettings['allow_hiddenPost']) && $message['hiddenOption'] > 0)
		{
			global $sourcedir;
			require_once($sourcedir . '/HidePost.php');
			$context['current_message'] = $message;
			$message['body'] = getHiddenMessage();
			$message['can_view_post'] = $context['can_view_post'];
		}

	$message['body'] = parse_bbc($message['body'], $message['smileysEnabled'], $message['ID_MSG']);

	$output = array(
		'can_view_post' => $message['can_view_post'],
		'alternate' => $counter % 2,
		'id' => $message['ID_MSG'],
		'href' => '' . $scripturl . '/?topic=' . $topic,
		'link' => '<a href="' . $scripturl . '/?topic=' . $topic . '">' . $message['subject'] . '</a>',
		'member' => &$memberContext[$message['ID_MEMBER']],
		'subject' => $message['subject'],
    	'board' => array(
				'id' => $message['ID_BOARD'],
				'name' => $message['bname'],
				'href' => '' . $scripturl . '/?id=' . $message['ID_BOARD'] . '',
				'link' => '<a href="' . $scripturl . '/?id=' . $message['ID_BOARD'] . '" alt="' . $message['bname'] . '" title="' . $message['bname'] . '">' . $message['bname'] . '</a>'
			),
		'category' => $message['catName'],
		'time' => timeformat($message['posterTime']),
		'timestamp' => forum_time(true, $message['posterTime']),
		'counter' => isset($_REQUEST['xml']) ? $context['num_replies'] : $counter,
		'modified' => array(
			'time' => timeformat($message['modifiedTime']),
			'timestamp' => forum_time(true, $message['modifiedTime']),
			'name' => $message['modifiedName'],
		    'edit_reason' => $message['edit_reason'],
		),
		'body' => $message['body'],
		'new' => empty($message['isRead']),
		'first_new' => isset($context['start_from']) && $context['start_from'] == $counter,
		'can_modify' => (!$context['is_locked'] || allowedTo('moderate_board')) && (allowedTo('modify_any') || (allowedTo('modify_replies') && $context['user']['started']) || (allowedTo('modify_own') && $message['ID_MEMBER'] == $ID_MEMBER && (empty($modSettings['edit_disable_time']) || $message['posterTime'] + $modSettings['edit_disable_time'] * 60 > time()))),
		'can_remove' => allowedTo('delete_any') || (allowedTo('delete_replies') && $context['user']['started']) || (allowedTo('delete_own') && $message['ID_MEMBER'] == $ID_MEMBER && (empty($modSettings['edit_disable_time']) || $message['posterTime'] + $modSettings['edit_disable_time'] * 60 > time())),
		'can_see_ip' => allowedTo('moderate_forum') || ($message['ID_MEMBER'] == $ID_MEMBER && !empty($ID_MEMBER)),
		'thank_you_post' => array(
			'post' => $context['thank_you_post_enable'] && empty($context['is_thank_you_post_locked']) && allowedTo('thank_you_post_post') && $ID_MEMBER != $message['ID_MEMBER'] && !isset($context['thank_you_post']['postet_thanks'][$message['ID_MSG']]) && !(empty($modSettings['thankYouPostOnePerPost']) && !empty($context['thank_you_post']['postet_thanks'])),
			'lock' => $context['thank_you_post_enable'] && empty($context['is_thank_you_post_locked']) && (allowedTo('thank_you_post_lock_any') || (allowedTo('thank_you_post_lock_own') && $ID_MEMBER == $message['ID_MEMBER'])),
			'delete' => $context['thank_you_post_enable'] && allowedTo('thank_you_post_delete_any') || (allowedTo('thank_you_post_delete_own') && $ID_MEMBER == $message['ID_MEMBER']),
			'counter' => $context['thank_you_post_enable'] && !empty($message['thank_you_post_counter']) ? $message['thank_you_post_counter'] : '0',
			'locked' => $context['thank_you_post_enable'] && !empty($message['thank_you_post']) && $message['thank_you_post'] > 1,
			'isThankYouPost' => $context['thank_you_post_enable'] && !empty($message['thank_you_post']) && $message['thank_you_post'] >= 1,
			'href' => $context['thank_you_post_enable'] ? $scripturl . '?action=thankyoupostlist;topic=' . $topic . '.0;msg='.$message['ID_MSG'] : '',
		),
	);



if($context['thank_you_post_enable'] && allowedTo('thank_you_post_unlock_all') && !empty($message['thank_you_post']) && $message['thank_you_post'] > 1)
		$context['thank_you_post_unlock_all'] = true;

	if($disable_unhideafter) 
		$context['user_post_avaible'] = 0;
	
	if (empty($options['view_newest_first']))
		$counter++;
	else
		$counter--;

	return $output;
}
function Download(){}
function loadAttachmentContext($ID_MSG){}

function theme_quickreply_box()
{
	global $txt, $modSettings, $db_prefix;
	global $context, $settings, $user_info;
	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template']))
	{
		$temp1 = $settings['theme_url'];
		$settings['theme_url'] = $settings['default_theme_url'];
		$temp2 = $settings['images_url'];
		$settings['images_url'] = $settings['default_images_url'];
		$temp3 = $settings['theme_dir'];
		$settings['theme_dir'] = $settings['default_theme_dir'];
	}
	$context['smileys'] = array(
		'postform' => array(),
		'popup' => array(),
	);
	loadLanguage('Post');
	if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')
		$context['smileys']['postform'][] = array();
	elseif ($user_info['smiley_set'] != 'none')
	{
		if (($temp = cache_get_data('posting_smileys', 480)) == null)
		{
			$request = db_query("
				SELECT code, filename, description, smileyRow, hidden
				FROM {$db_prefix}smileys
				WHERE hidden IN (0, 2)
				ORDER BY smileyRow, smileyOrder", __FILE__, __LINE__);
			while ($row = mysql_fetch_assoc($request))
			{
				$row['code'] = htmlspecialchars($row['code']);
				$row['filename'] = htmlspecialchars($row['filename']);
				$row['description'] = htmlspecialchars($row['description']);

				$context['smileys'][empty($row['hidden']) ? 'postform' : 'popup'][$row['smileyRow']]['smileys'][] = $row;
			}
			mysql_free_result($request);

			cache_put_data('posting_smileys', $context['smileys'], 480);
		}
		else
			$context['smileys'] = $temp;
	}

	foreach (array_keys($context['smileys']) as $location)
	{
		foreach ($context['smileys'][$location] as $j => $row)
		{
			$n = count($context['smileys'][$location][$j]['smileys']);
			for ($i = 0; $i < $n; $i++)
			{
				$context['smileys'][$location][$j]['smileys'][$i]['code'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['code']);
				$context['smileys'][$location][$j]['smileys'][$i]['js_description'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['description']);
			}

			$context['smileys'][$location][$j]['smileys'][$n - 1]['last'] = true;
		}
		if (!empty($context['smileys'][$location]))
			$context['smileys'][$location][count($context['smileys'][$location]) - 1]['last'] = true;
	}
	$settings['smileys_url'] = $modSettings['smileys_url'] . '/' . $user_info['smiley_set'];
	$context['show_bbc'] = !empty($modSettings['enableBBC']) && !empty($settings['show_bbc']);
	if (!empty($modSettings['disabledBBC']))
	{
		$disabled_tags = explode(',', $modSettings['disabledBBC']);
		foreach ($disabled_tags as $tag)
			$context['disabled_tags'][trim($tag)] = true;
	}
	template_quickreply_box();
	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template']))
	{
		$settings['theme_url'] = $temp1;
		$settings['images_url'] = $temp2;
		$settings['theme_dir'] = $temp3;
	}
}
?>