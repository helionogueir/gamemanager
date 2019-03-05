<?php

namespace module\event\controller;

use module\event\usecase\SeekEvent;
use module\main\driver\UserSession;
use module\main\driver\GetterMapping;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;

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
                'event' => (new SeekEvent())->seek($this->getter['eventid'], $user->personid)
            ));
        }
    }

}
