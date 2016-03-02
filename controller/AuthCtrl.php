<?php
namespace BossEdu\Controller;

use BossEdu\Model\PersonQuery;
use BossEdu\Model\SomeoneQuery;
use BossEdu\Util\Util;
use Jacwright\RestServer\RestException;
use Mailgun\Mailgun;

class AuthCtrl
{
    public static function check()
    {
        if (!isset($_SESSION)) session_start();

        AuthCtrl::refreshSession();

        if (isset($_SESSION["email"])) {
            $user = SomeoneQuery::create()
                ->filterByEmail($_SESSION["email"])
                ->filterByPassword($_SESSION["password"])
                ->findOne();

            if ($user) {
                return true;
            }
        }

        AuthCtrl::destroySession();
    }

    public static function startSession($persist = false)
    {
        if ($persist) {
            session_set_cookie_params(time() + 3600 * 24 * 60); // 2 Months
        }

        session_start();
    }

    public static function refreshSession()
    {
        if (!isset($_SESSION)) session_start();

        if ($_SESSION["persist"]) {
            $params = session_get_cookie_params();
            setcookie(session_name(), session_id(), time() + 3600 * 24 * 60,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    public static function destroySession()
    {
        if (!isset($_SESSION)) session_start();

        if (isset($_SESSION["id"])) InstructionCtrl::resetCurrentInstruction($_SESSION["id"]);

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    /**
     * @url POST /login
     */
    public function login()
    {
        $user = Util::getPostContents("lower");

        AuthCtrl::startSession($user["persist"] ?? false);

        if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
            if (isset($user["email"]) && isset($user["password"])) {
                $entity = SomeoneQuery::create()
                    ->filterByEmail($user["email"])
                    ->findOne();

                if ($entity) {
                    $entity = SomeoneQuery::create()
                        ->filterByEmail($user["email"])
                        ->filterByPassword($user["password"])
                        ->findOne();

                    if ($entity) {
                        $_SESSION["id"] = PersonQuery::create()
                            ->filterByEmail($user["email"])
                            ->select("Person.Id")
                            ->findOne();
                        $_SESSION["email"] = $user["email"];
                        $_SESSION["password"] = $user["password"];
                        $_SESSION["persist"] = $user["persist"] ? true : false;
                    } else {
                        AuthCtrl::destroySession();
                        throw new RestException(401, "Password");
                    }
                } else {
                    AuthCtrl::destroySession();
                    throw new RestException(404, "User");
                }
            } else {
                AuthCtrl::destroySession();
                throw new RestException(400, "No post data");
            }
        }
    }

    /**
     * @url GET /logout
     * @url POST /logout
     */
    public function logout()
    {
        AuthCtrl::destroySession();

        header("Location: /");
        exit();
    }
}
