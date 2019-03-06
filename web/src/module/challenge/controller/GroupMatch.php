<?php

namespace module\challenge\controller;

use module\main\usecase\Route;
use module\main\driver\MustacheEngine;
use module\main\controller\PrivateLayer;
use module\challenge\entity\Challenge_Group_GroupId_Match;

class GroupMatch implements PrivateLayer
{

    private $route = null;

    public function __construct(Route $route)
    {
        $this->route = $route;
        return $this;
    }

    public function display()
    {
        $groupid = $this->route->getter('2');
        echo (new MustacheEngine())->render("groupmatches", array(
            'matches' => (new Challenge_Group_GroupId_Match())->get($groupid)
        ));
    }

}
