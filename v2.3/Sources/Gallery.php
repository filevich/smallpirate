<?php
/* Software Version:  SMF 0.1        */
if (!defined('SMF'))
	die('Error');

function GalleryMain()
{

	loadtemplate('Gallery');

	if(loadlanguage('Gallery') == false)
	loadLanguage('Gallery','spanish');
	$subActions = array(
		'main' => 'main',
		'ver' => 'ViewPicture',
		'admincat' => 'AdminCats',
		'adminset'=> 'AdminSettings',
		'adminset2'=> 'AdminSettings2',
		'eliminar545' => 'DeletePicture',
		'eliminar' => 'DeletePicture2',
		'reportar' => 'ReportPicture',
		'report2' => 'ReportPicture2',
		'editar' => 'EditPicture',
		'edit2' => 'EditPicture2',
		'dpuntos' => 'dpuntos',
		'dpuntos2' => 'dpuntos2',
		'deletereport' => 'DeleteReport',
		'reportlist' => 'ReportList',
		'comment' => 'AddComment',
		'comment2' => 'AddComment2',
		'eliminar-comment' => 'DeleteComment',
		'rate' => 'RatePicture',
		'catup' => 'CatUp',
		'catdown' => 'CatDown',
		'addcat' => 'AddCategory',
		'addcat2' => 'AddCategory2',
		'editcat' => 'EditCategory',
		'editcat2' => 'EditCategory2',
		'deletecat' => 'DeleteCategory',
		'deletecat2' => 'DeleteCategory2',
		'viewc' => 'ViewC',
		'45844' => 'MyImages',
		'approvelist' => 'ApproveList',
		'aprobar' => 'ApprovePicture',
		'noaprobar' => 'UnApprovePicture',
		'agregar' => 'AddPicture',
		'add2' => 'AddPicture2',
		'search' => 'Search',
		'search2' => 'Search2',
	);


	@$sa = $_GET['sa'];
	if (!empty($subActions[$sa]))
		$subActions[$sa]();
	else
		main();

}
function main()
{
	global $context, $scripturl, $mbname,$txt, $db_prefix, $modSettings, $user_info;
		global $context, $mbname, $txt, $db_prefix;

	isAllowedTo('smfgallery_view');


	$us = mysql_real_escape_string($_GET['usuario']);
	if($us == '')
	fatal_error($txt['gallery_error_no_user_selected']);

    $resp = mysql_query("select * from {$db_prefix}members where memberName LIKE '$us'") ;
    $datos = mysql_fetch_array($resp) ;
	
	$u = (int) $datos['ID_MEMBER'];
	$context['gallery_userid'] = $u;
    $dbresult = db_query("SELECT m.memberName, m.realName FROM {$db_prefix}members AS m WHERE m.ID_MEMBER = {$u}  LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	$context['gallery_usergallery_name'] = $row['realName'];
	mysql_free_result($dbresult);


	$context['page_title'] = $txt[18];

	$context['sub_template']  = 'galeria';
	
	isAllowedTo('smfgallery_view');

	$context['sub_template']  = 'main';

	$context['gallery_cat_name'] = ' ';

}
function AddCategory()
{
	global $context, $mbname, $txt, $modSettings, $db_prefix;

	isAllowedTo('smfgallery_manage');

	adminIndex('imagenes');

	$context['page_title'] = $txt[18];

	$context['sub_template']  = 'add_category';

	// Check if spellchecking is both enabled and actually working.
	$context['show_spellchecking'] = !empty($modSettings['enableSpellChecking']) && function_exists('pspell_new');

}
function AddCategory2()
{
	global $db_prefix, $txt, $scripturl;

	isAllowedTo('smfgallery_manage');


	$title = htmlspecialchars($_REQUEST['title'], ENT_QUOTES);
	$description = htmlspecialchars($_REQUEST['description'], ENT_QUOTES);
	$image =  htmlspecialchars($_REQUEST['image'], ENT_QUOTES);

	if($title == '')
		fatal_error($txt['gallery_error_cat_title'],false);

	//Do the order
	$dbresult = db_query("SELECT roworder FROM {$db_prefix}gallery_cat ORDER BY roworder DESC", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);

	$order = $row['roworder'];
	$order++;

	//Insert the category
	db_query("INSERT INTO {$db_prefix}gallery_cat
			(title, description,roworder,image)
		VALUES ('$title', '$description',$order,'$image')", __FILE__, __LINE__);
	mysql_free_result($dbresult);


	 redirectexit('action=imagenes;sa=admincat');
}
function ViewC()
{
	die(base64_decode('UG93ZXJlZCBieSBHYWxsZXJ5IEZvciBTTUYgIG1hZGUgYnkgdmJnYW1lcjQ1IGh0dHA6Ly93d3cuc21maGFja3MuY29t'));
}
function EditCategory()
{
	global $context, $mbname, $txt, $modSettings, $db_prefix;
	isAllowedTo('smfgallery_manage');

	adminIndex('gallery_settings');

	$context['page_title'] = $txt[18];

	$context['sub_template']  = 'edit_category';

	// Check if spellchecking is both enabled and actually working.
	$context['show_spellchecking'] = !empty($modSettings['enableSpellChecking']) && function_exists('pspell_new');

}
function EditCategory2()
{
	global $db_prefix, $txt,$scripturl;
	isAllowedTo('smfgallery_manage');

	//Clean the input
	$title = htmlspecialchars($_REQUEST['title'], ENT_QUOTES);
	$description = htmlspecialchars($_REQUEST['description'], ENT_QUOTES);
	$catid = (int) $_REQUEST['catid'];
	$image = htmlspecialchars($_REQUEST['image'], ENT_QUOTES);

	if($title == '')
		fatal_error($txt['gallery_error_cat_title'],false);

	//Update the category
	db_query("UPDATE {$db_prefix}gallery_cat
		SET title = '$title', image = '$image', description = '$description' WHERE ID_CAT = $catid LIMIT 1", __FILE__, __LINE__);


	redirectexit('action=imagenes;sa=admincat');

}
function DeleteCategory()
{
	global $context, $mbname, $txt, $db_prefix;
	isAllowedTo('smfgallery_manage');

	adminIndex('gallery_settings');

	$context['page_title'] = $txt[18];

	$context['sub_template']  = 'delete_category';
}
function DeleteCategory2()
{
	global $db_prefix, $modSettings, $boarddir,$scripturl;
	isAllowedTo('smfgallery_manage');

    if(empty($modSettings['gallery_path']))
	{
		$modSettings['gallery_path'] = $boarddir . '/gallery/';
	}

	$catid = (int) $_REQUEST['catid'];

	$dbresult = db_query("SELECT ID_PICTURE, thumbfilename, filename FROM {$db_prefix}gallery_pic WHERE ID_CAT = $catid", __FILE__, __LINE__);

	while($row = mysql_fetch_assoc($dbresult))
	{
		//Delete Files
		//Delete Large image
		@unlink($modSettings['gallery_path'] . $row['filename']);
		//Delete Thumbnail
		@unlink($modSettings['gallery_path'] . $row['thumbfilename']);

		db_query("DELETE FROM {$db_prefix}gallery_comment WHERE ID_PICTURE  = " . $row['ID_PICTURE'], __FILE__, __LINE__);
		//db_query("DELETE FROM {$db_prefix}gallery_rating WHERE ID_PICTURE  = " . $row['ID_PICTURE'], __FILE__, __LINE__);
		db_query("DELETE FROM {$db_prefix}gallery_report WHERE ID_PICTURE  = " . $row['ID_PICTURE'], __FILE__, __LINE__);

	}
	//Delete All Pictures
	db_query("DELETE FROM {$db_prefix}gallery_pic WHERE ID_CAT = $catid", __FILE__, __LINE__);



	//Finally delete the category
	db_query("DELETE FROM {$db_prefix}gallery_cat WHERE ID_CAT = $catid LIMIT 1", __FILE__, __LINE__);


	redirectexit('action=imagenes;sa=admincat');
}
function ViewPicture()
{
	global $context, $mbname, $db_prefix,$modSettings,$user_info, $scripturl,$txt, $ID_MEMBER;

	is_not_guest();

	isAllowedTo('smfgallery_comment');
	loadlanguage('Post');

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	$context['gallery_pic_id'] = $id;

	//Comments allowed check
    $dbresult = db_query("SELECT p.allowcomments FROM {$db_prefix}gallery_pic as p WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	mysql_free_result($dbresult);


	$context['sub_template']  = 'add_comment';

	$context['page_title'] = $txt[18];


	$context['smileys'] = array(
		'postform' => array(),
		'popup' => array(),
	);

	if(function_exists('parse_bbc'))
		$esmile = 'embarrassed.gif';
	else
		$esmile = 'embarassed.gif';

	if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')
		$context['smileys']['postform'][] = array(
			'smileys' => array(
				array('code' => ':)', 'filename' => 'smiley.gif', 'description' => $txt[287]),
				array('code' => ';)', 'filename' => 'wink.gif', 'description' => $txt[292]),
				array('code' => ':D', 'filename' => 'cheesy.gif', 'description' => $txt[289]),
				array('code' => ';D', 'filename' => 'grin.gif', 'description' => $txt[293]),
				array('code' => '>:(', 'filename' => 'angry.gif', 'description' => $txt[288]),
				array('code' => ':(', 'filename' => 'sad.gif', 'description' => $txt[291]),
				array('code' => ':o', 'filename' => 'shocked.gif', 'description' => $txt[294]),
				array('code' => '8)', 'filename' => 'cool.gif', 'description' => $txt[295]),
				array('code' => '???', 'filename' => 'huh.gif', 'description' => $txt[296]),
				array('code' => '::)', 'filename' => 'rolleyes.gif', 'description' => $txt[450]),
				array('code' => ':P', 'filename' => 'tongue.gif', 'description' => $txt[451]),
				array('code' => ':-[', 'filename' => $esmile, 'description' => $txt[526]),
				array('code' => ':-X', 'filename' => 'lipsrsealed.gif', 'description' => $txt[527]),
				array('code' => ':-\\', 'filename' => 'undecided.gif', 'description' => $txt[528]),
				array('code' => ':-*', 'filename' => 'kiss.gif', 'description' => $txt[529]),
				array('code' => ':\'(', 'filename' => 'cry.gif', 'description' => $txt[530])
			),
			'last' => true,
		);
	elseif ($user_info['smiley_set'] != 'none')
	{
		$request = db_query("
			SELECT code, filename, description, smileyRow, hidden
			FROM {$db_prefix}smileys
			WHERE hidden IN (0, 2)
			ORDER BY smileyRow, smileyOrder", __FILE__, __LINE__);
		while ($row = mysql_fetch_assoc($request))
			$context['smileys'][empty($row['hidden']) ? 'postform' : 'popup'][$row['smileyRow']]['smileys'][] = $row;
		mysql_free_result($request);
	}

	// Clean house... add slashes to the code for javascript.
	foreach (array_keys($context['smileys']) as $location)
	{
		foreach ($context['smileys'][$location] as $j => $row)
		{
			$n = count($context['smileys'][$location][$j]['smileys']);
			for ($i = 0; $i < $n; $i++)
			{
				$context['smileys'][$location][$j]['smileys'][$i]['code'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['code']);
				$context['smileys'][$location][$j]['smileys'][$i]['js_description'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['description']);
			}

			$context['smileys'][$location][$j]['smileys'][$n - 1]['last'] = true;
		}
		if (!empty($context['smileys'][$location]))
			$context['smileys'][$location][count($context['smileys'][$location]) - 1]['last'] = true;
	}
	$settings['smileys_url'] = $modSettings['smileys_url'] . '/' . $user_info['smiley_set'];

	// Allow for things to be overridden.
	if (!isset($context['post_box_columns']))
		$context['post_box_columns'] = 60;
	if (!isset($context['post_box_rows']))
		$context['post_box_rows'] = 12;
	if (!isset($context['post_box_name']))
		$context['post_box_name'] = 'comment';
	if (!isset($context['post_form']))
		$context['post_form'] = 'cprofile';

	$context['show_bbc'] = !empty($modSettings['enableBBC']) && !empty($settings['show_bbc']);

	if (!empty($modSettings['disabledBBC']))
	{
		$disabled_tags = explode(',', $modSettings['disabledBBC']);
		foreach ($disabled_tags as $tag)
			$context['disabled_tags'][trim($tag)] = true;
	}

	isAllowedTo('smfgallery_view');

	//Get the picture ID
	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

    $dbresult = db_query("SELECT p.ID_PICTURE, p.width, p.height, p.allowcomments, p.ID_CAT, p.keywords, p.commenttotal, p.filesize, p.filename, p.views, p.title, p.ID_MEMBER, m.memberName, m.realName, p.date, p.description FROM {$db_prefix}gallery_pic as p
    LEFT JOIN {$db_prefix}members AS m ON (p.ID_MEMBER = m.ID_MEMBER) WHERE p.ID_PICTURE = $id   LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	$context['gallery_pic'] = array(
		'ID_PICTURE' => $row['ID_PICTURE'],
		'ID_MEMBER' => $row['ID_MEMBER'],
		'commenttotal' => $row['commenttotal'],
		'views' => $row['views'],
		'title' => $row['title'],
		'description' => $row['description'],
		'filesize' => round($row['filesize']  / 1024, 2),
		'filename' => $row['filename'],
		'width' => $row['width'],
		'height' => $row['height'],
		'allowcomments' => $row['allowcomments'],
		'ID_CAT' => $row['ID_CAT'],
		'date' => $row['date'],
		'keywords' => $row['keywords'],
		'memberName' => $row['memberName'],
		'realName' => $row['realName'],
	);
	mysql_free_result($dbresult);
	  $dbresult = db_query("UPDATE {$db_prefix}gallery_pic
		SET views = views + 1 WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$context['sub_template']  = 'view_picture';
	$context['page_title'] = $txt[18];
	if (!empty($modSettings['gallery_who_viewing']))
	{
		$context['can_moderate_forum'] = allowedTo('moderate_forum');
			if(function_exists('parse_bbc'))
			{
				//SMF 1.1
				//Taken from Display.php
				// Start out with no one at all viewing it.
				$context['view_members'] = array();
				$context['view_members_list'] = array();
				$context['view_num_hidden'] = 0;

				// Search for members who have this picture id set in their GET data.
				$request = db_query("
					SELECT
						lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
						mg.onlineColor, mg.ID_GROUP, mg.groupName
					FROM {$db_prefix}log_online AS lo
						LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
						LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
					WHERE INSTR(lo.url, 's:7:\"gallery\";s:2:\"sa\";s:4:\"view\";s:2:\"id\";s:1:\"$id\";') OR lo.session = '" . ($user_info['is_guest'] ? 'ip' . $user_info['ip'] : session_id()) . "'", __FILE__, __LINE__);
				while ($row = mysql_fetch_assoc($request))
				{
					if (empty($row['ID_MEMBER']))
						continue;

					if (!empty($row['onlineColor']))
						$link = '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
					else
						$link = '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';

					$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
					if ($is_buddy)
						$link = '<b>' . $link . '</b>';
					if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
						$context['view_members_list'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;
					$context['view_members'][$row['logTime'] . $row['memberName']] = array(
						'id' => $row['ID_MEMBER'],
						'username' => $row['memberName'],
						'name' => $row['realName'],
						'group' => $row['ID_GROUP'],
						'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
						'link' => $link,
						'is_buddy' => $is_buddy,
						'hidden' => empty($row['showOnline']),
					);

					if (empty($row['showOnline']))
						$context['view_num_hidden']++;
				}
				$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
				mysql_free_result($request);
				krsort($context['view_members']);
				krsort($context['view_members_list']);
			}
			else
			{
				$context['view_members'] = array();
				$context['view_members_list'] = array();
				$context['view_num_hidden'] = 0;
				$request = db_query("
					SELECT mem.ID_MEMBER, IFNULL(mem.realName, 0) AS realName, mem.showOnline
					FROM {$db_prefix}log_online AS lo
						LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
					WHERE INSTR(lo.url, 's:7:\"gallery\";s:2:\"sa\";s:4:\"view\";s:2:\"id\";s:1:\"$id\";')", __FILE__, __LINE__);
				while ($row = mysql_fetch_assoc($request))
					if (!empty($row['ID_MEMBER']))
					{
						if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
							$context['view_members_list'][] = empty($row['showOnline']) ? '<i><a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a></i>' : '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';
						$context['view_members'][] = array(
							'id' => $row['ID_MEMBER'],
							'name' => $row['realName'],
							'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
							'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>',
							'hidden' => empty($row['showOnline']),
						);

						if (empty($row['showOnline']))
							$context['view_num_hidden']++;
					}

			$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
				mysql_free_result($request);
			}

	}
}
function AddPicture()
{
	global $context, $mbname, $txt, $modSettings, $db_prefix;

	isAllowedTo('smfgallery_add');
	$context['sub_template']  = 'add_picture';
	$context['page_title'] = $txt[18];
	$request = mysql_query("
                            SELECT *
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
if($context['leecher'])
fatal_error($txt['gallery_lechers_noimage'],true);
}
function AddPicture2()
{
	global $ID_MEMBER, $txt, $db_prefix, $scripturl,$modSettings, $boarddir,$sourcedir,$gd2;

	isAllowedTo('smfgallery_add');
	if(empty($modSettings['gallery_path']))
	{
		$modSettings['gallery_path'] = $boarddir . '/gallery/';
	}
	if (!is_writable($modSettings['gallery_path']))
		fatal_error($txt['gallery_write_error'] . $modSettings['gallery_path']);
	$title = htmlspecialchars($_REQUEST['title'],ENT_QUOTES);
	$description = htmlspecialchars($_REQUEST['description'],ENT_QUOTES);
	$keywords = htmlspecialchars($_REQUEST['keywords'],ENT_QUOTES);
	$cat = (int) $_REQUEST['cat'];
	@$allowcomments = $_REQUEST['allowcomments'];
	$approved = (allowedTo('smfgallery_autoapprove') ? 1 : 0);
	if(empty($modSettings['gallery_commentchoice']) || $modSettings['gallery_commentchoice'] == 0)
		$allowcomments = 1;
	else
	{
		if(empty($allowcomments))
			$allowcomments = 0;
		else
			$allowcomments = 1;
	}

	if($title == '')
		fatal_error($txt['gallery_error_no_title'],false);
	if($cat == '')
		fatal_error($txt['gallery_error_no_cat'],false);

$filename = $_POST['filename'];
$description = $_POST['description'];
$cat = $_POST['cat'];
$title = $_POST['title'];
$ID_MEMBER = $_POST['ID_MEMBER'];
$t = $_POST['t'];
$approved = $_POST['approved'];
$allowcomments = $_POST['allowcomments'];

				db_query("INSERT INTO {$db_prefix}gallery_pic
							(ID_CAT, filename, title, description,ID_MEMBER,date,approved,allowcomments)
						VALUES ($cat, '$filename', '$title', '$description',$ID_MEMBER,$t,$approved, $allowcomments)", __FILE__, __LINE__);

			// Update the SMF Shop Points
			if (isset($modSettings['shopVersion']))
 				db_query("UPDATE {$db_prefix}members
				 	SET money = money + " . $modSettings['gallery_shop_picadd'] . "
				 	WHERE ID_MEMBER = {$ID_MEMBER}
				 	LIMIT 1", __FILE__, __LINE__);
			

}
function EditPicture()
{
	global $context, $mbname, $txt,$ID_MEMBER,$db_prefix, $modSettings;

	is_not_guest();
	$request = mysql_query("
                            SELECT *
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
if($context['leecher'])
fatal_error($txt['gallery_lechers_no_edit_image'],true);
	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);
    $dbresult = db_query("SELECT p.ID_PICTURE, p.width, p.height, p.ID_CAT, p.keywords, p.commenttotal, p.filesize, p.filename,  p.views, p.title, p.ID_MEMBER, m.memberName, m.realName, p.date, p.description 
    FROM {$db_prefix}gallery_pic as p
    LEFT JOIN {$db_prefix}members AS m ON (m.ID_MEMBER = p.ID_MEMBER) WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);

	//Gallery picture information
	$context['gallery_pic'] = array(
		'ID_PICTURE' => $row['ID_PICTURE'],
		'ID_MEMBER' => $row['ID_MEMBER'],
		'commenttotal' => $row['commenttotal'],
		'views' => $row['views'],
		'title' => $row['title'],
		'description' => $row['description'],
		'filesize' => round($row['filesize']  / 1024, 2),
		'filename' => $row['filename'],
		'thumbfilename' => $row['thumbfilename'],
		'width' => $row['width'],
		'height' => $row['height'],
		'allowcomments' => $row['allowcomments'],
		'ID_CAT' => $row['ID_CAT'],
		'date' => timeformat($row['date']),
		'keywords' => $row['keywords'],
		'memberName' => $row['memberName'],
		'realName' => $row['realName'],
	);
	mysql_free_result($dbresult);

	if(AllowedTo('smfgallery_manage') || (AllowedTo('smfgallery_edit') && $ID_MEMBER == $context['gallery_pic']['ID_MEMBER']))
	{


		$context['page_title'] = $txt[18];
		$context['sub_template']  = 'edit_picture';



	}
	else
	{
		fatal_error($txt['gallery_error_noedit_permission']);
	}



}
function EditPicture2()
{
	global $ID_MEMBER, $txt, $db_prefix, $scripturl,$modSettings, $boarddir,$sourcedir,$gd2;

	is_not_guest();

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	//Check the user permissions
    $dbresult = db_query("SELECT ID_MEMBER,thumbfilename,filename FROM {$db_prefix}gallery_pic WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	$memID = $row['ID_MEMBER'];
	$oldfilename = $row['filename'];
	$oldthumbfilename  = $row['thumbfilename'];

	mysql_free_result($dbresult);
	if(AllowedTo('smfgallery_manage') || (AllowedTo('smfgallery_edit') && $ID_MEMBER == $memID))
	{

		if(!is_writable($modSettings['gallery_path']))
			fatal_error($txt['gallery_write_error'] . $modSettings['gallery_path']);


		$title = htmlspecialchars($_REQUEST['title'],ENT_QUOTES);
		$description = htmlspecialchars($_REQUEST['description'],ENT_QUOTES);
		$keywords = htmlspecialchars($_REQUEST['keywords'],ENT_QUOTES);
		$cat = (int) $_REQUEST['cat'];

		if($title == '')
			fatal_error($txt['gallery_error_no_title'],false);
		if($cat == '')
			fatal_error($txt['gallery_error_no_cat'],false);


	$testGD = get_extension_funcs('gd');
	$gd2 = in_array('imagecreatetruecolor', $testGD) && function_exists('imagecreatetruecolor');
	unset($testGD);

		//Process Uploaded file
		if (isset($_FILES['picture']['name']) && $_FILES['picture']['name'] != '')
		{

			$sizes = @getimagesize($_FILES['picture']['tmp_name']);

				// No size, then it's probably not a valid pic.
				if ($sizes === false)
					fatal_error($txt['gallery_error_invalid_picture'],false);
				elseif ((!empty($modSettings['gallery_max_width']) && $sizes[0] > $modSettings['gallery_max_width']) || (!empty($modSettings['gallery_max_height']) && $sizes[1] > $modSettings['gallery_max_height']))
				{
					fatal_error($txt['gallery_error_img_size_height'] . $sizes[1] . $txt['gallery_error_img_size_width']. $sizes[0],false);
				}
				else
				{

					//Get the filesize
					$filesize = $_FILES['picture']['size'];
					if(!empty($modSettings['gallery_max_filesize']) && $filesize > $modSettings['gallery_max_filesize'])
					{
						//Delete the temp file
						@unlink($_FILES['picture']['tmp_name']);
						fatal_error($txt['gallery_error_img_filesize'] . round($modSettings['gallery_max_filesize'] / 1024, 2) . 'kb',false);
					}
					//Delete the old files
					@unlink($modSettings['gallery_path'] . $oldfilename );
					@unlink($modSettings['gallery_path'] . $oldthumbfilename);

					//Filename Member Id + Day + Month + Year + 24 hour, Minute Seconds
					$extension = substr(strrchr($_FILES['picture']['name'], '.'), 1);
					$filename = $ID_MEMBER . '_' . date('d_m_y_g_i_s') . '.' . $extension;
					move_uploaded_file($_FILES['picture']['tmp_name'], $modSettings['gallery_path'] . $filename);
					@chmod($modSettings['gallery_path'] . $filename, 0644);
					//Create thumbnail
					require_once($sourcedir . '/Subs-Graphics.php');
					if(function_exists('parse_bbc'))
					{	createThumbnail($modSettings['gallery_path'] . $filename, 120, 78);
						rename($modSettings['gallery_path'] . $filename . '_thumb',  $modSettings['gallery_path'] . 'thumb_' . $filename);
						$thumbname = 'thumb_' . $filename;
					}
					else
					{
						//For 1.0.8
						generateThumbnail($modSettings['gallery_path'] . $filename, $modSettings['gallery_path'] . 'thumb_' . $filename, 120, 78);
						$thumbname = 'thumb_' . $filename;
					}
					@chmod($modSettings['gallery_path'] . $thumbname, 0644);
					db_query("UPDATE {$db_prefix}gallery_pic
					SET ID_CAT = $cat, filename = '$filename', title = '$title', description = '$description' WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);


					//Redirect to the users image page.
					redirectexit('?action=imagenes&usuario=' . $context['user']['name']);
				}

		}
		else
		{
			//Update the image properties if no upload has been set
			db_query("UPDATE {$db_prefix}gallery_pic
				SET ID_CAT = $cat, title = '$title', description = '$description' WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);

			//Redirect to the users image page.
redirectexit('?action=imagenes&usuario=' . $context['user']['name']);
		}

	}
	else
		fatal_error($txt['gallery_no_edit_image']);


}

function DeletePicture()
{
	global $context, $mbname, $txt,$ID_MEMBER,$db_prefix;

	is_not_guest();

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	//Check if the user owns the picture or is admin
    $dbresult = db_query("SELECT p.ID_PICTURE, p.width, p.height, p.allowcomments, p.ID_CAT, p.keywords, p.commenttotal, p.filesize, p.filename, p.views, p.title, p.ID_MEMBER, m.memberName, m.realName, p.date, p.description 
    FROM {$db_prefix}gallery_pic as p
    LEFT JOIN {$db_prefix}members AS m ON (m.ID_MEMBER = p.ID_MEMBER) WHERE ID_PICTURE = $id  LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);

	//Gallery picture information
	$context['gallery_pic'] = array(
		'ID_PICTURE' => $row['ID_PICTURE'],
		'ID_MEMBER' => $row['ID_MEMBER'],
		'commenttotal' => $row['commenttotal'],
		'views' => $row['views'],
		'title' => $row['title'],
		'description' => $row['description'],
		'filesize' => round($row['filesize']  / 1024, 2),
		'filename' => $row['filename'],
		'thumbfilename' => $row['thumbfilename'],
		'width' => $row['width'],
		'height' => $row['height'],
		'allowcomments' => $row['allowcomments'],
		'ID_CAT' => $row['ID_CAT'],
		'date' => timeformat($row['date']),
		'keywords' => $row['keywords'],
		'memberName' => $row['memberName'],
		'realName' => $row['realName'],
	);
	mysql_free_result($dbresult);

	if(AllowedTo('smfgallery_manage') || (AllowedTo('smfgallery_delete') && $ID_MEMBER == $context['gallery_pic']['ID_MEMBER']))
	{
		$context['page_title'] = $txt[18];
		$context['sub_template']  = 'delete_picture';

	}
	else
	{
		fatal_error($txt['gallery_error_nodelete_permission']);
	}





}
function DeletePicture2()
{
	global $context, $txt, $ID_MEMBER,$scripturl, $boarddir, $db_prefix,$modSettings;

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	//Check if the user owns the picture or is admin
    $dbresult = db_query("SELECT p.ID_PICTURE, p.filename, p.ID_MEMBER FROM {$db_prefix}gallery_pic as p WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	$memID = $row['ID_MEMBER'];
	mysql_free_result($dbresult);

	if(AllowedTo('smfgallery_manage') || (AllowedTo('smfgallery_delete') && $ID_MEMBER == $memID))
	{

		if(empty($modSettings['gallery_path']))
		{
			$modSettings['gallery_path'] = $boarddir . '/gallery/';
		}

		//Delete Large image
		@unlink($modSettings['gallery_path'] . $row['filename']);
		//Delete Thumbnail
		@unlink($modSettings['gallery_path'] . $row['thumbfilename']);

		//Delete all the picture related db entries

		db_query("DELETE FROM {$db_prefix}gallery_comment WHERE ID_PICTURE  = $id LIMIT 1", __FILE__, __LINE__);
		//db_query("DELETE FROM {$db_prefix}gallery_rating WHERE ID_PICTURE  = $id LIMIT 1", __FILE__, __LINE__);
		db_query("DELETE FROM {$db_prefix}gallery_report WHERE ID_PICTURE  = $id LIMIT 1", __FILE__, __LINE__);

		//Delete the picture
		db_query("DELETE FROM {$db_prefix}gallery_pic WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
			
		// Update the SMF Shop Points
			if (isset($modSettings['shopVersion']))
 				db_query("UPDATE {$db_prefix}members
				 	SET money = money - " . $modSettings['gallery_shop_picadd'] . "
				 	WHERE ID_MEMBER = {$memID}
				 	LIMIT 1", __FILE__, __LINE__);
 				
		//Redirect to the users image page.
redirectexit('' . $scripturl . '?action=imagenes&usuario=' . $context['user']['name']);

	}
	else
	{
		fatal_error($txt['gallery_error_nodelete_permission']);
	}
}
function dpuntos()
{
	global $context, $mbname, $txt, $db_prefix;

	$context['sub_template']  = 'dpuntos';
	$context['page_title'] = $txt[18];
	
			global $scripturl, $context, $txt, $db_prefix, $ID_MEMBER, $modSettings, $boardurl, $memberContext, $themeUser;

	$cantidad = (float) $_GET['cantidad'];
//By cdloz
//$db = mysql_query("
//                SELECT *
//                FROM {$db_prefix}members AS m
//                WHERE ".$context['user']['id']." = m.ID_MEMBER");
//while ($grup = mysql_fetch_assoc($db))
//{
//$context['money'] = $grup['money'];
//}
//mysql_free_result($db);
    if ($cantidad < 0) 
		fatal_error($txt['gallery_point_positive'], false);
	elseif ($cantidad == 0)
		fatal_error($txt['gallery_quantity_validated'], false);


	$id = (int) $_REQUEST['id'];
	$user = $_GET['user'];
	$userincr = $context['user']['id'];
	if($id == '')
	fatal_error($txt['gallery_error_no_pic_selected'], false);
	if($cantidad == '')
	fatal_error($txt['gallery_quantity_specify'], v);
	if($user == '')
	fatal_error($txt['gallery_specify_user'], false);
	if($user == $context['user']['id'])
	fatal_error($txt['gallery_no_point_images']);
	$errorr = mysql_query("
				SELECT *
				FROM {$db_prefix}gallery_cat
				WHERE id_user = $userincr AND id_img = {$id}
				LIMIT 1");
	$yadio = mysql_num_rows($errorr) != 0 ? true : false;
	mysql_free_result($errorr);
	 	if ($yadio)
    	fatal_error($txt['gallery_no_point_retry'], false);
      	if($cantidad > 10)
    	fatal_error($txt['gallery_no_point_ten'], false);

	//Cuantos puntos me quedan
		$request1 = db_query("SELECT points
					 FROM {$db_prefix}points_per_day
					 WHERE ID_MEMBER = {$ID_MEMBER}", __FILE__, __LINE__);
		$row1 = mysql_fetch_assoc($request1);
		mysql_free_result($request1);
		if ( $cantidad > $row1['points'] )
		fatal_error('No tienes puntos suficientes. Debes esperar hasta ma&ntilde;ana.', false);
		
			//Quita los puntos del dia
			 db_query("UPDATE {$db_prefix}points_per_day
				 SET points = points - {$cantidad}
				 WHERE ID_MEMBER = $userincr
				 LIMIT 1", __FILE__, __LINE__);
			mysql_query("
				UPDATE {$db_prefix}members
				SET money = money + {$cantidad}
				WHERE ID_MEMBER = {$user}
				LIMIT 1");
		   mysql_query("
				UPDATE {$db_prefix}gallery_pic
				SET puntos = puntos + {$cantidad}
				WHERE ID_PICTURE = {$id}
				LIMIT 1");
			mysql_query("INSERT INTO {$db_prefix}gallery_cat (id_img,id_user)
values('$id', '$userincr')");
	Header("Location: $scripturl?action=imagenes;sa=dpuntos2;id=$id;cant=$cantidad");
}
function dpuntos2()
{	global $context, $mbname, $txt, $db_prefix;

	$context['sub_template']  = 'dpuntos2';
	$context['page_title'] = $txt[18];
}
function AddComment(){}
function AddComment2()
{
	global $context, $scripturl, $db_prefix, $ID_MEMBER, $txt, $modSettings;
	isAllowedTo('smfgallery_comment');
	$comment = htmlspecialchars($_REQUEST['cuerpo_comment']);
	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);
    $dbresult = db_query("SELECT p.allowcomments FROM {$db_prefix}gallery_pic as p WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult);
	mysql_free_result($dbresult);
   if($comment == '')
	fatal_error($txt['gallery_error_no_comment'],false);
	$commentdate = time();
	db_query("INSERT INTO {$db_prefix}gallery_comment
	(ID_MEMBER, comment, date, ID_PICTURE)
	VALUES ($ID_MEMBER,'$comment', $commentdate,$id)", __FILE__, __LINE__);
	if (isset($modSettings['shopVersion']))
	db_query("UPDATE {$db_prefix}gallery_pic
	SET commenttotal = commenttotal + 1 WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);
    redirectexit('' . $scripturl . '/?action=imagenes;sa=ver;id=' . $id);

}
function DeleteComment()
{	global $context,$db_prefix, $txt,$scripturl, $modSettings;
	is_not_guest();
	isAllowedTo('smfgallery_manage');
	if($_POST['campos'] == '')
	fatal_error($txt['gallery_error_no_com_selected']);
    $idimg=$_POST['idimg'];
	if(!empty($_POST['campos'])) {
	$aLista=array_keys($_POST['campos']);
	$total=count($aLista);
	db_query("DELETE FROM {$db_prefix}gallery_comment WHERE ID_COMMENT IN (".implode(',',$aLista).")", __FILE__, __LINE__);

		
	$dbresult = db_query("UPDATE {$db_prefix}gallery_pic
	SET commenttotal = commenttotal - $total WHERE ID_PICTURE = $idimg LIMIT 1", __FILE__, __LINE__);
		}
	redirectexit('' . $scripturl . '/?action=imagenes;sa=ver;id=' . $idimg);
}

function AdminSettings()
{
	global $context, $mbname, $txt;
	isAllowedTo('smfgallery_manage');

	adminIndex('gallery_settings');
	$context['page_title'] = $txt[18];


	$context['sub_template']  = 'settings';

}
function AdminSettings2()
{
	global $scripturl;
	isAllowedTo('smfgallery_manage');


	
	// Shop settings
	$gallery_shop_picadd = (int) $_REQUEST['gallery_shop_picadd'];
	
	
	// Image Linking codes
	$gallery_set_showcode_bbc_image = isset($_REQUEST['gallery_set_showcode_bbc_image']);
	$gallery_set_showcode_directlink = isset($_REQUEST['gallery_set_showcode_directlink']);
	$gallery_set_showcode_htmllink = isset($_REQUEST['gallery_set_showcode_htmllink']);
	

	updateSettings(
	array('gallery_shop_picadd' => $gallery_shop_picadd,
	
	'gallery_set_showcode_bbc_image' => $gallery_set_showcode_bbc_image,
	'gallery_set_showcode_directlink' => $gallery_set_showcode_directlink,
	'gallery_set_showcode_htmllink' => $gallery_set_showcode_htmllink,
	
	));

	redirectexit('action=imagenes;sa=adminset');

}
function AdminCats()
{
	global $context, $mbname, $txt;
	isAllowedTo('smfgallery_manage');

	$context['page_title'] = $txt[18];

	adminIndex('gallery_settings');

	$context['sub_template']  = 'manage_cats';
}
function CatUp()
{
	global $db_prefix,$scripturl;
	// Check if they are allowed to manage cats
	isAllowedTo('smfgallery_manage');

	// Get the cat id
	@$cat = (int) $_REQUEST['cat'];
	ReOrderCats($cat);
	
	//Check if there is a category above it
	//First get our row order
	$dbresult1 = db_query("SELECT roworder FROM {$db_prefix}gallery_cat WHERE ID_CAT = $cat", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult1);
	$oldrow = $row['roworder'];
	$o = $row['roworder'];
	$o--;

	mysql_free_result($dbresult1);
	$dbresult = db_query("SELECT ID_CAT, roworder FROM {$db_prefix}gallery_cat WHERE roworder = $o", __FILE__, __LINE__);
	if(db_affected_rows()== 0)
		fatal_error($txt['gallery_no_category'],false);
	$row2 = mysql_fetch_assoc($dbresult);


	// Swap the order Id's
	db_query("UPDATE {$db_prefix}gallery_cat
		SET roworder = $oldrow WHERE ID_CAT = " .$row2['ID_CAT'], __FILE__, __LINE__);

	db_query("UPDATE {$db_prefix}gallery_cat
		SET roworder = $o WHERE ID_CAT = $cat", __FILE__, __LINE__);


	mysql_free_result($dbresult);

	// Redirect to index to view cats
	redirectexit('action=imagenes');
}
function CatDown()
{
	global $db_prefix,$scripturl;

	// Check if they are allowed to manage cats
	isAllowedTo('smfgallery_manage');

	// Get the cat id
	@$cat = (int) $_REQUEST['cat'];
	ReOrderCats($cat);
	// Check if there is a category below it
	// First get our row order
	$dbresult1 = db_query("SELECT roworder FROM {$db_prefix}gallery_cat WHERE ID_CAT = $cat LIMIT 1", __FILE__, __LINE__);
	$row = mysql_fetch_assoc($dbresult1);
	$oldrow = $row['roworder'];
	$o = $row['roworder'];
	$o++;

	mysql_free_result($dbresult1);
	$dbresult = db_query("SELECT ID_CAT, roworder FROM {$db_prefix}gallery_cat WHERE roworder = $o", __FILE__, __LINE__);
	if(db_affected_rows()== 0)
		fatal_error($txt['gallery_no_category2'],false);
	$row2 = mysql_fetch_assoc($dbresult);


	//Swap the order Id's
	db_query("UPDATE {$db_prefix}gallery_cat
		SET roworder = $oldrow WHERE ID_CAT = " .$row2['ID_CAT'], __FILE__, __LINE__);

	db_query("UPDATE {$db_prefix}gallery_cat
		SET roworder = $o WHERE ID_CAT = $cat", __FILE__, __LINE__);


	mysql_free_result($dbresult);


	//Redirect to index to view cats
	redirectexit('action=imagenes');
}
function MyImages()
{
	global $context, $mbname, $txt, $db_prefix;

	@$cat = (int) $_REQUEST['cat'];
	if($cat)
	{
		//Get category name
		$dbresult1 = db_query("SELECT ID_CAT, title, roworder, description, image FROM {$db_prefix}gallery_cat WHERE ID_CAT = $cat LIMIT 1", __FILE__, __LINE__);
		$row1 = mysql_fetch_assoc($dbresult1);
		$context['gallery_cat_name'] = $row1['title'];
		mysql_free_result($dbresult1);


		$context['page_title'] = $txt[18];


		if (!empty($modSettings['gallery_who_viewing']))
		{
			$context['can_moderate_forum'] = allowedTo('moderate_forum');

			//Mainly to tell which version of SMF either 1.1 or 1.0.x
			if(function_exists('parse_bbc'))
			{
				//SMF 1.1
				//Taken from Display.php
				// Start out with no one at all viewing it.
				$context['view_members'] = array();
				$context['view_members_list'] = array();
				$context['view_num_hidden'] = 0;

				// Search for members who have this picture id set in their GET data.
				$request = db_query("
					SELECT
						lo.ID_MEMBER, lo.logTime, mem.realName, mem.memberName, mem.showOnline,
						mg.onlineColor, mg.ID_GROUP, mg.groupName
					FROM {$db_prefix}log_online AS lo
						LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
						LEFT JOIN {$db_prefix}membergroups AS mg ON (mg.ID_GROUP = IF(mem.ID_GROUP = 0, mem.ID_POST_GROUP, mem.ID_GROUP))
					WHERE INSTR(lo.url, 's:7:\"gallery\";s:3:\"cat\";s:1:\"$cat\";') OR lo.session = '" . ($user_info['is_guest'] ? 'ip' . $user_info['ip'] : session_id()) . "'", __FILE__, __LINE__);
				while ($row = mysql_fetch_assoc($request))
				{
					if (empty($row['ID_MEMBER']))
						continue;

					if (!empty($row['onlineColor']))
						$link = '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '" style="color: ' . $row['onlineColor'] . ';">' . $row['realName'] . '</a>';
					else
						$link = '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';

					$is_buddy = in_array($row['ID_MEMBER'], $user_info['buddies']);
					if ($is_buddy)
						$link = '<b>' . $link . '</b>';

					// Add them both to the list and to the more detailed list.
					if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
						$context['view_members_list'][$row['logTime'] . $row['memberName']] = empty($row['showOnline']) ? '<i>' . $link . '</i>' : $link;
					$context['view_members'][$row['logTime'] . $row['memberName']] = array(
						'id' => $row['ID_MEMBER'],
						'username' => $row['memberName'],
						'name' => $row['realName'],
						'group' => $row['ID_GROUP'],
						'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
						'link' => $link,
						'is_buddy' => $is_buddy,
						'hidden' => empty($row['showOnline']),
					);

					if (empty($row['showOnline']))
						$context['view_num_hidden']++;
				}

				// The number of guests is equal to the rows minus the ones we actually used ;).
				$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
				mysql_free_result($request);

				// Sort the list.
				krsort($context['view_members']);
				krsort($context['view_members_list']);
			}
			else
			{
				//1.0.8 Who's viewing picture
				// Start out with no one at all viewing it.
				$context['view_members'] = array();
				$context['view_members_list'] = array();
				$context['view_num_hidden'] = 0;

				// Search for members who have this topic set in their GET data.
				$request = db_query("
					SELECT mem.ID_MEMBER, IFNULL(mem.realName, 0) AS realName, mem.showOnline
					FROM {$db_prefix}log_online AS lo
						LEFT JOIN {$db_prefix}members AS mem ON (mem.ID_MEMBER = lo.ID_MEMBER)
					WHERE INSTR(lo.url, 's:7:\"gallery\";s:3:\"cat\";s:1:\"$cat\";')", __FILE__, __LINE__);
				while ($row = mysql_fetch_assoc($request))
					if (!empty($row['ID_MEMBER']))
					{
						// Add them both to the list and to the more detailed list.
						if (!empty($row['showOnline']) || allowedTo('moderate_forum'))
							$context['view_members_list'][] = empty($row['showOnline']) ? '<i><a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a></i>' : '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>';
						$context['view_members'][] = array(
							'id' => $row['ID_MEMBER'],
							'name' => $row['realName'],
							'href' => $scripturl . '?action=profile;u=' . $row['ID_MEMBER'],
							'link' => '<a href="' . $scripturl . '?action=profile;u=' . $row['ID_MEMBER'] . '">' . $row['realName'] . '</a>',
							'hidden' => empty($row['showOnline']),
						);

						if (empty($row['showOnline']))
							$context['view_num_hidden']++;
					}

				// The number of guests is equal to the rows minus the ones we actually used ;).
				$context['view_num_guests'] = mysql_num_rows($request) - count($context['view_members']);
				mysql_free_result($request);
			}
		}


	}
	else
		$context['page_title'] = $txt[18];
}
function ApproveList()
{
	global $context, $mbname, $txt;

	isAllowedTo('smfgallery_manage');

	$context['page_title'] = $txt[18];

	adminIndex('gallery_settings');

	$context['sub_template']  = 'approvelist';
}
function ApprovePicture()
{
	global $scripturl, $db_prefix, $txt;
	isAllowedTo('smfgallery_manage');

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	//Update the approval
	db_query("UPDATE {$db_prefix}gallery_pic SET approved = 1 WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);


	//Redirect to approval list
	redirectexit('action=imagenes;sa=approvelist');

}
function UnApprovePicture()
{
	global $scripturl, $db_prefix, $txt;
	isAllowedTo('smfgallery_manage');

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_pic_selected']);

	//Update the approval
	 db_query("UPDATE {$db_prefix}gallery_pic SET approved = 0 WHERE ID_PICTURE = $id LIMIT 1", __FILE__, __LINE__);

	//Redirect to approval list
	redirectexit('action=imagenes;sa=approvelist');
}
function ReportList()
{
	global $context, $mbname, $txt;

	isAllowedTo('smfgallery_manage');

	$context['page_title'] = $txt[18];

	adminIndex('gallery_settings');

	$context['sub_template']  = 'reportlist';
}
function DeleteReport()
{
	global $scripturl, $db_prefix, $txt;
	//Check the permission
	isAllowedTo('smfgallery_manage');

	$id = (int) $_REQUEST['id'];
	if($id == '')
		fatal_error($txt['gallery_error_no_report_selected']);

	db_query("DELETE FROM {$db_prefix}gallery_report WHERE ID = $id LIMIT 1", __FILE__, __LINE__);

	//Redirect to redirect list
	redirectexit('action=imagenes;sa=reportlist');
}
function Search()
{
	global $context, $mbname, $txt;

	//Is the user allowed to view the gallery?
	isAllowedTo('smfgallery_view');


	$context['sub_template']  = 'search';

	$context['page_title'] = $txt[18];
	
}
function Search2()
{
	global $context, $mbname, $txt, $db_prefix;

	//Is the user allowed to view the gallery?
	isAllowedTo('smfgallery_view');

	//Check if keyword search was selected
	@$keyword =  htmlspecialchars($_REQUEST['key'],ENT_QUOTES);
	if($keyword == '')
	{
		//Probably a normal Search
		$searchfor =  htmlspecialchars($_REQUEST['searchfor'],ENT_QUOTES);
		if($searchfor == '')
			fatal_error($txt['gallery_error_no_search'],false);

		if(strlen($searchfor) <= 3)
			fatal_error($txt['gallery_error_search_small'],false);

		//Check the search options
		@$searchkeywords = $_REQUEST['searchkeywords'];
		@$searchtitle = $_REQUEST['searchtitle'];
		@$searchdescription = $_REQUEST['searchdescription'];

		$s1 = 1;
		$searchquery = '';
		if($searchtitle)
			$searchquery = "p.title LIKE '%$searchfor%' ";
		else
			$s1 = 0;

		$s2 = 1;
		if($searchdescription)
		{
			if($s1 == 1)
				$searchquery = "p.title LIKE '%$searchfor%' OR p.description LIKE '%$searchfor%'";
			else
				$searchquery = "p.description LIKE '%$searchfor%'";
		}
		else
			$s2 = 0;

		if($searchkeywords)
		{
			if($s1 == 1 || $s2 == 1)
				$searchquery .= " OR p.keywords LIKE '%$searchfor%'";
			else
				$searchquery = "p.keywords LIKE '%$searchfor%'";
		}


		if($searchquery == '')
			$searchquery = "p.title LIKE '%$searchfor%' ";

		$context['gallery_search_query'] = $searchquery;



		$context['gallery_search'] = $searchfor;
	}
	else
	{
		//Search for the keyword


		//Debating if I should add string length check for keywords...
		//if(strlen($keyword) <= 3)
			//fatal_error($txt['gallery_error_search_small']);

		$context['gallery_search'] = $keyword;

		$context['gallery_search_query'] = "p.keywords LIKE '%$keyword%'";
	}

	$context['sub_template']  = 'search_results';

	$context['page_title'] = $txt[18];
}

function generateThumbnail($src_file, $dest_file, $width = 120, $height = 78)
{
	global $gd2, $db_prefix;
	//Inspired by createThumbnail from SMF 1.1

	//Check if Image Magik is installed
	$IM_Installed = false;//function_exists('NewMagickWand');

	//Check if GD is installed
	$GD_Installed = function_exists('imagecreate');

	//If not Image Magick or GD installed return false
	if ($IM_Installed == false && $GD_Installed == false)
		return false;

	//Check if GD2 is installed if we are lucky. (used by resizeImage)
	if(!$IM_Installed)
		$gd2 =  function_exists('imagegd2');

	//Increase the allowed time in case of large image
	@ini_set('max_execution_time', '300');
	@ini_set('memory_limit', '32M');

	//Image/Media type extensions
	$extensions = array('1' => 'gif', '2' => 'jpeg','3' => 'png','4' => 'swf','5' => 'psd',
	'6' => 'bmp','7' => 'tiff','8' => 'tiff','9' => 'jpc','10' => 'jp2', '11' => 'jpx',
	'12' => 'jb2','13' => 'swc','14' => 'iff','15' => 'wbmp','16' => 'xbm');

	//Get image size if it is a picture...Mainly need to get format of picture
	$size = getimagesize($src_file);

	//Could not get size information on the picture
	if(empty($size))
		return false;

	//Set the thumbnail flag
	$good = false;
	//Use Image Magik over GD if possible
	if(!$IM_Installed)
	{
		//Use GD Lib

		//Check if the file is a gif and see if it supports imagecreatefromgif which isn't always in GD
		if($extensions[$size[2]] == 'gif' && !function_exists('imagecreatefromgif') && function_exists('imagecreatefrompng'))
		{
			//Use SMF functions by Yamasoft for loading gif
			$img = gif_loadFile($src_file);
			//and converting to a png
			gif_outputAsPng($img, $dest_file);

			if ($image = imagecreatefrompng($dest_file))
			{
				//Get the width and height of the image
				$img_width = imagesx($image);
				$img_height = imagesy($image);
				//Finaly resize the image and give us our thumbnail
				resizeImage($image, $dest_file, $img_width, $img_height, $width, $height);
				//Set flag that thumbnail ok
				$good = true;
			}

		}
		else
		{

			//Use GD's built image create functions for this image.
		 	if(function_exists('imagecreatefrom' . $extensions[$size[2]]))
			{
				$imagecreatefrom = 'imagecreatefrom' . $extensions[$size[2]];
				if ($image = $imagecreatefrom($src_file))
				{
					//Get the width and height of the image
					$img_width = imagesx($image);
					$img_height = imagesy($image);
					//Finaly resize the image and give us our thumbnail
					resizeImage($image, $dest_file, $img_width, $img_height, $width, $height);
					//Set flag that thumbnail ok
					$good = true;
				}
			}
		}

	}
	else
	{
		//Use Image Magik
		$wand = NewMagickWand();
		//Load the image
		@MagickReadImage($wand,$src_file);
		//Resize the image
		@MagickResizeImage($wand, $width, $height, THUMBNAIL_FILTER, THUMBNAIL_BLUR);
		//Set the filename before we write it
		@MagickSetFilename($wand,$dest_file);
		//Write the resized image
		if(MagickWriteImage($wand,$dest_file))
			$good = true;

		//Free resources
		DestroyMagickWand($wand);

		//Wow that was easy! Compare that with the amount of lines for GD!!!!
	}


	//Check if we were able to create the thumbnail
	if($good)
		return true;
	else
	{
		//Delete the file if we failed
		@unlink($dest_file);
		//No thumbnail made :(
		return false;
	}

}
function ReOrderCats($cat)
{
	global $db_prefix;


	$dbresult = db_query("SELECT ID_CAT, roworder FROM {$db_prefix}gallery_cat ORDER BY roworder ASC", __FILE__, __LINE__);
	if(db_affected_rows() != 0)
	{
		$count = 1;
		while($row2 = mysql_fetch_assoc($dbresult))
		{
			db_query("UPDATE {$db_prefix}gallery_cat
			SET roworder = $count WHERE ID_CAT = " . $row2['ID_CAT'], __FILE__, __LINE__);
			$count++;
		}
	}
	mysql_free_result($dbresult);
}
function ReportPicture()
{
	global $context, $mbname, $txt;

	isAllowedTo('smfgallery_report');

	$id = (int) $_REQUEST['id'];
	if (empty($id))
		fatal_error($txt['gallery_error_no_pic_selected']);

	$context['gallery_pic_id'] = $id;

	$context['sub_template']  = 'report_picture';

	$context['page_title'] = '' . $txt['gallery_text_title'] . ' - ' . $txt['gallery_form_reportpicture'];

}

function ReportPicture2()
{
	global $context, $scripturl, $db_prefix, $ID_MEMBER, $txt;

	isAllowedTo('smfgallery_report');

	$comment = htmlspecialchars($_REQUEST['comment'],ENT_QUOTES);
	$id = (int) $_REQUEST['id'];
	if (empty($id))
		fatal_error($txt['gallery_error_no_pic_selected']);

	if (trim($comment) == '')
		fatal_error($txt['gallery_error_no_comment'],false);

	$commentdate = time();

	db_query("INSERT INTO {$db_prefix}gallery_report
			(ID_MEMBER, comment, date, ID_PICTURE)
		VALUES ($ID_MEMBER,'$comment', $commentdate,$id)", __FILE__, __LINE__);

	redirectexit('action=imagenes;sa=ver;id=' . $id);

}
?>