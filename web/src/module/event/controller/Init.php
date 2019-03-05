<?php

namespace module\event\controller;

use module\main\driver\UserSession;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\event\usecase\SeekEventsByPersonId;

class Init implements PrivateLayer
{

    public function __construct(array $params)
    {
        return $this;
    }

    public function render()
    {
        if ($user = (new UserSession())->get()) {
            echo (new MustacheEngine())->render("events", array(
                'events' => (new SeekEventsByPersonId())->seek($user->personid)
            ));
        }
    }

}
