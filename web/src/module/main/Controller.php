<?php

namespace module\main;

use module\main\usecase\Route;

interface Controller
{

    public function __construct(Route $route);

    public function display();
}
