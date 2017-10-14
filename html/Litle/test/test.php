<?php
require_once realpath(dirname(__FILE__)) . '/../lib/LitleOnline.php';

#Sale
$sale_info = array(
         'orderId' => '1',
                      'id'=> '456',
'amount' => '10010',
'orderSource'=>'ecommerce',
'billToAddress'=>array(
'name' => 'John Smith',
'addressLine1' => '1 Main St.',
'city' => 'Burlington',
'state' => 'MA',
'zip' => '01803-3747',
'country' => 'US'),
'card'=>array(
'number' =>'5112010000000003',
'expDate' => '0112',
'cardValidationNum' => '349',
'type' => 'MC')
);

$initilaize = new LitleOnlineRequest();
$saleResponse = $initilaize->saleRequest($sale_info);
