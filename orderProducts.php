<?php

require_once "main.php";

$orderProducts = explode(",", $argv[1]);

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

$orderProductsId = "";
$orderProductsPrice = "";

for($i = 0; $i <= (count($orderProducts) - 1); $i++){
    if($products[$i]->getName() == $orderProducts[$i]){
        $productId = $products[$i]->getId();
        $productPrice = $products[$i]->getPrice();
        $orderProductsId .= $productId.",";
        $orderProductsPrice += $productPrice;
    } else {
        echo "Sorry! Product '".$orderProducts[$i]."' is not found.\n";
        exit;
    }
}

$order = new Order();
$order->setOrderProducts($orderProductsId);
$order->setOrderAmount($orderProductsPrice);

$entityManager->persist($order);
$entityManager->flush();

echo "Your order is executed. Id order: ".$order->getId()."\n";