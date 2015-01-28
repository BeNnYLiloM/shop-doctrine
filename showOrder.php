<?php

require_once "main.php";

$orderId = $argv[1];

$result = $entityManager->find('Order', $orderId);
if(!$result){
    echo "ID of the order is not found!\n";
    exit;
}
$orderProducts = explode(",", $result->getOrderProducts());

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

echo "Your order: \n";
for($i = 0; $i <= (count($orderProducts) - 1); $i++){
    if($orderProducts[$i] === ""){
        continue;
    }
    if($products[$i]->getId() == $orderProducts[$i]){
        echo $products[$i]->getName()."\n";
    }
}

echo "Amount of your order: ".$result->getOrderAmount()." rub.\n";