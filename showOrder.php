<?php

require_once "main.php";

if(count($argv) == 1){
    $orders = $entityManager->getRepository('Order')->getAllOrders();
    foreach($orders as $entity) {
        echo 'ID of order: '.$entity->getId().'. Amount of order: '.$entity->getTotal()."\n";
    }
} elseif(count($argv) == 2) {
    $orderId = $argv[1];

    $order = $entityManager->getRepository('Order')->getOneOrder($orderId);
    if(!$order){
        echo "ID of the order is not found!\n";
        die;
    }
    foreach ($order as $entity) {
        echo "ID of your order: ".$entity->getId().". Amount of your order: ".$entity->getTotal()."\n";
    }
}