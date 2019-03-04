<?php

namespace module\event\usecase;

use module\main\entity\event\Person;
use module\main\UseCase;

class SeekEvents implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function seek(int $personid): array
    {
        $data = array();
        if ($rowSet = (new Person())->get($personid)) {
            $data = $rowSet;
        }
        return $data;
    }

}
