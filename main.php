<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Events;
use \FlushListener;

require_once "vendor/autoload.php";

$path = array(__DIR__."/src");
$isDevMode = true;

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'root',
    'dbname' => 'shop-doctrine',
);

$eventManager = new EventManager();

$config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config, $eventManager);