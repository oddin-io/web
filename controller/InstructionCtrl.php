<?php
namespace BossEdu\Controller;

use BossEdu\Model\InstructionQuery;
use BossEdu\Model\PersonQuery;
use BossEdu\Model\PiLinkQuery;
use BossEdu\Model\PresentationQuery;
use BossEdu\Util\Util;
use Jacwright\RestServer\RestException;

class InstructionCtrl
{
    public function authorize()
    {
        return AuthCtrl::check();
    }

    public static function setCurrentInstruction($instruction_id, $person)
    {
        PersonQuery::create()
            ->filterById($person)
            ->update(["CurrentInstruction" => $instruction_id]);
    }

    public static function getInstructionId($event, $lecture, $start_date, $class)
    {
        return (int) InstructionQuery::create()
            ->filterByEventCode($event)
            ->filterByLectureCode($lecture)
            ->filterByStartDate($start_date)
            ->filterByClass($class)
            ->select("Id")
            ->findOne();
    }

    public static function resetCurrentInstruction($person)
    {
        PersonQuery::create()
            ->filterById($person)
            ->update(["CurrentInstruction" => null]);
    }
}
