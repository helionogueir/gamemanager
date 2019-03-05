<?php

namespace module\main\usecase;

use module\main\Usecase;
use module\main\Controller;
use module\main\usecase\Route;
use module\main\driver\UserSession;
use module\main\usecase\HttpPage;
use module\main\usecase\SetPathGlobal;
use module\main\controller\PrivateLayer;

class FactoryAction implements Usecase
{

    public function __construct()
    {
        return $this;
    }

    public function render(Route $route)
    {
        global $PATH;
        $controllerName = $route->getControllername();
        if (class_exists($controllerName)) {
            $controllerObject = new $controllerName($route);
            if ($controllerObject instanceof Controller) {
                (new SetPathGlobal())->set('module', $PATH->dirroot
                        . DIRECTORY_SEPARATOR . 'module'
                        . DIRECTORY_SEPARATOR . $route->getModulename());
                if ($controllerObject instanceof PrivateLayer) {
                    if (!(new UserSession())->get()) {
                        (new HttpPage())->display(404);
                        return;
                    }
                }
                $controllerObject->display();
                return;
            }
        }
        (new HttpPage())->display(404);
    }

}
