<?php

namespace module\event\usecase;

use module\main\UseCase;
use module\event\entity\Event_EvenId_Person_PersonId;

class SeekEventByEventIdAndPersonId implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function seek(int $eventid, int $personid)
    {
        $data = null;
        if ($row = (new Event_EvenId_Person_PersonId())->get($eventid, $personid)) {
            $data = $row;
        }
        return (array) $data;
    }

}
