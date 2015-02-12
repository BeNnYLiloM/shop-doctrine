<?php

use Doctrine\ORM\Events;

require_once "main.php";

//$productId = $argv[1];
//$amountProduct = $argv[2];
//
//$product = $entityManager->find('Product', $productId);
//
//$order = new Order();
//$order->setIdProduct($productId);
//$order->addProduct($product);
//$order->setAmount($amountProduct);
//
//$entityManager->persist($order);
//$entityManager->flush();

$userId = $argv[1];
$orderProduct = $argv[2];
$amount = $argv[3];

$user = $entityManager->find('User', $userId);
$product = $entityManager->find('Product', $orderProduct);

$order = new UserOrder();
$order->setAmount($argv[3]);
$order->setTotal($product->getPrice());
$order->setUserId($user);
$order->setProduct($product);

$entityManager->persist($order);
$entityManager->flush();

echo "Successfully!\n";