<?php

/**********************************************************************************
* Buddies.php                                                                      *
***********************************************************************************
* Version: 0.8.5
* This file is a part of Ultimate Profile mod
* Author: Jovan Turanjanin                                                      *
**********************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');
	
function BuddiesMain()
{
	isAllowedTo ('profile_extra_own');

        if(loadLanguage('Buddies') == false)
            loadLanguage('Buddies','spanish');

        loadTemplate('Buddies');
	
	switch (@$_GET['sa'])
        {
		case 'add': BuddyAdd(); break;
		case 'remove': BuddyRemove(); break;
		case 'approve': BuddyApprove(); break;
		case 'order': BuddyOrder(); break;
		default: Buddies();
	}
}





function Buddies()

{
	global $db_prefix, $ID_MEMBER, $context, $user_profile, $memberContext,  $txt;
	
	// approved buddies
	$buddies = array();
	$request = db_query ('SELECT BUDDY_ID FROM ' . $db_prefix . 'buddies 
			WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND approved = 1 
			ORDER BY position ASC, time_updated DESC', __FILE__, __LINE__);
	
	while ($row = mysql_fetch_assoc($request))
		$buddies[] = $row['BUDDY_ID'];

	mysql_free_result($request);

	// Load all the members up.
	loadMemberData($buddies, false, 'profile');

	$context['buddies'] = array();
	foreach ($buddies as $buddy)
	{
		loadMemberContext($buddy);
		$context['buddies'][$buddy] = $memberContext[$buddy];
	}
	
	// unapproved buddies
	$buddies = array();
	$request = db_query ('SELECT BUDDY_ID FROM ' . $db_prefix . 'buddies 
			WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND approved = 0 AND requested <> ' . $ID_MEMBER  . '
			ORDER BY position ASC, time_updated DESC', __FILE__, __LINE__);
	
	while ($row = mysql_fetch_assoc($request))
		$buddies[] = $row['BUDDY_ID'];
	mysql_free_result($request);
	
	if (count ($buddies) > 0) {
		// Load all the members up.
		loadMemberData($buddies, false, 'profile');
	
		$context['unapproved'] = array();
		foreach ($buddies as $buddy)
		{
			loadMemberContext($buddy);
			$context['unapproved'][$buddy] = $memberContext[$buddy];
		}
	}
	
	// pending buddies
	$buddies = array();
	$request = db_query ('SELECT ID_MEMBER FROM ' . $db_prefix . 'buddies 
			WHERE BUDDY_ID = ' . $ID_MEMBER . ' AND approved = 0 AND requested = ' . $ID_MEMBER  . '
			ORDER BY position ASC, time_updated DESC', __FILE__, __LINE__);
	
	while ($row = mysql_fetch_assoc($request))
		$buddies[] = $row['ID_MEMBER'];
	mysql_free_result($request);
	
	if (count ($buddies) > 0) {
		// Load all the members up.
		loadMemberData($buddies, false, 'profile');
	
		$context['pending'] = array();
		foreach ($buddies as $buddy)
		{
			loadMemberContext($buddy);
			$context['pending'][$buddy] = $memberContext[$buddy];
		}
	}
	
	$_GET['action'] = 'profile'; // just for the tab...
	$context['page_title'] = $txt['Buddies_center'];
	$context['sub_template'] = 'buddy_center';
}

function BuddyOrder()
{
	global $db_prefix, $ID_MEMBER;
	
	checkSession('get');
	
	$user = (int)$_GET['u'];
	
	$request = db_query ('SELECT position FROM ' . $db_prefix . 'buddies WHERE BUDDY_ID = ' . $user . ' AND ID_MEMBER = ' . $ID_MEMBER, __FILE__, __LINE__);
	list ($old_position) = mysql_fetch_row ($request);	
	
	if ($_GET['dir'] == 'up')
		$request = db_query ('SELECT BUDDY_ID, position FROM ' . $db_prefix . 'buddies WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND position < ' . $old_position . ' ORDER BY time_updated DESC LIMIT 1', __FILE__, __LINE__);
	else
		$request = db_query ('SELECT BUDDY_ID, position FROM ' . $db_prefix . 'buddies WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND position > ' . $old_position . ' ORDER BY time_updated DESC LIMIT 1', __FILE__, __LINE__);
	
	list ($buddy_id, $new_position) = mysql_fetch_row ($request);
	$buddy_id = (int)$buddy_id;
	$new_position = (int)$new_position;
	
	if ($new_position == 0)
		$new_position = ($_GET['dir'] == 'up') ? $old_position - 1 : $old_position + 1;
	
	db_query ('UPDATE ' . $db_prefix . 'buddies SET position = "' . $new_position . '", time_updated = "' . time() . '" WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND BUDDY_ID = ' . $user, __FILE__, __LINE__);
	db_query ('UPDATE ' . $db_prefix . 'buddies SET position = "' . $old_position . '", time_updated = "' . time() . '" WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND BUDDY_ID = ' . $buddy_id, __FILE__, __LINE__);
	
	redirectexit('action=buddies');
}

function BuddyAdd()

{
	global $db_prefix, $ID_MEMBER, $sourcedir, $txt, $context, $scripturl;
	
	checkSession('get');
	
	$user = (int)$_GET['u'];

        if ($ID_MEMBER == $user)
            	fatal_error ($txt['Buddies_youself'], false);

	$request = db_query ('SELECT approved FROM ' . $db_prefix . 'buddies WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND BUDDY_ID = ' . $user, __FILE__, __LINE__);
	if (mysql_num_rows ($request) > 0)
		fatal_error ($txt['Buddies_again'], false);
	
	$request = db_query ('SELECT realName FROM ' . $db_prefix . 'members WHERE ID_MEMBER = ' . $user, __FILE__, __LINE__);
	if (mysql_num_rows ($request) < 1)
		redirectexit();
		
	// Find the new position.
	$request = db_query ('SELECT position FROM ' . $db_prefix . 'buddies 
			WHERE ID_MEMBER = ' . $ID_MEMBER . '  
			ORDER BY position DESC
			LIMIT 1', __FILE__, __LINE__);

	list ($position) = mysql_fetch_row ($request);
	$position = $position + 1;

	db_query ('INSERT INTO ' . $db_prefix . 'buddies SET ID_MEMBER = ' . $ID_MEMBER . ', BUDDY_ID = ' . $user . ', approved = 0, position = ' . $position . ', time_updated = "' . time() . '", requested = ' . $ID_MEMBER, __FILE__, __LINE__);

	$request = db_query ('SELECT position FROM ' . $db_prefix . 'buddies 
			WHERE ID_MEMBER = ' . $user . '
			ORDER BY position DESC
			LIMIT 1', __FILE__, __LINE__);

	list ($position) = mysql_fetch_row ($request);
	$position = $position + 1;

	db_query ('INSERT INTO ' . $db_prefix . 'buddies SET BUDDY_ID = ' . $ID_MEMBER . ', ID_MEMBER = ' . $_GET['u'] . ', approved = 0, position = ' . $position . ', time_updated = "' . time() . '", requested = ' . $ID_MEMBER, __FILE__, __LINE__);

	// Let's notify the user.
	require_once $sourcedir . '/Subs-Post.php';
	sendpm (array('to' => array($user), 'bcc' => array()), sprintf ($txt['Buddies_permission_short'], $context['user']['name']), sprintf ($txt['Buddies_permission_long'], $context['user']['name'], $scripturl . '?action=buddies'), false, array ('id' => 0, 'name' => $txt['profile_notif_com_user'], 'username' => $txt['profile_notif_com_user']));

        fatal_error ($txt['Buddies_added'], false);
	//redirectexit('action=profile;u=' . $_GET['u']);
}



function BuddyApprove()

{
	global $db_prefix, $ID_MEMBER, $user_info, $user_profile;

	checkSession('get');
	
	$_GET['u'] = (int)$_GET['u'];
	
	db_query ('UPDATE ' . $db_prefix .'buddies SET approved = 1 WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND BUDDY_ID = ' . $_GET['u'], __FILE__, __LINE__);
	db_query ('UPDATE ' . $db_prefix .'buddies SET approved = 1 WHERE BUDDY_ID = ' . $ID_MEMBER . ' AND ID_MEMBER = ' . $_GET['u'], __FILE__, __LINE__);
	
	// update SMF's system as well...
	$user_info['buddies'][] = $_GET['u'];
	updateMemberData($ID_MEMBER, array('buddy_list' => "'" . implode(',', $user_info['buddies']) . "'"));
	
	loadMemberData($_GET['u'], false, 'normal');
	$buddies = explode (',', $user_profile[$_GET['u']]['buddy_list']);
	$buddies[] = $ID_MEMBER;
	updateMemberData($_GET['u'], array('buddy_list' => "'" . implode(',', $buddies) . "'"));
	
	redirectexit('action=buddies');
}

function BuddyRemove()
{
	global $db_prefix, $ID_MEMBER, $user_info, $user_profile;
	
	checkSession('get');
	
	$_GET['u'] = (int)$_GET['u'];
	
	db_query ('DELETE FROM ' . $db_prefix . 'buddies WHERE ID_MEMBER = ' . $ID_MEMBER . ' AND BUDDY_ID = ' . $_GET['u'], __FILE__, __LINE__);
	db_query ('DELETE FROM ' . $db_prefix . 'buddies WHERE BUDDY_ID = ' . $ID_MEMBER . ' AND ID_MEMBER = ' . $_GET['u'], __FILE__, __LINE__);
	
	// update SMF's system as well...
	$user_info['buddies'] = array_diff($user_info['buddies'], array($_GET['u']));
	updateMemberData($ID_MEMBER, array('buddy_list' => "'" . implode(',', $user_info['buddies']) . "'"));
	
	loadMemberData($_GET['u'], false, 'normal');
	$buddies = explode (',', $user_profile[$_GET['u']]['buddy_list']);
	$buddies = array_diff($buddies, array($ID_MEMBER));
	updateMemberData($_GET['u'], array('buddy_list' => "'" . implode(',', $buddies) . "'"));
	
	redirectexit('action=buddies');
}
?>