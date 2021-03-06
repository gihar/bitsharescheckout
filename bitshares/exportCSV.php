<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=exportTransactions.csv');
require 'systemfunctions.php';
$memo = $_REQUEST['memo'];
$order_id = $_REQUEST['order_id'];
$response = verifyOpenOrder($memo, $order_id);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('#', 'Transaction ID', 'Order ID', 'Amount'));
$count = 0;
foreach ($response as $responseOrder) {
	$count++;
	fputcsv($output, array($count, $responseOrder['trx_id'], $responseOrder['order_id'], $responseOrder['amount'].' ' . $responseOrder['asset']));
}
if(count($response) <= 0)
{
	fputcsv($output, array('No transactions found!'));
}
?>