<?php
/* Software Version:  SMF 0.1        */

if (!defined('SMF'))
	die('Error');
	
function extras()
{
	global $settings, $user_info, $language, $context, $txt;
	//¿ets admin?
	isAllowedTo('admin_forum');
	//marco Gestionar bloques
	adminIndex('extras');
	//titol seccio
	$context['page_title'] = 'Configuraci&oacute;n Extras';
	//carrego plantilla estandar
	loadTemplate('Extras');
	
	// ;sa=gestionar = template_main
	$context['all_pages'] = array(
		'gestionar' => 'main',
	);
	//on vols anar? si no hi ha res ves al gestionar
	if (!isset($_GET['sa']) || !isset($context['all_pages'][$_GET['sa']]))
		$_GET['sa'] = 'gestionar';

	$context['current_page'] = $_GET['sa'];
	$context['sub_template'] = '' . $context['all_pages'][$context['current_page']];
}
?>