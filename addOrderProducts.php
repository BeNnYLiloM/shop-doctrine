<?php

require_once "main.php";

if(count($argv) == 4) {
    $order = $entityManager->find('Order', $argv[1]);
    if($order){
        $product = $entityManager->find('Product', $argv[2]);

        $cart = new OrderProduct();
        $cart->setOrder($order);
        $cart->setProduct($product);
        $cart->setAmount($argv[3]);

        $entityManager->persist($cart);
        $entityManager->flush();
    } else {
        echo "Order with ID: '$argv[1]' not found!\n";
        die;
    }
} elseif(count($argv) == 3) {
    $newOrder = new Order();

    $entityManager->persist($newOrder);
    $entityManager->flush();

    $orderId = $newOrder->getId();

    $product = $entityManager->find('Product', $argv[1]);

    $cart = new OrderProduct();
    $cart->setOrder($newOrder);
    $cart->setProduct($product);
    $cart->setAmount($argv[2]);

    $entityManager->persist($cart);
    $entityManager->flush();
}