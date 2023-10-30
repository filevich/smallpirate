<?php


if (!defined('SMF'))
	die('Error');

global $db_prefix, $txt;

if ($_GET['do'] == 'sendmoney')
{
	isAllowedTo('shop_sendmoney');
	$context['shopSendMoneyMember'] = isset($_GET['member']) ?  $_GET['member'] : '';
	$context['shop_do'] = 'sendmoney';
	$context['sub_template'] = 'sendmoney';
}
elseif($_GET['do'] == 'sendmoney2')
{
	isAllowedTo('shop_sendmoney');
	$amount = (float) $_GET['amount'];
    if ($amount < 0) 
		$context['shop_buy_message'] = $txt['shop_give_negative'];
	elseif ($amount == 0)
		$context['shop_buy_message'] = $txt['shop_invalid_send_amount'];
	else {
	
$topic = $_GET['topic'];
		if ($topic)
		{
		
		$result = db_query("
			SELECT *
			FROM smf_topics
			WHERE ID_TOPIC = '$topic'
			LIMIT 1", __FILE__, __LINE__);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
	mysql_free_result($result);
			$creador=$row['ID_MEMBER_STARTED'];
			
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
if ($context['leecher'])
		{$text = '<center><font color="red">Debes subir tu cantidad de mensajes para poder puntuar</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}
$errorr = db_query("
				SELECT *
				FROM {$db_prefix}puntos
				WHERE
				id_member = $ID_MEMBER AND
				id_post = $topic
				LIMIT 1", __FILE__, __LINE__);
	$yadio = mysql_num_rows($errorr) != 0 ? true : false;
	mysql_free_result($errorr);

     	if ($yadio)
		{$text = '<center><font color="red">Ya has dado puntos a este post.</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}
      	if($amount > 10)
		{$text = '<center><font color="red">No puedes dar m&aacute;s de 10 puntos.</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}
    	if($creador == $context['user']['id'])
	    {$text = '<center><font color="red">No puedes dar puntos a tus posts.</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}

	//Cuantos puntos me quedan
		$request1 = db_query("SELECT points
					 FROM {$db_prefix}points_per_day
					 WHERE ID_MEMBER = {$ID_MEMBER}", __FILE__, __LINE__);
		$row1 = mysql_fetch_assoc($request1);
		mysql_free_result($request1);

		if ( $amount > $row1['points'] )
		{$text = '<center><font color="red">No tienes puntos suficientes. Debes esperar hasta ma&ntilde;ana.</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}

		//Quita los puntos del dia
			 db_query("UPDATE {$db_prefix}points_per_day
				 SET points = points - {$amount}
				 WHERE ID_MEMBER = {$ID_MEMBER}
				 LIMIT 1", __FILE__, __LINE__);

			// Dar los puntos al usuario
			db_query("
				UPDATE {$db_prefix}members
				SET money = money + {$amount}
				WHERE ID_MEMBER = {$row['ID_MEMBER_STARTED']}
				LIMIT 1", __FILE__, __LINE__);
				
                        //Dar los puntos al post
                        db_query("
				UPDATE {$db_prefix}topics
				SET puntos = puntos + {$amount}
				WHERE ID_TOPIC = '$topic'
				LIMIT 1", __FILE__, __LINE__);
						
	       db_query("INSERT INTO {$db_prefix}puntos (id_post,id_member,amount)
                         values('$topic', '$ID_MEMBER', '$amount')", __FILE__, __LINE__);
	
	 $request = db_query("
SELECT ID_TOPIC, subject
FROM smf_messages
WHERE ID_TOPIC = $topic
ORDER BY subject ASC
LIMIT 1", __FILE__, __LINE__);

	while ($row = mysql_fetch_assoc($request))
{
		{$text = '<center><font color="green">'.$amount.' puntos agregados correctamente.</font></center>';if(!isset($_REQUEST['ajax'])){ fatal_error($text, false);}else{die($text);}}
		
				}
	mysql_free_result($request);
						}
	
	}
	$context['shop_do'] = 'sendmoney';
	$context['page_title'] = $txt['shop'] . '' . $txt['shop_send_money'];
	$context['sub_template'] = 'message';

} 	
?>
