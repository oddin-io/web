<?php
namespace BossEdu\Controller;

use BombArea\SSO\Client;
use BombArea\SSO\LoggedClient;
use BossEdu\Model\PersonQuery;
use BossEdu\Util\Util;
use Jacwright\RestServer\RestException;

class AuthCtrl
{
    /**
     * @url POST /login
     */
    public function login()
    {
        $postData = Util::getPostContents("lower");
        $postData["persist"] = $postData["persist"] ?? false;

        try {
            $loggedClient = self::getClient()->login($postData["email"], $postData["password"]);
            self::setCookie($loggedClient->getSessionToken(), $postData["persist"]);

            $personId = PersonQuery::create()
                ->findOneByEmail($postData["email"])
                ->getId();

            $loggedClient->setSessionData([
                "id" => $personId,
                "persist" => $postData["persist"]
            ]);
        } catch (\Exception $ex) {
            throw new RestException(401, $ex->getMessage());
        }
    }

    /**
     * @url GET /logout
     * @url POST /logout
     */
    public function logout()
    {
        $loggedClient = new LoggedClient(self::getClient(), $_COOKIE[self::getCookieName()]);

        try {
            $loggedClient->logout();
            self::deleteCookie();

            header("Location: /");
            exit();
        } catch (\Exception $ex) {
            throw new RestException(401, $ex->getMessage());
        }
    }

    public static function getSession()
    {
        $loggedUser = self::buildLoggedClient();
        return $loggedUser->getSessionData();
    }

    public static function setSession($values)
    {
        $loggedUser = self::buildLoggedClient();
        return $loggedUser->setSessionData($values);
    }

    public static function check()
    {
        if (!isset($_COOKIE[self::getCookieName()])) return false;

        return true;
    }

    public static function getClient()
    {
        return new Client(getenv("AUTH_URL"), "client", "asd123");
    }

    private static function buildLoggedClient()
    {
        if(!self::check()) throw new \Exception("You aren't logged");

        return new LoggedClient(self::getClient(), $_COOKIE[self::getCookieName()]);
    }

    private static function setCookie($value, $persist = false)
    {
        $ttl = 0;

        if ($persist) $ttl = time() + 3600 * 24 * 60;

        setcookie(self::getCookieName(), $value, $ttl, "/");
    }

    private static function deleteCookie()
    {
        setcookie(self::getCookieName(), "", -3600, "/");
    }

    private static function renewCookie()
    {
        setcookie(self::getCookieName(), $_COOKIE[self::getCookieName()], time() + 3600 * 24 * 60, "/");
    }

    private static function getCookieName()
    {
        return "sso_client_token";
    }
}
