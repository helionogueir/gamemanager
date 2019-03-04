<?php

namespace module\main\usecase;

use Exception;
use module\main\UseCase;
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
        try {
            (new SetPathGlobal())->set('dirroot', $dirroot)
                    ->set('cache', $dirroot . DIRECTORY_SEPARATOR . 'cache')
                    ->set('main', $dirroot . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . 'main');
            (new FactoryConfigGlobal())->factory();
            $params = $this->prepareParams($request);
            list($module, $action) = $params;
            unset($params[0], $params[1]);
            (new FactoryAction())->render($module, $action, array_values($params));
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function prepareParams(array $request): array
    {
        global $CFG;
        $params = array($CFG->environment->default, 'init');
        if (!empty($request['q'])) {
            foreach (explode('/', $request['q']) as $key => $value) {
                $params[$key] = $value;
            }
        }
        return $params;
    }

}
