<?php
namespace BossEdu\Controller;

use BossEdu\Model\PiLinkQuery;
use BossEdu\Model\PresentationQuery;

define("__VIEWFOLDER__", __DIR__."/../view/pages");

class FrontEndCtrl
{
    public function authorize()
    {
        return AuthCtrl::check();
    }

    /**
     * @noAuth
     * @url GET /recover-password
     */
    public function recoverPassword()
    {
        echo file_get_contents(__VIEWFOLDER__."/recuperar_senha.html");
    }

    /**
     * @url GET /instruction
     */
    public function lectures()
    {
        echo file_get_contents(__VIEWFOLDER__."/palestras.html");
    }

    /**
     * @url GET /instruction/$instruction_id/material
     */
    public function material($instruction_id)
    {
        $instruction_id = urldecode($instruction_id);

        $person = $_SESSION["id"];

        $profile = $this->getProfile($instruction_id, $person);

        if ($profile >= 2) {
            echo file_get_contents(__VIEWFOLDER__."/material-p.html");
            return;
        }

        echo file_get_contents(__VIEWFOLDER__."/material-o.html");
    }

    /**
     * @url GET /instruction/$instruction_id/participants
     */
    public function participants($instruction_id)
    {
        echo file_get_contents(__VIEWFOLDER__."/participantes.html");
    }

    public function getProfile($instruction_id, $person)
    {
        return (int) PiLinkQuery::create()
            ->filterByInstructionId($instruction_id)
            ->filterByPersonId($person)
            ->select("PiLink.Profile")
            ->findOne();
    }

    /**
     * @url GET /instruction/$instruction_id/historic
     */
    public function historic($instruction_id)
    {
        $instruction_id = urldecode($instruction_id);
        $person = $_SESSION["id"];

        $profile = $this->getProfile($instruction_id, $person);

        if ($profile >= 2) {
            echo file_get_contents(__VIEWFOLDER__."/historico-p.html");
            return;
        }

        echo file_get_contents(__VIEWFOLDER__."/historico-o.html");
    }

    /**
     * @url GET /instruction/$instruction_id/presentation/current
     */
    public function currentPresentation($instruction_id)
    {
        $instruction_id = urldecode($instruction_id);

        $presentation_id = PresentationQuery::create()
            ->filterByInstructionId($instruction_id)
            ->select("Id")
            ->findOne();

        if ($presentation_id) {
            $url = "/app/{$instruction_id}/presentation/{$presentation_id}";
            header("Location: {$url}");
        } else {
            $url = "/app/{$instruction_id}/historic";
            header("Location: {$url}");
        }
    }

    /**
     * @url GET /instruction/$instruction_id/presentation/$id
     */
    public function presentation($instruction_id, $id)
    {
        $instruction_id = urldecode($instruction_id);

        $profile = $this->getProfile($instruction_id, $_SESSION["id"]);

        if ($profile >= 2) {
            echo file_get_contents(__VIEWFOLDER__."/apresentacao-p-slick_carousel.html");
            return;
        }

        echo file_get_contents(__VIEWFOLDER__."/apresentacao-o.html");
    }
}
