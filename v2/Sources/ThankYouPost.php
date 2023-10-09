<?
if (!defined('SMF'))
	die('Hacking attempt...');
function ThankYou() {

	global $txt, $scripturl, $topic, $db_prefix, $modSettings, $board, $ID_MEMBER, $user_info;
	global $sc, $board_info, $context, $settings, $sourcedir;

	loadLanguage('Errors');
	loadLanguage('ThankYouPost');
	if(empty($_GET['msg']) || !is_numeric($_GET['msg']) || empty($topic))
		fatal_error($txt['NMidTopicSet'], false);
	ThankYouPostCheckClosed();

	if(!allowedTo('thank_you_post_post'))
		redirectexit();
	
	$request = db_query("
		SELECT ID_THX_POST, thx_time
		FROM {$db_prefix}thank_you_post
		WHERE ID_MSG = $_GET[msg] AND ID_MEMBER = $ID_MEMBER
		LIMIT 1", __FILE__, __LINE__);

	list($ID_THX_POST, $thx_time) = mysql_fetch_row($request);
	mysql_free_result($request);

	if(!empty($ID_THX_POST)) {
		$replaced = str_replace('[TIME]', timeformat($thx_time), $txt['allready_postet_thx']);
		fatal_error($replaced, false);
	}

	if(empty($modSettings['thankYouPostOnePerPost'])) {
		$request = db_query("
			SELECT id_thx_post, thx_time
			FROM {$db_prefix}thank_you_post
			WHERE id_topic = $topic AND id_member = $ID_MEMBER
			LIMIT 1", __FILE__, __LINE__);

		list($id_thx_post, $thx_time) = mysql_fetch_row($request);
		mysql_free_result($request);

		if(!empty($id_thx_post)) {
			$replaced = str_replace('[TIME]', timeformat($thx_time), $txt['allready_postet_thx']);
			fatal_error($replaced, false);
		}
	}

	//Load the Post data :)
	$post = db_query("
		SELECT ID_MSG, ID_MEMBER, thank_you_post, thank_you_post_counter
		FROM {$db_prefix}messages
		WHERE ID_TOPIC = $topic AND ID_MSG = $_GET[msg]
		LIMIT 1", __FILE__, __LINE__);

	list($ID_MSG, $ID_MEMBER_POST, $status, $count) = mysql_fetch_row($post);
	mysql_free_result($post);

	if(empty($ID_MSG))
		fatal_error($txt['WMidTopicSet'], false);
	elseif($ID_MEMBER == $ID_MEMBER_POST)
		fatal_error($txt['Thxtomyself'], false);
	elseif($status > 1)
		fatal_error($txt['thxislocked'], false);

	//Okay new one?
	if(empty($status))
		db_query("
			UPDATE {$db_prefix}messages
			SET thank_you_post = 1
			WHERE ID_MSG = $_GET[msg]
			LIMIT 1", __FILE__, __LINE__);

	//So mow add the now thx :)
	db_query("
		INSERT INTO {$db_prefix}thank_you_post
		(ID_MSG, ID_TOPIC, ID_BOARD, ID_MEMBER, memberName, thx_time)
		VALUES
		($ID_MSG, $topic, $board, $ID_MEMBER, '".$user_info['name']."', ".time().")", __FILE__, __LINE__);

	//Update Stats :)
	updateMemberData($ID_MEMBER, array('thank_you_post_made' => '+'));
	if(!empty($ID_MEMBER_POST))
		updateMemberData($ID_MEMBER_POST, array('thank_you_post_became' => '+'));

	//Okay Update the counter :)
	ThankYouPostCount($ID_MSG);

	//Okay all done now redirect exit :)
	if(!isset($_GET['list']))
		redirectexit('topic='.$topic.'.msg'.$ID_MSG.'#msg'.$ID_MSG);
	else
		redirectexit('action=thankyoupostlist;topic='.$topic.'.0;msg='.$ID_MSG);
}

function ThankYouPostDelete($msg_ids = array()) {

	global $txt, $topic, $db_prefix, $ID_MEMBER, $topic, $modSettings;

	loadLanguage('ThankYouPost');

	$session = true;
	$isAllowed = true;

	if(empty($msg_ids) && (empty($topic) || empty($_GET['msg']) || !is_numeric($_GET['msg'])))
		fatal_error($txt['NMidTopicSet'], false);
	//Massdelete is could be only made if you delete a thread or anything like that :)
	elseif(!empty($msg_ids) && empty($_GET['msg'])) {
		$session = false;
		$isAllowed = false;
		$msg_ids = !is_array($msg_ids) ? array($msg_ids) : $msg_ids;
	}
	else {
		$msg_ids = array($_GET['msg']);
	}

	if($session)
		checkSession('request');

	//Okay i'm here now to delete and correct the stats :)
	//First the where :D
	if(count($msg_ids) == 1)
		$where = "WHERE ID_MSG = ".current($msg_ids);
	else {
		$msg_ids = array_unique($msg_ids);
		$where = "WHERE ID_MSG IN (".implode(', ', $msg_ids).")";
	}

	//This is importend! I will only delete thing where really a known post is!
	$andCondition = ' AND thank_you_post != 0';

	//Load the Post data :)
	$post = db_query("
		SELECT ID_MSG, ID_MEMBER
		FROM {$db_prefix}messages
		$where $andCondition
		LIMIT ".count($msg_ids), __FILE__, __LINE__);

	$msg_ids = array();
	$msg_poster = array();

	while($row = mysql_fetch_assoc($post)) {
		//Built the real msg_ids ;)
		$msg_ids[] = $row['ID_MSG'];
		if(!empty($row['ID_MEMBER']))
			$msg_poster[$row['ID_MSG']] = $row['ID_MEMBER'];
	}

	mysql_free_result($post);

	//At least nothing to do?
	if(empty($msg_ids))
		return;
	elseif(count($msg_ids) == 1) {
		$where = "WHERE ID_MSG = ".current($msg_ids);
		$ID_MSG = current($msg_ids);
	}
	else {
		$msg_ids = array_unique($msg_ids);
		$where = "WHERE ID_MSG IN (".implode(', ', $msg_ids).")";
	}

	//So i look if i need to check some rights :)
	if($isAllowed) {
		if(count($msg_ids) != 1)
			fatal_error($txt['thankyouposterrorinscript']);

		$ID_MEMBER_POST = !empty($msg_poster) ? current($msg_poster) : 0;

		//Okay mal rechte prüfen :)
		if(!allowedTo('thank_you_post_delete_any') && !(allowedTo('thank_you_post_delete_own') && $ID_MEMBER == $ID_MEMBER_POST))
			fatal_error($txt['thxdeletenor'], false);
	}

	//Load the THX Infomations :)
	$poster = array();
	$thx_delete = array();

	$thx = db_query("
		SELECT ID_THX_POST, ID_MEMBER, ID_MSG
		FROM {$db_prefix}thank_you_post
		$where", __FILE__, __LINE__);

	while($row = mysql_fetch_assoc($thx)) {
		$poster[$row['ID_MSG']][] = $row['ID_MEMBER'];
		$thx_delete[] = $row['ID_THX_POST'];
	}

	mysql_free_result($thx);

	//So i need to split between single or multi delete :)
	if(!empty($thx_delete))
			//Delete the Thank You Posts :)
			db_query("
				DELETE FROM {$db_prefix}thank_you_post
				WHERE ID_THX_POST IN (".implode(', ', $thx_delete).")
				LIMIT ".count($thx_delete), __FILE__, __LINE__);

	//Okay set counter back to 0 and the status to 0 :)
	//Okay now correct member Settings *g*
	if(!empty($poster))
		foreach($poster as $id_posters)
			updateMemberData($id_posters, array('thank_you_post_made' => '-'));
	//now the resived Thank You
	if(!empty($msg_poster))
		foreach($msg_poster as $ID_MSG => $ID_MEMBER_POST)
			updateMemberData($ID_MEMBER_POST, array('thank_you_post_became' => 'thank_you_post_became - '.count($poster[$ID_MSG])));

	//Okay now reset the Stats :), i think i can do this blind ;D
	db_query("
		UPDATE {$db_prefix}messages
		SET thank_you_post = 0, thank_you_post_counter = 0
		$where
		LIMIT ".count($msg_ids), __FILE__, __LINE__);

	//Uff i'm finished now... hope it work all correct XD (still hoping after programming it) okay redirect, or not
	if(!empty($_GET['msg']) && !empty($topic) && $session)
		redirectexit('topic='.$topic.'.msg'.$_GET['msg'].'#msg'.$_GET['msg']);
	else
		return;
}

function ThankYouPostDeletePost() {

	global $txt, $topic, $db_prefix, $ID_MEMBER, $modSettings;

	loadLanguage('ThankYouPost');

	checkSession('get');

	if(empty($topic) || empty($_GET['thxid']) || !is_numeric($_GET['thxid']))
		fatal_error($txt['NMidTopicSet'], false);

	//Load this thanks and look if the user allowed to it, or if the rights are ;)
	$thx = db_query("
		SELECT ID_THX_POST, ID_MEMBER, ID_MSG
		FROM {$db_prefix}thank_you_post
		WHERE ID_THX_POST = $_GET[thxid]
			AND ID_TOPIC = $topic
		LIMIT 1", __FILE__, __LINE__);

	list($ID_THX, $ID_MEMBER_THX, $ID_MSG) = mysql_fetch_row($thx);
	mysql_free_result($thx);

	if(empty($ID_THX))
		fatal_error($txt['thxidnotfound'], false);

	//Okay let's look for the rights first :)
	if(!allowedTo('thank_you_post_delete_mem_any') && !(allowedTo('thank_you_post_delete_mem_own') && $ID_MEMBER == $ID_MEMBER_THX))
		fatal_error($txt['thxdeletenormem'], false);

	//More than one poster? if not the rights a little bit diffrent ;P
	$thx = db_query("
		SELECT ID_THX_POST
		FROM {$db_prefix}thank_you_post
		WHERE ID_MSG = $ID_MSG
		LIMIT 2", __FILE__, __LINE__);

	$count = mysql_num_rows($thx);
	mysql_free_result($thx);

	//This is a delete of a the thank you post so this is not allowed to every one!
	if($count != 2) {
		//I add now the msg so it look like a delete :D
		$_GET['msg'] = $ID_MSG;
		//Okay delete with the check of the rights ;D
		return ThankYouPostDelete();
	}
	else {
		//I need the poster to correct the stats ;)
		$post = db_query("
			SELECT ID_MEMBER
			FROM {$db_prefix}messages
			WHERE ID_MSG = $ID_MSG LIMIT 1", __FILE__, __LINE__);

		list($ID_MEMBER_POST) = mysql_fetch_row($post);
		mysql_free_result($post);
	}

	//Okay here this is a normal delete :)
	db_query("
		DELETE FROM {$db_prefix}thank_you_post
		WHERE ID_THX_POST = $ID_THX
		LIMIT 1", __FILE__, __LINE__);

	//Okay Correct the stats ;D
	updateMemberData($ID_MEMBER_THX, array('thank_you_post_made' => '-'));
	if(!empty($ID_MEMBER_POST))
		updateMemberData($ID_MEMBER_POST, array('thank_you_post_became' => '-'));

	//Okay Update the counter :)
	ThankYouPostCount($ID_MSG, '-');

	//redirectexit now :=)
	redirectexit('topic='.$topic.'.msg'.$ID_MSG.'#msg'.$ID_MSG);
}

function ThankYouPostList($msg_ids = array(), $preview = false) {

	global $txt, $scripturl, $topic, $db_prefix, $modSettings, $board, $ID_MEMBER, $user_info;
	global $sc, $board_info, $context, $settings, $sourcedir, $color_profile;

	loadLanguage('ThankYouPost');

	$modSettings += array(
		'thankYouPostColors' => 0,
		'thankYouPostPreview' => 0,
		'thankYouPostPreviewHM' => 0,
		'thankYouPostPreviewOrder' => 0,
		'thankYouPostFullOrder' => 0,
	);

	//I need to do nothing?
	if($preview && empty($modSettings['thankYouPostPreview']))
		return;

	if(empty($msg_ids) && empty($_GET['msg']) && !is_numeric($_GET['msg']))
		return;
	elseif(!empty($_GET['msg']) && is_numeric($_GET['msg']))
		$msg_ids = $_GET['msg'];

	$msg_ids = !is_array($msg_ids) ? array($msg_ids) : $msg_ids;
	//First the where :D
	if(count($msg_ids) == 1)
		$where = "WHERE ID_MSG = ".current($msg_ids);
	else {
		$msg_ids = array_unique($msg_ids);
		$where = "WHERE ID_MSG IN (".implode(', ', $msg_ids).")";
	}

	//Select Order Number between Prieview or Full Order :)
	$order = $preview ? $modSettings['thankYouPostPreviewOrder'] : $modSettings['thankYouPostFullOrder'];

	//Set the real Order now :)
	if($order == 1)
		$sort = 'ORDER BY thx.ID_THX_POST DESC';
	elseif($order == 2 && !$preview)
		$sort = 'ORDER BY mem.memberName';
	else
		$sort = 'ORDER BY thx.ID_THX_POST';

	//Limit for each list
	$limit = $preview && !empty($modSettings['thankYouPostPreviewHM']) ? $modSettings['thankYouPostPreviewHM'] : '0';

	//Okay Let's look and remove the not thank you posts :), also collect some datas :)
	//This is importend! I will only build list for thing where really a known post is!
	$andCondition = ' AND thank_you_post != 0';

	//Load the Post data :)
	$post = db_query("
		SELECT ID_MSG, ID_MEMBER, posterName
		FROM {$db_prefix}messages
		$where $andCondition
		LIMIT ".count($msg_ids), __FILE__, __LINE__);

	$msg_ids = array();
	$msg_poster = array();
	$msg_posterName = array();

	while($row = mysql_fetch_assoc($post)) {
		//Built the real msg_ids ;)
		$msg_ids[] = $row['ID_MSG'];
		if(!empty($row['ID_MEMBER']))
			$msg_poster[$row['ID_MSG']] = $row['ID_MEMBER'];
		//This is for guests :x
		$msg_posterName[$row['ID_MSG']] = $row['posterName'];
	}

	mysql_free_result($post);

	//At least nothing to do?
	if(empty($msg_ids))
		return;
	elseif(count($msg_ids) == 1) {
		$where = "WHERE ID_MSG = ".current($msg_ids);
		$ID_MSG = current($msg_ids);
	}
	else {
		$msg_ids = array_unique($msg_ids);
		$where = "WHERE ID_MSG IN (".implode(', ', $msg_ids).")";
	}

	//Okay i can set a real limit =D if only one id is searched :D
	if(!empty($limit) && count($msg_ids) == 1) {
		$speciallimit = 'LIMIT '.$modSettings['thankYouPostPreviewHM'];
		$limit = 0;
	}
	else
		$speciallimit = '';

	//Load the Memberdatas :) only if it not a preview :)
	if(!$preview)
		loadMemberData($msg_poster, 'minimal');

	$collecting_ids = array_values($msg_poster);

	//So i load a huge array okay depend on the thank who made xD... somehow i must find a better way for limit :x
	$thx = db_query("
		SELECT
			thx.ID_THX_POST AS ID_THX, thx.ID_MSG AS ID_MSG, thx.ID_TOPIC AS ID_TOPIC,
			thx.thx_time AS thx_time,
			IFNULL(mem.ID_MEMBER, 0) AS ID_MEMBER, IFNULL(mem.realName, thx.memberName) AS memberName
		FROM {$db_prefix}thank_you_post AS thx
			LEFT JOIN {$db_prefix}members AS mem ON (thx.ID_MEMBER = mem.ID_MEMBER)
		$where
		$sort
		$speciallimit", __FILE__, __LINE__);

	while($row = mysql_fetch_assoc($thx)) {
		//Current Member has postet?
		if(!isset($context['thank_you_post'][$row['ID_MSG']]['user_postet']) || !$context['thank_you_post'][$row['ID_MSG']]['user_postet'])
			$context['thank_you_post'][$row['ID_MSG']]['user_postet'] = $ID_MEMBER == $row['ID_MEMBER'];

		//Show only a small amount of it?
		if(!empty($limit)) {
			if(!isset($counter[$row['ID_MSG']]))
				$counter[$row['ID_MSG']] = 1;
			else
				$counter[$row['ID_MSG']]++;

			if($counter[$row['ID_MSG']] > $limit)
				continue;
		}

		//Okay Start the Array :)
		$context['thank_you_post'][$row['ID_MSG']]['fulllist'][$row['ID_THX']] = array(
			'ID_THX' => $row['ID_THX'],
			'ID_MEMBER' => $row['ID_MEMBER'],
			'memberName' => $row['memberName'],
			'href' => !empty($row['ID_MEMBER']) ? $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] : '',
			'link' => !empty($row['ID_MEMBER']) ? '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '" title="'. $txt['thank_you_post_thx_display'] .' '. $txt['thank_you_post_made_display'] . ': '.timeformat($row['thx_time'], false) . '">' . $row['memberName'] . '</a>' : $row['memberName'],
			'deletelink' => allowedTo('thank_you_post_delete_mem_any') || (allowedTo('thank_you_post_delete_mem_own') && $ID_MEMBER == $row['ID_MEMBER']) ? ' <a href="'.$scripturl.'?action=thankyoupostdm;thxid='.$row['ID_THX'].';topic='.$topic.';sesc='.$context['session_id'].'" onclick="return confirm(\''.$txt['remove_thank_you_post_mem'].'?\');"><span style="color:red">*</span></a>' : '',
			'thx_timestamp' => $row['thx_time'],
			'thx_time' => timeformat($row['thx_time']),
			'last' => false,
		);
if(!empty($row['ID_MEMBER']))
			$collecting_ids[] = $row['ID_MEMBER'];
	}

	mysql_free_result($thx);

	if(empty($context['thank_you_post']))
		return;
if(!empty($modSettings['thankYouPostColors'])) {
		thank_you_post_loadColors($collecting_ids);

		foreach($context['thank_you_post'] as $ID_MSG => $content) {
			if(!empty($content['fulllist'])) {
				foreach($content['fulllist'] as $ID_THX => $items) {
					//Okay Let's boogie woogie ;D
					$profile = $color_profile[$context['thank_you_post'][$ID_MSG]['fulllist'][$ID_THX]['ID_MEMBER']];
					if(!empty($profile['member_group_color']) || !empty($profile['post_group_color'])) {
						$time = timeformat($context['thank_you_post'][$ID_MSG]['fulllist'][$ID_THX]['thx_timestamp'], false);
						$context['thank_you_post'][$ID_MSG]['fulllist'][$ID_THX]['link'] = '<a href="' . $scripturl . '?action=profile;u=' . $profile['ID_MEMBER'] . '" title="'. $txt['thank_you_post_thx_display'] .' '. $txt['thank_you_post_made_display'] . ': '.$time.'"><span style="color:#000000">' . $profile['realName'] . '</span></a>';
					}
				}
				//Hehe a way to find the last item ;D
				$context['thank_you_post'][$ID_MSG]['fulllist'][$ID_THX]['last'] = true;
			}
		}
	}
	//Okay not colors but i need to fix something else :X
	else {
			foreach($msg_ids as $ID_MSG) {
				if(!empty($context['thank_you_post'][$ID_MSG]['fulllist'])) {
					//Hehe look strange but work fine and fast :)
					end($context['thank_you_post'][$ID_MSG]['fulllist']);
					//Last key of the list ;)
					$key = key($context['thank_you_post'][$ID_MSG]['fulllist']);
					//Set it to the last one
					$context['thank_you_post'][$ID_MSG]['fulllist'][$key]['last'] = true;
					//do like i'm do nothing ;D
					reset($context['thank_you_post'][$ID_MSG]['fulllist']);
				}
			}
	}
	return;
}

function ThankYouPostListShow() {

	global $txt, $scripturl, $topic, $db_prefix, $modSettings, $board, $ID_MEMBER, $user_info;
	global $sc, $board_info, $context, $settings, $sourcedir, $memberContext;

	if(!allowedTo('thank_you_post_show'))
		redirectexit();

	//Load the list ;)
	ThankYouPostList();

	//Okay the thank you is allready deleted... go back to the thread or to the startpage :)
	if(empty($context['thank_you_post'])) {
		if(!empty($topic)) {
			if(!isset($_GET['msg']))
				redirectexit('topic='.$topic.'.msg'.$_GET['msg'].'#msg'.$_GET['msg']);
			else
				redirectexit('topic='.$topic.'.0');
		}
		else
			redirectexit();
	}

	//Template
	loadTemplate('ThankYouPost');

	//Load the Topic Infomations
	$request = db_query("
		SELECT
			t.numReplies, t.numViews, t.locked, ms.subject, t.isSticky, t.ID_POLL,
			t.thank_you_post_locked,
			t.ID_MEMBER_STARTED, t.ID_FIRST_MSG, t.ID_LAST_MSG,
			" . ($user_info['is_guest'] ? '0' : 'IFNULL(lt.ID_MSG, -1) + 1') . " AS new_from
		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS ms)" . ($user_info['is_guest'] ? '' : "
			LEFT JOIN {$db_prefix}log_topics AS lt ON (lt.ID_TOPIC = $topic AND lt.ID_MEMBER = $ID_MEMBER)") ."
		WHERE t.ID_TOPIC = $topic
			AND ms.ID_MSG = t.ID_FIRST_MSG
		LIMIT 1", __FILE__, __LINE__);
	if (mysql_num_rows($request) == 0)
		fatal_lang_error(472, false);
	$topicinfo = mysql_fetch_assoc($request);
	mysql_free_result($request);

	// Build the link tree.
	$context['linktree'][] = array(
		'url' => $scripturl . '?topic=' . $topic . '.0',
		'name' => $topicinfo['subject'],
		'extra_before' => $settings['linktree_inline'] ? $txt[118] . ': ' : ''
	);
	// Extend the thank you ;) to the link tree :D.
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=thankyoupostlist;topic=' . $topic . '.0;msg='.$_GET['msg'],
		'name' => $txt['thankyoupostlist']
	);

	// Build a list of this board's moderators.
	$context['moderators'] = &$board_info['moderators'];
	$context['link_moderators'] = array();
	if (!empty($board_info['moderators']))
	{
		// Add a link for each moderator...
		foreach ($board_info['moderators'] as $mod)
			$context['link_moderators'][] = '<a href="' . $scripturl . '?action=profile;u=' . $mod['id'] . '" title="' . $txt[62] . '">' . $mod['name'] . '</a>';

		// And show it after the board's name.
		$context['linktree'][count($context['linktree']) - 2]['extra_after'] = ' (' . (count($context['link_moderators']) == 1 ? $txt[298] : $txt[299]) . ': ' . implode(', ', $context['link_moderators']) . ')';
	}

	// Information about the current topic...
	$context['is_locked'] = $topicinfo['locked'];
	$context['is_sticky'] = $topicinfo['isSticky'];
	$context['is_very_hot'] = $topicinfo['numReplies'] >= $modSettings['hotTopicVeryPosts'];
	$context['is_hot'] = $topicinfo['numReplies'] >= $modSettings['hotTopicPosts'];

	//Some Thank You things ;)
	$context['is_thank_you_post_locked'] = $topicinfo['thank_you_post_locked'];
	$context['thank_you_lock_allowed'] = !empty($board_info['thank_you_post_enable']) && !$user_info['is_guest'] && (allowedTo('thank_you_post_lock_all_any') || (allowedTo('thank_you_post_lock_all_own') && $ID_MEMBER == $topicinfo['ID_MEMBER_STARTED']));
	$context['thank_you_post_enable'] = $board_info['thank_you_post_enable'];
	$context['thank_you_post_unlock_all'] = false;
	$context['can_send_pm'] = allowedTo('send_pm');

	// We don't want to show the poll icon in the topic class here, so pretend it's not one.
	$context['is_poll'] = false;
	determineTopicClass($context);

	// Did this user start the topic or not?
	$context['user']['started'] = $ID_MEMBER == $topicinfo['ID_MEMBER_STARTED'] && !$user_info['is_guest'];
	$context['topic_starter_id'] = $topicinfo['ID_MEMBER_STARTED'];

	// Set the topic's information for the template.
	$context['subject'] = $topicinfo['subject'];
	$context['num_views'] = $topicinfo['numViews'];

	//Load the postinfomation :)
	$post = db_query("
		SELECT
			ID_MSG, icon, subject, posterTime, posterIP, ID_MEMBER, modifiedTime, modifiedName, body,
			smileysEnabled, posterName, posterEmail, thank_you_post, thank_you_post_counter
		FROM {$db_prefix}messages
		WHERE ID_MSG = $_GET[msg]
		LIMIT 1", __FILE__, __LINE__);

	$message = mysql_fetch_assoc($post);
	mysql_free_result($post);

	//Load Member Data of the Post
	if (!empty($message['ID_MEMBER']))
		loadMemberData($message['ID_MEMBER']);

	// If it couldn't load, or the user was a guest.... someday may be done with a guest table.
	if (!loadMemberContext($message['ID_MEMBER']))
	{
		// Notice this information isn't used anywhere else....
		$memberContext[$message['ID_MEMBER']]['name'] = $message['posterName'];
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

	// $context['icon_sources'] says where each icon should come from - here we set up the ones which will always exist!
	if (empty($context['icon_sources']))
	{
		$stable_icons = array('xx', 'thumbup', 'thumbdown', 'exclamation', 'question', 'lamp', 'smiley', 'angry', 'cheesy', 'grin', 'sad', 'wink', 'moved', 'recycled', 'wireless');
		$context['icon_sources'] = array();
		foreach ($stable_icons as $icon)
			$context['icon_sources'][$icon] = 'images_url';
	}

	//This Handels the Hidetag ;)...
	$context['user_post_avaible'] = 0;
	//This Thx can unhide itself?
	if(!$user_info['is_guest']) {
		if((!empty($modSettings['thankYouPostThxUnhideAll']) || !empty($modSettings['thankYouPostUnhidePost'])) && $context['thank_you_post'][$message['ID_MSG']]['user_postet'])
			$context['user_post_avaible'] = 1;
		//Okay you postet somewhere a thx and can see this hidden conent?
		elseif(!empty($modSettings['thankYouPostThxUnhideAll'])) {
			//Look for Thx post made in the Thread ;)
			$check = db_query("
				SELECT ID_THX_POST
				FROM {$db_prefix}thank_you_post
				WHERE ID_MEMBER = $ID_MEMBER
				AND ID_TOPIC = $topic
				LIMIT 1", __FILE__, __LINE__);

			list($ID_THX) = mysql_fetch_row($check);
			mysql_free_result;

			if(!empty($ID_THX))
				$context['user_post_avaible'] = 1;
		}

		//Okay Hide Standard is enabled, and i look if you postet here?
		if(empty($context['user_post_avaible']) && empty($modSettings['thankYouPostDisableUnhide'])) {
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
	else
		$context['user_post_avaible'] = 0;

	// Do the censor things.
	censorText($message['body']);
	censorText($message['subject']);

	// Run BBC interpreter on the message.
	$message['body'] = parse_bbc($message['body'], $message['smileysEnabled'], $message['ID_MSG']);

	//Okay Build the post ;)
	$context['thank_you_post']['post'] = array(
		'id' => $message['ID_MSG'],
		'alternate' => 0,
		'href' => $scripturl . '?topic=' . $topic . '.msg' . $message['ID_MSG'] . '#msg' . $message['ID_MSG'],
		'link' => '<a href="' . $scripturl . '?topic=' . $topic . '.msg' . $message['ID_MSG'] . '#msg' . $message['ID_MSG'] . '">' . $message['subject'] . '</a>',
		'member' => &$memberContext[$message['ID_MEMBER']],
		'icon' => $message['icon'],
		'icon_url' => $settings[$context['icon_sources'][$message['icon']]] . '/post/' . $message['icon'] . '.gif',
		'subject' => $message['subject'],
		'time' => timeformat($message['posterTime']),
		'timestamp' => forum_time(true, $message['posterTime']),
		'modified' => array(
			'time' => timeformat($message['modifiedTime']),
			'timestamp' => forum_time(true, $message['modifiedTime']),
			'name' => $message['modifiedName']
		),
		'body' => $message['body'],
		'can_see_ip' => allowedTo('moderate_forum') || ($message['ID_MEMBER'] == $ID_MEMBER && !empty($ID_MEMBER)),
		'thank_you_post' => array(
			'post' => !$context['thank_you_post'][$message['ID_MSG']]['user_postet'] && allowedTo('thank_you_post_post') && $ID_MEMBER != $message['ID_MEMBER'],
			'lock' => empty($context['is_thank_you_post_locked']) && (allowedTo('thank_you_post_lock_any') || (allowedTo('thank_you_post_lock_own') && $ID_MEMBER == $message['ID_MEMBER'])),
			'delete' => allowedTo('thank_you_post_delete_any') || (allowedTo('thank_you_post_delete_own') && $ID_MEMBER == $message['ID_MEMBER']),
			'counter' => !empty($message['thank_you_post_counter']) ? $message['thank_you_post_counter'] : '0',
			'locked' => !empty($message['thank_you_post']) && $message['thank_you_post'] > 1,
			'isThankYouPost' => !empty($message['thank_you_post']) && $message['thank_you_post'] >= 1,
			'href' => $scripturl . '?topic=' . $topic . '.msg' . $message['ID_MSG'] . '#msg' . $message['ID_MSG'],
		),
	);

	$context['page_title'] = $message['subject'];
	//This is needed for the Karma *g*
	$context['start'] = !empty($_REQUEST['start']) ? $_REQUEST['start'] : 0;
}

function ThankYouPostLock() {

	global $txt, $topic, $db_prefix, $ID_MEMBER;

	//Load some Languagefiles :)
	loadLanguage('Errors');
	loadLanguage('ThankYouPost');

	//Okay Okay ;D Most importend!
	if(empty($_GET['msg']) || !is_numeric($_GET['msg']) || empty($topic))
		fatal_error($txt['NMidTopicSet'], false);

	//First look if the Thank You closed?
	ThankYouPostCheckClosed();

	//Load the Post data :)
	$post = db_query("
		SELECT ID_MSG, ID_MEMBER, thank_you_post, thank_you_post_counter
		FROM {$db_prefix}messages
		WHERE ID_TOPIC = $topic AND ID_MSG = $_GET[msg]
		LIMIT 1", __FILE__, __LINE__);

	list($ID_MSG, $ID_MEMBER_POST, $status, $count) = mysql_fetch_row($post);
	mysql_free_result($post);

	if(empty($ID_MSG))
		fatal_error($txt['WMidTopicSet'], false);
	//Okay mal rechte prüfen :)
	elseif(!allowedTo('thank_you_post_lock_any') && !(allowedTo('thank_you_post_lock_own') && $ID_MEMBER == $ID_MEMBER_POST))
		fatal_error($txt['thxislockednor'], false);
	elseif(empty($status))
		fatal_error($txt['notathankyoupost'], false);

	//Hehe dann mal ändern :)
	db_query("
		UPDATE {$db_prefix}messages
		SET thank_you_post = IF(thank_you_post = 1, 2, 1)
		WHERE ID_MSG = $ID_MSG
		LIMIT 1", __FILE__, __LINE__);

	//Okay all done now Reddirect exit :)
	if(!isset($_GET['list']))
		redirectexit('topic='.$topic.'.msg'.$ID_MSG.'#msg'.$ID_MSG);
	else
		redirectexit('action=thankyoupostlist;topic='.$topic.'.0;msg='.$ID_MSG);
}

//This is  a small Skript to load colors for Thank You(a little bit faster... because sometime i need 100+ colors :x)
function thank_you_post_loadColors($users) {
	global $color_profile, $db_prefix, $modSettings;

	// Can't just look for no users :P.
	if (empty($users))
		return false;

	// Make sure it's an array.
	$users = !is_array($users) ? array($users) : array_unique($users);

	if (empty($users))
		return false;

	// Load the data.
	$request = db_query("
		SELECT
		mem.ID_MEMBER AS ID_MEMBER, mem.realName AS realName,
		mg.onlineColor AS member_group_color, IFNULL(mg.groupName, '') AS member_group,
		pg.onlineColor AS post_group_color, IFNULL(pg.groupName, '') AS post_group
		FROM {$db_prefix}members AS mem
		LEFT JOIN {$db_prefix}membergroups AS pg ON (pg.ID_GROUP = mem.ID_POST_GROUP)
		LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = mem.ID_GROUP)
		WHERE mem.ID_MEMBER ".(count($users) == 1 ? " = '" . current($users) . "'" : " IN ('" . implode("', '", $users) . "')"), __FILE__, __LINE__);

	$loaded_ids = array();
	while ($row = mysql_fetch_assoc($request))
	{
		$loaded_ids[] = $row['ID_MEMBER'];
		$color_profile[$row['ID_MEMBER']] = $row;
	}
	mysql_free_result($request);

	return empty($loaded_ids) ? false : $loaded_ids;
}

function ThankYouPostCount($msg_ids = array(), $counter = '+') {
	global $db_prefix, $modSettings;

	if(empty($msg_ids))
		return;

	if($counter != '+' && $counter != '-' && $counter != 'reset' && !is_numeric($counter)) {
		trigger_error("ThankYouPostCount(): Unkonwn 2. Paramter", E_USER_NOTICE);
		return;
	}

	$msg_ids = !is_array($msg_ids) ? array($msg_ids) : $msg_ids;

	if(count($msg_ids) == 1)
		$where = "WHERE ID_MSG = ".current($msg_ids);
	else {
		$msg_ids = array_unique($msg_ids);
		$where = "WHERE ID_MSG IN (".implode(', ', $msg_ids).")";
	}

	//Limit :)
	$limit = "
		LIMIT ".count($msg_ids);

	//Build the sets :)
	if($counter == '+' || $counter == '-')
		$set = 'SET thank_you_post_counter = IF(thank_you_post_counter '.$counter.' 1 < 0, 0, thank_you_post_counter '.$counter.' 1)';
	elseif(is_numeric($counter)) {
		$counter = (int) $counter;

		//Never go bellow 0 ;)
		if($counter < 0)
			$counter = 0;

		$set = "SET thank_you_post_counter = $counter";
	}
	//Recalculate all Values :x, a lot of things to do <<
	else {
		//Theres a fast and long way :)
			$count = db_query(
				"SELECT COUNT(*) as counter, ID_MSG
				FROM {$db_prefix}thank_you_post
				$where
				GROUP BY ID_MSG", __FILE__, __LINE__);

		//The fast way :)
		if(count($msg_ids) == 1) {
			list($counter, $ID_MSG) = mysql_fetch_row($count);
			mysql_free_result($count);

			$counter = empty($counter) ? 0 : $counter;
			//Set the statment :)
			$set = "SET thank_you_post_counter = $counter";
		}
		//Long way...
		else {

			//Change all step by step :)
			while($row = mysql_fetch_assoc($count))
				ThankYouPostCount($row['ID_MSG'], $row['counter']);

			mysql_free_result($count);
			//So after this i'm finished :)
			return;
		}
	}

	//Okay i will update it :) (But only if all is correct :X
	if(!empty($set) && !empty($where) && !empty($limit)) {
		db_query("
			UPDATE {$db_prefix}messages
			$set
			$where
			$limit",__FILE__, __LINE__);
	}
	else
		trigger_error("ThankYouPostCount(): Could not update counter", E_USER_NOTICE);

	return;
}

function ThankYouPostCheckClosed() {
	global $topic, $txt, $db_prefix;

	//Missing language file?
	if(!isset($txt['NMidTopicSet']))
		loadLanguage('ThankYouPost');

	if(empty($topic))
		fatal_error($txt['NMidTopicSet'], false);

	//Check if locked ;)
	$check = db_query("
		SELECT thank_you_post_locked
		FROM {$db_prefix}topics
		WHERE ID_TOPIC = $topic
		LIMIT 1", __FILE__, __LINE__);

	$locked = mysql_fetch_assoc($check);
	mysql_free_result($check);

	if(empty($locked['thank_you_post_locked']) || $locked['thank_you_post_locked'] < 1)
		return true;
	else
		fatal_error($txt['thxislocked'], false);
}

function ThankYouPostCloseAll() {
	global $txt, $topic, $db_prefix, $ID_MEMBER;

	//Load some Languagefiles :)
	loadLanguage('Errors');
	loadLanguage('ThankYouPost');

	//Okay Okay ;D Most importend!
	if(empty($topic))
		fatal_error($txt['NMidTopicSet'], false);

	//Load the Topic Starter informations ;)
	$topicinfo = db_query("
		SELECT ID_MEMBER_STARTED
		FROM {$db_prefix}topics
		WHERE ID_TOPIC = $topic
		LIMIT 1", __FILE__, __LINE__);

	list($ID_MEMBER_STARTED) = mysql_fetch_row($topicinfo);
	mysql_free_result($topicinfo);

	//Okay check the right
	if(!(allowedTo('thank_you_post_lock_all_own') && $ID_MEMBER == $ID_MEMBER_STARTED) && !allowedTo('thank_you_post_lock_all_any'))
 		fatal_error($txt['thxislockednor'], false);

 	//Okay change it ;)
	db_query("
		UPDATE {$db_prefix}topics
		SET thank_you_post_locked = IF(thank_you_post_locked = 0, 1, 0)
		WHERE ID_TOPIC = $topic
		LIMIT 1", __FILE__, __LINE__);

	redirectexit('topic='.$topic);
}

function ThankYouPostRemoveTopics($topics = array()) {
	global $db_prefix;

	//Okay Let's do the work, no checks here because the user already allowed to remove topics,
	//so i will allow remove thank you from this topics :)!
	if(empty($topics))
		return;
	elseif(count($topics) == 1)
		$condition = 'ID_TOPIC = '.current($topics);
	else
		$condition = 'ID_TOPIC IN ('.implode(', ', $topics).')';

	//Okay now do the work, load all topic infomations and all the ID_MSG... and update all members... and so on...
	//now nothing can be stoped any more <<
	$posts = db_query("
		SELECT ID_MSG
		FROM {$db_prefix}messages
		WHERE $condition
		AND thank_you_post != 0", __FILE__, __LINE__);

	$msg_ids = array();

	while($row = mysql_fetch_assoc($posts))
		$msg_ids[] = current($row);

	mysql_free_result($posts);

	//Nothing to do? Hope so... if not hope it take not to long :X Okay depent on the posts who made <<
	if(empty($msg_ids))
		return;
	else
		ThankYouPostDelete($msg_ids);

	return;
}

function ThankYouPostUnlockAllPosts() {
	global $db_prefix, $txt, $topic;

	loadLanguage('ThankYouPost');

	if(empty($topic))
		fatal_error($txt['NMidTopicSet'], false);

	//Allowed to do this?
	isAllowedTo('thank_you_post_unlock_all');

	//Okay do it now ;)
	db_query("
		UPDATE {$db_prefix}messages
		SET thank_you_post = IF(thank_you_post = 2, 1, thank_you_post)
		WHERE ID_TOPIC = $topic", __FILE__, __LINE__);

		redirectexit('topic='.$topic);
}

// Miscellaneous Count maintenance..
function ThankYouPostRecountAll()
{
	global $context, $txt, $db_prefix, $user_info, $modSettings;

	// Select it on the left.
	adminIndex('maintain_forum');

	$context['page_title'] = $txt['not_done_title'];
	$context['continue_post_data'] = '';
	$context['continue_countdown'] = '3';
	$context['sub_template'] = 'not_done';

	// Try for as much time as possible.
	@set_time_limit(600);

	$maintenance_done = false;

	//Okay Let's do the work ;)
	if(!isset($_GET['substep']))
		$_GET['substep'] = 0;

	if(!isset($_GET['pos']))
		$_GET['pos'] = 0;
		
	if(!isset($step_count))
		$step_count = 0;
	if(!isset($rows))
		$rows = 0;

	//First Callculate all the Thank You Post Counts :)
	if(empty($_GET['pos'])) {
		//250 Querys in a short time should be enouph *g*
		$step_count = 250;

		$counter = db_query("
			SELECT count(*) as count, ID_MSG
			FROM {$db_prefix}thank_you_post
			GROUP BY ID_MSG
			LIMIT $_GET[substep], $step_count", __FILE__, __LINE__);

		$rows = mysql_num_rows($counter);
		//Replace all
		while($row = mysql_fetch_assoc($counter))
			db_query("
				UPDATE {$db_prefix}messages
				SET thank_you_post_counter = $row[count]
				WHERE ID_MSG = $row[ID_MSG]
				LIMIT 1", __FILE__, __LINE__);

		mysql_free_result($counter);

		//Reload Settings :)
		if(empty($rows))
			$_GET['pos'] = 1;
	}

	//Updating all Member Stats made stats ;)
	if($_GET['pos'] == 1) {
		$step_count = 250;

		$counter = db_query("
			SELECT count(*) as count, ID_MEMBER
			FROM {$db_prefix}thank_you_post
			GROUP BY ID_MEMBER
			LIMIT $_GET[substep], $step_count", __FILE__, __LINE__);

		$rows = mysql_num_rows($counter);
		//Replace all
		while($row = mysql_fetch_assoc($counter))
			db_query("
				UPDATE {$db_prefix}members
				SET thank_you_post_made = $row[count]
				WHERE ID_MEMBER = $row[ID_MEMBER]
				LIMIT 1", __FILE__, __LINE__);

		//Reload Settings :)
		if(empty($rows))
			$_GET['pos'] = 2;
	}

	//This is work... hmmm how made this fast? very difficult ;)
	//Okay calculate the became thank yous new ;D That wach user give to you... a lot work <<
	if($_GET['pos'] == 2) {
		//Think about... if you made this to high it can take a long time tu build ;).
		$step_count = 50;

		$counter = db_query("
			SELECT ID_MEMBER, SUM(thank_you_post_counter) as count
			FROM {$db_prefix}messages
			WHERE thank_you_post != 0
			GROUP BY ID_MEMBER
			LIMIT $_GET[substep], $step_count", __FILE__, __LINE__);

		$rows = mysql_num_rows($counter);
		//Replace all
		while($row = mysql_fetch_assoc($counter)) {
			db_query("
				UPDATE {$db_prefix}members
				SET thank_you_post_became = $row[count]
				WHERE ID_MEMBER = $row[ID_MEMBER]
				LIMIT 1", __FILE__, __LINE__);
		}

		if(empty($rows))
			$maintenance_done = true;
	}

	if($_GET['pos'] > 2)
		$maintenance_done = true;

	if(!$maintenance_done) {
		if($step_count > $rows) {
			$_GET['pos']++;
			$_GET['substep'] = 0;
		}
		else {
			$_GET['substep'] = $_GET['substep'] + $step_count;
		}
		return ThankYouPostRM();
	}

	//Okay it's done so beck to maintaince done ;)
	redirectexit('action=maintain;done');
}

function ThankYouPostRM() {
	//Okay redirect back ;)
	redirectexit('action='.$_REQUEST['action'].';substep='.$_GET['substep'].';pos='.$_GET['pos']);
}

// Miscellaneous Repair maintenance..
function ThankYouPostRepairTable()
{
	global $context, $txt, $db_prefix, $user_info, $modSettings;

	// Select it on the left.
	adminIndex('maintain_forum');

	$context['page_title'] = $txt['not_done_title'];
	$context['continue_post_data'] = '';
	$context['continue_countdown'] = '3';
	$context['sub_template'] = 'not_done';

	// Try for as much time as possible.
	@set_time_limit(600);

	$maintenance_done = false;

	//Okay Let's do the work ;)
	if(!isset($_GET['substep']))
		$_GET['substep'] = 0;

	if(!isset($_GET['pos']))
		$_GET['pos'] = 0;

	if(!isset($step_count))
		$step_count = 0;
	if(!isset($rows))
		$rows = 0;

	//Find all the not existing Posts and remove them from the thank you ;)
	if(empty($_GET['pos'])) {
		$step_count = 250;

		$counter = db_query("
			SELECT t.ID_MSG as ID_MSG
			FROM {$db_prefix}thank_you_post as t
				LEFT JOIN {$db_prefix}messages as m ON (t.ID_MSG = m.ID_MSG)
			WHERE m.ID_MSG IS NULL
			GROUP BY ID_MSG
			LIMIT $step_count", __FILE__, __LINE__);

		$rows = mysql_num_rows($counter);
		//Replace all
		$msg_ids = array();
		while($row = mysql_fetch_assoc($counter))
			$msg_ids[] = $row['ID_MSG'];

		mysql_free_result($counter);

		if(!empty($msg_ids))
			//Delete all, need no recalculation, because i miss the master things ;)
			db_query("
				DELETE FROM {$db_prefix}thank_you_post
				WHERE ID_MSG IN (".implode(', ', $msg_ids).")", __FILE__, __LINE__);

		//Reload Settings :)
		if(empty($rows))
			$_GET['pos'] = 1;
	}

	//Search for not enabled Thank You Boards ;)
	if($_GET['pos'] == 1) {
		$step_count = 250;

		//Load not enabled list, and remove recycler ;D
		$boardlist = db_query("
			SELECT ID_BOARD
			FROM {$db_prefix}boards
			WHERE thank_you_post_enable != 0 AND ID_BOARD != $modSettings[recycle_board]", __FILE__, __LINE__);

		$boards = array();
		while($row = mysql_fetch_assoc($boardlist))
			$boards[] = $row['ID_BOARD'];

		//Nothing to do? Go to next step ;)
		if(empty($boards)) {
			$_GET['pos']++;
			$_GET['substep'] = 0;
			return ThankYouPostRM();
		}

		//Okay delete all this posts
		$counter = db_query("
			SELECT ID_MSG
			FROM {$db_prefix}thank_you_post
			WHERE ID_BOARD IN (".implode(', ', $boards).")
			GROUP BY ID_MSG
			LIMIT $step_count", __FILE__, __LINE__);

		$rows = mysql_num_rows($counter);
		//Replace all
		$msg_ids = array();
		while($row = mysql_fetch_assoc($counter))
			$msg_ids[] = $row['ID_MSG'];

		mysql_free_result($counter);

		if(!empty($msg_ids))
			//Delete all, an recallculate stats :)
			ThankYouPostDelete($msg_ids);

		if(empty($rows) || empty($msg_ids))
			$_GET['pos'] = 2;
	}

	//Find double entries but only if the modSetting is set ;)
	//Each time i must goo through the complete list... so it could take longer than thought :x
	if($_GET['pos'] == 2 && empty($modSettings['thankYouPostOnePerPost'])) {
		$step_count = 500;

		//I go in a while condition... until i find some ;)
		$roundToTry = 0;
		$gogogo = true;

		while($gogogo && $roundToTry <= 20) {
			$counter = db_query("
				SELECT ID_MEMBER, COUNT(ID_MEMBER) as count, ID_TOPIC
				FROM {$db_prefix}thank_you_post
				GROUP BY ID_TOPIC, ID_MEMBER
				LIMIT $_GET[substep], $step_count", __FILE__, __LINE__);

			$rows = mysql_num_rows($counter);
			//Replace all
			$toMuch = array();
			while($row = mysql_fetch_assoc($counter))
				if($row['count'] > 1)
					$toMuch[] = array(
						'ID_MEMBER' => $row['ID_MEMBER'],
						'ID_TOPIC' => $row['ID_TOPIC'],
						'count' => $row['count'],
						'limit' => $row['count'] - 1,
					);

			mysql_free_result($counter);

			//Save ;)
			$roundToTry++;

			$gogogo = !empty($rows) && empty($toMuch);

			if($gogogo && $roundToTry <= 20)
				$_GET['substep'] = $_GET['substep'] + $step_count;
		}

		//Okay something to remove? ;)
		if(!empty($toMuch)) {
			foreach($toMuch as $toSearch) {
				//Mistake?
				if($toSearch['count'] <= 1)
					continue;

				$thx = db_query("
					SELECT ID_THX_POST as ID_THX, ID_MSG, ID_MEMBER
					FROM {$db_prefix}thank_you_post
					WHERE ID_TOPIC = $toSearch[ID_TOPIC]
					LIMIT 1, $toSearch[limit]", __FILE__, __LINE__);

				$remove_ids = array();
				while($row = mysql_fetch_assoc($thx))
					$remove_ids[$row['ID_MSG']] = array(
						'ID_THX' => $row['ID_THX'],
						'ID_MEMBER' => $row['ID_MEMBER'],
					);

				mysql_free_result($thx);

				if(empty($remove_ids))
					continue;

				//Next Step... single post delete or is it a complete delete ;), it's a diffrence ;P
				//Load Message infomations for the ID_MSGs ;)
				$posts = db_query("
					SELECT ID_MSG, ID_MEMBER AS ID_MEMBER_POSTER, thank_you_post_counter
					FROM {$db_prefix}messages
					WHERE ID_MSG IN(".implode(', ', array_keys($remove_ids)).")
					LIMIT ".count(array_keys($remove_ids)), __FILE__, __LINE__);

				$toDelete = array(
					'single' => array(),
					'complete' => array(),
				);

				while($row = mysql_fetch_assoc($posts)) {
					if($row['thank_you_post_counter'] == 1)
						$toDelete['complete'][] = $row['ID_MSG'];
					else
						$toDelete['single'][] = array(
							'ID_MSG' => $row['ID_MSG'],
							'ID_MEMBER_POSTER' => $row['ID_MEMBER_POSTER'],
							'ID_THX' => $remove_ids[$row['ID_MSG']]['ID_THX'],
							'ID_MEMBER' => $remove_ids[$row['ID_MSG']]['ID_MEMBER'],
						);
				}

				if(empty($toDelete['complete']) && empty($toDelete['complete']))
				 continue;

				if(!empty($toDelete['complete']))
					ThankYouPostDelete($toDelete['complete']);

				if(!empty($toDelete['single'])) {
					//Okay Step by step *g*
					$msg_ids = array();
					$thx_ids = array();
					//First Step decrase all became and made stats of the selected members
					foreach($toDelete['single'] as $value) {
						$msg_ids[] = $value['ID_MSG'];
						$thx_ids[] = $value['ID_THX'];
						//Update Stats :)
						updateMemberData($value['ID_MEMBER'], array('thank_you_post_made' => '-'));
						if(!empty($value['ID_MEMBER_POSTER']) && $value['ID_MEMBER_POSTER'] != '-1')
							updateMemberData($value['ID_MEMBER_POSTER'], array('thank_you_post_became' => '-'));
					}

					//Remove the thx ids
					if(!empty($thx_ids))
						db_query("
							DELETE FROM {$db_prefix}thank_you_post
							WHERE ID_THX_POST IN (".implode(', ', $thx_ids).")
							LIMIT ".count($thx_ids), __FILE__, __LINE__);

					//Recalculate the Complete Sum of the post count ;)
					if(!empty($msg_ids))
						ThankYouPostCount($msg_ids, 'reset');
				}
			}
		}

		if(empty($rows))
			$_GET['pos'] = 3;
	}
	elseif($_GET['pos'] == 2)
		$_GET['pos'] = 3;

	//Look for 0 Thank You Post Count but thank you post is enabled! Disable Them ;)
	if($_GET['pos'] == 3) {
		db_query("
			UPDATE {$db_prefix}messages
			SET thank_you_post = 0
			WHERE thank_you_post_counter = 0 AND thank_you_post != 0", __FILE__, __LINE__);

		$maintenance_done = true;
	}

	if($_GET['pos'] > 3)
		$maintenance_done = true;

	if(!$maintenance_done) {
		if($step_count > $rows) {
			$_GET['pos']++;
			$_GET['substep'] = 0;
		}
		else {
			$_GET['substep'] = $_GET['substep'] + $step_count;
		}
		return ThankYouPostRM();
	}

	//Okay it's done so beck to maintaince done ;)
	redirectexit('action=maintain;done');
}

?>