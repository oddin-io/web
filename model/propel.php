<?php

$dbConfig = parse_url(getenv("DATABASE_URL"));

$dbName = ltrim($dbConfig["path"],"/");
$host = $dbConfig["host"];
$port = $dbConfig["port"];
$user = $dbConfig["user"];
$password = $dbConfig["pass"];

return [
    "propel" => [
        "database" => [
            "connections" =>[
                "default" => [
                    "adapter" => "pgsql",
                    "settings" => [
                        "charset" => "utf8",
                        "queries" => [
                            "utf8" => "SET NAMES 'UTF8'"
                        ]
                    ],
                    "classname" => "Propel\\Runtime\\Connection\\ConnectionWrapper",
                    "dsn" => "pgsql:host={$host} port={$port} dbname={$dbName}",
                    "user" => $user,
                    "password" => $password
                ]
            ]
        ],
        "runtime" => [
            "defaultConnection" => "default",
            "connections" => ["default"]
        ]
    ]
];
