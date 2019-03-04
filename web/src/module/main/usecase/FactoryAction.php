<?php

namespace module\main\usecase;

use Exception;
use module\main\Usecase;
use module\main\Controller;
use module\main\driver\UserSession;
use module\main\usecase\SetPathGlobal;
use module\main\controller\PrivateLayer;

class FactoryAction implements Usecase
{

    public function __construct()
    {
        return $this;
    }

    public function render(string $module, string $action, array $params)
    {
        global $PATH;
        try {
            $actionName = ucfirst($action);
            $controllerName = "\\module\\{$module}\\controller\\{$actionName}";
            if (class_exists($controllerName)) {
                $controllerObject = new $controllerName($params);
                if ($controllerObject instanceof Controller) {
                    (new SetPathGlobal())->set('module', $PATH->dirroot
                            . DIRECTORY_SEPARATOR . 'module'
                            . DIRECTORY_SEPARATOR . $module);
                    if ($controllerObject instanceof PrivateLayer) {
                        if (!(new UserSession())->get()) {
                            (new FactoryAction())->render('main', 'httpPage', array(404));
                            return;
                        }
                    }
                    $controllerObject->render();
                    return;
                }
            }
            (new FactoryAction())->render('main', 'httpPage', array(404));
            return;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}
