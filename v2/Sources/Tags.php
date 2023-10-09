<?php

if (!defined('SMF'))
	die('Hacking attempt...');

function TagsMain()
{
	loadtemplate('Tags');
	if (loadlanguage('Tags') == false)
		loadLanguage('Tags','english');

	$subActions = array(

		'suggest' => 'SuggestTag',
		'suggest2' => 'SuggestTag2',
		'addtag' => 'AddTag',
		'addtag2' => 'AddTag2',
		'deletetag' => 'DeleteTag',
		'admin' => 'TagsSettings',
		'admin2' => 'TagsSettings2',
		'cleanup' => 'TagCleanUp',
	);


	if (!empty($subActions[@$_GET['sa']]))
		$subActions[$_GET['sa']]();
	else
		ViewTags();

}
function ViewTags()
{
	global $context,$txt,$mbname,$db_prefix,$scripturl,$user_info;
	
	if (isset($_REQUEST['id']))
	{
		$id = (int) $_REQUEST['id'];
		
		$dbresult = db_query("SELECT tag FROM {$db_prefix}tags WHERE ID_TAG = $id LIMIT 1", __FILE__, __LINE__);
		$row = mysql_fetch_assoc($dbresult);
		mysql_free_result($dbresult);
		
		$context['tag_search'] = $row['tag'];
		$context['page_title'] = $row['tag'];
	$dbresult = db_query("
		SELECT t.numReplies,t.numViews,mem.RealName,t.puntos,m.ID_MEMBER,m.posterTime,m.posterName,m.subject,m.ID_TOPIC,m.posterTime, t.ID_BOARD ,b.name
		FROM {$db_prefix}tags_log as l, {$db_prefix}boards as b, {$db_prefix}topics AS t, {$db_prefix}messages as m, {$db_prefix}members as mem
		WHERE l.ID_TAG = $id AND m.ID_TOPIC = l.ID_TOPIC AND m.ID_MEMBER = mem.ID_MEMBER AND b.ID_BOARD = t.ID_BOARD AND l.ID_TOPIC = t.ID_TOPIC AND t.ID_FIRST_MSG = m.ID_MSG AND " . $user_info['query_see_board'], __FILE__, __LINE__);
		
		$context['tags_topics'] = array();
		while ($row = mysql_fetch_assoc($dbresult))
		{
				$context['tags_topics'][] = array(
				'ID_MEMBER' => $row['ID_MEMBER'],
				'user' => $row['RealName'],
				'puntos' => $row['puntos'],
				'posterName' => $row['posterName'],
				'subject' => $row['subject'],
				'ID_TOPIC' => $row['ID_TOPIC'],
			    'ID_BOARD' => $row['ID_BOARD'],
			    'name' => $row['name'],
				'posterTime' => $row['posterTime'],
				'numViews' => $row['numViews'],
				'numReplies' => $row['numReplies'],
				'time' => timeformat($row['posterTime']),
				);
		}
		mysql_free_result($dbresult);
		$context['sub_template']  = 'results';
		
		
		
	}
	else 
	{
		$context['page_title'] =  $txt[18];

$query = "	SELECT ta.tag, t.ID_TAG, COUNT(*) as quantity
		FROM smf_tags_log AS t
		LEFT JOIN smf_tags AS ta ON (ta.ID_TAG = t.ID_TAG)
		WHERE t.ID_TAG != 0
		GROUP BY ta.ID_TAG
		ORDER BY quantity DESC
		LIMIT 100";
		
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
				$row_count++;
			    $size = $min_size + (($value - $min_qty) * $step);
			    $context['poptags'] .= '<a href="'. $scripturl .'?action=tags;id=' . $tags2[$key] . '" style="font-size: '.$size.'%; padding: 0px 5px 0px 5px;"';
			    $context['poptags'] .= ' title="'.$value.' tags con la palabra '.$key.'"';
			   $context['poptags'] .= '>'.$key.'</a>';
			   if ($row_count > 15)
			   {
			   	$context['poptags'] .= '<br><br>';
			   	$row_count =0;
			   }
		   }
		}
		}


	}
function AddTag()
{
	global $context,$txt,$mbname,$db_prefix,$ID_MEMBER;
	
	// Get the Topic
	$topic = (int) $_REQUEST['topic'];
	
	if (empty($topic))
		fatal_error($txt['smftags_err_notopic'],false);
	
	// Check permission
	$a_manage = allowedTo('smftags_manage');
	$dbresult = db_query("
	SELECT m.ID_MEMBER FROM {$db_prefix}topics as t, {$db_prefix}messages as m 
	WHERE t.ID_FIRST_MSG = m.ID_MSG AND t.ID_TOPIC = $topic LIMIT 1", __FILE__, __LINE__);
	
	$row = mysql_fetch_assoc($dbresult);
	mysql_free_result($dbresult);
	
	if ($ID_MEMBER != $row['ID_MEMBER'] && $a_manage == false)
		fatal_error($txt['smftags_err_permaddtags'],false);
	
	$context['tags_topic'] = $topic;
	$context['sub_template']  = 'addtag';
	$context['page_title'] = 'Agregar tags';

	
}
function AddTag2()
{
	global $db_prefix,$txt, $modSettings,$ID_MEMBER;
	$topic = (int) $_REQUEST['topic'];
	
	if (empty($topic))
		fatal_error($txt['smftags_err_notopic'],false);
	
	
	// Check Permission
	$a_manage = allowedTo('smftags_manage');
		
	$dbresult = db_query("SELECT m.ID_MEMBER FROM {$db_prefix}topics as t, {$db_prefix}messages as m
	 WHERE t.ID_FIRST_MSG = m.ID_MSG AND t.ID_TOPIC = $topic LIMIT 1", __FILE__, __LINE__);
	
	$row = mysql_fetch_assoc($dbresult);
	mysql_free_result($dbresult);
	
	if($ID_MEMBER != $row['ID_MEMBER'] && $a_manage == false)
		fatal_error($txt['smftags_err_permaddtags'],false);
	$dbresult = db_query("SELECT COUNT(*) as total FROM {$db_prefix}tags_log 
	WHERE ID_TOPIC = " . $topic, __FILE__, __LINE__);
	
	$row = mysql_fetch_assoc($dbresult);
	$totaltags = $row['total'];
	mysql_free_result($dbresult);
	
	if ($totaltags >= $modSettings['smftags_set_maxtags'])
		fatal_error($txt['smftags_err_toomaxtag'],false);
	
	// Check Tag restrictions
	$tag = htmlspecialchars($_REQUEST['tag'],ENT_QUOTES);
	
	if (empty($tag))
		fatal_error($txt['smftags_err_notag'],false);
	if (strlen($tag) < $modSettings['smftags_set_mintaglength'])
		fatal_error($txt['smftags_err_mintag'] .  $modSettings['smftags_set_mintaglength'],false);
	if (strlen($tag) > $modSettings['smftags_set_maxtaglength'])
		fatal_error($txt['smftags_err_maxtag'] . $modSettings['smftags_set_maxtaglength'],false);
	$dbresult = db_query("SELECT ID_TAG FROM {$db_prefix}tags 
		WHERE tag = '$tag'", __FILE__, __LINE__);
	if (db_affected_rows() == 0)
	{
		db_query("INSERT INTO {$db_prefix}tags
			(tag, approved)
		VALUES ('$tag',1)", __FILE__, __LINE__);	
		$ID_TAG = db_insert_id();
		db_query("INSERT INTO {$db_prefix}tags_log
			(ID_TAG,ID_TOPIC, ID_MEMBER)
		VALUES ($ID_TAG,$topic,$ID_MEMBER)", __FILE__, __LINE__);
	}
	else 
	{
		$row = mysql_fetch_assoc($dbresult);
		$ID_TAG = $row['ID_TAG'];
		$dbresult2= db_query("SELECT ID FROM {$db_prefix}tags_log 
		WHERE ID_TAG  =  $ID_TAG  AND ID_TOPIC = $topic", __FILE__, __LINE__);
		if (db_affected_rows() != 0)
		{
			fatal_error($$txt['smftags_err_alreadyexists'],false);
		}
		mysql_free_result($dbresult2);
		db_query("INSERT INTO {$db_prefix}tags_log
			(ID_TAG,ID_TOPIC, ID_MEMBER)
		VALUES ($ID_TAG,$topic,$ID_MEMBER)", __FILE__, __LINE__);
	}
	mysql_free_result($dbresult);
	redirectexit('topic=' . $topic);
}
function DeleteTag()
{
	global $db_prefix,$ID_MEMBER, $txt;
	
	$id = (int) $_REQUEST['id'];
	$a_manage = allowedTo('smftags_manage');
	
	$dbresult = db_query("SELECT ID_MEMBER,ID_TOPIC,ID_TAG FROM {$db_prefix}tags_log
	 WHERE ID = $id LIMIT 1", __FILE__, __LINE__);
	
	$row = mysql_fetch_assoc($dbresult);
	mysql_free_result($dbresult);
	
	if ($row['ID_MEMBER'] != $ID_MEMBER && $a_manage == false)
		fatal_error($txt['smftags_err_deletetag'],false);
	db_query("DELETE FROM {$db_prefix}tags_log WHERE ID = $id LIMIT 1", __FILE__, __LINE__);
	TagCleanUp($row['ID_TAG']);
	redirectexit('topic=' . $row['ID_TOPIC']);
}
function TagsSettings()
{
	global $context,$txt,$mbname;
	adminIndex('tags_settings');
	isAllowedTo('smftags_manage');
	
	
	
	$context['sub_template']  = 'admin_settings';
	$context['page_title'] = $mbname . ' - ' . $txt['smftags_settings'];
}
function TagsSettings2()
{
	isAllowedTo('smftags_manage');
	$smftags_set_mintaglength = (int) $_REQUEST['smftags_set_mintaglength'];
	$smftags_set_maxtaglength =  (int) $_REQUEST['smftags_set_maxtaglength'];
	$smftags_set_maxtags =  (int) $_REQUEST['smftags_set_maxtags'];
	updateSettings(
	array('smftags_set_maxtags' => $smftags_set_maxtags,
	'smftags_set_mintaglength' => $smftags_set_mintaglength,
	'smftags_set_maxtaglength' => $smftags_set_maxtaglength,
	));
	redirectexit('action=tags;sa=admin');
}
function TagCleanUp($ID_TAG)
{
	
	global $db_prefix;

		$dbresult2 = db_query("SELECT ID FROM {$db_prefix}tags_log 
			WHERE ID_TAG = " . $ID_TAG, __FILE__, __LINE__);
		
		if (db_affected_rows() == 0)
		{
			db_query("DELETE FROM {$db_prefix}tags WHERE ID_TAG = " . $ID_TAG, __FILE__, __LINE__);
		}
		mysql_free_result($dbresult2);
	
}

function SuggestTag()
{
	global $context,$txt,$mbname;
	isAllowedTo('smftags_suggest');
	
	$context['sub_template']  = 'suggest';
	$context['page_title'] = $mbname . ' - ' . $txt['smftags_suggest'];
}
function SuggestTag2()
{
	isAllowedTo('smftags_suggest');
}

?>