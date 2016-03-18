<?php
namespace BossEdu\Controller;

use Jacwright\RestServer\RestException;

class ConfigCtrl
{
    public function authorize()
    {
        return AuthCtrl::check();
    }

    /**
     * @url GET /config/app
     */
    public function getAppConfig()
    {
        if (!isset($_GET["callback"])) throw new RestException(400, "Callback isn't set");

        $config = [
            "config" => [
                "urls" => [
                    "rest" => "http://rest.localhost" // getenv("REST_URL")
                    , "auth" => "http://auth.localhost" // getenv("AUTH_URL")
                    , "socket" => "http://localhost:3000"// getenv("SOCKET_URL")
                    , "www" => "http://localhost" //getenv("WWW_URL")
                ]
            ]
        ];

        echo $_GET["callback"] . "(" . json_encode($config, JSON_PRETTY_PRINT) . ");";
    }
}
