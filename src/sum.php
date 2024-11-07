<?php


function getLeadsTotalSum($param)
{
	$totalSumClient = [];
	$totalSum = 0;

	foreach ($param as $clientName => $client) {
		$totalSumClient[$clientName] = 0;

		foreach ($client as $item) {
			if ($item['price'] > 0) {
				$totalSumClient[$clientName] += $item['price'];
			}
		}
		$totalSum += $totalSumClient[$clientName];
	}

	return [$totalSumClient,$totalSum];
}