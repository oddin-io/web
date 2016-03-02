<?php
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "php://stderr");
error_reporting(E_ALL);

require_once(__DIR__."/../vendor/autoload.php");
require_once(__DIR__."/../model/generated-conf/config.php");

use Jacwright\RestServer\RestServer;

$server = new RestServer("debug");
try {
    $server->addClass("\\BossEdu\\Controller\\AuthCtrl");
    $server->handle();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
