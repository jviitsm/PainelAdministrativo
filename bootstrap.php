<?php
// bootstrap.php
require_once "vendor/autoload.php";


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("/Models/Entity");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host' => 'localhost',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'citycare_db',
);
$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
$container['em'] = $entityManager;