<?php

namespace module\event\usecase;

use module\main\UseCase;
use module\event\entity\Match_Group_Event_EvenId_Person_PersonId;

class SeekGroupsByEventIdAndPersonId implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function seek(int $eventid, int $personid): array
    {
        $data = array();
        if ($rowSet = (new Match_Group_Event_EvenId_Person_PersonId())->get($eventid, $personid)) {
            $data = $rowSet;
        }
        return $data;
    }

}
