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
     * @noAuth
     * @url GET /config/app
     */
    public function getAppConfig()
    {
        if (!isset($_GET["callback"])) throw new RestException(400, "Callback isn't set");

        $config = [
            "config" => [
                "urls" => [
                    "rest" => getenv("REST_URL")
                    , "auth" => getenv("AUTH_URL")
                    , "socket" => getenv("SOCKET_URL")
                    , "www" => getenv("WWW_URL")
                ]
            ]
        ];

        echo $_GET["callback"] . "(" . json_encode($config, JSON_PRETTY_PRINT) . ");";
    }
}
