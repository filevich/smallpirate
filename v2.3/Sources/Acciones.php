<?php
/* Software Version:  SMF 0.1        */


if (!defined('SMF'))
	die('Error');

function acciones()
{
	global $settings, $user_info, $language, $context, $txt, $db_prefix;

$request = mysql_query("
                        SELECT m.ID_MEMBER, m.ID_POST_GROUP
                        FROM {$db_prefix}members AS m
                        WHERE ".$context['user']['id']." = m.ID_MEMBER");
    
while ($grup = mysql_fetch_assoc($request))
{	
$context['idgrup'] = $grup['ID_POST_GROUP'];
$context['leecher'] = $grup['ID_POST_GROUP'] == '4';
$context['novato'] = $grup['ID_POST_GROUP'] == '5';
$context['buenus'] = $grup['ID_POST_GROUP'] == '6';
}	
mysql_free_result($request);

        if(loadlanguage('Acciones') == false)
            loadLanguage('Acciones','spanish');
            
	loadTemplate('Acciones');
	
	$context['all_pages'] = array(
		'index' => 'intro',
		'enviarp' => 'enviarp',
		'enviari' => 'enviari',
		'editari' => 'editari',
		'editarp' => 'editarp',
                
		'eliminarp' => 'eliminarp',
		'post-agregado' => 'postagregado',
		'post-editado' => 'posteditado',
		'comentar' => 'comentar',
		'eliminarc' => 'eliminarc',
		'vr2965' => 'vr2965',
		'denuncias' => 'denuncias',
		'endenuncias' => 'endenuncias',
		'eldenuncias' => 'eldenuncias',
		'elfrase' => 'elfrase',
		'enfrase' => 'enfrase',
		'edfrase' => 'edfrase',
		'apfrase' => 'apfrase',
		'4674868' => '4674868',
		
	);
	if (!isset($_GET['m']) || !isset($context['all_pages'][$_GET['m']]))
		$_GET['m'] = 'index';

	$context['current_page'] = $_GET['m'];
	$context['sub_template'] = '' . $context['all_pages'][$context['current_page']];

	$context['page_title'] = $txt[18];
}

?>