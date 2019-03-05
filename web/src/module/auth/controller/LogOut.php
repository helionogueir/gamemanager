<?php

namespace module\auth\controller;

use module\main\usecase\Route;
use module\main\driver\UserSession;
use module\main\controller\PublicLayer;

class LogOut implements PublicLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        (new UserSession())->destroy();
        header('location:/');
    }

}
