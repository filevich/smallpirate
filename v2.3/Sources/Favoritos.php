<?php
/* Software Version:  SMF 0.1        */

if (!defined('SMF'))
	die('Error');
	
function Favoritos()
{
	global $txt, $context, $scripturl, $db_prefix, $user_info, $ID_MEMBER, $return;

        if(loadLanguage('Favoritos') == false)
            loadLanguage('Favoritos','spanish');

	loadTemplate('Favoritos');
	
	if (!$context['user']['is_logged'])
		{$text = '<center><font color="green">Solo usuarios registrados pueden agregar a favoritos</font></center>';
                        if(!isset($_REQUEST['ajax']))
                        { fatal_error($text, false);}else{die($text);}}	
						
	$context['page_title'] = 'Mis post favoritos';

	$context['sub_action'] = isset($_REQUEST['sa']) ? $_REQUEST['sa'] : '';
	
	switch ($context['sub_action'])
	{
		case 'add':
		$return = !empty($_REQUEST['topic']) ? addFavoritos(intval($_REQUEST['topic'])) : '';
		break;
		
		case 'delete':
		$return = !empty($_POST['remove_favoritos']) ? deleteFavoritos($_POST['remove_favoritos']) : '';
		break;
	}

	$request = db_query("
		SELECT ms.posterTime, t.puntos, b.ID_BOARD, b.name, mem.realName, ms.ID_BOARD, t.ID_TOPIC, mem.ID_MEMBER, ms.ID_MEMBER, ms.ID_TOPIC, ms.subject, ms.ID_MEMBER	
		FROM ({$db_prefix}bookmarks AS bm, {$db_prefix}boards AS b, {$db_prefix}topics AS t, {$db_prefix}messages AS ms, {$db_prefix}members AS mem)
	WHERE     bm.ID_MEMBER = $ID_MEMBER
		  AND t.ID_TOPIC = bm.ID_TOPIC
		  AND t.ID_TOPIC = ms.ID_TOPIC
		  AND ms.ID_BOARD = b.ID_BOARD
		  AND mem.ID_MEMBER = ms.ID_MEMBER
		  AND $user_info[query_see_board]
		ORDER BY bm.id DESC", __FILE__, __LINE__);

	$context['favoritos'] = array();
	while ($row = mysql_fetch_assoc($request))
	{
		censorText($row['subject']);

		$context['favoritos'][] = array(
			'id' => $row['ID_TOPIC'],
    		'puntos' => $row['puntos'],
			'poster' => array(
				'id' => $row['ID_MEMBER'],
				'name' => $row['realName'],
				'href' => empty($row['ID_MEMBER']) ? '' : '' . $scripturl . '?action=profile;u=' .$row['ID_MEMBER'],
				'link' => empty($row['ID_MEMBER']) ? $row['realName'] : '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>'
			),
			'subject' => $row['subject'],
			'href' => '' . $scripturl . '?action=profile;u=' . $row['ID_TOPIC'] . '',
			'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_TOPIC'] . '">' . $row['subject'] . '</a>',
			'time' => timeformat($row['posterTime']),
		    'timestamp' => forum_time(true, $row['posterTime']),
			'board' => array(
				'id' => $row['ID_BOARD'],
				'name' => $row['name'],
				'href' => '' . $scripturl . '?id=' . $row['ID_BOARD'] . '',
				'link' => '<a href="' . $scripturl . '?id=' . $row['ID_BOARD'] . '">' . $row['name'] . '</a>'
			)
		);
	}
	mysql_free_result($request);
}

function addFavoritos($id_topic, $id_user = null)
{
	global $txt, $context, $db_prefix;

	if ($id_user == null)
		$id_user = $context['user']['id'];

	$result = db_query("
				SELECT *
				FROM {$db_prefix}bookmarks
				WHERE
					ID_MEMBER = $id_user AND
					ID_TOPIC = $id_topic
				LIMIT 1", __FILE__, __LINE__);
	
	$alreadyAdded = mysql_num_rows($result) != 0 ? true : false;
	mysql_free_result($result);

	if ($alreadyAdded)
		{$text = '<center><font color="red">'. $txt['post_already_added_to_favorites'].'</font></center>';
                    if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}
					
					else
	{
		$result = db_query("
				INSERT INTO {$db_prefix}bookmarks
				(ID_MEMBER, ID_TOPIC)
				VALUES ($id_user, $id_topic)", __FILE__, __LINE__);
		if ($result)
                {
                      $text = '<center><font color="green">'. $txt['added_to_favorites'].'</font></center>';
                        if(!isset($_REQUEST['ajax']))
                        { fatal_error($text, false);}else{die($text);}}
	}
}

function deleteFavoritos($topic_ids, $id_user = null)
{
	global $txt, $context, $db_prefix;

	if ($id_user == null)
		$id_user = $context['user']['id'];
	
	foreach ($topic_ids as $index => $id)
		$topic_ids[$index] = (int) $id;

	$topics = implode(',', $topic_ids);
	
	$result = db_query("
				DELETE FROM {$db_prefix}bookmarks
				WHERE
					ID_TOPIC IN($topics) AND
					ID_MEMBER = $id_user", __FILE__, __LINE__);
	
	$deleted = mysql_affected_rows();
	
	if ($result)
		return sprintf($txt['bookmark_delete_success'], $deleted);
	else
		return sprintf($txt['bookmark_delete_failure'], $deleted);
}
?>