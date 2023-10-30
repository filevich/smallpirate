<?php

$forum_version = 'Spirate 2.3';

define('SMF', 1);
@set_magic_quotes_runtime(0);
error_reporting(E_ALL);
$time_start = microtime();
// Make sure some things simply do not exist.
foreach (array('db_character_set') as $variable)
	if (isset($GLOBALS[$variable]))
		unset($GLOBALS[$variable]);

// Load the settings...
require_once(dirname(__FILE__) . '/Settings.php');
require_once($sourcedir . '/QueryString.php');
require_once($sourcedir . '/Subs.php');
require_once($sourcedir . '/Errors.php');
require_once($sourcedir . '/Load.php');
require_once($sourcedir . '/Security.php');
if (@version_compare(PHP_VERSION, '4.2.3') != 1)
	require_once($sourcedir . '/Subs-Compat.php');
if (!empty($maintenance) && $maintenance == 2)
	db_fatal_error();
if (empty($db_persist))
	$db_connection = @mysql_connect($db_server, $db_user, $db_passwd);
else
	$db_connection = @mysql_pconnect($db_server, $db_user, $db_passwd);

if (!$db_connection || !@mysql_select_db($db_name, $db_connection))
	db_fatal_error();
reloadSettings();

cleanRequest();

// Seed the random generator?
if (empty($modSettings['rand_seed']) || mt_rand(1, 250) == 69)
	smf_seed_generator();

// Determine if this is using WAP, WAP2, or imode.  Technically, we should check that wap comes before application/xhtml or text/html, but this doesn't work in practice as much as it should.
if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/vnd.wap.xhtml+xml') !== false)
	$_REQUEST['wap2'] = 1;
elseif (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/vnd.wap.wml') !== false)
{
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'DoCoMo/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'portalmmm/') !== false)
		$_REQUEST['imode'] = 1;
	else
		$_REQUEST['wap'] = 1;
}
if (!defined('WIRELESS'))
	define('WIRELESS', isset($_REQUEST['wap']) || isset($_REQUEST['wap2']) || isset($_REQUEST['imode']));
if (WIRELESS)
{
	define('WIRELESS_PROTOCOL', isset($_REQUEST['wap']) ? 'wap' : (isset($_REQUEST['wap2']) ? 'wap2' : (isset($_REQUEST['imode']) ? 'imode' : '')));
	$modSettings['enableCompressedOutput'] = '0';
	$modSettings['defaultMaxMessages'] = 5;
	$modSettings['defaultMaxTopics'] = 9;

	if (WIRELESS_PROTOCOL == 'wap')
		header('Content-Type: text/vnd.wap.wml');
}
if (!empty($modSettings['enableCompressedOutput']) && !headers_sent() && ob_get_length() == 0)
{
	if (@ini_get('zlib.output_compression') == '1' || @ini_get('output_handler') == 'ob_gzhandler' || @version_compare(PHP_VERSION, '4.2.0') == -1)
		$modSettings['enableCompressedOutput'] = '0';
	else
		ob_start('ob_gzhandler');
}
if (empty($modSettings['enableCompressedOutput']))
	ob_start();

set_error_handler('error_handler');
loadSession();
call_user_func(smf_main());
obExit(null, null, true);
function smf_main()
{
	global $modSettings, $settings, $user_info, $board, $topic, $maintenance, $sourcedir;
	if (isset($_GET['action']) && $_GET['action'] == 'keepalive')
		die;
	loadUserSettings();
	loadBoard();
	loadTheme();
	is_not_banned();
	loadPermissions();
	// Referrals Mod - Check For Referrals
	if (isset($_GET['referredby']) || isset($_COOKIE['smf_referrals']))
		loadReferral();
	if (empty($_REQUEST['action']) || !in_array($_REQUEST['action'], array('dlattach', 'jsoption', '.xml')))
	{
		writeLog();
		if (!empty($modSettings['hitStats']))
			trackStats(array('hits' => '+'));
	}
	if (!empty($maintenance) && !allowedTo('admin_forum'))
	{
		if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'login2' || $_REQUEST['action'] == 'logout'))
		{
			require_once($sourcedir . '/LogInOut.php');
			return $_REQUEST['action'] == 'login2' ? 'Login2' : 'Logout';
		}
		else
		{
			require_once($sourcedir . '/Subs-Auth.php');
			return 'InMaintenance';
		}
	}
	elseif (empty($modSettings['allow_guestAccess']) && $user_info['is_guest'] && (!isset($_REQUEST['action']) || !in_array($_REQUEST['action'], array('coppa', 'login', 'login2', 'register', 'register2', 'reminder', 'activate', 'smstats', 'help', 'verificationcode'))))
	{
		require_once($sourcedir . '/Subs-Auth.php');
		return 'KickGuest';
	}
	elseif (empty($_REQUEST['action']))
	{
		if (empty($board) && empty($topic))
		{
			require_once($sourcedir . '/Recent.php');
			return 'RecentPosts';
		}
		elseif (empty($topic))
		{
			require_once($sourcedir . '/MessageIndex.php');
			return 'MessageIndex';
		}
		else
		{
			require_once($sourcedir . '/Display.php');
			return 'Display';
		}
	}
	$actionArray = array(
		'buddies' => array('Buddies.php', 'BuddiesMain'),
		'activate' => array('Register.php', 'Activate'),
		'admin' => array('Admin.php', 'Admin'),
		'tags' => array('Tags.php', 'TagsMain'),
		'ban' => array('ManageBans.php', 'Ban'),
		'boardrecount' => array('Admin.php', 'AdminBoardRecount'),
                'favoritos' => array('Favoritos.php', 'Favoritos'),
		'cleanperms' => array('Admin.php', 'CleanupPermissions'),
		'convertentities' => array('Admin.php', 'ConvertEntities'),
		'convertutf8' => array('Admin.php', 'ConvertUtf8'),
		'coppa' => array('Register.php', 'CoppaForm'),
		'contactenos' => array('Contactenos.php', 'ShowHelp'),
		'imagenes' => array('Gallery.php', 'GalleryMain'),
		'deletemsg' => array('RemoveTopic.php', 'DeleteMessage'),
		'detailedversion' => array('Admin.php', 'VersionDetail'),
		'display' => array('Display.php', 'Display'),
		'dlattach' => array('Display.php', 'Download'),
		'dumpdb' => array('DumpDatabase.php', 'DumpDatabase2'),
		'extras' => array('Extras.php', 'Extras'),
		'featuresettings' => array('ModSettings.php', 'ModifyFeatureSettings'),
		'featuresettings2' => array('ModSettings.php', 'ModifyFeatureSettings2'),
		'findmember' => array('Subs-Auth.php', 'JSMembers'),
		'help' => array('Help.php', 'ShowHelp'),	
		'helpadmin' => array('Help.php', 'ShowAdminHelp'),		
		'jsoption' => array('Themes.php', 'SetJavaScript'),
		'jsmodify' => array('Post.php', 'JavaScriptModify'),	
		'terminos-y-condiciones' => array('terminos-y-condiciones.php', 'ShowHelp'),
		'widget' => array('widget.php', 'ShowHelp'),
		'recomendar' => array('Recomendar.php', 'ShowHelp'),
		'cine' => array('Cine.php', 'cine'),
		'denunciar' => array('Denunciar.php', 'ShowHelp'),
		'enlazanos' => array('Enlazanos.php', 'ShowHelp'),
		'gsearch' => array('gsearch.php', 'ShowHelp'),
		'protocolo' => array('Protocolo.php', 'ShowHelp'),
		'im' => array('PersonalMessage.php', 'MessageMain'),
		'jsoption' => array('Themes.php', 'SetJavaScript'),
		'jsmodify' => array('Post.php', 'JavaScriptModify'),
		'lock' => array('LockTopic.php', 'LockTopic'),
		'login' => array('LogInOut.php', 'Login'),
		'login2' => array('LogInOut.php', 'Login2'),
		'logout' => array('LogInOut.php', 'Logout'),
		'maintain' => array('Admin.php', 'Maintenance'),
		'manageattachments' => array('ManageAttachments.php', 'ManageAttachments'),
		'manageboards' => array('ManageBoards.php', 'ManageBoards'),
		'managecalendar' => array('ManageCalendar.php', 'ManageCalendar'),
		'managesearch' => array('ManageSearch.php', 'ManageSearch'),
		'markasread' => array('Subs-Boards.php', 'MarkRead'),
		'membergroups' => array('ManageMembergroups.php', 'ModifyMembergroups'),
		'mergetopics' => array('SplitTopics.php', 'MergeTopics'),
		'mlist' => array('Memberlist.php', 'Memberlist'),
		'modifycat' => array('ManageBoards.php', 'ModifyCat'),
		'modifykarma' => array('Karma.php', 'ModifyKarma'),
		'hist-mod' => array('Modlog.php', 'ViewModlog'),
		'movetopic' => array('MoveTopic.php', 'MoveTopic'),
		'movetopic2' => array('MoveTopic.php', 'MoveTopic2'),
		'movetopic3' => array('MoveTopic.php', 'MoveTopic3'),
		'news' => array('ManageNews.php', 'ManageNews'),
		'monitor' => array('Monitor.php', 'Monitor'),
		'notify' => array('Notify.php', 'Notify'),
		'notifyboard' => array('Notify.php', 'BoardNotify'),
		'optimizetables' => array('Admin.php', 'OptimizeTables'),
		'packageget' => array('PackageGet.php', 'PackageGet'),
		'packages' => array('Packages.php', 'Packages'),
		'permissions' => array('ManagePermissions.php', 'ModifyPermissions'),
		'pgdownload' => array('PackageGet.php', 'PackageGet'),
		'pm' => array('PersonalMessage.php', 'MessageMain'),
		'post' => array('Post.php', 'Post'),
		'agregar' => array('Agregar.php', 'Agregar'),
		'agregar2' => array('Agregar.php', 'Agregar2'),
		'post2' => array('Post.php', 'Post2'),
		'postsettings' => array('ManagePosts.php', 'ManagePostSettings'),
		'printpage' => array('Printpage.php', 'PrintTopic'),
		'profile' => array('Profile.php', 'ModifyProfile'),
		'profile2' => array('Profile.php', 'ModifyProfile2'),
		'quotefast' => array('Post.php', 'QuoteFast'),
		'quickmod' => array('Subs-Boards.php', 'QuickModeration'),
		'quickmod2' => array('Subs-Boards.php', 'QuickModeration2'),
		'index' => array('Recent.php', 'RecentPosts'),
		'regcenter' => array('ManageRegistration.php', 'RegCenter'),
		'registrarse' => array('Register.php', 'Register'),
		'register2' => array('Register.php', 'Register2'),
		'reminder' => array('Reminder.php', 'RemindMe'),
		'removetopic2' => array('RemoveTopic.php', 'RemoveTopic2'),
		'removeoldtopics2' => array('RemoveTopic.php', 'RemoveOldTopics2'),
		'repairboards' => array('RepairBoards.php', 'RepairBoards'),
		'requestmembers' => array('Subs-Auth.php', 'RequestMembers'),
		'search' => array('Search.php', 'PlushSearch1'),
		'search2' => array('Search.php', 'PlushSearch2'),
		'enviar-a-amigo' => array('SendTopic.php', 'SendTopic'),
		'serversettings' => array('ManageServer.php', 'ModifySettings'),
		'serversettings2' => array('ManageServer.php', 'ModifySettings2'),
		'sitemap' => array('Sitemap.php', 'ShowSiteMap'),
		'smileys' => array('ManageSmileys.php', 'ManageSmileys'),
		'splittopics' => array('SplitTopics.php', 'SplitTopics'),
		'TOPs' => array('Stats.php', 'DisplayStats'),
		'sticky' => array('LockTopic.php', 'Sticky'),		
		'rz' => array('Acciones.php', 'Acciones'),
		'theme' => array('Themes.php', 'ThemesMain'),
		'trackip' => array('Profile.php', 'trackIP'),
		'viewErrorLog' => array('ManageErrors.php', 'ViewErrorLog'),
		'viewmembers' => array('ManageMembers.php', 'ViewMembers'),
		'viewprofile' => array('Profile.php', 'ModifyProfile'),
		'verificationcode' => array('Register.php', 'VerificationCode'),
		'who' => array('Who.php', 'Who'),
		'.xml' => array('News.php', 'ShowXmlFeed'),
		'enviar-puntos' => array('shop/Shop.php', 'Shop'),
		'shop_general' => array('shop/ShopAdmin.php', 'ShopGeneral'),
		'shop_inventory' => array('shop/ShopAdmin.php', 'ShopInventory'),
		'shop_items_add' => array('shop/ShopAdmin.php', 'ShopItemsAdd'),
		'shop_items_edit' => array('shop/ShopAdmin.php', 'ShopItemsEdit'),
		'shop_restock' => array('shop/ShopAdmin.php', 'ShopRestock'),
		'shop_usergroup' => array('shop/ShopAdmin.php', 'ShopUserGroup'),	
		'shop_cat' => array('shop/ShopAdmin.php', 'ShopCategories'),

	);
	if (!isset($_REQUEST['action']) || !isset($actionArray[$_REQUEST['action']]))
	{
		if (!empty($settings['catch_action']))
		{
			require_once($sourcedir . '/Themes.php');
			return 'WrapAction';
		}
		require_once($sourcedir . '/Recent.php');
		return 'RecentPosts';
	}

	require_once($sourcedir . '/' . $actionArray[$_REQUEST['action']][0]);
	return $actionArray[$_REQUEST['action']][1];
}

?>