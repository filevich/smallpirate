<?php
/**********************************************************************************
* News.php                                                                        *
***********************************************************************************
* SMF: Simple Machines Forum                                                      *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                    *
* =============================================================================== *
* Software Version:           SMF 1.1                                             *
* Software by:                Simple Machines (http://www.simplemachines.org)     *
* Copyright 2006 by:          Simple Machines LLC (http://www.simplemachines.org) *
*           2001-2006 by:     Lewis Media (http://www.lewismedia.com)             *
* Support, News, Updates at:  http://www.simplemachines.org                       *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Simple Machines LLC.          *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Simple Machines license.          *
* The latest version can always be found at http://www.simplemachines.org.        *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

/*	This file contains the files necessary to display news as an XML feed.

	void ShowXmlFeed()
		- is called to output xml information.

		- can be passed four subactions which decide what is output: 'recent'

		  for recent posts, 'news' for news topics, 'members' for recently

		  registered members, and 'profile' for a member's profile.

		- To display a member's profile, a user id has to be given. (;u=1)

		- uses the Stats language file.

		- outputs an rss feed instead of a proprietary one if the 'type' get

		  parameter is 'rss' or 'rss2'.

		- does not use any templates, sub templates, or template layers.

		- is accessed via ?action=.xml.



	void dumpTags(array data, int indentation, string tag = use_array,

			string format)

		- formats data retrieved in other functions into xml format.

		- additionally formats data based on the specific format passed.

		- the data parameter is the array to output as xml data.

		- indentation is the amount of indentation to use.

		- if a tag is specified, it will be used instead of the keys of data.

		- this function is recursively called to handle sub arrays of data.



	array getXmlMembers(string format)

		- is called to retrieve list of members from database.

		- the array will be generated to match the format.

		- returns array of data.



	array getXmlNews(string format)

		- is called to retrieve news topics from database.

		- the array will be generated to match the format.

		- returns array of topics.



	array getXmlRecent(string format)

		- is called to retrieve list of recent topics.

		- the array will be generated to match the format.

		- returns an array of recent posts.



	array getXmlProfile(string format)

		- is called to retrieve profile information for member into array.

		- the array will be generated to match the format.

		- returns an array of data.

*/



// Show an xml file representing recent information or a profile.

function ShowXmlFeed()

{

	global $db_prefix, $board, $board_info, $context, $scripturl, $txt, $modSettings, $user_info;

	global $query_this_board;



	// If it's not enabled, die.

	if (empty($modSettings['xmlnews_enable']))

		obExit(false);



	loadLanguage('Stats');



	// Default to latest 5.  No more than 255, please.

	$_GET['limit'] = empty($_GET['limit']) || (int) $_GET['limit'] < 1 ? 25 : min((int) $_GET['limit'], 255);



	// Handle the cases where a board, boards, or category is asked for.

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

				WHERE ID_CAT = " . (int) $_REQUEST['c'][0], __FILE__, __LINE__);

			list ($feed_title) = mysql_fetch_row($request);

			mysql_free_result($request);



			$feed_title = ' - ' . htmlspecialchars($feed_title);

		}



		$request = db_query("

			SELECT b.ID_BOARD, b.numPosts

			FROM {$db_prefix}boards AS b

			WHERE b.ID_CAT IN (" . implode(', ', $_REQUEST['c']) . ")

				AND $user_info[query_see_board]", __FILE__, __LINE__);

		$total_cat_posts = 0;

		$boards = array();

		while ($row = mysql_fetch_assoc($request))

		{

			$boards[] = $row['ID_BOARD'];

			$total_cat_posts += $row['numPosts'];

		}

		mysql_free_result($request);



		if (!empty($boards))

			$query_this_board = 'b.ID_BOARD IN (' . implode(', ', $boards) . ')';



		// Try to limit the number of messages we look through.

		if ($total_cat_posts > 100 && $total_cat_posts > $modSettings['totalMessages'] / 15)

			$query_this_board .= '

			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 400 - $_GET['limit'] * 5);

	}

	elseif (!empty($_REQUEST['boards']))

	{

		$_REQUEST['boards'] = explode(',', $_REQUEST['boards']);

		foreach ($_REQUEST['boards'] as $i => $b)

			$_REQUEST['boards'][$i] = (int) $b;



		$request = db_query("

			SELECT b.ID_BOARD, b.numPosts, b.name

			FROM {$db_prefix}boards AS b

			WHERE b.ID_BOARD IN (" . implode(', ', $_REQUEST['boards']) . ")

				AND $user_info[query_see_board]

			LIMIT " . count($_REQUEST['boards']), __FILE__, __LINE__);



		// Either the board specified doesn't exist or you have no access.

		if (mysql_num_rows($request) == 0)

			fatal_lang_error('smf232');



		$total_posts = 0;

		$boards = array();

		while ($row = mysql_fetch_assoc($request))

		{

			if (count($_REQUEST['boards']) == 1)

				$feed_title = ' - ' . htmlspecialchars($row['name']);



			$boards[] = $row['ID_BOARD'];

			$total_posts += $row['numPosts'];

		}

		mysql_free_result($request);



		if (!empty($boards))

			$query_this_board = 'b.ID_BOARD IN (' . implode(', ', $boards) . ')';



		// The more boards, the more we're going to look through...

		if ($total_posts > 100 && $total_posts > $modSettings['totalMessages'] / 12)

			$query_this_board .= '

			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 500 - $_GET['limit'] * 5);

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



		$feed_title = ' - ' . htmlspecialchars($board_info['name']);



		$query_this_board = 'b.ID_BOARD = ' . $board;



		// Try to look through just a few messages, if at all possible.

		if ($total_posts > 80 && $total_posts > $modSettings['totalMessages'] / 10)

			$query_this_board .= '

			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 600 - $_GET['limit'] * 5);

	}

	else

	{

		$query_this_board = $user_info['query_see_board'] . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "

			AND b.ID_BOARD != $modSettings[recycle_board]" : ''). '

			AND m.ID_MSG >= ' . max(0, $modSettings['maxMsgID'] - 100 - $_GET['limit'] * 5);

	}



	// Show in rss or proprietary format?

	$xml_format = isset($_GET['type']) && in_array($_GET['type'], array('smf', 'rss', 'rss2', 'atom', 'rdf')) ? $_GET['type'] : 'smf';



	// !!! Birthdays?



	// List all the different types of data they can pull.

	$subActions = array(

		'recent' => array('getXmlRecent', 'recent-post'),

		'comentarios' => array('getXmlComentarios', 'comentarios'),

		'post' => array('getXmlpost', 'article'),

		'us' => array('getXmlus', 'article'),

		'widget' => array('getXmlwidget', 'article'),

		'ppuntos' => array('getXmlppuntos', 'article'),

		'imagenes-vistas' => array('getXmlimgv', 'article'),

		'widget-cortado' => array('getXmlwidgetcortado', 'article'),

		'categorias' => array('getXmlcategorias', 'categoria'),

		'postsres' => array('getXmlpostrespondidos', 'postr'),

		'postsvist' => array('getXmlpostvistos', 'postvis'),

		'puntos' => array('getXmlpuntos', 'money'),

		'charlantes' => array('getXmlcharlantes', 'charlantes'),

		'posteadores' => array('getXmlposteadores', 'starter'),

	    'usuarios' => array('getXmlMembers', 'member'),

		'profile' => array('getXmlProfile', null),

	);

	if (empty($_GET['sa']) || !isset($subActions[$_GET['sa']]))

		$_GET['sa'] = 'recent';



	// Get the associative array representing the xml.

	if ($user_info['is_guest'] && !empty($modSettings['cache_enable']) && $modSettings['cache_enable'] >= 2)

		$xml = cache_get_data('xmlfeed-' . $xml_format . ':' . md5(serialize($_GET)), 240);

	if (empty($xml))

	{

		$xml = $subActions[$_GET['sa']][0]($xml_format);



		if ($user_info['is_guest'] && !empty($modSettings['cache_enable']) && $modSettings['cache_enable'] >= 2)

			cache_put_data('xmlfeed-' . $xml_format . ':' . md5(serialize($_GET)), $xml, 240);

	}



	$feed_title = htmlspecialchars(htmlspecialchars($context['forum_name'])) . (isset($feed_title) ? $feed_title : '');



	// This is an xml file....

	ob_end_clean();

	if (!empty($modSettings['enableCompressedOutput']))

		@ob_start('ob_gzhandler');

	else

		ob_start();




	if ($xml_format == 'smf' || isset($_REQUEST['debug']))

		header('Content-Type: text/xml; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));

	elseif ($xml_format == 'rss' || $xml_format == 'rss2')

		header('Content-Type: application/rss+xml; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));

	elseif ($xml_format == 'atom')

		header('Content-Type: application/atom+xml; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));

	elseif ($xml_format == 'rdf')

		header('Content-Type: application/rdf+xml; charset=' . (empty($context['character_set']) ? 'ISO-8859-1' : $context['character_set']));



	// First, output the xml header.

	echo '<?xml version="1.0" encoding="', $context['character_set'], '"?' . '>';



	// Are we outputting an rss feed or one with more information?

	if ($xml_format == 'rss' || $xml_format == 'rss2')

	{

		// Start with an RSS 2.0 header.

		echo '

<rss version=', $xml_format == 'rss2' ? '"2.0"' : '"0.92"', ' xml:lang="', strtr($txt['lang_locale'], '_', '-'), '">

	<channel>

	 <image>

    <url>'; echo $scripturl; echo'/web/imagenes/rss.png</url>

    <title>RSS</title>

    <link>'; echo $scripturl; echo'</link>



    <width>111</width>

    <height>32</height>

    <description>en vivo desde '; echo $scripturl; echo'</description>

  </image>

	    <title>', $feed_title, ' - RSS ', $posttt, '</title>

    <link>'; echo $scripturl; echo'</link>

    <description>en vivo desde '; echo $scripturl; echo'</description>';



		// Output all of the associative array, start indenting with 2 tabs, and name everything "item".

		dumpTags($xml, 2, 'item', $xml_format);



		// Output the footer of the xml.

		echo '

	</channel>

</rss>';

	}

	elseif ($xml_format == 'atom')

	{

		echo '

<feed version="0.3" xmlns="http://purl.org/atom/ns#">

	<title>', $feed_title, '</title>

	<link rel="alternate" type="text/html" href="', $scripturl, '" />



	<modified>', gmstrftime('%Y-%m-%dT%H:%M:%SZ'), '</modified>

	<tagline><![CDATA[', htmlspecialchars($txt['xml_rss_desc']), ']]></tagline>

	<generator>�Lo Meno!</generator>

	<author>

		<name>', htmlspecialchars($context['forum_name']), '</name>

	</author>';



		dumpTags($xml, 2, 'entry', $xml_format);



		echo '

</feed>';

	}

	elseif ($xml_format == 'rdf')

	{

		echo '

<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns="http://purl.org/rss/1.0/">

	<channel rdf:about="', $scripturl, '">

		<title>', $feed_title, '  ', $posttt, '</title>

		<link>', $scripturl, '</link>

		<description><![CDATA[', htmlspecialchars($txt['xml_rss_desc']), ']]></description>

		<items>

			<rdf:Seq>';



		foreach ($xml as $item)

			echo '

				<rdf:li rdf:resource="', $item['link'], '" />';



		echo '

			</rdf:Seq>

		</items>

	</channel>

';



		dumpTags($xml, 1, 'item', $xml_format);



		echo '

</rdf:RDF>';

	}

	// Otherwise, we're using our proprietary formats - they give more data, though.

	else

	{

		echo '

<smf:xml-feed xmlns:smf="http://www.simplemachines.org/" xmlns="http://www.simplemachines.org/xml/', $_GET['sa'], '" xml:lang="', strtr($txt['lang_locale'], '_', '-'), '">';



		// Dump out that associative array.  Indent properly.... and use the right names for the base elements.

		dumpTags($xml, 1, $subActions[$_GET['sa']][1], $xml_format);



		echo '

</smf:xml-feed>';

}



	obExit(false);

}



function fix_possible_url($val)

{

	global $modSettings, $context, $scripturl;



	if (substr($val, 0, strlen($scripturl)) != $scripturl)

		return $val;



	if (isset($modSettings['integrate_fix_url']) && funcion_exists($modSettings['integrate_fix_url']))

		$val = call_user_func($modSettings['integrate_fix_url'], $val);




/***	if (empty($modSettings['queryless_urls']) || ($context['server']['is_cgi'] && @ini_get('cgi.fix_pathinfo') == 0) || !$context['server']['is_apache'])
		return $val;

	$val = preg_replace('/^' . preg_quote($scripturl, '/') . '\?((?:board|topic)=[^#"]+)(#[^"]*)?$/e', "'' . \$scripturl . '/' . strtr('\$1', '&;=', '//,') . '.html\$2'", $val); ***/


}



function cdata_parse($data, $ns = '')

{

	global $func;



	$cdata = '<![CDATA[';



	for ($pos = 0, $n = $func['strlen']($data); $pos < $n; null)

	{

		$positions = array(

			$func['strpos']($data, '&', $pos),

			$func['strpos']($data, ']', $pos),

		);

		if ($ns != '')

			$positions[] = $func['strpos']($data, '<', $pos);

		foreach ($positions as $k => $dummy)

		{

			if ($dummy === false)

				unset($positions[$k]);

		}



		$old = $pos;

		$pos = empty($positions) ? $n : min($positions);



		if ($pos - $old > 0)

			$cdata .= $func['substr']($data, $old, $pos - $old);

		if ($pos >= $n)

			break;



		if ($func['substr']($data, $pos, 1) == '<')

		{

			$pos2 = $func['strpos']($data, '>', $pos);

			if ($pos2 === false)

				$pos2 = $n;

			if ($func['substr']($data, $pos + 1, 1) == '/')

				$cdata .= ']]></' . $ns . ':' . $func['substr']($data, $pos + 2, $pos2 - $pos - 1) . '<![CDATA[';

			else

				$cdata .= ']]><' . $ns . ':' . $func['substr']($data, $pos + 1, $pos2 - $pos) . '<![CDATA[';

			$pos = $pos2 + 1;

		}

		elseif ($func['substr']($data, $pos, 1) == ']')

		{

			$cdata .= ']]>&#093;<![CDATA[';

			$pos++;

		}

		elseif ($func['substr']($data, $pos, 1) == '&')

		{

			$pos2 = $func['strpos']($data, ';', $pos);

			if ($pos2 === false)

				$pos2 = $n;

			$ent = $func['substr']($data, $pos + 1, $pos2 - $pos - 1);



			if ($func['substr']($data, $pos + 1, 1) == '#')

				$cdata .= ']]>' . $func['substr']($data, $pos, $pos2 - $pos + 1) . '<![CDATA[';

			elseif (in_array($ent, array('amp', 'lt', 'gt', 'quot')))

				$cdata .= ']]>' . $func['substr']($data, $pos, $pos2 - $pos + 1) . '<![CDATA[';

			// !!! ??



			$pos = $pos2 + 1;

		}

	}



	$cdata .= ']]>';



	return strtr($cdata, array('<![CDATA[]]>' => ''));

}



function dumpTags($data, $i, $tag = null, $xml_format = '')

{

	global $modSettings, $context, $scripturl;



	// For every array in the data...

	foreach ($data as $key => $val)

	{

		// Skip it, it's been set to null.

		if ($val == null)

			continue;



		// If a tag was passed, use it instead of the key.

		$key = isset($tag) ? $tag : $key;



		// First let's indent!

		echo "\n", str_repeat("\t", $i);



		// Grr, I hate kludges... almost worth doing it properly, here, but not quite.

		if ($xml_format == 'atom' && $key == 'link')

		{

			echo '<link rel="alternate" type="text/html" href="', fix_possible_url($val), '" />';

			continue;

		}



		// If it's empty/0/nothing simply output an empty tag.

		if ($val == '')

			echo '<', $key, ' />';

		else

		{

			// Beginning tag.

			if ($xml_format == 'rdf' && $key == 'item' && isset($val['link']))

			{

				echo '<', $key, ' rdf:about="', fix_possible_url($val['link']), '">';

				echo "\n", str_repeat("\t", $i + 1);

				echo '<dc:format>text/html</dc:format>';

			}

			elseif ($xml_format == 'atom' && $key == 'summary')

				echo '<', $key, ' type="html">';

			else

				echo '<', $key, '>';



			if (is_array($val))

			{

				// An array.  Dump it, and then indent the tag.

				dumpTags($val, $i + 1, null, $xml_format);

				echo "\n", str_repeat("\t", $i), '</', $key, '>';

			}

			// A string with returns in it.... show this as a multiline element.

			elseif (strpos($val, "\n") !== false || strpos($val, '<br />') !== false)

				echo "\n", fix_possible_url($val), "\n", str_repeat("\t", $i), '</', $key, '>';

			// A simple string.

			else

				echo fix_possible_url($val), '</', $key, '>';

		}

	}

}





function getXmlpuntos($xml_format)

{

	global $db_prefix, $scripturl;



	$request = db_query("
			SELECT ID_MEMBER, memberName, realName, money
			FROM {$db_prefix}members
			ORDER BY money DESC, realName
			LIMIT 25", __FILE__, __LINE__);


	

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['realName']) . ' (' . formatMoney($row['money']) .')',

			    'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

				'comments' => $scripturl . '?action=pm;sa=send;u=' . $row['ID_MEMBER'],

				'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $row['dateRegistered']),

				'guid' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		elseif ($xml_format == 'rdf')

			$data[] = array(

				'title' => cdata_parse($row['realName'] ($row['money'])),

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		elseif ($xml_format == 'atom')

			$data[] = array(

				'title' => cdata_parse($row['realName']),

						'money' => $row['money'],

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

				'created' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['dateRegistered']),

				'issued' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['dateRegistered']),

				'modified' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['lastLogin']),

				'id' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		// More logical format for the data, but harder to apply.

		else

			$data[] = array(
				'name' => cdata_parse($row['realName']),
				'time' => htmlspecialchars(timeformat($row['dateRegistered'])),
				'id' => $row['ID_MEMBER'],
				'money' => $row['money'],
				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER']
			);
	}
	mysql_free_result($request);

	return $data;
}

function getXmlposteadores($xml_format)
{
	global $db_prefix, $scripturl;
    
	$request = db_query("
		SELECT ID_MEMBER, memberName, realName, topics
		FROM {$db_prefix}members
		WHERE topics > 0
		ORDER BY topics DESC

		LIMIT 25", __FILE__, __LINE__);

	$max_num_topics = 1;

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['realName']).' (' . $row['topics'] .') ',

				'link' => '' . $scripturl . '/?action=profile;u=' . $row['ID_MEMBER'],

				'comments' => cdata_parse($scripturl . '?action=pm;sa=send;u=' . $row['ID_MEMBER']),

				'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $row['dateRegistered']),

				'guid' => '' . $scripturl . '/?action=profile;u=' . $row['ID_MEMBER'],

			);

		

	}

	mysql_free_result($request);



	return $data;

}



function getXmlcharlantes($xml_format)

{

	global $db_prefix, $scripturl;

    

	$request = db_query("



		SELECT ID_MEMBER, realName, memberName, posts

		FROM {$db_prefix}members

		WHERE posts > 0

		ORDER BY posts DESC

		LIMIT 25", __FILE__, __LINE__);

	$context['top_posters'] = array();

	$max_num_posts = 1;

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['realName']).' (' . $row['posts'] .') ',

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

				'comments' => cdata_parse($scripturl . '?action=pm;sa=send;u=' . $row['ID_MEMBER']),

				'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $row['dateRegistered']),

				'guid' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		

	}

	mysql_free_result($request);



	return $data;

}



function getXmlMembers($xml_format)

{

	global $db_prefix, $scripturl;



	// Find the most recent members.

	$request = db_query("

		SELECT ID_MEMBER, memberName, realName, dateRegistered, lastLogin

		FROM {$db_prefix}members

		ORDER BY ID_MEMBER DESC

		LIMIT $_GET[limit]", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		// Make the data look rss-ish.

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['realName']),

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

				'comments' => cdata_parse($scripturl . '?action=pm;sa=send;u=' . $row['ID_MEMBER']),

				'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $row['dateRegistered']),

				'guid' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		elseif ($xml_format == 'rdf')

			$data[] = array(

				'title' => cdata_parse($row['realName']),

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

								'comments' => $scripturl . '?action=pm;sa=send;u=' . $row['ID_MEMBER'],

			);

		elseif ($xml_format == 'atom')

			$data[] = array(

				'title' => cdata_parse($row['realName']),

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

				'created' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['dateRegistered']),

				'issued' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['dateRegistered']),

				'modified' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['lastLogin']),

				'id' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],

			);

		// More logical format for the data, but harder to apply.

		else

			$data[] = array(

				'name' => cdata_parse($row['realName']),

				'time' => htmlspecialchars(timeformat($row['dateRegistered'])),

				'id' => $row['ID_MEMBER'],

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER']

			);

	}

	mysql_free_result($request);



	return $data;

}



function getXmlpost($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	/* Find the latest posts that:

		- are the first post in their topic.

		- are on an any board OR in a specified board.

		- can be seen by this user.

		- are actually the latest posts. */

	$request = db_query("

		SELECT

			m.smileysEnabled, m.posterTime, m.ID_MSG, m.subject, m.body, t.ID_TOPIC, t.ID_BOARD,

			b.name AS bname, t.numReplies, m.ID_MEMBER, IFNULL(mem.realName, m.posterName) AS posterName,

			mem.hideEmail, IFNULL(mem.emailAddress, m.posterEmail) AS posterEmail, m.modifiedTime

		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)

			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)

		WHERE b.ID_BOARD = " . (empty($board) ? 't.ID_BOARD' : "$board

			AND t.ID_BOARD = $board") . "

			AND m.ID_MSG = t.ID_FIRST_MSG

			AND $query_this_board

		ORDER BY t.ID_FIRST_MSG DESC

		LIMIT $_GET[limit]", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		// Limit the length of the message, if the option is set.

		if (!empty($modSettings['xmlnews_maxlen']) && $func['strlen'](str_replace('<br />', "\n", $row['body'])) > $modSettings['xmlnews_maxlen'])

			$row['body'] = strtr($func['substr'](str_replace('<br />', "\n", $row['body']), 0, $modSettings['xmlnews_maxlen'] - 3), array("\n" => '<br />')) . '...';



		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);



		censorText($row['body']);

		censorText($row['subject']);



		// Being news, this actually makes sense in rss format.

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['subject']),

				'link' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.0',

				'description' => cdata_parse($row['body']),

				'author' => (!empty($modSettings['guest_hideContacts']) && $user_info['is_guest']) || (!empty($row['hideEmail']) && !empty($modSettings['allow_hideEmail']) && !allowedTo('moderate_forum')) ? null : $row['posterEmail'],

				'comments' => $scripturl . '?action=post;topic=' . $row['ID_TOPIC'] . '.0',

				'category' => '<![CDATA[' . $row['bname'] . ']]>',

				'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $row['posterTime']),

				'guid' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.msg' . $row['ID_MSG'] . '#msg' . $row['ID_MSG']

			);

		elseif ($xml_format == 'rdf')

			$data[] = array(

				'title' => cdata_parse($row['subject']),

				'link' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.0',

				'description' => cdata_parse($row['body']),

			);

		elseif ($xml_format == 'atom')

			$data[] = array(

				'title' => cdata_parse($row['subject']),

				'link' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.0',

				'summary' => cdata_parse($row['body']),

				'author' => array('name' => $row['posterName']),

				'created' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['posterTime']),

				'issued' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', $row['posterTime']),

				'modified' => gmstrftime('%Y-%m-%dT%H:%M:%SZ', empty($row['modifiedTime']) ? $row['posterTime'] : $row['modifiedTime']),

				'id' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.msg' . $row['ID_MSG'] . '#msg' . $row['ID_MSG']

			);

		// The biggest difference here is more information.

		else

			$data[] = array(

				'time' => htmlspecialchars(timeformat($row['posterTime'])),

				'id' => $row['ID_MSG'],

				'subject' => cdata_parse($row['subject']),

				'body' => cdata_parse($row['body']),

				'poster' => array(

					'name' => cdata_parse($row['posterName']),

					'id' => $row['ID_MEMBER'],

					'link' => !empty($row['ID_MEMBER']) ? $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] : ''

				),

				'topic' => $row['ID_TOPIC'],

				'board' => array(

					'name' => cdata_parse($row['bname']),

					'id' => $row['ID_BOARD'],

					'link' => $scripturl . '?board=' . $row['ID_BOARD'] . '.0'

				),

				'link' => $scripturl . '?topic=' . $row['ID_TOPIC'] . '.0'

			);

	}

	mysql_free_result($request);



	return $data;

}



function getXmlus($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$starttime = mktime(0, 0, 0, date("n"), date("j"), date("Y")) - (date("N")*3600*24);

	$starttime = forum_time(false, $starttime);

		$request = db_query("	SELECT me.ID_MEMBER, me.memberName, me.realName, COUNT(*) as count_posts

		FROM {$db_prefix}messages AS m

			LEFT JOIN {$db_prefix}members AS me ON (me.ID_MEMBER = m.ID_MEMBER)

		WHERE m.posterTime > " . $starttime . "

			AND m.ID_MEMBER != 0

		GROUP BY me.ID_MEMBER

		ORDER BY count_posts DESC

		LIMIT 10", __FILE__, __LINE__);

$max_num_posts = 1;

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

		if (!empty($modSettings['xmlnews_maxlen']) && $func['strlen'](str_replace('<br />', "\n", $row['body'])) > $modSettings['xmlnews_maxlen'])



		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['realName']),

				'link' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '',

				'description' => cdata_parse($row['count_posts']),

				);

	if ($max_num_posts < $row['count_posts'])

			$max_num_posts = $row['count_posts'];

			}

	mysql_free_result($request);

	

	

	foreach ($data as $i => $j)

		$data[$i]['post_percent'] = round(($j['num_posts'] * 100) / $max_num_posts);



	unset($max_num_posts, $row_members, $j, $i);

	

	return $data;

}



function getXmlppuntos($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board, $db_prefix, $query_this_board, $func;



$request = db_query("

SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.puntos

FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m)

WHERE t.ID_TOPIC = m.ID_TOPIC

ORDER BY t.puntos DESC

LIMIT 25", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){ 

    $texto .= ' '.$arrayTexto[$contador]; 

    $contador++; 

} 

			censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => ''. $row['subject']. ' ('. $row['puntos'].' puntos)',

				'link' => '' . $scripturl . '/?topic=' . $row['id'] . '',



				);





	}

	mysql_free_result($request);



	return $data;

}

function getXmlimgv($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("SELECT m.ID_MEMBER, i.ID_MEMBER, i.ID_PICTURE, i.title, m.memberName, m.realName, i.views

FROM ({$db_prefix}gallery_pic AS i, {$db_prefix}members AS m)

WHERE i.ID_MEMBER = m.ID_MEMBER

ORDER BY i.views DESC

LIMIT 0 , 25", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){ 

    $texto .= ' '.$arrayTexto[$contador]; 

    $contador++; 

} 

			censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => ''. $row['title']. ' ('.$row['views'] .')',

				'link' => '' . $scripturl . '/?action=imagenes;sa=ver;id=' . $row['ID_PICTURE'] . '',



				);





	}

	mysql_free_result($request);



	return $data;

}

function getXmlwidget($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT

			m.smileysEnabled, m.posterTime, m.ID_MSG, m.subject, m.body, t.ID_TOPIC, t.ID_BOARD,

			b.name AS bname, t.numReplies, m.ID_MEMBER, IFNULL(mem.realName, m.posterName) AS posterName,

			mem.hideEmail, IFNULL(mem.emailAddress, m.posterEmail) AS posterEmail, m.modifiedTime

		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)

			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)

		WHERE b.ID_BOARD = " . (empty($board) ? 't.ID_BOARD' : "$board

			AND t.ID_BOARD = $board") . "

			AND m.ID_MSG = t.ID_FIRST_MSG

			AND $query_this_board

		ORDER BY t.ID_FIRST_MSG DESC

		LIMIT " .$_GET['can']. "", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){ 

    $texto .= ' '.$arrayTexto[$contador]; 

    $contador++; 

} 

	

			$row['body'] = '' . $row['ID_BOARD'] . '';

    		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);

 

		censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => $row['subject'],

				'link' => '' . $scripturl . '/'.'?topic=' . $row['ID_TOPIC'] . '/' . str_replace(' ','-',$row['subject']) . '',

				'description' => cdata_parse($row['body']),

				);





	}

	mysql_free_result($request);



	return $data;

}

function getXmlwidgetcortado($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT

			m.smileysEnabled, m.posterTime, m.ID_MSG, m.subject, m.body, t.ID_TOPIC, t.ID_BOARD,

			b.name AS bname, t.numReplies, m.ID_MEMBER, IFNULL(mem.realName, m.posterName) AS posterName,

			mem.hideEmail, IFNULL(mem.emailAddress, m.posterEmail) AS posterEmail, m.modifiedTime

		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)

			LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = m.ID_MEMBER)

		WHERE b.ID_BOARD = " . (empty($board) ? 't.ID_BOARD' : "$board

			AND t.ID_BOARD = $board") . "

			AND m.ID_MSG = t.ID_FIRST_MSG

			AND $query_this_board

		ORDER BY t.ID_FIRST_MSG DESC

		LIMIT " .$_GET['can']. "", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{



	

			$row['body'] = '' . $row['ID_BOARD'] . '';

    		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);

 

		censorText($row['body']);

		censorText($row['subject']);



		// Doesn't work as well as news, but it kinda does..

		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => strlen($row['subject']) > $limit ? substr($row['subject'], 0, $limit + 30) . '' : $row['subject'],

				'link' => '' . $scripturl . '/'.'?topic=' . $row['ID_TOPIC'] . '/' . str_replace(' ','-',$row['subject']) . '',

				'description' => cdata_parse($row['body']),

				);





	}

	mysql_free_result($request);



	return $data;

}



function getXmlcategorias($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT ID_BOARD, name, numPosts

		FROM {$db_prefix}boards AS b

		WHERE $user_info[query_see_board]" . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "

			AND b.ID_BOARD != $modSettings[recycle_board]" : '') . "

		ORDER BY numPosts DESC

		LIMIT 25", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

	

			$row['body'] = '' . $row['ID_BOARD'] . '';

    		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);

 

		censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => '' . $row['name'] . ' (' . $row['numPosts'] . ')',

				'link' => '' . $scripturl . '/?board=' . $row['ID_BOARD'] . '',

				);



	}

	mysql_free_result($request);



	return $data;

}				



function getXmlpostrespondidos($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT m.subject, t.numReplies, t.ID_BOARD, t.ID_TOPIC, b.name

		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)

		WHERE m.ID_MSG = t.ID_FIRST_MSG

			AND $user_info[query_see_board]" . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "

			AND b.ID_BOARD != $modSettings[recycle_board]" : '') . "

			AND t.ID_BOARD = b.ID_BOARD" . (!empty($topic_ids) ? "

			AND t.ID_TOPIC IN (" . implode(', ', $topic_ids) . ")" : '') . "

		ORDER BY t.numReplies DESC

		LIMIT 25", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

	

			$row['body'] = '' . $row['ID_BOARD'] . '';

    		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);

 

		censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => '' . $row['subject'] . ' (' . $row['numReplies'] . ')',

				'link' => '' . $scripturl . '/?topic=' . $row['ID_TOPIC'] . '',

				);





	}

	mysql_free_result($request);



	return $data;

}

function getXmlpostvistos($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT m.subject, t.numViews, t.ID_BOARD, t.ID_TOPIC, b.name

		FROM ({$db_prefix}topics AS t, {$db_prefix}messages AS m, {$db_prefix}boards AS b)

		WHERE m.ID_MSG = t.ID_FIRST_MSG

			AND $user_info[query_see_board]" . (!empty($modSettings['recycle_enable']) && $modSettings['recycle_board'] > 0 ? "

			AND b.ID_BOARD != $modSettings[recycle_board]" : '') . "

			AND t.ID_BOARD = b.ID_BOARD" . (!empty($topic_ids) ? "

			AND t.ID_TOPIC IN (" . implode(', ', $topic_ids) . ")" : '') . "

		ORDER BY t.numViews DESC

		LIMIT 25", __FILE__, __LINE__);

	$data = array();

	while ($row = mysql_fetch_assoc($request))

	{

	

			$row['body'] = '' . $row['ID_BOARD'] . '';

    		$row['body'] = parse_bbc($row['body'], $row['smileysEnabled'], $row['ID_MSG']);

 

		censorText($row['body']);

		censorText($row['subject']);





		if ($xml_format == 'rss' || $xml_format == 'rss2')	

			$data[] = array(

				'title' => '' . $row['subject'] . ' (' . $row['numViews'] . ')',

				'link' => '' . $scripturl . '/?topic=' . $row['ID_TOPIC'] . '',

				);





	}

	mysql_free_result($request);



	return $data;

}



function getXmlRecent($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



	$request = db_query("

		SELECT c.id_post, c.comentario, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName

FROM ({$db_prefix}comentarios AS c, {$db_prefix}messages AS m, {$db_prefix}members AS mem)

WHERE id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER

ORDER BY c.id_coment DESC

LIMIT 25", __FILE__, __LINE__);

	$messages = array();

	while ($row = mysql_fetch_assoc($request))

{

		if (!empty($modSettings['xmlnews_maxlen']) && $func['strlen'](str_replace('<br />', "\n", $row['comentario'])) > $modSettings['xmlnews_maxlen'])

			$row['comentario'] = strtr($func['substr'](str_replace('<br />', "\n", $row['comentario']), 0, $modSettings['xmlnews_maxlen'] - 3), array("\n" => '<br />')) . '...';

		$row['comentario'] = parse_bbc($row['comentario'], '1', $row['ID_MSG']);

		censorText($row['comentario']);

		censorText($row['subject']);

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse($row['memberName'].' - '.$row['subject']),

				'link' => '' . $scripturl . '/?topic=' . $row['ID_TOPIC'] . '#cmt_' . $row['id_coment'] ,

				'description' => cdata_parse($row['comentario']),

			);

	}

	mysql_free_result($request);



	return $data;

}





function getXmlComentarios($xml_format)

{

	global $db_prefix, $user_info, $scripturl, $modSettings, $board;

	global $query_this_board, $func;



$id = $_GET['id'];

$posttt = 'postsssss';



$request = db_query("

SELECT c.id_post, c.comentario, c.id_coment, m.subject, m.ID_TOPIC, c.id_user, mem.ID_MEMBER, mem.RealName, mem.memberName

FROM ({$db_prefix}comentarios AS c, {$db_prefix}messages AS m, {$db_prefix}members AS mem)

WHERE c.id_post = $id AND c.id_post = m.ID_TOPIC AND c.id_user = mem.ID_MEMBER", __FILE__, __LINE__);



while ($row = mysql_fetch_assoc($request))

{

		$row['comentario'] = parse_bbc($row['comentario'], '1', $row['ID_MSG']);

		censorText($row['comentario']);

		censorText($row['subject']);

		if ($xml_format == 'rss' || $xml_format == 'rss2')

			$data[] = array(

				'title' => cdata_parse('Comentario de '.$row['memberName']),

				'link' => '' . $scripturl . '/?topic=' . $row['ID_TOPIC'] . '#cmt_' . $row['id_coment'] ,

				'description' => cdata_parse($row['comentario']),

			);

	}

	mysql_free_result($request);



	return $data;

}



function getXmlProfile($xml_format)

{

	global $scripturl, $memberContext, $user_profile, $modSettings, $user_info;



	// You must input a valid user....

	if (empty($_GET['u']) || loadMemberData((int) $_GET['u']) === false)

		return array();



	// Make sure the id is a number and not "I like trying to hack the database".

	$_GET['u'] = (int) $_GET['u'];



	// Load the member's contextual information!

	if (!loadMemberContext($_GET['u']))

		return array();



	// Okay, I admit it, I'm lazy.  Stupid $_GET['u'] is long and hard to type.

	$profile = &$memberContext[$_GET['u']];

	if ($xml_format == 'rss' || $xml_format == 'rss2')

		$data = array(array(

			'title' => cdata_parse($profile['name']),

			'link' => $scripturl  . '?action=profile;u=' . $profile['id'],

			'description' => cdata_parse(isset($profile['group']) ? $profile['group'] : $profile['post_group']),

			'comments' => $scripturl . '?action=pm;sa=send;u=' . $profile['id'],

			'pubDate' => gmdate('D, d M Y H:i:s \G\M\T', $user_profile[$profile['id']]['dateRegistered']),

			'guid' => $scripturl  . '?action=profile;u=' . $profile['id'],

		));



	// Save some memory.

	unset($profile);

	unset($memberContext[$_GET['u']]);



	return $data;

}

function formatMoney($money)

{

	global $modSettings;

	$money = (float) $money;

	return $modSettings['shopCurrencyPrefix'] . $money;

}

function wordcut($texto,$wini,$wcant){

    $wordsout="";

    $arraywords = split(" ",$texto);

    while( ($xword = $arraywords[$wini]) and $wcant ){

        $wordsout .= "$xword ";

        $wini++;

        $wcant--;

    }

    return $wordsout; 

}

?>