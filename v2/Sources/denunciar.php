<?php
/* Software Version:  SMF 0.1        */

if (!defined('SMF'))
	die('Error');

function ShowHelp()
{
	global $settings, $user_info, $language, $context, $txt;

	loadTemplate('denunciar');
	loadLanguage('Manual');

	$context['all_pages'] = array(
		'index' => 'intro',
		'enviada' => 'login',
	);

	if (!isset($_GET['page']) || !isset($context['all_pages'][$_GET['page']]))
		$_GET['page'] = 'index';

	$context['current_page'] = $_GET['page'];
	$context['sub_template'] = 'manual_' . $context['all_pages'][$context['current_page']];

	$context['template_layers'][] = 'manual';
	  $txt['Titulo'] = "Denunciar Post"; 
	$context['page_title'] = $txt['Titulo'];

	$context['html_headers'] .= '
		<link rel="stylesheet" type="text/css" href="' . (file_exists($settings['theme_dir'] . '/style.css') ? $settings['theme_url'] : $settings['default_theme_url']) . '/style.css" />';
}

function ShowAdminHelp()
{
	global $txt, $helptxt, $context, $scripturl;

	if (!isset($_GET['help']))
		fatal_lang_error('no_access');

	loadLanguage('denunciar');

	if (isset($_GET['help']) && substr($_GET['help'], 0, 14) == 'permissionhelp')
		loadLanguage('ManagePermissions');

	loadTemplate('denunciar');

    $txt['Titulo'] = "Denunciar Post"; 
	$context['page_title'] = $txt['Titulo'];

	$context['template_layers'] = array();
	$context['sub_template'] = 'popup';

	if (isset($helptxt[$_GET['help']]))
		$context['help_text'] = &$helptxt[$_GET['help']];
	elseif (isset($txt[$_GET['help']]))
		$context['help_text'] = &$txt[$_GET['help']];
	else
		$context['help_text'] = $_GET['help'];

	if (preg_match('~%([0-9]+\$)?s\?~', $context['help_text'], $match))
	{
		$context['help_text'] = sprintf($context['help_text'], $scripturl, $context['session_id']);
	}
}

?>