<?php


if (!defined('SMF'))
	die('Error');


function RecentPosts()
{
	
	global $txt, $scripturl, $db_prefix, $user_info, $context, $ID_MEMBER, $modSettings, $sourcedir, $board;
	global $settings, $limit_posts, $mbname;
        global $PagAnt, $PagAct, $PagSig, $PagUlt, $id;

        if(loadLanguage('Recent') == false)
            loadLanguage('Recent','spanish');

//Listado de posts
    //Hay seleccionada alguna categoria?
    $id=(int) $_GET['id'];
    if($id == '')        $cat_condition = '';
    else                 $cat_condition = 'AND m.ID_BOARD = ' . $id;

    //Determinar las paginas
    if($id == ''){
        $request= db_query("SELECT count(*) as cant FROM {$db_prefix}messages");
        $NroRegistros= mysql_fetch_assoc($request);
        mysql_free_result($request);    }
    else{
        $request= db_query("SELECT count(*) as cant FROM {$db_prefix}messages WHERE ID_BOARD = {$id}");
        $NroRegistros=mysql_fetch_assoc($request);
        mysql_free_result($request);    }
    
        //En que pagina estoy?
        if(isset($_GET['pag'])){
            $RegistrosAEmpezar=($_GET['pag']-1)*$limit_posts;
            $PagAct=$_GET['pag'];
        }
        else{
            $RegistrosAEmpezar=0;
            $PagAct=1;
        }
    $PagAnt=$PagAct-1;
    $PagSig=$PagAct+1;
    $PagUlt=$NroRegistros['cant']/$limit_posts;
    $Res=$NroRegistros['cant']%$limit_posts;
    // si hay residuo usamos funcion floor para que me devuelva la parte entera, SIN REDONDEAR, y le sumamos
    // una unidad para obtener la ultima pagina
     if($Res>0) $PagUlt=floor($PagUlt)+1;



    //Consulta de Sticky, solo si estamos en pagina 1 
    if ($PagAct==1)
    {
        $request = db_query("
            SELECT m.ID_MEMBER, m.ID_TOPIC, subject, name, t.ID_BOARD, posterName, puntos, m.hiddenOption, posterTime
            FROM {$db_prefix}messages as m, {$db_prefix}boards as c, {$db_prefix}topics as t
            WHERE c.ID_BOARD=m.ID_BOARD AND t.ID_TOPIC=m.ID_TOPIC AND t.isSticky = 1 {$cat_condition}
            ORDER BY m.ID_TOPIC DESC", __FILE__, __LINE__);

        while($posts = mysql_fetch_array($request))
        {
            //Comentarios
            $row = db_query("SELECT count(*) as comm FROM {$db_prefix}comentarios WHERE id_post={$posts['ID_TOPIC']}");
            $comment = mysql_fetch_assoc($row);
            mysql_free_result($row);
            //Favoritos
            $row = db_query("SELECT count(*) as fav FROM {$db_prefix}bookmarks WHERE ID_TOPIC={$posts['ID_TOPIC']}");
            $favourites = mysql_fetch_assoc($row);
            mysql_free_result($row);

            //Cargo la variable
            $context['sticky'][] = array(
                'ID_MEMBER' => $posts['ID_MEMBER'],
                'id' => $posts['ID_TOPIC'],
                'title' => $posts['subject'],
                'category' => $posts['name'],
                'id_category' => $posts['ID_BOARD'],
                'user' => $posts['posterName'],
                'points' => $posts['puntos'],
                'date' => $posts['posterTime'],
                'private' => $posts['hiddenOption'],
                'comments' => $comment['comm'],
                'favourites' => $favourites['fav'],
            );
        }
        mysql_free_result($request);
    }
    //Consulta de posts normales 
    $request=db_query("
        SELECT m.ID_MEMBER, m.ID_TOPIC, subject, name, t.ID_BOARD, posterName, puntos, m.hiddenOption, posterTime
        FROM {$db_prefix}messages as m, {$db_prefix}boards as c, {$db_prefix}topics as t
        WHERE c.ID_BOARD=m.ID_BOARD AND t.ID_TOPIC=m.ID_TOPIC AND t.isSticky = 0 {$cat_condition}
        ORDER BY m.ID_TOPIC DESC
        LIMIT $RegistrosAEmpezar, $limit_posts", __FILE__, __LINE__);

       while($posts = mysql_fetch_array($request))
    {
            //Comentarios
            $row = db_query("SELECT count(*) as comm FROM {$db_prefix}comentarios WHERE id_post={$posts['ID_TOPIC']}");
            $comment = mysql_fetch_assoc($row);
            mysql_free_result($row);
            //Favoritos
            $row = db_query("SELECT count(*) as fav FROM {$db_prefix}bookmarks WHERE ID_TOPIC={$posts['ID_TOPIC']}");
            $favourites = mysql_fetch_assoc($row);
            mysql_free_result($row);

            $context['normal_posts'][] = array(
            'ID_MEMBER' => $posts['ID_MEMBER'],
            'id' => $posts['ID_TOPIC'],
            'title' => $posts['subject'],
            'category' => $posts['name'],
            'id_category' => $posts['ID_BOARD'],
            'user' => $posts['posterName'],
            'points' => $posts['puntos'],
            'comments' => $posts['comm'],
            'date' => $posts['posterTime'],
            'private' => $posts['hiddenOption'],
            'comments' => $comment['comm'],
            'favourites' => $favourites['fav'],
        );
    }
    mysql_free_result($request);
//F ** Listado de posts

     $request = db_query("
		SELECT m.ID_MEMBER, i.ID_MEMBER, i.ID_PICTURE, i.filename, i.title, m.memberName, i.commenttotal, m.realName
                FROM ({$db_prefix}gallery_pic AS i, {$db_prefix}members AS m)
                WHERE i.ID_MEMBER = m.ID_MEMBER
                ORDER BY RAND()
                LIMIT 0 , 1", __FILE__, __LINE__);

	$context['imgaletatoria'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['imgaletatoria'][] = array(
			'id' => $row['ID_PICTURE'],
			'filename' => $row['filename'],
			'title' => $row['title'],
			'commenttotal' => $row['commenttotal'],
		);
	mysql_free_result($request);
	
		$query = "	SELECT ta.tag, t.ID_TAG, COUNT(*) as quantity
		FROM {$db_prefix}tags_log AS t
		LEFT JOIN {$db_prefix}tags AS ta ON (ta.ID_TAG = t.ID_TAG)
		WHERE t.ID_TAG != 0
		GROUP BY ta.ID_TAG
		ORDER BY quantity DESC
		LIMIT 30";
		
		$result = db_query($query, __FILE__, __LINE__);
		$tags = array();
		$tags2 = array();
		$max_num_posts = 1;
		while ($row = mysql_fetch_array($result)) 
		{
		    $tags[$row['tag']] = $row['quantity'];
		    $tags2[$row['tag']] = $row['ID_TAG'];
		    
		if ($max_num_posts < $tags[$row['tag']])
			$max_num_posts = $tags[$row['tag']];
	
		}
		if(count($tags2) > 0)
		{
    		$max_size = 120;
			$min_size = 100; 
			$max_qty = max(array_values($tags));
			$min_qty = min(array_values($tags));
			$spread = $max_qty - $min_qty;
			if (0 == $spread)
	        { 
			    $spread = 1;
			}
			$step = ($max_size - $min_size)/($spread);
			$context['poptags'] = '';
			$row_count = 0;
			foreach ($tags as $key => $value) 
			{
                $cantidad2 = $key;
    			$row_count++;
			    $size = $min_size + (($value - $min_qty) * $step);
			    $context['poptags'] .= '<a href="'. $scripturl.'/?action=tags;id=' . $tags2[$key] . '" style="font-size: '.$size.'%; padding: 0px 3px 0px 3px;"';
			    $context['poptags'] .= ' title="'.$value.' tags con la palabra '.$key.'"';
			   $context['poptags'] .= '>'.$cantidad2++.'</a>';
			   if ($row_count > 5)
			   {
               $context['poptags'] .= '<br><br>';
			   $row_count =0;
			   }
		   }
		}

		$dbresult = db_query("
		SELECT DISTINCT l.ID_TOPIC, t.numReplies,t.numViews,m.ID_MEMBER,m.posterName,m.subject,m.ID_TOPIC,m.posterTime, t.ID_BOARD 
		 FROM {$db_prefix}tags_log as l,{$db_prefix}boards AS b, {$db_prefix}topics as t, {$db_prefix}messages as m 
		 WHERE b.ID_BOARD = t.ID_BOARD AND l.ID_TOPIC = t.ID_TOPIC AND t.ID_FIRST_MSG = m.ID_MSG AND " . $user_info['query_see_board'] . " ORDER BY l.ID DESC LIMIT 10", __FILE__, __LINE__);

		
		$context['tags_topics'] = array();
		while ($row = mysql_fetch_assoc($dbresult))
		{
				$context['tags_topics'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'posterName' => $row['posterName'],
				'subject' => $row['subject'],
				'ID_TOPIC' => $row['ID_TOPIC'],
				'posterTime' => $row['posterTime'],
				'numViews' => $row['numViews'],
				'numReplies' => $row['numReplies'],
				
				);
		}
		mysql_free_result($dbresult);
	
$request = db_query("
		SELECT b.ID_BOARD, b.name, b.childLevel, c.name AS catName
		FROM {$db_prefix}boards AS b
			LEFT JOIN {$db_prefix}categories AS c ON (c.ID_CAT = b.ID_CAT)
		WHERE b.ID_BOARD != $board
			AND $user_info[query_see_board]" , __FILE__, __LINE__);
	$context['boards'] = array();
	while ($row = mysql_fetch_assoc($request))
		$context['boards'][] = array(
			'id' => $row['ID_BOARD'],
			'name' => $row['name'],
			'category' => $row['catName'],
			'child_level' => $row['childLevel'],
			'selected' => !empty($_SESSION['move_to_topic']) && $_SESSION['move_to_topic'] == $row['ID_BOARD']
		);
	mysql_free_result($request);

	$result = db_query("
		SELECT
			lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
			mg.onlineColor, mg.ID_GROUP, mg.groupName
		FROM {$db_prefix}log_online AS lo
			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
			LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))", __FILE__, __LINE__);

	$context['users_online'] = array();
	$context['list_users_online'] = array();
	$context['online_groups'] = array();
	$context['num_guests'] = 0;
	$context['num_buddies'] = 0;
	$context['num_users_hidden'] = 0;

	$context['show_buddies'] = !empty($user_info['buddies']);

	while ($row = mysql_fetch_assoc($result))
	{
		if (empty($row['realName']))
		{
			$context['num_guests']++;
			continue;
		}
		elseif (empty($row['showOnline']) && !allowedTo('moderate_forum'))
		{
			$context['num_users_hidden']++;
			continue;
		}

			
			$link = '';
	
		$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
		if ($is_buddy)
		{
			$context['num_buddies']++;
			$link = '' . $link . '';
		}

		$context['users_online'][$row['logTime'] . $row['memberName']] = array(
			'id' => $row['ID_MEMBER'],
			'username' => $row['memberName'],
			'name' => $row['realName'],
			'group' => $row['ID_GROUP'],
			'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
			'link' => $link,
			'is_buddy' => $is_buddy,
			'hidden' => empty($row['showOnline']),
		);

		$context['list_users_online'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;

		if (!isset($context['online_groups'][$row['ID_GROUP']]))
			$context['online_groups'][$row['ID_GROUP']] = array(
				'id' => $row['ID_GROUP'],
				'name' => $row['groupName'],
				'color' => $row['onlineColor']
			);
	}
	mysql_free_result($result);

	krsort($context['users_online']);
	krsort($context['list_users_online']);
	ksort($context['online_groups']);
	
	$context['num_users_online_today'] = count($context['users_online_today']);
	if (!$user_info['is_admin'])
	{
		$context['num_users_online_today'] = $context['num_users_online_today'] + $context['num_hidden_users_online_today'];
	}

	$context['num_users_online'] = count($context['users_online']) + $context['num_users_hidden'];
	while ($row = mysql_fetch_assoc($request))
	{
		$actions = @unserialize($row['url']);
		if ($actions === false)
			continue;

		$context['members'][$row['session']] = array(
			'id' => $row['ID_MEMBER'],
			'ip' => allowedTo('moderate_forum') ? $row['ip'] : '',
			'time' => strtr(timeformat($row['logTime']), array($txt['smf10'] => '', $txt['smf10b'] => '')),
			'timestamp' => forum_time(true, $row['logTime']),
			'query' => $actions,
			'color' => empty($row['onlineColor']) ? '' : $row['onlineColor']
		);

		$url_data[$row['session']] = array($row['url'], $row['ID_MEMBER']);
		$member_ids[] = $row['ID_MEMBER'];
	}
	mysql_free_result($request);

$members_result = db_query("
		SELECT ID_MEMBER, realName, memberName, posts
		FROM {$db_prefix}members
		WHERE posts > 0
		ORDER BY posts DESC
		LIMIT 10", __FILE__, __LINE__);
	$context['top_posters'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		$context['top_posters'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['posts'],
			'href' => $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'],
			'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_posts < $row_members['posts'])
			$max_num_posts = $row_members['posts'];
	}
	mysql_free_result($members_result);
	
        //Top poster week
        $starttime = mktime(0, 0, 0, date("n"), date("j")-7, date("Y"));
	$starttime = forum_time(false, $starttime);
	
	$request = db_query("
		SELECT me.ID_MEMBER, me.memberName, me.realName, COUNT(*) as count_posts
		FROM {$db_prefix}messages AS m
			LEFT JOIN {$db_prefix}members AS me ON (me.ID_MEMBER = m.ID_MEMBER)
		WHERE m.posterTime > $starttime
			AND m.ID_MEMBER != 0
		GROUP BY me.ID_MEMBER
		ORDER BY count_posts DESC
		LIMIT 10", __FILE__, __LINE__);
			
	$context['top_posters_week'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($request))
	{
		$context['top_posters_week'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['count_posts'],
			'href' => $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'],
			'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_posts < $row_members['count_posts'])
			$max_num_posts = $row_members['count_posts'];
	}
	mysql_free_result($request);

	foreach ($context['top_posters_week'] as $i => $j)
		$context['top_posters_week'][$i]['post_percent'] = round(($j['num_posts'] * 100) / $max_num_posts);

	unset($max_num_posts, $row_members, $j, $i);

        //Top poster week
	$starttime = mktime(0, 0, 0, date("n"), date("j")-7, date("Y"));
	$starttime = forum_time(false, $starttime);
	
	$request = db_query("
                    SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.puntos
                    FROM {$db_prefix}topics AS t INNER JOIN {$db_prefix}messages AS m ON t.ID_TOPIC = m.ID_TOPIC
                    WHERE m.posterTime > $starttime
                    ORDER BY t.puntos DESC
                    LIMIT 10", __FILE__, __LINE__);

        $context['top_posts_week'] = array();
	
	while ($row = mysql_fetch_assoc($request))
		$context['top_posts_week'][] = array(
			'titulo' => $row['subject'],
			'puntos' => $row['puntos'],
			'id' => $row['ID_TOPIC']
			);
	mysql_free_result($request);

        //Top starter
	$members_result = db_query("
		SELECT ID_MEMBER, realName, memberName, topics
		FROM {$db_prefix}members
		WHERE topics > 0
		ORDER BY topics DESC
		LIMIT 10", __FILE__, __LINE__);
	$context['top_starters'] = array();
	$max_num_topics = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		$context['top_starters'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_topics' => $row_members['topics'],
			'href' => $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'],
			'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'] . '">' . $row_members['realName'] . '</a>'
		);

		if ($max_num_topics < $row_members['topics'])
			$max_num_topics = $row_members['topics'];
	}
	mysql_free_result($members_result);

			$context['shop_richest'] = array();
		$result = db_query("
			SELECT ID_MEMBER, realName, memberName, money
			FROM {$db_prefix}members
			ORDER BY money DESC, realName
			LIMIT 10", __FILE__, __LINE__);
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			$context['shop_richest'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'memberName' => $row['memberName'],
				'realName' => $row['realName'],
				'money' => $row['money']
			);
			
			$members_result = db_query("SELECT ID_MEMBER, realName, memberName, posts
                                                    FROM {$db_prefix}members
                                                    ORDER BY ID_MEMBER DESC
                                                    LIMIT 10", __FILE__, __LINE__);
	$context['yeniuyeler'] = array();
	$max_num_posts = 1;
	while ($row_members = mysql_fetch_assoc($members_result))
	{
		
		$context['yeniuyeler'][] = array(
			'name' => $row_members['realName'],
			'id' => $row_members['ID_MEMBER'],
			'num_posts' => $row_members['posts'],
			'href' => $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'],
			'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row_members['ID_MEMBER'] . '">' . $row_members['realName'] . '</a>'
		);

		
if (!empty($modSettings['MemberColorStats']))
			$MemberColor_ID_MEMBER[$row_members['ID_MEMBER']] = $row_members['ID_MEMBER'];


if ($max_num_posts < $row_members['posts'])
			$max_num_posts = $row_members['posts'];
	}
	mysql_free_result($members_result);


	if (isset($_GET['delete']))
	{
		checkSession('get');

		require_once($sourcedir . '/RemoveTopic.php');
		removeMessage((int) $_GET['delete']);

		redirectexit('action=index');
	}

	loadTemplate('Recent');
	$context['page_title'] = $txt[214];

	if (isset($_REQUEST['start']) && $_REQUEST['start'] > 10000000000)
		$_REQUEST['start'] = 10000000000;

	if (!empty($_REQUEST['c']) && empty($board))
	{
		$_REQUEST['c'] = explode(',', $_REQUEST['c']);
		foreach ($_REQUEST['c'] as $i => $c)
			$_REQUEST['c'][$i] = (int) $c;

		if (count($_REQUEST['c']) == 1)
		{
			$request = db_query("
				SELECT name
				FROM {$db_prefix}categories
				WHERE ID_CAT = " . $_REQUEST['c'][0] . "
				LIMIT 1", __FILE__, __LINE__);
			list ($name) = mysql_fetch_row($request);
			mysql_free_result($request);

			if (empty($name))
				fatal_lang_error(1, false);

			$context['linktree'][] = array(
				'url' => $scripturl . '#' . (int) $_REQUEST['c'],
				'name' => $name
			);
		}

		$request = db_query("
			SELECT b.ID_BOARD, b.numPosts
			FROM {$db_prefix}boards AS b
			WHERE b.ID_CAT IN (" . implode(', ', $_REQUEST['c']) . ")
				AND $user_info[query_see_board]", __FILE__, __LINE__);
		$total_cat_posts = 10000000000;
		$boards = array();
		while ($row = mysql_fetch_assoc($request))
		{
			$boards[] = $row['ID_BOARD'];
			$total_cat_posts += $row['numPosts'];
		}
		mysql_free_result($request);

		if (empty($boards))
			fatal_lang_error('error_no_boards_selected', false);

		$query_this_board = 'b.ID_BOARD IN (' . implode(', ', $boards) . ')';

		// If this category has a significant number of posts in it...
		if ($total_cat_posts > 9000 && $total_cat_posts > $modSettings['totalMessages'] / 15)
			$query_this_board .= '
			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 400 - $_REQUEST['start'] * 7);

		$context['page_index'] = constructPageIndex($scripturl . '?action=index;c=' . implode(',', $_REQUEST['c']), $_REQUEST['start'], min(9000, $total_cat_posts), 90, false);
	}
	elseif (!empty($_REQUEST['boards']))
	{
		$_REQUEST['boards'] = explode(',', $_REQUEST['boards']);
		foreach ($_REQUEST['boards'] as $i => $b)
			$_REQUEST['boards'][$i] = (int) $b;

		$request = db_query("
			SELECT b.ID_BOARD, b.numPosts
			FROM {$db_prefix}boards AS b
			WHERE b.ID_BOARD IN (" . implode(', ', $_REQUEST['boards']) . ")
				AND $user_info[query_see_board]
			LIMIT " . count($_REQUEST['boards']), __FILE__, __LINE__);
		$total_posts = 0;
		$boards = array();
		while ($row = mysql_fetch_assoc($request))
		{
			$boards[] = $row['ID_BOARD'];
			$total_posts += $row['numPosts'];
		}
		mysql_free_result($request);

		if (empty($boards))
			fatal_lang_error('error_no_boards_selected', false);

		$query_this_board = 'b.ID_BOARD IN (' . implode(', ', $boards) . ')';

		if ($total_posts > 10000000000 && $total_posts > $modSettings['totalMessages'] / 12)
			$query_this_board .= '
			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 500 - $_REQUEST['start'] * 10000000000);

		$context['page_index'] = constructPageIndex($scripturl . '?action=index;boards=' . implode(',', $_REQUEST['boards']), $_REQUEST['start'], min(10000000000, $total_posts), 10000000000, false);
	}
	elseif (!empty($board))
	{
		$request = db_query("
			SELECT numPosts
			FROM {$db_prefix}boards
			WHERE ID_BOARD = $board
			LIMIT 1", __FILE__, __LINE__);
		list ($total_posts) = mysql_fetch_row($request);
		mysql_free_result($request);

		$query_this_board = 'b.ID_BOARD = ' . $board;

		// If this board has a significant number of posts in it...
		if ($total_posts > 10000000000000000000 && $total_posts > $modSettings['totalMessages'] / 10000000000000000000)
			$query_this_board .= '
			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 600 - $_REQUEST['start'] * 10000000000000000000);

		$context['page_index'] = constructPageIndex($scripturl . '?action=index;board=' . $board . '.%d', $_REQUEST['start'], min(10000000000000000000, $total_posts), 10000000000000000000, true);
	}
	else
	{
		$query_this_board = $user_info['query_see_board'] . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "
			AND b.ID_BOARD != $modSettings[recycle_board]" : ''). '
			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 9000 - $_REQUEST['start'] * 6);

		$context['page_index'] = constructPageIndex($scripturl . '?action=index', $_REQUEST['start'], min(99999999999, $modSettings['totalMessages']), 50, false);
	}

	$context['linktree'][] = array(
		'url' => $scripturl . '?action=index' . (empty($board) ? (empty($_REQUEST['c']) ? '' : ';c=' . (int) $_REQUEST['c']) : ';board=' . $board . '.0'),
		'name' => $context['page_title']
	);
}
?>