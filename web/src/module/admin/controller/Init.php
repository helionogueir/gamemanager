<?php

namespace module\admin\controller;

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
        echo (new MustacheEngine())->render("dashboard");
    }

}
