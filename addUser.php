<?php

require_once "main.php";

$name = $argv[1];

$user = new User();
$user->setName($name);

$entityManager->persist($user);
$entityManager->flush();

echo "User by name '".$user->getName()."' has been created.\n";