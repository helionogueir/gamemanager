<?php

namespace module\main\usecase;

use module\main\UseCase;
use module\main\usecase\Route;
use module\main\usecase\FactoryAction;
use module\main\usecase\SetPathGlobal;
use module\main\usecase\FactoryConfigGlobal;

class RenderRequest implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function render(string $dirroot, array $request)
    {
        $route = empty($request['q']) ? '' : $request['q'];
        (new SetPathGlobal())->set('dirroot', $dirroot)
                ->set('cache', $dirroot . DIRECTORY_SEPARATOR . 'cache')
                ->set('main', $dirroot . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . 'main');
        (new FactoryConfigGlobal())->factory();
        (new FactoryAction())->render((new Route($route)));
    }

}
