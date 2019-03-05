<?php

namespace module\challenge\controller;

use module\main\usecase\Route;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\challenge\entity\Challenge_Groups;

class Groups implements PrivateLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        echo (new MustacheEngine())->render("groups", array(
            'groups' => (new Challenge_Groups())->get()
        ));
    }

}
