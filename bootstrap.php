<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = Setup::createAnnotationMetadataConfiguration(
    paths: [__DIR__."/app/Models"],
    isDevMode: true,
    proxyDir: null,
    cache: null,
    useSimpleAnnotationReader: false
);

// configuring the database connection for MySQL
$connectionParams = array(
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => 'pdo_mysql',
);

$connection = DriverManager::getConnection($connectionParams, $config);

// obtaining the entity manager
$entityManager = EntityManager::create($connection, $config);

$GLOBALS['em'] = $entityManager;