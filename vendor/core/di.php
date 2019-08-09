<?php
use DI\ContainerBuilder;
use Delight\Auth\Auth;
use League\Plates\Engine;


$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Engine::class => function() {
    return new Engine('../app/Views');
    },

    \PDO::class => function() {
        require_once ROOT . '/config/config_db.php';
        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },

    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    }
]);
$container = $containerBuilder->build();
