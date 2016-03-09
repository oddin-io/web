<?php
namespace BossEdu\Controller;

use BossEdu\Model\PersonQuery;
use BossEdu\Model\SomeoneQuery;
use BossEdu\Util\Util;
use Jacwright\RestServer\RestException;
use Jasny\SSO\Broker;

class AuthCtrl
{
    public static function check()
    {
        if (!isset($_SESSION)) session_start();

        if (isset($_SESSION["email"])) {
            $user = SomeoneQuery::create()
                ->filterByEmail($_SESSION["email"])
                ->filterByPassword($_SESSION["password"])
                ->findOne();

            if ($user) {
                return true;
            }
        }
    }

    private function attach() {
        $broker = new Broker("http://auth.localhost", "Greg", "7pypoox2pc");
        $broker->attach(true);

        return $broker;
    }

    /**
     * @url POST /login
     */
    public function login()
    {
        $broker = $this->attach();
        $user = Util::getPostContents("lower");

        try {
            $broker->login($user['username'], $user['password']);
        } catch (Exception $ex) {
            throw new RestException(401, "Unauthorized");
        }
    }

    /**
     * @url GET /logout
     * @url POST /logout
     */
    public function logout()
    {
        $broker = $this->attach();

        $broker->logout();
    }

    /**
     * @noAuth
     * @url GET /test
     */
    public function getTest()
    {
        $broker = $this->attach();

        $user = $broker->getUserInfo();

        echo json_encode($user, JSON_PRETTY_PRINT);
    }

    /**
     * @noAuth
     * @url POST /test
     */
    public function postTest()
    {
        echo json_encode($_FILES);
        echo json_encode($_POST);
    }
}
