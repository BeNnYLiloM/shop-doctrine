<?php

require_once 'main.php';

$orderId = $argv[1];

if($cart = $entityManager->find('Order', $orderId)) {
    $dql = "SELECT o FROM OrderProduct o WHERE o.order = " . $orderId;
    $query = $entityManager->createQuery($dql);
    $result = $query->getResult();

    echo "Your list of products:\n";
    foreach ($result as $orderProduct) {
        echo $orderProduct->getId() . " - " . $orderProduct->getProduct()->getName() . "\n";
    }
} else {
    echo "ID does not exist.\n";
    die;
}