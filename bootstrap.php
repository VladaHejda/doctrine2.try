<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

// database configuration parameters
$conn = array(
	'driver' => 'pdo_mysql',
	'host' => 'localhost',
	'dbname' => 'doctrine2try',
	'user' => 'root',
	'password' => 'xylofon',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
