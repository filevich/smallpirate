<?php
if (!defined('SMF'))
	die('Hacking attempt...');

function Shop()
{
	global $context, $modSettings, $scripturl, $db_prefix, $ID_MEMBER;
	global $txt, $item_info, $boardurl, $sourcedir, $func;
	
	require_once($sourcedir . '/shop/Shop-Subs.php');
	include_once($sourcedir . '/Subs-Post.php');
	include_once($sourcedir . '/Subs-Auth.php');

        if(loadLanguage('PersonalMessage') == false)
            loadLanguage('PersonalMessage','english');

        if(loadLanguage('Shop') == false)
            loadLanguage('Shop','english');

	header("Expires: Fri, 1 Jun 1990 00:00:00 GMT"); // My birthday ;)
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Pragma: no-cache");

	loadTemplate('Shop');
	is_not_guest($txt['shop_guest_message']);
	isAllowedTo('shop_main');
	$context['template_layers'][] = 'shop';
	$context['linktree'][] = array(
		'url' => $scripturl . '?action=shop',
		'name' => $txt['shop'],
	);
	if (empty($_GET['do']))
		$_GET['do'] = 'home';	
	if ($_GET['do'] == "home")
	{
		$context['linktree'][] = array(
			'url' => $scripturl . 'action=shop',
			'name' => $txt['shop'] . ' Home',
		); 
		$context['shop_richest'] = array();
		$result = db_query("
			SELECT ID_MEMBER, realName, money
			FROM {$db_prefix}members
			ORDER BY money DESC, realName
			LIMIT 10", __FILE__, __LINE__);
		// Loop through all results
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			// And add them to the list
			$context['shop_richest'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'realName' => $row['realName'],
				'money' => $row['money']
			);
			
		mysql_free_result($result);

		$context['shop_richestBank'] = array();
		$result = db_query("
			SELECT ID_MEMBER, realName, moneyBank
			FROM {$db_prefix}members
			ORDER BY moneyBank DESC, realName
			LIMIT 10", __FILE__, __LINE__);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			$context['shop_richestBank'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'realName' => $row['realName'],
				'moneyBank' => $row['moneyBank']
			);
			
		mysql_free_result($result);

		$context['shop_do'] = 'main';
		$context['page_title'] = $txt['shop'];
		$context['sub_template'] = 'main';

	}
	elseif (substr($_GET['do'], 0, 3) == "buy") // Buy an item
		require "Shop-Buy.php";
	elseif (substr($_GET['do'], 0, 3) == "inv") // View inventory
		require "Shop-Inventory.php";
	elseif (substr($_GET['do'], 0, 4) == "send") //Send money
		require "Shop-Send.php";
	elseif (substr($_GET['do'], 0, 4) == "bank" || $_GET['do'] == "deposit" || $_GET['do'] == "withdraw") //Bank stuff
		require "Shop-Bank.php";
	elseif (substr($_GET['do'], 0, 5) == "trade") //Trade Centre
		require "Shop-Trade.php";
		
	// View all members by money in their pocket
	elseif($_GET['do'] == "viewall")
	{
		// Add to the link tree
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=shop;do=viewall',
			'name' => $txt['shop_view_all'],
		);

		// Start with an empty list
		$context['shop_members'] = array();
		// Get actual list of people with money != 0
		$result = db_query("
			SELECT realName, money
			FROM {$db_prefix}members
			WHERE money <> 0
			ORDER BY money DESC
			", __FILE__, __LINE__);
		// Loop through results
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			// Add user to the list
			$context['shop_members'][] = array(
				'realName' => $row['realName'],
				'money' => $row['money']
			);
		mysql_free_result($result);
		
		// Set the page title
		$context['page_title'] = $txt['shop'] . ' - ' . $txt['shop_view_all'];
		// Use the viewAllMembers template
		$context['sub_template'] = 'viewAllMembers';

	// Similar to above, except for money in the bank
	} elseif($_GET['do'] == "viewallBank") {

		// Add to the link tree
		$context['linktree'][] = array(
			'url' => "$scripturl?action=shop;do=viewallBank",
			'name' => $txt['shop_view_all2'],
		);

		// Start with an empty list
		$context['shop_members'] = array();
		// Get actual list of people (moneyBank != 0)
		$result = db_query("
			SELECT realName, moneyBank
			FROM {$db_prefix}members
			WHERE moneyBank <> 0
			ORDER BY moneyBank DESC
			", __FILE__, __LINE__);
		// Loop through results
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			// Add them to the list
			$context['shop_members'][] = array(
				'realName' => $row['realName'],
				'money' => $row['moneyBank']
			);
		mysql_free_result($result);
		
		// Set the page title
		$context['page_title'] = $txt['shop'] . ' - ' . $txt['shop_view_all2'];
		// Use the viewAllMembers template
		$context['sub_template'] = 'viewAllMembers';
	}
	// 'Who Owns This Item' option
	elseif($_GET['do'] == 'owners')
	{
		// Make sure item ID is a number
		$_GET['id'] = (int) $_GET['id'];
		
		// Get item name
		$result = db_query("
			SELECT name
			FROM {$db_prefix}shop_items
			WHERE id = {$_GET['id']}
			LIMIT 1", __FILE__, __LINE__);
							 
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);

		// Add to the linktree
		$context['linktree'][] = array(
			'url' => $scripturl . '?action=shop;do=owners;id=' . $_GET['id'],
			'name' => $txt['shop_owners'] . ' - ' . $row['name'],
		);
							 
		// Now, get the actual usernames
		// If user has more than one of this item, only count them once
		$result = db_query("
			SELECT DISTINCT m.realName
			FROM {$db_prefix}shop_inventory AS inv, {$db_prefix}shop_items AS it, {$db_prefix}members AS m
			WHERE inv.itemid = {$_GET['id']} AND m.ID_MEMBER = inv.ownerid", __FILE__, __LINE__);
							 
		// Add the header to the message (xx users own the item xx)
		// TODO: Fix the ugly code!
		$context['shop_buy_message'] = '
						<b>' . sprintf($txt['shop_users_own_item'], (int) mysql_num_rows($result), $row['name']) . '</b>
						<ul>';
									 
		// Loop through results
		while ($rowUser = mysql_fetch_assoc($result))
			// Add user to the list
			$context['shop_buy_message'] .= '
							<li>' . $rowUser['realName'] . '</li>';
		mysql_free_result($result);
		
		// Close the list
		$context['shop_buy_message'] .= '
						</ul>';
		// Set the page title
		$context['page_title'] = $txt['shop'] . ' - ' . $txt['shop_owners'] . ' - ' . $row['name'];
		// Use the message template
		$context['sub_template'] = 'message';
	}
	// Otherwise... What do you want us to do?
	else
	{
		fatal_error('ERROR: The \'do\' action you passed was not valid!');
	}
}
?>
