<?php
/* Software Version:  SMF 0.1        */


if (!defined('SMF'))
	die('Error');

function Agregar()
{
	global $settings, $user_info, $language, $context, $txt;
	loadTemplate('Agregar');
	$context['all_pages'] = array(
		'index' => 'intro',
	);

	if (!isset($_GET['page']) || !isset($context['all_pages'][$_GET['page']]))
		$_GET['page'] = 'index';
	$context['current_page'] = $_GET['page'];
	  $txt['Titulo'] = "T&eacute;rminos y Condiciones"; 
	$context['page_title'] = $txt['Titulo'];
	$request = mysql_query("
		SELECT b.ID_BOARD, b.name, b.childLevel
		FROM smf_boards AS b");
	$context['boards'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['boards'][] = array(
			'id' => $row['ID_BOARD'],
			'name' => $row['name'],
			'child_level' => $row['childLevel'],
		);
	mysql_free_result($request);
	
	$request = mysql_query("
SELECT *
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

}


function Agregar2()
{
	global $settings, $user_info, $language, $context, $txt;

	loadTemplate('Agregar2');
	$context['all_pages'] = array(
		'index' => 'intro',
	);

	if (!isset($_GET['page']) || !isset($context['all_pages'][$_GET['page']]))
		$_GET['page'] = 'Agregar2';
	$context['current_page'] = $_GET['page'];
	$txt['Titulo'] = "T&eacute;rminos y Condiciones"; 
	$context['page_title'] = $txt['Titulo'];
}

?>