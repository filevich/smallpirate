<?php
if (defined('SMF'))
	return true;

define('SMF', 'SSI');

global $time_start, $maintenance, $msubject, $mmessage, $mbname, $language;
global $boardurl, $boarddir, $sourcedir, $webmaster_email, $cookiename;
global $db_server, $db_name, $db_user, $db_prefix, $db_persist, $db_error_send, $db_last_error;
global $db_connection, $modSettings, $context, $sc, $user_info, $topic, $board, $txt;

$ssi_magic_quotes_runtime = get_magic_quotes_runtime();
@set_magic_quotes_runtime(0);
$time_start = microtime();

require_once(dirname(__FILE__) . '/Settings.php');

$ssi_error_reporting = error_reporting(E_ALL);

if ($maintenance == 2 && (!isset($ssi_maintenance_off) || $ssi_maintenance_off !== true))
	die($mmessage);

if (substr($sourcedir, 0, 1) == '.' && substr($sourcedir, 1, 1) != '.')
	$sourcedir = dirname(__FILE__) . substr($sourcedir, 1);

require_once($sourcedir . '/QueryString.php');
require_once($sourcedir . '/Subs.php');
require_once($sourcedir . '/Errors.php');
require_once($sourcedir . '/Load.php');
require_once($sourcedir . '/Security.php');

if (@version_compare(PHP_VERSION, '4.2.3') != 1)
	require_once($sourcedir . '/Subs-Compat.php');

if (empty($db_persist))
	$db_connection = @mysql_connect($db_server, $db_user, $db_passwd);
else
	$db_connection = @mysql_pconnect($db_server, $db_user, $db_passwd);
if ($db_connection === false)
	return false;

if (strpos($db_prefix, '.') === false)
	$db_prefix = is_numeric(substr($db_prefix, 0, 1)) ? $db_name . '.' . $db_prefix : '`' . $db_name . '`.' . $db_prefix;
else
	@mysql_select_db($db_name, $db_connection);

reloadSettings();
cleanRequest();
if (isset($_REQUEST['GLOBALS']) || isset($_COOKIE['GLOBALS']))
	die('$url');
elseif (isset($_REQUEST['ssi_theme']) && (int) $_REQUEST['ssi_theme'] == (int) $ssi_theme)
	die('$url');
elseif (isset($_COOKIE['ssi_theme']) && (int) $_COOKIE['ssi_theme'] == (int) $ssi_theme)
	die('$url');
elseif (isset($_REQUEST['ssi_layers']))
{
	if ((get_magic_quotes_gpc() ? addslashes($_REQUEST['ssi_layers']) : $_REQUEST['ssi_layers']) == htmlspecialchars($ssi_layers))
		die('$url');
}

if (isset($_REQUEST['context']))
	die('$url');
define('WIRELESS', false);
if (isset($ssi_gzip) && $ssi_gzip === true && @ini_get('zlib.output_compression') != '1' && @ini_get('output_handler') != 'ob_gzhandler' && @version_compare(PHP_VERSION, '4.2.0') != -1)
	ob_start('ob_gzhandler');
else
	$modSettings['enableCompressedOutput'] = '0';
ob_start('ob_sessrewrite');
if (!headers_sent())
	loadSession();
else
{
	if (isset($_COOKIE[session_name()]) || isset($_REQUEST[session_name()]))
	{
		$temp = error_reporting(error_reporting() & !E_WARNING);
		loadSession();
		error_reporting($temp);
	}

	if (!isset($_SESSION['rand_code']))
		$_SESSION['rand_code'] = '';
	$sc = &$_SESSION['rand_code'];
}
unset($board);
unset($topic);
$user_info['is_mod'] = false;
$context['user']['is_mod'] = false;
$context['linktree'] = array();
loadUserSettings();
loadTheme(isset($ssi_theme) ? (int) $ssi_theme : 0);
if (isset($_REQUEST['ssi_ban']) || (isset($ssi_ban) && $ssi_ban === true))
	is_not_banned();
loadPermissions();
if (isset($ssi_layers))
{
	$context['template_layers'] = $ssi_layers;
	template_header();
}
else
	setupThemeContext();
if (isset($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['is_cli']) && session_id() == '')
	trigger_error($txt['ssi_session_broken'], E_USER_NOTICE);
if (!isset($_SESSION['USER_AGENT']) && (!isset($_GET['ssi_function']) || $_GET['ssi_function'] !== 'pollVote'))
	$_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
if (isset($_GET['ssi_function']) && function_exists('ssi_' . $_GET['ssi_function']))
{
	call_user_func('ssi_' . $_GET['ssi_function']);
	exit;
}
if (isset($_GET['ssi_function']))
	exit;
elseif (basename($_SERVER['PHP_SELF']) == 'SSI.php')
	die(sprintf($txt['ssi_not_direct'], $user_info['is_admin'] ? '\'' . addslashes(__FILE__) . '\'' : '\'SSI.php\''));
$anonimos = $context['user']['is_guest'];
error_reporting($ssi_error_reporting);
@set_magic_quotes_runtime($ssi_magic_quotes_runtime);

return true;

function ssi_categorias($output_method = 'echo')
{
	global $db_prefix, $txt, $scripturl, $modSettings;
$request = db_query("
		SELECT b.ID_BOARD, b.name, b.childLevel, c.name AS catName
		FROM {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}categories AS c ON (c.ID_CAT = b.ID_CAT)
	", __FILE__, __LINE__);
	$context['boards'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['boards'][] = array(
			'id' => $row['ID_BOARD'],
			'name' => $row['name'],
			'category' => $row['catName'],
			'child_level' => $row['childLevel'],
		);
	mysql_free_result($request);
	echo'<script language="javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location=\'"+selObj.options[selObj.selectedIndex].value+"\'");
  if (restore) selObj.selectedIndex=0;
}</script>
	<select onchange="MM_jumpMenu(\'parent\',this,0)"> <option value="" selected="selected">Ver categor&iacute;as</option>';
	foreach ($context['boards'] as $board){
	echo '<option value="'. $scripturl .'?id=', $board['id'], '"', $board['selected'] ? ' selected="selected"' : '', '>', $board['name'], '</option>';}
	echo'</select>';

}

function ssi_enlaces()
{
global $settings, $db_prefix, $scripturl, $modSettings;
// Sacamos lo que hay actualmente y lo mostramos
$obtenir1=mysql_query("
SELECT *
FROM smf_settings
WHERE variable='enlaces'");
while ($row1 = mysql_fetch_assoc($obtenir1)){
$enlaces=$row1['value'];
echo $enlaces;
}
     
	echo'
<br><br><center><a class="size10" href="'; echo $url; echo '/?action=enlazanos" target="_blank">Enl&aacute;zanos en tu Web</a></center>';
			

}
function consulta($texto){
$rs = mysql_query("SELECT value
FROM (smf_settings)
WHERE variable ='".$texto."'");
while ($row = mysql_fetch_array($rs)){
echo $row['value'];
}
}
function ssi_destacado()
{
global $settings, $db_prefix, $scripturl, $modSettings;
// Sacamos lo que hay actualmente y lo mostramos esto by fatrixse
$lol=array(1,2,3,4,5);
$num = rand(0,sizeof($lol)-1);
$destacados = array(consulta('anuncio'. $num .''));

}
?>