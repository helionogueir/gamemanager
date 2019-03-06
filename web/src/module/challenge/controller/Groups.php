<?php

namespace module\challenge\controller;

use module\main\usecase\Route;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\challenge\usecase\PrepareState;
use module\challenge\entity\Challenge_Group_State;

class Groups implements PrivateLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        $stage = new PrepareState();
        echo (new MustacheEngine())->render("groups", array(
            'stages' => array(
                $stage->prepare('cc', (new Challenge_Group_State())->get('cc')),
                $stage->prepare('po', (new Challenge_Group_State())->get('po')),
                $stage->prepare('f8', (new Challenge_Group_State())->get('f8')),
                $stage->prepare('f4', (new Challenge_Group_State())->get('f4')),
                $stage->prepare('fs', (new Challenge_Group_State())->get('fs')),
                $stage->prepare('ff', (new Challenge_Group_State())->get('ff'))
            )
        ));
    }

}
