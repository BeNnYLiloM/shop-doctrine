<?php

require_once "main.php";

$orderProductId = $argv[1];

$orderProduct = $entityManager->find('OrderProduct', $orderProductId);

if($orderProduct){
    $entityManager->remove($orderProduct);
    $entityManager->flush();
} else {
    echo "Product with ID `$orderProductId` was not found in your shopping cart.\n";
    die;
}