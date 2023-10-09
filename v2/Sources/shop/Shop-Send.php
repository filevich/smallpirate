<?php


if (!defined('SMF'))
	die('Error');

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
    if ($context['user']['money'] < $amount)
		$context['shop_buy_message'] = $txt['shop_dont_have_much'];
	elseif ($amount < 0) 
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
fatal_error('Usuarios Leecher no pueden dar puntos.', false);
$errorr = db_query("
				SELECT *
				FROM cw_puntos
				WHERE
				id_member = $ID_MEMBER AND
				id_post = $topic
				LIMIT 1", __FILE__, __LINE__);
	$yadio = mysql_num_rows($errorr) != 0 ? true : false;
	mysql_free_result($errorr);

     	if ($yadio)
    	fatal_error('Ya has dado puntos a este post.', false);
      	if($amount > 10)
    	fatal_error('No puedes dar m&aacute;s de 10 puntos.', false);
		if($creador == $context['user']['id'])
		fatal_error('No puedes dar puntos a tus post.', false);
		
			// Aun no está acabado, esto mirará si ha dado los puntos que podia por dia
			// $requesto = db_query("
			//	SELECT cantidad,fecha
			//	FROM cw_puntos
			//	WHERE ID_member = $context['user']['id']", __FILE__, __LINE__);
			//	$puntosdeldia = mysql_num_rows($requesto);
			//	mysql_free_result($requesto);
			//	$cantidad=$row['cantidad'];
			//	$fechafea=$row['fecha'];
			//	$fechahoy=date("d/m/Y",time());
			//	$tiabuena=date("d/m/Y",$fechafea);
			//	if($fechahoy==$tiabuena and $cantidad==34){
			//	fatal_error('Gilipollas no puedes dar más por hoy.');
			//	}
		
		// Query que quita el dinero, si lo borras tal y como esta el script ahora lo que pasa es que los users tienen saldo..
		// ilimitado
			db_query("
				UPDATE {$db_prefix}members
				SET money = money - {$amount}
				WHERE ID_MEMBER = {$ID_MEMBER}
				LIMIT 1", __FILE__, __LINE__);

			// Dar el dinero
			db_query("
				UPDATE {$db_prefix}members
				SET money = money + {$amount}
				WHERE ID_MEMBER = {$row['ID_MEMBER_STARTED']}
				LIMIT 1", __FILE__, __LINE__);
				

		    db_query("
				UPDATE {$db_prefix}topics
				SET puntos = puntos + {$amount}
				WHERE ID_TOPIC = '$topic'
				LIMIT 1", __FILE__, __LINE__);
						
	       db_query("INSERT INTO cw_puntos (id_post,id_member,cantidad)
values('$topic', '$ID_MEMBER', '$amount')", __FILE__, __LINE__);
	
	 $request = db_query("
SELECT ID_TOPIC, subject
FROM smf_messages
WHERE ID_TOPIC = $topic
ORDER BY subject ASC
LIMIT 1", __FILE__, __LINE__);

	while ($row = mysql_fetch_assoc($request))
{
		$context['shop_buy_message'] = sprintf('<span class="size11">'.$amount.' Puntos agregados correctamente a "<b>'.$row['subject'].'</b>"</span>');
		
				}
	mysql_free_result($request);
						}
	
	}
	$context['shop_do'] = 'sendmoney';
	$context['page_title'] = $txt['shop'] . '' . $txt['shop_send_money'];
	$context['sub_template'] = 'message';

} 	
?>
