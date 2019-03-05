<?php

namespace module\event\controller;

use module\main\driver\UserSession;
use module\main\driver\GetterMapping;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\event\usecase\SeekEventByEventIdAndPersonId;
use module\event\usecase\SeekGroupsByEventIdAndPersonId;

class View implements PrivateLayer
{

    private $getter = null;

    public function __construct(array $params)
    {
        $this->getter = (new GetterMapping())->map(array('eventid'), $params);
        return $this;
    }

    public function render()
    {
        if ($user = (new UserSession())->get()) {
            echo (new MustacheEngine())->render("view", array(
                'event' => (new SeekEventByEventIdAndPersonId())
                        ->seek($this->getter['eventid'], $user->personid),
                'groups' => (new SeekGroupsByEventIdAndPersonId())
                        ->seek($this->getter['eventid'], $user->personid)
            ));
        }
    }

}
