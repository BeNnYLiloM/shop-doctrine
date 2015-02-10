<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Events;

require_once "vendor/autoload.php";
require_once "listeners/FlushListener.php";

$path = array(__DIR__."/src");
$isDevMode = true;

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'shop-doctrine',
);

$eventManager = new EventManager();
$eventManager->addEventListener(array(Events::onFlush), new FlushListener());

$config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config, $eventManager);