<?php

namespace module\challenge\controller;

use module\main\usecase\Route;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\challenge\usecase\PrepareState;
use module\challenge\entity\Challenge_Groups;

class Groups implements PrivateLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        $prepare = new PrepareState();
        echo (new MustacheEngine())->render("groups", array(
            'stages' => array(
                $prepare->prepare('group', (new Challenge_Groups())->get())
            )
        ));
    }

}
