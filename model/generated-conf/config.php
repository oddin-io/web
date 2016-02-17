<?php
$dbConfig = parse_url(getenv("DATABASE_URL"));

$dbName = ltrim($dbConfig["path"],"/");
$host = $dbConfig["host"];
$port = $dbConfig["port"];
$user = $dbConfig["user"];
$password = $dbConfig["pass"];

$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'pgsql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
    'settings' =>
        array (
            'charset' => 'utf8',
            'queries' =>
                array (
                    'utf8' => 'SET NAMES \'UTF8\'',
                ),
        ),
    'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
    'dsn' => 'pgsql:host='.$host.' port='.$port.' dbname='.$dbName,
    'user' => $user,
    'password' => $password,
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');
