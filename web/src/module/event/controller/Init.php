<?php

namespace module\event\controller;

use module\main\driver\UserSession;
use module\main\driver\MustacheEngine;
use module\event\usecase\SeekAllEvents;
use module\main\controller\PrivateLayer;

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
                'events' => (new SeekAllEvents())->seek($user->personid)
            ));
        }
    }

}
