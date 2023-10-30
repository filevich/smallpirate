<?php
if (!defined('SMF'))
	die('Error');
	
function monitor()
{
	global $settings, $user_info, $language, $context, $txt, $db_prefix;
	
	$idmember = $context['user']['id'];

//monitor Últimos comentarios de tus posts

$request = db_query("
SELECT j.memberName ,m.subject, m.ID_TOPIC, t.ID_TOPIC, t.ID_BOARD, t.puntos, b.name AS bname, m.ID_MEMBER, c.fecha, c.comentario, c.id_coment
FROM (smf_topics AS t, smf_messages AS m, smf_boards AS b, {$db_prefix}comentarios AS c, smf_members as j)
WHERE t.ID_TOPIC = c.id_post
AND c.id_post = m.ID_TOPIC
AND t.ID_BOARD = b.ID_BOARD
AND m.ID_MEMBER = $idmember
AND j.ID_MEMBER = c.id_user
ORDER BY m.ID_TOPIC DESC, c.id_coment DESC
LIMIT 20
", __FILE__, __LINE__);
$context['monitorcom'] = array();
while ($row = mysql_fetch_assoc($request))
$context['monitorcom'][] = array(
'titulo' => $row['subject'],
'puntos' => $row['puntos'],
'id' => $row['ID_TOPIC'],
'bname' => $row['bname'],
'ID_BOARD' => $row['ID_BOARD'],
'comentario' => $row['comentario'],
'fecha' => $row['fecha'],
'user' => $row['memberName'],
'id_coment' => $row['id_coment'],
);
mysql_free_result($request);

//monitor mis posts en favoritos
$request = db_query("
SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.ID_BOARD, t.puntos, b.name AS bname, m.ID_MEMBER, c.ID_TOPIC, c.ID_MEMBER as cmember, c.id, r.ID_MEMBER, r.realName
FROM (smf_topics AS t, smf_messages AS m, smf_boards AS b, smf_bookmarks AS c, smf_members AS r)
WHERE t.ID_TOPIC = c.ID_TOPIC
AND c.ID_TOPIC = m.ID_TOPIC
AND t.ID_BOARD = b.ID_BOARD
AND m.ID_MEMBER = $idmember
AND r.ID_MEMBER = c.ID_MEMBER
ORDER BY c.id DESC
LIMIT 20
", __FILE__, __LINE__);
$context['monitorfav'] = array();
while ($row = mysql_fetch_assoc($request))
$context['monitorfav'][] = array(
'titulo' => $row['subject'],
'puntos' => $row['puntos'],
'ID_TOPIC' => $row['ID_TOPIC'],
'cmember' => $row['cmember'],
'bname' => $row['bname'],
'ID_BOARD' => $row['ID_BOARD'],
'id' => $row['id'],
'realName' => $row['realName'],
);
mysql_free_result($request);

//Últimos comentarios de tus imágenes

$request = db_query("
SELECT p.ID_PICTURE, p.ID_MEMBER, p.title, p.puntos, g.ID_PICTURE, g.ID_COMMENT, g.comment, g.date
FROM (smf_gallery_comment AS g, smf_gallery_pic AS p)
WHERE p.ID_MEMBER = $idmember
AND p.ID_PICTURE = g.ID_PICTURE
ORDER BY g.ID_COMMENT DESC
LIMIT 20
", __FILE__, __LINE__);
$context['monitorimg'] = array();
while ($row = mysql_fetch_assoc($request))
$context['monitorimg'][] = array(
'ID_PICTURE' => $row['ID_PICTURE'],
'ID_COMMENT' => $row['ID_COMMENT'],
'comment' => $row['comment'],
'date' => $row['date'],
'title' => $row['title'],
'puntos' => $row['puntos'],
);
mysql_free_result($request);

//monitorpun

$request = db_query("
SELECT m.subject, m.ID_TOPIC, t.ID_TOPIC, t.ID_BOARD, t.puntos, b.name AS bname, m.ID_MEMBER, c.id_post, c.id_member as cmember, c.id, c.amount, r.ID_MEMBER, r.realName
FROM (smf_topics AS t, smf_messages AS m, smf_boards AS b, {$db_prefix}puntos AS c, smf_members AS r)
WHERE t.ID_TOPIC = c.id_post
AND c.id_post = m.ID_TOPIC
AND t.ID_BOARD = b.ID_BOARD
AND m.ID_MEMBER = $idmember
AND r.ID_MEMBER = c.id_member
ORDER BY c.id DESC
LIMIT 7
", __FILE__, __LINE__);
$context['monitorpun'] = array();
while ($row = mysql_fetch_assoc($request))
$context['monitorpun'][] = array(
'titulo' => $row['subject'],
'puntos' => $row['puntos'],
'ID_TOPIC' => $row['ID_TOPIC'],
'cmember' => $row['cmember'],
'bname' => $row['bname'],
'ID_BOARD' => $row['ID_BOARD'],
'id' => $row['id'],
'amount' => $row['amount'],
'realName' => $row['realName'],
);
mysql_free_result($request);
	
	//Titulo
        loadlanguage('Monitor');
	$context['page_title'] = $txt['monitor_title'];
	
        //Cargo plantilla estandar
	loadTemplate('Monitor');
	
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