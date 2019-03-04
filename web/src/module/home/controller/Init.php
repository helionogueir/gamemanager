<?php

namespace module\home\controller;

use module\main\driver\MustacheEngine;
use module\main\controller\PublicLayer;

class Init implements PublicLayer
{

    public function __construct(array $params)
    {
        return $this;
    }

    public function render()
    {
        echo (new MustacheEngine())->render("login");
    }

}
