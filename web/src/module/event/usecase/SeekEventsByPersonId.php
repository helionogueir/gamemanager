<?php

namespace module\event\usecase;

use module\main\UseCase;
use module\event\entity\Event_Person_PersonId;

class SeekEventsByPersonId implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function seek(int $personid): array
    {
        $data = array();
        if ($rowSet = (new Event_Person_PersonId())->get($personid)) {
            $data = $rowSet;
        }
        return $data;
    }

}
