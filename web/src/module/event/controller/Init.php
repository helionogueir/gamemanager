<?php

namespace module\event\controller;

use module\main\driver\UserSession;
use module\event\usecase\SeekEvents;
use module\main\driver\MustacheEngine;
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
                'events' => (new SeekEvents())->seek($user->personid)
            ));
        }
    }

}
