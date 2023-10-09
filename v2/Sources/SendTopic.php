<?php



if (!defined('SMF'))
	die('Error');
	
function SendTopic()
{
	global $topic, $txt, $db_prefix, $context, $scripturl, $sourcedir;

	isAllowedTo('send_topic');

	if (empty($topic))
		fatal_lang_error(472, false);

	$request = db_query("
		SELECT m.subject
		FROM ({$db_prefix}messages AS m, {$db_prefix}topics AS t)
		WHERE t.ID_TOPIC = $topic
			AND t.ID_FIRST_MSG = m.ID_MSG
		LIMIT 1", __FILE__, __LINE__);
	if (mysql_num_rows($request) == 0)
	fatal_lang_error(472, false);
	$row = mysql_fetch_assoc($request);
	mysql_free_result($request);
	censorText($row['subject']);
	if (empty($_POST['send']))
	{
		loadTemplate('SendTopic');
		$context['page_title'] = $row['subject'];
		$context['start'] = $_REQUEST['start'];

		return;
	}

	checkSession();
	spamProtection('spam');

	require_once($sourcedir . '/Subs-Post.php');

	$_POST['y_name'] = trim($_POST['y_name']);
	$_POST['r_name'] = trim($_POST['r_name']);

	if ($_POST['y_name'] == '_' || !isset($_POST['y_name']) || $_POST['y_name'] == '')
		fatal_lang_error(75, false);
	if (!isset($_POST['y_email']) || $_POST['y_email'] == '')
		fatal_lang_error(76, false);
	if (preg_match('~^[0-9A-Za-z=_+\-/][0-9A-Za-z=_\'+\-/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$~', stripslashes($_POST['y_email'])) == 0)
		fatal_lang_error(243, false);

if ($_POST['r_name'] == '_' || !isset($_POST['r_name']) || $_POST['r_name'] == '')
		fatal_lang_error(75, false);
	if (!isset($_POST['r_email']) || $_POST['r_email'] == '')
	fatal_lang_error(76, false);
	if (preg_match('~^[0-9A-Za-z=_+\-/][0-9A-Za-z=_\'+\-/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$~', stripslashes($_POST['r_email'])) == 0)
		fatal_lang_error(243, false);

	$row['subject'] = un_htmlspecialchars($row['subject']);

	sendmail($_POST['r_email'], ''.$row['subject'].'',
		sprintf('Este mensaje ha sido enviado desde '. $scripturl .':') . "\n\n" .
		sprintf($_POST['comment']) . "\n\n" .
		'Enlace: '. $scripturl .'?topic=' . $topic . '');

	redirectexit(''. $scripturl .'?topic=' . $topic . '');
}
function ReportToModerator(){}
function ReportToModerator2(){}

?>