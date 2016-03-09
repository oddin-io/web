<?php
namespace BossEdu\Controller;

use Jacwright\RestServer\RestException;
use Jasny\SSO\Broker;

class AuthCtrl
{
    public static function check()
    {
        $broker = self::attach();
        $user = $broker->getUserInfo();

        if ($user) {
            session_start();
            $_SESSION["id"] = $user["id"];
            return true;
        } else {
            throw new RestException(401, "Unauthorized");
        }
    }

    private function attach()
    {
        $broker = new Broker("http://auth.localhost", "Greg", "7pypoox2pc");
        $broker->attach(true);

        return $broker;
    }
}