<?php

namespace module\home\controller;

use module\main\usecase\Route;
use module\main\driver\MustacheEngine;
use module\main\controller\PublicLayer;

class SignIn implements PublicLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        echo (new MustacheEngine())->render("signin");
    }

}
