<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\Common\EventManager;
use Doctrine\Common\ClassLoader;
use Symfony\Component\Console\Application;

$listenerLoader = new ClassLoader('Listener', 'src');
$listenerLoader->register();
$listenerLoader->loadClass('Listener\FlushListener');

$consoleCommandLoader = new ClassLoader('ConsoleCommand', 'src');
$consoleCommandLoader->register();
$consoleCommandLoader->loadClass('ConsoleCommand\ConsoleCommand');

$repositoryLoader = new ClassLoader('Repository', 'src');
$repositoryLoader->register();
$repositoryLoader->loadClass('Repository\OrderRepository');
$repositoryLoader->loadClass('Repository\OrderProductRepository');

$path = array(__DIR__.'/src/Entity');
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

$application = new Application();
$application->add(new ConsoleCommand());