<?php
function formatMoney($money)
{
	global $modSettings;
	$money = (float) $money;
	return $modSettings['shopCurrencyPrefix'] . $money . $modSettings['shopCurrencySuffix'];
}
function getImageList(){}
function getCatList(){}
function recountItems(){}
recountItems();
?>
