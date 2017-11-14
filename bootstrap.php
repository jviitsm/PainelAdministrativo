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
    'user'     => 'root',/*citycare_web*/
    'password' => '',/*T0*oO3HfwSzv*/
    'dbname'   => 'citycare_db',
    'charset' => 'utf8',
);
$cacheDir = dirname(__FILE__).'/cache';
if (!is_dir($cacheDir)) {
    mkdir($cacheDir);
}


$isDevMode = true;


$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode,$cacheDir);
$entityManager = EntityManager::create($dbParams, $config);
$container['em'] = $entityManager;